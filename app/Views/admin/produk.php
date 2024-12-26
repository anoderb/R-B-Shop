<?= $this->extend('admin/templates/index'); ?>
<?= $this->section('content-admin'); ?>
<div class="container-fluid">
    <h1>Semua Produk</h1>

    <a href="/admin/produk/tambah" class="btn btn-primary mb-3" id="tambah-produk">+ Tambah Produk</a>

    <div class="mb-3">
        <div class="btn-group">
            <button class="btn btn-secondary btn-sm" onclick="copyToClipboard()">Copy</button>
            <a href="<?= base_url('admin/produk/export-csv') ?>" class="btn btn-secondary btn-sm">CSV</a>
            <a href="<?= base_url('admin/produk/export-excel') ?>" class="btn btn-secondary btn-sm">Excel</a>
            <a href="<?= base_url('admin/produk/export-pdf') ?>" class="btn btn-secondary btn-sm">PDF</a>
            <button class="btn btn-secondary btn-sm" onclick="window.print()">Print</button>
        </div>

        <div class="float-right">
            <form action="" method="get" class="form-inline">
                <label>Search: </label>
                <input type="text" class="form-control form-control-sm ml-2" name="keyword" value="<?= esc($keyword) ?>">
            </form>
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Nama Produk <i class="fas fa-sort"></i></th>
                <th>Supplier <i class="fas fa-sort"></i></th>
                <th>Metadata <i class="fas fa-sort"></i></th>
                <th>Harga <i class="fas fa-sort"></i></th>
                <th>Stok <i class="fas fa-sort"></i></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($produk)): ?>
                <?php foreach ($produk as $item): ?>
                    <tr>
                        <td><?= $item['nama_produk']; ?></td>
                        <td><?= $item['nama_suppl']; ?></td>
                        <td>
                            <!-- Metadata dalam format bullet points -->
                            <ul class="list-unstyled mb-0">
                                <li>• Kategori: <?= $item['nama_kategori'] ?? 'Kategori Produk'; ?></li>
                                <li>• Merek: <?= $item['nama_kategori'] ?? 'Kategori Produk'; ?></li>
                                <li>• Berat <?= $item['Berat'] ?? '0'; ?> Gram</li>
                            </ul>
                        </td>
                        <td>Rp <?= number_format($item['harga'], 0, ',', '.'); ?></td>
                        <td><?= $item['stok'] ?? '0'; ?></td>
                        <td>
                            <a href="/admin/produk/detail/<?= $item['Produk_id']; ?>" class="btn btn-info btn-sm">Detail</a>
                            <a href="/admin/produk/edit/<?= $item['Produk_id']; ?>" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                            <a href="/admin/produk/delete/<?= $item['Produk_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus produk ini?')"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">Tidak ada produk yang tersedia.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="d-flex justify-content-between align-items-center mt-3">
        <div>
            Showing 1 to 5 of 6 entries
        </div>
        <div>
            <?= $pager->links('default', 'bootstrap_pagination'); ?>
        </div>
    </div>
</div>

<style>
    .table th i.fas.fa-sort {
        float: right;
        margin-top: 4px;
    }

    .table td ul {
        margin-left: 0;
        padding-left: 0;
    }

    .btn-group .btn {
        margin-right: 2px;
    }
</style>
<script>
    function copyToClipboard() {
        var table = document.querySelector('table');
        var range = document.createRange();
        range.selectNode(table);
        window.getSelection().removeAllRanges();
        window.getSelection().addRange(range);
        document.execCommand('copy');
        window.getSelection().removeAllRanges();
        alert('Tabel berhasil disalin ke clipboard!');
    }
</script>

<style>
    /* Style untuk print */
    @media print {

        .btn-group,
        .navbar,
        .footer,
        .no-print {
            display: none !important;
        }

        table {
            width: 100%;
        }
    }
</style>
<?= $this->endSection(); ?>