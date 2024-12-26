<?= $this->extend('/templates/index'); ?>

<?= $this->section('content-user'); ?>


<!-- hero-section.php -->
<div class="hero-section container my-5 py-4 px-3 bg-light border rounded shadow-sm">
    <div class="row align-items-center">
        <div class="col-lg-6 text-center text-lg-start">
            <h1 class="fw-bold mb-3">FIND CLOTHES THAT MATCH YOUR STYLE
            </h1>
            <p class="text-secondary mb-4">Browse through our diverse range of meticulously crafted garments, designed to bring out your individuality and cater to your sense of style.</p>
            <a href="/homepage" class="btn btn-dark">Belanja Sekarang</a>
        </div>
        <div class="col-lg-6 text-center mt-4 mt-lg-0">
            <img alt="A stylish man and woman wearing fashionable clothes" class="img-fluid rounded" src="https://storage.googleapis.com/a1aa/image/LxcTTsWnOT4OBJt6MxqgqUhiihyCWFvjk6y9YVUy0loFf37JA.jpg" />
        </div>
    </div>
</div>


<?= $this->endSection(); ?>