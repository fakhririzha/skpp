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
          <hr>
        <?php endif; ?>
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
                <label for="semester">Semester</label>
                <select name="semester" class="custom-select form-control" required>
                  <option value="">Pilih semester</option>
                  <option value="A">Ganjil</option>
                  <option value="B">Genap</option>
                </select>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="nominalBayar">Nominal Bayar</label>
                <?php if ($nominalBayar->status == "subsidi") : ?>
                  <input type="text" class="form-control" name="nominalBayar" value="<?= $nominalBayar->iuran_bulanan_subsidi ?>" readonly>
                <?php else if ($nominalBayar->status == "wargasekitar") : ?>
                  <input type="text" class="form-control" name="nominalBayar" value="<?= $nominalBayar->iuran_bulanan_warga_sekitar ?>" readonly>
                <?php else if ($nominalBayar->status == "saudara1") : ?>
                  <input type="text" class="form-control" name="nominalBayar" value="<?= $nominalBayar->iuran_bulanan_saudara1 ?>" readonly>
                <?php else if ($nominalBayar->status == "saudara2") : ?>
                  <input type="text" class="form-control" name="nominalBayar" value="<?= $nominalBayar->iuran_bulanan_saudara2 ?>" readonly>
                <?php else if ($nominalBayar->status == "saudara3") : ?>
                  <input type="text" class="form-control" name="nominalBayar" value="<?= $nominalBayar->iuran_bulanan_saudara3 ?>" readonly>
                <?php else if ($nominalBayar->status == "saudara4") : ?>
                  <input type="text" class="form-control" name="nominalBayar" value="<?= $nominalBayar->iuran_bulanan_saudara4 ?>" readonly>
                <?php else if ($nominalBayar->status == "saudara5") : ?>
                  <input type="text" class="form-control" name="nominalBayar" value="<?= $nominalBayar->iuran_bulanan_saudara5 ?>" readonly>
                <?php else if ($nominalBayar->status == "beasiswa") : ?>
                  <input type="text" class="form-control" name="nominalBayar" value="<?= $nominalBayar->iuran_bulanan_beasiswa ?>" readonly>
                <?php else if ($nominalBayar->status == "laziswa") : ?>
                  <input type="text" class="form-control" name="nominalBayar" value="<?= $nominalBayar->iuran_bulanan_laziswa ?>" readonly>
                <?php else : ?>
                  <input type="text" class="form-control" name="nominalBayar" value="<?= $nominalBayar->iuran_bulanan ?>" readonly>
                <?php endif; ?>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="bulanBayar">Bulan Bayar</label>
                <select name="bulanBayar" class="custom-select form-control" required>
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
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <input type="submit" class="btn btn-primary" name="bayarBulanan" value="Simpan">
              </div>
            </div>
          </div>
        </form>
        <!-- FORM UNTUK IURAN BULANAN -->
      </div>
    </div>
  </div>
</div>
