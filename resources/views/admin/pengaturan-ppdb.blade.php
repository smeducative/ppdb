@extends('layouts.admin')

@inject('carbon', 'Carbon\Carbon')

@section('title', 'Pengaturan PPDB')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Pengaturan PPDB</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Pengaturan PPDB

                        </li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>



    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-6">

                    @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fas fa-check"></i> Success!</h5>
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                Pengaturan PPDB
                            </h3>
                        </div>
<form action="{{ route('ppdb.set.batas.akhir') }}" method="post">
						<div class="card-body">

							<div class="form-group">
								<strong>  No. Surat: </strong> <br>
								<span> {{ optional((new App\Models\PpdbSetting)->latest()->first()->body)['no_surat'] }} </span>
							</div>

							<div class="form-group">
								<strong>  Batas Akhir PPDB: </strong> <br>
								<span> {{ $carbon->parse(optional((new App\Models\PpdbSetting)->latest()->first()->body)['batas_akhir_ppdb'])->translatedFormat('l, d F Y') }} </span>
							</div>

                            <div class="form-group">
                                <label class="form-label">Pengumuman Hasil Seleksi</label> <br>
                                <span> {{ $carbon->parse(optional((new App\Models\PpdbSetting)->latest()->first()->body)['hasil_seleksi'])->translatedFormat('l, d F Y') }} </span>
                            </div>

							<div class="form-group">
                                <label class="form-label">Batas Akhir Daftar Ulang</label>

                                <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="batas_akhir_ppdb"
                                data-mask required>
							</div>

							<div class="form-group">
								<label class="form-label">Ubah No. Surat</label>

								<input type="text" name="no_surat" class="form-control" placeholder="No Surat" required>
							</div>

							<div class="form-group">
								<label class="form-label">Pengumuman Hasil Seleksi</label>

                                <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="hasil_seleksi" data-mask required>
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
            </div>

        </div>
    </section>
    {{-- container  --}}

</div>
@endsection


@section('footer')
 <script src="/plugins/inputmask/jquery.inputmask.min.js"></script>
    <script>
        $(document).ready(function() {
            $('[data-mask]').inputmask()
        })
    </script>
@endsection
