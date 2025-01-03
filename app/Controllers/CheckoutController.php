<?php

namespace App\Controllers;

use App\Models\PembelianModel;
use App\Models\PembelianDetailModel;
use App\Models\PelangganModel;
use Myth\Auth\Models\UserModel;
use App\Models\KategoriModel;


use CodeIgniter\Controller;

class CheckoutController extends BaseController
{
    protected $cart;
    protected $pembelianModel;
    protected $pembelianDetailModel;
    protected $pelangganModel;
    protected $kategoriModel;

    public function __construct()
    {
        $this->cart = \Config\Services::cart();
        $this->pembelianModel = new PembelianModel();
        $this->pembelianDetailModel = new PembelianDetailModel();
        $this->pelangganModel = new PelangganModel();
        $this->kategoriModel = new KategoriModel();
        helper(['number', 'form']);
    }

    public function index()
    {
        $userId = user()->id;
        $pelanggan = $this->pelangganModel->where('User_id', $userId)->first();

        // Ambil data dari sesi
        $kurir_id = session()->get('kurir_id');
        $ongkir = session()->get('ongkir');
        $db = \Config\Database::connect();
        $kurir = $kurir_id ? $db->table('kurir')->where('kurir_id', $kurir_id)->get()->getRow() : null;
        $kategori = $this->kategoriModel->findAll();
        $data = [
            'title' => 'Checkout',
            'pelanggan' => $pelanggan,
            'kurir' => $kurir,
            'ongkir' => $ongkir,
            'cart' => $this->cart,
            'kategori' => $kategori,
        ];

        return view('checkout', $data);
    }


    public function process()
    {
        if (!$this->validate([
            'nama_pelanggan' => 'required',
            'alamat' => 'required',
            'kota' => 'required',
            'hp' => 'required',
        ])) {
            return $this->response->setJSON(['error' => 'Mohon lengkapi semua data.']);
        }

        try {
            $kurirId = session()->get('kurir_id');

            $pembelianData = [
                'tanggal' => date('Y-m-d H:i:s'),
                'user_id' => user()->id,
                'status' => 'pending',
                'kurir_id' => $kurirId
            ];

            $pembelianId = $this->pembelianModel->createOrder($pembelianData);

            foreach ($this->cart->contents() as $item) {
                $this->pembelianDetailModel->createOrderDetails([
                    'Pembelian_id' => $pembelianId,
                    'Produk_id' => $item['id'],
                    'qty' => $item['qty'],
                ]);
            }
            // Konfigurasi Midtrans
          
            \Midtrans\Config::$serverKey = env('midtrans.serverKey');
            \Midtrans\Config::$isProduction = (bool)env('midtrans.isProduction');
            \Midtrans\Config::$isSanitized = (bool)env('midtrans.isSanitized');
            \Midtrans\Config::$is3ds = (bool)env('midtrans.is3ds');

            // Generate Snap Token dari Midtrans
            $ongkir = session()->get('ongkir');

            // Update konfigurasi Midtrans
            $midtrans = new \Midtrans\Snap();
            $transactionDetails = [
                'order_id' => 'ORDER-' . time(),
                'gross_amount' => $this->cart->total() + $ongkir, // Menggunakan ongkir dari session
            ];
            $params = [
                'transaction_details' => $transactionDetails,
                'customer_details' => [
                    'first_name' => $this->request->getPost('nama_pelanggan'),
                    'email' => user()->email ?? 'email@example.com',
                    'phone' => $this->request->getPost('hp'),
                ],
            ];
            $snapToken = $midtrans->getSnapToken($params);

            // Kosongkan keranjang
            $this->cart->destroy();

            // Return JSON response dengan redirect URL
            return $this->response->setJSON([
                'snapToken' => $snapToken,
                'orderId' => $pembelianId,
                'redirectUrl' => base_url('/checkout/complete'), // Route tujuan setelah pembayaran selesai
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => $e->getMessage()]);
        }
    }

    public function complete()
    {
        $orderId = (int) $this->request->getPost('order_id');
        $transactionId = $this->request->getPost('transaction_id');
        $grossAmount = (int) $this->request->getPost('gross_amount');
        $transactionStatus = $this->request->getPost('transaction_status');

        $status = 'pending';
        if ($transactionStatus == 'settlement') {
            $status = 'completed'; // Ubah dari 'completed' ke 'shipped'
        } elseif ($transactionStatus == 'pending') {
            $status = 'pending';
        } else {
            $status = 'failed';
        }

        // Data yang akan diperbarui
        $dataToUpdate = [
            'transaction_id' => $transactionId,
            'grand_total' => $grossAmount,
            'status' => $status,
            'kurir_id' => session()->get('kurir_id')
        ];

        // Lakukan update berdasarkan order_id
        $this->pembelianModel->update(['Pembelian_id' => $orderId], $dataToUpdate);

        // Redirect ke halaman sukses
        return redirect()->to(base_url('/myorder'))->with('message', 'Transaksi berhasil.');
    }


    public function myOrders()
    {
        $userId = user()->id;
        $orders = $this->pembelianModel->getUserOrders($userId);

        foreach ($orders as &$order) {
            $order['details'] = $this->pembelianDetailModel->getDetailsWithProduct($order['Pembelian_id']);
            $order['total_harga'] = array_reduce($order['details'], function ($carry, $item) {
                return $carry + ($item['harga'] * $item['qty']);
            }, 0);
        }

        $data = [
            'title' => 'My Orders',
            'orders' => $orders,
            'kategori' => $this->kategoriModel->findAll(),
        ];

        return view('myorder', $data);
    }


    public function updateStatus($orderId, $status)
    {
        $validStatuses = ['cancelled', 'completed', 'delivered'];
        if (!in_array($status, $validStatuses)) {
            return redirect()->back()->with('error', 'Status tidak valid.');
        }

        $dbStatus = ($status === 'cancelled') ? 'failed' : $status;

        if (!$this->pembelianModel->updateOrderStatus($orderId, ['status' => $dbStatus])) {
            return redirect()->back()->with('error', 'Gagal memperbarui status.');
        }

        $messages = [
            'cancelled' => 'Pesanan berhasil dibatalkan.',
            'completed' => 'Pesanan berhasil diselesaikan.',
            'delivered' => 'Pesanan telah diterima.'
        ];

        return redirect()->to('/myorder')->with('success', $messages[$status]);
    }
}
