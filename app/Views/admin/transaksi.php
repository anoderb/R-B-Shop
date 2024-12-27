<?= $this->extend('admin/templates/index'); ?>

<?= $this->section('content-admin'); ?>
<div class="container-fluid">
    <h1>Data Order</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row align-items-center">
                <div class="col">
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-outline-secondary active">Konfirmasi</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary">Lunas</button>
                    </div>
                </div>
                <div class="col">
                    <div class="btn-group">
                        <button class="btn btn-secondary btn-sm" onclick="copyToClipboard()">Copy</button>
                        <a href="<?= base_url('admin/transaksi/export-csv') ?>" class="btn btn-secondary btn-sm">CSV</a>
                        <a href="<?= base_url('admin/transaksi/export-excel') ?>" class="btn btn-secondary btn-sm">Excel</a>
                        <a href="<?= base_url('admin/transaksi/export-pdf') ?>" class="btn btn-secondary btn-sm">PDF</a>
                        <button class="btn btn-secondary btn-sm" onclick="window.print()">Print</button>
                    </div>
                </div>
                <div class="mb-3">
                <form action="" method="get" class="form-inline float-right">
                    <label>Search: </label>
                    <input type="text" class="form-control form-control-sm ml-2" name="keyword" value="<?= esc($keyword ?? '') ?>">
                </form>
            </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Transaction ID</th>
                            <th>Tanggal</th>
                            <th>Item</th>
                            <th>Total Jual</th>
                            <th>Kurir</th>
                            <th>Grand Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($transaksi as $item): ?>
                            <tr>
                                <td><?= $item['transaction_id'] ?? 'N/A'; ?></td>
                                <td><?= date('d-m-Y', strtotime($item['tanggal'])); ?></td>
                                <td>
                                    • <?= $item['total_items'] ?? 1 ?> Item<br>
                                    Rp <?= number_format($item['grand_total'], 0, ',', '.'); ?>
                                </td>
                                <td>Rp <?= number_format($item['grand_total'], 0, ',', '.'); ?></td>
                                <td><?= $item['nama_kurir'] ?? 'N/A'; ?> Rp<?= number_format($item['ongkos_kirim'] ?? 0, 0, ',', '.'); ?></td>
                                <td>Rp <?= number_format($item['grand_total'], 0, ',', '.'); ?></td>
                                <td>
                                    <a href="/admin/transaksi/detail/<?= $item['Pembelian_id']; ?>" class="btn btn-danger btn-sm">Detail</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    Showing 1 to <?= count($transaksi) ?> of <?= $pager->getTotal() ?> entries
                </div>
                <div>
                    <?= $pager->links('default', 'bootstrap_pagination') ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>