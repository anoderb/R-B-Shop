<?php

namespace App\Controllers\Admin;

use App\Models\TransaksiModel;
use CodeIgniter\Controller;

class TransaksiController extends Controller
{
    public function index()
    {
        // Membuat objek dari model TransaksiModel
        $transaksiModel = new TransaksiModel();
        
        // Mendapatkan data transaksi dari model
        $transaksi = $transaksiModel->getTransaksi();
        
        // Mengirim data transaksi ke tampilan
        return view('admin/transaksi', ['transaksi' => $transaksi]);
    }
}
