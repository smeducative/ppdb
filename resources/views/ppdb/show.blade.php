@extends('layouts.admin')

@section('title', $peserta->nama_lengkap)

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
                <div class="col-md-12">


                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Data diri peserta</h3>
                        </div>
                        <div class="card-body p-0">

                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>No. Pendaftaran</th>
                                        <td>:</td>
                                        <td>
                                            <strong>{{ $peserta->no_pendaftaran }}</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Nama Lengkap</th>
                                        <td>:</td>
                                        <td>
                                            <span>{{ $peserta->nama_lengkap }}</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

</div>


@endsection
