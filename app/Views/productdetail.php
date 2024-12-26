<?= $this->extend('/templates/index'); ?>
<?= $this->section('content-user'); ?>

<div class="container mt-4">
    <?php if (session()->getFlashdata('pesan')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('pesan'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/produk">Produk</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail Produk</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-4">
            <img src="<?= base_url('/uploads/produk/' . $produk['gambar']); ?>" class="img-fluid rounded" alt="<?= esc($produk['nama_produk']); ?>">
        </div>
        <div class="col-md-8">
            <h2 class="fw-bold"><?= esc($produk['nama_produk']); ?></h2>
            <h4 class="text-danger">Rp <?= number_format($produk['harga'], 0, ',', '.'); ?></h4>
            <p class="text-muted"><?= esc($produk['Deskripsi']); ?></p>

            <form action="<?= base_url('homepage/add'); ?>" method="post">
                <?= csrf_field(); ?>
                <input type="hidden" name="id" value="<?= $produk['Produk_id']; ?>">
                <input type="hidden" name="name" value="<?= $produk['nama_produk']; ?>">
                <input type="hidden" name="price" value="<?= $produk['harga']; ?>">
                <input type="hidden" name="gambar" value="<?= $produk['gambar']; ?>">
                <input type="hidden" name="berat" value="<?= $produk['Berat'] ?? 0; ?>">
                <input type="hidden" name="qty" value="1">
                <button type="submit" class="btn btn-dark mt-4 w-100">Add to Cart</button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
