<?php

namespace App\Models;

use CodeIgniter\Model;

class MetadataModel extends Model
{
    protected $table = 'metadata';
    protected $primaryKey = 'Metadata_id';
    protected $allowedFields = ['Produk_id', 'Warna', 'Ukuran', 'Stok', 'Harga', 'meta_gambar'];
    protected $useSoftDeletes = false;
}
