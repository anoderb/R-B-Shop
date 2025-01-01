<?= $this->extend('admin/templates/index'); ?>
<?= $this->section('content-admin'); ?>
<div class="container-fluid">

    <!-- Flash Message -->
    <div class="alert-container">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="custom-alert alert-success">
                <div class="alert-content">
                    <i class="fas fa-check-circle alert-icon"></i>
                    <span class="alert-message"><?= session()->getFlashdata('success') ?></span>
                </div>
                <button class="alert-close">×</button>
            </div>
        <?php endif; ?>
    </div>

    <!-- Page Heading -->   
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

    .alert-container {
        position: fixed;
        top: 80px;
        /* Adjust this value based on your navbar height */
        right: 2rem;
        z-index: 1000;
        max-width: 400px;
    }

    /* Rest of your existing alert styles remain the same */
    .custom-alert {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem 1.5rem;
        border-radius: 12px;
        background: #fff;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        margin-bottom: 1rem;
        animation: slideIn 0.3s ease-out;
    }

    .alert-content {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .alert-icon {
        font-size: 1.25rem;
        color: #10b981;
    }

    .alert-message {
        color: #1f2937;
        font-size: 0.95rem;
    }

    .alert-close {
        background: none;
        border: none;
        color: #9ca3af;
        font-size: 1.5rem;
        cursor: pointer;
        padding: 0 0.5rem;
        line-height: 1;
    }

    .alert-close:hover {
        color: #4b5563;
    }

    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }

        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }

        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }

    .alert-hiding {
        animation: slideOut 0.3s ease-in forwards;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const alerts = document.querySelectorAll('.custom-alert');

        alerts.forEach(alert => {
            // Close button functionality
            const closeBtn = alert.querySelector('.alert-close');
            closeBtn.addEventListener('click', () => {
                alert.classList.add('alert-hiding');
                setTimeout(() => alert.remove(), 300);
            });

            // Auto-dismiss after 5 seconds
            setTimeout(() => {
                if (alert && document.body.contains(alert)) {
                    alert.classList.add('alert-hiding');
                    setTimeout(() => alert.remove(), 300);
                }
            }, 5000);
        });
    });
</script>
<?= $this->endSection(); ?>