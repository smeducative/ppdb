@extends('layouts.admin')

@section('title', 'Dashboard')


@section('content')
    <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Dashboard</h1>
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
                <div class="col-md-12">

                    {{-- alert --}}
                    @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fas fa-check"></i> Success!</h5>
                            {{ session('success') }}
                        </div>
                    @endif


                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Kwitansi Peserta</h3>
                        </div>

                        <div class="card-body p-0">

                            <form action="{{ route('ppdb.kwitansi.tambah', ['uuid' => $peserta->id ]) }}" method="POST">
                                @csrf

                             <table class="table">
                                <tbody>
                                    <tr>
                                        <th width="30%">No. Pendaftaran</th>
                                        <td width="5%">:</td>
                                        <td>
                                            <strong>{{ $peserta->no_pendaftaran }}</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Nama Lengkap</th>
                                        <td width="5%">:</td>
                                        <td>
                                            <span>{{ $peserta->nama_lengkap }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Jenis Pembayaran</th>
                                        <td width="5%">:</td>
                                        <td>
                                            <input type="text" class="form-control" name="jenis_pembayaran" placeholder="Jenis Pembayaran" required>
                                            <span class="text-secondary">contoh: daftar ulang, seragam, lainnya</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Jumlah</th>
                                        <td width="5%">:</td>
                                        <td>
                                            <input type="number" class="form-control" name="nominal" placeholder="Nominal" min=1 required>
                                            <span class="text-secondary">contoh: 150000</span>
                                            <span class="text-danger">*tanpa titik maupun koma</span>
                                        </td>
                                    </tr>
                                </tbody>
                             </table>



                        <div class="card-footer">
                            <span>Pastikan untuk menerima biaya sebelum menambahkan kwitansi</span> <br>
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>


                            </form>

                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card">

                        <div class="card-header">
                            <h3 class="card-title">kwitansi Pembayaran</h3>

                            <div class="card-tools">
                                <form action="{{ route('ppdb.cetak.kwitansi', ['uuid' => $peserta->id]) }}" method="POST">
                                    <button class="btn btn-outline-success disabled">
                                        Total terbayar: Rp. {{ number_format($peserta->kwitansi->sum('nominal'), 0, ',', '.') }}
                                    </button>
                                    @csrf

                                    <button type="submit" class="btn btn-primary"> <i class="fas fa-print mr-2"></i> Cetak Semua</button>
                                </form>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-0">

                            @if ($peserta->kwitansi->count())
                            <table class="table table-sm table-hover text-nowrap">

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


                                    @foreach ($peserta->kwitansi as $kwitansi)
                                    <tr>
                                        <td>{{ $peserta->no_pendaftaran }}</td>
                                        <td>{{ $peserta->nama_lengkap}}</td>
                                        <td>{{ $kwitansi->jenis_pembayaran }}</td>
                                        <td>Rp. {{ number_format($kwitansi->nominal, 0, ',', '.') }},-</td>
                                        <td>{{ $kwitansi->created_at->translatedFormat('l, d F Y H:i') }}</td>
                                        <td>{{ $kwitansi->penerima->name }}</td>
                                        <td>
                                            <form action="{{ route('ppdb.cetak.kwitansi.single', ['uuid' => $peserta->id, 'id' => $kwitansi->id]) }}" method="POST">
                                    @csrf

                                    <button type="submit" class="btn btn-primary"> <i class="fas fa-print mr-2"></i> Cetak</button>

                                </form> </td>
                                    </tr>
                                    @endforeach
                                </tbody>

                            </table>
                            @else

                            <div class="">
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
