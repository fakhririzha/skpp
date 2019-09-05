<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title product-sans">Histori Transaksi Pondok Pesantren Mawaridussalam</h4>
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
          <table class="table" id="histori-pemasukan">
            <thead class="text-primary thead-dark">
              <tr>
                <th rowspan="2" scope="col" class="text-center">ID</th>
                <th rowspan="2" scope="col" class="text-center">No. Ref</th>
                <th rowspan="2" scope="col" class="text-center">Kode</th>
                <th rowspan="2" scope="col" class="text-center">Tanggal</th>
                <th rowspan="2" scope="col" class="text-center">Keterangan</th>
                <th rowspan="2" scope="col" class="text-center">Nominal</th>
                <th colspan="2" scope="col" class="text-center">Aksi</th>
              </tr>
              <tr>
                <th scope="col" class="text-center">Ubah</th>
                <th scope="col" class="text-center">Hapus</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($historiPemasukan as $trx) : ?>

                <tr>
                  <td class="text-center"><?= $trx->id ?></td>
                  <td class="text-center"><?= $trx->no_ref ?></td>
                  <td class="text-center"><?= $trx->kode ?></td>
                  <td class="text-center"><?= $trx->tanggal ?></td>
                  <td class="text-center"><?= $trx->keterangan ?></td>
                  <td class="text-center"><?= "Rp. " . number_format($trx->nominal, 0, ',', '.') ?></td>
                  <td class="text-center">
                    <a class="btn btn-success text-white" href="<?= base_url() ?>bendahara/ubahPemasukanLainnya?no_ref=<?= $trx->no_ref ?>"><i class="fas fa-pencil-alt"></i> Ubah</a>
                  </td>
                  <td class="text-center">
                    <button class="btn btn-danger text-white" data-toggle="modal" data-target="#hapus-pemasukan-<?= $trx->no_ref ?>-modal"><i class="fas fa-trash-alt"></i> Hapus</button>
                    <!--  -->
                    <div class="modal fade" id="hapus-pemasukan-<?= $trx->no_ref ?>-modal" tabindex="-1" role="dialog" aria-labelledby="hapus-kelas-modal-label" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="hapus-kelas-modal-label">Konfirmasi Hapus Transaksi Pemasukan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <p>Apakah anda yakin akan menghapus transaksi pemasukan dengan No. Ref <?= $trx->no_ref ?> ?</p>
                            <p>Aksi ini tidak dapat dibatalkan setelah anda menekan tombol hapus!</p>
                          </div>
                          <div class="modal-footer">
                            <a href="<?= base_url() ?>bendahara/hapusPemasukanLainnya?no_ref=<?= $trx->no_ref ?>" class="btn btn-danger text-white"> Hapus</a>
                            &nbsp;&nbsp;|&nbsp;&nbsp;
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                          </div>
                        </div>
                      </div>
                    </div>
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
