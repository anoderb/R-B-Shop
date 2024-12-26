<!DOCTYPE html>
<html>
<head>
    <title>Payment Success</title>
    <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
</head>
<body>
    <?= $this->extend('/templates/index'); ?>
    <?= $this->section('content-user'); ?>
    
    <!-- Payment Success Section -->
    <div class="container my-5">
        <div class="text-center">
            <i class="fa-solid fa-check text-success fa-5x mb-4"></i>
            <h2 class="mb-4">Payment Successful!</h2>
            <p class="mb-4">Thank you for your purchase. Your order has been successfully placed and is being processed.</p>
            <a class="btn btn-dark" href="/home">
                <i class="fas fa-home"></i>
                Return to Home
            </a>
        </div>
    </div>
    
    <?= $this->endSection(); ?>
</body>
</html>
