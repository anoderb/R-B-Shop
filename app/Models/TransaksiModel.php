<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table = 'Pembelian';
    protected $primaryKey = 'Pembelian_id';
    protected $allowedFields = ['tanggal', 'user_id', 'status', 'transaction_id', 'kurir_id', 'grand_total'];

    public function getTransaksi()
    {
        return $this->select('Pembelian.*, Users.username, Kurir.nama_kurir, Kurir.ongkos_kirim, (Pembelian.grand_total - Kurir.ongkos_kirim) AS nilai_total')
            ->join('Users', 'Users.id = Pembelian.user_id', 'left')
            ->join('Kurir', 'Kurir.kurir_id = Pembelian.kurir_id', 'left')
            ->findAll();
    }

    public function search($keyword)
    {
        return $this->select('Pembelian.*, Users.username, Kurir.nama_kurir, Kurir.ongkos_kirim, (Pembelian.grand_total - Kurir.ongkos_kirim) AS nilai_total')
            ->join('Users', 'Users.id = Pembelian.user_id', 'left')
            ->join('Kurir', 'Kurir.kurir_id = Pembelian.kurir_id', 'left')
            ->like('Pembelian.Pembelian_id', $keyword)
            ->orLike('Users.username', $keyword)
            ->orLike('Pembelian.status', $keyword)
            ->orLike('Kurir.nama_kurir', $keyword);
    }
    public function getTransaksiById($id)
    {
        return $this->select('Pembelian.*, Users.username, Kurir.nama_kurir, Kurir.ongkos_kirim')
            ->join('Users', 'Users.id = Pembelian.user_id', 'left')
            ->join('Kurir', 'Kurir.kurir_id = Pembelian.kurir_id', 'left')
            ->where('Pembelian.Pembelian_id', $id)
            ->first();
    }
    // In TransaksiModel:

    public function getPaginatedTransaksi($perPage, $keyword = null)
    {
        $builder = $this->select('Pembelian.*, Users.username, Kurir.nama_kurir, Kurir.ongkos_kirim, (Pembelian.grand_total - Kurir.ongkos_kirim) AS nilai_total')
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

        return $builder->paginate($perPage);
    }

    public function getDetailProduk($pembelianId)
    {
        $db = \Config\Database::connect();
        return $db->table('Pembelian_detail')
            ->select('Pembelian_detail.*, produk.nama_produk, produk.harga, Pembelian_detail.qty')
            ->join('produk', 'produk.Produk_id = Pembelian_detail.Produk_id')
            ->where('Pembelian_id', $pembelianId)
            ->get()
            ->getResultArray();
    }

    public function shipOrder($id)
    {
        return $this->update($id, ['status' => 'shipped']);
    }
}
