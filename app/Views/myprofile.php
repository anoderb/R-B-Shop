<?= $this->extend('/templates/index'); ?>
<?= $this->section('content-user'); ?>

<div class="container my-5">
    <h2 class="mb-4">User Profile</h2>
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-body text-center">
                    <img alt="User profile picture" class="img-fluid rounded-circle mb-3" height="150" width="150" src="<?= base_url('/img/' . $user['user_image']); ?>" />
                    <h5 class="card-title"><?= esc($user['fullname']); ?></h5>
                    <p class="card-text"><?= esc($user['email']); ?></p>
                    <a class="btn btn-dark" href="#">Edit Foto Profile</a>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Account Details</h5>
                    <form>
                        <div class="mb-3">
                            <label class="form-label" for="fullName">Nama Lengkap</label>
                            <input class="form-control" id="fullName" type="text" value="<?= esc($user['fullname']); ?>" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="username">Username</label>
                            <input class="form-control" id="username" type="text" value="<?= esc($user['username']); ?>" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="email">Email</label>
                            <input class="form-control" id="email" type="email" value="<?= esc($user['email']); ?>" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="hp">Nomor HP</label>
                            <input class="form-control" id="hp" type="text" value="<?= esc($pelanggan['Hp']); ?>" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="alamat">Alamat</label>
                            <input class="form-control" id="alamat" type="text" value="<?= esc($pelanggan['Alamat']); ?>" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="kota">Kota</label>
                            <input class="form-control" id="kota" type="text" value="<?= esc($pelanggan['Kota']); ?>" />
                        </div>
                        <button class="btn btn-dark" type="submit">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
