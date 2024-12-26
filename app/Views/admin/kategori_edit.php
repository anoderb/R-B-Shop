<?= $this->extend('admin/templates/index'); ?>

<?= $this->section('content-admin'); ?>
<h1 class="h3 mb-4 text-gray-800">Edit Kategori Produk</h1>

<?php if(isset($validation)): ?>
    <div class="alert alert-danger"><?= $validation->listErrors(); ?></div>
<?php endif; ?>

<form action="<?= base_url('/admin/kategori/update/' . $kategori['Kategori_id']); ?>" method="post">
    <?= csrf_field(); ?>
    <div class="form-group">
        <label for="nama_kategori">Nama Kategori</label>
        <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" value="<?= old('nama_kategori', $kategori['nama_kategori']); ?>" required>
    </div>
    <button type="submit" class="btn btn-warning">Update Kategori</button>
</form>

<?= $this->endSection(); ?>
