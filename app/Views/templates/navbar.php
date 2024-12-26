<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold fs-4" href="/">R&BSHOP</a>
        <button aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler" data-bs-target="#navbarNav" data-bs-toggle="collapse" type="button">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="kategoriDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Kategori
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="kategoriDropdown">
                        <li><a class="dropdown-item" href="#">Kategori 1</a></li>
                        <li><a class="dropdown-item" href="#">Kategori 2</a></li>
                        <li><a class="dropdown-item" href="#">Kategori 3</a></li>
                        <li><a class="dropdown-item" href="#">Kategori 4</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="#">Diskon</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Brands</a></li>
            </ul>
            <form class="d-flex" action="<?= base_url('homepage') ?>" method="get"> <!-- Tambahkan action dan method -->
                <input class="form-control me-2" name="search" placeholder="Search for products..." type="search" aria-label="Search" />
                <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
            </form>
            <?php if (logged_in()): ?>
                <?php
                $keranjang = isset($cart) ? $cart->contents() : [];
                $jml_item = 0;
                foreach ($keranjang as $value) {
                    $jml_item += $value['qty'];
                }
                ?>

                <div class="nav-item dropdown ms-2">
                    <a href="#" class="btn btn-outline-secondary dropdown-toggle position-relative" id="cartDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.75rem;">
                            <?= $jml_item ?>
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="cartDropdown" style="min-width: 300px;">

                        <?php if (empty($keranjang)) { ?>
                            <li class="dropdown-item text-center">
                                Keranjang Anda Kosong
                            </li>
                        <?php } else { ?>
                            <?php foreach ($keranjang as $item): ?>
                                <li class="dropdown-item">
                                    <div class="d-flex align-items-center">
                                        <img src="<?= base_url('/uploads/produk/' . $item['options']['gambar']) ?>" alt="<?= $item['name'] ?>" class="me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                        <div>
                                            <p class="mb-0"><?= $item['name'] ?></p>
                                            <small class="text-muted">Rp <?= number_format($item['price'], 0, ',', '.') ?></small>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li class="dropdown-item text-center">
                                <a href="/homepage/cart" class="btn btn-sm btn-primary">View Cart</a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            <?php endif; ?>
            <ul class="navbar-nav ms-2">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle btn btn-outline-secondary" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <?php if (logged_in()): ?>
                            <li><a class="dropdown-item" href="/profile">Hello, <?= user()->username ?></a></li>
                            <li><a class="dropdown-item" href="/profile">Profile</a></li>
                            <li><a class="dropdown-item" href="/myorder">My Order</a></li>
                            <li><a class="dropdown-item" href="/dashboard">Settings</a></li>
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