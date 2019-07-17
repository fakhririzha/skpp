<?php
defined('BASEPATH') or exit('No direct script access allowed');
// echo password_hash("admin", PASSWORD_DEFAULT);
// die;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700,900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/bootstrap.css">
  <link rel="stylesheet" href="assets/css/fontawesome-all.css">
  <link rel="stylesheet" href="assets/css/material-color.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <title>Secure Login</title>
</head>

<body style="background-color: lightslategrey">
  <div class="container login-page">
    <div class="row">
      <div class="col-sm-1 col-md-2 col-lg-3 col-xl-3"></div>
      <div class="col-sm-10 col-md-8 col-lg-6 col-xl-6">
        <div class="card z-depth-4">
          <div class="card-header green-gradient white-text">Secure Login</div>
          <form action="" method="POST">
            <div class="card-body green lighten-5">

              <!-- ALERT MESSAGE -->
              <?php if ($this->session->flashdata('msgHead')) : ?>

                <div class="alert alert-<?= $this->session->flashdata('msgType') ?> alert-dismissible fade show" role="alert">
                  <strong><?= $this->session->flashdata('msgHead') ?></strong> <?= $this->session->flashdata('msgText') ?>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

              <?php endif; ?>

              <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username" placeholder="Masukkan username..." required autofocus>
              </div>
              <div class="form-group">
                <label for="katasandi">Kata Sandi</label>
                <input type="password" class="form-control" name="password" placeholder="**********" required>
              </div>
              <div class="form-group">
                <?= $captcha['image'] ?>
                <small>
                  &nbsp;&nbsp;<em>Silahkan reload halaman jika gambar kurang jelas.</em>
                </small>
                <hr>
                <input type="text" class="form-control" name="captcha_input" placeholder="Masukkan kode diatas..." required>
              </div>

            </div>
            <div class="card-footer green lighten-4 text-center">
              <input type="submit" class="btn btn-block login-button white-text" name="authUser" value="Masuk">
            </div>
          </form>
        </div>
      </div>
      <div class="col-sm-1 col-md-2 col-lg-3 col-xl-3"></div>
    </div>
  </div>
</body>
<script src="assets/js/jquery.slim.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<!-- <script src="js/app.js"></script> -->

</html>
