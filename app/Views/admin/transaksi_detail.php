<?= $this->extend('admin/templates/index'); ?>

<?= $this->section('content-admin'); ?>
<div class="container-fluid">
    <h1>Detail Transaksi</h1>

    <div class="card shadow mb-4">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">Informasi Transaksi</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td>Transaction ID</td>
                            <td>: <?= $transaksi['transaction_id'] ?? 'N/A' ?></td>
                        </tr>
                        <tr>
                            <td>Tanggal</td>
                            <td>: <?= date('d-m-Y', strtotime($transaksi['tanggal'])) ?></td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>: <?= $transaksi['status'] ?></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td>Kurir</td>
                            <td>: <?= $transaksi['nama_kurir'] ?? 'N/A' ?></td>
                        </tr>
                        <tr>
                            <td>Ongkos Kirim</td>
                            <td>: Rp<?= number_format($transaksi['ongkos_kirim'] ?? 0, 0, ',', '.') ?></td>
                        </tr>
                        <tr>
                            <td>Total Pembayaran</td>
                            <td>: Rp<?= number_format($transaksi['grand_total'], 0, ',', '.') ?></td>
                        </tr>
                    </table>
                </div>
            </div>

            <h6 class="font-weight-bold mt-4">Detail Produk</h6>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($detail_produk as $detail): ?>
                        <tr>
                            <td><?= $detail['nama_produk'] ?></td>
                            <td>Rp<?= number_format($detail['harga'], 0, ',', '.') ?></td>
                            <td><?= $detail['qty'] ?></td>
                            <td>Rp<?= number_format($detail['harga'] * $detail['qty'], 0, ',', '.') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php if ($transaksi['status'] === 'completed'): ?>
                <div class="mt-3">
                    <form action="<?= base_url('admin/transaksi/ship/' . $transaksi['Pembelian_id']) ?>" method="post" class="d-inline">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-shipping-fast"></i> Ship Order
                        </button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>