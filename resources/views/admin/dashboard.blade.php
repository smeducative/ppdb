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
                        <a href="{{ route('ppdb.list.pendaftar.jurusan', ['jurusan' => 3]) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
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
                        <a href="{{ route('ppdb.list.pendaftar.jurusan', ['jurusan' => 2]) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
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
                        <a href="{{ route('ppdb.list.pendaftar.jurusan', ['jurusan' => 1]) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
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

			<!-- Graphic card -->
			<h5 class="mb-2">Graphic Chart</h5>
			<div class="row">
				<div class="col-md-6">
					<!-- BAR CHART -->
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Perbandingan jenis kelamin pendaftar</h3>

                <div class="card-tools">

                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
				</div>

				<div class="col-md-6">
					<!-- PIE CHART -->
            <div class="card card-danger">
              <div class="card-header">
                <h3 class="card-title">Perbandingan pendaftar tiap jurusan</h3>
              </div>
              <div class="card-body">
                <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

				</div>
			</div>
			<!-- row graphic card -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@section('footer')<!-- ChartJS -->
<script src="/plugins/chart.js/Chart.min.js"></script>
	<script>
		$(document).ready(function () {
			$("#ppdb-tahun").on('change', function (e) {
				window.location.href = '?tahun='+e.target.value
			})


			var areaChartData = {
			  labels  : ['TKJ', 'TBSM', 'ATPH'],
			  datasets: [
				{
				  label               : 'Laki-laki',
				  backgroundColor     : 'rgba(60,141,188,0.9)',
				  borderColor         : 'rgba(60,141,188,0.8)',
				  pointRadius          : false,
				  pointColor          : '#3b8bba',
				  pointStrokeColor    : 'rgba(60,141,188,1)',
				  pointHighlightFill  : '#fff',
				  pointHighlightStroke: 'rgba(60,141,188,1)',
				  data                : {!! $compareSx['l'] !!}
				},
				{
				  label               : 'Perempuan',
				  backgroundColor     : 'rgba(210, 214, 222, 1)',
				  borderColor         : 'rgba(210, 214, 222, 1)',
				  pointRadius         : false,
				  pointColor          : 'rgba(210, 214, 222, 1)',
				  pointStrokeColor    : '#c1c7d1',
				  pointHighlightFill  : '#fff',
				  pointHighlightStroke: 'rgba(220,220,220,1)',
				  data                : {!! $compareSx['p'] !!}
				}
			  ]
			}


			//-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = $.extend(true, {}, areaChartData)
    var temp0 = areaChartData.datasets[0]
    var temp1 = areaChartData.datasets[1]
    barChartData.datasets[0] = temp1
    barChartData.datasets[1] = temp0

    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false
    }

    new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartData,
      options: barChartOptions
    })


		//-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
		var donutData        = {
		  labels: [
			  'TKJ',
			  'TBSM',
			  'ATPH',
		  ],
		  datasets: [
			{
			  data: {!! collect($count)->except('all')->values() !!},
			  backgroundColor : ['#f56954', '#00c0ef', '#00a65a'],
			}
		  ]
		}

    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieData        = donutData;
    var pieOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(pieChartCanvas, {
      type: 'pie',
      data: pieData,
      options: pieOptions
    })



		})
	</script>
@endsection
