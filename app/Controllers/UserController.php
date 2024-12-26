<?php

namespace App\Controllers;

use App\Models\PelangganModel;
use Myth\Auth\Models\UserModel;

class UserController extends BaseController
{
    protected $pelangganModel;
    protected $userModel;

    public function __construct()
    {
        $this->pelangganModel = new PelangganModel();
        $this->userModel = new UserModel(); // Menggunakan model bawaan Myth:Auth
    }

    public function updateProfile()
    {
        // Ambil ID user yang sedang login
        $userId = user()->id; // Dari Myth:Auth
        $pelanggan = $this->pelangganModel->where('User_id', $userId)->first();

        if (!$pelanggan) {
            return redirect()->back()->with('error', 'Data pelanggan tidak ditemukan.');
        }

        // Validasi input
        $this->validate([
            'Nama_pelanggan' => 'required',
            'username'       => 'required|min_length[3]|max_length[30]',
            'email'          => 'required|valid_email',
            'Hp'             => 'required',
            'Alamat'         => 'required',
            'Kota'           => 'required',
        ]);

        // Data dari form
        $userData = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
        ];

        $pelangganData = [
            'Nama_pelanggan' => $this->request->getPost('Nama_pelanggan'),
            'Hp'             => $this->request->getPost('Hp'),
            'Alamat'         => $this->request->getPost('Alamat'),
            'Kota'           => $this->request->getPost('Kota'),
        ];

        // Update tabel `users`
        $this->userModel->update($userId, $userData);

        // Update tabel `pelanggan`
        $this->pelangganModel->update($pelanggan['Pelanggan_id'], $pelangganData);

        return redirect()->to('/profile')->with('success', 'Profil berhasil diperbarui.');
    }

    public function userprofile()
    {
        // Ambil data user yang sedang login
        $user = user(); // Fungsi `user()` bawaan Myth:Auth

        // Ambil data pelanggan berdasarkan User_id
        $pelanggan = $this->pelangganModel->where('User_id', $user->id)->first();

        // Kirim data ke view
        return view('userprofile', [
            'user' => $user,
            'pelanggan' => $pelanggan,
            'cart' => \Config\Services::cart(),
        ]);
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
