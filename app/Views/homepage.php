<?= $this->extend('/templates/index'); ?>
<?= $this->section('content-user'); ?>

<div class="homepage-container">
    <!-- Flash Message -->
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

    <!-- Page Header -->
    <div class="section-header">
        <h2>New Arrivals</h2>
        <p class="subtitle">Discover our latest collection</p>
    </div>

    <!-- Products Grid -->
    <div class="products-grid">
        <?php foreach ($barang as $key => $value): ?>
            <div class="product-item">
                <?php
                echo form_open('homepage/add');
                echo form_hidden('id', $value['Produk_id']);
                echo form_hidden('price', $value['harga']);
                echo form_hidden('name', $value['nama_produk']);
                echo form_hidden('gambar', $value['gambar']);
                echo form_hidden('berat', $value['Berat']);
                ?>

                <div class="product-card">
                    <!-- Product Image -->
                    <div class="product-image">
                        <img src="<?= base_url('/uploads/produk/' . $value['gambar']) ?>"
                            alt="<?= esc($value['nama_produk']) ?>">
                        <div class="product-actions">
                            <button type="submit" class="cart-button">
                                <span class="icon"><i class="fas fa-shopping-cart"></i></span>
                                <span class="text">Add to Cart</span>
                            </button>
                            <a href="<?= base_url('produk/' . $value['Produk_id']) ?>" class="details-button">
                                <span class="icon"><i class="fas fa-eye"></i></span>
                            </a>
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div class="product-info">
                        <h3 class="product-title">
                            <a href="<?= base_url('produk/' . $value['Produk_id']) ?>">
                                <?= esc($value['nama_produk']) ?>
                            </a>
                        </h3>
                        <p class="product-price">
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
    /* Container Styles */
    .homepage-container {
        max-width: 1440px;
        margin: 0 auto;
        padding: 4rem 2rem;
        background-color: #ffffff;
    }

    /* Alert Styles */
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

    /* Header Styles */
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

    /* Products Grid */
    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 2rem;
    }

    /* Product Card Styles */
    .product-card {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    /* Product Image Styles */
    .product-image {
        position: relative;
        padding-bottom: 100%;
        overflow: hidden;
    }

    .product-image img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .product-card:hover .product-image img {
        transform: scale(1.1);
    }

    /* Product Actions */
    .product-actions {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 1.5rem;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
        display: flex;
        gap: 1rem;
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.3s ease;
    }

    .product-card:hover .product-actions {
        opacity: 1;
        transform: translateY(0);
    }

    /* Button Styles */
    .cart-button {
        flex: 1;
        background: #000;
        color: #fff;
        border: none;
        padding: 0.8rem 1.5rem;
        border-radius: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .cart-button:hover {
        background: #333;
    }

    .details-button {
        background: #fff;
        color: #000;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .details-button:hover {
        background: #000;
        color: #fff;
    }

    /* Product Info Styles */
    .product-info {
        padding: 1.5rem;
    }

    .product-title {
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .product-title a {
        color: #000;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .product-title a:hover {
        color: #666;
    }

    .product-price {
        font-size: 1.1rem;
        font-weight: 700;
        color: #000;
        margin: 0;
    }

    /* Responsive Styles */
    @media (max-width: 1200px) {
        .products-grid {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        }
    }

    @media (max-width: 768px) {
        .homepage-container {
            padding: 2rem 1rem;
        }

        .section-header h2 {
            font-size: 2rem;
        }

        .products-grid {
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
        }

        .product-info {
            padding: 1rem;
        }
    }

    @media (max-width: 480px) {
        .products-grid {
            grid-template-columns: 1fr;
        }

        .product-actions {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
<script>
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