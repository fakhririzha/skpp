<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title product-sans">Form Pemasukan Lainnya</h4>
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
        <!-- FORM UNTUK IURAN BULANAN -->
        <form action="" method="POST">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="tanggalTransaksi">Tanggal Bayar</label>
                <input type="text" class="form-control" name="tanggalTransaksi" value="<?= date("Y-m-d", time()) ?>" readonly>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="kodeTransaksi">Kode Transaksi</label>
                <select class="custom-select form-control" name="kodeTransaksi" required>
                  <option value="">Pilih kode</option>
                  <option value="3A">(3A) - Pemasukan Lainnya</option>
                  <option value="4A">(4A) - Saldo Awal</option>
                </select>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="keterangan">Keterangan</label>
                <input type="text" class="form-control" name="keterangan" required>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label for="nominalTransaksi">Nominal Transaksi</label>
              <input type="text" id="number-input" class="form-control" name="nominalTransaksi" required </div> </div> </div> <hr>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <input type="submit" class="btn btn-primary" name="addPemasukanLainnya" value="Simpan">
                  </div>
                </div>
              </div>
        </form>
        <!-- FORM UNTUK IURAN BULANAN -->
      </div>
    </div>
  </div>
</div>
