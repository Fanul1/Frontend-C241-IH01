<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PotCher | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url('assets/template/') ?>plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?= base_url('assets/template/') ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('assets/template/') ?>dist/css/adminlte.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/template/') ?>dist/css/spinner.css">

  <style>
    body {
      background-color: yellowgreen; /* Ganti dengan warna atau gambar background yang Anda inginkan */
    }

    .login-logo {
      text-align: center; /* Posisikan logo ke tengah */
      margin-bottom:0; /* Atur jarak antara logo dan form */
    }

    .login-logo img {
      max-width: 200px; /* Sesuaikan ukuran logo sesuai kebutuhan */
    }

    .login-card-body {
      background: #fff; /* Ganti dengan warna atau gambar latar belakang form */
      border-radius: 10px; /* Atur radius sudut form */
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); /* Efek bayangan form */
      padding: 30px; /* Atur padding dalam form */
    }

    .login-box-msg {
      font-size: 18px; /* Ukuran font pesan selamat datang */
    }
  </style>
</head>

<body class="hold-transition login-page">
  <div id="loading-spinner" style="display:none;">
    <div class="spinner"></div>
    <div class="loading-text">Loading, please wait...</div>
  </div>

  <div>
    <div class="login-logo">
      <img src="<?= base_url('assets/template/') ?>img/logo2.png" alt="PotCher Logo">
    </div>
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Welcome! Please sign in to continue.</p>

        <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger" role="alert">
          <?= $this->session->flashdata('error'); ?>
        </div>
        <?php endif; ?>

        <form id="login-form" action="<?= base_url('auth/login') ?>" method="post">
          <div class="input-group mb-3">
            <input type="text" name="ip" id="ip" class="form-control" placeholder="IP Address / IP VPN" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-globe"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="text" name="user" id="user" class="form-control" placeholder="Username" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- jQuery -->
  <script src="<?= base_url('assets/template/') ?>plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?= base_url('assets/template/') ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?= base_url('assets/template/') ?>dist/js/adminlte.min.js"></script>
  <script src="<?= base_url('assets/template/') ?>dist/js/login.js"></script>
</body>
</html>