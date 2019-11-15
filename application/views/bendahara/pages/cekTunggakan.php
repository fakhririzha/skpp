<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title product-sans">Cek Tunggakan Pondok Pesantren Mawaridussalam</h4>
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
          <div class="container">
            <div class="row">
              <div class="form-group col-md-6">
                <label for="kelas">Filter Bulan</label>
                <select name="bulan" class="form-control custom-select" required>
                  <option value="">Pilih bulan</option>
                  <option value="1">Juli</option>
                  <option value="2">Agustus</option>
                  <option value="3">September</option>
                  <option value="4">Oktober</option>
                  <option value="5">November</option>
                  <option value="6">Desember</option>
                  <option value="7">Januari</option>
                  <option value="8">Februari</option>
                  <option value="9">Maret</option>
                  <option value="10">April</option>
                  <option value="11">Mei</option>
                  <option value="12">Juni</option>
                </select>
              </div>
              <div class="form-group col-md-6">
                <label for="tahun_akademik">Tahun Akademik</label>
                <input type="text" class="form-control" name="tahun_akademik" value="<?= $tahun_akademik->tahun_akademik ?>" readonly>
              </div>
            </div>
          </div>
          <div class="form-group">
            <input type="submit" class="btn btn-block btn-primary" name="filterBulanTunggakan" value="Filter">
          </div>
        </form>
      </div>
      <div class="card-body">
        <em>Perlu diketahui bahwa bulan tagihan ke-1 adalah bulan juli.</em>
        <?php if (isset($cekTunggakanBulanan)) : ?>

          <div class="table-responsive">
            <table class="table" id="tunggakan">
              <thead class="text-primary thead-dark">
                <tr>
                  <th scope="col" class="text-center">No</th>
                  <th scope="col" class="text-center">Nama</th>
                  <th scope="col" class="text-center">Kelas</th>
                  <th scope="col" class="text-center">Deskripsi</th>
                  <th scope="col" class="text-center">Tagihan</th>
                  <th scope="col" class="text-center">Keterangan</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($cekTunggakanBulanan as $trx) : ?>
                  <?php
                  $blnSkrg = $bulanMaks;
                  ?>
                  <tr>
                    <td class="text-center">&nbsp;</td>
                    <td class="text-center"><?= $trx->nama ?></td>
                    <td class="text-center"><?= $trx->kode_kelas ?></td>
                    <td class="text-center">Bulan
                      <?php for ($i = ($trx->bulan_bayar) + 1, $x = 0; $i <= $blnSkrg; $i++, $x++) : ?>
                        <?php if ($i == $blnSkrg) : ?>
                          <?php
                          if ($i < 7) {
                            $y = $i + 6;
                          } else {
                            $y = $i - 6;
                          }
                          ?>
                          <?= $y ?>
                        <?php else : ?>
                          <?php
                          if ($i < 7) {
                            $y = $i + 6;
                          } else {
                            $y = $i - 6;
                          }
                          ?>
                          <?= $y ?>,&nbsp;
                        <?php endif; ?>
                      <?php endfor; ?>
                    </td>
                    <td class="text-center">Rp. <?= number_format(($trx->nominal) * $x, 0, ',', '.') ?></td>
                    <td class="text-center">Iuran Bulanan</td>
                  </tr>

                <?php endforeach; ?>
                <?php foreach ($cekTunggakanTahunan as $trx) : ?>
                  <tr>
                    <td class="text-center">&nbsp;</td>
                    <td class="text-center"><?= $trx->nama ?></td>
                    <td class="text-center"><?= $trx->kode_kelas ?></td>
                    <td class="text-center">
                      Terbayar Rp. <?= number_format(($trx->nominal), 0, ',', '.') ?>
                    </td>
                    <td class="text-center">Rp. <?= number_format(($trx->iuran_tahunan - $trx->nominal), 0, ',', '.') ?></td>
                    <td class="text-center">Iuran Tahunan</td>
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
