<?php

namespace App\Controllers;

use App\Models\HomePageModel;
use App\Models\KategoriModel;

class HomePageController extends BaseController
{
    protected $homePageModel;
    protected $kategoriModel;

    public function __construct()
    {
        $this->homePageModel = new HomePageModel();
        $this->kategoriModel = new KategoriModel();
        helper(['number', 'form']);
    }

    public function index()
    {
        $keyword = $this->request->getVar('search');
        $data = [
            'title' => 'Home Page',
            'barang' => $this->homePageModel->searchBarang($keyword),
            'kategori' => $this->kategoriModel->getAllKategori(),
            'cart' => \Config\Services::cart(),
        ];
        return view('homepage', $data);
    }

    public function cek()
    {
        $response = $this->homePageModel->getCartContents();
        echo '<pre>';
        print_r($response);
        echo '</pre>';
    }

    public function add()
    {
        $this->homePageModel->addToCart([
            'id' => $this->request->getPost('id'),
            'qty' => 1,
            'price' => $this->request->getPost('price'),
            'name' => $this->request->getPost('name'),
            'options' => [
                'berat' => $this->request->getPost('berat'),
                'gambar' => $this->request->getPost('gambar'),
            ]
        ]);

        session()->setFlashdata('pesan', 'Barang berhasil ditambahkan ke keranjang!');
        return redirect()->back();
    }

    public function clear()
    {
        $this->homePageModel->clearCart();
        return redirect()->back();
    }

    public function cart()
    {
        if (!session()->has('ongkir')) {
            session()->set('ongkir', 0);
        }

        $data = [
            'title' => 'Cart',
            'cart' => \Config\Services::cart(),
            'subtotal' => $this->homePageModel->calculateSubtotal(),
            'kurirs' => $this->homePageModel->getKurirs(),
            'kategori' => $this->kategoriModel->getAllKategori(),
            'ongkir' => session()->get('ongkir')
        ];
        return view('cart', $data);
    }

    public function update()
    {
        $kurir_id = $this->request->getPost('kurir_id');
        
        if ($kurir_id) {
            $kurir = $this->homePageModel->getKurirById($kurir_id);
            if ($kurir) {
                session()->set([
                    'kurir_id' => $kurir_id,
                    'ongkir' => $kurir->ongkos_kirim
                ]);
            }
        }

        $cart = \Config\Services::cart();
        $i = 1;
        foreach ($cart->contents() as $key => $value) {
            $rowid = $this->request->getPost('rowid' . $i);
            $qty = $this->request->getPost('qty' . $i);

            if ($qty > 0) {
                $this->homePageModel->updateCart([
                    'rowid' => $rowid,
                    'qty' => $qty
                ]);
            } else {
                $this->homePageModel->removeFromCart($rowid);
            }
            $i++;
        }

        session()->setFlashdata('pesan', 'Cart berhasil diupdate!');
        return redirect()->to(base_url('homepage/cart'));
    }

    public function remove($rowid)
    {
        $this->homePageModel->removeFromCart($rowid);
        session()->setFlashdata('pesan', 'Barang berhasil dihapus dari keranjang!');
        return redirect()->to(base_url('homepage/cart'));
    }

    public function produkDetail($id)
    {
        $produk = $this->homePageModel->getBarang($id);
        
        if (!$produk) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Produk tidak ditemukan.');
        }

        $data = [
            'title' => 'Detail Produk',
            'produk' => $produk,
            'cart' => \Config\Services::cart(),
            'kategori' => $this->kategoriModel->getAllKategori(),
        ];

        return view('productdetail', $data);
    }
}