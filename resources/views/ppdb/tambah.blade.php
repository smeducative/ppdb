@extends('layouts.admin')


@section('title', 'Tambah Peserta PPDB')

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
                        <li class="breadcrumb-item active">Tambah Peserta</li>
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
                <div class="col-10">

                    <div class="card">

                        <div class="card-header">
                            <h3 class="card-title">Data diri pendaftar</h3>
                        </div>

                        <form action="{{ route('ppdb.tambah.pendaftar') }}" method="post">
                            @csrf

                            {{-- card body --}}

                            <div class="card-body">
                                {{-- nama lengkap --}}
                                <div class="form-group">
                                    <label>Nama Lengkap</label>
                                    <input type="text" class="form-control" name="nama_lengkap" id="name" value="{{ old('nama_lengkap') }}" placeholder="Nama Lengkap" required>
                                </div>

                                {{-- jenis kelamin --}}
                                <div class="form-group">
                                    <label>Jenis Kelamin</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="jenis_kelamin" value="l" checked="">
                                        <label class="form-check-label">Laki-laki</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="jenis_kelamin" value="p">
                                        <label class="form-check-label">Perempuan</label>
                                    </div>
                                </div>
                            </div>






                            {{-- card footer --}}
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </section>



</div>
@endsection
