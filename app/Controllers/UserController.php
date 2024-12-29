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
        // Ambil ID user yang sedang login
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
            $this->userModel->update($userId, $userData);

            // Jika data pelanggan belum ada, buat baru
            if (!$pelanggan) {
                $this->pelangganModel->insert($pelangganData);
            } else {
                // Jika sudah ada, update data yang ada
                $this->pelangganModel->update($pelanggan['Pelanggan_id'], $pelangganData);
            }

            // Selesaikan transaksi
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
        // Ambil data user yang sedang login
        $user = user();

        if (!$user) {
            return redirect()->to('/login');
        }

        // Ambil data pelanggan berdasarkan User_id
        $pelanggan = $this->pelangganModel->where('User_id', $user->id)->first();

        // Jika data pelanggan belum ada, siapkan array kosong
        if (!$pelanggan) {
            $pelanggan = [
                'Nama_pelanggan' => '',
                'Hp' => '',
                'Alamat' => '',
                'Kota' => ''
            ];
        }

        $kategori = $this->kategoriModel->findAll();

        $data = [
            'user' => $user,
            'pelanggan' => $pelanggan,
            'kategori' => $kategori,
            'cart' => \Config\Services::cart()
            
        ];

        return view('userprofile', $data);
    }
    public function updatePhoto()
    {
        // Ambil ID user yang sedang login
        $userId = user()->id;

        if (!$userId) {
            return redirect()->to('/profile')->with('error', 'ID pengguna tidak valid.');
        }

        // Validasi file upload
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

        if (!$this->validate($validationRules)) {
            return redirect()->back()
                ->with('error', $this->validator->getError('user_image'))
                ->withInput();
        }

        try {
            // Ambil file yang diunggah
            $file = $this->request->getFile('user_image');

            if (!$file->isValid()) {
                throw new \RuntimeException('File tidak valid.');
            }

            // Generate nama file baru dengan timestamp
            $extension = $file->getExtension();
            $newFileName = 'profile_' . $userId . '_' . time() . '.' . $extension;

            // Pastikan direktori upload ada dan bisa ditulis
            $uploadPath = FCPATH . 'img';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Ambil data pengguna yang sedang login
            $user = $this->userModel->find($userId);
            if (!$user) {
                throw new \RuntimeException('Data pengguna tidak ditemukan.');
            }

            // Hapus file gambar lama jika bukan default.svg
            if ($user->user_image && $user->user_image !== 'default.svg') {
                $oldFilePath = $uploadPath . DIRECTORY_SEPARATOR . $user->user_image;
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }

            // Pindahkan file baru
            if (!$file->move($uploadPath, $newFileName)) {
                throw new \RuntimeException('Gagal memindahkan file.');
            }

            // Update database
            if (!$this->userModel->update($userId, ['user_image' => $newFileName])) {
                // Jika update database gagal, hapus file yang sudah diupload
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
