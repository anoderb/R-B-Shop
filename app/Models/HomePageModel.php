<?php

namespace App\Models;

use CodeIgniter\Model;

class HomePageModel extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'Produk_id';
    protected $allowedFields = ['nama_produk', 'harga', 'Deskripsi', 'gambar', 'Berat'];

    public function getBarang($id = null)
    {
        if ($id === null) {
            return $this->findAll();
        }
        return $this->find($id);
    }

    public function searchBarang($keyword = null)
    {
        if ($keyword) {
            return $this->like('nama_produk', $keyword)
                       ->orLike('harga', $keyword)
                       ->findAll();
        }
        return $this->findAll();
    }

    // Cart related methods
    public function addToCart($data)
    {
        $cart = \Config\Services::cart();
        return $cart->insert($data);
    }

    public function updateCart($data)
    {
        $cart = \Config\Services::cart();
        return $cart->update($data);
    }

    public function removeFromCart($rowid)
    {
        $cart = \Config\Services::cart();
        return $cart->remove($rowid);
    }

    public function clearCart()
    {
        $cart = \Config\Services::cart();
        return $cart->destroy();
    }

    public function getCartContents()
    {
        $cart = \Config\Services::cart();
        return $cart->contents();
    }

    public function getKurirs()
    {
        $db = \Config\Database::connect();
        return $db->table('kurir')->get()->getResultArray();
    }

    public function getKurirById($kurir_id)
    {
        $db = \Config\Database::connect();
        return $db->table('kurir')->where('kurir_id', $kurir_id)->get()->getRow();
    }

    public function calculateSubtotal()
    {
        $cart = \Config\Services::cart();
        $subtotal = 0;
        foreach ($cart->contents() as $item) {
            $subtotal += $item['price'] * $item['qty'];
        }
        return $subtotal;
    }
}