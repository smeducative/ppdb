<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <img src="/img/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
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
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a href="/master/jurusan" class="nav-link">
                        <i class="nav-icon fas fa-list-alt"></i>
                        <p>
                            Jurusan
                        </p>
                    </a>
                </li> --}}
                <li class="nav-item has-treeview {{ request()->routeIs('ppdb.tambah.pendaftar') || request()->routeIs('ppdb.list.pendaftar') || request()->routeIs('ppdb.list.pendaftar.jurusan')|| request()->routeIs('ppdb.show.peserta') ? 'menu-open' : ''  }}">
                    <a href="#" class="nav-link {{ request()->routeIs('ppdb.tambah.pendaftar') || request()->routeIs('ppdb.list.pendaftar') || request()->routeIs('ppdb.list.pendaftar.jurusan')|| request()->routeIs('ppdb.show.peserta') ? 'active' : ''  }}">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>
                            Pendaftaran PPDB
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('ppdb.tambah.pendaftar') }}" class="nav-link {{ request()->routeIs('ppdb.tambah.pendaftar') ? 'active' : ''  }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tambah Peserta PPDB</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.list.pendaftar') }}" class="nav-link {{ request()->routeIs('ppdb.list.pendaftar') || request()->routeIs('ppdb.show.peserta') ? 'active' : ''  }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List Semua Peserta</p>
                            </a>
                        </li>

						<!-- per jurusan -->
						<li class="nav-item">
                            <a href="{{ route('ppdb.list.pendaftar.jurusan', ['jurusan' => 3]) }}" class="nav-link {{ request()->is('dashboard/ppdb/list-pendaftar/3') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ATPH</p>
                            </a>
                        </li>

						<li class="nav-item">
                            <a href="{{ route('ppdb.list.pendaftar.jurusan', ['jurusan' => 2]) }}" class="nav-link  {{ request()->is('dashboard/ppdb/list-pendaftar/2') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>TBSM</p>
                            </a>
                        </li>

						<li class="nav-item">
                            <a href="{{ route('ppdb.list.pendaftar.jurusan', ['jurusan' => 1]) }}" class="nav-link {{ request()->is('dashboard/ppdb/list-pendaftar/1') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>TKJ</p>
                            </a>
                        </li>
						<li class="nav-item">
                            <a href="{{ route('ppdb.list.pendaftar.jurusan', ['jurusan' => 4]) }}" class="nav-link {{ request()->is('dashboard/ppdb/list-pendaftar/4') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>BCF</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview {{ request()->routeIs('ppdb.daftar.ulang.list') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('ppdb.daftar.ulang.list') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-check-double"></i>
                        <p>
                            List Daftar Ulang
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('ppdb.daftar.ulang.list', ['jurusan' => 3]) }}" class="nav-link {{ request()->is('dashboard/ppdb/list/terdaftar-ulang/3') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>DU ATPH</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.daftar.ulang.list', ['jurusan' => 2]) }}" class="nav-link {{ request()->is('dashboard/ppdb/list/terdaftar-ulang/2') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>DU TBSM</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.daftar.ulang.list', ['jurusan' => 1]) }}" class="nav-link {{ request()->is('dashboard/ppdb/list/terdaftar-ulang/1') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>DU TKJ</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.daftar.ulang.list', ['jurusan' => 4]) }}" class="nav-link {{ request()->is('dashboard/ppdb/list/terdaftar-ulang/4') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>DU BCF</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview {{ request()->routeIs('ppdb.seragam.show.jurusan') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('ppdb.seragam.show.jurusan') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tshirt"></i>
                        <p>
                            List Ukuran Baju
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('ppdb.seragam.show.jurusan', ['jurusan' => 3]) }}" class="nav-link {{ request()->is('dashboard/ukuran-seragam/show/3') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ATPH</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.seragam.show.jurusan', ['jurusan' => 2]) }}" class="nav-link {{ request()->is('dashboard/ukuran-seragam/show/2') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>TBSM</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.seragam.show.jurusan', ['jurusan' => 1]) }}" class="nav-link {{ request()->is('dashboard/ukuran-seragam/show/1') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>TKJ</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.seragam.show.jurusan', ['jurusan' => 4]) }}" class="nav-link {{ request()->is('dashboard/ukuran-seragam/show/4') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>BCF</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-header">CETAK DOKUMEN</li>
                <li class="nav-item has-treeview {{ request()->routeIs('ppdb.kartu.show.jurusan') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('ppdb.kartu.show.jurusan') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-id-card"></i>
                        <p>
                            Kartu Pendaftaran
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('ppdb.kartu.show.jurusan', ['jurusan' => 3]) }}" class="nav-link {{ request()->is('dashboard/kartu-pendaftaran/show/3') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kartu ATPH</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.kartu.show.jurusan', ['jurusan' => 2]) }}" class="nav-link {{ request()->is('dashboard/kartu-pendaftaran/show/2') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kartu TBSM</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.kartu.show.jurusan', ['jurusan' => 1]) }}" class="nav-link {{ request()->is('dashboard/kartu-pendaftaran/show/1') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kartu TKJ</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.kartu.show.jurusan', ['jurusan' => 4]) }}" class="nav-link {{ request()->is('dashboard/kartu-pendaftaran/show/4') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kartu BCF</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview {{ request()->routeIs('ppdb.formulir.show.jurusan') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link  {{ request()->routeIs('ppdb.formulir.show.jurusan') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file"></i>
                        <p>
                            Form Pendaftaran
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('ppdb.formulir.show.jurusan', ['jurusan' => 3]) }}" class="nav-link {{ request()->is('dashboard/formulir/show/3') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Form ATPH</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.formulir.show.jurusan', ['jurusan' => 2]) }}" class="nav-link {{ request()->is('dashboard/formulir/show/2') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Form TBSM</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.formulir.show.jurusan', ['jurusan' => 1]) }}" class="nav-link {{ request()->is('dashboard/formulir/show/1') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Form TKJ</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.formulir.show.jurusan', ['jurusan' => 4]) }}" class="nav-link {{ request()->is('dashboard/formulir/show/4') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Form BCF</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview {{ request()->routeIs('ppdb.surat.show.jurusan') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('ppdb.surat.show.jurusan') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>
                            Surat Diterima
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('ppdb.surat.show.jurusan', ['jurusan' => 3]) }}" class="nav-link {{ request()->is('dashboard/surat/show/3') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Surat ATPH</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.surat.show.jurusan', ['jurusan' => 2]) }}" class="nav-link {{ request()->is('dashboard/surat/show/2') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Surat TBSM</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.surat.show.jurusan', ['jurusan' => 1]) }}" class="nav-link {{ request()->is('dashboard/surat/show/1') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Surat TKJ</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.surat.show.jurusan', ['jurusan' => 4]) }}" class="nav-link {{ request()->is('dashboard/surat/show/4') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Surat BCF</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview {{ request()->routeIs('ppdb.kwitansi.show') || request()->routeIs('ppdb.kwitansi.show.jurusan') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('ppdb.kwitansi.show') || request()->routeIs('ppdb.kwitansi.show.jurusan') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-money-check"></i>
                        <p>
                            Kwitansi
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('ppdb.kwitansi.show') }}" class="nav-link  {{ request()->routeIs('ppdb.kwitansi.show') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List Peserta Diterima</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.kwitansi.show.jurusan', ['jurusan' => 3]) }}" class="nav-link {{ request()->is('dashboard/kwitansi/show/3') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kwitansi ATPH</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.kwitansi.show.jurusan', ['jurusan' => 2]) }}" class="nav-link {{ request()->is('dashboard/kwitansi/show/2') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kwitansi TBSM</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.kwitansi.show.jurusan', ['jurusan' => 1]) }}" class="nav-link {{ request()->is('dashboard/kwitansi/show/1') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kwitansi TKJ</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.kwitansi.show.jurusan', ['jurusan' => 4]) }}" class="nav-link {{ request()->is('dashboard/kwitansi/show/4') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kwitansi BCF</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-header">PENGATURAN AKUN</li>

                <li class="nav-item">
                    <a href="{{ route('setting.profile') }}" class="nav-link {{ request()->routeIs('setting.profile') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Pengaturan Profile
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('ppdb.set.batas.akhir') }}" class="nav-link {{ request()->routeIs('ppdb.set.batas.akhir') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-newspaper"></i>
                        <p>
                            Pengaturan PPDB
                        </p>
                    </a>
                </li>



            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
