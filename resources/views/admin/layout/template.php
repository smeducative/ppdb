<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="/css/css-admin/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                        <img src="/img/img-admin/user2-160x160.jpg" class="user-image img-circle elevation-2" alt="User Image">
                        <span class="d-none d-md-inline">Alexander Pierce</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <!-- User image -->
                        <li class="user-header bg-primary">
                            <img src="/img/img-admin/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">

                            <p>
                                Alexander Pierce - Web Developer
                                <small>Member since Nov. 2012</small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                            <div class="row">
                                <div class="col-4 text-center">
                                    <a href="#">Followers</a>
                                </div>
                                <div class="col-4 text-center">
                                    <a href="#">Sales</a>
                                </div>
                                <div class="col-4 text-center">
                                    <a href="#">Friends</a>
                                </div>
                            </div>
                            <!-- /.row -->
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <a href="#" class="btn btn-default btn-flat">Profile</a>
                            <a href="#" class="btn btn-default btn-flat float-right">Sign out</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- End Navbar -->
        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="/master/home" class="brand-link">
                <img src="/img/img-admin/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">PPDB | Admin</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="/master/home" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/master/jurusan" class="nav-link">
                                <i class="nav-icon fas fa-list-alt"></i>
                                <p>
                                    Jurusan
                                </p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-chart-pie"></i>
                                <p>
                                    List Pendaftar
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/master/list-atph" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>ATPH</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/master/list-tbsm" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>TBSM</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/master/list-tkj" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>TKJ</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-check-double"></i>
                                <p>
                                    List Daftar Ulang
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/master/du-atph" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>DU ATPH</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/master/du-tbsm" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>DU TBSM</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/master/du-tkj" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>DU TKJ</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-tshirt"></i>
                                <p>
                                    List Ukuran Baju
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/master/baju-atph" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>ATPH</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/master/baju-tbsm" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>TBSM</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/master/baju-tkj" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>TKJ</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-header">CETAK DOKUMEN</li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-id-card"></i>
                                <p>
                                    Kartu Pendaftaran
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/master/baju-atph" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Kartu ATPH</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/master/baju-tbsm" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Kartu TBSM</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/master/baju-tkj" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Kartu TKJ</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-file"></i>
                                <p>
                                    Form Pendaftaran
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/master/baju-atph" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Form ATPH</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/master/baju-tbsm" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Form TBSM</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/master/baju-tkj" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Form TKJ</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-file-alt"></i>
                                <p>
                                    Surat Diterima
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/master/baju-atph" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Surat ATPH</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/master/baju-tbsm" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Surat TBSM</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/master/baju-tkj" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Surat TKJ</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-money-check"></i>
                                <p>
                                    Kwitansi
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/master/baju-atph" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Kwitansi ATPH</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/master/baju-tbsm" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Kwitansi TBSM</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/master/baju-tkj" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Kwitansi TKJ</p>
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
        <!-- End Main Sidebar Container -->

        <?= $this->renderSection('content'); ?>

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 3.0.1
            </div>
            <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong> All rights
            reserved.
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

    </div>
    <!-- End Site wrapper -->


    <!-- jQuery -->
    <script src="/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/js/js-admin/adminlte.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- DataTables -->
    <script src="/plugins/datatables/jquery.dataTables.js"></script>
    <script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="/js/js-admin/demo.js"></script>

    <!-- page script -->
    <script>
        $(function() {
            $("#example1").DataTable();
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
            });
        });
    </script>
</body>

</html>