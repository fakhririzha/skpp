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
  <link href="<?= base_url("assets/css/now-ui-dashboard.min.css") ?>" rel="stylesheet" />
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
  <div class="wrapper ">
    <div class="sidebar" data-color="orange">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
    -->
      <div class="logo">
        <a href="<?= base_url() ?>" class="simple-text logo-normal">
          <?= ucfirst($this->session->username) ?>
        </a>
      </div>
      <div class="sidebar-wrapper" id="sidebar-wrapper">
        <ul class="nav">
          <li class="active ">
            <a href="<?= base_url() ?>admin">
              <i class="now-ui-icons design_app"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li>
            <a href="<?= base_url() ?>bendahara/bulanan">
              <i class="now-ui-icons business_money-coins"></i>
              <p>Iuran Bulanan</p>
            </a>
          </li>
          <li>
            <a href="<?= base_url() ?>bendahara/tahunan">
              <i class="now-ui-icons business_money-coins"></i>
              <p>Iuran Tahunan</p>
            </a>
          </li>
          <li>
            <a href="<?= base_url() ?>bendahara/pemasukanLainnya">
              <i class="now-ui-icons business_money-coins"></i>
              <p>Pemasukan Lainnya</p>
            </a>
          </li>
          <li>
            <a href="<?= base_url() ?>bendahara/histori">
              <i class="fas fa-history"></i>
              <p>Histori Transaksi</p>
            </a>
          </li>
          <li>
            <a href="<?= base_url() ?>bendahara/pengeluaran">
              <i class="now-ui-icons shopping_cart-simple"></i>
              <p>Pengeluaran</p>
            </a>
          </li>
          <li>
            <a href="<?= base_url() ?>bendahara/laporan">
              <i class="now-ui-icons business_chart-bar-32"></i>
              <p>Laporan</p>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="main-panel" id="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent  bg-primary  navbar-absolute">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-toggle">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>
            <a class="navbar-brand" href="#pablo">Dashboard</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <ul class="navbar-nav">
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="now-ui-icons users_single-02"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Some Actions</span>
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="<?= base_url() ?>logout"><i class="fas fa-sign-out-alt"></i> Keluar</a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
      <?php if (isset($headingPanel)) : ?>
        <div class="panel-header panel-header-lg">
          <h2 style="margin-left: 1.75rem" class="text-white product-sans">Selamat Datang di Sistem Keuangan Pondok Pesantren Mawaridussalam</h2>
        </div>
      <?php else : ?>
        <div class="panel-header panel-header-sm">
        </div>
      <?php endif; ?>
      <div class="content">
        <?php $this->load->view($content); ?>
      </div>
      <footer class="footer">
        <div class="container-fluid">
          <nav>
            <ul>
              <li>
                <a href="https://www.creative-tim.com">
                  Creative Tim
                </a>
              </li>
              <li>
                <a href="http://presentation.creative-tim.com">
                  About Us
                </a>
              </li>
              <li>
                <a href="http://blog.creative-tim.com">
                  Blog
                </a>
              </li>
            </ul>
          </nav>
          <div class="copyright" id="copyright">
            &copy;
            <script>
              document.getElementById('copyright').appendChild(document.createTextNode(new Date().getFullYear()))
            </script>, Designed by
            <a href="https://www.invisionapp.com" target="_blank">Invision</a>. Coded by
            <a href="https://www.creative-tim.com" target="_blank">Creative Tim</a>.
          </div>
        </div>
      </footer>
    </div>
  </div>
  <!--   Core JS Files   -->
  <script src="<?= base_url() ?>assets/js/jquery.slim.min.js"></script>
  <script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url() ?>assets/js/perfect-scrollbar.jquery.min.js"></script>
  <!-- Chart JS -->
  <script src="<?= base_url() ?>assets/js/chartjs.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="<?= base_url() ?>assets/js/bootstrap-notify.js"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="<?= base_url() ?>assets/js/now-ui-dashboard.min.js" type="text/javascript"></script>
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
