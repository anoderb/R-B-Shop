<?php

namespace App\Models;

use CodeIgniter\Model;

class PembelianModel extends Model
{
    protected $table = 'pembelian';
    protected $primaryKey = 'Pembelian_id';
    protected $allowedFields = ['tanggal', 'user_id', 'status', 'transaction_id', 'kurir_id', 'grand_total'];

    public function createOrder($data)
    {
        return $this->insert($data, true);
    }

    public function getUserOrders($userId)
    {
        return $this->where('user_id', $userId)
                    ->orderBy('tanggal', 'DESC')
                    ->findAll();
    }

    public function updateOrderStatus($orderId, $data)
    {
        return $this->update($orderId, $data);
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