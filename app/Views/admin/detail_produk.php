<?= $this->extend('admin/templates/index'); ?>

<?= $this->section('content-admin'); ?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Detail Produk</h1>

    <!-- Detail Produk -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary text-white">
            <h6 class="m-0 font-weight-bold">Detail Produk: <?= esc($produk['nama_produk']); ?></h6>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Gambar Produk -->
                <div class="col-md-4 text-center">
                    <img src="<?= base_url('/uploads/produk/' . esc($produk['gambar'])); ?>" 
                         class="img-fluid rounded shadow-sm mb-3" 
                         alt="<?= esc($produk['nama_produk']); ?>">
                </div>

                <!-- Informasi Produk -->
                <div class="col-md-8">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th class="bg-light">Kode Produk</th>
                                <td><?= esc($produk['Kode_produk']); ?></td>
                            </tr>
                            <tr>
                                <th class="bg-light">Nama Produk</th>
                                <td><?= esc($produk['nama_produk']); ?></td>
                            </tr>
                            <tr>
                                <th class="bg-light">Kategori</th>
                                <td>
                                    <?php
                                    $kategoriModel = new \App\Models\ProdukKategoriModel();
                                    $kategori = $kategoriModel->find($produk['Kategori_id']);
                                    echo esc($kategori['nama_kategori']);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-light">Harga</th>
                                <td>Rp <?= number_format($produk['harga'], 0, ',', '.'); ?></td>
                            </tr>
                            <tr>
                                <th class="bg-light">Berat</th>
                                <td><?= esc($produk['Berat']); ?> kg</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Deskripsi</th>
                                <td><?= nl2br(esc($produk['Deskripsi'])); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Metadata Produk -->
            <?php if (!empty($metadata)): ?>
                <div class="mt-4">
                    <h5 class="text-primary">Metadata</h5>
                    <table class="table table-striped table-bordered mt-2">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Warna</th>
                                <th>Ukuran</th>
                                <th>Stok</th>
                                <th>Harga</th>
                                <th>Gambar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($metadata as $key => $meta): ?>
                                <tr>
                                    <td><?= $key + 1; ?></td>
                                    <td><?= esc($meta['Warna']); ?></td>
                                    <td><?= esc($meta['Ukuran']); ?></td>
                                    <td><?= esc($meta['Stok']); ?></td>
                                    <td>Rp <?= number_format(esc($meta['Harga']), 0, ',', '.'); ?></td>
                                    <td class="text-center">
                                        <?php if (!empty($meta['meta_gambar'])): ?>
                                            <img src="<?= base_url('/uploads/metadata/' . esc($meta['meta_gambar'])); ?>" 
                                                 alt="Metadata Image" 
                                                 class="img-thumbnail shadow-sm" 
                                                 style="max-width: 100px;">
                                        <?php else: ?>
                                            <span class="text-muted">Tidak ada gambar</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info mt-4">Tidak ada metadata yang ditambahkan untuk produk ini.</div>
            <?php endif; ?>

            <!-- Tombol Kembali -->
            <div class="text-right mt-4">
                <a href="/admin/produk" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
<?= $this->endSection(); ?>
