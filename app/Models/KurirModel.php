<?php

namespace App\Models;

use CodeIgniter\Model;

class KurirModel extends Model
{
    protected $table = 'kurir';
    protected $primaryKey = 'kurir_id';
    protected $allowedFields = ['nama_kurir', 'ongkos_kirim'];
}
