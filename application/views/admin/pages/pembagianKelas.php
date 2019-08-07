<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title product-sans">Siswa terdaftar belum ada kelas</h4>
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
      </div>
      <div class="card-body">
        <form action="<?= base_url() ?>admin/pembagianKelasAction" method="POST">
          <div class="form-group">
            <label for="kelas">Filter Kelas</label>
            <select name="kelas" class="form-control custom-select" required>
              <option selected>Pilih kelas</option>
              <?php foreach ($kelass as $kelas) : ?>
                <option value="<?= $kelas->kode_kelas ?>"><?= $kelas->kode_kelas ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <hr>
          <?php if (isset($siswas)) : ?>
            <div class="table-responsive">
              <table class="table" id="list-pembagian-kelas">
                <thead class="text-primary thead-dark">
                  <tr>
                    <th scope="col" class="text-center">Cek</th>
                    <th scope="col" class="text-center">No. STTB</th>
                    <th scope="col" class="text-center">Nama</th>
                    <th scope="col" class="text-center">Jenis Kelamin</th>
                    <th scope="col" class="text-center">Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($siswas as $siswa) : ?>

                    <tr>
                      <td class="text-center">
                        <input type="checkbox" name="sttb[]" value="<?= $siswa->sttb ?>">
                      </td>
                      <td class="text-center"><?= $siswa->sttb ?></td>
                      <td class="text-center"><?= $siswa->nama ?></td>
                      <td class="text-center"><?= ucfirst($siswa->jenis_kelamin) ?></td>
                      <td class="text-center"><?= ucfirst($siswa->status) ?></td>
                    </tr>

                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          <?php endif; ?>
          <div class="form-group">
            <input type="submit" class="btn btn-block btn-primary" name="simpanSiswa" value="Simpan">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
