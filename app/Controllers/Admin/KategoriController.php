<?php

// app/Controllers/Admin/KategoriController.php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KategoriModel;

class KategoriController extends BaseController
{
    protected $kategoriModel;

    public function __construct()
    {
        $this->kategoriModel = new KategoriModel();
    }

    // Menampilkan daftar kategori
    public function index()
    {
        $data = [
            'kategori' => $this->kategoriModel->getAllKategori(), // Mengambil semua kategori
        ];

        return view('admin/kategori', $data);
    }

    // Menampilkan form untuk menambah kategori
    public function create()
    {
        return view('admin/kategori_tambah');
    }

    // Menyimpan kategori baru
    public function store()
    {
        $this->validate([
            'nama_kategori' => 'required|is_unique[produk_kategori.nama_kategori]',
        ]);

        $this->kategoriModel->addKategori([
            'nama_kategori' => $this->request->getPost('nama_kategori'),
        ]);

        return redirect()->to('/admin/kategori')->with('success', 'Kategori berhasil ditambahkan!');
    }

    // Menampilkan form untuk mengedit kategori
    public function edit($id)
    {
        $kategori = $this->kategoriModel->getKategoriById($id);

        if (!$kategori) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kategori tidak ditemukan');
        }

        return view('admin/kategori_edit', ['kategori' => $kategori]);
    }

    // Mengupdate kategori
    public function update($id)
    {
        $this->validate([
            'nama_kategori' => "required|is_unique[produk_kategori.nama_kategori,kategori_id,$id]",
        ]);

        $this->kategoriModel->updateKategori($id, [
            'nama_kategori' => $this->request->getPost('nama_kategori'),
        ]);

        return redirect()->to('/admin/kategori')->with('success', 'Kategori berhasil diupdate!');
    }

    // Menghapus kategori
    public function delete($id)
    {
        $this->kategoriModel->deleteKategori($id);

        return redirect()->to('/admin/kategori')->with('success', 'Kategori berhasil dihapus!');
    }
}
