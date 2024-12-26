<?= $this->extend('admin/templates/index'); ?>

<?= $this->section('content-admin'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Tambah Kategori</h1>

    <form action="<?= base_url('/admin/kategori/store'); ?>" method="post">
        <?= csrf_field(); ?>
        <div class="mb-3">
            <label for="nama_kategori" class="form-label">Nama Kategori</label>
            <input type="text" name="nama_kategori" id="nama_kategori" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="<?= base_url('/admin/kategori'); ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>
<?= $this->endSection(); ?>
