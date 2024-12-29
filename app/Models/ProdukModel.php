<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'Produk_id';
    protected $allowedFields = ['Kode_produk', 'nama_produk', 'Kategori_id', 'harga', 'Berat', 'Deskripsi', 'gambar', 'stok', 'id_suppl'];

    public function search($keyword)
    {
        return $this->select('Produk_id, Kode_produk, nama_produk, harga')
            ->like('Kode_produk', $keyword)
            ->orLike('nama_produk', $keyword)
            ->orLike('harga', $keyword);
    }

    public function getKategori()
    {
        return $this->db->table('produk_kategori')->get()->getResultArray();
    }

    public function getProdukWithRelations($perPage = null)
    {
        $query = $this->select('produk.*, supplier.nama_suppl, produk_kategori.nama_kategori')
            ->join('supplier', 'supplier.id_suppl = produk.id_suppl', 'left')
            ->join('produk_kategori', 'produk_kategori.Kategori_id = produk.Kategori_id', 'left');

        if ($perPage !== null) {
            return $query->paginate($perPage);
        }
        return $query->findAll();
    }

    public function createProduk($data)
    {
        return $this->insert($data);
    }

    public function updateProduk($id, $data)
    {
        return $this->update($id, $data);
    }

    public function deleteProduk($id)
    {
        $produk = $this->find($id);
        if ($produk && !empty($produk['gambar'])) {
            $imagePath = FCPATH . 'uploads/produk/' . $produk['gambar'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        return $this->delete($id);
    }

    public function getProdukById($id)
    {
        return $this->find($id);
    }

    public function getProdukWithMetadata($id)
    {
        $produk = $this->select('produk.*, supplier.nama_suppl, produk_kategori.nama_kategori')
            ->join('supplier', 'supplier.id_suppl = produk.id_suppl', 'left')
            ->join('produk_kategori', 'produk_kategori.Kategori_id = produk.Kategori_id', 'left')
            ->find($id);

        if ($produk) {
            $metadataModel = new MetadataModel();
            $metadata = $metadataModel->where('Produk_id', $id)->findAll();
            return [
                'produk' => $produk,
                'metadata' => $metadata
            ];
        }
        return null;
    }

    public function getAllProdukData()
    {
        return $this->select('produk.*, supplier.nama_suppl, produk_kategori.nama_kategori')
            ->join('supplier', 'supplier.id_suppl = produk.id_suppl', 'left')
            ->join('produk_kategori', 'produk_kategori.Kategori_id = produk.Kategori_id', 'left')
            ->findAll();
    }

    public function getProdukByKategori($kategori = null)
    {
        $query = $this->select('produk.*, produk_kategori.nama_kategori')
            ->join('produk_kategori', 'produk_kategori.Kategori_id = produk.Kategori_id');

        if ($kategori) {
            $query->where('produk_kategori.nama_kategori', $kategori);
        }

        return $query->findAll();
    }

    public function getProdukWithKategori($kategori)
    {
        return $this->select('produk.*')
            ->where('kategori', $kategori)
            ->findAll();
    }
}
