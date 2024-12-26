<?= $this->extend('admin/templates/index'); ?>

<?= $this->section('content-admin'); ?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Daftar Transaksi</h1>

    <!-- Tabel Transaksi -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Transaksi yang Diperoleh</h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID Pembelian</th>
                        <th>Tanggal</th>
                        <th>Nama Pengguna</th> <!-- Nama kolom yang benar -->
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($transaksi as $item): ?>
                        <tr>
                            <td><?= $item['Pembelian_id']; ?></td>
                            <td><?= $item['tanggal']; ?></td>
                            <td><?= esc($item['username']); ?></td> <!-- Menampilkan fullname -->
                            <td><?= $item['status']; ?></td>
                            <td>
                                <a href="/admin/transaksi/detail/<?= $item['Pembelian_id']; ?>" class="btn btn-info btn-sm">Detail</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>
</div>
<!-- /.container-fluid -->
<?= $this->endSection(); ?>