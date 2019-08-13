<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title product-sans">Form Iuran Bulanan</h4>
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
      </div>
      <div class="card-body">
        <?php if (isset($siswas)) : ?>
          <div class="table-responsive">
            <table class="table" id="iuran-bulanan">
              <thead class="text-primary thead-dark">
                <tr>
                  <th rowspan="2" scope="col" class="text-center">No. STTB</th>
                  <th rowspan="2" scope="col" class="text-center">Nama</th>
                  <th rowspan="2" scope="col" class="text-center">Kelas</th>
                  <th rowspan="2" scope="col" class="text-center">Status</th>
                  <th colspan="2" scope="col" class="text-center">Aksi</th>
                </tr>
                <tr>
                  <th scope="col" class="text-center">Bayar</th>
                  <th scope="col" class="text-center">Histori</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($siswas as $siswa) : ?>

                  <tr>
                    <td class="text-center"><?= $siswa->sttb ?></td>
                    <td class="text-center"><?= $siswa->nama ?></td>
                    <td class="text-center"><?= $siswa->kode_kelas ?></td>
                    <td class="text-center"><?= ucfirst($siswa->status) ?></td>
                    <td class="text-center">
                      <a class="btn btn-success text-white" href="<?= base_url() ?>staff/bayarBulanan?sttb=<?= $siswa->sttb ?>"><i class="fas fa-cash-register"></i> Bayar</a>
                    </td>
                    <td class="text-center">
                      <a class="btn btn-primary text-white" href="<?= base_url() ?>staff/historiBulanan?sttb=<?= $siswa->sttb ?>"><i class="fas fa-history"></i> Histori</a>
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
