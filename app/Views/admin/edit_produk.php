<?= $this->extend('admin/templates/index'); ?>

<?= $this->section('content-admin'); ?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-primary"><i class="fas fa-edit"></i> Edit Produk</h1>

    <form action="/admin/produk/update/<?= $produk['Produk_id']; ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field(); ?>

        <!-- Informasi Produk -->
        <div class="row">
            <div class="col-md-6">
                <div class="card shadow-sm p-3">
                    <h5 class="text-secondary"><i class="fas fa-info-circle"></i> Informasi Produk</h5>
                    <div class="form-group">
                        <label for="Kode_produk"><i class="fas fa-barcode"></i> Kode Produk</label>
                        <input type="text" name="Kode_produk" id="Kode_produk" class="form-control" value="<?= old('Kode_produk', $produk['Kode_produk']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_produk"><i class="fas fa-tag"></i> Nama Produk</label>
                        <input type="text" name="nama_produk" id="nama_produk" class="form-control" value="<?= old('nama_produk', $produk['nama_produk']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="Kategori_id"><i class="fas fa-list"></i> Kategori</label>
                        <select name="Kategori_id" id="Kategori_id" class="form-control">
                            <?php foreach ($kategori as $kat): ?>
                                <option value="<?= $kat['Kategori_id']; ?>" <?= $kat['Kategori_id'] == $produk['Kategori_id'] ? 'selected' : ''; ?>><?= $kat['nama_kategori']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Harga & Stok -->
            <div class="col-md-6">
                <div class="card shadow-sm p-3">
                    <h5 class="text-secondary"><i class="fas fa-box"></i> Harga & Stok</h5>
                    <div class="form-group">
                        <label for="harga"><i class="fas fa-dollar-sign"></i> Harga</label>
                        <input type="number" name="harga" id="harga" class="form-control" value="<?= old('harga', $produk['harga']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="Berat"><i class="fas fa-weight"></i> Berat</label>
                        <input type="number" step="any" name="Berat" id="Berat" class="form-control" value="<?= old('Berat', $produk['Berat']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="stok"><i class="fas fa-layer-group"></i> Stok</label>
                        <input type="number" name="stok" id="stok" class="form-control" value="<?= $produk['stok']; ?>" required>
                    </div>
                </div>
            </div>
        </div>

        <!-- Deskripsi & Gambar -->
        <div class="card shadow-sm mt-4 p-3">
            <h5 class="text-secondary"><i class="fas fa-align-left"></i> Deskripsi Produk</h5>
            <div class="form-group">
                <textarea name="Deskripsi" id="Deskripsi" class="form-control"><?= old('Deskripsi', $produk['Deskripsi']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="gambar"><i class="fas fa-image"></i> Gambar Produk</label>
                <input type="file" name="gambar" id="gambar" class="form-control">
                <img src="<?= base_url('uploads/produk/' . $produk['gambar']); ?>" alt="Gambar Produk" width="100" class="mt-2">
                <input type="hidden" name="old_gambar" value="<?= $produk['gambar']; ?>">
            </div>
        </div>

        <!-- Metadata -->
        <div class="card shadow-sm mt-4 p-3">
            <h5 class="text-secondary"><i class="fas fa-tags"></i> Metadata Produk</h5>
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
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="btn btn-outline-secondary mt-2" onclick="addMetadataField()"><i class="fas fa-plus"></i> Tambah Metadata</button>
        </div>

        <!-- Tombol Aksi -->
        <div class="mt-4">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Perbarui Produk</button>
            <a href="/admin/produk" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
        </div>
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