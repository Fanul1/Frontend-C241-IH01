<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $title; ?></title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?= base_url('assets/template/') ?>plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet"
    href="<?= base_url('assets/template/') ?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('assets/template/') ?>dist/css/adminlte.min.css">
  <!-- DataTables -->
  <link rel="stylesheet"
    href="<?= base_url('assets/template/') ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet"
    href="<?= base_url('assets/template/') ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-cyan navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= site_url('auth/logout') ?>"
            onclick="return confirm('Apakah anda yakin akan keluar ?')" role="button">
            <i class="fas fa-sign-out-alt"></i>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-cyan-primary elevation-4">
    <!-- Brand Logo -->
        <<a href="<?= base_url('') ?>" class="brand-link">
                <img src="<?= base_url('assets/template/') ?>img/logo2.png" alt="PotCher Logo" class="brand-image">
        </a>



      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->

        <!-- SidebarSearch Form -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="<?= site_url('dashboard') ?>" class="nav-link <?= $title == 'Dashboard PotCher' ? 'active' : '' ?> ">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <!--Menu Hotspot-->
          <li class="nav-item <?= $title == 'Users Hotspot' | $title == 'Users Active' | $title == 'Users Binding' | $title == 'Users Profile'| $title == 'Users Host'|$title == 'Users Cookies' ? 'menu-open' : '' ?>">
              <a href="#" class="nav-link <?= $title == 'Users Hotspot' | $title == 'Users Active' | $title == 'Users Profile'| $title == 'Users Host'| $title == 'Users Cookies' ? 'active' : '' ?>">
              <i class="nav-icon fas fa-wifi"></i>
              <p>
                Hotspot
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= site_url('hotspot/active') ?>" class="nav-link <?= $title == 'Users Active' ? 'active' : '' ?>">
                  <i class="far nav-icon ml-3 fas fa-chart-line"></i>
                  <p>Active</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= site_url('hotspot/users') ?>" class="nav-link <?= $title == 'Users Hotspot' ? 'active' : '' ?>">
                  <i class="far  nav-icon ml-3 fas fa-users"></i>
                  <p>Users</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= site_url('hotspot/profile') ?>" class="nav-link <?= $title == 'Users Profile' ? 'active' : '' ?>">
                  <i class="far  nav-icon ml-3 fas fa-database"></i>
                  <p>Profile</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= site_url('hotspot/binding') ?>" class="nav-link <?= $title == 'Users Binding' ? 'active' : '' ?>">
                  <i class="far  nav-icon ml-3 fas fa-network-wired"></i>
                  <p>Binding</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= site_url('hotspot/host') ?>" class="nav-link" <?= $title == 'Users Host' ? 'active' : '' ?>>
                  <i class="far  nav-icon ml-3 fas fa-ioxhost"></i>
                  <p>Host</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= site_url('hotspot/cookies') ?>" class="nav-link">
                  <i class="far  nav-icon ml-3 fas fa-cookie"></i>
                  <p>Cookies</p>
                </a>
              </li>
            </ul>
          </li>
          <!--Menu PPP-->
          <li class="nav-item <?= $title == 'PPP Secret' | $title == 'PPP PPPOE' | $title == 'PPP Profile' | $title == 'PPP Active' ? 'menu-open' : '' ?>">
              <a href="#" class="nav-link <?= $title == 'PPP Secret' | $title == 'PPP PPPOE' | $title == 'PPP Profile' | $title == 'PPP Active' ? 'active' : '' ?>">
              <i class="nav-icon fas fa-users"></i>
              <p>
                PPP
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= site_url('ppp/secret') ?>" class="nav-link <?= $title == 'PPP Secret' ? 'active' : '' ?>">
                  <i class="far  nav-icon ml-3 fas fa-secret"></i>
                  <p>Secret</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= site_url('ppp/pppoe') ?>" class="nav-link <?= $title == 'PPP PPPOE' ? 'active' : '' ?>">
                  <i class="far  nav-icon ml-3 fas fa-pied-piper-pp"></i>
                  <p>PPPOE</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= site_url('ppp/profile') ?>" class="nav-link <?= $title == 'PPP Profile' ? 'active' : '' ?>">
                  <i class="far  nav-icon ml-3 fas fa-info"></i>
                  <p>Profile</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= site_url('ppp/active') ?>" class="nav-link <?= $title == 'PPP Active' ? 'active' : '' ?>">
                  <i class="far  nav-icon ml-3 fas fa-check"></i>
                  <p>Active</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->
  <!-- jQuery -->
  <script src="<?= base_url('assets/template/') ?>plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="<?= base_url('assets/template/') ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- overlayScrollbars -->
  <script
    src="<?= base_url('assets/template/') ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?= base_url('assets/template/') ?>dist/js/adminlte.js"></script>

  <!-- PAGE PLUGINS -->
  <!-- jQuery Mapael -->
  <script src="<?= base_url('assets/template/') ?>plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
  <script src="<?= base_url('assets/template/') ?>plugins/raphael/raphael.min.js"></script>
  <script src="<?= base_url('assets/template/') ?>plugins/jquery-mapael/jquery.mapael.min.js"></script>
  <script src="<?= base_url('assets/template/') ?>plugins/jquery-mapael/maps/usa_states.min.js"></script>
  <!-- ChartJS -->
  <script src="<?= base_url('assets/template/') ?>plugins/chart.js/Chart.min.js"></script>

  <!-- AdminLTE for demo purposes -->
  <script src="<?= base_url('assets/template/') ?>dist/js/demo.js"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <!-- DataTables  & Plugins -->
  <script src="<?= base_url('assets/template/') ?>plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?= base_url('assets/template/') ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script
    src="<?= base_url('assets/template/') ?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script
    src="<?= base_url('assets/template/') ?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="<?= base_url('assets/template/') ?>plugins/chart.js/Chart.min.js"></script>
  <script>
    $(function () {
      $('#dataTable').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
  </script>
</body>

</html>

<!-- hidden error -->
<?php ini_set('display_errors', 'off'); ?>