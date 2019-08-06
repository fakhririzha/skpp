<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title product-sans">Edit Kelas</h4>
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
        <!-- FORM UNTUK ADD USER -->
        <form action="<?= base_url() ?>admin/editKelas" method="POST">

          <div class="form-group">
            <label for="kodeKelas">Kode Kelas</label>
            <input type="text" class="form-control" name="kodeKelas" value="<?= $kelas->kode_kelas ?>" required readonly>
          </div>
          <div class="row">
            <div class="form-group col-md-6">
              <label for="semester">Kode Kelas</label>
              <input type="text" class="form-control" value="<?= $kelas->semester ?>" required readonly>
            </div>
            <div class="form-group col-md-6">
              <label for="tahun_akademik">Kode Kelas</label>
              <input type="text" class="form-control" value="<?= $kelas->tahun_akademik ?>" required readonly>
            </div>
          </div>
          <div class="form-group">
            <label for="iuranBulanan">Iuran Bulanan</label>
            <input type="text" id="number-input" class="form-control" name="iuranBulanan" value="<?= $kelas->iuran_bulanan ?>" required autofocus>
          </div>
          <div class="form-group">
            <label for="iuranBulananSubsidi">Iuran Bulanan Subsidi</label>
            <input type="text" id="number-input-2" class="form-control" name="iuranBulananSubsidi" value="<?= $kelas->iuran_bulanan_subsidi ?>" required autofocus>
          </div>
          <div class="form-group">
            <label for="iuranTahunan">Iuran Tahunan</label>
            <input type="text" id="number-input-3" class="form-control" name="iuranTahunan" value="<?= $kelas->iuran_tahunan ?>" required autofocus>
          </div>

          <div class="card-footer text-center">
            <input class="btn btn-primary btn-block" type="submit" name="editKelas" value="Simpan">
          </div>

        </form>
        <!-- FORM UNTUK ADD USER -->
      </div>
    </div>
  </div>
</div>
