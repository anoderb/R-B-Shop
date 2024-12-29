<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProdukModel;
use App\Models\ProdukKategoriModel;
use App\Controllers\Admin\MetadataController;
use App\Models\SupplierModel;
use App\Models\MetadataModel;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use TCPDF;

class ProdukController extends BaseController
{
    protected $produkModel;
    protected $db;

    public function __construct()
    {
        $this->produkModel = new ProdukModel();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $perPage = 5;
        $currentPage = $this->request->getVar('page') ?? 1;
        $keyword = $this->request->getVar('keyword');

        if ($keyword) {
            $this->produkModel->search($keyword);
        }

        $produk = $this->produkModel->getProdukWithRelations($perPage);
        $pager = $this->produkModel->pager;

        return view('admin/produk', [
            'produk' => $produk,
            'pager' => $pager,
            'currentPage' => $currentPage,
            'keyword' => $keyword,
        ]);
    }

    public function tambah()
    {
        $kategoriModel = new ProdukKategoriModel();
        $supplierModel = new SupplierModel();

        return view('admin/tambah_produk', [
            'kategori' => $kategoriModel->findAll(),
            'supplier' => $supplierModel->findAll(),
            'metadata' => [] // Add empty metadata array for new products
        ]);
    }

    public function save()
    {
        $fileGambar = $this->request->getFile('gambar');
        $gambarName = '';
        
        if ($fileGambar->isValid() && !$fileGambar->hasMoved()) {
            $fileGambar->move(FCPATH . 'uploads/produk');
            $gambarName = $fileGambar->getName();
        }

        $produkData = [
            'Kode_produk' => $this->request->getPost('Kode_produk'),
            'nama_produk' => $this->request->getPost('nama_produk'),
            'Kategori_id' => $this->request->getPost('Kategori_id'),
            'harga' => $this->request->getPost('harga'),
            'Berat' => $this->request->getPost('Berat'),
            'Deskripsi' => $this->request->getPost('Deskripsi'),
            'gambar' => $gambarName,
            'id_suppl' => $this->request->getPost('id_suppl'),
            'stok' => $this->request->getPost('stok'),
        ];

        $produkId = $this->produkModel->createProduk($produkData);

        if ($metadata = $this->request->getPost('metadata')) {
            $metadataController = new MetadataController();
            $metadataController->save($produkId, $metadata, $this->request->getFiles());
        }

        return redirect()->to('/admin/produk')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $result = $this->produkModel->getProdukWithMetadata($id);
        if (!$result) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $kategoriModel = new ProdukKategoriModel();
        $supplierModel = new SupplierModel();

        return view('admin/edit_produk', [
            'produk' => $result['produk'],
            'metadata' => $result['metadata'],
            'kategori' => $kategoriModel->findAll(),
            'supplier' => $supplierModel->findAll()
        ]);
    }

    public function detail($id)
    {
        $result = $this->produkModel->getProdukWithMetadata($id);
        if (!$result) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('admin/detail_produk', [
            'produk' => $result['produk'],
            'metadata' => $result['metadata']
        ]);
    }
    public function update($id)
    {
        // Start database transaction
        $this->db->transStart();

        try {
            // Handle product image
            $fileGambar = $this->request->getFile('gambar');
            $gambarName = $this->request->getPost('old_gambar');

            if ($fileGambar && $fileGambar->isValid() && !$fileGambar->hasMoved()) {
                $fileGambar->move(FCPATH . 'uploads/produk');
                $gambarName = $fileGambar->getName();

                // Delete old image if exists
                $oldImage = $this->request->getPost('old_gambar');
                if ($oldImage && file_exists(FCPATH . 'uploads/produk/' . $oldImage)) {
                    unlink(FCPATH . 'uploads/produk/' . $oldImage);
                }
            }

            // Prepare product data
            $produkData = [
                'Kode_produk' => $this->request->getPost('Kode_produk'),
                'nama_produk' => $this->request->getPost('nama_produk'),
                'Kategori_id' => $this->request->getPost('Kategori_id'),
                'harga' => $this->request->getPost('harga'),
                'Berat' => $this->request->getPost('Berat'),
                'Deskripsi' => $this->request->getPost('Deskripsi'),
                'gambar' => $gambarName,
                'stok' => $this->request->getPost('stok'),
                'id_suppl' => $this->request->getPost('id_suppl'),
            ];

            // Update product
            $this->produkModel->update($id, $produkData);

            // Handle metadata updates
            $metadata = $this->request->getPost('metadata');
            if ($metadata) {
                $metadataController = new MetadataController();
                $allFiles = $this->request->getFiles();
                $metadataController->save($id, $metadata, $allFiles);
            }

            // Complete transaction
            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                // An error occurred
                return redirect()->back()
                    ->with('error', 'Terjadi kesalahan saat memperbarui produk.')
                    ->withInput();
            }

            return redirect()->to('/admin/produk')
                ->with('success', 'Produk berhasil diperbarui!');

        } catch (\Exception $e) {
            // Roll back transaction on error
            $this->db->transRollback();
            log_message('error', 'Error updating product: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }


    public function delete($id)
    {
        if ($this->produkModel->deleteProduk($id)) {
            return redirect()->to('/admin/produk')
                ->with('success', 'Produk berhasil dihapus!');
        }
        return redirect()->back()
            ->with('error', 'Gagal menghapus produk.');
    }

    // pagenation
    //EXPORT
    private function getProdukData()
    {
        // Fungsi helper untuk mendapatkan data produk lengkap
        return $this->produkModel
            ->select('produk.*, supplier.nama_suppl, produk_kategori.nama_kategori')
            ->join('supplier', 'supplier.id_suppl = produk.id_suppl', 'left')
            ->join('produk_kategori', 'produk_kategori.Kategori_id = produk.Kategori_id', 'left')
            ->findAll();
    }

    public function exportExcel()
    {
        $produkData = $this->getProdukData();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header kolom
        $sheet->setCellValue('A1', 'Kode Produk');
        $sheet->setCellValue('B1', 'Nama Produk');
        $sheet->setCellValue('C1', 'Supplier');
        $sheet->setCellValue('D1', 'Kategori');
        $sheet->setCellValue('E1', 'Harga');
        $sheet->setCellValue('F1', 'Stok');
        $sheet->setCellValue('G1', 'Berat');

        // Isi data
        $row = 2;
        foreach ($produkData as $produk) {
            $sheet->setCellValue('A' . $row, $produk['Kode_produk']);
            $sheet->setCellValue('B' . $row, $produk['nama_produk']);
            $sheet->setCellValue('C' . $row, $produk['nama_suppl']);
            $sheet->setCellValue('D' . $row, $produk['nama_kategori']);
            $sheet->setCellValue('E' . $row, $produk['harga']);
            $sheet->setCellValue('F' . $row, $produk['stok']);
            $sheet->setCellValue('G' . $row, $produk['Berat']);
            $row++;
        }

        // Styling
        foreach (range('A', 'G') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Produk_Export.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit();
    }

    public function exportCSV()
    {
        $produkData = $this->getProdukData();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header dan data sama seperti Excel
        // ... (gunakan kode yang sama seperti di exportExcel)

        $writer = new Csv($spreadsheet);
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename="Produk_Export.csv"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit();
    }

    public function exportPDF()
    {
        $produkData = $this->getProdukData();

        // Create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('R&B SHOP');
        $pdf->SetTitle('Daftar Produk');

        // Set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'Daftar Produk', '');

        // Set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // Add a page
        $pdf->AddPage();

        // Create the table content
        $html = '<table border="1" cellpadding="4">
                    <tr>
                        <th>Kode Produk</th>
                        <th>Nama Produk</th>
                        <th>Supplier</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Berat</th>
                    </tr>';

        foreach ($produkData as $produk) {
            $html .= '<tr>
                        <td>' . $produk['Kode_produk'] . '</td>
                        <td>' . $produk['nama_produk'] . '</td>
                        <td>' . $produk['nama_suppl'] . '</td>
                        <td>' . $produk['nama_kategori'] . '</td>
                        <td>Rp ' . number_format($produk['harga'], 0, ',', '.') . '</td>
                        <td>' . $produk['stok'] . '</td>
                        <td>' . $produk['Berat'] . ' gram</td>
                    </tr>';
        }
        $html .= '</table>';

        // Print the table
        $pdf->writeHTML($html, true, false, true, false, '');

        // Close and output PDF document
        $pdf->Output('Produk_Export.pdf', 'D');
        exit();
    }
}
