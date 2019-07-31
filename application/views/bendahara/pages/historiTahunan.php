<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title product-sans">Histori Transaksi Pondok Pesantren Mawaridussalam</h4>
        <hr>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table" id="histori-transaksi-tahunan">
            <thead class="text-primary thead-dark">
              <tr>
                <th rowspan="2" scope="col" class="text-center">ID</th>
                <th rowspan="2" scope="col" class="text-center">Nama</th>
                <th rowspan="2" scope="col" class="text-center">Tahun Akademik</th>
                <th rowspan="2" scope="col" class="text-center">Tanggal Bayar</th>
                <th rowspan="2" scope="col" class="text-center">Nominal</th>
                <th colspan="2" scope="col" class="text-center">Aksi</th>
              </tr>
              <tr>
                <th scope="col" class="text-center">Cetak</th>
                <th scope="col" class="text-center">Hapus</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($historiTransaksi as $trx) : ?>

                <tr>
                  <td class="text-center"><?= $trx->id ?></td>
                  <td class="text-center"><?= $trx->namaSiswa ?></td>
                  <td class="text-center"><?= $trx->tahun_akademik ?></td>
                  <td class="text-center">
                    <?= DateTime::createFromFormat("Y-m-d", $trx->tanggal)->format("d-m-Y") ?>
                  </td>
                  <td class="text-center"><?= $trx->nominal ?></td>
                  <td class="text-center">
                    <a class="btn btn-success text-white" href="<?= base_url() ?>bendahara/cetakTahunan?sttb=<?= $trx->sttbSiswa ?>&no_ref=<?= $trx->no_ref ?>"><i class="fas fa-print"></i> Cetak</a>
                  </td>
                  <td class="text-center">
                    <a class="btn btn-danger text-white" href="<?= base_url() ?>bendahara/hapusTahunan?sttb=<?= $trx->sttbSiswa ?>&no_ref=<?= $trx->no_ref ?>"><i class="fas fa-trash-alt"></i> Hapus</a>
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
