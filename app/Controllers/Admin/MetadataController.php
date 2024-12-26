<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MetadataModel;

class MetadataController extends BaseController
{
    protected $metadataModel;


    // Di awal MetadataController constructor
    public function __construct()
    {
        $this->metadataModel = new MetadataModel();

        // Cek dan buat folder jika belum ada
        $uploadPath = FCPATH . 'uploads/metadata/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        // Log permission folder
        log_message('debug', 'Metadata upload folder permissions: ' . substr(sprintf('%o', fileperms($uploadPath)), -4));
    }
    public function save($produkId, $metadata, $allFiles)
    {
        log_message('debug', 'Starting metadata save process');
        log_message('debug', 'Metadata array: ' . print_r($metadata, true));
        log_message('debug', 'All files: ' . print_r($allFiles, true));

        foreach ($metadata as $index => $data) {
            try {
                $fileKey = "meta_gambar_" . $index;
                $metaGambar = null;

                log_message('debug', 'Processing metadata index: ' . $index);
                log_message('debug', 'Looking for file with key: ' . $fileKey);

                if (isset($allFiles[$fileKey])) {
                    $file = $allFiles[$fileKey];
                    log_message('debug', 'Found file: ' . print_r($file, true));

                    if ($file->isValid() && !$file->hasMoved()) {
                        // Tentukan folder upload
                        $uploadPath = FCPATH . 'uploads/metadata/';

                        // Buat folder jika tidak ada
                        if (!is_dir($uploadPath)) {
                            mkdir($uploadPath, 0777, true);
                        }

                        // Generate nama file unik
                        $newName = $file->getRandomName();

                        // Debug permission folder
                        log_message('debug', 'Upload path permissions: ' . substr(sprintf('%o', fileperms($uploadPath)), -4));

                        // Coba pindahkan file
                        if ($file->move($uploadPath, $newName)) {
                            $metaGambar = $newName;
                            log_message('debug', 'File moved successfully: ' . $newName);
                        } else {
                            log_message('error', 'Failed to move file: ' . $file->getErrorString());
                        }
                    } else {
                        log_message('error', 'Invalid file or already moved: ' . $fileKey);
                    }
                }

                // Siapkan data metadata
                $metadataData = [
                    'Produk_id' => $produkId,
                    'Warna' => $data['Warna'],
                    'Ukuran' => $data['Ukuran'],
                    'Stok' => $data['Stok'],
                    'Harga' => $data['Harga'],
                    'meta_gambar' => $metaGambar
                ];

                // Debug data sebelum disimpan
                log_message('debug', 'Saving metadata: ' . print_r($metadataData, true));

                // Simpan ke database
                $saved = $this->metadataModel->save($metadataData);

                if (!$saved) {
                    log_message('error', 'Failed to save metadata to database: ' . print_r($this->metadataModel->errors(), true));
                }
            } catch (\Exception $e) {
                log_message('error', 'Error processing metadata: ' . $e->getMessage());
                throw $e;
            }
        }
    }
    private function isValidImage($file)
    {
        $validTypes = ['image/jpeg', 'image/png', 'image/gif'];
        return in_array($file->getMimeType(), $validTypes);
    }
    public function delete($id)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'Invalid request'
            ]);
        }

        try {
            $metadataModel = new \App\Models\MetadataModel();

            // Ambil data metadata
            $metadata = $metadataModel->find($id);

            if (!$metadata) {
                return $this->response->setStatusCode(404)->setJSON([
                    'success' => false,
                    'message' => 'Metadata tidak ditemukan'
                ]);
            }

            // Hapus file gambar jika ada
            if (!empty($metadata['meta_gambar'])) {
                $imagePath = FCPATH . 'uploads/metadata/' . $metadata['meta_gambar'];
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            // Hapus data dari database
            if ($metadataModel->delete($id)) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Metadata berhasil dihapus'
                ]);
            } else {
                return $this->response->setStatusCode(500)->setJSON([
                    'success' => false,
                    'message' => 'Gagal menghapus metadata dari database'
                ]);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error deleting metadata: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan internal server'
            ]);
        }
    }
}
