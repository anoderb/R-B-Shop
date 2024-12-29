<?= $this->extend('auth/templates/index'); ?>

<?= $this->section('content'); ?>
<div class="login-container">
    <div class="login-image-section">
        <img class="background-image" 
             src="https://storage.googleapis.com/a1aa/image/LxcTTsWnOT4OBJt6MxqgqUhiihyCWFvjk6y9YVUy0loFf37JA.jpg" 
             alt="Login background">
        <div class="login-image-content">
            <h2>Welcome Back!</h2>
            <p>Sign in to access your account and explore our latest collection of products.</p>
        </div>
    </div>
    
    <div class="login-form-section">
        <?= view('Myth\Auth\Views\_message_block') ?>

        <div class="login-header">
            <h1>Sign In</h1>
            <p>Please login to continue</p>
        </div>

        <form action="<?= url_to('login') ?>" method="post">
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="login">Email or Username</label>
                <input type="text" 
                       id="login"
                       class="form-control <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>"
                       name="login"
                       placeholder="Enter your email or username">
                <div class="invalid-feedback">
                    <?= session('errors.login') ?>
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" 
                       id="password"
                       class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>"
                       name="password"
                       placeholder="Enter your password">
                <div class="invalid-feedback">
                    <?= session('errors.password') ?>
                </div>
            </div>

            <?php if ($config->allowRemembering): ?>
            <div class="remember-me">
                <input type="checkbox" 
                       id="remember" 
                       name="remember" 
                       <?php if (old('remember')) : ?> checked <?php endif ?>>
                <label for="remember">Remember me</label>
            </div>
            <?php endif; ?>

            <button type="submit" class="btn-login">Sign In</button>

            <div class="divider"></div>
            
            <div class="register-link">
                Don't have an account? <a href="<?= url_to('register') ?>">Create one</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection(); ?>