<?= $this->extend('/templates/index'); ?>
<?= $this->section('content-user'); ?>

<div class="cart-container">

    <!-- Page Header -->
    <div class="section-header">
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
        <?php echo form_open('homepage/update'); ?>
        <h2>Shopping Cart</h2>
        <p class="subtitle">Review and manage your items</p>
    </div>

    <div class="cart-layout">
        <!-- Cart Items Column -->
        <div class="cart-items">
            <?php if (empty($cart->contents())): ?>
                <div class="empty-cart">
                    <p>Your cart is empty.</p>
                    <a href="/homepage" class="primary-button">Continue Shopping</a>
                </div>
            <?php else: ?>
                <?php
                $subtotal = 0;
                $i = 1;
                foreach ($cart->contents() as $key => $value):
                    $item_total = $value['price'] * $value['qty'];
                    $subtotal += $item_total;
                ?>
                    <div class="cart-item">
                        <div class="item-image">
                            <img src="<?= base_url('/uploads/produk/' . $value['options']['gambar']) ?>"
                                alt="<?= esc($value['name']) ?>">
                        </div>

                        <div class="item-details">
                            <h3><?= esc($value['name']) ?></h3>
                            <p class="item-price"><?= number_to_currency($value['price'], 'IDR') ?></p>
                            <p class="item-subtotal">Subtotal: <?= number_to_currency($item_total, 'IDR') ?></p>
                        </div>

                        <div class="item-actions">
                            <div class="quantity-controls">
                                <button type="button" class="qty-btn btn-minus">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input name="qty<?= $i ?>" type="number" class="qty-input"
                                    value="<?= esc($value['qty']) ?>" min="0">
                                <button type="button" class="qty-btn btn-plus">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <input type="hidden" name="rowid<?= $i ?>" value="<?= $value['rowid'] ?>">
                            <a href="<?= base_url('homepage/remove/' . $value['rowid']) ?>"
                                class="remove-button"
                                onclick="return confirm('Are you sure you want to remove this item?')">
                                <i class="fas fa-trash-alt"></i> Remove
                            </a>
                        </div>
                    </div>
                <?php
                    $i++;
                endforeach;
                ?>
            <?php endif; ?>
        </div>

        <!-- Order Summary -->
        <div class="order-summary">
            <div class="summary-card">
                <h3>Order Summary</h3>

                <div class="courier-select">
                    <label>Select Courier</label>
                    <select name="kurir_id" class="select-input">
                        <option value="">Choose Courier</option>
                        <?php foreach ($kurirs as $kurir): ?>
                            <option value="<?= $kurir['kurir_id'] ?>"
                                <?= session()->get('ongkir') == $kurir['ongkos_kirim'] ? 'selected' : '' ?>>
                                <?= $kurir['nama_kurir'] ?> - <?= number_to_currency($kurir['ongkos_kirim'], 'IDR') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="summary-details">
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span><?= number_to_currency($subtotal, 'IDR') ?></span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping</span>
                        <span><?= number_to_currency($ongkir, 'IDR') ?></span>
                    </div>
                    <div class="summary-total">
                        <span>Total</span>
                        <span><?= number_to_currency($subtotal + $ongkir, 'IDR') ?></span>
                    </div>
                </div>

                <div class="summary-actions">
                    <button type="submit" class="update-button">
                        Update Cart
                    </button>
                    <a href="/checkout" class="checkout-button">
                        Proceed to Checkout <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>

<style>
    .cart-container {
        max-width: 1440px;
        margin: 0 auto;
        padding: 4rem 2rem;
        background-color: #ffffff;
    }

    .section-header {
        text-align: center;
        margin-bottom: 4rem;
    }

    .section-header h2 {
        font-size: 2.5rem;
        font-weight: 700;
        color: #000;
        margin-bottom: 0.5rem;
        letter-spacing: -0.5px;
    }

    .subtitle {
        color: #666;
        font-size: 1.1rem;
        margin: 0;
    }

    .cart-layout {
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 2rem;
    }

    /* Empty Cart Styles */
    .empty-cart {
        text-align: center;
        padding: 3rem;
        background: #f8f9fa;
        border-radius: 12px;
    }

    .primary-button {
        display: inline-block;
        background: #000;
        color: #fff;
        padding: 1rem 2rem;
        border-radius: 25px;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .primary-button:hover {
        background: #333;
        color: #fff;
    }

    /* Cart Item Styles */
    .cart-item {
        display: grid;
        grid-template-columns: 150px 1fr auto;
        gap: 2rem;
        padding: 2rem;
        background: #fff;
        border: 1px solid #eee;
        border-radius: 12px;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .cart-item:hover {
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .item-image {
        position: relative;
        padding-bottom: 100%;
        overflow: hidden;
        border-radius: 8px;
    }

    .item-image img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .item-details h3 {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .item-price {
        font-size: 1.2rem;
        font-weight: 700;
        color: #000;
        margin-bottom: 0.5rem;
    }

    .item-subtotal {
        color: #666;
        font-size: 0.9rem;
    }

    /* Quantity Controls */
    .quantity-controls {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
    }

    .qty-btn {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .qty-btn:hover {
        background: #e9ecef;
    }

    .qty-input {
        width: 60px;
        height: 36px;
        text-align: center;
        border: 1px solid #dee2e6;
        margin: 0 0.5rem;
    }

    .remove-button {
        color: #dc3545;
        text-decoration: none;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .remove-button:hover {
        color: #c82333;
    }

    /* Order Summary Styles */
    .summary-card {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 12px;
        padding: 2rem;
    }

    .summary-card h3 {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
    }

    .courier-select {
        margin-bottom: 2rem;
    }

    .select-input {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        margin-top: 0.5rem;
    }

    .summary-details {
        border-top: 1px solid #eee;
        padding-top: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1rem;
        color: #666;
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        font-size: 1.2rem;
        font-weight: 700;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 2px solid #eee;
    }

    .summary-actions {
        display: grid;
        gap: 1rem;
    }

    .update-button,
    .checkout-button {
        width: 100%;
        padding: 1rem;
        border: none;
        border-radius: 25px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
        text-decoration: none;
    }

    .update-button {
        background: #f8f9fa;
        color: #000;
    }

    .update-button:hover {
        background: #e9ecef;
    }

    .checkout-button {
        background: #000;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .checkout-button:hover {
        background: #333;
        color: #fff;
    }

    /* Responsive Styles */
    @media (max-width: 1200px) {
        .cart-layout {
            grid-template-columns: 1fr 350px;
        }
    }

    @media (max-width: 992px) {
        .cart-layout {
            grid-template-columns: 1fr;
        }

        .cart-item {
            grid-template-columns: 120px 1fr;
        }

        .item-actions {
            grid-column: 1 / -1;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    }

    @media (max-width: 576px) {
        .cart-container {
            padding: 2rem 1rem;
        }

        .cart-item {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .item-image {
            padding-bottom: 60%;
        }

        .item-actions {
            flex-direction: column;
            gap: 1rem;
        }

        .quantity-controls {
            width: 100%;
            justify-content: center;
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
        // Quantity adjustment buttons
        document.querySelectorAll('.btn-minus').forEach(button => {
            button.addEventListener('click', () => {
                const input = button.nextElementSibling;
                let currentValue = parseInt(input.value) || 0;
                if (currentValue > 0) {
                    input.value = currentValue - 1;
                }
            });
        });

        document.querySelectorAll('.btn-plus').forEach(button => {
            button.addEventListener('click', () => {
                const input = button.previousElementSibling;
                let currentValue = parseInt(input.value) || 0;
                input.value = currentValue + 1;
            });
        });

        // Remove item confirmation
        document.querySelectorAll('.remove-button').forEach(button => {
            button.addEventListener('click', (e) => {
                if (!confirm('Are you sure you want to remove this item?')) {
                    e.preventDefault();
                }
            });
        });
    });
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