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
                        <li class="breadcrumb-item active">Peserta SPMB</li>
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

					@if (session()->has('warning'))
                        <div class="alert alert-warning alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fas fa-check"></i> Peringatan!</h5>
                            {{ session('warning') }}
                        </div>
                    @endif

                   @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fas fa-check"></i> Success!</h5>
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Data diri peserta</h3>

                            <div class="card-tools">
                                <a class="btn btn-primary" href="{{ route('ppdb.edit.peserta', $peserta->id) }}"><i class="fas fa-edit mr-2"></i> edit</a>
                            </div>
                        </div>
                        <div class="card-body p-0">

                            <div class="p-3">
                                <h4># Identitas Diri</h4>
                            </div>

                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th width="30%">No. Pendaftaran</th>
                                        <td width="5%">:</td>
                                        <td>
                                            <strong>{{ $peserta->no_pendaftaran }}</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Nama Lengkap</th>
                                        <td width="5%">:</td>
                                        <td>
                                            <span>{{ $peserta->nama_lengkap }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Jenis Kelamin</th>
                                        <td width="5%">:</td>
                                        <td>
                                            <span>{{ $peserta->jenis_kelamin === 'l' ? 'Laki-laki' : 'Perempuan' }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Tempat, Tanggal lahir</th>
                                        <td width="5%">:</td>
                                        <td>
                                            <span>{{ $peserta->tempat_lahir }},
                                                {{ $peserta->tanggal_lahir->format('d-m-Y') }}</span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th width="30%">Umur</th>
                                        <td width="5%">:</td>
                                        <td>
                                            <span>{{ $peserta->tanggal_lahir->timespan() }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Asal Sekolah</th>
                                        <td width="5%">:</td>
                                        <td>
                                            <span>{{ $peserta->asal_sekolah }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Tahun Lulus</th>
                                        <td width="5%">:</td>
                                        <td>
                                            <span>{{ $peserta->tahun_lulus }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Pilihan Jurusan</th>
                                        <td width="5%">:</td>
                                        <td>
                                            <span>{{ $peserta->jurusan->nama }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="30%">NIK</th>
                                        <td width="5%">:</td>
                                        <td>
                                            <span>{{ $peserta->nik }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="30%">NISN</th>
                                        <td width="5%">:</td>
                                        <td>
                                            <span>{{ $peserta->nisn }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Alamat</th>
                                        <td width="5%">:</td>
                                        <td>
                                            <span>{{ $peserta->alamat_lengkap }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Dukuh</th>
                                        <td width="5%">:</td>
                                        <td>
                                            <span>{{ $peserta->dukuh }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="30%">RT</th>
                                        <td width="5%">:</td>
                                        <td>
                                            <span>{{ $peserta->rt }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="30%">RW</th>
                                        <td width="5%">:</td>
                                        <td>
                                            <span>{{ $peserta->rw }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Desa/Kelurahan</th>
                                        <td width="5%">:</td>
                                        <td>
                                            <span>{{ $peserta->desa_kelurahan }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Kecamatan</th>
                                        <td width="5%">:</td>
                                        <td>
                                            <span>{{ $peserta->kecamatan }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Kabupaten/Kota</th>
                                        <td width="5%">:</td>
                                        <td>
                                            <span>{{ $peserta->kabupaten_kota }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Provinsi</th>
                                        <td width="5%">:</td>
                                        <td>
                                            <span>{{ $peserta->provinsi }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Kode Pos</th>
                                        <td width="5%">:</td>
                                        <td>
                                            <span>{{ $peserta->kode_pos }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="30%">No. HP</th>
                                        <td width="5%">:</td>
                                        <td>
                                            <span>{{ $peserta->no_hp }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Penerima KIP</th>
                                        <td width="5%">:</td>
                                        <td>
                                            <span>{{ $peserta->penerima_kip === 'y' ? 'Penerima KIP' : 'bukan penerima KIP' }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="30%">No. KIP</th>
                                        <td width="5%">:</td>
                                        <td>
                                            <span>{{ $peserta->no_kip ?? '-' }}</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="p-3">
                                <h4># Identitas Orang Tua</h4>
                            </div>

                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th width="30%">Nama Ayah</th>
                                        <td width="5%">:</td>
                                        <td>
                                            <span>{{ $peserta->nama_ayah }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Pekerjaan Ayah</th>
                                        <td width="5%">:</td>
                                        <td>
                                            <span>{{ $peserta->pekerjaan_ayah }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="30%">No. HP Ayah</th>
                                        <td width="5%">:</td>
                                        <td>
                                            <span>{{ $peserta->no_hp_ayah }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Nama Ibu</th>
                                        <td width="5%">:</td>
                                        <td>
                                            <span>{{ $peserta->nama_ibu }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Pekerjaan Ibu</th>
                                        <td width="5%">:</td>
                                        <td>
                                            <span>{{ $peserta->pekerjaan_ibu }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="30%">No. HP Ibu</th>
                                        <td width="5%">:</td>
                                        <td>
                                            <span>{{ $peserta->no_hp_ibu }}</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="p-3">
                                <h4>Jenis Beasiswa</h4>
                            </div>

                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th colspan="3"># Akademik</th>
                                    </tr>
                                    <tr>
                                        <th width="30%">Kelas</th>
                                        <td width="5%">:</td>
                                        <td>
                                            <span>{{ $peserta->akademik['kelas'] }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Semester</th>
                                        <td width="5%">:</td>
                                        <td>
                                            <span>{{ $peserta->akademik['semester'] }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Peringkat</th>
                                        <td width="5%">:</td>
                                        <td>
                                            <span>{{ $peserta->akademik['peringkat'] }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Hafidz / Hafidzoh</th>
                                        <td width="5%">:</td>
                                        <td>
                                            <span>{{ $peserta->akademik['hafidz'] }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th colspan="3"># Non Akademik</th>
                                    </tr>
                                    <tr>
                                        <th width="30%">Jenis Lomba</th>
                                        <td width="5%">:</td>
                                        <td>
                                            <span>{{ $peserta->non_akademik['jenis_lomba'] }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Juara ke</th>
                                        <td width="5%">:</td>
                                        <td>
                                            <span>{{ $peserta->non_akademik['juara_ke'] }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="30%">Juara Tingkat</th>
                                        <td width="5%">:</td>
                                        <td>
                                            <span>{{ $peserta->non_akademik['juara_tingkat'] }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th colspan="3"># Rekomendasi</th>
                                    </tr>
                                    <tr>
                                        <th width="30%">Rekomendasi MWC</th>
                                        <td width="5%">:</td>
                                        <td>
                                            <span>{{ $peserta->rekomendasi_mwc ? 'Ya' : 'Tidak'}}</span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th colspan="3"># Status</th>
                                    </tr>

                                    <tr>
                                        <th width="30%">Penerimaan</th>
                                        <td width="5%">:</td>
                                        <td>
                                                @switch($peserta->diterima)
                                                @case(0)
                                                <span class="badge bg-warning">Proses seleksi</span>
                                                @break
                                                @case(1)
                                                <span class="badge bg-success">Di terima</span>

                                                @break
                                                @default
                                                <span class="badge bg-danger">Di tolak</span>

                                                @endswitch
                                        </td>
                                    </tr>


                                    <tr>
                                        <th width="30%">Saran dari</th>
                                        <td width="5%">:</td>
                                        <td>
                                            <span>{{ $peserta->saran_dari }}</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>

                        <div class="card-footer">

							Peserta yang dinyatakan diterima, melakukan daftar ulang di menu kwitansi.
<br> <br>
                            <button id="btn-terima" class="btn btn-success">Terima</button>
                            <button id="btn-tolak" class="btn btn-danger">Tolak</button>

                            <form id="peserta-diterima" action="{{ route('ppdb.terima.peserta', ['uuid' => $peserta->id]) }}?status=y" method="POST">
                                @csrf
                            </form>
                            <form id="peserta-ditolak" action="{{ route('ppdb.terima.peserta', ['uuid' => $peserta->id]) }}?status=n" method="POST">
                                @csrf
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

</div>


@endsection
@section('head')

<link rel="stylesheet" href="/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

@endsection
@section('footer')
    <script src="/plugins/sweetalert2/sweetalert2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#btn-terima').click(function() {

                Swal.fire({
                    icon: 'question',
                    title: 'Terima Peserta?',
                    showCancelButton: true,
                }).then((res) => {

                    if(res.isConfirmed) {
                        $('#peserta-diterima').submit()
                    }

                });

                // $('#peserta-diterima')
            });

            $('#btn-tolak').click(function() {

                Swal.fire({
                    icon: 'question',
                    title: 'Tolak Peserta?',
                    showCancelButton: true,
                }).then((res) => {

                    if(res.isConfirmed) {
                        $('#peserta-ditolak').submit()
                    }

                });

                // $('#peserta-diterima')
            });
        })
    </script>
@endsection
