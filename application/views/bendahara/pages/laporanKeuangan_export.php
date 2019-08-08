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
          <p>BULAN : <?= $bulan . ' ' . $tahun ?></p>
          <br>
        </div>
        <table class="table" border="2">
          <thead>
            <th style="width: 1%" class="text-center">NO.</th>
            <th style="width: 5%" class="text-center">TANGGAL</th>
            <th style="width: 5%" class="text-center">HARI</th>
            <th style="width: 15%" class="text-center">DEBIT</th>
            <th style="width: 15%" class="text-center">KREDIT</th>
            <th style="width: 10%" class="text-center">SALDO</th>
          </thead>
          <tbody>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td class="text-right"><?= "Rp. " . number_format($saldoAwal, 0, ',', '.') ?></td>
            </tr>
            <?php
            $saldo = $saldoAwal;
            $totalDebit = 0;
            $totalKredit = 0;
            ?>
            <?php for ($i = $awal; $i <= $akhir; $i++) : ?>
              <tr>
                <?php

                $debitFound = false;
                $kreditFound = false;

                $hari = ($i > 9) ? $i : "0" . $i;
                $carbon = new \Carbon\Carbon();
                $bulan = $carbon::parse($tanggal)->format("m");
                $tgl = $hari . '/' . $bulan . '/' . $tahun;

                ?>
                <td class="text-center"><?= $i ?></td>
                <td class="text-center"><?= $tgl ?></td>
                <td class="text-uppercase text-center">
                  <?php

                  $carbon = new \Carbon\Carbon();
                  $hari = $carbon::createFromFormat("d/m/Y", $tgl)->locale("id_ID")->dayName;
                  echo $hari;

                  ?>
                </td>
                <td class="text-right">
                  <?php

                  $debit = 0;

                  foreach ($laporanKeuangan as $data) {
                    if ($data->tanggalFormatted == $tgl) {
                      echo "Rp. " . number_format($data->jlhDebit, 0, ',', '.');
                      $debit = $data->jlhDebit;
                      $totalDebit += $debit;
                      $debitFound = true;
                      break;
                    }
                  }
                  if ($debitFound == false) {
                    echo "Rp. 0";
                  }
                  ?>
                </td>
                <td class="text-right">
                  <?php

                  $kredit = 0;

                  foreach ($laporanKeuangan as $data) {
                    if ($data->tanggalFormatted == $tgl) {
                      echo "Rp. " . number_format($data->jlhKredit, 0, ',', '.');
                      $kredit = $data->jlhKredit;
                      $totalKredit += $kredit;
                      $kreditFound = true;
                      break;
                    }
                  }
                  if ($kreditFound == false) {
                    echo "Rp. 0";
                  }
                  ?>
                </td>
                <td class="text-right">
                  <?php

                  $saldo += ($debit - $kredit);
                  echo "Rp. " . number_format($saldo, 0, ',', '.');

                  ?>
                </td>
              </tr>
            <?php endfor; ?>
            <tr>
              <td class="text-center"><?= $i ?></td>
              <td class="text-center">LAIN-LAIN</td>
              <td></td>
              <td class="text-right">
                <?= "Rp. " . number_format($pemasukanLainnya->pemasukanLainnya, 0, ',', '.') ?>
                <?php $totalDebit += $pemasukanLainnya->pemasukanLainnya ?>
              </td>
              <td></td>
              <td class="text-right">
                <?= "Rp. " . number_format(($saldo + $pemasukanLainnya->pemasukanLainnya), 0, ',', '.') ?>
              </td>
            </tr>
            <tr>
              <td colspan=3 class="text-center">TOTAL KESELURUHAN</td>
              <td class="text-right"><?= "Rp. " . number_format($totalDebit, 0, ',', '.') ?></td>
              <td class="text-right"><?= "Rp. " . number_format($totalKredit, 0, ',', '.') ?></td>
              <td class="text-right">
                <?= "Rp. " . number_format(($saldo + $pemasukanLainnya->pemasukanLainnya), 0, ',', '.') ?>
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
