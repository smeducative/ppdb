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
                                    @for ($i = now()->year; $i >= $years_visible; $i--)
                                        <option value="{{ $i }}"
                                            {{ request('tahun', now()->year) == $i ? 'selected' : '' }}>{{ $i }}
                                        </option>
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
                <h5 class="mb-2">Jumlah total</h5>
                <div class="row">
                    <!-- ./col -->
                    <div class="col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $count['all'] }}</h3>

                                <p>Total Pendaftar</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $du['all'] }}</h3>

                                <p>Total Daftar Ulang</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $penerimaan['diterima'] }}</h3>

                                <p>Total Peserta Diterima</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $penerimaan['ditolak'] }}</h3>

                                <p>Total Peserta Ditolak</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <h5 class="mb-2">Info Pendaftar</h5>
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $count['atph'] }}</h3>

                                <p>AT</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-leaf"></i>
                            </div>
                            <a href="{{ route('ppdb.list.pendaftar.jurusan', ['jurusan' => 3]) }}"
                                class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-2 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $count['tsm'] }}</h3>

                                <p>TSM</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-settings"></i>
                            </div>
                            <a href="{{ route('ppdb.list.pendaftar.jurusan', ['jurusan' => 2]) }}"
                                class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-2 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $count['tkr'] }}</h3>

                                <p>TKR</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-settings"></i>
                            </div>
                            <a href="{{ route('ppdb.list.pendaftar.jurusan', ['jurusan' => 2]) }}"
                                class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-2 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $count['tkj'] }}</h3>

                                <p>TKJ</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-wifi"></i>
                            </div>
                            <a href="{{ route('ppdb.list.pendaftar.jurusan', ['jurusan' => 1]) }}"
                                class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-orange">
                            <div class="inner">
                                <h3>{{ $count['bdp'] }}</h3>

                                <p>BDP</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-film-marker"></i>
                            </div>
                            <a href="{{ route('ppdb.list.pendaftar.jurusan', ['jurusan' => 4]) }}"
                                class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
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

                                <p>AT</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-leaf"></i>
                            </div>
                            <a href="{{ route('ppdb.daftar.ulang.list', ['jurusan' => 3]) }}" class="small-box-footer">More
                                info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-2 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $du['tsm'] }}</h3>

                                <p>TSM</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-settings"></i>
                            </div>
                            <a href="{{ route('ppdb.daftar.ulang.list', ['jurusan' => 2]) }}" class="small-box-footer">More
                                info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-2 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $du['tkr'] }}</h3>

                                <p>TKR</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-settings"></i>
                            </div>
                            <a href="{{ route('ppdb.daftar.ulang.list', ['jurusan' => 2]) }}" class="small-box-footer">More
                                info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-2 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $du['tkj'] }}</h3>

                                <p>TKJ</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-wifi"></i>
                            </div>
                            <a href="{{ route('ppdb.daftar.ulang.list', ['jurusan' => 1]) }}"
                                class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-orange">
                            <div class="inner">
                                <h3>{{ $du['bdp'] }}</h3>

                                <p>BDP</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-film-marker"></i>
                            </div>
                            <a href="{{ route('ppdb.daftar.ulang.list', ['jurusan' => 4]) }}"
                                class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
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
                            </div>
                            <div class="card-body">
                                <div class="chart">
                                    <canvas id="barChart"
                                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>

                    {{-- COMPARE DX --}}
                    <div class="col-md-6">
                        <!-- BAR CHART -->
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">Perbandingan jenis kelamin daftar ulang</h3>
                            </div>
                            <div class="card-body">
                                <div class="chart">
                                    <canvas id="duBarChart"
                                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
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
                                <canvas id="pieChart"
                                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>

                    {{-- du tiap jurusan --}}
                    <div class="col-md-6">
                        <!-- PIE CHART -->
                        <div class="card card-danger">
                            <div class="card-header">
                                <h3 class="card-title">Perbandingan daftar ulang tiap jurusan</h3>
                            </div>
                            <div class="card-body">
                                <canvas id="pieDuChart"
                                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>

                    {{-- perbandingan pendaftar pertahun --}}
                    <div class="col-md-12">
                        <!-- PIE CHART -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Perbandingan pendaftar perbulan dengan tahun sebelumnya</h3>
                            </div>
                            <div class="card-body">
                                <canvas id="yearDiff"
                                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>

                    <div class="col-md-12">
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title">Jumlah pendaftar per sekolah</h3>

                                <div class="card-tools">
                                    <form action="{{ route('export.rekap-sekolah') }}" method="post">
                                        @csrf

                                        <button type="submit" class="btn btn-primary">export .xlsx</button>
                                    </form>
                                </div>
                            </div>
                            <div class="card-body p-0 py-2 table-responsive text-nowrap">
                                @if (!$pendaftarPerSekolah->isEmpty())

                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered" id="list-sekolah">
                                            <thead>
                                                <tr>

                                                    <th>Nama Sekolah</th>
                                                    <th>Jumlah</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($pendaftarPerSekolah as $sekolah)
                                                    <tr>
                                                        <td> {{ $sekolah->asal_sekolah }} </td>
                                                        <td> {{ $sekolah->as_count }} </td>
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
        $(document).ready(function() {

            $('#list-sekolah').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": false,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });

            // pendaftar
            var areaChartData = {
                labels: ['TKJ', 'AT', 'BDP', 'TSM', 'TKR'],
                datasets: [{
                        label: 'Laki-laki',
                        backgroundColor: 'rgba(60,141,188,0.9)',
                        borderColor: 'rgba(60,141,188,0.8)',
                        pointRadius: false,
                        pointColor: '#3b8bba',
                        pointStrokeColor: 'rgba(60,141,188,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data: {!! $compareSx['l'] !!}
                    },
                    {
                        label: 'Perempuan',
                        backgroundColor: 'rgba(210, 214, 222, 1)',
                        borderColor: 'rgba(210, 214, 222, 1)',
                        pointRadius: false,
                        pointColor: 'rgba(210, 214, 222, 1)',
                        pointStrokeColor: '#c1c7d1',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(220,220,220,1)',
                        data: {!! $compareSx['p'] !!}
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
                responsive: true,
                maintainAspectRatio: false,
                datasetFill: false
            }

            new Chart(barChartCanvas, {
                type: 'bar',
                data: barChartData,
                options: barChartOptions
            })

            // daftar ulang
            var areaDuChartData = {
                labels: ['TKJ', 'AT', 'BDP', 'TSM', 'TKR'],
                datasets: [{
                        label: 'Laki-laki',
                        backgroundColor: 'rgba(60,141,188,0.9)',
                        borderColor: 'rgba(60,141,188,0.8)',
                        pointRadius: false,
                        pointColor: '#3b8bba',
                        pointStrokeColor: 'rgba(60,141,188,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data: {!! $compareDx['l'] !!}
                    },
                    {
                        label: 'Perempuan',
                        backgroundColor: 'rgba(210, 214, 222, 1)',
                        borderColor: 'rgba(210, 214, 222, 1)',
                        pointRadius: false,
                        pointColor: 'rgba(210, 214, 222, 1)',
                        pointStrokeColor: '#c1c7d1',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(220,220,220,1)',
                        data: {!! $compareDx['p'] !!}
                    }
                ]
            }


            //-------------
            //- BAR CHART -
            //-------------
            var barDuChartCanvas = $('#duBarChart').get(0).getContext('2d')
            var barDuChartData = $.extend(true, {}, areaDuChartData)
            var tempDu0 = areaDuChartData.datasets[0]
            var tempDu1 = areaDuChartData.datasets[1]
            barDuChartData.datasets[0] = tempDu1
            barDuChartData.datasets[1] = tempDu0

            var barDuChartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                datasetFill: false
            }

            new Chart(barDuChartCanvas, {
                type: 'bar',
                data: barDuChartData,
                options: barDuChartOptions
            })

            //-------------
            //- Perbandingan pendaftar pertahun BAR CHART -
            //-------------
            var areaYearChartData = {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [
                    @isset($yearDiff[$lastYear])
                        {
                            label: 'Tahun {{ $lastYear }}',
                            data: {!! $yearDiff[$lastYear]->pluck('jumlah_pendaftar') !!},
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        },
                    @endisset {
                        label: 'Tahun {{ $tahun }}',
                        data: {!! $yearDiff[$tahun]->pluck('jumlah_pendaftar') !!},
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }
                ]
            }

            var barYearCanvas = $('#yearDiff').get(0).getContext('2d')
            var barYearData = $.extend(true, {}, areaYearChartData)
            var year = areaYearChartData.datasets[1]
            barYearData.datasets[0] = year

            @isset($yearDiff[$lastYear])

                var lastYear = areaYearChartData.datasets[0]
                barYearData.datasets[1] = lastYear
            @endisset

            var baryYearOpt = {
                responsive: true,
                maintainAspectRatio: false,
                datasetFill: false
            }

            new Chart(barYearCanvas, {
                type: 'bar',
                data: barYearData,
                options: baryYearOpt
            })


            //-------------
            //- PIE CHART -
            //-------------
            // Get context with jQuery - using jQuery's .get() method.
            var donutData = {
                labels: ['TKJ', 'AT', 'BDP', 'TSM', 'TKR'],
                datasets: [{
                    data: {!! collect($count)->except(['all', 'to'])->values() !!},
                    backgroundColor: ['#f56954', '#00c0ef', '#00a65a', '#f39c12', '#3c8dbc'],
                }]
            }

            var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
            var pieData = donutData;
            var pieOptions = {
                maintainAspectRatio: false,
                responsive: true,
            }
            //Create pie or douhnut chart
            // You can switch between pie and douhnut using the method below.
            new Chart(pieChartCanvas, {
                type: 'pie',
                data: pieData,
                options: pieOptions
            })

            // du pie chart
            //-------------
            //- PIE CHART -
            //-------------
            // Get context with jQuery - using jQuery's .get() method.
            var donutDuData = {
                labels: ['TKJ', 'AT', 'BDP', 'TSM', 'TKR'],
                datasets: [{
                    data: {!! collect($du)->except(['all', 'to'])->values() !!},
                    backgroundColor: ['#f56954', '#00c0ef', '#00a65a', '#f39c12', '#3c8dbc'],
                }]
            }

            var pieDuChartCanvas = $('#pieDuChart').get(0).getContext('2d')
            var pieDuData = donutDuData;
            var pieDuOptions = {
                maintainAspectRatio: false,
                responsive: true,
            }
            //Create pie or douhnut chart
            // You can switch between pie and douhnut using the method below.
            new Chart(pieDuChartCanvas, {
                type: 'pie',
                data: pieDuData,
                options: pieDuOptions
            })

        });
    </script>
@endsection
