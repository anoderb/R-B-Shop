<?php

namespace App\Models;

use CodeIgniter\Model;

class HomePageModel extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'Produk_id'; // Sesuaikan dengan nama kolom primary key di tabel Anda
    protected $allowedFields = ['nama_produk', 'harga', 'Deskripsi', 'gambar', 'Berat']; // Sesuaikan dengan kolom-kolom di tabel Anda

    /**
     * Mengambil semua produk atau produk tertentu berdasarkan ID.
     *
     * @param int|null $id ID produk (opsional)
     * @return array|null Data produk (semua atau satu produk)
     */
    public function getBarang($id = null)
    {
        if ($id === null) {
            return $this->findAll();
        }

        return $this->find($id);
    }

    /**
     * Mencari produk berdasarkan keyword.
     *
     * @param string|null $keyword Keyword pencarian
     * @return array Data produk yang sesuai dengan pencarian
     */
    public function searchBarang($keyword = null)
    {
        if ($keyword) {
            return $this->like('nama_produk', $keyword)
                        ->orLike('harga', $keyword) // Jika Anda ingin mencari berdasarkan harga juga
                        ->findAll();
        }
        return $this->findAll(); // Mengembalikan semua data jika tidak ada keyword
    }
}