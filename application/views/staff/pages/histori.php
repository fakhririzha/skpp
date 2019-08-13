<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title product-sans">Histori Transaksi Pondok Pesantren Mawaridussalam</h4>
        <hr>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table" id="histori-transaksi">
            <thead class="text-primary thead-dark">
              <tr>
                <th scope="col" class="text-center">ID</th>
                <th scope="col" class="text-center">Kode</th>
                <th scope="col" class="text-center">Keterangan</th>
                <th scope="col" class="text-center">Tanggal</th>
                <th scope="col" class="text-center">Nominal</th>
                <th scope="col" class="text-center">Status</th>
                <th scope="col" class="text-center">Petugas</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($historiTransaksi as $trx) : ?>

                <tr>
                  <td class="text-center"><?= $trx->id ?></td>
                  <td class="text-center"><?= $trx->kode ?></td>
                  <td class="text-center"><?= $trx->keterangan ?></td>
                  <td class="text-center">
                    <?= DateTime::createFromFormat("Y-m-d", $trx->tanggal)->format("d-m-Y") ?>
                  </td>
                  <td class="text-center">Rp. <?= $trx->nominal ?></td>
                  <td class="text-center"><?= 'Selesai' ?></td>
                  <!-- <td class="text-center"><?= strtoupper($trx->status) ?></td> -->
                  <td class="text-center"><?= $trx->nama ?></td>
                </tr>

              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
