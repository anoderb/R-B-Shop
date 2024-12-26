<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelProduk extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'Produk_id';
    protected $allowedFields = ['Kode_produk', 'nama_produk', 'Kategori_id', 'Deskripsi', 'harga', 'Berat', 'gambar', 'stok'];
    protected $useTimestamps = true; // Jika Anda menggunakan kolom created_at atau updated_at
    protected $orderBy = ['Produk_id' => 'desc']; // Mengurutkan berdasarkan ID produk terbaru

    // Fungsi untuk mengambil produk dengan urutan terbaru
    public function getProduk()
    {
        return $this->findAll(); // Menampilkan semua produk dengan urutan terbaru berdasarkan Produk_id
    }
}
