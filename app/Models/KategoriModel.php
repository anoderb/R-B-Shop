<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table = 'produk_kategori'; // Nama tabel di database
    protected $primaryKey = 'kategori_id';
    protected $allowedFields = ['nama_kategori']; // Kolom yang boleh diisi
}
