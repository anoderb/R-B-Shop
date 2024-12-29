<?= $this->extend('/templates/index'); ?>
<?= $this->section('content-user'); ?>

<div class="profile-container">
    <div class="container py-5">
        <h2 class="section-title mb-4">User Profile</h2>
        
        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <div class="row g-4">
            <!-- Profile Information -->
            <div class="col-md-4">
                <div class="profile-section">
                    <div class="section-header">
                        <h4>Profile Picture</h4>
                        <span class="line"></span>
                    </div>
                    <div class="profile-card text-center">
                        <img alt="User profile picture" class="profile-image mb-3" src="<?= base_url(); ?>/img/<?= $user->user_image ?? 'default.svg'; ?>" />
                        <h5 class="mb-2"><?= $user->fullname; ?></h5>
                        <p class="text-muted mb-3"><?= $user->email; ?></p>
                        <button class="btn-edit" data-bs-toggle="modal" data-bs-target="#editFotoModal">
                            Edit Profile Picture
                        </button>
                    </div>
                </div>
            </div>

            <!-- Account Details -->
            <div class="col-md-8">
                <div class="profile-section">
                    <div class="section-header">
                        <h4>Account Details</h4>
                        <span class="line"></span>
                    </div>
                    <form action="<?= base_url('/user/updateProfile'); ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="form-group">
                            <label for="Nama_pelanggan">Full Name</label>
                            <input class="form-control" id="Nama_pelanggan" name="Nama_pelanggan" type="text" value="<?= $pelanggan['Nama_pelanggan'] ?? ''; ?>" />
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input class="form-control" id="username" name="username" type="text" value="<?= user()->username; ?>" />
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input class="form-control" id="email" name="email" type="email" value="<?= user()->email; ?>" />
                        </div>
                        <div class="form-group">
                            <label for="Hp">Phone Number</label>
                            <input class="form-control" id="Hp" name="Hp" type="text" value="<?= $pelanggan['Hp'] ?? ''; ?>" />
                        </div>
                        <div class="form-group">
                            <label for="Alamat">Address</label>
                            <input class="form-control" id="Alamat" name="Alamat" type="text" value="<?= $pelanggan['Alamat'] ?? ''; ?>" />
                        </div>
                        <div class="form-group">
                            <label for="Kota">City</label>
                            <input class="form-control" id="Kota" name="Kota" type="text" value="<?= $pelanggan['Kota'] ?? ''; ?>" />
                        </div>
                        <button class="btn-save" type="submit">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Foto -->
<div class="modal fade" id="editFotoModal" tabindex="-1" aria-labelledby="editFotoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('/user/updatePhoto'); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="editFotoModalLabel">Edit Profile Picture</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="user_image">Upload New Picture</label>
                        <input type="file" class="form-control" id="user_image" name="user_image" accept="image/*" required />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-save">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.profile-container {
    background-color: #f8f9fa;
    min-height: 100vh;
}

.section-title {
    font-size: 2rem;
    font-weight: 600;
    color: #000;
    margin-bottom: 2rem;
}

.profile-section {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    height: 100%;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
}

.section-header {
    margin-bottom: 2rem;
    position: relative;
}

.section-header h4 {
    font-size: 1.25rem;
    font-weight: 600;
    color: #000;
    margin: 0;
}

.section-header .line {
    display: block;
    width: 50px;
    height: 3px;
    background: #000;
    margin-top: 0.5rem;
}

.profile-card {
    padding: 1rem;
}

.profile-image {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #f8f9fa;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: #333;
}

.form-control {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid #dee2e6;
    border-radius: 10px;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #000;
    box-shadow: none;
    outline: none;
}

.btn-edit, .btn-save, .btn-cancel {
    padding: 0.75rem 1.5rem;
    border-radius: 50px;
    font-size: 0.875rem;
    font-weight: 500;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-edit {
    background: #000;
    color: white;
}

.btn-edit:hover {
    background: #333;
}

.btn-save {
    background: #000;
    color: white;
}

.btn-save:hover {
    background:rgb(51, 51, 51);
}

.btn-cancel {
    background: #dc3545;
    color: white;
}

.btn-cancel:hover {
    background: #c82333;
}

.modal-content {
    border-radius: 20px;
}

.modal-header {
    border-bottom: none;
    padding: 1.5rem;
}

.modal-body {
    padding: 1.5rem;
}

.modal-footer {
    border-top: none;
    padding: 1.5rem;
}

@media (max-width: 768px) {
    .profile-section {
        padding: 1.5rem;
        margin-bottom: 1rem;
    }
    
    .btn-edit, .btn-save, .btn-cancel {
        width: 100%;
        margin-bottom: 0.5rem;
    }
}
</style>

<?= $this->endSection(); ?>