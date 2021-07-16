<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/master/home" class="brand-link">
        <img src="/img/img-admin/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">PPDB | Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="/master/home" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
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
                            Pendaftaran PPDB
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('ppdb.tambah.pendaftar') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tambah Peserta PPDB</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/master/list-tbsm" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List Peserta</p>
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
