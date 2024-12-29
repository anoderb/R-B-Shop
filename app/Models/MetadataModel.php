<?php

namespace App\Models;

use CodeIgniter\Model;

class MetadataModel extends Model
{
    protected $table = 'metadata';
    protected $primaryKey = 'Metadata_id';
    protected $allowedFields = ['Produk_id', 'Warna', 'Ukuran', 'Stok', 'Harga', 'meta_gambar'];
    protected $useSoftDeletes = false;

    // Menyimpan metadata
    public function saveMetadata($data)
    {
        return $this->save($data);
    }

    // Menghapus metadata berdasarkan ID
    public function deleteMetadata($id)
    {
        return $this->delete($id);
    }

    // Mendapatkan metadata berdasarkan ID
    public function getMetadataById($id)
    {
        return $this->find($id);
    }
}