<?php

namespace App\Models;

use CodeIgniter\Model;

class PembelianDetailModel extends Model
{
    protected $table = 'pembelian_detail';
    protected $primaryKey = 'Pembelian_detail_id';
    protected $allowedFields = ['Pembelian_id', 'Produk_id', 'qty'];

    public function createOrderDetails($data)
    {
        return $this->insert($data);
    }

    public function getDetailsWithProduct($pembelianId)
    {
        return $this->db->table('pembelian_detail')
            ->select('pembelian_detail.*, produk.nama_produk, produk.harga')
            ->join('produk', 'produk.Produk_id = pembelian_detail.Produk_id')
            ->where('pembelian_detail.Pembelian_id', $pembelianId)
            ->get()
            ->getResultArray();
    }
}