<?= $this->extend('/templates/index'); ?>
<?= $this->section('content-user'); ?>

<div class="container py-5">
    <!-- Flash Message -->
    <?php if (session()->getFlashdata('pesan')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('pesan'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Page Header -->
    <div class="text-center mb-5">
        <h2 class="display-4 fw-bold position-relative d-inline-block">
            NEW ARRIVALS
            <div class="heading-underline"></div>
        </h2>
    </div>

    <!-- Products Grid -->
    <div class="row g-4">
        <?php foreach ($barang as $key => $value): ?>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <?php
                echo form_open('homepage/add');
                echo form_hidden('id', $value['Produk_id']);
                echo form_hidden('price', $value['harga']);
                echo form_hidden('name', $value['nama_produk']);
                echo form_hidden('gambar', $value['gambar']);
                echo form_hidden('berat', $value['Berat']);
                ?>

                <div class="product-card card h-100 border-0 shadow-hover">
                    <!-- Product Image -->
                    <div class="product-image-wrapper">
                        <img src="<?= base_url('/uploads/produk/' . $value['gambar']) ?>"
                            class="card-img-top"
                            alt="<?= esc($value['nama_produk']) ?>">
                        <div class="product-overlay">
                            <button type="submit" class="btn btn-primary btn-add-cart">
                                <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                            </button>
                        </div>
                    </div>

                    <!-- Product Details -->
                    <div class="card-body text-center">
                        <h5 class="product-title mb-3" title="<?= esc($value['nama_produk']) ?>">
                            <a href="<?= base_url('produk/' . $value['Produk_id']) ?>" class="text-decoration-none">
                                <?= esc($value['nama_produk']) ?>
                            </a>
                        </h5>
                        <p class="product-price mb-0">
                            <?= number_to_currency($value['harga'], 'IDR') ?>
                        </p>
                    </div>

                </div>
                <?php echo form_close(); ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
    /* General Styles */
    .container {
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Header Styles */
    .heading-underline {
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 3px;
        background: linear-gradient(to right, #007bff, #00ff88);
    }

    /* Product Card Styles */
    .product-card {
        transition: all 0.3s ease;
        background: #ffffff;
        border-radius: 12px;
        overflow: hidden;
    }

    .shadow-hover {
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
    }

    .shadow-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
    }

    /* Product Image Styles */
    .product-image-wrapper {
        position: relative;
        height: 250px;
        overflow: hidden;
    }

    .product-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .product-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .product-card:hover .product-overlay {
        opacity: 1;
    }

    .product-card:hover .product-image-wrapper img {
        transform: scale(1.1);
    }

    /* Product Details Styles */
    .product-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .product-price {
        font-size: 1.2rem;
        font-weight: 700;
        color: #28a745;
    }

    /* Button Styles */
    .btn-add-cart {
        padding: 0.5rem 1.5rem;
        border-radius: 25px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        background: #000000;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-add-cart:hover {
        background: #5a5a5a;
        transform: scale(1.05);
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .product-image-wrapper {
            height: 200px;
        }

        .product-title {
            font-size: 1rem;
        }

        .product-price {
            font-size: 1.1rem;
        }
    }
</style>

<?= $this->endSection(); ?>