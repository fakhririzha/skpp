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
        <?php endif; ?>
        <hr>
        <button class="btn btn-success" data-toggle="modal" data-target="#add-siswa-modal"><i class="fas fa-user-plus"></i> Tambah Kelas</button>
        <hr>

        <!-- FORM UNTUK ADD KELAS -->
        <div class="modal fade" id="add-siswa-modal" tabindex="-1" role="dialog" aria-labelledby="add-siswa-modal-label" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="add-siswa-modal-label">Tambahkan siswa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form action="<?= base_url() ?>admin/addSiswa" method="POST">

                  <div class="form-group">
                    <label for="sttb">No. STTB</label>
                    <input type="number" class="form-control" name="sttb" placeholder="Masukkan No. STTB" required autofocus>
                  </div>
                  <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" name="nama" placeholder="Masukkan nama" required>
                  </div>
                  <div class="form-group">
                    <label for="kodeKelas">Kelas</label>
                    <select name="kodeKelas" class="custom-select form-control" required>
                      <option value="">Pilih kelas</option>
                      <?php foreach ($kelass as $kelas) : ?>
                        <option value="<?= $kelas->kode_kelas ?>"><?= $kelas->kode_kelas ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="jenisKelamin">Jenis Kelamin</label>
                    <select name="jenisKelamin" class="custom-select form-control" required>
                      <option value="">Pilih jenis kelamin</option>
                      <option value="laki-laki">Laki-Laki</option>
                      <option value="perempuan">Perempuan</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" class="custom-select form-control" required>
                      <option value="">Pilih status subsidi</option>
                      <option value="subsidi">Subsidi</option>
                      <option value="non-subsidi">Non-subsidi</option>
                    </select>
                  </div>

                  <div class="card-footer text-center">
                    <input class="btn btn-primary btn-block" type="submit" name="addSiswa" value="Simpan">
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
                      <button class="btn btn-danger text-white" data-toggle="modal" data-target="#hapus-kelas-modal"><i class="fas fa-trash-alt"></i> Hapus</button>
                      <div class="modal fade" id="hapus-kelas-modal" tabindex="-1" role="dialog" aria-labelledby="hapus-kelas-modal-label" aria-hidden="true">
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
