<?= $this->extend('admin/templates/index'); ?>
<!-- acc -->
<?= $this->section('content-admin'); ?>
<div class="container-fluid">

    <h1 class="h3 mb-4 text-primary">Tambah Produk</h1>

    <form action="/admin/produk/save" method="POST" enctype="multipart/form-data">
        <?= csrf_field(); ?>

        <div class="row">
            <!-- Informasi Produk -->
            <div class="col-md-6">
                <div class="card shadow-sm p-3">
                    <h5 class="text-secondary">Informasi Produk</h5>
                    <div class="form-group">
                        <label for="Kode_produk"><i class="fas fa-barcode"></i> Kode Produk</label>
                        <input type="text" class="form-control" id="Kode_produk" name="Kode_produk" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_produk"><i class="fas fa-tag"></i> Nama Produk</label>
                        <input type="text" class="form-control" id="nama_produk" name="nama_produk" required>
                    </div>
                    <div class="form-group">
                        <label for="Kategori_id"><i class="fas fa-list"></i> Kategori</label>
                        <select class="form-control" id="Kategori_id" name="Kategori_id" required>
                            <?php foreach ($kategori as $item): ?>
                                <option value="<?= $item['Kategori_id']; ?>"><?= $item['nama_kategori']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="id_suppl"><i class="fas fa-truck"></i> Supplier</label>
                        <select class="form-control" id="id_suppl" name="id_suppl" required>
                            <?php foreach ($supplier as $item): ?>
                                <option value="<?= $item['id_suppl']; ?>"><?= $item['nama_suppl']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Harga dan Stok -->
            <div class="col-md-6">
                <div class="card shadow-sm p-3">
                    <h5 class="text-secondary">Harga & Stok</h5>
                    <div class="form-group">
                        <label for="harga"><i class="fas fa-dollar-sign"></i> Harga Dasar</label>
                        <input type="number" class="form-control" id="harga" name="harga" required>
                    </div>
                    <div class="form-group">
                        <label for="Berat"><i class="fas fa-weight"></i> Berat (kg)</label>
                        <input type="number" class="form-control" id="Berat" name="Berat" step="any" required>
                    </div>
                    <div class="form-group">
                        <label for="stok"><i class="fas fa-box"></i> Stok</label>
                        <input type="number" class="form-control" id="stok" name="stok" required>
                    </div>
                    <div class="form-group">
                        <label for="gambar"><i class="fas fa-image"></i> Gambar Produk</label>
                        <input type="file" class="form-control-file" id="gambar" name="gambar" required>
                    </div>
                </div>
            </div>
        </div>

        <!-- Deskripsi -->
        <div class="card shadow-sm mt-4 p-3">
            <h5 class="text-secondary">Deskripsi</h5>
            <div class="form-group">
                <label for="Deskripsi"><i class="fas fa-align-left"></i> Deskripsi Produk</label>
                <textarea class="form-control" id="Deskripsi" name="Deskripsi"></textarea>
            </div>
        </div>

        <!-- Metadata -->
        <div class="card shadow-sm mt-4 p-3">
            <h5 class="text-secondary">Metadata (Opsional)</h5>
            <div id="metadata-container"></div>
            <button type="button" id="add-metadata" class="btn btn-outline-secondary mt-2"><i class="fas fa-plus"></i> Tambah Metadata</button>
        </div>

        <!-- Submit -->
        <div class="mt-4">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
            <a href="/admin/produk" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
        </div>
    </form>
</div>


<script>
    // JavaScript untuk menambahkan/menghapus metadata
    let metadataIndex = 0;
    const container = document.getElementById('metadata-container');

    // Menambahkan form metadata
    document.getElementById('add-metadata').addEventListener('click', () => {
        metadataIndex++;
        const metadataForm = `
    <div class="card mt-3 p-3" id="metadata-${metadataIndex}">
        <button type="button" class="btn btn-danger btn-sm mb-2 remove-metadata" data-index="${metadataIndex}">Hapus Metadata</button>
        <div class="form-group">
            <label for="Warna-${metadataIndex}">Warna</label>
            <input type="text" class="form-control" name="metadata[${metadataIndex}][Warna]" id="Warna-${metadataIndex}">
        </div>
        <div class="form-group">
            <label for="Ukuran-${metadataIndex}">Ukuran</label>
            <input type="text" class="form-control" name="metadata[${metadataIndex}][Ukuran]" id="Ukuran-${metadataIndex}">
        </div>
        <div class="form-group">
            <label for="Stok-${metadataIndex}">Stok</label>
            <input type="number" class="form-control" name="metadata[${metadataIndex}][Stok]" id="Stok-${metadataIndex}">
        </div>
        <div class="form-group">
            <label for="Harga-${metadataIndex}">Harga</label>
            <input type="number" class="form-control" name="metadata[${metadataIndex}][Harga]" id="Harga-${metadataIndex}" step="0.01">
        </div>
        <div class="form-group">
            <label for="meta_gambar-${metadataIndex}">Gambar Metadata</label>
            <input type="file" class="form-control" name="meta_gambar_${metadataIndex}" id="meta_gambar-${metadataIndex}">
        </div>
    </div>`;
        container.insertAdjacentHTML('beforeend', metadataForm);
    });

    // Menghapus form metadata
    container.addEventListener('click', (e) => {
        if (e.target.classList.contains('remove-metadata')) {
            const index = e.target.dataset.index;
            document.getElementById(`metadata-${index}`).remove();
        }
    });
</script>

<?= $this->endSection(); ?>