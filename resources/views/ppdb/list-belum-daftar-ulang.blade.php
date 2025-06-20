@extends('layouts.admin')

@section('title', 'List Peserta Belum Daftar Ulang')

@section('head')
    <!-- DataTables -->
    <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="mb-2 row">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">List Peserta Belum Daftar Ulang</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="float-sm-right breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">List Peserta Belum Daftar Ulang</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="callout callout-info">
                            <h5>Info!</h5>

                        <p>Peserta yang belum melakukan pembayaran daftar ulang akan tampil disini. jika peserta belum
                            tampil, silahkan melakukan daftar ulang di menu kwitansi.</p>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Data Peserta Belum Daftar Ulang</h3>
                            <div class="card-tools">
                                <form action="" method="get" style="display: inline-block;">
                                    <div class="input-group input-group-sm" style="width: 150px;">
                                        <select name="tahun" class="float-right form-control" onchange="this.form.submit()">
                                            @for($i = now()->year; $i >= 2021; $i--)
                                                <option value="{{ $i }}" {{ request('tahun', now()->year) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </form>
                                <form
                                    action="{{ route('export.belum.daftar.ulang') }}?jurusan={{ request()->segment(5) }}&tahun={{ request('tahun', now()->year) }}"
                                    method="POST"
                                    style="display: inline-block;">
                                    @csrf
                                    <input type="hidden" name="tahun" value="{{ request('tahun', now()->year) }}">
                                    <button type="submit" class="btn btn-sm btn-primary">Export</button>
                                </form>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="table-responsive p-0 py-2 text-nowrap card-body">
                            <table class="table table-hover text-nowrap" id="list-belum-daftar-ulang">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>No Pendaftaran</th>
                                        <th>Nama Lengkap</th>
                                        <th>Jurusan</th>
                                        <th>Asal Sekolah</th>
                                        <th>No HP</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pesertappdb as $index => $peserta)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $peserta->no_pendaftaran }}</td>
                                            <td>{{ $peserta->nama_lengkap }}</td>
                                            <td>{{ $peserta->jurusan->abbreviation ?? '-' }}</td>
                                            <td>{{ $peserta->asal_sekolah }}</td>
                                            <td>
                                                <a href="{{ $peserta->toWhatsapp($peserta->no_hp) }}" target="_blank">{{ $peserta->no_hp }}</a>
                                            </td>
                                            <td>
                                                @if($peserta->diterima == 1)
                                                    <span class="badge badge-success">Diterima</span>
                                                @elseif($peserta->diterima == 2)
                                                    <span class="badge badge-danger">Ditolak</span>
                                                @else
                                                    <span class="badge badge-warning">Belum Diverifikasi</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('ppdb.show.peserta', $peserta->id) }}" class="btn btn-sm btn-info">Lihat</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if($pesertappdb->isEmpty())
                                        <tr>
                                            <td colspan="8" class="text-center">Tidak ada data peserta yang belum daftar ulang.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection

@section('footer')
    <!-- DataTables  & Plugins -->
    <script src="/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script>
        $(function() {
            $('#list-belum-daftar-ulang').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": false,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
@endsection
