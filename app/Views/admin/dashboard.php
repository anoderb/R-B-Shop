<?= $this->extend('admin/templates/index'); ?>

<?= $this->section('content-admin'); ?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="container mt-4">
        <h5 class="text-secondary">
            Dashboard Operator
        </h5>
        <h2 class="text-primary">
            Selamat Datang, Operator
        </h2>
        <div class="row mt-4">
            <!-- Card Produk -->
            <div class="col-md-3 mb-4">
                <div class="card shadow-sm bg-info text-white text-center">
                    <div class="card-body">
                        <i class="fas fa-box fa-3x mb-3"></i>
                        <h5 class="card-title">Produk</h5>
                        <p class="card-text">Manajemen Produk</p>
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        <a href="#" class="text-white text-decoration-none">
                            Lihat Daftar Produk &gt;
                        </a>
                    </div>
                </div>
            </div>
            <!-- Card Transaksi -->
            <div class="col-md-3 mb-4">
                <div class="card shadow-sm bg-success text-white text-center">
                    <div class="card-body">
                        <i class="fas fa-money-bill-wave fa-3x mb-3"></i>
                        <h5 class="card-title">Transaksi</h5>
                        <p class="card-text">Manajemen Halaman Berita</p>
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        <a href="#" class="text-white text-decoration-none">
                            Lihat Detail Transaksi &gt;
                        </a>
                    </div>
                </div>
            </div>
            <!-- Card Mitra -->
            <div class="col-md-3 mb-4">
                <div class="card shadow-sm bg-warning text-white text-center">
                    <div class="card-body">
                        <i class="fas fa-handshake fa-3x mb-3"></i>
                        <h5 class="card-title">Mitra</h5>
                        <p class="card-text">Manajemen Mitra Usaha</p>
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        <a href="#" class="text-white text-decoration-none">
                            Lihat Daftar Mitra &gt;
                        </a>
                    </div>
                </div>
            </div>
            <!-- Card Konten -->
            <div class="col-md-3 mb-4">
                <div class="card shadow-sm bg-danger text-white text-center">
                    <div class="card-body">
                        <i class="fas fa-file-alt fa-3x mb-3"></i>
                        <h5 class="card-title">Konten</h5>
                        <p class="card-text">Manajemen Konten</p>
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        <a href="#" class="text-white text-decoration-none">
                            Atur Konten &gt;
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
<?= $this->endSection(); ?>
