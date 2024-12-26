<?php

namespace App\Models;

use CodeIgniter\Model;

class PelangganModel extends Model
{
    protected $table = 'pelanggan';
    protected $primaryKey = 'Pelanggan_id';
    protected $allowedFields = ['Nama_pelanggan', 'Alamat', 'Hp', 'Kota', 'User_id'];

    // Nonaktifkan timestamps jika tidak digunakan
    protected $useTimestamps = false;
}
