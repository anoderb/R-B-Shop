<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'Produk_id';
    protected $allowedFields = ['Kode_produk', 'nama_produk', 'Kategori_id', 'harga', 'Berat', 'Deskripsi', 'gambar', 'stok', 'id_suppl'];

    public function search($keyword)
    {
        $this->select('Produk_id, Kode_produk, nama_produk, harga');
        $this->like('Kode_produk', $keyword);
        $this->orLike('nama_produk', $keyword);
        $this->orLike('harga', $keyword);
        
        return $this; // Kembalikan instance model
    }
}