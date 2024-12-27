<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-store"></i>
        </div>
        <div class="sidebar-brand-text mx-3">RB Shop <sup>@</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="/dashboard">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">Manajemen</div>

    <!-- Nav Item - Produk Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProduk"
            aria-expanded="false" aria-controls="collapseProduk">
            <i class="fas fa-box"></i>
            <span>Produk</span>
        </a>
        <div id="collapseProduk" class="collapse" aria-labelledby="headingProduk" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Produk & Kategori:</h6>
                <a class="collapse-item" href="/admin/produk">Daftar Produk</a>
                <a class="collapse-item" href="/admin/kategori">Kategori</a>
                <a class="collapse-item" href="/produk/Merk">Merk</a>
                <a class="collapse-item" href="/produk/Promo">Promo</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Transaksi Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTransaksi"
            aria-expanded="false" aria-controls="collapseTransaksi">
            <i class="fas fa-money-check-alt"></i>
            <span>Transaksi</span>
        </a>
        <div id="collapseTransaksi" class="collapse" aria-labelledby="headingTransaksi" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Manajemen Transaksi:</h6>
                <a class="collapse-item" href="/admin/transaksi">Order</a>
                <a class="collapse-item" href="/transaksi">Mutasi Stok</a>
                <a class="collapse-item" href="/transaksi">Pemesanan Produk</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Mitra -->
    <li class="nav-item">
        <a class="nav-link" href="/mitra">
            <i class="fas fa-handshake"></i>
            <span>Mitra</span>
        </a>
    </li>

    <!-- Nav Item - Konten Web -->
    <li class="nav-item">
        <a class="nav-link" href="/konten">
            <i class="fas fa-file-alt"></i>
            <span>Konten Web</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
