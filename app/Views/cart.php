<?= $this->extend('/templates/index'); ?>

<?= $this->section('content-user'); ?>

<!-- Cart Section -->
<div class="container py-5">
    <?php echo form_open('homepage/update'); ?>

    <h2 class="mb-4 text-center fw-bold">Shopping Cart</h2>

    <div class="row g-4">
        <!-- Cart Items Column -->
        <div class="col-lg-8">
            <?php if (empty($cart->contents())): ?>
                <div class="alert alert-info text-center">
                    Your cart is empty. <a href="/homepage" class="alert-link">Continue shopping</a>
                </div>
            <?php else: ?>
                <?php
                $subtotal = 0; // Inisialisasi variabel subtotal
                $i = 1;
                foreach ($cart->contents() as $key => $value):
                    $item_total = $value['price'] * $value['qty'];
                    $subtotal += $item_total;
                ?>
                    <div class="card shadow-sm mb-3 border-0">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <!-- Product Image -->
                                <div class="col-md-3 mb-3 mb-md-0">
                                    <img src="<?= base_url('/uploads/produk/' . $value['options']['gambar']) ?>"
                                        class="img-fluid rounded"
                                        alt="<?= esc($value['name']) ?>"
                                        style="object-fit: cover; height: 120px; width: 100%;">
                                </div>

                                <!-- Product Details -->
                                <div class="col-md-5 mb-3 mb-md-0">
                                    <h5 class="card-title mb-2"><?= esc($value['name']) ?></h5>
                                    <p class="card-text text-primary fw-bold mb-1">
                                        <?= number_to_currency($value['price'], 'IDR') ?>
                                    </p>
                                    <p class="card-text text-muted small">
                                        Item Subtotal: <?= number_to_currency($item_total, 'IDR') ?>
                                    </p>
                                </div>

                                <!-- Quantity Controls -->
                                <div class="col-md-4">
                                    <div class="d-flex flex-column align-items-end">
                                        <div class="input-group input-group-sm" style="max-width: 150px;">
                                            <button class="btn btn-outline-primary btn-minus" type="button">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <input name="qty<?= $i ?>"
                                                type="number"
                                                class="form-control text-center qty-input"
                                                value="<?= esc($value['qty']) ?>"
                                                min="0">
                                            <button class="btn btn-outline-primary btn-plus" type="button">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                        <input type="hidden" name="rowid<?= $i ?>" value="<?= $value['rowid'] ?>">
                                        <a href="<?= base_url('homepage/remove/' . $value['rowid']) ?>"
                                            class="btn btn-link text-danger mt-2 p-0 remove-item"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus item ini?')">
                                            <i class="fas fa-trash-alt"></i> Remove
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                    $i++;
                endforeach;
                ?>
            <?php endif; ?>
        </div>

        <!-- Order Summary Column -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-4">Order Summary</h5>
                    <div class="mb-4">
                        <label class="form-label">Pilih Kurir</label>
                        <select name="kurir_id" class="form-select">
                            <option value="">Pilih Kurir</option>
                            <?php foreach ($kurirs as $kurir): ?>
                                <option value="<?= $kurir['kurir_id'] ?>" <?= session()->get('ongkir') == $kurir['ongkos_kirim'] ? 'selected' : '' ?>>
                                    <?= $kurir['nama_kurir'] ?> - <?= number_to_currency($kurir['ongkos_kirim'], 'IDR') ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal</span>
                        <span class="fw-bold"><?= number_to_currency($subtotal, 'IDR') ?></span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Ongkos Kirim</span>
                        <span class="fw-bold"><?= number_to_currency($ongkir, 'IDR') ?></span>
                    </div>

                    <div class="border-top pt-3 mb-4">
                        <div class="d-flex justify-content-between">
                            <span class="h5 mb-0">Total</span>
                            <span class="h5 mb-0"><?= number_to_currency($subtotal + $ongkir, 'IDR') ?></span>
                        </div>
                    </div>
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary btn-lg" type="submit">
                            Update Cart
                        </button>
                        <a href="/checkout" class="btn btn-dark btn-lg">
                            Proceed to Checkout <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>

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
        document.querySelectorAll('.remove-item').forEach(button => {
            button.addEventListener('click', (e) => {
                if (!confirm('Apakah Anda yakin ingin menghapus item ini?')) {
                    e.preventDefault();
                }
            });
        });
    });
</script>

<?= $this->endSection(); ?>