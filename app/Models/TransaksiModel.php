<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    // Nama tabel yang akan digunakan
    protected $table = 'Pembelian';
    // Tentukan primary key
    protected $primaryKey = 'Pembelian_id';
    // Tentukan kolom yang bisa diisi
    protected $allowedFields = ['tanggal', 'user_id', 'status'];

    // Mengambil data transaksi
    public function getTransaksi()
    {
        // Menggunakan kolom fullname yang benar dari tabel Users
        return $this->select('Pembelian.Pembelian_id, Pembelian.tanggal, Pembelian.status, Users.username')
                    ->join('Users', 'Users.id = Pembelian.user_id') // Pastikan ID yang digunakan benar
                    ->findAll();
    }
}
