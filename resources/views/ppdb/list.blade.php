@extends('layouts.admin')

@section('title', 'List Peserta SPMB')

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="mb-2 row">
                    <div class="col-sm-6">
                        <h1>Dashboard</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="float-sm-right breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Peserta SPMB</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <div class="row">
                    <div class="mt-3 col-md-3">
                        <div class="">
                            <div class="form-group">
                                <label class="form-label">Data Tahun:</label>
                                <select class="form-control-border custom-select" id="ppdb-tahun">
                                    @for ($i = now()->year; $i >= $years_visible; $i--)
                                        <option value="{{ $i }}"
                                            {{ request('tahun', now()->year) == $i ? 'selected' : '' }}>{{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">

                        @if (session()->has('success'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h5><i class="icon fas fa-check"></i> Success!</h5>
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="card">
                            <div class="card-header">
                                <h3>Peserta SPMB</h3>

                                <div class="card-tools">
                                    <form
                                        action="{{ route('export.peserta.ppdb') }}?jurusan={{ request()->segment(4) }}&tahun={{ request('tahun', now()->year) }}&all=1"
                                        method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Export</button>
                                    </form>
                                </div>
                            </div>
                            <div class="p-0 py-2 card-body">
                                @if (!$pesertappdb->isEmpty())

                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped" id="list-ppdb">
                                            <thead>
                                                <tr>

                                                    <th>No. Pendaftaran</th>
                                                    <th>Nama</th>
                                                    <th>Tempat, Tanggal Lahir</th>
                                                    <th>No. Telepon</th>
                                                    <th>Asal Sekolah</th>
                                                    <th>Pilihan Jurusan</th>
                                                    <th>Status</th>
                                                    <th>Tanggal daftar</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($pesertappdb as $peserta)
                                                    <tr>
                                                        <td> {{ $peserta->no_pendaftaran }} </td>
                                                        <td> <a href="{{ route('ppdb.show.peserta', $peserta->id) }}">
                                                                {{ $peserta->nama_lengkap }}</a> </td>
                                                        <td> {{ $peserta->tempat_lahir }},
                                                            {{ $peserta->tanggal_lahir->format('d-m-Y') }} </td>
                                                        <td>
                                                            <a href="{{ $peserta->toWhatsapp($peserta->no_hp) }}">
                                                                {{ $peserta->no_hp }}
                                                            </a>
                                                        </td>
                                                        <td> {{ $peserta->asal_sekolah }} </td>
                                                        <td> {{ $peserta->jurusan->nama }} </td>
                                                        <td>
                                                            @switch($peserta->diterima)
                                                                @case(0)
                                                                    <span class="bg-warning badge">Proses seleksi</span>
                                                                @break

                                                                @case(1)
                                                                    <span class="bg-success badge">Di terima</span>
                                                                @break

                                                                @default
                                                                    <span class="bg-danger badge">Di tolak</span>
                                                            @endswitch
                                                        </td>
                                                        <td>{{ $peserta->created_at->format('d-m-Y H:i') }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    belum ada peserta
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


    </div>
@endsection


@section('head')
    <!-- DataTables -->
    <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

@endsection

@section('footer')
    <!-- DataTables  & Plugins -->
    <script src="/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>


    <!-- Page specific script -->
    <script>
        $(function() {

            $('#list-ppdb').DataTable({
                "paging": true,
                "lengthChange": true,
                "lengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                "searching": true,
                "ordering": false,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "buttons": ['copy', 'csv', 'excel'],
            });
        });
    </script>
@endsection
