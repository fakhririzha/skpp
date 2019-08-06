<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title product-sans">Daftar Kelas Tersedia</h4>
        <hr>
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
        <button class="btn btn-success" data-toggle="modal" data-target="#add-kelas-modal"><i class="fas fa-user-plus"></i> Tambah Kelas</button>
        <hr>

        <!-- FORM UNTUK ADD KELAS -->
        <div class="modal fade" id="add-kelas-modal" tabindex="-1" role="dialog" aria-labelledby="add-kelas-modal-label" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="add-kelass-modal-label">Tambahkan siswa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form action="<?= base_url() ?>admin/addKelas" method="POST">

                  <div class="form-group">
                    <label for="kodeKelas">Kode Kelas</label>
                    <input type="text" class="form-control" name="kodeKelas" placeholder="Masukkan Kode Kelas" required autofocus>
                  </div>
                  <div class="form-group">
                    <label for="iuranBulanan">Iuran Bulanan</label>
                    <input type="text" id="number-input" class="form-control" name="iuranBulanan" placeholder="Masukkan Iuran Bulanan" required autofocus>
                  </div>
                  <div class="form-group">
                    <label for="iuranBulananSubsidi">Iuran Bulanan Subsidi</label>
                    <input type="text" id="number-input-2" class="form-control" name="iuranBulananSubsidi" placeholder="Masukkan Iuran Bulanan Subsidi" required autofocus>
                  </div>
                  <div class="form-group">
                    <label for="iuranTahunan">Iuran Tahunan</label>
                    <input type="text" id="number-input-3" class="form-control" name="iuranTahunan" placeholder="Masukkan Iuran Tahunan" required autofocus>
                  </div>

                  <div class="card-footer text-center">
                    <input class="btn btn-primary btn-block" type="submit" name="addKelas" value="Simpan">
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
              </div>
            </div>
          </div>
        </div>
        <!-- FORM UNTUK ADD KELAS -->
      </div>
      <div class="card-body">
        <?php if (isset($kelass)) : ?>
          <div class="table-responsive">
            <table class="table" id="list-kelas">
              <thead class="text-primary thead-dark">
                <tr>
                  <th rowspan="2" scope="col" class="text-center">Kode Kelas</th>
                  <th rowspan="2" scope="col" class="text-center">Semester Aktif</th>
                  <th rowspan="2" scope="col" class="text-center">Tahun Akademik Aktif</th>
                  <th rowspan="2" scope="col" class="text-center">Iuran Bulanan</th>
                  <th rowspan="2" scope="col" class="text-center">Iuran Bulanan Subsidi</th>
                  <th rowspan="2" scope="col" class="text-center">Iuran Tahunan</th>
                  <th colspan="2" scope="col" class="text-center">Aksi</th>
                </tr>
                <tr>
                  <th scope="col" class="text-center">Ubah</th>
                  <th scope="col" class="text-center">Hapus</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($kelass as $kelas) : ?>

                  <tr>
                    <td class="text-center"><?= $kelas->kode_kelas ?></td>
                    <td class="text-center"><?= $kelas->semester ?></td>
                    <td class="text-center"><?= $kelas->tahun_akademik ?></td>
                    <td class="text-center"><?= $kelas->iuran_bulanan ?></td>
                    <td class="text-center"><?= $kelas->iuran_bulanan_subsidi ?></td>
                    <td class="text-center"><?= $kelas->iuran_tahunan ?></td>
                    <td class="text-center">
                      <a class="btn btn-success text-white" href="<?= base_url() ?>admin/editKelas?kode_kelas=<?= $kelas->kode_kelas ?>"><i class="fas fa-pencil-alt"></i> Ubah</a>
                    </td>
                    <td class="text-center">
                      <button class="btn btn-danger text-white" data-toggle="modal" data-target="#hapus-kelas-<?= str_replace(" ", "", $kelas->kode_kelas) ?>-modal"><i class="fas fa-trash-alt"></i> Hapus</button>
                      <div class="modal fade" id="hapus-kelas-<?= str_replace(" ", "", $kelas->kode_kelas) ?>-modal" tabindex="-1" role="dialog" aria-labelledby="hapus-kelas-modal-label" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="hapus-kelas-modal-label">Konfirmasi Hapus Kelas</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <p>Apakah anda yakin akan menghapus kelas <?= $kelas->kode_kelas ?> ?</p>
                              <p>Aksi ini tidak dapat dibatalkan setelah anda menekan tombol hapus!</p>
                            </div>
                            <div class="modal-footer">
                              <a href="<?= base_url() ?>admin/hapusKelas?kode_kelas=<?= $kelas->kode_kelas ?>" class="btn btn-danger text-white"> Hapus</a>
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
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
