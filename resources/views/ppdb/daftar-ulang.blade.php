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
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Form Daftar Ulang</h3>
                        </div>

                        <div class="card-body p-0">

                            <form action="{{ route('ppdb.daftar.ulang', ['uuid' => $peserta->id ]) }}" method="POST">
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
                                            <input type="text" class="form-control" name="jenis_pembayaran" value="Daftar Ulang PPDB">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Jumlah</th>
                                        <td width="5%">:</td>
                                        <td>
                                            <input type="text" class="form-control" name="jumlah">
                                        </td>
                                    </tr>
                                </tbody>
                             </table>

                            </form>


                        <div class="card-footer">
                            <a href="{{ route('ppdb.daftar-ulang', ['uuid' => $peserta->id ]) }}" type="button" class="btn btn-primary">Daftar Ulang</a>
                        </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection
