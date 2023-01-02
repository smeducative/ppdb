@extends('layouts.admin')

@section('title', 'List Peserta PPDB')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Peserta PPDB</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-3 mt-3">
                    <div class="">
                                <div class="form-group">
                                    <label class="form-label">Data Tahun:</label>
                                    <select class="custom-select form-control-border" id="ppdb-tahun">
										@for($i = now()->year; $i >= 2021 ; $i--)
                                        <option value="{{ $i }}"  {{ request('tahun', now()->year) == $i ? 'selected' : '' }}>{{ $i }}</option>
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
                            <h3>Peserta PPDB</h3>

                            <div class="card-tools">
                                <form action="{{ route('export.peserta.ppdb') }}?jurusan={{ request()->segment(4) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary">Export</button>
                                </form>
                            </div>
                        </div>
                        <div class="card-body p-0 py-2">
                            @if (!$pesertappdb->isEmpty())

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="list-ppdb">
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
                                            <td> {{ $peserta->no_hp }} </td>
                                            <td> {{ $peserta->asal_sekolah }} </td>
                                            <td> {{ $peserta->jurusan->nama }} </td>
                                            <td>@switch($peserta->diterima)
                                                @case(0)
                                                <span class="badge bg-warning">Proses seleksi</span>
                                                @break
                                                @case(1)
                                                <span class="badge bg-success">Di terima</span>

                                                @break
                                                @default
                                                <span class="badge bg-danger">Di tolak</span>

                                                @endswitch</td>
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
    $(function () {

            $('#list-ppdb').DataTable({
                "paging": true,
                "lengthChange": false,
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
