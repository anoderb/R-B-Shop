<?php



namespace App\Controllers;

use App\Models\ModelProduk;

class ControllerProduk extends BaseController
{
    public function index()
    {
        $model = new ModelProduk();
        $data['produk'] = $model->getProduk();
        return view('product', $data);
    }

    public function detail($id)
    {
        $model = new ModelProduk();
        $data['produk'] = $model->find($id);

        if (!$data['produk']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Produk tidak ditemukan.');
        }

        return view('productdetail', $data);
    }
}
