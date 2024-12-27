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
        $this->produkModel->select('produk.*, produk_kategori.nama_kategori');
        $this->produkModel->join('produk_kategori', 'produk_kategori.Kategori_id = produk.Kategori_id');
        
        $data = [
            'title' => 'Produk',
            'produk' => $kategori 
                ? $this->produkModel->where('produk_kategori.nama_kategori', $kategori)->findAll()
                : $this->produkModel->findAll(),
            'kategori' => $this->kategoriModel->getKategori(),
        ];
        
        return view('produk_kategori', $data);
    }



    public function kategori($kategori)
    {
        $data['produk'] = $this->produkModel->where('kategori', $kategori)->findAll();

        if (empty($data['produk'])) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Produk untuk kategori $kategori tidak ditemukan.");
        }

        $data['title'] = "Produk Kategori: $kategori";
        return view('produk_kategori', $data);
    }
}
