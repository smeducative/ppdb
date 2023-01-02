@extends('layouts.admin')

@section('title', 'Rekap Kwitansi')


@section('content')
    <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Rekap Kwitansi</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/master/home">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
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
            </div>

            <div class="col-md-12">
                <h2>
                    Dana Kelola PPDB
                </h2>
            </div>

            {{-- counter --}}
            <div class="row">
                 <!-- ./col -->
                <div class="col-md-4">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>Rp. {{ number_format($danaKelola, 0,',', '.') }},-</h3>

                            <p>Dana masuk</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-cash"></i>
                        </div>
                        {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
                    </div>
                </div>
                 <!-- ./col -->
                <div class="col-md-4">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $kwitansies->filter(fn ($d) => is_null($d->deleted_at))->count() }}</h3>

                            <p>Jumlah Kwitansi</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-document-text"></i>
                        </div>
                        {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Jenis Dana Kelola</h3>

                            <div class="card-tools">
                                <form action="{{ route('ppdb.rekap.kwitansi-dana') }}?tahun={{ request('tahun', now()->year) }}" method="POST">
                                    @csrf

                                    <button class="btn btn-primary">
                                        <i class="fas fa-print mr-2"></i>
                                        Export .xlsx
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Jenis Pembayaran</th>
                                        <th>Total dana</th>
                                        <th>Jumlah kwitansi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($jenisPembayaran as $jenis => $dana)
                                        <tr>
                                            <td>{{ $jenis }}</td>
                                            <td>Rp. {{ number_format($dana->sum('nominal'), 0, ',', '.') }},-</td>
                                            <td>{{ $dana->count() }}</td>
                                        </tr>
                                    @empty

                                    @endforelse
                                    {{--  --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">

                        <div class="card-header">
                            <h3 class="card-title">Riwayat kwitansi terakhir</h3>
                            <div class="card-tools">
                                <form action="{{ route('ppdb.rekap.kwitansi-riwayat') }}?tahun={{ request('tahun', now()->year) }}" method="POST">
                                    @csrf

                                    <button class="btn btn-primary">
                                        <i class="fas fa-print mr-2"></i>
                                        Export .xlsx
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-0">

                            @if ($kwitansies->count())
                            <table class="table table-sm table-hover text-nowrap" id="list-kwitansi">

                                <thead>

                                    <tr>
                                        <th>No. Peserta</th>
                                        <th>Nama Lengkap</th>
                                        <th>Jenis Pembayaran</th>
                                        <th>Jumlah</th>
                                        <th>Pada Tanggal</th>
                                        <th>Penerima</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>


                                    @foreach ($kwitansies as $kwitansi)
                                    <tr @class([
                                        'table-danger'  => $kwitansi->deleted_at
                                    ])>
                                        <td>{{ $kwitansi->pesertaPpdb->no_pendaftaran }}</td>
                                        <td>{{ $kwitansi->pesertaPpdb->nama_lengkap}}</td>
                                        <td>{{ $kwitansi->jenis_pembayaran }}</td>
                                        <td>Rp. {{ number_format($kwitansi->nominal, 0, ',', '.') }},-</td>
                                        <td>{{ $kwitansi->created_at->translatedFormat('l, d F Y H:i') }}</td>
                                        <td>{{ $kwitansi->penerima->name }}</td>
                                        <td>
                                            @if (!$kwitansi->deleted_at)
                                            <form action="{{ route('ppdb.cetak.kwitansi.single', ['uuid' => $kwitansi->pesertaPpdb->id, 'id' => $kwitansi->id]) }}" method="POST">
                                                @csrf

                                                <button type="submit" class="btn btn-primary"> <i class="fas fa-print mr-2"></i> Cetak</button>

                                            </form>
                                            @else
                                            <div>
                                                <strong class="text-danger">dihapus</strong> <br>
                                                <span>
                                                    {{ $kwitansi->deletedBy->name }}
                                                </span>
                                            </div>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>

                            </table>
                            @else

                            <div class="p-5">
                                belum ada kwitansi untuk di tampilkan
                            </div>

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

            $('#list-kwitansi').DataTable({
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
