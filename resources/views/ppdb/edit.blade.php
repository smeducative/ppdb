@extends('layouts.admin')

@inject('jurusan', 'App\Models\Jurusan')

@section('title', 'Edit Peserta PPDB')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="text-dark m-0">Dashboard</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/master/home">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                            <li class="breadcrumb-item active">Edit Peserta</li>
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

                        @if (session()->has('success'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h5><i class="icon fas fa-check"></i> Success!</h5>
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="card">

                            <div class="card-header">
                                <h3 class="card-title">Data diri pendaftar</h3>

                                <div class="card-tools">
                                    <form action="{{ route('ppdb.delete.peserta', $peserta->id) }}" method="post"
                                        id="delete-peserta">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i>
                                            Hapus</button>
                                    </form>
                                </div>
                            </div>

                            <form action="{{ route('ppdb.edit.peserta', $peserta->id) }}" method="post">
                                @csrf
                                @method('put')

                                {{-- card body --}}

                                <div class="card-body">



                                    {{-- bs-stepper --}}
                                    <div class="bs-stepper" id="stepper">

                                        {{-- bs step header --}}
                                        <div class="bs-stepper-header" role="tablist">
                                            <!-- steps here -->
                                            <div class="step" data-target="#identitas-diri">
                                                <button type="button" class="step-trigger" role="tab"
                                                    aria-controls="identitas-diri" id="identitas-diri-part-trigger">
                                                    <span class="bs-stepper-circle">1</span>
                                                    <span class="bs-stepper-label">Identitas Diri</span>
                                                </button>
                                            </div>

                                            <div class="line"></div>

                                            <div class="step" data-target="#identitas-orang-tua">
                                                <button type="button" class="step-trigger" role="tab"
                                                    aria-controls="identitas-orang-tua"
                                                    id="identitas-orang-tua-part-trigger">
                                                    <span class="bs-stepper-circle">2</span>
                                                    <span class="bs-stepper-label">Identias Orang Tua</span>
                                                </button>
                                            </div>

                                            <div class="line"></div>
                                            <div class="step" data-target="#jenis-beasiswa">
                                                <button type="button" class="step-trigger" role="tab"
                                                    aria-controls="jenis-beasiswa" id="jenis-beasiswa-part-trigger">
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
                                            <div id="identitas-diri" class="content" role="tabpanel"
                                                aria-labelledby="identitas-diri-part-trigger">
                                                {{-- identias diri --}}

                                                {{-- nama lengkap --}}
                                                <div class="form-group">
                                                    <label>Nama Lengkap <strong class="text-danger"> * </strong> </label>
                                                    <input type="text" class="form-control" name="nama_lengkap"
                                                        id="name" value="{{ $peserta->nama_lengkap }}"
                                                        placeholder="Nama Lengkap" autofocus required>
                                                    <div class="form-text text-muted text-xs">Nama lengkap peserta</div>
                                                </div>

                                                {{-- jenis kelamin --}}
                                                <div class="form-group">
                                                    <label>Jenis Kelamin <strong class="text-danger"> * </strong></label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="jenis_kelamin"
                                                            value="l"
                                                            {{ $peserta->jenis_kelamin == 'l' ? 'checked=""' : '' }}>
                                                        <label class="form-check-label">Laki-laki</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="jenis_kelamin"
                                                            value="p"
                                                            {{ $peserta->jenis_kelamin == 'p' ? 'checked=""' : '' }}>
                                                        <label class="form-check-label">Perempuan</label>
                                                    </div>
                                                </div>

                                                {{-- Tempat Lahir --}}
                                                <div class="form-group">
                                                    <label>Tempat Lahir <strong class="text-danger"> * </strong></label>
                                                    <input type="text" class="form-control" name="tempat_lahir"
                                                        value="{{ $peserta->tempat_lahir }}" placeholder="Tempat Lahir"
                                                        required>
                                                    <div class="form-text text-muted text-xs">Tempat lahir peserta </div>
                                                </div>
                                                {{-- Tanggal Lahir --}}
                                                <div class="form-group">
                                                    <label>Tanggal Lahir <strong class="text-danger"> * </strong></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i
                                                                    class="far fa-calendar-alt"></i></span>
                                                        </div>
                                                        <input type="text" class="form-control"
                                                            data-inputmask-alias="datetime"
                                                            data-inputmask-inputformat="dd-mm-yyyy"
                                                            placeholder="dd-mm-yyyy" name="tanggal_lahir"
                                                            value="{{ $peserta->tanggal_lahir->format('d-m-Y') }}"
                                                            data-mask required>
                                                    </div>
                                                    <div class="form-text text-muted text-xs">Tanggal lahir peserta.
                                                        contoh: 17-08-2007</div>
                                                </div>


                                                {{-- NIK --}}
                                                <div class="form-group">
                                                    <label>NIK <strong class="text-danger"> * </strong></label>
                                                    <input type="text" class="form-control" name="nik"
                                                        value="{{ $peserta->nik }}" placeholder="NIK" required>
                                                    <div class="form-text text-muted text-xs">NIK peserta</div>
                                                </div>

                                                {{-- Alamat lengkap --}}
                                                <div class="form-group">
                                                    <label>Alamat Lengkap <strong class="text-danger"> * </strong></label>
                                                    <textarea type="text" class="form-control" name="alamat_lengkap" placeholder="Alamat Lengkap" required>{{ $peserta->alamat_lengkap }}</textarea>
                                                </div>

                                                {{-- Dukuh --}}
                                                <div class="form-group">
                                                    <label>Dukuh</label>
                                                    <input type="text" class="form-control" name="dukuh"
                                                        value="{{ $peserta->dukuh }}" placeholder="Dukuh">
                                                </div>

                                                {{-- RT --}}
                                                <div class="form-group">
                                                    <label>RT</label>
                                                    <input type="text" class="form-control" name="rt"
                                                        value="{{ $peserta->rt }}" placeholder="RT">
                                                </div>

                                                {{-- RW --}}
                                                <div class="form-group">
                                                    <label>RW</label>
                                                    <input type="text" class="form-control" name="rw"
                                                        value="{{ $peserta->rw }}" placeholder="RW">
                                                </div>

                                                {{-- Desa/Kelurahan --}}
                                                <div class="form-group">
                                                    <label>Desa/Kelurahan</label>
                                                    <input type="text" class="form-control" name="desa_kelurahan"
                                                        value="{{ $peserta->desa_kelurahan }}"
                                                        placeholder="Desa/Kelurahan">
                                                </div>

                                                {{-- Kecamatan --}}
                                                <div class="form-group">
                                                    <label>Kecamatan</label>
                                                    <input type="text" class="form-control" name="kecamatan"
                                                        value="{{ $peserta->kecamatan }}" placeholder="Kecamatan">
                                                </div>

                                                {{-- Kabupaten/Kota --}}
                                                <div class="form-group">
                                                    <label>Kabupaten/Kota</label>
                                                    <input type="text" class="form-control" name="kabupaten_kota"
                                                        value="{{ $peserta->kabupaten_kota }}"
                                                        placeholder="Kabupaten/Kota">
                                                </div>

                                                {{-- Provinsi --}}
                                                <div class="form-group">
                                                    <label>Provinsi</label>
                                                    <input type="text" class="form-control" name="provinsi"
                                                        value="{{ $peserta->provinsi }}" placeholder="Provinsi">
                                                </div>

                                                {{-- kode pos --}}
                                                <div class="form-group">
                                                    <label>Kodepos</label>
                                                    <input type="text" class="form-control" name="kode_pos"
                                                        value="{{ $peserta->kode_pos }}" placeholder="kode_pos">
                                                </div>

                                                {{-- Pilihan jurusan --}}
                                                <div class="form-group">
                                                    <label>Pilihan Jurusan <strong class="text-danger"> * </strong></label>
                                                    <select class="form-control select2" id="pjurusan"
                                                        style="width: 100%;" name="pilihan_jurusan" required>
                                                        @foreach ($jurusan->get() as $jrs)
                                                            <option value="{{ $jrs->id }}"
                                                                {{ $peserta->jurusan_id == $jrs->id ? 'selected' : '' }}>
                                                                {{ $jrs->nama }}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="form-text text-muted text-xs">Jurusan pilihan</div>
                                                </div>

                                                {{-- Asal Sekolah --}}
                                                <div class="form-group">
                                                    <label>Asal Sekolah <strong class="text-danger"> * </strong></label>
                                                    <input type="text" class="form-control" name="asal_sekolah"
                                                        value="{{ $peserta->asal_sekolah }}" placeholder="Asal Sekolah"
                                                        required>
                                                </div>

                                                {{-- Tahun Lulus --}}
                                                <div class="form-group">
                                                    <label>Tahun Lulus <strong class="text-danger"> * </strong></label>
                                                    <select class="form-control select2" id="tlulus"
                                                        name="tahun_lulus" style="width: 100%;" required>
                                                        @for ($i = now()->year; $i > 2015; $i--)
                                                            <option value="{{ $i }}"
                                                                {{ $peserta->tahun_lulus == $i ? 'selected' : '' }}>
                                                                {{ $i }}</option>
                                                        @endfor
                                                    </select>
                                                </div>

                                                {{-- NISN --}}
                                                <div class="form-group">
                                                    <label>NISN</label>
                                                    <input type="text" class="form-control" name="nisn"
                                                        value="{{ $peserta->nisn }}" placeholder="NISN">
                                                </div>

                                                {{-- Penerima KIP --}}
                                                <div class="form-group">
                                                    <label>Penerima KIP</label>
                                                    <div class="custom-control custom-checkbox mb-2" onclick="fkip()">
                                                        <input type="checkbox" name="penerima_kip"
                                                            class="custom-control-input" id="pkip"
                                                            {{ $peserta->penerima_kip == 'y' ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="pkip">Peserta
                                                            penerima KIP</label>
                                                    </div>

                                                    <input id="input-kip" type="text" class="form-control"
                                                        name="no_kip" value="{{ $peserta->no_kip }}"
                                                        placeholder="No. KIP" disabled>
                                                </div>

                                                {{-- No. HP --}}
                                                <div class="form-group">
                                                    <label>No. HP <strong class="text-danger"> * </strong></label>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">+62</span>
                                                        </div>
                                                        <input type="number" class="form-control" name="no_hp"
                                                            placeholder="No. HP" value="{{ $peserta->no_hp }}" required>

                                                    </div>
                                                    <div class="form-text text-muted text-xs">No. HP peserta yang bisa di
                                                        hubungi</div>
                                                </div>


                                                <button class="btn btn-primary"
                                                    onclick="event.preventDefault();stepper.next()">Lanjut</button>
                                            </div>

                                            {{-- identitas orang tua --}}
                                            <div id="identitas-orang-tua" class="content" role="tabpanel"
                                                aria-labelledby="identitas-orang-tua-part-trigger">
                                                {{-- identias orang tua --}}

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        {{-- nama ayah --}}
                                                        <div class="form-group">
                                                            <label>Nama Ayah <strong class="text-danger"> *
                                                                </strong></label>
                                                            <input type="text" name="nama_ayah" class="form-control"
                                                                placeholder="Nama Ayah" value="{{ $peserta->nama_ayah }}"
                                                                required />
                                                            <div class="form-text text-muted text-xs">Nama lengkap ayah
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>No. HP Ayah</label>
                                                            <input type="text" name="no_ayah" class="form-control"
                                                                placeholder="No. HP Ayah"
                                                                value="{{ $peserta->no_hp_ayah }}" />
                                                            <div class="form-text text-muted text-xs">No. HP Ayah</div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Pekerjaan Ayah</label>
                                                            <input type="text" name="pekerjaan_ayah"
                                                                class="form-control" placeholder="Pekerjaan ayah"
                                                                value="{{ $peserta->pekerjaan_ayah }}" />
                                                            <div class="form-text text-muted text-xs">Pekerjaan Ayah</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        {{-- nama ibu --}}
                                                        <div class="form-group">
                                                            <label>Nama Ibu <strong class="text-danger"> *
                                                                </strong></label>
                                                            <input type="text" name="nama_ibu" class="form-control"
                                                                placeholder="Nama Ibu" value="{{ $peserta->nama_ibu }}"
                                                                required />
                                                            <div class="form-text text-muted text-xs">Nama lengkap Ibu
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>No. HP Ibu</label>
                                                            <input type="text" name="no_ibu" class="form-control"
                                                                placeholder="No. HP Ayah"
                                                                value="{{ $peserta->no_hp_ibu }}" />
                                                            <div class="form-text text-muted text-xs">No. HP Ibu</div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Pekerjaan Ibu</label>
                                                            <input type="text" name="pekerjaan_ibu"
                                                                class="form-control" placeholder="Pekerjaan Ibu"
                                                                value="{{ $peserta->pekerjaan_ibu }}" />
                                                            <div class="form-text text-muted text-xs">Pekerjaan Ibu</div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <button class="btn btn-primary"
                                                    onclick="event.preventDefault();stepper.previous()">Kembali</button>
                                                <button class="btn btn-primary"
                                                    onclick="event.preventDefault();stepper.next()">Lanjut</button>
                                            </div>

                                            {{-- Jenis beasiswa --}}
                                            <div id="jenis-beasiswa" class="content" role="tabpanel"
                                                aria-labelledby="jenis-beasiswa-part-trigger">
                                                {{-- jenis beasiswa --}}


                                                <div class="row">

                                                    <div class="col-md-12">
                                                        <h3>Akademik</h3>
                                                    </div>


                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Ranking</label>

                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i
                                                                            class="fas fa-medal"></i></span>
                                                                </div>
                                                                <input type="text" class="form-control"
                                                                    data-inputmask='"mask": "9/9/9"'
                                                                    placeholder="kelas/semester/peringkat"
                                                                    name="peringkat"
                                                                    value="{{ $peserta->akademik['kelas']
                                                                        ? $peserta->akademik['kelas'] . '/' . $peserta->akademik['semester'] . '/' . $peserta->akademik['peringkat']
                                                                        : '' }}"
                                                                    data-mask>
                                                            </div>
                                                            <div class="form-text text-muted text-xs">format: kelas /
                                                                semester / peringkat. contoh: 9/1/1</div>
                                                            <!-- /.input group -->
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Hadidz / Hafidzoh</label>
                                                            <input type="text" class="form-control" name="hafidz"
                                                                placeholder="Hafidz / Hafidzoh"
                                                                value="{{ $peserta->akademik['hafidz'] ?? '' }}" />
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <h3>Non Akademik</h3>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Jenis Lomba</label>
                                                            <input type="text" class="form-control" name="jenis_lomba"
                                                                placeholder="misal: kejuaraan catur"
                                                                value="{{ $peserta->non_akademik['jenis_lomba'] ?? '' }}" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Juara ke</label>
                                                            <input type="number" class="form-control" name="juara_ke"
                                                                placeholder="Juara ke"
                                                                value="{{ $peserta->non_akademik['juara_ke'] ?? '' }}" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Tingkat</label>
                                                            <select class="form-control select2" id="jtingkat"
                                                                style="width: 100%;" name="juara_tingkat">
                                                                <option value="">-- pilih tingkat --</option>
                                                                @foreach (['kabupaten/kota', 'provinsi', 'nasional'] as $tingkat)
                                                                    <option value="{{ $tingkat }}"
                                                                        {{ $peserta->non_akademik['juara_tingkat'] ? ($peserta->non_akademik['juara_tingkat'] == $tingkat ? 'selected' : '') : '' }}>
                                                                        {{ $tingkat }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <h3>Rekomendasi</h3>
                                                    </div>

                                                    <div class="col-md-12">
                                                        {{-- <label>Rekomendasi</label> --}}
                                                        <div class="custom-control custom-checkbox mb-2">
                                                            <input type="checkbox" name="rekomendasi_mwc"
                                                                class="custom-control-input" id="mwc"
                                                                {{ $peserta->rekomendasi_mwc ? 'checked' : '' }}>
                                                            <label class="custom-control-label" for="mwc">Peserta di
                                                                rekomendasikan oleh MWC</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 mt-3">
                                                        <div class="form-group">
                                                            <label>Saran dari</label>
                                                            <input type="text" class="form-control" name="saran_dari"
                                                                placeholder="Saran dari siapa?"
                                                                value="{{ $peserta->saran_dari }}" />
                                                        </div>
                                                    </div>
                                                </div> <!-- row -->



                                                <button class="btn btn-primary"
                                                    onclick="event.preventDefault();stepper.previous()">Kembali</button>
                                                <button class="btn btn-primary" type="submit">Simpan</button>
                                            </div>
                                        </div>
                                        {{-- bs step body --}}


                                    </div> {{-- bs-stepper --}}



                                </div> {{-- card body --}}






                                {{-- card footer
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary ml-2">Simpan</button>
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
    <link rel="stylesheet" href="/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
@endsection

@section('footer')

    <script src="/plugins/select2/js/select2.full.min.js"></script>

    <script src="/plugins/bs-stepper/js/bs-stepper.min.js"></script>
    <script src="/plugins/inputmask/jquery.inputmask.min.js"></script>
    <script src="/plugins/sweetalert2/sweetalert2.min.js"></script>

    <script>
        $(function() {
            $('#pjurusan').select2({
                theme: 'bootstrap4'
            })

            $('#tlulus').select2({
                theme: 'bootstrap4'
            })
            $('#jtingkat').select2({
                theme: 'bootstrap4'
            })

            $('[data-mask]').inputmask()

        })

        function fkip() {
            let kip = $('#pkip:checked').length;

            if (kip) {
                $('#input-kip').prop('disabled', false)
            } else {

                $('#input-kip').prop('disabled', true)
            }

        }

        // BS-Stepper Init
        document.addEventListener('DOMContentLoaded', function() {

            let step = document.getElementById('stepper')
            window.stepper = new Stepper(step)
        })
    </script>
    <script>
        let deletePeserta = document.getElementById('delete-peserta')

        deletePeserta.addEventListener('submit', (e) => {
            e.preventDefault()

            console.log('opo')

            Swal.fire({
                icon: 'warning',
                title: 'Hapus Peserta?',
                text: 'Peserta akan di hapus dari pendaftar ppdb',
                showCancelButton: true,
            }).then((res) => {

                if (res.isConfirmed) {
                    deletePeserta.submit()
                }

            });
        })
    </script>
@endsection
