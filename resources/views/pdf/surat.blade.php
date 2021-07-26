@extends('layouts.admin')

@section('title', 'Surat Diterima Peserta PPDB')

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
                        <li class="breadcrumb-item active">Surat Diterima Peserta PPDB</li>
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
										@for($i = now()->year; $i >= 2021 ; $i--)
                                        <option value="{{ $i }}">{{ $i }}</option>
										@endfor
                                    </select>
                                </div>
                            </div>
                </div>

				<div class="col-md-12">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title"> Atur batas daftar ulang </h3>
						</div>
						<form action="{{ route('ppdb.set.batas.akhir') }}" method="post">
						<div class="card-body">

							<div class="form-group">
								<strong>  Batas Akhir Sekarang: </strong> <br>
								<span> {{ (new App\Models\PpdbSetting)->body['batas_akhir_ppdb'] ?? now()->format('d-m-Y') }} </span>
							</div>

							<div class="form-group">
								<label class="form-label">Batas Akhir Daftar Ulang</label>

								<input type="date" name="batas_akhir_ppdb" class="form-control" placeholder="Batas Akhir daftar ulang" required>
							</div>

						</div>

						<div class="card-footer">
							@csrf
							@method('PUT')
							<button class="btn btn-primary" type="submit">Atur</button>
						</div>
						</form>

					</div>
				</div>

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Surat Diterima Peserta PPDB </h3>

                            <div class="card-tools">

                                <form action="{{ route('ppdb.cetak.surat.semua', ['jurusan' => $jurusan]) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-primary">
                                        <i class="fas fa-print"></i> Cetak Semua
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="card-body px-0">
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
                                            <th>Action</th>
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
                                            <td> {{ $peserta->jurusan->nama }} </td>
                                            <td>

                                                <form action="{{ route('ppdb.cetak.surat', $peserta->id) }}" method="POST">
                                                    @csrf

                                                    <button class="btn btn-primary"> <i class="fas fa-print mr-2"></i> Cetak</button>
                                                </form>
                                            </td>
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