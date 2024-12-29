<?php

namespace App\Models;

use CodeIgniter\Model;

class PelangganModel extends Model
{
    protected $table = 'pelanggan';
    protected $primaryKey = 'Pelanggan_id';
    protected $allowedFields = ['Nama_pelanggan', 'Alamat', 'Hp', 'Kota', 'User_id'];
    protected $useTimestamps = false;

    // Add CRUD methods
    public function getPelangganByUserId($userId)
    {
        return $this->where('User_id', $userId)->first();
    }

    public function updateOrCreatePelanggan($userId, $data)
    {
        $pelanggan = $this->getPelangganByUserId($userId);

        if (!$pelanggan) {
            return $this->insert($data);
        } else {
            return $this->update($pelanggan['Pelanggan_id'], $data);
        }
    }
}