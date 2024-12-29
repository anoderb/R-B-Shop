<?= $this->extend('auth/templates/index'); ?>

<?= $this->section('content'); ?>
<div class="login-container">
    <div class="login-image-section">
        <img class="background-image" 
             src="https://storage.googleapis.com/a1aa/image/LxcTTsWnOT4OBJt6MxqgqUhiihyCWFvjk6y9YVUy0loFf37JA.jpg" 
             alt="Register background">
        <div class="login-image-content">
            <h2>Join Our Community</h2>
            <p>Create an account to start shopping and get access to exclusive offers.</p>
        </div>
    </div>
    
    <div class="login-form-section">
        <?= view('Myth\Auth\Views\_message_block') ?>

        <div class="login-header">
            <h1>Create Account</h1>
            <p>Fill in your details to register</p>
        </div>

        <form action="<?= url_to('register') ?>" method="post">
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" 
                       id="username"
                       class="form-control <?php if (session('errors.username')) : ?>is-invalid<?php endif ?>"
                       name="username"
                       placeholder="Choose your username"
                       value="<?= old('username') ?>">
                <div class="invalid-feedback">
                    <?= session('errors.username') ?>
                </div>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" 
                       id="email"
                       class="form-control <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>"
                       name="email"
                       placeholder="Enter your email"
                       value="<?= old('email') ?>">
                <div class="invalid-feedback">
                    <?= session('errors.email') ?>
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" 
                       id="password"
                       class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>"
                       name="password"
                       placeholder="Create a password"
                       autocomplete="off">
                <div class="invalid-feedback">
                    <?= session('errors.password') ?>
                </div>
            </div>

            <div class="form-group">
                <label for="pass_confirm">Confirm Password</label>
                <input type="password" 
                       id="pass_confirm"
                       class="form-control <?php if (session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>"
                       name="pass_confirm"
                       placeholder="Repeat your password"
                       autocomplete="off">
                <div class="invalid-feedback">
                    <?= session('errors.pass_confirm') ?>
                </div>
            </div>

            <button type="submit" class="btn-login">Create Account</button>

            <div class="divider"></div>
            
            <div class="register-link">
                Already have an account? <a href="<?= url_to('login') ?>"><?=lang('Auth.signIn')?></a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection(); ?>