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
        <table class="table table-borderless big-font">
          <thead>
            <tr style="font-weight: 700;">
              <th style="width: 1%" class="text-center">A</th>
              <th style="width: 2%" class="text-center">PENERIMAAN</th>
              <th style="width: 1%">
              </th>
            </tr>
          </thead>
          <tbody>
            <tr style="font-weight: 700;">
              <td style="width: 1%"></td>
              <td style="width: 2%" class="text-left">IURAN SANTRI</td>
              <td style="width: 1%"></td>
            </tr>
            <tr>
              <td style="width: 1%" class="text-center">1</td>
              <td style="width: 2%" class="text-left">Penerimaan Putra</td>
              <td style="width: 1%" class="text-right">
                <?= "Rp. " . number_format($penerimaanPutra->putra, 0, ',', '.') ?>
              </td>
            </tr>
            <tr>
              <td style="width: 1%" class="text-center">2</td>
              <td style="width: 2%" class="text-left">Penerimaan Putri</td>
              <td style="width: 1%" class="text-right">
                <?= "Rp. " . number_format($penerimaanPutri->putri, 0, ',', '.') ?>
              </td>
            </tr>
            <tr>
              <td style="width: 1%" class="text-center">3</td>
              <td style="width: 2%" class="text-left">Lain-Lain</td>
              <td style="width: 1%" class="text-right">
                <?= "Rp. " . number_format($pemasukanLainnya->pemasukanLainnya, 0, ',', '.') ?>
              </td>
            </tr>
            <tr style="font-weight: 700;">
              <td style="width: 1%"></td>
              <td style="width: 2%" class="text-center">TOTAL PENERIMAAN</td>
              <td style="width: 1%" class="text-right">
                <?php
                $totalPenerimaan = $penerimaanPutra->putra + $penerimaanPutri->putri + $pemasukanLainnya->pemasukanLainnya;
                echo "Rp. " . number_format($totalPenerimaan, 0, ',', '.');
                ?>
              </td>
            </tr>
          </tbody>
        </table>
        <br>
        <table class="table table-borderless big-font">
          <thead>
            <tr style="font-weight: 700;">
              <th style="width: 1%" class="text-center">B</th>
              <th style="width: 2%" class="text-center">PENGELUARAN</th>
              <th style="width: 1%">
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td style="width: 1%" class="text-center">1</td>
              <td style="width: 2%" class="text-left">Pimpinan</td>
              <td style="width: 1%" class="text-right">
                <?= "Rp. " . number_format($pimpinan->jumlah, 0, ',', '.') ?>
              </td>
            </tr>
            <tr>
              <td style="width: 1%" class="text-center">2</td>
              <td style="width: 2%" class="text-left">Sekretaris</td>
              <td style="width: 1%" class="text-right">
                <?= "Rp. " . number_format($sekretaris->jumlah, 0, ',', '.') ?>
              </td>
            </tr>
            <tr>
              <td style="width: 1%" class="text-center">3</td>
              <td style="width: 2%" class="text-left">Bendahara</td>
              <td style="width: 1%" class="text-right">
                <?= "Rp. " . number_format($bendahara->jumlah, 0, ',', '.') ?>
              </td>
            </tr>
            <tr>
              <td style="width: 1%" class="text-center">4</td>
              <td style="width: 2%" class="text-left">KMI</td>
              <td style="width: 1%" class="text-right">
                <?= "Rp. " . number_format($kmi->jumlah, 0, ',', '.') ?>
              </td>
            </tr>
            <tr>
              <td style="width: 1%" class="text-center">5</td>
              <td style="width: 2%" class="text-left">Pengasuhan</td>
              <td style="width: 1%" class="text-right">
                <?= "Rp. " . number_format($pengasuhan->jumlah, 0, ',', '.') ?>
              </td>
            </tr>
            <tr>
              <td style="width: 1%" class="text-center">6</td>
              <td style="width: 2%" class="text-left">Dapur</td>
              <td style="width: 1%" class="text-right">
                <?= "Rp. " . number_format($dapur->jumlah, 0, ',', '.') ?>
              </td>
            </tr>
            <tr>
              <td style="width: 1%" class="text-center">7</td>
              <td style="width: 2%" class="text-left">Pembangunan</td>
              <td style="width: 1%" class="text-right">
                <?= "Rp. " . number_format($pembangunan->jumlah, 0, ',', '.') ?>
              </td>
            </tr>
            <tr>
              <td style="width: 1%" class="text-center">8</td>
              <td style="width: 2%" class="text-left">Listrik</td>
              <td style="width: 1%" class="text-right">
                <?= "Rp. " . number_format($listrik->jumlah, 0, ',', '.') ?>
              </td>
            </tr>
            <tr>
              <td style="width: 1%" class="text-center">9</td>
              <td style="width: 2%" class="text-left">Kesejahteraan</td>
              <td style="width: 1%" class="text-right">
                <?= "Rp. " . number_format($kesejahteraan->jumlah, 0, ',', '.') ?>
              </td>
            <tr>
              <td style="width: 1%" class="text-center">10</td>
              <td style="width: 2%" class="text-left">Lain-Lain</td>
              <td style="width: 1%" class="text-right">
                <?= "Rp. " . number_format($lainLain->jumlah, 0, ',', '.') ?>
              </td>
            </tr>
            </tr>
            <tr style="font-weight: 700;">
              <td style="width: 1%"></td>
              <td style="width: 2%" class="text-center">TOTAL PENGELUARAN</td>
              <td style="width: 1%" class="text-right">
                <?php
                $totalPengeluaran = $pimpinan->jumlah + $sekretaris->jumlah + $bendahara->jumlah + $kmi->jumlah + $pengasuhan->jumlah + $dapur->jumlah + $pembangunan->jumlah + $listrik->jumlah + $kesejahteraan->jumlah + $lainLain->jumlah;
                echo "Rp. " . number_format($totalPengeluaran, 0, ',', '.');
                ?>
              </td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr style="font-weight: 700;">
              <td style="width: 1%"></td>
              <td style="width: 2%" class="text-left">Saldo</td>
              <td style="width: 1%" class="text-right">
                <?php
                echo "Rp. " . number_format(($totalPenerimaan - $totalPengeluaran), 0, ',', '.');
                ?>
              </td>
            </tr>
            <tr style="font-weight: 700;">
              <td style="width: 1%"></td>
              <td style="width: 2%" class="text-left">Saldo Bulan Lalu</td>
              <td style="width: 1%" class="text-right">
                <?php
                echo "Rp. " . number_format($saldoAwal, 0, ',', '.');
                ?>
              </td>
            </tr>
            <tr style="font-weight: 700;">
              <td style="width: 1%"></td>
              <td style="width: 2%" class="text-left">Saldo Akhir</td>
              <td style="width: 1%" class="text-right">
                <?php
                echo "Rp. " . number_format(($totalPenerimaan - $totalPengeluaran + $saldoAwal), 0, ',', '.');
                ?>
              </td>
            </tr>
          </tbody>
        </table>
        <br>
        <br>
        <br>
        <br>
        <br>
        <table class="table table-borderless big-font">
          <tr>
            <td style="width: 1%" class="text-center"></td>
            <td style="width: 2%" class="text-center">Bendahara</td>
            <td style="width: 2%" class="text-center">Bagian</td>
          </tr>
          <tr>
            <td style="width: 1%" class="text-center"></td>
            <td style="width: 2%" class="text-center">Pondok Pesantren Mawaridussalam</td>
            <td style="width: 2%" class="text-center">Pembukuan</td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td style="width: 1%" class="text-center"></td>
            <td style="width: 2%" class="text-center">Ust. M. Harmain, SE, M.M</td>
            <td style="width: 2%" class="text-center">Ust. Taufik Romadhon, DLT</td>
          </tr>
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
