<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title product-sans">Form Iuran Tahunan</h4>
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
                <label for="sttb">No. STTB</label>
                <input type="text" class="form-control" name="sttb_x" value="<?= $siswa->sttb ?>" readonly>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" class="form-control" name="nama" value="<?= $siswa->nama ?>" readonly>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="kelas">Kelas</label>
                <input type="text" class="form-control" name="kelas" value="<?= $siswa->kode_kelas ?>" readonly>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="status">Status</label>
                <input type="text" class="form-control" name="status" value="<?= ucfirst($siswa->status) ?>" readonly>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="status">Tanggal Bayar</label>
                <input type="text" id="date-input" class="form-control" name="tanggalBayar" value="<?= date("Y-m-d", time()) ?>">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="status">Tahun Akademik</label>
                <input type="text" class="form-control" name="tahunAkademik" value="<?= $siswa->tahun_akademik ?>">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="nominalBayar">Nominal Bayar</label>
                <input type="text" id="number-input" class="form-control" name="nominalBayar" required autofocus>
              </div>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <input type="submit" class="btn btn-primary" name="bayarTahunan" value="Simpan">
              </div>
            </div>
          </div>
        </form>
        <!-- FORM UNTUK IURAN BULANAN -->
      </div>
    </div>
  </div>
</div>
