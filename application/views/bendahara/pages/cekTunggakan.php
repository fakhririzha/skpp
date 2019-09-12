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
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table" id="tunggakan">
            <thead class="text-primary thead-dark">
              <tr>
                <th rowspan="2" scope="col" class="text-center">No</th>
                <th rowspan="2" scope="col" class="text-center">Nama</th>
                <th rowspan="2" scope="col" class="text-center">Kelas</th>
                <th rowspan="2" scope="col" class="text-center">Bulan</th>
                <th rowspan="2" scope="col" class="text-center">Jumlah</th>
                <th rowspan="2" scope="col" class="text-center">Keterangan</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($cekTunggakanBulanan as $trx) : ?>
                <?php
                  $blnSkrg = (int) date("m", time());
                ?>
                <?php for($i =$trx->bulan_bayar; $i<=$blnSkrg; $i++): ?>
                <tr>
                  <td class="text-center">&nbsp;</td>
                  <td class="text-center"><?= $trx->nama ?></td>
                  <td class="text-center"><?= $trx->kode_kelas ?></td>
                  <td class="text-center"><?= $i ?></td>
                  <td class="text-center"><?= $trx->nominal ?></td>
                  <td class="text-center">&nbsp;</td>
                </tr>
                <?php endfor; ?>

              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
