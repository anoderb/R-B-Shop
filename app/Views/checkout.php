<?= $this->extend('/templates/index'); ?>

<?= $this->section('content-user'); ?>

<!-- Checkout Section -->
<div class="container my-5">
    <h2 class="mb-4">CHECKOUT</h2>
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error'); ?></div>
    <?php endif; ?>

    <div class="row">
        <!-- Billing Details -->
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Billing Details</h5>
                    <form action="/checkout/process" method="post" id="checkout-form">
                        <?= csrf_field(); ?>
                        <div class="mb-3">
                            <label for="nama_pelanggan" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan"
                                value="<?= $pelanggan['Nama_pelanggan']  ?? ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat"
                                value="<?= $pelanggan['Alamat'] ?? ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="kota" class="form-label">Kota</label>
                            <input type="text" class="form-control" id="kota" name="kota"
                                value="<?= $pelanggan['Kota'] ?? ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="hp" class="form-label">Nomor HP</label>
                            <input type="text" class="form-control" id="hp" name="hp"
                                value="<?= $pelanggan['Hp'] ?? ''; ?>" required>
                        </div>


                        <!-- Product List from Cart -->
                        <div class="mt-4">
                            <h5>Your Order</h5>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($cart->contents() as $item): ?>
                                            <tr>
                                                <td><?= esc($item['name']); ?></td>
                                                <td><?= esc($item['qty']); ?></td>
                                                <td>Rp<?= number_format($item['price'], 0, ',', '.'); ?></td>
                                                <td>Rp<?= number_format($item['subtotal'], 0, ',', '.'); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- Courier Selection -->
                        <div class="mt-4">
                            <h5>Courier Selection</h5>
                            <?php if (isset($kurir) && $kurir): ?>
                                <div class="border p-3 rounded">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="courier" id="selected-courier" value="<?= $kurir->kurir_id ?>" checked>
                                        <label class="form-check-label" for="selected-courier">
                                            <?= esc($kurir->nama_kurir) ?> - Rp<?= number_format($ongkir, 0, ',', '.') ?>
                                        </label>
                                    </div>
                                </div>
                            <?php else: ?>
                                <p class="text-danger">Kurir belum dipilih. Silakan kembali ke keranjang untuk memilih kurir.</p>
                            <?php endif; ?>
                            <input type="hidden" name="ongkir" value="<?= esc($ongkir) ?>">
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <!-- Order Summary -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Order Summary</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Subtotal</span>
                            <span>Rp<?= number_format($cart->total(), 0, ',', '.'); ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Shipping Fee</span>
                            <span>Rp<?= number_format($ongkir, 0, ',', '.'); ?></span>
                        </li>
                    </ul>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <h5>Total</h5>
                        <h5>Rp<?= number_format($cart->total() + $ongkir, 0, ',', '.'); ?></h5>
                    </div>
                    <button type="submit" form="checkout-form" id="placeOrderButton" class="btn btn-dark w-100">
                        Place Order <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <form action="/checkout/complete" style="display: none;" hidden method="post" id="checkout-form-success"></form>
</div>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-jf9Jkm-Rly43CyXs"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const placeOrderButton = document.getElementById("placeOrderButton");
        const checkoutForm = document.getElementById("checkout-form");


        console.log('DOM ready');
        // Event listener saat tombol diklik
        placeOrderButton.onclick = function(e) {
            e.preventDefault();
            console.log('Tombol ditekan');

            // Ambil data form
            const formData = new FormData(checkoutForm);
            formData.append('total', <?= $cart->total() + $ongkir ?>); // Kirim total ke server

            // Kirim data ke server untuk mendapatkan Snap Token
            fetch('/checkout/process', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.snapToken) {
                        // Panggil Midtrans Snap setelah tombol ditekan
                        snap.pay(data.snapToken, {
                            onSuccess: function(result) {
                                const transactionId = result.transaction_id;


                                const checkoutFormSuccess = document.getElementById("checkout-form-success");

                                const inputs = [{
                                        name: 'transaction_id',
                                        value: transactionId
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
                                const transactionId = result.transaction_id;


                                const checkoutFormSuccess = document.getElementById("checkout-form-success");

                                const inputs = [{
                                        name: 'transaction_id',
                                        value: transactionId
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
                                alert('Payment pending!');
                            },
                            onError: function(result) {
                                const transactionId = result.transaction_id;


                                const checkoutFormSuccess = document.getElementById("checkout-form-success");

                                const inputs = [{
                                        name: 'transaction_id',
                                        value: transactionId
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
                                alert('Payment gagal!');
                            }
                        });
                    } else {
                        alert('Gagal mendapatkan token pembayaran.');
                    }
                })
                .catch(error => {
                    console.error('EROR OOOOS:', error);
                    alert('Terjadi kesalahan, silakan coba lagi.');
                });
        };
    });
</script>

<?= $this->endSection(); ?>