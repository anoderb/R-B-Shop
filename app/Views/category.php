<?= $this->extend('/templates/index'); ?>

<?= $this->section('content-user'); ?>

<div class="container my-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold">NEW ARRIVALS</h2>
    </div>

    <!-- Product Cards -->
    <div class="row g-4">
        <!-- Product Card 1 -->
        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm">
                <img src="https://storage.googleapis.com/a1aa/image/giOzvv3kirZAH9oIhHuMMthroUS2IjMqrC4LwANecV4KYm8JA.jpg" class="card-img-top" alt="T-shirt with Tape Details">
                <div class="card-body text-center">
                    <h5 class="card-title">T-shirt with Tape Details</h5>
                    <p class="card-text">
                        <span class="fw-bold">$120</span>
                        <br />

                    </p>
                </div>
            </div>
        </div>

        <!-- Product Card 2 -->
        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm">
                <img src="https://storage.googleapis.com/a1aa/image/9dyxVF82eM1jDCrVE8oQ2ss6cVMMOUod8PkuFwPsx6tIYm8JA.jpg" class="card-img-top" alt="Skinny Fit Jeans">
                <div class="card-body text-center">
                    <h5 class="card-title">Skinny Fit Jeans</h5>
                    <p class="card-text">
                        <span class="fw-bold">$240</span>
                        <span class="text-decoration-line-through text-muted">$260</span>
                        <span class="text-danger">20% off</span>
                        <br />

                    </p>
                </div>
            </div>
        </div>

        <!-- Add additional cards as needed -->
    </div>

    <!-- View All Button -->
    <div class="text-center mt-4">
        <a href="#" class="btn btn-outline-dark rounded-pill px-4">View All</a>
    </div>

    <!-- Another Section -->
    <div class="text-center my-5">
        <h2 class="fw-bold">TOP SELLING</h2>
    </div>
    <div class="row g-4">
        <!-- Product Card Example -->
        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm">
                <img src="https://storage.googleapis.com/a1aa/image/XHJhuMcKJuYFM1GyE80SqbResUEssehXDmg0NPafYbbvgZynA.jpg" class="card-img-top" alt="Vertical Striped Shirt">
                <div class="card-body text-center">
                    <h5 class="card-title">Vertical Striped Shirt</h5>
                    <p class="card-text">
                        <span class="fw-bold">$212</span>
                        <span class="text-decoration-line-through text-muted">$232</span>
                        <span class="text-danger">20% off</span>
                        <br />

                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center my-3">
        <h1 class="h3">Casual</h1>
        <!-- <div>
                <span>Showing 1-10 of 100 Products</span>
                <span>Sort by: <strong>Most Popular</strong></span>
            </div> -->
    </div>

    <!-- Product Grid -->
    <div class="row g-4">
        <!-- Product Card -->
        <!-- Product Card -->
        <div class="col-md-4 col-sm-6">
            <a href="/productdetail" class="text-decoration-none">
                <div class="card text-center">
                    <img src="https://storage.googleapis.com/a1aa/image/OxmOW09DCxoBApqJAOgexEjQr3i5cEgHXvPJhtCnbetHS44TA.jpg" class="card-img-top" alt="Gradient Graphic T-shirt">
                    <div class="card-body">
                        <p class="fw-bold">Gradient Graphic T-shirt</p>

                        <p class="fw-bold">$145</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4 col-sm-6">
            <div class="card text-center">
                <img src="https://storage.googleapis.com/a1aa/image/OxmOW09DCxoBApqJAOgexEjQr3i5cEgHXvPJhtCnbetHS44TA.jpg" class="card-img-top" alt="Gradient Graphic T-shirt">
                <div class="card-body">
                    <p class="fw-bold">Gradient Graphic T-shirt</p>

                    <p class="fw-bold">$145</p>
                </div>
            </div>
        </div>


        <!-- Ulangi produk lainnya seperti di atas -->
        <!-- Contoh lainnya -->
        <div class="col-md-4 col-sm-6">
            <div class="card text-center">
                <img src="https://storage.googleapis.com/a1aa/image/TVRNLhkcWG45M1ARHL8NkX1Ma1THvyi7fLeycCcZDIsQS44TA.jpg" class="card-img-top" alt="Polo with Tipping Details">
                <div class="card-body">
                    <p class="fw-bold">Polo with Tipping Details</p>

                    <p class="fw-bold">$180</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="card text-center">
                <img src="https://storage.googleapis.com/a1aa/image/TVRNLhkcWG45M1ARHL8NkX1Ma1THvyi7fLeycCcZDIsQS44TA.jpg" class="card-img-top" alt="Polo with Tipping Details">
                <div class="card-body">
                    <p class="fw-bold">Polo with Tipping Details</p>

                    <p class="fw-bold">$180</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <nav aria-label="Page navigation" class="mt-4">
        <ul class="pagination justify-content-center">
            <li class="page-item"><a class="page-link" href="#" aria-label="Previous">&laquo; Previous</a></li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">4</a></li>
            <li class="page-item"><a class="page-link" href="#">5</a></li>
            <li class="page-item"><a class="page-link" href="#" aria-label="Next">Next &raquo;</a></li>
        </ul>
    </nav>
</div>
<?= $this->endSection(); ?>