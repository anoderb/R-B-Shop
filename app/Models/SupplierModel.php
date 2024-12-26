<?php

namespace App\Models;

use CodeIgniter\Model;

class SupplierModel extends Model
{
    protected $table = 'supplier'; 
    protected $primaryKey = 'id_suppl';
    protected $allowedFields = ['nama_suppl']; 
}
