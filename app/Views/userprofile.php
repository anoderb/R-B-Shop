<?= $this->extend('/templates/index'); ?>
<?= $this->section('content-user'); ?>

<div class="container my-5">
    <h2 class="mb-4">User Profile</h2>
    <div class="row">
        <!-- Profile Information -->
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-body text-center">
                    <img alt="User profile picture" class="img-fluid rounded-circle mb-3" height="150" width="150" src="<?= base_url(); ?>/img/<?= $user->user_image ?? 'default.svg'; ?>" />
                    <h5 class="card-title"><?= $user->fullname; ?></h5>
                    <p class="card-text"><?= $user->email; ?></p>
                    <a class="btn btn-dark mb-3" data-bs-toggle="modal" data-bs-target="#editFotoModal">
                        Edit Foto Profile
                    </a>

                    <!-- Modal Edit Foto -->
                    <div class="modal fade" id="editFotoModal" tabindex="-1" aria-labelledby="editFotoModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="<?= base_url('/user/updatePhoto'); ?>" method="post" enctype="multipart/form-data">
                                    <?= csrf_field(); ?>
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editFotoModalLabel">Edit Foto Profile</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="user_image" class="form-label">Upload Foto Baru</label>
                                            <input type="file" class="form-control" id="user_image" name="user_image" accept="image/*" required />
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-dark">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Account Details -->
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Account Details</h5>
                    <form action="<?= base_url('/user/updateProfile'); ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="mb-3">
                            <label class="form-label" for="Nama_pelanggan">Nama Lengkap</label>
                            <input class="form-control" id="Nama_pelanggan" name="Nama_pelanggan" type="text" value="<?= $pelanggan['Nama_pelanggan'] ?? ''; ?>" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="username">Username</label>
                            <input class="form-control" id="username" name="username" type="text" value="<?= user()->username; ?>" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="email">Email</label>
                            <input class="form-control" id="email" name="email" type="email" value="<?= user()->email; ?>" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="Hp">Nomor HP</label>
                            <input class="form-control" id="Hp" name="Hp" type="text" value="<?= $pelanggan['Hp'] ?? ''; ?>" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="Alamat">Alamat</label>
                            <input class="form-control" id="Alamat" name="Alamat" type="text" value="<?= $pelanggan['Alamat'] ?? ''; ?>" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="Kota">Kota</label>
                            <input class="form-control" id="Kota" name="Kota" type="text" value="<?= $pelanggan['Kota'] ?? ''; ?>" />
                        </div>
                        <button class="btn btn-dark" type="submit">Save Changes</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>