@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="mb-2 row">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Dashboard</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="float-sm-right breadcrumb">
                            <li class="breadcrumb-item"><a href="/master/home">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div><!-- /.col -->

                    <div class="mt-3 col-md-3">
                        <div class="">
                            <div class="form-group">
                                <label class="form-label">Data Tahun:</label>
                                <select class="form-control-border custom-select" id="ppdb-tahun">
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
                        <div class="bg-warning small-box">
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
                        <div class="bg-warning small-box">
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
                        <div class="bg-warning small-box">
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
                        <div class="bg-warning small-box">
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
                        <div class="bg-success small-box">
                            <div class="inner">
                                <h3>{{ $count['atph'] }}</h3>

                                <p>AT</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-leaf"></i>
                            </div>
                            <a href="{{ route('ppdb.list.pendaftar.jurusan', ['jurusan' => 3]) }}"
                                class="small-box-footer">More info <i class="fa-arrow-circle-right fas"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-2 col-6">
                        <!-- small box -->
                        <div class="bg-info small-box">
                            <div class="inner">
                                <h3>{{ $count['tsm'] }}</h3>

                                <p>TSM</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-settings"></i>
                            </div>
                            <a href="{{ route('ppdb.list.pendaftar.jurusan', ['jurusan' => 2]) }}"
                                class="small-box-footer">More info <i class="fa-arrow-circle-right fas"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-2 col-6">
                        <!-- small box -->
                        <div class="bg-info small-box">
                            <div class="inner">
                                <h3>{{ $count['tkr'] }}</h3>

                                <p>TKR</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-settings"></i>
                            </div>
                            <a href="{{ route('ppdb.list.pendaftar.jurusan', ['jurusan' => 2]) }}"
                                class="small-box-footer">More info <i class="fa-arrow-circle-right fas"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-2 col-6">
                        <!-- small box -->
                        <div class="bg-danger small-box">
                            <div class="inner">
                                <h3>{{ $count['tkj'] }}</h3>

                                <p>TKJ</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-wifi"></i>
                            </div>
                            <a href="{{ route('ppdb.list.pendaftar.jurusan', ['jurusan' => 1]) }}"
                                class="small-box-footer">More info <i class="fa-arrow-circle-right fas"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="bg-orange small-box">
                            <div class="inner">
                                <h3>{{ $count['bdp'] }}</h3>

                                <p>BDP</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-film-marker"></i>
                            </div>
                            <a href="{{ route('ppdb.list.pendaftar.jurusan', ['jurusan' => 4]) }}"
                                class="small-box-footer">More info <i class="fa-arrow-circle-right fas"></i></a>
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
                        <div class="bg-success small-box">
                            <div class="inner">
                                <h3>{{ $du['atph'] }}</h3>

                                <p>AT</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-leaf"></i>
                            </div>
                            <a href="{{ route('ppdb.daftar.ulang.list', ['jurusan' => 3]) }}" class="small-box-footer">More
                                info <i class="fa-arrow-circle-right fas"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-2 col-6">
                        <!-- small box -->
                        <div class="bg-info small-box">
                            <div class="inner">
                                <h3>{{ $du['tsm'] }}</h3>

                                <p>TSM</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-settings"></i>
                            </div>
                            <a href="{{ route('ppdb.daftar.ulang.list', ['jurusan' => 2]) }}" class="small-box-footer">More
                                info <i class="fa-arrow-circle-right fas"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-2 col-6">
                        <!-- small box -->
                        <div class="bg-info small-box">
                            <div class="inner">
                                <h3>{{ $du['tkr'] }}</h3>

                                <p>TKR</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-settings"></i>
                            </div>
                            <a href="{{ route('ppdb.daftar.ulang.list', ['jurusan' => 2]) }}" class="small-box-footer">More
                                info <i class="fa-arrow-circle-right fas"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-2 col-6">
                        <!-- small box -->
                        <div class="bg-danger small-box">
                            <div class="inner">
                                <h3>{{ $du['tkj'] }}</h3>

                                <p>TKJ</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-wifi"></i>
                            </div>
                            <a href="{{ route('ppdb.daftar.ulang.list', ['jurusan' => 1]) }}"
                                class="small-box-footer">More info <i class="fa-arrow-circle-right fas"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="bg-orange small-box">
                            <div class="inner">
                                <h3>{{ $du['bdp'] }}</h3>

                                <p>BDP</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-film-marker"></i>
                            </div>
                            <a href="{{ route('ppdb.daftar.ulang.list', ['jurusan' => 4]) }}"
                                class="small-box-footer">More info <i class="fa-arrow-circle-right fas"></i></a>
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
                        <!-- BAR CHART -->
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Perbandingan daftar ulang perbulan dengan tahun sebelumnya</h3>
                            </div>
                            <div class="card-body">
                                <canvas id="yearDiffDaftarUlang"
                                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>

                    <div class="col-md-12">
                        <!-- BAR CHART -->
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title">Top 10 Sekolah Pendaftar</h3>
                            </div>
                            <div class="card-body">
                                <canvas id="schoolChart"
                                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>

                    <div class="col-md-12">
                        <!-- STACKED BAR CHART -->
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">Distribusi Jenis Kelamin Pendaftar per Bulan</h3>
                            </div>
                            <div class="card-body">
                                <canvas id="genderOverTimeChart"
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
                            <div class="table-responsive p-0 py-2 text-nowrap card-body">
                                @if (!$pendaftarPerSekolahCount->isEmpty())

                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped" id="list-sekolah">
                                            <thead>
                                                <tr>

                                                    <th>Nama Sekolah</th>
                                                    <th>Jumlah</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($pendaftarPerSekolahCount as $sekolah)
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
            var barChartElem = $('#barChart').get(0);
            if (barChartElem) {
                var barChartCanvas = barChartElem.getContext('2d');
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
                });
            }

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
            var barDuChartElem = $('#duBarChart').get(0);
            if (barDuChartElem) {
                var barDuChartCanvas = barDuChartElem.getContext('2d');
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
                });
            }

            //-------------
            //- Perbandingan pendaftar pertahun BAR CHART -
            //-------------
            var barYearElem = $('#yearDiff').get(0);
            if (barYearElem) {
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

                var barYearCanvas = barYearElem.getContext('2d')
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
                });
            }

            //-------------
            //- Perbandingan daftar ulang pertahun BAR CHART -
            //-------------
            var barYearDaftarUlangElem = $('#yearDiffDaftarUlang').get(0);
            if (barYearDaftarUlangElem) {
                var areaYearDaftarUlangChartData = {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                    datasets: [
                        @isset($yearDiffDaftarUlang[$lastYear])
                            {
                                label: 'Tahun {{ $lastYear }}',
                                data: {!! $yearDiffDaftarUlang[$lastYear]->pluck('jumlah_daftar_ulang') !!},
                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1
                            },
                        @endisset {
                            label: 'Tahun {{ $tahun }}',
                            data: {!! $yearDiffDaftarUlang[$tahun]->pluck('jumlah_daftar_ulang') !!},
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }
                    ]
                }

                var barYearDaftarUlangCanvas = barYearDaftarUlangElem.getContext('2d')
                var barYearDaftarUlangData = $.extend(true, {}, areaYearDaftarUlangChartData)
                // Ensure datasets are correctly ordered without assuming index existence
                barYearDaftarUlangData.datasets = [];
                @isset($yearDiffDaftarUlang[$tahun])
                    barYearDaftarUlangData.datasets.push({
                        label: 'Tahun {{ $tahun }}',
                        data: {!! $yearDiffDaftarUlang[$tahun]->pluck('jumlah_daftar_ulang') !!},
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    });
                @endisset
                @isset($yearDiffDaftarUlang[$lastYear])
                    barYearDaftarUlangData.datasets.push({
                        label: 'Tahun {{ $lastYear }}',
                        data: {!! $yearDiffDaftarUlang[$lastYear]->pluck('jumlah_daftar_ulang') !!},
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    });
                @endisset

                var barYearDaftarUlangOpt = {
                    responsive: true,
                    maintainAspectRatio: false,
                    datasetFill: false
                }

                new Chart(barYearDaftarUlangCanvas, {
                    type: 'bar',
                    data: barYearDaftarUlangData,
                    options: barYearDaftarUlangOpt
                });
            }

            //-------------
            //- PIE CHART -
            //-------------
            var pieChartElem = $('#pieChart').get(0);
            if (pieChartElem) {
                var donutData = {
                    labels: ['TKJ', 'AT', 'BDP', 'TSM', 'TKR'],
                    datasets: [{
                        data: {!! collect($count)->except(['all', 'to'])->values() !!},
                        backgroundColor: ['#f56954', '#00c0ef', '#00a65a', '#f39c12', '#3c8dbc'],
                    }]
                }

                var pieChartCanvas = pieChartElem.getContext('2d');
                var pieData = donutData;
                var pieOptions = {
                    maintainAspectRatio: false,
                    responsive: true,
                }
                new Chart(pieChartCanvas, {
                    type: 'pie',
                    data: pieData,
                    options: pieOptions
                });
            }

            // du pie chart
            var pieDuChartElem = $('#pieDuChart').get(0);
            if (pieDuChartElem) {
                var donutDuData = {
                    labels: ['TKJ', 'AT', 'BDP', 'TSM', 'TKR'],
                    datasets: [{
                        data: {!! collect($du)->except(['all', 'to'])->values() !!},
                        backgroundColor: ['#f56954', '#00c0ef', '#00a65a', '#f39c12', '#3c8dbc'],
                    }]
                }

                var pieDuChartCanvas = pieDuChartElem.getContext('2d');
                var pieDuData = donutDuData;
                var pieDuOptions = {
                    maintainAspectRatio: false,
                    responsive: true,
                }
                new Chart(pieDuChartCanvas, {
                    type: 'pie',
                    data: pieDuData,
                    options: pieDuOptions
                });
            }

            //-------------
            //- LINE CHART for Daily Trends -
            //-------------
            var dailyTrendsElem = $('#dailyTrends').get(0);
            if (dailyTrendsElem) {
                var dailyTrendsData = {
                    labels: {!! $dailyTrends->pluck('tanggal') !!},
                    datasets: [{
                        label: 'Pendaftaran Harian',
                        data: {!! $dailyTrends->pluck('jumlah') !!},
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 2,
                        fill: true
                    }]
                }

                var dailyTrendsCanvas = dailyTrendsElem.getContext('2d');
                var dailyTrendsOptions = {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }

                new Chart(dailyTrendsCanvas, {
                    type: 'line',
                    data: dailyTrendsData,
                    options: dailyTrendsOptions
                });
            }

            //-------------
            //- BAR CHART for Top Schools -
            //-------------
            var schoolElem = $('#schoolChart').get(0);
            if (schoolElem) {
                var schoolData = {
                    labels: {!! $pendaftarPerSekolah->pluck('asal_sekolah') !!},
                    datasets: [{
                        label: 'Jumlah Pendaftar',
                        data: {!! $pendaftarPerSekolah->pluck('as_count') !!},
                        backgroundColor: 'rgba(255, 159, 64, 0.9)',
                        borderColor: 'rgba(255, 159, 64, 1)',
                        borderWidth: 1
                    }]
                }

                var schoolCanvas = schoolElem.getContext('2d');
                var schoolOptions = {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }

                new Chart(schoolCanvas, {
                    type: 'bar',
                    data: schoolData,
                    options: schoolOptions
                });
            }

            //-------------
            //- STACKED BAR CHART for Gender Distribution Over Time -
            //-------------
            var genderOverTimeElem = $('#genderOverTimeChart').get(0);
            if (genderOverTimeElem) {
                var genderOverTimeData = {
                    labels: {!! $genderOverTime->pluck('bulan') !!},
                    datasets: [{
                        label: 'Laki-laki',
                        data: {!! $genderOverTime->pluck('laki') !!},
                        backgroundColor: 'rgba(54, 162, 235, 0.9)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }, {
                        label: 'Perempuan',
                        data: {!! $genderOverTime->pluck('perempuan') !!},
                        backgroundColor: 'rgba(255, 99, 132, 0.9)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }]
                }

                var genderOverTimeCanvas = genderOverTimeElem.getContext('2d');
                var genderOverTimeOptions = {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            stacked: true
                        },
                        x: {
                            stacked: true
                        }
                    }
                }

                new Chart(genderOverTimeCanvas, {
                    type: 'bar',
                    data: genderOverTimeData,
                    options: genderOverTimeOptions
                });
            }

        });
    </script>
@endsection
