<?php
namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table = 'produk_kategori'; // Nama tabel di database
    protected $primaryKey = 'kategori_id';
    protected $allowedFields = ['nama_kategori']; // Kolom yang boleh diisi

    // Mendapatkan semua kategori
    public function getAllKategori()
    {
        return $this->findAll();
    }

    // Menambah kategori baru
    public function addKategori($data)
    {
        return $this->insert($data);
    }

    // Mengupdate kategori
    public function updateKategori($id, $data)
    {
        return $this->update($id, $data);
    }

    // Menghapus kategori
    public function deleteKategori($id)
    {
        return $this->delete($id);
    }

    // Mendapatkan kategori berdasarkan ID
    public function getKategoriById($id)
    {
        return $this->find($id);
    }
}