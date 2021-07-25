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

                <div class="col-md-3 mt-3">
                    <div class="">
                                <div class="form-group">
                                    <label class="form-label">Data Tahun:</label>
                                    <select class="custom-select form-control-border" id="ppdb-tahun">
										@for($i = now()->year; $i >= 2021 ; $i--)
                                        <option value="{{ $i }}">{{ $i }}</option>
										@endfor
                                    </select>
                                </div>
                            </div>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <h5 class="mb-2">Info Pendaftar</h5>
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
							<h3>{{ $count['atph'] }}</h3>

                            <p>ATPH</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-leaf"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
							<h3>{{ $count['tbsm'] }}</h3>

                            <p>TBSM</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-settings"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
							<h3>{{ $count['tkj'] }}</h3>

                            <p>TKJ</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-wifi"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $count['all'] }}</h3>

                            <p>Total Pendaftar</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->

            <!-- Small boxes (Stat box) -->
            <h5 class="mb-2">Info Daftar Ulang</h5>
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $du['atph'] }}</h3>

                            <p>ATPH</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-leaf"></i>
                        </div>
                        <a href="{{ route('ppdb.daftar.ulang.list', ['jurusan' => 3]) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $du['tbsm'] }}</h3>

                            <p>TBSM</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-settings"></i>
                        </div>
                        <a href="{{ route('ppdb.daftar.ulang.list', ['jurusan' => 2]) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $du['tkj'] }}</h3>

                            <p>TKJ</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-wifi"></i>
                        </div>
                        <a href="{{ route('ppdb.daftar.ulang.list', ['jurusan' => 1]) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $du['all'] }}</h3>

                            <p>Total Pendaftar</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@section('footer')
	<script>
		$(document).ready(function () {
			$("#ppdb-tahun").on('change', function (e) {
				window.location.href = '?tahun='+e.target.value
			})
		})
	</script>
@endsection