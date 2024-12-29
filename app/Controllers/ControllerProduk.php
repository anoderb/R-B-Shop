<?php

namespace App\Controllers;

use App\Models\ProdukModel;

class ControllerProduk extends BaseController
{
    protected $produkModel;
    protected $kategoriModel;
    
    public function __construct()
    {
        $this->produkModel = new ProdukModel();
        $this->kategoriModel = new \App\Models\ProdukKategoriModel();
        helper(['form', 'number']); 
    }
    
    public function index()
    {
        $kategori = $this->request->getGet('kategori');
        
        $data = [
            'title' => 'Produk',
            'produk' => $this->produkModel->getProdukByKategori($kategori),
            'kategori' => $this->kategoriModel->getKategori(),
        ];
        
        return view('produk_kategori', $data);
    }

    public function kategori($kategori)
    {
        $data['produk'] = $this->produkModel->getProdukWithKategori($kategori);

        if (empty($data['produk'])) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Produk untuk kategori $kategori tidak ditemukan.");
        }

        $data['title'] = "Produk Kategori: $kategori";
        return view('produk_kategori', $data);
    }
}