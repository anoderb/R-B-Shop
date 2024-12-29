<?php

namespace App\Controllers\Admin;

use App\Models\TransaksiModel;
use CodeIgniter\Controller;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use TCPDF;

class TransaksiController extends Controller
{
    protected $transaksiModel;

    public function __construct()
    {
        $this->transaksiModel = new TransaksiModel();
    }

    public function index()
    {
        helper('number');

        $perPage = 5;
        $currentPage = $this->request->getVar('page') ?? 1;
        $keyword = $this->request->getVar('keyword');

        $builder = $this->transaksiModel->select('Pembelian.*, Users.username, Kurir.nama_kurir, Kurir.ongkos_kirim, (Pembelian.grand_total - Kurir.ongkos_kirim) AS nilai_total')
            ->join('Users', 'Users.id = Pembelian.user_id', 'left')
            ->join('Kurir', 'Kurir.kurir_id = Pembelian.kurir_id', 'left');

        if ($keyword) {
            $builder->groupStart()
                ->like('Pembelian.Pembelian_id', $keyword)
                ->orLike('Users.username', $keyword)
                ->orLike('Pembelian.status', $keyword)
                ->orLike('Kurir.nama_kurir', $keyword)
                ->groupEnd();
        }

        $data = [
            'transaksi' => $builder->paginate($perPage),
            'pager' => $builder->pager,
            'currentPage' => $currentPage,
            'keyword' => $keyword
        ];

        return view('admin/transaksi', $data);
    }

    private function getTransaksiData()
    {
        return $this->transaksiModel->getTransaksi();
    }

    public function exportExcel()
    {
        $transaksiData = $this->getTransaksiData();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $sheet->setCellValue('A1', 'ID Pembelian');
        $sheet->setCellValue('B1', 'Tanggal');
        $sheet->setCellValue('C1', 'Nama Pengguna');
        $sheet->setCellValue('D1', 'Status');
        $sheet->setCellValue('E1', 'Kurir');
        $sheet->setCellValue('F1', 'Ongkos Kirim');
        $sheet->setCellValue('G1', 'Transaction ID');
        $sheet->setCellValue('H1', 'Grand Total');

        // Data
        $row = 2;
        foreach ($transaksiData as $transaksi) {
            $sheet->setCellValue('A' . $row, $transaksi['Pembelian_id']);
            $sheet->setCellValue('B' . $row, $transaksi['tanggal']);
            $sheet->setCellValue('C' . $row, $transaksi['username']);
            $sheet->setCellValue('D' . $row, $transaksi['status']);
            $sheet->setCellValue('E' . $row, $transaksi['nama_kurir']);
            $sheet->setCellValue('F' . $row, $transaksi['ongkos_kirim']);
            $sheet->setCellValue('G' . $row, $transaksi['transaction_id']);
            $sheet->setCellValue('H' . $row, $transaksi['grand_total']);
            $row++;
        }

        // Auto-size columns
        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Transaksi_Export.xlsx"');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }
    public function exportPDF()
    {
        $transaksiData = $this->getTransaksiData();

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('R&B SHOP');
        $pdf->SetTitle('Daftar Transaksi');
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'Daftar Transaksi', '');
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->AddPage();

        $html = '<table border="1" cellpadding="4">
            <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Pengguna</th>
                <th>Status</th>
                <th>Kurir</th>
                <th>Total</th>
            </tr>';

        foreach ($transaksiData as $transaksi) {
            $html .= '<tr>
                <td>' . $transaksi['Pembelian_id'] . '</td>
                <td>' . $transaksi['tanggal'] . '</td>
                <td>' . $transaksi['username'] . '</td>
                <td>' . $transaksi['status'] . '</td>
                <td>' . $transaksi['nama_kurir'] . '</td>
                <td>Rp ' . number_format($transaksi['grand_total'], 0, ',', '.') . '</td>
            </tr>';
        }
        $html .= '</table>';

        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('Transaksi_Export.pdf', 'D');
        exit();
    }
    public function detail($id)
    {
        $transaksiModel = new TransaksiModel();
        $transaksi = $transaksiModel->getTransaksiById($id);

        $db = \Config\Database::connect();
        $detail_produk = $db->table('Pembelian_detail')
            ->select('Pembelian_detail.*, produk.nama_produk, produk.harga, Pembelian_detail.qty')
            ->join('produk', 'produk.Produk_id = Pembelian_detail.Produk_id')
            ->where('Pembelian_id', $id)
            ->get()
            ->getResultArray();


        return view('admin/transaksi_detail', [
            'transaksi' => $transaksi,
            'detail_produk' => $detail_produk
        ]);
    }
    public function ship($id)
    {
        // Update status to shipped
        $this->transaksiModel->update($id, ['status' => 'shipped']);

        return redirect()->back()->with('message', 'Order has been marked as shipped.');
    }
}
