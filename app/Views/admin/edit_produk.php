<?= $this->extend('admin/templates/index'); ?>

<?= $this->section('content-admin'); ?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Edit Produk</h1>

    <!-- Form Edit Produk -->
    <form action="/admin/produk/update/<?= $produk['Produk_id']; ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field(); ?>

        <!-- Produk Data -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="m-0">Data Produk</h5>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="Kode_produk">Kode Produk</label>
                    <input type="text" name="Kode_produk" id="Kode_produk" class="form-control" value="<?= old('Kode_produk', $produk['Kode_produk']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="nama_produk">Nama Produk</label>
                    <input type="text" name="nama_produk" id="nama_produk" class="form-control" value="<?= old('nama_produk', $produk['nama_produk']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="Kategori_id">Kategori</label>
                    <select name="Kategori_id" id="Kategori_id" class="form-control">
                        <?php foreach ($kategori as $kat): ?>
                            <option value="<?= $kat['Kategori_id']; ?>" <?= $kat['Kategori_id'] == $produk['Kategori_id'] ? 'selected' : ''; ?>><?= $kat['nama_kategori']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="harga">Harga</label>
                    <input type="number" name="harga" id="harga" class="form-control" value="<?= old('harga', $produk['harga']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="Berat">Berat</label>
                    <input type="number" step="any" name="Berat" id="Berat" class="form-control" value="<?= old('Berat', $produk['Berat']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="Deskripsi">Deskripsi</label>
                    <textarea name="Deskripsi" id="Deskripsi" class="form-control"><?= old('Deskripsi', $produk['Deskripsi']); ?></textarea>
                </div>

                <div class="form-group">
                    <label for="gambar">Gambar Produk</label>
                    <input type="file" name="gambar" id="gambar" class="form-control">
                    <img src="<?= base_url('uploads/produk/' . $produk['gambar']); ?>" alt="Gambar Produk" width="100" class="mt-2">
                    <input type="hidden" name="old_gambar" value="<?= $produk['gambar']; ?>">
                </div>
            </div>
        </div>

        <!-- Metadata Section -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="m-0">Metadata Produk</h5>
                <button type="button" class="btn btn-sm btn-success" onclick="addMetadataField()">Tambah Metadata</button>
            </div>
            <div class="card-body">
                <div id="metadata-container">
                    <?php foreach ($metadata as $index => $meta): ?>
                        <div class="metadata-item border p-3 mb-3">
                            <input type="hidden" name="metadata[<?= $index ?>][Metadata_id]" value="<?= $meta['Metadata_id'] ?>">

                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label>Warna</label>
                                    <input type="text" name="metadata[<?= $index ?>][Warna]" class="form-control" value="<?= $meta['Warna'] ?>" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Ukuran</label>
                                    <input type="text" name="metadata[<?= $index ?>][Ukuran]" class="form-control" value="<?= $meta['Ukuran'] ?>" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Stok</label>
                                    <input type="number" name="metadata[<?= $index ?>][Stok]" class="form-control" value="<?= $meta['Stok'] ?>" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Harga</label>
                                    <input type="number" name="metadata[<?= $index ?>][Harga]" class="form-control" value="<?= $meta['Harga'] ?>" required>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Gambar Metadata</label>
                                    <input type="file" name="meta_gambar_<?= $index ?>" class="form-control">
                                    <?php if ($meta['meta_gambar']): ?>
                                        <img src="<?= base_url('uploads/metadata/' . $meta['meta_gambar']); ?>" alt="Metadata Gambar" width="100" class="mt-2">
                                    <?php endif; ?>
                                    <input type="hidden" name="metadata[<?= $index ?>][old_meta_gambar]" value="<?= $meta['meta_gambar'] ?>">
                                </div>
                            </div>
                            <!-- Ganti button hapus yang lama dengan dua button baru -->
                            <div class="btn-group">
                                <?php if (isset($meta['Metadata_id'])): ?>
                                    <!-- Tombol untuk metadata yang sudah ada di database -->
                                    <button type="button" class="btn btn-danger btn-sm" onclick="deleteMetadataFromDB(this, <?= $meta['Metadata_id'] ?>)">Hapus dari DB</button>
                                <?php else: ?>
                                    <!-- Tombol untuk metadata yang baru ditambahkan -->
                                    <button type="button" class="btn btn-warning btn-sm" onclick="removeMetadataField(this)">Hapus Field</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Perbarui Produk</button>
        <a href="/admin/produk" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<script>
    // Tambahkan setelah tag <script> dan sebelum fungsi-fungsi lainnya
    const csrfToken = document.querySelector('meta[name="X-CSRF-TOKEN"]').content;
    let metadataIndex = <?= count($metadata) ?>; // Dimulai dari jumlah metadata yang sudah ada


    // Fungsi untuk menghapus metadata dari database
    function deleteMetadataFromDB(button, metadataId) {
        const metadataItem = button.closest('.metadata-item');

        if (confirm('Apakah Anda yakin ingin menghapus metadata ini dari database?')) {
            fetch(`/admin/metadata/delete/${metadataId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'same-origin'
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        metadataItem.remove();
                        alert(data.message);
                    } else {
                        alert('Gagal menghapus metadata: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menghapus metadata');
                });
        }
    }

    // Fungsi untuk menghapus field metadata yang belum disimpan
    function removeMetadataField(button) {
        if (confirm('Apakah Anda yakin ingin menghapus field metadata ini?')) {
            const metadataItem = button.closest('.metadata-item');
            metadataItem.remove();
        }
    }

    // Update fungsi addMetadataField untuk menggunakan tombol yang sesuai
    function addMetadataField() {
        const container = document.getElementById('metadata-container');
        const newMetadata = `
        <div class="metadata-item border p-3 mb-3">
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label>Warna</label>
                    <input type="text" name="metadata[${metadataIndex}][Warna]" class="form-control" required>
                </div>
                <div class="form-group col-md-3">
                    <label>Ukuran</label>
                    <input type="text" name="metadata[${metadataIndex}][Ukuran]" class="form-control" required>
                </div>
                <div class="form-group col-md-2">
                    <label>Stok</label>
                    <input type="number" name="metadata[${metadataIndex}][Stok]" class="form-control" required>
                </div>
                <div class="form-group col-md-3">
                    <label>Harga</label>
                    <input type="number" name="metadata[${metadataIndex}][Harga]" class="form-control" required>
                </div>
                <div class="form-group col-md-12">
                    <label>Gambar Metadata</label>
                    <input type="file" name="meta_gambar_${metadataIndex}" class="form-control">
                </div>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-warning btn-sm" onclick="removeMetadataField(this)">Hapus Field</button>
            </div>
        </div>
    `;
        container.insertAdjacentHTML('beforeend', newMetadata);
        metadataIndex++;
    }
</script>
<?= $this->endSection(); ?>