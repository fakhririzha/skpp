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
          <p>LAPORAN KEUANGAN PENERIMAAN SPP SANTRI/WATI</p>
          <p>BULAN : <?= $bulan . ' ' . $tahun ?></p>
          <br>
        </div>
        <table class="table" border="2">
          <thead>
            <th style="width: 1%" class="text-center">NO.</th>
            <th style="width: 5%" class="text-center">TANGGAL</th>
            <th style="width: 5%" class="text-center">HARI</th>
            <th style="width: 15%" class="text-center">PENERIMAAN PUTRA</th>
            <th style="width: 15%" class="text-center">PENERIMAAN PUTRI</th>
            <th style="width: 10%" class="text-center">JUMLAH</th>
          </thead>
          <tbody>
            <?php
            $saldo = 0;
            $pa = 0;
            $pi = 0;
            ?>
            <?php for ($i = $awal; $i <= $akhir; $i++) : ?>
              <tr>
                <?php

                $paFound = false;
                $piFound = false;

                $hari = ($i > 9) ? $i : "0" . $i;
                $carbon = new \Carbon\Carbon();
                $bulan = $carbon::parse($tanggal)->format("m");
                $tgl = $hari . '/' . $bulan . '/' . $tahun;

                ?>
                <td><?= $i ?></td>
                <td><?= $tgl ?></td>
                <td class="text-uppercase">
                  <?php

                  $carbon = new \Carbon\Carbon();
                  $hari = $carbon::createFromFormat("d/m/Y", $tgl)->locale("id_ID")->dayName;
                  echo $hari;

                  ?>
                </td>
                <td class="text-right">
                  <?php

                  $putra = 0;

                  foreach ($laporanSPP as $data) {
                    if ($data->tanggalFormatted == $tgl) {
                      echo "Rp. " . $data->jlhPutra;
                      $putra = $data->jlhPutra;
                      $pa += $putra;
                      $paFound = true;
                      break;
                    }
                  }
                  if ($paFound == false) {
                    echo "Rp. -";
                  }
                  ?>
                </td>
                <td class="text-right">
                  <?php

                  $putri = 0;

                  foreach ($laporanSPP as $data) {
                    if ($data->tanggalFormatted == $tgl) {
                      echo "Rp. " . $data->jlhPutri;
                      $putri = $data->jlhPutri;
                      $pi += $putri;
                      $piFound = true;
                      break;
                    }
                  }
                  if ($piFound == false) {
                    echo "Rp. -";
                  }
                  ?>
                </td>
                <td class="text-right">
                  <?php

                  echo "Rp. " . ($putra + $putri);
                  $saldo += ($putra + $putri);

                  ?>
                </td>
              </tr>
            <?php endfor; ?>
            <tr>
              <td><?= $i ?></td>
              <td>LAIN-LAIN</td>
              <td></td>
              <td></td>
              <td></td>
              <td class="text-right">
                <?= "Rp. " . $pemasukanLainnya->pemasukanLainnya ?>
              </td>
            </tr>
            <tr>
              <td colspan=3 class="text-center">TOTAL PENERIMAAN</td>
              <td class="text-right"><?= "Rp. " . $pa ?></td>
              <td class="text-right"><?= "Rp. " . $pi ?></td>
              <td class="text-right">
                <?= "Rp. " . ($saldo + $pemasukanLainnya->pemasukanLainnya) ?>
              </td>
            </tr>
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
