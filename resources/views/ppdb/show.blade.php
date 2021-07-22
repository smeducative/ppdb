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
                        <li class="breadcrumb-item active">Peserta PPDB</li>
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

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Data diri peserta</h3>

                            <div class="card-tools">
                                <button class="btn btn-primary" onclick="document.getElementById('unduh-dokumen').submit();"><i class="fas fa-print mr-2"></i> print</button>
                                <form action="{{ route('ppdb.unduh.dokumen', ['uuid' => $peserta->id ]) }}" method="POST" id="unduh-dokumen">
                                    @csrf
                                </form>
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
                                                {{ $peserta->tanggal_lahir->format('d-m-Y') }}
                                                ({{ $peserta->tanggal_lahir->timespan() }}) </span>
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
                                            <span>
                                                @switch($peserta->diterima)
                                                @case(0)
                                                <span class="text-warning">Proses seleksi</span>
                                                @break
                                                @case(1)
                                                <span class="text-success">Di terima</span>

                                                @break
                                                @default
                                                <span class="text-danger">Di tolak</span>

                                                @endswitch
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>

                        <div class="card-footer">
                            <button type="button" class="btn btn-success">Terima</button>
                            <button type="button" class="btn btn-danger">Tolak</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

</div>


@endsection
