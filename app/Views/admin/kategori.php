<?= $this->extend('admin/templates/index'); ?>

<?= $this->section('content-admin'); ?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="flash-messages">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle mr-2"></i>
                <?= session()->getFlashdata('success'); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <?= session()->getFlashdata('error'); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>
    </div>
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Kelola Kategori Produk</h1>
    <!-- Tombol Tambah Kategori -->
    <a href="<?= base_url('/admin/kategori/create'); ?>" class="btn btn-primary mb-3">Tambah Kategori</a>

    <!-- Tabel Kategori -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Kategori</h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($kategori)): ?>
                        <?php foreach ($kategori as $key => $item): ?>
                            <tr>
                                <td><?= $item['Kategori_id']; ?></td>
                                <td><?= esc($item['nama_kategori']); ?></td>
                                <td>
                                    <a href="<?= base_url('/admin/kategori/edit/' . $item['Kategori_id']); ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="<?= base_url('/admin/kategori/delete/' . $item['Kategori_id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus kategori ini?')">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center">Tidak ada kategori yang tersedia.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<style>
.flash-messages {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 1050;
    max-width: 350px;
}

.alert {
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    border: 1px solid transparent;
    margin-bottom: 1rem;
}

.alert-dismissible .close {
    position: absolute;
    top: 0;
    right: 0;
    padding: 0.75rem 1.25rem;
    color: inherit;
}

.fade {
    transition: opacity 0.15s linear;
}

.alert.fade {
    opacity: 0;
    transition: opacity 0.3s ease-in-out;
}

.alert.show {
    opacity: 1;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-dismiss alerts after 5 seconds
    setTimeout(function() {
        let alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            let closeButton = alert.querySelector('.close');
            if (closeButton) {
                closeButton.click();
            }
        });
    }, 5000);
});
</script>
<!-- /.container-fluid -->
<?= $this->endSection(); ?>