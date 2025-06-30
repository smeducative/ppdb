@extends('layouts.admin')

@section('title', 'List Peserta PPDB')

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
                            <li class="breadcrumb-item active">Daftar Ulang Peserta PPDB</li>
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
                                    @for($i = now()->year; $i >= $years_visible ; $i--)
                                        <option value="{{ $i }}" {{ request('tahun', now()->year) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">

                        <div class="callout callout-info">
                            <h5>Info!</h5>

                            <p>Peserta yang telah melakukan pembayaran daftar ulang akan tampil disini. jika peserta belum
                                tampil, silahkan melakukan daftar ulang di menu kwitansi.</p>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h3>Peserta Daftar Ulang PPDB</h3>

                                <div class="card-tools">
                                    <form
                                        action="{{ route('export.peserta.ppdb') }}?jurusan={{ request()->segment(5) }}&tahun={{ request('tahun') }}&diterima=1&all=0"
                                        method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Export</button>
                                    </form>
                                </div>
                            </div>
                            <div class="table-responsive p-0 py-2 text-nowrap card-body">
                                @if (!$pesertappdb->isEmpty())

                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped" id="list-ppdb">
                                            <thead>
                                                <tr>
                                                    <th>No. Pendaftaran / Nama</th>
                                                    <th>Tempat, Tanggal Lahir</th>
                                                    <th>No. Telepon</th>
                                                    <th>Asal Sekolah</th>
                                                    <th>Pilihan Jurusan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($pesertappdb as $peserta)
                                                    <tr>
                                                        <td>
                                                            <a href="{{ route('ppdb.show.peserta', $peserta->id) }}">
                                                                {{ $peserta->nama_lengkap }}</a>
                                                                <br>
                                                                <span class="text-secondary">
                                                                    {{ $peserta->no_pendaftaran }}
                                                                </span>
                                                            </td>
                                                        <td> {{ $peserta->tempat_lahir }},
                                                            {{ $peserta->tanggal_lahir->format('d-m-Y') }} </td>
                                                        <td>
                                                            <a href="{{ $peserta->toWhatsapp($peserta->no_hp) }}">
                                                                {{ $peserta->no_hp }}
                                                            </a>
                                                        </td>
                                                        <td> {{ $peserta->asal_sekolah }} </td>
                                                        <td> {{ $peserta->jurusan->abbreviation }} </td>
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
