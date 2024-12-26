<?= $this->extend('admin/templates/index'); ?>

<?= $this->section('content-admin'); ?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Kelola Kategori Produk</h1>

    <!-- Tampilkan pesan sukses jika ada -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
    <?php endif; ?>

    <!-- Tombol Tambah Kategori -->
    <a href="<?= base_url('/admin/kategori/create'); ?>" class="btn btn-primary mb-3">Tambah Kategori</a>

    <!-- Tabel Kategori -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Kategori</h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($kategori)): ?>
                        <?php foreach ($kategori as $key => $item): ?>
                            <tr>
                                <td><?= $item['Kategori_id']; ?></td>
                                <td><?= esc($item['nama_kategori']); ?></td>
                                <td>
                                    <a href="<?= base_url('/admin/kategori/edit/' . $item['Kategori_id']); ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="<?= base_url('/admin/kategori/hapus/' . $item['Kategori_id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus kategori ini?')">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center">Tidak ada kategori yang tersedia.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
<?= $this->endSection(); ?>
