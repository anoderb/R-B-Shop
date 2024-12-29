<?= $this->extend('/templates/index'); ?>

<?= $this->section('content-user'); ?>

<div class="orders-container">
    <div class="container py-5">
        <h2 class="section-title mb-4">My Orders</h2>
        <div class="row g-4">
            <!-- Current Orders -->
            <div class="col-md-6">
                <div class="orders-section">
                    <div class="section-header">
                        <h4>Current Orders</h4>
                        <span class="line"></span>
                    </div>
                    <?php 
                    $hasCurrentOrders = false; 
                    foreach ($orders as $order): 
                        if (in_array($order['status'], ['completed', 'pending', 'shipped'])): 
                            $hasCurrentOrders = true; 
                    ?>
                        <div class="order-card">
                            <div class="order-header">
                                <h5>Order #<?= $order['Pembelian_id']; ?></h5>
                                <?php
                                $statusClass = 'status-pending';
                                $statusText = ucfirst($order['status']);
                                
                                switch ($order['status']) {
                                    case 'completed':
                                        $statusClass = 'status-success';
                                        $statusText = 'Success Payment';
                                        break;
                                    case 'shipped':
                                        $statusClass = 'status-shipped';
                                        break;
                                }
                                ?>
                                <span class="status-badge <?= $statusClass ?>">
                                    <?= $statusText ?>
                                </span>
                            </div>
                            
                            <?php if ($order['status'] === 'completed'): ?>
                                <div class="status-message">
                                    <i class="fas fa-clock"></i>
                                    <span>Waiting for shipment</span>
                                </div>
                            <?php endif; ?>

                            <div class="order-items">
                                <h6>Items</h6>
                                <ul>
                                    <?php foreach ($order['details'] as $item): ?>
                                        <li>
                                            <span class="item-name"><?= $item['nama_produk']; ?></span>
                                            <span class="item-qty"><?= $item['qty']; ?> pcs</span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>

                            <div class="order-footer">
                                <div class="order-total">
                                    <span>Total Amount</span>
                                    <strong>Rp<?= number_format($order['total_harga'], 0, ',', '.'); ?></strong>
                                </div>

                                <?php if ($order['status'] === 'pending'): ?>
                                    <form action="/checkout/update-status/<?= $order['Pembelian_id']; ?>/cancelled" method="post">
                                        <button class="btn-cancel">Cancel Order</button>
                                    </form>
                                <?php endif; ?>

                                <?php if ($order['status'] === 'shipped'): ?>
                                    <form action="/checkout/update-status/<?= $order['Pembelian_id']; ?>/delivered" method="post">
                                        <button class="btn-delivered">Mark as Delivered</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php 
                        endif; 
                    endforeach; 
                    ?>

                    <?php if (!$hasCurrentOrders): ?>
                        <div class="empty-state">
                            <i class="fas fa-box-open"></i>
                            <p>No current orders available</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Order History -->
            <div class="col-md-6">
                <div class="orders-section">
                    <div class="section-header">
                        <h4>Order History</h4>
                        <span class="line"></span>
                    </div>
                    <?php 
                    $hasOrderHistory = false; 
                    foreach ($orders as $order): 
                        if (in_array($order['status'], ['failed', 'delivered'])): 
                            $hasOrderHistory = true; 
                    ?>
                        <div class="order-card">
                            <div class="order-header">
                                <h5>Order #<?= $order['Pembelian_id']; ?></h5>
                                <?php
                                $statusClass = 'status-cancelled';
                                $statusText = 'Cancelled';

                                if ($order['status'] === 'delivered') {
                                    $statusClass = 'status-delivered';
                                    $statusText = 'Delivered';
                                }
                                ?>
                                <span class="status-badge <?= $statusClass ?>">
                                    <?= $statusText ?>
                                </span>
                            </div>

                            <div class="order-items">
                                <h6>Items</h6>
                                <ul>
                                    <?php foreach ($order['details'] as $item): ?>
                                        <li>
                                            <span class="item-name"><?= $item['nama_produk']; ?></span>
                                            <span class="item-qty"><?= $item['qty']; ?> pcs</span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>

                            <div class="order-footer">
                                <div class="order-total">
                                    <span>Total Amount</span>
                                    <strong>Rp<?= number_format($order['total_harga'], 0, ',', '.'); ?></strong>
                                </div>
                            </div>
                        </div>
                    <?php 
                        endif; 
                    endforeach; 
                    ?>

                    <?php if (!$hasOrderHistory): ?>
                        <div class="empty-state">
                            <i class="fas fa-history"></i>
                            <p>No order history available</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.orders-container {
    background-color: #f8f9fa;
    min-height: 100vh;
}

.section-title {
    font-size: 2rem;
    font-weight: 600;
    color: #000;
    margin-bottom: 2rem;
}

.orders-section {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    height: 100%;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
}

.section-header {
    margin-bottom: 2rem;
    position: relative;
}

.section-header h4 {
    font-size: 1.25rem;
    font-weight: 600;
    color: #000;
    margin: 0;
}

.section-header .line {
    display: block;
    width: 50px;
    height: 3px;
    background: #000;
    margin-top: 0.5rem;
}

.order-card {
    background: white;
    border: 1px solid #eee;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1rem;
    transition: all 0.3s ease;
}

.order-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
}

.order-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.order-header h5 {
    font-size: 1.1rem;
    font-weight: 600;
    margin: 0;
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 50px;
    font-size: 0.875rem;
    font-weight: 500;
}

.status-pending {
    background: #fff3cd;
    color: #856404;
}

.status-success {
    background: #d4edda;
    color: #155724;
}

.status-shipped {
    background: #cce5ff;
    color: #004085;
}

.status-cancelled {
    background: #f8d7da;
    color: #721c24;
}

.status-delivered {
    background: #d4edda;
    color: #155724;
}

.status-message {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #666;
    font-size: 0.875rem;
    margin-bottom: 1rem;
}

.order-items {
    margin: 1rem 0;
}

.order-items h6 {
    font-size: 0.875rem;
    color: #666;
    margin-bottom: 0.5rem;
}

.order-items ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.order-items li {
    display: flex;
    justify-content: space-between;
    padding: 0.5rem 0;
    border-bottom: 1px solid #eee;
}

.order-items li:last-child {
    border-bottom: none;
}

.item-name {
    font-weight: 500;
}

.item-qty {
    color: #666;
}

.order-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid #eee;
}

.order-total {
    display: flex;
    flex-direction: column;
}

.order-total span {
    font-size: 0.875rem;
    color: #666;
}

.order-total strong {
    font-size: 1.1rem;
    color: #000;
}

.btn-cancel, .btn-delivered {
    padding: 0.5rem 1.5rem;
    border-radius: 50px;
    font-size: 0.875rem;
    font-weight: 500;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-cancel {
    background: #dc3545;
    color: white;
}

.btn-cancel:hover {
    background: #c82333;
}

.btn-delivered {
    background: #28a745;
    color: white;
}

.btn-delivered:hover {
    background: #218838;
}

.empty-state {
    text-align: center;
    padding: 2rem;
    color: #666;
}

.empty-state i {
    font-size: 2rem;
    margin-bottom: 1rem;
}

.empty-state p {
    margin: 0;
}

@media (max-width: 768px) {
    .orders-section {
        padding: 1.5rem;
        margin-bottom: 1rem;
    }

    .order-footer {
        flex-direction: column;
        gap: 1rem;
    }

    .order-total {
        margin-bottom: 1rem;
    }
}
</style>

<?= $this->endSection(); ?>