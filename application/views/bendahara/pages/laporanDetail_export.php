<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    SKPP Mawaridussalam
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link rel="stylesheet" href="<?= base_url("assets/css/fontawesome-all.min.css") ?>">
  <!-- CSS Files -->
  <link href="<?= base_url("assets/css/bootstrap.css") ?>" rel="stylesheet" />
  <link rel="stylesheet" href="<?= base_url('assets/css/material-color.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
  <!-- Custom CSS Files -->
  <?php
  if (isset($cssFiles)) {
    for ($i = 0; $i < count($cssFiles); $i++) {
      $link = base_url("assets/css/$cssFiles[$i]");
      echo "\t<link href=\"$link\" rel=\"stylesheet\">\n";
    }
  }
  ?>
</head>

<body class="">
  <button type="button" onclick="printJS({
    printable: 'laporan',
    type: 'html',
    css: ['http:\/\/localhost/SKPP/assets/css/bootstrap.css','http:\/\/localhost/SKPP/assets/css/laporan.css']
  })">
    Print Form
  </button>
  <div class="container-fluid" id="laporan">
    <img src="<?= base_url() ?>assets/img/kop_surat.jpg" alt="Kop Surat Mawaridussalam" class="img-responsive" style="width: 800px; height: auto;">

    <div class="row">
      <div class="col-md-12 text-center">
        <div class="heading">
          <br>
        </div>
        <table class="table" border="2">
          <thead>
            <tr>
              <th></th>
              <th colspan="5">BULAN : <?= $bulan . ' ' . $tahun ?></th>
            </tr>
            <tr>
              <th style="width: 1%" class="text-center">TANGGAL</th>
              <th style="width: 1%" class="text-center">KODE</th>
              <th style="width: 1%" class="text-center">KETERANGAN</th>
              <th style="width: 5%" class="text-center">DEBIT</th>
              <th style="width: 5%" class="text-center">KREDIT</th>
              <th style="width: 5%" class="text-center">SALDO</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td><?= "Rp. " . number_format($saldoAwal, 0, ',', '.') ?></td>
            </tr>
            <?php for ($i = $awal; $i <= $akhir; $i++) : ?>
              <?php foreach ($laporanPengeluaran[$i]["laporanPengeluaran"] as $data) : ?>
                <tr>
                  <td class="text-center">
                    <?php

                    $carbon = new \Carbon\Carbon();
                    echo substr($laporanPengeluaran[$i]["tanggal"], 0, 2);
                    // var_dump($data);

                    ?>
                  </td>
                  <td class="text-center"><?= $data->kode ?></td>
                  <td><?= $data->keterangan ?></td>
                  <td class="text-right"></td>
                  <td class="text-right"><?= "Rp. " . number_format($data->nominal, 0, ',', '.') ?></td>
                  <td></td>
                </tr>
              <?php endforeach; ?>
              <?php foreach ($laporanPemasukanLainnya[$i]["laporanPemasukanLainnya"] as $data) : ?>
                <tr>
                  <td class="text-center">
                    <?php

                    $carbon = new \Carbon\Carbon();
                    echo substr($laporanPemasukanLainnya[$i]["tanggal"], 0, 2);
                    // var_dump($data);

                    ?>
                  </td>
                  <td class="text-center"><?= $data->kode ?></td>
                  <td><?= $data->keterangan ?></td>
                  <td class="text-right"></td>
                  <td class="text-right"><?= "Rp. " . number_format($data->nominal, 0, ',', '.') ?></td>
                  <td></td>
                </tr>
              <?php endforeach; ?>
              <?php foreach ($laporanSPP[$i]["laporanSPP"] as $data) : ?>
                <tr>
                  <td class="text-center">
                    <?php

                    $carbon = new \Carbon\Carbon();
                    echo substr($laporanSPP[$i]["tanggal"], 0, 2);
                    // var_dump($data);

                    ?>
                  </td>
                  <td class="text-center">1A</td>
                  <td class="text-left">Penerimaan Putra</td>
                  <td class="text-right"><?= "Rp. " . number_format($data->penerimaanPutra, 0, ',', '.') ?></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                  <td class="text-center">
                    <?php

                    $carbon = new \Carbon\Carbon();
                    echo substr($laporanSPP[$i]["tanggal"], 0, 2);
                    // var_dump($data);

                    ?>
                  </td>
                  <td class="text-center">2A</td>
                  <td class="text-left">Penerimaan Putri</td>
                  <td class="text-right"><?= "Rp. " . number_format($data->penerimaanPutri, 0, ',', '.') ?></td>
                  <td></td>
                  <td></td>
                </tr>
              <?php endforeach; ?>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
            <?php endfor; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!--   Core JS Files   -->
  <script src="<?= base_url() ?>assets/js/jquery.slim.min.js"></script>
  <script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url() ?>assets/js/perfect-scrollbar.jquery.min.js"></script>
  <!-- CUSTOM JS TAG -->
  <?php
  if (isset($jsFiles)) {
    for ($i = 0; $i < count($jsFiles); $i++) {
      $link = base_url("assets/js/$jsFiles[$i]");
      echo "\t<script src=\"$link\"></script>\n";
    }
  }
  ?>
  <!-- MAIN JS FILES -->
  <script src="<?= base_url() ?>assets/js/app.js"></script>
</body>

</html>
