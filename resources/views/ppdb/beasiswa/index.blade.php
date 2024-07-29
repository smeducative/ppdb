@extends('layouts.admin')

@section('title', $title)

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
                        <li class="breadcrumb-item active">{{ $title }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="row">

                <div class="col-md-3 mt-3">
                    <div class="">
                        <div class="form-group">
                            <label class="form-label">Data Tahun:</label>
                            <select class="custom-select form-control-border" id="ppdb-tahun">
                                @for($i = now()->year; $i >= $years_visible ; $i--)
                                <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">

					<div class="callout callout-info">
                  		<h5>Info!</h5>

                  		<p>Daftar Peserta yang menerima <strong>{{ $title }}</strong> .</p>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3>Peserta {{ $title }}</h3>
                            <div class="card-tools">
                                <form action="" method="post">
                                    @csrf
                                    <button class="btn btn-primary">export</button>
                                </form>
                            </div>
                        </div>
                        <div class="card-body p-0 py-2 table-responsive text-nowrap">
                            @if (!$pesertappdb->isEmpty())

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="list-ppdb">
                                    <thead>
                                        <tr>

                                            <th>No. Pendaftaran</th>
                                            <th>Nama</th>
                                            <th>Tempat, Tanggal Lahir</th>
                                            <th>No. Telepon</th>
                                            <th>Asal Sekolah</th>
                                            <th>Pilihan Jurusan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pesertappdb as $peserta)
                                        <tr>
                                            <td> {{ $peserta->no_pendaftaran }} </td>
                                            <td> <a href="{{ route('ppdb.show.peserta', $peserta->id) }}">
                                                    {{ $peserta->nama_lengkap }}</a> </td>
                                            <td> {{ $peserta->tempat_lahir }},
                                                {{ $peserta->tanggal_lahir->format('d-m-Y') }} </td>
                                            <td> {{ $peserta->no_hp }} </td>
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
    $(function () {

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
