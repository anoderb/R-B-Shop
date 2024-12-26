<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProdukModel;
use App\Models\ProdukKategoriModel;
use App\Controllers\Admin\MetadataController;
use App\Models\SupplierModel;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use TCPDF;

//work
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
        } else {
            $this->produkModel->search('');
        }

        // Modifikasi query untuk mengambil data supplier dan kategori
        $produk = $this->produkModel
            ->select('produk.*, supplier.nama_suppl, produk_kategori.nama_kategori')
            ->join('supplier', 'supplier.id_suppl = produk.id_suppl', 'left')
            ->join('produk_kategori', 'produk_kategori.Kategori_id = produk.Kategori_id', 'left')
            ->paginate($perPage);

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
        $kategori = $kategoriModel->findAll();
        $supplierModel = new SupplierModel();
        $supplier = $supplierModel->findAll();


        return view('admin/tambah_produk', [
            'kategori' => $kategori,
            'supplier' => $supplier // Pastikan nama variabel sesuai
        ]);
    }

    public function save()
    {
        // Debug untuk melihat semua data yang diterima
        $allFiles = $this->request->getFiles();
        $allPost = $this->request->getPost();

        log_message('debug', 'All Files: ' . print_r($allFiles, true));
        log_message('debug', 'All Post: ' . print_r($allPost, true));

        // Proses produk
        $fileGambar = $this->request->getFile('gambar');
        if ($fileGambar->isValid() && !$fileGambar->hasMoved()) {
            $fileGambar->move(FCPATH . 'uploads/produk');
            $gambarName = $fileGambar->getName();
        } else {
            $gambarName = '';
            log_message('error', 'Error uploading main product image: ' . print_r($fileGambar->getError(), true));
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
            'stok' => $this->request->getPost('stok'), // Tambahkan stok
        ];


        $produkId = $this->produkModel->insert($produkData);

        // Proses metadata
        $metadata = $this->request->getPost('metadata');

        if ($metadata) {
            try {
                $metadataController = new MetadataController();
                $metadataController->save($produkId, $metadata, $allFiles);
            } catch (\Exception $e) {
                log_message('error', 'Error saving metadata: ' . $e->getMessage());
                return redirect()->to('/admin/produk')->with('error', 'Error saving metadata: ' . $e->getMessage());
            }
        }

        return redirect()->to('/admin/produk')->with('success', 'Produk dan metadata berhasil ditambahkan!');
    }


    public function edit($id)
    {
        $produk = $this->produkModel->find($id);
        if (!$produk) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Produk tidak ditemukan');
        }

        $kategoriModel = new ProdukKategoriModel();
        $kategori = $kategoriModel->findAll();

        // Get metadata for this product
        $metadataModel = new \App\Models\MetadataModel();
        $metadata = $metadataModel->where('Produk_id', $id)->findAll();

        return view('admin/edit_produk', [
            'produk' => $produk,
            'kategori' => $kategori,
            'metadata' => $metadata
        ]);
    }
    public function update($id)
    {
        if (!$this->validate([
            'Kode_produk' => 'required',
            'nama_produk' => 'required',
            'Kategori_id' => 'required',
            'id_suppl' => 'required',
            'harga' => 'required|numeric',
            'Berat' => 'required|numeric',
            'stok' => 'required|numeric',
            'gambar' => 'uploaded[gambar]|is_image[gambar]|max_size[gambar,1024]'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Handle main product image
        $fileGambar = $this->request->getFile('gambar');
        if ($fileGambar && $fileGambar->isValid() && !$fileGambar->hasMoved()) {
            $fileGambar->move('uploads/produk');
            $gambarName = $fileGambar->getName();
        } else {
            $gambarName = $this->request->getPost('old_gambar');
        }

        // Update product data
        $data = [
            'Kode_produk' => $this->request->getPost('Kode_produk'),
            'nama_produk' => $this->request->getPost('nama_produk'),
            'Kategori_id' => $this->request->getPost('Kategori_id'),
            'harga' => $this->request->getPost('harga'),
            'Berat' => $this->request->getPost('Berat'),
            'Deskripsi' => $this->request->getPost('Deskripsi'),
            'gambar' => $gambarName,
            'stok' => $this->request->getPost('stok'),
            'id_suppl' => $this->request->getPost('id_suppl'), // Tambahkan stok
        ];


        $this->db->transStart();

        try {
            // Update product
            $this->produkModel->update($id, $data);

            // Handle metadata updates
            $metadata = $this->request->getPost('metadata');
            $metadataModel = new \App\Models\MetadataModel();

            if ($metadata) {
                foreach ($metadata as $index => $meta) {
                    $metadataData = [
                        'Warna' => $meta['Warna'],
                        'Ukuran' => $meta['Ukuran'],
                        'Stok' => $meta['Stok'],
                        'Harga' => $meta['Harga']
                    ];

                    // Handle metadata image
                    $metaFile = $this->request->getFile('meta_gambar_' . $index);
                    if ($metaFile && $metaFile->isValid() && !$metaFile->hasMoved()) {
                        $metaFile->move('uploads/metadata');
                        $metadataData['meta_gambar'] = $metaFile->getName();
                    } elseif (isset($meta['old_meta_gambar'])) {
                        $metadataData['meta_gambar'] = $meta['old_meta_gambar'];
                    }

                    if (isset($meta['Metadata_id'])) {
                        // Update existing metadata
                        $metadataModel->update($meta['Metadata_id'], $metadataData);
                    } else {
                        // Add new metadata
                        $metadataData['Produk_id'] = $id;
                        $metadataModel->insert($metadataData);
                    }
                }
            }

            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                return redirect()->back()->withInput()->with('error', 'Gagal memperbarui produk dan metadata.');
            }

            return redirect()->to('/admin/produk')->with('success', 'Produk dan metadata berhasil diperbarui!');
        } catch (\Exception $e) {
            $this->db->transRollback();
            log_message('error', 'Error updating product and metadata: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui produk dan metadata.');
        }
    }
    public function detail($id)
    {
        // Ambil data produk berdasarkan ID
        $produk = $this->produkModel->find($id);

        // Jika data produk tidak ditemukan
        if (!$produk) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Produk dengan ID $id tidak ditemukan.");
        }

        // Load Metadata
        $metadataModel = new \App\Models\MetadataModel();
        $metadata = $metadataModel->where('Produk_id', $id)->findAll();

        // Kirim data produk dan metadata ke view
        return view('admin/detail_produk', [
            'produk' => $produk,
            'metadata' => $metadata
        ]);
    }

    public function delete($id)
    {
        if ($this->produkModel->delete($id)) {
            return redirect()->to('/admin/produk')->with('success', 'Produk berhasil dihapus!');
        }

        return redirect()->back()->with('error', 'Gagal menghapus produk.');
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
