<?= $this->extend('admin/templates/index'); ?>

<?= $this->section('content-admin'); ?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="container mt-4">
        <div class="bg-light p-4 rounded shadow-sm">
            <h5 class="text-secondary">
                Dashboard Operator
            </h5>
            <h2 class="text-primary">
                Selamat Datang, Operator
            </h2>
        </div>

        <!-- Cards Section -->
        <div class="row mt-4">
            <!-- Card Produk -->
            <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                <div class="card shadow-sm border-0 bg-info text-white text-center h-100">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <i class="fas fa-box fa-4x mb-3"></i>
                        <h5 class="card-title">Produk</h5>
                        <p class="card-text">Manajemen Produk</p>
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        <a href="/produk" class="btn btn-light btn-sm text-info">
                            Lihat Daftar Produk &gt;
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card Transaksi -->
            <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                <div class="card shadow-sm border-0 bg-success text-white text-center h-100">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <i class="fas fa-money-bill-wave fa-4x mb-3"></i>
                        <h5 class="card-title">Transaksi</h5>
                        <p class="card-text">Manajemen Halaman Transaksi</p>
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        <a href="#" class="btn btn-light btn-sm text-success">
                            Lihat Detail Transaksi &gt;
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card Mitra -->
            <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                <div class="card shadow-sm border-0 bg-warning text-white text-center h-100">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <i class="fas fa-handshake fa-4x mb-3"></i>
                        <h5 class="card-title">Mitra</h5>
                        <p class="card-text">Manajemen Mitra Usaha</p>
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        <a href="#" class="btn btn-light btn-sm text-warning">
                            Lihat Daftar Mitra &gt;
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card Konten -->
            <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                <div class="card shadow-sm border-0 bg-danger text-white text-center h-100">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <i class="fas fa-file-alt fa-4x mb-3"></i>
                        <h5 class="card-title">Konten</h5>
                        <p class="card-text">Manajemen Konten</p>
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        <a href="#" class="btn btn-light btn-sm text-danger">
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
