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
                <label for="sttb">No. STTB</label>
                <input type="text" class="form-control" name="sttb" value="<?= $siswa->sttb ?>" required>
                <input type="hidden" name="oldSttb" value="<?= $siswa->sttb ?>">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" class="form-control" name="nama" value="<?= $siswa->nama ?>" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="kelas">Kelas</label>
                <select name="kelas" class="form-control custom-select" required>
                  <option value="<?= $siswa->kode_kelas ?>"><?= $siswa->kode_kelas ?></option>
                  <?php foreach ($kelass as $kelas) : ?>
                    <option value="<?= $kelas->kode_kelas ?>"><?= $kelas->kode_kelas ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="jenisKelamin">Jenis Kelamin</label>
                <select name="jenisKelamin" class="custom-select form-control" required>
                  <option value="<?= $siswa->jenis_kelamin ?>"><?= ucfirst($siswa->jenis_kelamin) ?></option>
                  <option value="laki-laki">Laki-laki</option>
                  <option value="perempuan">Perempuan</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="status">Status</label>
                <select name="status" class="custom-select form-control" required>
                  <option value="<?= $siswa->status ?>"><?= ucfirst($siswa->status) ?></option>
                  <option value="subsidi">Subsidi</option>
                  <option value="non-subsidi">Non-subsidi</option>
                </select>
              </div>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <input type="submit" class="btn btn-primary" name="editSiswa" value="Simpan">
              </div>
            </div>
          </div>
        </form>
        <!-- FORM UNTUK ADD USER -->
      </div>
    </div>
  </div>
</div>
