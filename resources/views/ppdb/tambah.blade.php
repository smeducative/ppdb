@extends('layouts.admin')

@inject('jurusan', 'App\Models\Jurusan')

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
                <div class="col-md-12">

                    <div class="card">

                        <div class="card-header">
                            <h3 class="card-title">Data diri pendaftar</h3>
                        </div>

                        <form action="{{ route('ppdb.tambah.pendaftar') }}" method="post">
                            @csrf

                            {{-- card body --}}

                            <div class="card-body">



                                {{-- bs-stepper --}}
                                <div class="bs-stepper" id="stepper">

                                    {{-- bs step header --}}
                                    <div class="bs-stepper-header" role="tablist">
                                        <!-- steps here -->
                                        <div class="step" data-target="#identitas-diri">
                                            <button type="button" class="step-trigger" role="tab" aria-controls="identitas-diri" id="identitas-diri-part-trigger">
                                                <span class="bs-stepper-circle">1</span>
                                                <span class="bs-stepper-label">Identitas Diri</span>
                                            </button>
                                        </div>

                                        <div class="line"></div>

                                        <div class="step" data-target="#identitas-orang-tua">
                                            <button type="button" class="step-trigger" role="tab" aria-controls="identitas-orang-tua"
                                                id="identitas-orang-tua-part-trigger">
                                                <span class="bs-stepper-circle">2</span>
                                                <span class="bs-stepper-label">Identias Orang Tua</span>
                                            </button>
                                        </div>

                                        <div class="line"></div>
                                        <div class="step" data-target="#jenis-beasiswa">
                                            <button type="button" class="step-trigger" role="tab" aria-controls="jenis-beasiswa"
                                                id="jenis-beasiswa-part-trigger">
                                                <span class="bs-stepper-circle">3</span>
                                                <span class="bs-stepper-label">Jenis Beasiswa</span>
                                            </button>
                                        </div>
                                    </div>
                                    {{-- bs step header --}}



                                    {{-- bs step body --}}
                                    <div class="bs-stepper-content">
                                        <!-- your steps content here -->

                                        {{-- identitas diri --}}
                                        <div id="identitas-diri" class="content" role="tabpanel" aria-labelledby="identitas-diri-part-trigger">
                                            {{-- identias diri --}}

                                            {{-- nama lengkap --}}
                                            <div class="form-group">
                                                <label>Nama Lengkap</label>
                                                <input type="text" class="form-control" name="nama_lengkap" id="name" value="{{ old('nama_lengkap') }}"
                                                    placeholder="Nama Lengkap" required>
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

                                            {{-- Tempat Lahir --}}
                                            <div class="form-group">
                                                <label>Tempat Lahir</label>
                                                <input type="text" class="form-control" name="tempat_lahir" value="{{ old('tempat_lahir') }}"
                                                    placeholder="Tempat Lahir" required>
                                            </div>


                                            {{-- NIK --}}
                                            <div class="form-group">
                                                <label>NIK</label>
                                                <input type="text" class="form-control" name="nik" value="{{ old('nik') }}" placeholder="NIK" required>
                                            </div>

                                            {{-- Alamat lengkap --}}
                                            <div class="form-group">
                                                <label>Alamat Lengkap</label>
                                                <textarea type="text" class="form-control" name="alamat_lengkap" value="{{ old('alamat_lengkap') }}"
                                                    placeholder="Alamat Lengkap" required></textarea>
                                            </div>

                                            {{-- Pilihan jurusan --}}
                                            <div class="form-group">
                                                <label>Pilihan Jurusan</label>
                                                <select class="form-control select2" id="pjurusan" style="width: 100%;" name="pilihan_jurusan" required>
                                                    @foreach ($jurusan->get() as $jrs)

                                                    <option value="{{ $jrs->id }}">{{ $jrs->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            {{-- Asal Sekolah --}}
                                            <div class="form-group">
                                                <label>Asal Sekolah</label>
                                                <input type="text" class="form-control" name="asal_sekolah" value="{{ old('asal_sekolah') }}"
                                                    placeholder="Asal Sekolah" required>
                                            </div>

                                            {{-- Tahun Lulus --}}
                                            <div class="form-group">
                                                <label>Tahun Lulus</label>
                                                <select class="form-control select2" id="tlulus" name="tahun_lulus" style="width: 100%;" required>
                                                    @for ($i = now()->year; $i > 2015; $i--)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>

                                            {{-- NISN --}}
                                            <div class="form-group">
                                                <label>NISN</label>
                                                <input type="text" class="form-control" name="nisn" value="{{ old('nisn') }}" placeholder="NISN">
                                            </div>

                                            {{-- Penerima KIP --}}
                                            <div class="form-group">
                                                <label>Penerima KIP</label>
                                                <div class="custom-control custom-checkbox mb-2">
                                                    <input type="checkbox" name="penerima_kip" class="custom-control-input" id="pkip">
                                                    <label class="custom-control-label" for="pkip">Peserta penerima KIP</label>
                                                </div>

                                                <input type="text" class="form-control" name="no_kip" value="{{ old('no_kip') }}" placeholder="No. NISN" disabled>
                                            </div>

                                            {{-- No. HP --}}
                                            <div class="form-group">
                                                <label>No. HP</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">+62</span>
                                                    </div>
                                                    <input type="number" class="form-control" placeholder="No. HP">
                                                </div>
                                            </div>


                                            <button class="btn btn-primary" onclick="event.preventDefault();stepper.next()">Lanjut</button>
                                        </div>

                                        {{-- identitas orang tua --}}
                                        <div id="identitas-orang-tua" class="content" role="tabpanel" aria-labelledby="identitas-orang-tua-part-trigger">
                                            {{-- identias orang tua --}}
                                            tes

                                            <button class="btn btn-primary" onclick="event.preventDefault();stepper.previous()">Kembali</button>
                                            <button class="btn btn-primary" onclick="event.preventDefault();stepper.next()">Lanjut</button>
                                        </div>

                                        {{-- Jenis beasiswa --}}
                                        <div id="jenis-beasiswa" class="content" role="tabpanel" aria-labelledby="jenis-beasiswa-part-trigger">
                                            {{-- jenis beasiswa --}}
                                            cek

                                            <button class="btn btn-primary" onclick="event.preventDefault();stepper.previous()">Kembali</button>
                                            <button class="btn btn-primary" type="submit">Submit</button>
                                        </div>
                                    </div>
                                    {{-- bs step body --}}


                                </div> {{-- bs-stepper --}}



                            </div> {{-- card body --}}






                            {{-- card footer
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div> --}}
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </section>



</div>
@endsection


@section('head')
<link rel="stylesheet" href="/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<link rel="stylesheet" href="/plugins/bs-stepper/css/bs-stepper.min.css">
@endsection

@section('footer')

    <script src="/plugins/select2/js/select2.full.min.js"></script>

    <script src="/plugins/bs-stepper/js/bs-stepper.min.js"></script>

    <script>
        $(function() {
            $('#pjurusan').select2({
                theme: 'bootstrap4'
            })

            $('#tlulus').select2({
                theme: 'bootstrap4'
            })


        })

        // BS-Stepper Init
        document.addEventListener('DOMContentLoaded', function () {

            let step = document.getElementById('stepper')
            window.stepper = new Stepper(step)
        })
    </script>
@endsection
