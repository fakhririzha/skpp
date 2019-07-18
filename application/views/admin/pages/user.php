<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Akun terdaftar</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table" id="list-user">
            <thead class="text-primary">
              <tr>
                <th rowspan="2" scope="col" class="text-center">ID</th>
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
                  <td class="text-center"><?= $akun->nama ?></td>
                  <td class="text-center">
                    <?= DateTime::createFromFormat("Y-m-d H:i:s", $akun->last_login)->format("d-m-Y H:i:s") ?>
                    <?php if ($akun->status == "logged_in") : ?>
                      <?= "(sedang aktif)" ?>
                    <?php endif; ?>
                  </td>
                  <td class="text-center"><?= ucfirst($akun->jabatan) ?></td>
                  <td class="text-center">
                    <a class="btn btn-success text-white" href="<?= base_url() ?>admin/editUser?username=<?= $akun->username ?>"><i class="fas fa-pencil-alt"></i> Ubah</a>
                  </td>
                  <td class="text-center">
                    <a class="btn btn-danger text-white" href="<?= base_url() ?>admin/hapusUser?username=<?= $akun->username ?>"><i class="fas fa-trash-alt"></i> Hapus</a>
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
