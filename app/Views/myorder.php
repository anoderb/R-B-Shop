<?= $this->extend('/templates/index'); ?>

<?= $this->section('content-user'); ?>

<div class="container my-5">
    <h2 class="mb-4">My Orders</h2>
    <div class="row">

        <!-- Current Orders -->
        <div class="col-md-6">
            <h4>Current Orders</h4>
            <?php foreach ($orders as $order): ?>
                <?php if ($order['status'] === 'pending' || $order['status'] === 'shipped'): ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Order #<?= $order['Pembelian_id']; ?></h5>
                            <p class="card-text">Status: <span class="badge <?= $order['status'] === 'pending' ? 'bg-warning text-dark' : 'bg-secondary'; ?>">
                                    <?= ucfirst($order['status']); ?>
                                </span></p>
                            <p class="card-text">Items:</p>
                            <ul>
                                <?php foreach ($order['details'] as $item): ?>
                                    <li><?= $item['nama_produk']; ?> - <?= $item['qty']; ?> pcs</li>
                                <?php endforeach; ?>
                            </ul>
                            <p class="card-text"><strong>Total: Rp<?= number_format($order['total_harga'], 0, ',', '.'); ?></strong></p>
                            <?php if ($order['status'] === 'pending'): ?>
                                <form action="/checkout/update-status/<?= $order['Pembelian_id']; ?>/cancelled" method="post">
                                    <button class="btn btn-danger btn-sm">Cancel Order</i></button>
                                </form>
                            <?php endif; ?>
                            <?php if ($order['status'] === 'shipped'): ?>
                                <form action="/checkout/update-status/<?= $order['Pembelian_id']; ?>/completed" method="post" class="mt-2">
                                    <button class="btn btn-success btn-sm">Complete Order</i></button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <!-- Order History -->
        <div class="col-md-6">
            <h4>Order History</h4>
            <?php foreach ($orders as $order): ?>
                <?php if (in_array($order['status'], ['success', 'cancelled', 'completed'])): ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Order #<?= $order['Pembelian_id']; ?></h5>
                            <p class="card-text">Status:
                                <span class="badge <?= $order['status'] === 'success' || $order['status'] === 'completed' ? 'bg-success' : 'bg-danger'; ?>">
                                    <?= $order['status'] === 'success' || $order['status'] === 'completed' ? 'Successfully Delivered' : 'Cancelled'; ?>
                                </span>
                            </p>
                            <p class="card-text">Items:</p>
                            <ul>
                                <?php foreach ($order['details'] as $item): ?>
                                    <li><?= $item['nama_produk']; ?> - <?= $item['qty']; ?> pcs</li>
                                <?php endforeach; ?>
                            </ul>

                            <p class="card-text"><strong>Total: Rp<?= number_format($order['total_harga'], 0, ',', '.'); ?></strong></p>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>