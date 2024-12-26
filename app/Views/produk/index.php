<?= $this->extend('templates/index'); ?>

<?= $this->section('content'); ?>

<div class="text-center mb-5">
    <h2 class="fw-bold">NEW ARRIVALS</h2>
</div>

<!-- Product Cards -->
<div class="row g-4">
    <?php foreach ($produk as $item): ?>
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 shadow-sm">
            <!-- Menampilkan gambar produk -->
            <img src="<?= base_url('uploads/produk/' . $item['gambar']); ?>" class="card-img-top" alt="<?= esc($item['nama_produk']); ?>">
            <div class="card-body text-center">
                <h5 class="card-title"><?= esc($item['nama_produk']); ?></h5>
                <p class="card-text">
                    <span class="fw-bold">Rp <?= number_format($item['harga'], 0, ',', '.'); ?></span>
                    <br />
                    <!-- Deskripsi singkat produk -->
                    <small class="text-muted"><?= esc($item['Deskripsi']); ?></small>
                </p>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?= $this->endSection(); ?>
