<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <img src="/img/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="font-weight-light brand-text">PPDB | Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="flex-column nav nav-pills nav-sidebar" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a href="/master/jurusan" class="nav-link">
                        <i class="fa-list-alt nav-icon fas"></i>
                        <p>
                            Jurusan
                        </p>
                    </a>
                </li> --}}
                <li
                    class="nav-item has-treeview {{ request()->routeIs('ppdb.tambah.pendaftar') || request()->routeIs('ppdb.list.pendaftar') || request()->routeIs('ppdb.list.pendaftar.jurusan') || request()->routeIs('ppdb.show.peserta') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->routeIs('ppdb.tambah.pendaftar') || request()->routeIs('ppdb.list.pendaftar') || request()->routeIs('ppdb.list.pendaftar.jurusan') || request()->routeIs('ppdb.show.peserta') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>
                            Pendaftaran PPDB
                            <i class="right fa-angle-left fas"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('ppdb.tambah.pendaftar') }}"
                                class="nav-link {{ request()->routeIs('ppdb.tambah.pendaftar') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tambah Peserta PPDB</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.list.pendaftar') }}"
                                class="nav-link {{ request()->routeIs('ppdb.list.pendaftar') || request()->routeIs('ppdb.show.peserta') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List Semua Peserta</p>
                            </a>
                        </li>

                        <!-- per jurusan -->
                        <li class="nav-item">
                            <a href="{{ route('ppdb.list.pendaftar.jurusan', ['jurusan' => 3]) }}"
                                class="nav-link {{ request()->is('dashboard/ppdb/list-pendaftar/3') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>AT</p>
                            </a>
                        </li>

                        @if (request()->query('tahun', now()->year) < 2025)
                            <li class="nav-item">
                                <a href="{{ route('ppdb.list.pendaftar.jurusan', ['jurusan' => 2]) }}"
                                    class="nav-link  {{ request()->is('dashboard/ppdb/list-pendaftar/2') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>TO</p>
                                </a>
                            </li>
                        @endif

                        <li class="nav-item">
                            <a href="{{ route('ppdb.list.pendaftar.jurusan', ['jurusan' => 1]) }}"
                                class="nav-link {{ request()->is('dashboard/ppdb/list-pendaftar/1') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>TKJ</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.list.pendaftar.jurusan', ['jurusan' => 4]) }}"
                                class="nav-link {{ request()->is('dashboard/ppdb/list-pendaftar/4') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>BDP</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.list.pendaftar.jurusan', ['jurusan' => 6]) }}"
                                class="nav-link {{ request()->is('dashboard/ppdb/list-pendaftar/6') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>TSM</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.list.pendaftar.jurusan', ['jurusan' => 7]) }}"
                                class="nav-link {{ request()->is('dashboard/ppdb/list-pendaftar/7') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>TKR</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.list.pendaftar.jurusan', ['jurusan' => 8]) }}"
                                class="nav-link {{ request()->is('dashboard/ppdb/list-pendaftar/8') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ACP</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li
                    class="nav-item has-treeview {{ request()->routeIs('ppdb.daftar.ulang.list') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->routeIs('ppdb.daftar.ulang.list') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-check-double"></i>
                        <p>
                            List Daftar Ulang
                            <i class="right fa-angle-left fas"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('ppdb.daftar.ulang.list') }}"
                                class="nav-link {{ request()->is('dashboard/ppdb/list/terdaftar-ulang') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List Semua Peserta</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.daftar.ulang.list', ['jurusan' => 3]) }}"
                                class="nav-link {{ request()->is('dashboard/ppdb/list/terdaftar-ulang/3') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>DU AT</p>
                            </a>
                        </li>
                        @if (request()->query('tahun', now()->year) < 2025)
                            <li class="nav-item">
                                <a href="{{ route('ppdb.daftar.ulang.list', ['jurusan' => 2]) }}"
                                    class="nav-link {{ request()->is('dashboard/ppdb/list/terdaftar-ulang/2') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>DU TO</p>
                                </a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a href="{{ route('ppdb.daftar.ulang.list', ['jurusan' => 1]) }}"
                                class="nav-link {{ request()->is('dashboard/ppdb/list/terdaftar-ulang/1') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>DU TJKT</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.daftar.ulang.list', ['jurusan' => 4]) }}"
                                class="nav-link {{ request()->is('dashboard/ppdb/list/terdaftar-ulang/4') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>DU BDP</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.daftar.ulang.list', ['jurusan' => 6]) }}"
                                class="nav-link {{ request()->is('dashboard/ppdb/list/terdaftar-ulang/6') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>DU TSM</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.daftar.ulang.list', ['jurusan' => 7]) }}"
                                class="nav-link {{ request()->is('dashboard/ppdb/list/terdaftar-ulang/7') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>DU TKR</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.daftar.ulang.list', ['jurusan' => 8]) }}"
                                class="nav-link {{ request()->is('dashboard/ppdb/list/terdaftar-ulang/8') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>DU ACP</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li
                    class="nav-item has-treeview {{ request()->routeIs('ppdb.belum.daftar.ulang.list') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->routeIs('ppdb.belum.daftar.ulang.list') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-times-circle"></i>
                        <p>
                            List Belum Daftar Ulang
                            <i class="right fa-angle-left fas"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('ppdb.belum.daftar.ulang.list') }}"
                                class="nav-link {{ request()->is('dashboard/ppdb/list/belum-daftar-ulang') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List Semua Peserta</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.belum.daftar.ulang.list', ['jurusan' => 3]) }}"
                                class="nav-link {{ request()->is('dashboard/ppdb/list/belum-daftar-ulang/3') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>BDU AT</p>
                            </a>
                        </li>
                        @if (request()->query('tahun', now()->year) < 2025)
                            <li class="nav-item">
                                <a href="{{ route('ppdb.belum.daftar.ulang.list', ['jurusan' => 2]) }}"
                                    class="nav-link {{ request()->is('dashboard/ppdb/list/belum-daftar-ulang/2') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>BDU TO</p>
                                </a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a href="{{ route('ppdb.belum.daftar.ulang.list', ['jurusan' => 1]) }}"
                                class="nav-link {{ request()->is('dashboard/ppdb/list/belum-daftar-ulang/1') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>BDU TJKT</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.belum.daftar.ulang.list', ['jurusan' => 4]) }}"
                                class="nav-link {{ request()->is('dashboard/ppdb/list/belum-daftar-ulang/4') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>BDU BDP</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.belum.daftar.ulang.list', ['jurusan' => 6]) }}"
                                class="nav-link {{ request()->is('dashboard/ppdb/list/belum-daftar-ulang/6') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>BDU TSM</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.belum.daftar.ulang.list', ['jurusan' => 7]) }}"
                                class="nav-link {{ request()->is('dashboard/ppdb/list/belum-daftar-ulang/7') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>BDU TKR</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.belum.daftar.ulang.list', ['jurusan' => 8]) }}"
                                class="nav-link {{ request()->is('dashboard/ppdb/list/belum-daftar-ulang/8') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>BDU ACP</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li
                    class="nav-item has-treeview {{ request()->routeIs('ppdb.seragam.show.jurusan') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->routeIs('ppdb.seragam.show.jurusan') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tshirt"></i>
                        <p>
                            List Ukuran Baju
                            <i class="right fa-angle-left fas"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('ppdb.seragam.show.jurusan') }}"
                                class="nav-link {{ request()->is('dashboard/ukuran-seragam/show') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List Semua Peserta</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.seragam.show.jurusan', ['jurusan' => 3]) }}"
                                class="nav-link {{ request()->is('dashboard/ukuran-seragam/show/3') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>AT</p>
                            </a>
                        </li>
                        @if (request()->query('tahun', now()->year) < 2025)
                            <li class="nav-item">
                                <a href="{{ route('ppdb.seragam.show.jurusan', ['jurusan' => 2]) }}"
                                    class="nav-link {{ request()->is('dashboard/ukuran-seragam/show/2') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>TO</p>
                                </a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a href="{{ route('ppdb.seragam.show.jurusan', ['jurusan' => 1]) }}"
                                class="nav-link {{ request()->is('dashboard/ukuran-seragam/show/1') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>TJKT</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.seragam.show.jurusan', ['jurusan' => 4]) }}"
                                class="nav-link {{ request()->is('dashboard/ukuran-seragam/show/4') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>BDP</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.seragam.show.jurusan', ['jurusan' => 6]) }}"
                                class="nav-link {{ request()->is('dashboard/ukuran-seragam/show/6') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>TSM</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.seragam.show.jurusan', ['jurusan' => 7]) }}"
                                class="nav-link {{ request()->is('dashboard/ukuran-seragam/show/7') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>TKR</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.seragam.show.jurusan', ['jurusan' => 8]) }}"
                                class="nav-link {{ request()->is('dashboard/ukuran-seragam/show/8') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ACP</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-header">CETAK DOKUMEN</li>
                <li
                    class="nav-item has-treeview {{ request()->routeIs('ppdb.kartu.show.jurusan') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->routeIs('ppdb.kartu.show.jurusan') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-id-card"></i>
                        <p>
                            Kartu Pendaftaran
                            <i class="right fa-angle-left fas"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('ppdb.kartu.show.jurusan', ['jurusan' => 3]) }}"
                                class="nav-link {{ request()->is('dashboard/kartu-pendaftaran/show/3') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kartu AT</p>
                            </a>
                        </li>
                        @if (request()->query('tahun', now()->year) < 2025)
                            <li class="nav-item">
                                <a href="{{ route('ppdb.kartu.show.jurusan', ['jurusan' => 2]) }}"
                                    class="nav-link {{ request()->is('dashboard/kartu-pendaftaran/show/2') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Kartu TO</p>
                                </a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a href="{{ route('ppdb.kartu.show.jurusan', ['jurusan' => 1]) }}"
                                class="nav-link {{ request()->is('dashboard/kartu-pendaftaran/show/1') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kartu TJKT</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.kartu.show.jurusan', ['jurusan' => 4]) }}"
                                class="nav-link {{ request()->is('dashboard/kartu-pendaftaran/show/4') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kartu BDP</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.kartu.show.jurusan', ['jurusan' => 6]) }}"
                                class="nav-link {{ request()->is('dashboard/kartu-pendaftaran/show/6') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kartu TSM</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.kartu.show.jurusan', ['jurusan' => 7]) }}"
                                class="nav-link {{ request()->is('dashboard/kartu-pendaftaran/show/7') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kartu TKR</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.kartu.show.jurusan', ['jurusan' => 8]) }}"
                                class="nav-link {{ request()->is('dashboard/kartu-pendaftaran/show/8') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kartu ACP</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li
                    class="nav-item has-treeview {{ request()->routeIs('ppdb.formulir.show.jurusan') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link  {{ request()->routeIs('ppdb.formulir.show.jurusan') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file"></i>
                        <p>
                            Form Pendaftaran
                            <i class="right fa-angle-left fas"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('ppdb.formulir.show.jurusan', ['jurusan' => 3]) }}"
                                class="nav-link {{ request()->is('dashboard/formulir/show/3') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Form AT</p>
                            </a>
                        </li>
                        @if (request()->query('tahun', now()->year) < 2025)
                            <li class="nav-item">
                                <a href="{{ route('ppdb.formulir.show.jurusan', ['jurusan' => 2]) }}"
                                    class="nav-link {{ request()->is('dashboard/formulir/show/2') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Form TO</p>
                                </a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a href="{{ route('ppdb.formulir.show.jurusan', ['jurusan' => 1]) }}"
                                class="nav-link {{ request()->is('dashboard/formulir/show/1') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Form TJKT</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.formulir.show.jurusan', ['jurusan' => 4]) }}"
                                class="nav-link {{ request()->is('dashboard/formulir/show/4') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Form BDP</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.formulir.show.jurusan', ['jurusan' => 6]) }}"
                                class="nav-link {{ request()->is('dashboard/formulir/show/6') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Form TSM</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.formulir.show.jurusan', ['jurusan' => 7]) }}"
                                class="nav-link {{ request()->is('dashboard/formulir/show/7') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Form TKR</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.formulir.show.jurusan', ['jurusan' => 8]) }}"
                                class="nav-link {{ request()->is('dashboard/formulir/show/8') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Form ACP</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li
                    class="nav-item has-treeview {{ request()->routeIs('ppdb.surat.show.jurusan') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->routeIs('ppdb.surat.show.jurusan') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>
                            Surat Diterima
                            <i class="right fa-angle-left fas"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('ppdb.surat.show.jurusan', ['jurusan' => 3]) }}"
                                class="nav-link {{ request()->is('dashboard/surat/show/3') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Surat AT</p>
                            </a>
                        </li>
                        @if (request()->query('tahun', now()->year) < 2025)
                            <li class="nav-item">
                                <a href="{{ route('ppdb.surat.show.jurusan', ['jurusan' => 2]) }}"
                                    class="nav-link {{ request()->is('dashboard/surat/show/2') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Surat TO</p>
                                </a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a href="{{ route('ppdb.surat.show.jurusan', ['jurusan' => 1]) }}"
                                class="nav-link {{ request()->is('dashboard/surat/show/1') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Surat TJKT</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.surat.show.jurusan', ['jurusan' => 4]) }}"
                                class="nav-link {{ request()->is('dashboard/surat/show/4') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Surat BDP</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.surat.show.jurusan', ['jurusan' => 6]) }}"
                                class="nav-link {{ request()->is('dashboard/surat/show/6') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Surat TSM</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.surat.show.jurusan', ['jurusan' => 7]) }}"
                                class="nav-link {{ request()->is('dashboard/surat/show/7') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Surat TKR</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.surat.show.jurusan', ['jurusan' => 8]) }}"
                                class="nav-link {{ request()->is('dashboard/surat/show/8') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Surat ACP</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li
                    class="nav-item has-treeview {{ request()->routeIs('ppdb.kwitansi.show') || request()->routeIs('ppdb.kwitansi.show.jurusan') || request()->routeIs('ppdb.rekap.kwitansi') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->routeIs('ppdb.kwitansi.show') || request()->routeIs('ppdb.kwitansi.show.jurusan') || request()->routeIs('ppdb.rekap.kwitansi') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-money-check"></i>
                        <p>
                            Kwitansi
                            <i class="right fa-angle-left fas"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('ppdb.kwitansi.show') }}"
                                class="nav-link  {{ request()->routeIs('ppdb.kwitansi.show') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List Peserta Diterima</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.kwitansi.show.jurusan', ['jurusan' => 3]) }}"
                                class="nav-link {{ request()->is('dashboard/kwitansi/show/3') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kwitansi AT</p>
                            </a>
                        </li>
                        @if (request()->query('tahun', now()->year) < 2025)
                            <li class="nav-item">
                                <a href="{{ route('ppdb.kwitansi.show.jurusan', ['jurusan' => 2]) }}"
                                    class="nav-link {{ request()->is('dashboard/kwitansi/show/2') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Kwitansi TO</p>
                                </a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a href="{{ route('ppdb.kwitansi.show.jurusan', ['jurusan' => 1]) }}"
                                class="nav-link {{ request()->is('dashboard/kwitansi/show/1') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kwitansi TJKT</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.kwitansi.show.jurusan', ['jurusan' => 4]) }}"
                                class="nav-link {{ request()->is('dashboard/kwitansi/show/4') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kwitansi BDP</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.kwitansi.show.jurusan', ['jurusan' => 6]) }}"
                                class="nav-link {{ request()->is('dashboard/kwitansi/show/6') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kwitansi TSM</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.kwitansi.show.jurusan', ['jurusan' => 7]) }}"
                                class="nav-link {{ request()->is('dashboard/kwitansi/show/7') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kwitansi TKR</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.kwitansi.show.jurusan', ['jurusan' => 8]) }}"
                                class="nav-link {{ request()->is('dashboard/kwitansi/show/8') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kwitansi ACP</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ppdb.rekap.kwitansi') }}"
                                class="nav-link {{ request()->routeIs('ppdb.rekap.kwitansi') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Rekap Pembayaran</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-header">Penerima Beasiswa</li>

                <li class="nav-item">
                    <a href="{{ route('ppdb.beasiswa.mwc') }}"
                        class="nav-link {{ request()->routeIs('ppdb.beasiswa.mwc') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-award"></i>
                        <p>
                            Rekomendasi MWC
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('ppdb.beasiswa.akademik') }}"
                        class="nav-link {{ request()->routeIs('ppdb.beasiswa.akademik') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-trophy"></i>
                        <p>
                            Akademik
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('ppdb.beasiswa.tahfidz') }}"
                        class="nav-link {{ request()->routeIs('ppdb.beasiswa.tahfidz') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            Akademik [Tahfidz]
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('ppdb.beasiswa.non-akademik') }}"
                        class="nav-link {{ request()->routeIs('ppdb.beasiswa.non-akademik') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-star"></i>
                        <p>
                            Non Akademik
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('ppdb.beasiswa.kip') }}"
                        class="nav-link {{ request()->routeIs('ppdb.beasiswa.kip') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-medal"></i>
                        <p>
                            KIP
                        </p>
                    </a>
                </li>
                <li class="nav-header">PENGATURAN AKUN</li>

                <li class="nav-item">
                    <a href="{{ route('setting.profile') }}"
                        class="nav-link {{ request()->routeIs('setting.profile') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Pengaturan Profile
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('ppdb.set.batas.akhir') }}"
                        class="nav-link {{ request()->routeIs('ppdb.set.batas.akhir') ? 'active' : '' }}">
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
