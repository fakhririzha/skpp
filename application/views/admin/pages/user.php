<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title product-sans">Akun terdaftar</h4>
        <hr>
        <button class="btn btn-success" data-toggle="modal" data-target="#add-user-modal"><i class="fas fa-user-plus"></i> Tambah User</button>
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

        <!-- FORM UNTUK ADD USER -->
        <div class="modal fade" id="add-user-modal" tabindex="-1" role="dialog" aria-labelledby="add-user-modal-label" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="add-user-modal-label">Tambahkan user</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form action="<?= base_url() ?>admin/addUser" method="POST">

                  <!-- ALERT MESSAGE -->
                  <?php if ($this->session->flashdata('msgHead')) : ?>

                    <div class="alert alert-<?= $this->session->flashdata('msgType') ?> alert-dismissible fade show" role="alert">
                      <strong><?= $this->session->flashdata('msgHead') ?></strong> <?= $this->session->flashdata('msgText') ?>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>

                  <?php endif; ?>

                  <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" name="username" placeholder="Masukkan username..." required autofocus>
                  </div>
                  <div class="form-group">
                    <label for="katasandi">Password</label>
                    <input type="password" class="form-control" name="password" placeholder="**********" required>
                  </div>
                  <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" name="nama" placeholder="Masukkan nama..." required>
                  </div>
                  <div class="form-group">
                    <label for="katasandi">Jabatan</label>
                    <select name="jabatan" class="custom-select" required>
                      <option selected>Pilih jabatan</option>
                      <option value="admin">Admin</option>
                      <option value="bendahara">Bendahara</option>
                      <option value="staff">Staff</option>
                    </select>
                  </div>

                  <div class="card-footer text-center">
                    <input class="btn btn-primary btn-block" type="submit" name="addUser" value="Simpan">
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
              </div>
            </div>
          </div>
        </div>
        <!-- FORM UNTUK ADD USER -->
        <hr>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table" id="list-user">
            <thead class="text-primary">
              <tr>
                <th rowspan="2" scope="col" class="text-center">ID</th>
                <th rowspan="2" scope="col" class="text-center">Username</th>
                <th rowspan="2" scope="col" class="text-center">Nama</th>
                <th rowspan="2" scope="col" class="text-center">Terakhir Login</th>
                <th rowspan="2" scope="col" class="text-center">Jabatan</th>
                <th colspan="2" scope="col" class="text-center">Aksi</th>
              </tr>
              <tr>
                <th scope="col" class="text-center">Ubah</th>
                <th scope="col" class="text-center">Hapus</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($akuns as $akun) : ?>

                <tr>
                  <td class="text-center"><?= $akun->id ?></td>
                  <td class="text-center"><?= $akun->username ?></td>
                  <td class="text-center"><?= $akun->nama ?></td>
                  <td class="text-center">
                    <?= DateTime::createFromFormat("Y-m-d H:i:s", $akun->last_login)->format("d-m-Y H:i:s") ?>
                    <?php if ($akun->status == "logged_in") : ?>
                      <?= "(sedang aktif)" ?>
                    <?php endif; ?>
                  </td>
                  <td class="text-center"><?= ucfirst($akun->jabatan) ?></td>
                  <td class="text-center">
                    <?php if (($this->session->jabatan == $akun->jabatan) && ($this->session->username != $akun->username)) : ?>
                      <a class="btn btn-success text-white disabled" href="<?= base_url() ?>admin/editUser?username=<?= $akun->username ?>"><i class="fas fa-pencil-alt" aria-disabled="true"></i> Ubah</a>
                    <?php else : ?>
                      <a class="btn btn-success text-white" href="<?= base_url() ?>admin/editUser?username=<?= $akun->username ?>"><i class="fas fa-pencil-alt"></i> Ubah</a>
                    <?php endif; ?>
                  </td>
                  <td class="text-center">
                    <?php if (($this->session->jabatan == $akun->jabatan) && ($this->session->username != $akun->username)) : ?>
                      <a class="btn btn-danger text-white disabled" href="<?= base_url() ?>admin/hapusUser?username=<?= $akun->username ?>"><i class="fas fa-trash-alt" aria-disabled="true"></i> Hapus</a>
                    <?php else : ?>
                      <a class="btn btn-danger text-white" href="<?= base_url() ?>admin/hapusUser?username=<?= $akun->username ?>"><i class="fas fa-trash-alt"></i> Hapus</a>
                    <?php endif; ?>
                  </td>
                </tr>

              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
