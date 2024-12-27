<?php

namespace App\Controllers;

use App\Models\HomePageModel;
use App\Models\ProdukModel;
use App\Models\KategoriModel;

class HomePageController extends BaseController
{
    protected $homePageModel;
    protected $kategoriModel;

    public function __construct()
    {
        $this->homePageModel = new HomePageModel();
        $this->kategoriModel = new KategoriModel();
        helper('number');
        helper('form');
    }

    public function index()
    {
        $keyword = $this->request->getVar('search'); // Ambil keyword dari query string
        $data = [
            'title' => 'Home Page',
            'barang' => $this->homePageModel->searchBarang($keyword), // Panggil metode searchBarang dengan keyword
            'kategori' => $this->kategoriModel->findAll(), // Ambil semua kategori dari database
            'cart' => \Config\Services::cart(),
        ];
        return view('homepage', $data);
    }


    //shoping cart


    public function cek()
    {
        $cart = \Config\Services::cart();
        $response = $cart->contents();
        echo '<pre>';
        print_r($response);
        echo '</pre>';
    }
    // Insert an shopping cart
    // public function add()
    // {
    //     $cart = \Config\Services::cart();

    //     // Menambahkan item ke keranjang
    //     $cart->insert([
    //         'id'      => $this->request->getPost('id'),
    //         'qty'     => 1,
    //         'price'   => $this->request->getPost('price'),
    //         'name'    => $this->request->getPost('name'),
    //         'options' => [
    //             'berat'  => $this->request->getPost('berat'),
    //             'gambar' => $this->request->getPost('gambar'),
    //         ]
    //     ]);

    //     // Set flashdata untuk notifikasi
    //     session()->setFlashdata('pesan', 'Barang berhasil ditambahkan ke keranjang!');

    //     // Redirect ke halaman homepage
    //     return redirect()->to(base_url('homepage'));
    // }

    public function add()
    {
        $cart = \Config\Services::cart();

        // Menambahkan item ke keranjang
        $cart->insert([
            'id'      => $this->request->getPost('id'),
            'qty'     => 1,
            'price'   => $this->request->getPost('price'),
            'name'    => $this->request->getPost('name'),
            'options' => [
                'berat'  => $this->request->getPost('berat'),
                'gambar' => $this->request->getPost('gambar'),
            ]
        ]);

        // Set flashdata untuk notifikasi
        session()->setFlashdata('pesan', 'Barang berhasil ditambahkan ke keranjang!');

        // Redirect ke halaman sebelumnya (referer)
        return redirect()->back();
    }


    // delete an shopping cart
    public function clear()
    {
        $cart = \Config\Services::cart();
        $cart->destroy();
    }
    public function cart()
    {
        $cart = \Config\Services::cart();
        $db = \Config\Database::connect();

        // Initialize ongkir session if not set
        if (!session()->has('ongkir')) {
            session()->set('ongkir', 0);
        }

        $kurirs = $db->table('kurir')->get()->getResultArray();

        $subtotal = 0;
        foreach ($cart->contents() as $item) {
            $subtotal += $item['price'] * $item['qty'];
        }

        $data = [
            'title' => 'Cart',
            'cart' => $cart,
            'subtotal' => $subtotal,
            'kurirs' => $kurirs,
            'ongkir' => session()->get('ongkir')
        ];
        return view('cart', $data);
    }

    public function update()
    {
        $cart = \Config\Services::cart();
        $i = 1;
        $kurir_id = $this->request->getPost('kurir_id');
    
        if ($kurir_id) {
            $db = \Config\Database::connect();
            $kurir = $db->table('kurir')->where('kurir_id', $kurir_id)->get()->getRow();
    
            if ($kurir) {
                session()->set('kurir_id', $kurir_id);
                session()->set('ongkir', $kurir->ongkos_kirim);
            }
        }
    
        foreach ($cart->contents() as $key => $value) {
            $rowid = $this->request->getPost('rowid' . $i);
            $qty = $this->request->getPost('qty' . $i);
    
            if ($qty > 0) {
                $cart->update([
                    'rowid' => $rowid,
                    'qty' => $qty
                ]);
            } else {
                $cart->remove($rowid);
            }
            $i++;
        }
    
        session()->setFlashdata('pesan', 'Cart berhasil diupdate!');
        return redirect()->to(base_url('homepage/cart'));
    }
    

    // public function delete(){
    //     $cart = \Config\Services::cart();
    //     $cart->remove('rowid');
    //     return redirect()->to(base_url('homepage/cart'));
    // }
    public function remove($rowid)
    {
        $cart = \Config\Services::cart();
        $cart->remove($rowid);

        session()->setFlashdata('pesan', 'Barang berhasil dihapus dari keranjang!');
        return redirect()->to(base_url('homepage/cart'));
    }

    public function produkDetail($id)
    {
        // Ambil detail produk berdasarkan ID
        $produk = $this->homePageModel->getBarang($id);
        $cart = \Config\Services::cart();


        // Jika produk tidak ditemukan, tampilkan halaman 404
        if (!$produk) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Produk tidak ditemukan.');
        }

        $data = [
            'title' => 'Detail Produk',
            'produk' => $produk,
            'cart' => $cart,
        ];

        return view('productdetail', $data);
    }


}
