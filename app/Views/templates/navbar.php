<nav class="navbar navbar-expand-lg navbar-light sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold fs-4" href="/homepage">R&BSHOP</a>
        <button aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler" data-bs-target="#navbarNav" data-bs-toggle="collapse" type="button">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto align-items-center">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="kategoriDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Kategori
                    </a>
                    <ul class="dropdown-menu custom-dropdown" aria-labelledby="kategoriDropdown">
                        <?php if (!empty($kategori)): ?>
                            <?php foreach ($kategori as $kat): ?>
                                <li>
                                    <a class="dropdown-item" href="/produk?kategori=<?= urlencode($kat['nama_kategori']) ?>">
                                        <?= esc($kat['nama_kategori']) ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li>
                                <a class="dropdown-item" href="/login">Silahkan Login Terlebih dahulu</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="#">Diskon</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Brands</a></li>
            </ul>
            <form class="d-flex search-form" action="<?= base_url('homepage') ?>" method="get">
                <div class="search-container">
                    <input class="form-control search-input" name="search" placeholder="Search for products..." type="search" aria-label="Search" />
                    <button class="search-button" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <?php if (logged_in()): ?>
                <?php
                $keranjang = isset($cart) ? $cart->contents() : [];
                $jml_item = 0;
                if (!empty($keranjang)) {
                    foreach ($keranjang as $value) {
                        $jml_item += $value['qty'];
                    }
                }
                ?>
                <div class="nav-item dropdown ms-3">
                    <a href="#" class="cart-button" id="cartDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-badge">
                            <?= $jml_item ?>
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end cart-dropdown" aria-labelledby="cartDropdown">
                        <?php if (empty($keranjang)) { ?>
                            <li class="dropdown-item text-center">
                                Keranjang Anda Kosong
                            </li>
                        <?php } else { ?>
                            <?php foreach ($keranjang as $item): ?>
                                <li class="dropdown-item cart-item">
                                    <div class="d-flex align-items-center">
                                        <img src="<?= base_url('/uploads/produk/' . $item['options']['gambar']) ?>" alt="<?= $item['name'] ?>" class="cart-item-image">
                                        <div class="cart-item-details">
                                            <p class="cart-item-name"><?= $item['name'] ?></p>
                                            <p class="cart-item-price">Rp <?= number_format($item['price'], 0, ',', '.') ?></p>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li class="dropdown-item text-center">
                                <a href="/homepage/cart" class="view-cart-button">View Cart</a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            <?php endif; ?>
            <ul class="navbar-nav ms-3">
                <li class="nav-item dropdown">
                    <a class="profile-button" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end profile-dropdown" aria-labelledby="navbarDropdown">
                        <?php if (logged_in()): ?>
                            <li><a class="dropdown-item" href="/profile">Hello, <?= user()->username ?></a></li>
                            <li><a class="dropdown-item" href="/profile">Profile</a></li>
                            <li><a class="dropdown-item" href="/myorder">My Order</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                        <?php endif; ?>
                        <li><a class="dropdown-item" href="<?= logged_in() ? base_url('logout') : '/login' ?>">
                                <?= logged_in() ? 'Logout' : 'Login' ?>
                            </a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<style>
    /* Navbar Base Styles */
    .navbar {
        background-color: #ffffff;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        padding: 1rem 0;
    }

    .navbar-brand {
        color: #000;
        font-weight: 700;
        letter-spacing: -0.5px;
        transition: color 0.3s ease;
    }

    .navbar-brand:hover {
        color: #333;
    }

    /* Nav Links */
    .nav-link {
        color: #000;
        font-weight: 500;
        padding: 0.5rem 1rem;
        transition: all 0.3s ease;
    }

    .nav-link:hover {
        color: #666;
    }

    /* Search Form */
    .search-container {
        position: relative;
        width: 300px;
    }

    .search-input {
        width: 100%;
        padding: 0.6rem 1rem;
        padding-right: 3rem;
        border: 1px solid #eee;
        border-radius: 25px;
        transition: all 0.3s ease;
    }

    .search-input:focus {
        border-color: #000;
        box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.1);
    }

    .search-button {
        position: absolute;
        right: 5px;
        top: 50%;
        transform: translateY(-50%);
        background: #000;
        color: #fff;
        border: none;
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .search-button:hover {
        background: #333;
    }

    /* Cart Button */
    .cart-button {
        background: #fff;
        border: 1px solid #000;
        color: #000;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .cart-button:hover {
        background: #000;
        color: #fff;
    }

    .cart-badge {
        position: absolute;
        top: -8px;
        right: -8px;
        background: #ff0000;
        color: #fff;
        font-size: 0.75rem;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Profile Button */
    .profile-button {
        background: #fff;
        border: 1px solid #000;
        color: #000;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .profile-button:hover {
        background: #000;
        color: #fff;
    }

    /* Dropdowns */
    .custom-dropdown,
    .cart-dropdown,
    .profile-dropdown {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        padding: 0.5rem;
        margin-top: 0.5rem;
    }

    .dropdown-item {
        padding: 0.7rem 1rem;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
    }

    /* Cart Dropdown Items */
    .cart-item {
        padding: 1rem;
    }

    .cart-item-image {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 8px;
        margin-right: 1rem;
    }

    .cart-item-details {
        flex: 1;
    }

    .cart-item-name {
        margin: 0;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .cart-item-price {
        margin: 0;
        font-size: 0.8rem;
        color: #666;
    }

    .view-cart-button {
        background: #000;
        color: #fff;
        padding: 0.5rem 1.5rem;
        border-radius: 25px;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-block;
    }

    .view-cart-button:hover {
        background: #333;
        color: #fff;
    }

    /* Responsive Styles */
    @media (max-width: 991px) {
        .search-container {
            width: 100%;
            margin: 1rem 0;
        }

        .navbar-collapse {
            background: #fff;
            padding: 1rem;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            margin-top: 1rem;
        }
    }

    @media (max-width: 576px) {
        .cart-dropdown {
            width: 280px;
        }

        .cart-item {
            padding: 0.5rem;
        }

        .cart-item-image {
            width: 40px;
            height: 40px;
        }
    }
</style>