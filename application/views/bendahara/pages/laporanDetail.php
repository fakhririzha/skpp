<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title product-sans">Laporan Detail</h4>
        <hr>
        <form action="" method="POST">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="bulan">Bulan</label>
                <select name="bulan" class="form-control custom-select" required>
                  <option value="">Pilih bulan</option>
                  <option value="01">Januari</option>
                  <option value="02">Februari</option>
                  <option value="03">Maret</option>
                  <option value="04">April</option>
                  <option value="05">Mei</option>
                  <option value="06">Juni</option>
                  <option value="07">Juli</option>
                  <option value="08">Agustus</option>
                  <option value="09">September</option>
                  <option value="10">Oktober</option>
                  <option value="11">September</option>
                  <option value="12">Desember</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="tahun">Tahun</label>
                <select name="tahun" class="form-control custom-select" required>
                  <option value="">Pilih tahun</option>
                  <?php for ($i = (int) date("Y", time()); $i >= 2015; $i--) : ?>
                    <option value="<?= $i ?>"><?= $i ?></option>
                  <?php endfor; ?>
                </select>
              </div>
            </div>
            <div class="col-md-12">
              <div class=" form-group">
                <input type="submit" class="btn btn-block btn-primary" name="filterRentang" value="Filter">
              </div>
            </div>
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
                      <a class="btn btn-success text-white" href="<?= base_url() ?>bendahara/bayarBulanan?sttb=<?= $siswa->sttb ?>"><i class="fas fa-cash-register"></i> Bayar</a>
                    </td>
                    <td class="text-center">
                      <a class="btn btn-primary text-white" href="<?= base_url() ?>bendahara/historiBulanan?sttb=<?= $siswa->sttb ?>"><i class="fas fa-history"></i> Histori</a>
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
