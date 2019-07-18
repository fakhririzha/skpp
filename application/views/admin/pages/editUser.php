<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title product-sans">Edit User</h4>
        <?php if ($this->session->suksesMsg != "") : ?>
          <hr>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('suksesMsg') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <?php elseif ($this->session->actionMsg != "") : ?>
          <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('actionMsg') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <?php endif; ?>
        <hr>
      </div>
      <div class="card-body">
        <!-- FORM UNTUK ADD USER -->
        <form action="" method="POST">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" class="form-control" name="nama" value="<?= $user->nama ?>" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username" value="<?= $user->username ?>" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="jabatan">Jabatan <small>(sebelumnya: <?= ucfirst($user->jabatan) ?>)</small></label>
                <select name="jabatan" class="custom-select form-control" required>
                  <option value="">Pilih Jabatan</option>
                  <option value="admin">Admin</option>
                  <option value="bendahara">Bendahara</option>
                  <option value="staff">Staff</option>
                </select>
              </div>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <input type="submit" class="btn btn-primary" name="editUser" value="Simpan">
              </div>
            </div>
          </div>
        </form>
        <!-- FORM UNTUK ADD USER -->
      </div>
    </div>
  </div>
</div>
