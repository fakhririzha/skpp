<div class="row">
  <div class="col-md-12">
    <div class="card card-chart">
      <div class="card-header">
        <h4 class="card-title"><i class="fas fa-upload"></i> Import Data Siswa</h4>
      </div>
      <div class="card-body">
        <hr>
        <a href="<?= base_url() ?>admin/downloadTemplate" class="btn btn-success">Download Template Import Data</a>
        <hr>
        <form action="<?= base_url() ?>admin/uploadFileTemplate" enctype="multipart/form-data" method="POST" accept-charset="utf-8">

          <div class="form-group">
            <div class="custom-file">
              <input type="file" class="custom-file-input" name="customFile" id="customFile">
              <label class="custom-file-label" for="customFile">Choose file</label>
            </div>
          </div>

          <br /><br />

          <input type="submit" class="btn btn-primary" value="upload" />
          <hr>
        </form>
        <?php if (isset($siswa)) : ?>

          <h3>HASIL IMPORT</h3>
          <hr>

          <div class="table-responsive">
            <table class="table" id="list-siswa-import">
              <thead class="text-primary thead-dark">
                <tr>
                  <th scope="col" class="text-center">No. STTB</th>
                  <th scope="col" class="text-center">Nama</th>
                  <th scope="col" class="text-center">Jenis Kelamin</th>
                  <th scope="col" class="text-center">Status</th>
                  <th scope="col" class="text-center">Status Input</th>
              </thead>
              <tbody>
                <?php for ($i = 0; $i < count($siswa); $i++) : ?>

                  <tr>
                    <td class="text-center"><?= $siswa[$i]["sttb"] ?></td>
                    <td class="text-center"><?= $siswa[$i]["nama"] ?></td>
                    <td class="text-center"><?= ucfirst($siswa[$i]["jenis_kelamin"]) ?></td>
                    <td class="text-center"><?= ucfirst($siswa[$i]["status"]) ?></td>
                    <td class="text-center"><?= ucfirst($siswa[$i][0]["sukses"]) ?></td>
                  </tr>

                <?php endfor; ?>
              </tbody>
            </table>
          </div>
        <?php endif; ?>
      </div>
      <div class="card-footer">
        <div class="stats">
          <i class="now-ui-icons arrows-1_refresh-69"></i> Data diakses pada <?= date("d-m-Y H:i", time()) ?>
        </div>
      </div>
    </div>
  </div>
</div>
