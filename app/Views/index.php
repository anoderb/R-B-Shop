<?= $this->extend('/templates/index'); ?>

<?= $this->section('content-user'); ?>

<div class="hero-container">
    <div class="hero-content">
        <div class="hero-row">
            <div class="hero-text">
                <h1 class="hero-title">FIND CLOTHES THAT MATCH YOUR STYLE</h1>
                <p class="hero-description">Browse through our diverse range of meticulously crafted garments, designed to bring out your individuality and cater to your sense of style.</p>
                <a href="/homepage" class="hero-btn">Shop Now</a>
            </div>
            <div class="hero-image-wrapper">
                <img
                    src="https://storage.googleapis.com/a1aa/image/LxcTTsWnOT4OBJt6MxqgqUhiihyCWFvjk6y9YVUy0loFf37JA.jpg"
                    alt="A stylish man and woman wearing fashionable clothes"
                    class="hero-image" />
                <div class="hero-overlay"></div>
            </div>
        </div>
    </div>
</div>
<style>
    .hero-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        background-color: #f8f9fa;
        padding: 2rem;
    }

    .hero-content {
        max-width: 1200px;
        margin: 0 auto;
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    }

    .hero-row {
        display: flex;
        align-items: center;
    }

    .hero-text {
        flex: 1;
        padding: 60px;
        animation: slideRight 0.8s ease;
    }

    .hero-title {
        font-size: 3rem;
        font-weight: 700;
        color: #000;
        margin-bottom: 1.5rem;
        line-height: 1.2;
    }

    .hero-description {
        font-size: 1.1rem;
        color: #666;
        margin-bottom: 2rem;
        line-height: 1.6;
    }

    .hero-btn {
        display: inline-block;
        padding: 16px 40px;
        background: #000;
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 1.1rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s;
        animation: slideUp 0.6s ease;
    }

    .hero-btn:hover {
        background: #333;
        transform: translateY(-2px);
        color: white;
    }

    .hero-image-wrapper {
        flex: 1;
        position: relative;
        min-height: 600px;
        animation: fadeIn 1s ease;
    }

    .hero-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(45deg, rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0));
    }

    @keyframes slideRight {
        from {
            opacity: 0;
            transform: translateX(-50px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @media (max-width: 1024px) {
        .hero-title {
            font-size: 2.5rem;
        }

        .hero-text {
            padding: 40px;
        }
    }

    @media (max-width: 768px) {
        .hero-row {
            flex-direction: column;
        }

        .hero-text {
            padding: 40px;
            text-align: center;
        }

        .hero-image-wrapper {
            min-height: 400px;
            width: 100%;
        }

        .hero-title {
            font-size: 2rem;
        }
    }
</style>
<?= $this->endSection(); ?>