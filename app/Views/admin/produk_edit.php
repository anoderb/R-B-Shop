<?= $this->extend('admin/templates/index'); ?>

<?= $this->section('content-admin'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Produk</h1>

    <form action="/admin/produk/update/<?= $produk['Produk_id']; ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field(); ?>
        <div class="form-group">
            <label for="Kode_produk">Kode Produk</label>
            <input type="text" name="Kode_produk" id="Kode_produk" value="<?= $produk['Kode_produk']; ?>" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="nama_produk">Nama Produk</label>
            <input type="text" name="nama_produk" id="nama_produk" value="<?= $produk['nama_produk']; ?>" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="Kategori_id">Kategori</label>
            <input type="number" name="Kategori_id" id="Kategori_id" value="<?= $produk['Kategori_id']; ?>" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="Deskripsi">Deskripsi</label>
            <textarea name="Deskripsi" id="Deskripsi" class="form-control" required><?= $produk['Deskripsi']; ?></textarea>
        </div>
        <div class="form-group">
            <label for="harga">Harga</label>
            <input type="number" name="harga" id="harga" value="<?= $produk['harga']; ?>" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="stok">Stok</label>
            <input type="number" class="form-control" id="stok" name="stok" value="<?= $produk['stok']; ?>" required>
        </div>

        <div class="form-group">
            <label for="Berat">Berat (kg)</label>
            <input type="number" step="0.01" name="Berat" id="Berat" value="<?= $produk['Berat']; ?>" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="gambar">Gambar</label>
            <input type="file" name="gambar" id="gambar" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="/admin/produk" class="btn btn-secondary">Batal</a>
    </form>
</div>
<?= $this->endSection(); ?>