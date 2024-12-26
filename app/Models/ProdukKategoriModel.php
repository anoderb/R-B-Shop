<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukKategoriModel extends Model
{
    protected $table = 'Produk_Kategori';
    protected $primaryKey = 'Kategori_id';
    protected $allowedFields = ['nama_kategori'];
}
