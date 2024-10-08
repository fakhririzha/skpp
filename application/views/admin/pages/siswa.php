<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title product-sans">Siswa terdaftar</h4>
        <hr>
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
        <button class="btn btn-success" data-toggle="modal" data-target="#add-siswa-modal"><i class="fas fa-user-plus"></i> Tambah Siswa</button>
        <hr>
        <form action="" method="POST">
          <div class="form-group">
            <label for="kelas">Filter Kelas</label>
            <select name="kelas" class="form-control custom-select" required>
              <option selected>Pilih kelas</option>
              <?php foreach ($kelass as $kelas) : ?>
                <option value="<?= $kelas->kode_kelas ?>"><?= $kelas->kode_kelas ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <input type="submit" class="btn btn-block btn-primary" name="filterKelas" value="Filter">
          </div>
        </form>
        <hr>
        <!-- FORM UNTUK ADD SISWA -->
        <div class="modal fade" id="add-siswa-modal" tabindex="-1" role="dialog" aria-labelledby="add-siswa-modal-label" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="add-siswa-modal-label">Tambahkan siswa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form action="<?= base_url() ?>admin/addSiswa" method="POST">

                  <div class="form-group">
                    <label for="sttb">No. STTB</label>
                    <input type="number" class="form-control" name="sttb" placeholder="Masukkan No. STTB" required autofocus>
                  </div>
                  <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" name="nama" placeholder="Masukkan nama" required>
                  </div>
                  <div class="form-group">
                    <label for="kodeKelas">Kelas</label>
                    <select name="kodeKelas" class="custom-select form-control" required>
                      <option value="">Pilih kelas</option>
                      <?php foreach ($kelass as $kelas) : ?>
                        <option value="<?= $kelas->kode_kelas ?>"><?= $kelas->kode_kelas ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="jenisKelamin">Jenis Kelamin</label>
                    <select name="jenisKelamin" class="custom-select form-control" required>
                      <option value="">Pilih jenis kelamin</option>
                      <option value="laki-laki">Laki-Laki</option>
                      <option value="perempuan">Perempuan</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" class="custom-select form-control" required>
                      <option value="">Pilih status subsidi</option>
                      <option value="wargasekitar">Warga Setempat</option>
                      <option value="saudara1">Saudara 1</option>
                      <option value="saudara2">Saudara 2</option>
                      <option value="saudara3">Saudara 3</option>
                      <option value="saudara4">Saudara 4</option>
                      <option value="saudara5">Saudara 5</option>
                      <option value="beasiswa">Beasiswa</option>
                      <option value="laziswa">Laziswa</option>
                      <option value="non-subsidi">Non-subsidi</option>
                    </select>
                  </div>

                  <div class="card-footer text-center">
                    <input class="btn btn-primary btn-block" type="submit" name="addSiswa" value="Simpan">
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
      </div>
      <div class="card-body">
        <?php if (isset($siswas)) : ?>
          <div class="table-responsive">
            <table class="table" id="list-siswa">
              <thead class="text-primary thead-dark">
                <tr>
                  <th rowspan="2" scope="col" class="text-center">No. STTB</th>
                  <th rowspan="2" scope="col" class="text-center">Nama</th>
                  <th rowspan="2" scope="col" class="text-center">Kelas</th>
                  <th rowspan="2" scope="col" class="text-center">Jenis Kelamin</th>
                  <th rowspan="2" scope="col" class="text-center">Status</th>
                  <th colspan="2" scope="col" class="text-center">Aksi</th>
                </tr>
                <tr>
                  <th scope="col" class="text-center">Ubah</th>
                  <th scope="col" class="text-center">Hapus</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($siswas as $siswa) : ?>

                  <tr>
                    <td class="text-center"><?= $siswa->sttb ?></td>
                    <td class="text-center"><?= $siswa->nama ?></td>
                    <td class="text-center"><?= $siswa->kode_kelas ?></td>
                    <td class="text-center"><?= ucfirst($siswa->jenis_kelamin) ?></td>
                    <td class="text-center"><?= ucfirst($siswa->status) ?></td>
                    <td class="text-center">
                      <a class="btn btn-success text-white" href="<?= base_url() ?>admin/editSiswa?sttb=<?= $siswa->sttb ?>"><i class="fas fa-pencil-alt"></i> Ubah</a>
                    </td>
                    <td class="text-center">
                      <a class="btn btn-danger text-white" href="<?= base_url() ?>admin/hapusSiswa?sttb=<?= $siswa->sttb ?>"><i class="fas fa-trash-alt"></i> Hapus</a>
                    </td>
                  </tr>

                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
