<?php

namespace App\Models;

use CodeIgniter\Model;

class PembelianModel extends Model
{
    protected $table = 'pembelian';
    protected $primaryKey = 'Pembelian_id';
    protected $allowedFields = ['tanggal', 'user_id', 'status', 'transaction_id', 'grand_total'];
}
