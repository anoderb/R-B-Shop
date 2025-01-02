<?= $this->extend('/templates/index'); ?>

<?= $this->section('content-user'); ?>

<div class="checkout-container">
    <!-- Page Header -->
    <div class="section-header">
        <h2>Checkout</h2>
        <p class="subtitle">Complete your purchase</p>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error'); ?></div>
    <?php endif; ?>

    <div class="checkout-layout">
        <!-- Billing Details Column -->
        <div class="billing-details">
            <div class="details-card">
                <h3>Billing Information</h3>
                <form action="/checkout/process" method="post" id="checkout-form">
                    <?= csrf_field(); ?>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="nama_pelanggan">Full Name</label>
                            <input type="text" id="nama_pelanggan" name="nama_pelanggan"
                                value="<?= $pelanggan['Nama_pelanggan'] ?? ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Address</label>
                            <input type="text" id="alamat" name="alamat"
                                value="<?= $pelanggan['Alamat'] ?? ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="kota">City</label>
                            <input type="text" id="kota" name="kota"
                                value="<?= $pelanggan['Kota'] ?? ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="hp">Phone Number</label>
                            <input type="text" id="hp" name="hp"
                                value="<?= $pelanggan['Hp'] ?? ''; ?>" required>
                        </div>
                    </div>

                    <!-- Product List -->
                    <div class="order-items">
                        <h3>Your Order</h3>
                        <div class="order-table">
                            <div class="table-header">
                                <span>Product</span>
                                <span>Quantity</span>
                                <span>Price</span>
                                <span>Subtotal</span>
                            </div>
                            <?php foreach ($cart->contents() as $item): ?>
                                <div class="table-row">
                                    <span><?= esc($item['name']); ?></span>
                                    <span><?= esc($item['qty']); ?></span>
                                    <span>Rp<?= number_format($item['price'], 0, ',', '.'); ?></span>
                                    <span>Rp<?= number_format($item['subtotal'], 0, ',', '.'); ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Courier Selection -->
                    <div class="courier-selection">
                        <h3>Shipping Method</h3>
                        <?php if (isset($kurir) && $kurir): ?>
                            <div class="courier-option">
                                <input type="radio" name="courier" id="selected-courier"
                                    value="<?= $kurir->kurir_id ?>" checked>
                                <label for="selected-courier">
                                    <?= esc($kurir->nama_kurir) ?> - Rp<?= number_format($ongkir, 0, ',', '.') ?>
                                </label>
                            </div>
                        <?php else: ?>
                            <p class="error-message">No courier selected. Please go back to cart.</p>
                        <?php endif; ?>
                        <input type="hidden" name="ongkir" value="<?= esc($ongkir) ?>">
                    </div>
                </form>
            </div>
        </div>

        <!-- Order Summary Column -->
        <div class="order-summary">
            <div class="summary-card">
                <h3>Order Summary</h3>
                <div class="summary-details">
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span>Rp<?= number_format($cart->total(), 0, ',', '.'); ?></span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping Fee</span>
                        <span>Rp<?= number_format($ongkir, 0, ',', '.'); ?></span>
                    </div>
                    <div class="summary-total">
                        <span>Total</span>
                        <span>Rp<?= number_format($cart->total() + $ongkir, 0, ',', '.'); ?></span>
                    </div>
                </div>
                <button type="submit" form="checkout-form" id="placeOrderButton" class="checkout-button">
                    Place Order <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        </div>

    </div>

    <form action="/checkout/complete" style="display: none;" hidden method="post" id="checkout-form-success"></form>
</div>

<!-- Include existing script from previous checkout page -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?= env('midtrans.clientKey') ?>"></script>

<style>
    .checkout-container {
        max-width: 1440px;
        margin: 0 auto;
        padding: 4rem 2rem;
        background-color: #ffffff;
    }

    .section-header {
        text-align: center;
        margin-bottom: 3rem;
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

    .checkout-layout {
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 2rem;
    }

    .details-card,
    .summary-card {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 12px;
        padding: 2rem;
    }

    .details-card h3,
    .summary-card h3 {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        border-bottom: 1px solid #eee;
        padding-bottom: 1rem;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        margin-bottom: 1rem;
    }

    .form-group label {
        margin-bottom: 0.5rem;
        color: #666;
    }

    .form-group input {
        padding: 0.75rem;
        border: 1px solid #dee2e6;
        border-radius: 8px;
    }

    .order-items {
        margin-top: 2rem;
    }

    .order-table {
        width: 100%;
        border-collapse: collapse;
    }

    .table-header {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr 1fr;
        font-weight: bold;
        border-bottom: 2px solid #eee;
        padding-bottom: 0.5rem;
    }

    .table-row {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr 1fr;
        padding: 0.5rem 0;
        border-bottom: 1px solid #f1f1f1;
    }

    .courier-selection {
        margin-top: 2rem;
    }

    .courier-option {
        margin-bottom: 1rem;
    }

    .error-message {
        color: #dc3545;
    }

    .summary-details {
        margin-top: 1rem;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
        color: #666;
    }

    .summary-total {
        font-weight: bold;
        font-size: 1.2rem;
    }

    .checkout-button {
        width: 100%;
        padding: 1rem;
        background: #000;
        color: #fff;
        border: none;
        border-radius: 25px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .checkout-button:hover {
        background: #333;
    }

    @media (max-width: 992px) {
        .checkout-layout {
            grid-template-columns: 1fr;
        }
    }

    .summary-card {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 12px;
        padding: 2.5rem 2rem;
        /* Menambah padding untuk lebih lega */
        margin-top: 2rem;
        /* Memberikan jarak dari elemen di atasnya */
        margin-bottom: 2rem;
        /* Memberikan jarak dari elemen di bawahnya */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        /* Menambahkan bayangan untuk tampilan lebih modern */
    }

    .summary-details {
        margin-top: 1.5rem;
        /* Memberikan jarak lebih baik di antara elemen */
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1rem;
        /* Menambah jarak antar baris */
        font-size: 1rem;
        color: #333;
    }

    .summary-total {
        font-weight: bold;
        font-size: 1.3rem;
        /* Memperbesar font untuk lebih menonjolkan total */
        margin-top: 1rem;
        border-top: 1px solid #eee;
        padding-top: 1rem;
        color: #000;
        /* Memastikan warna teks tetap kontras */
    }

    .checkout-button {
        margin-top: 2rem;
        /* Memberikan jarak dengan elemen sebelumnya */
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const placeOrderButton = document.getElementById("placeOrderButton");
        const checkoutForm = document.getElementById("checkout-form");

        placeOrderButton.onclick = function(e) {
            e.preventDefault();
            const formData = new FormData(checkoutForm);
            formData.append('total', <?= $cart->total() + $ongkir ?>);

            fetch('/checkout/process', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.snapToken) {
                        snap.pay(data.snapToken, {
                            onSuccess: function(result) {
                                const checkoutFormSuccess = document.getElementById("checkout-form-success");
                                const inputs = [{
                                        name: 'transaction_id',
                                        value: result.transaction_id
                                    },
                                    {
                                        name: 'order_id',
                                        value: data.orderId
                                    },
                                    {
                                        name: 'gross_amount',
                                        value: result.gross_amount
                                    },
                                    {
                                        name: 'transaction_status',
                                        value: result.transaction_status
                                    }
                                ];
                                inputs.forEach(input => {
                                    const hiddenInput = document.createElement('input');
                                    hiddenInput.type = 'hidden';
                                    hiddenInput.name = input.name;
                                    hiddenInput.value = input.value;
                                    checkoutFormSuccess.appendChild(hiddenInput);
                                });
                                checkoutFormSuccess.submit();
                                alert('Payment success!');
                            },
                            onPending: function(result) {
                                // Handle pending payment
                            },
                            onError: function(result) {
                                // Handle error
                            }
                        });
                    } else {
                        alert('Failed to get payment token.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred, please try again.');
                });
        };
    });
</script>

<?= $this->endSection(); ?>