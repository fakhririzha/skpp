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
          <p>LAPORAN KEUANGAN PESANTREN MAWARIDUSSALAM</p>
          <p>BULAN <?= strtoupper($bulan) . ' ' . $tahun ?></p>
        </div>
        <hr>
        <table class="table table-borderless">
          <thead>
            <tr style="font-weight: 700;">
              <th style="width: 1%" class="text-center">A</th>
              <th style="width: 2%" class="text-center">PENERIMAAN</th>
              <th style="width: 1%">
              </th>
            </tr>
          </thead>
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
