<?= $this->extend('/templates/index'); ?>
<?= $this->section('content-user'); ?>

<div class="text-center mb-5">
    <h2 class="fw-bold">NEW ARRIVALS</h2>
</div>

<div class="row g-4">
    <!-- Produk Cards akan muncul di sini -->
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 shadow-sm h-100" style="cursor: pointer;">
            <div class="card-img-container position-relative">
                <img src="https://via.placeholder.com/200" 
                    class="card-img-top img-fluid" 
                    alt="Contoh Produk" 
                    style="height: 200px; object-fit: cover; border-top-left-radius: .25rem; border-top-right-radius: .25rem;">
            </div>
            <div class="card-body text-center d-flex flex-column justify-content-between">
                <h5 class="card-title fw-semibold text-truncate" title="Contoh Produk">
                    Contoh Produk
                </h5>
                <p class="card-text">
                    <span class="fw-bold text-success">Rp 100.000</span>
                </p>
                <button type="button" class="btn btn-dark btn-sm mt-2">Add Cart</button>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .card:hover {
        transform: scale(1.05);
        box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.2);
    }

    .card-title {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .card-img-container {
        overflow: hidden;
        height: 200px;
    }
</style>

<?= $this->endSection(); ?>
