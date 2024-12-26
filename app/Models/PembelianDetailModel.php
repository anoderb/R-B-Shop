<?php

namespace App\Models;

use CodeIgniter\Model;

class PembelianDetailModel extends Model
{
    protected $table = 'pembelian_detail';
    protected $primaryKey = 'Pembelian_detail_id';
    protected $allowedFields = ['Pembelian_id', 'Produk_id', 'qty'];

    // Tambahkan metode ini
    public function getDetailsWithProduct($pembelianId)
    {
        return $this->select('pembelian_detail.*, produk.nama_produk AS nama_produk, produk.harga')
            ->join('produk', 'produk.Produk_id = pembelian_detail.Produk_id') // Sesuaikan join dengan kolom yang benar
            ->where('pembelian_detail.Pembelian_id', $pembelianId)
            ->findAll();
    }
}
