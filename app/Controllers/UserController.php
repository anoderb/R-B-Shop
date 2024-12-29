<?php

namespace App\Controllers;

use App\Models\PelangganModel;
use Myth\Auth\Models\UserModel;
use App\Models\KategoriModel;

class UserController extends BaseController
{
    protected $pelangganModel;
    protected $userModel;
    protected $db;
    protected $kategoriModel;

    public function __construct()
    {
        $this->pelangganModel = new PelangganModel();
        $this->userModel = new UserModel();
        $this->db = \Config\Database::connect();
        $this->kategoriModel = new \App\Models\KategoriModel(); // Tambahkan ini untuk mendapatkan instance database
    }

    public function updateProfile()
    {
        $userId = user()->id;

        // Cek apakah data pelanggan sudah ada
        $pelanggan = $this->pelangganModel->where('User_id', $userId)->first();

        // Validasi input
        $rules = [
            'Nama_pelanggan' => 'required',
            'username'       => 'required|min_length[3]|max_length[30]',
            'email'         => 'required|valid_email',
            'Hp'            => 'required',
            'Alamat'        => 'required',
            'Kota'          => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->with('error', 'Validasi gagal: ' . implode(', ', $this->validator->getErrors()))
                ->withInput();
        }
        // Data untuk tabel users
        $userData = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
        ];

        // Data untuk tabel pelanggan
        $pelangganData = [
            'Nama_pelanggan' => $this->request->getPost('Nama_pelanggan'),
            'Hp'             => $this->request->getPost('Hp'),
            'Alamat'         => $this->request->getPost('Alamat'),
            'Kota'           => $this->request->getPost('Kota'),
            'User_id'        => $userId
        ];

        try {
            // Mulai transaksi database
            $this->db->transStart();

            // Update tabel users
            $userData = [
                'username' => $this->request->getPost('username'),
                'email'    => $this->request->getPost('email'),
            ];
            $this->userModel->updateUserProfile($userId, $userData);

            // Update pelanggan data
            $pelangganData = [
                'Nama_pelanggan' => $this->request->getPost('Nama_pelanggan'),
                'Hp'             => $this->request->getPost('Hp'),
                'Alamat'         => $this->request->getPost('Alamat'),
                'Kota'           => $this->request->getPost('Kota'),
                'User_id'        => $userId
            ];
            $this->pelangganModel->updateOrCreatePelanggan($userId, $pelangganData);

            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                throw new \Exception('Gagal menyimpan data');
            }

            return redirect()->to('/profile')->with('success', 'Profil berhasil diperbarui.');
        } catch (\Exception $e) {
            log_message('error', '[Update Profile] ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui profil.')
                ->withInput();
        }
    }

    public function userprofile()
    {
        $user = user();
        if (!$user) {
            return redirect()->to('/login');
        }

        $pelanggan = $this->pelangganModel->getPelangganByUserId($user->id) ?? [
            'Nama_pelanggan' => '',
            'Hp' => '',
            'Alamat' => '',
            'Kota' => ''
        ];

        $data = [
            'user' => $user,
            'pelanggan' => $pelanggan,
            'kategori' => $this->kategoriModel->findAll(),
            'cart' => \Config\Services::cart()
        ];

        return view('userprofile', $data);
    }
    public function updatePhoto()
    {
        $userId = user()->id;
        if (!$userId) {
            return redirect()->to('/profile')->with('error', 'ID pengguna tidak valid.');
        }

        // Define validation rules
        $validationRules = [
            'user_image' => [
                'rules' => 'uploaded[user_image]|is_image[user_image]|mime_in[user_image,image/jpg,image/jpeg,image/png]|max_size[user_image,2048]',
                'errors' => [
                    'uploaded' => 'File foto wajib diunggah.',
                    'is_image' => 'File yang diunggah harus berupa gambar.',
                    'mime_in'  => 'Format gambar hanya boleh JPG, JPEG, atau PNG.',
                    'max_size' => 'Ukuran file maksimal 2MB.',
                ],
            ],
        ];

        // Validate uploaded file
        if (!$this->validate($validationRules)) {
            return redirect()->back()
                ->with('error', $this->validator->getError('user_image'))
                ->withInput();
        }

        try {
            $file = $this->request->getFile('user_image');
            if (!$file->isValid()) {
                throw new \RuntimeException('File tidak valid.');
            }

            $extension = $file->getExtension();
            $newFileName = 'profile_' . $userId . '_' . time() . '.' . $extension;
            $uploadPath = FCPATH . 'img';

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $user = $this->userModel->find($userId);
            if (!$user) {
                throw new \RuntimeException('Data pengguna tidak ditemukan.');
            }

            // Delete old photo
            $this->userModel->deleteOldPhoto($user);

            // Move new file
            if (!$file->move($uploadPath, $newFileName)) {
                throw new \RuntimeException('Gagal memindahkan file.');
            }

            // Update database
            if (!$this->userModel->updateUserPhoto($userId, $newFileName)) {
                unlink($uploadPath . DIRECTORY_SEPARATOR . $newFileName);
                throw new \RuntimeException('Gagal mengupdate database.');
            }

            return redirect()->to('/profile')->with('success', 'Foto profil berhasil diperbarui.');
        } catch (\Exception $e) {
            log_message('error', '[Update Photo] ' . $e->getMessage());
            return redirect()->to('/profile')
                ->with('error', 'Terjadi kesalahan saat memperbarui foto profil: ' . $e->getMessage());
        }
    }
}
