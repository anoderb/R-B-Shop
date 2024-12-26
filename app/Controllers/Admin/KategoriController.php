<?php

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

    public function index()
    {
        $data = [
            'kategori' => $this->kategoriModel->findAll(), // Ambil semua data kategori
        ];

        return view('admin/kategori', $data);
    }

    public function create()
    {
        return view('admin/kategori_tambah');
    }

    public function store()
    {
        $this->validate([
            'nama_kategori' => 'required|is_unique[produk_kategori.nama_kategori]',
        ]);

        $this->kategoriModel->insert([
            'nama_kategori' => $this->request->getPost('nama_kategori'),
        ]);

        return redirect()->to('/admin/kategori')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $kategori = $this->kategoriModel->find($id);

        if (!$kategori) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kategori tidak ditemukan');
        }

        return view('admin/kategori_edit', ['kategori' => $kategori]);
    }

    public function update($id)
    {
        $this->validate([
            'nama_kategori' => "required|is_unique[produk_kategori.nama_kategori,kategori_id,$id]",
        ]);

        $this->kategoriModel->update($id, [
            'nama_kategori' => $this->request->getPost('nama_kategori'),
        ]);

        return redirect()->to('/admin/kategori')->with('success', 'Kategori berhasil diupdate!');
    }

    public function delete($id)
    {
        $this->kategoriModel->delete($id);

        return redirect()->to('/admin/kategori')->with('success', 'Kategori berhasil dihapus!');
    }
}
