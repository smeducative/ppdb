@extends('layouts.pdf')

@section('title', 'Cetak Surat Penerimaan Beasiswa')

@section('content')
@php
    $pesertasToPrint = isset($pesertas) ? $pesertas : collect([$peserta]);
@endphp

@foreach ($pesertasToPrint as $peserta)
    @php
        $jurusanAbbr = $peserta->jurusan->abbreviation ?? '';
        $bgColor = '#FFFFFF';
        $borderColor = '#000000';
        $textColor = '#000000';

        switch ($jurusanAbbr) {
            case 'TBSM':
            case 'TSM':
                $bgColor = '#87CEFA';
                $borderColor = '#00689e';
                $textColor = '#000000';
                break;
            case 'TKR':
            case 'TKRO':
                $bgColor = '#00008B';
                $borderColor = '#000000';
                $textColor = '#FFFFFF';
                break;
            case 'TKJ':
            case 'TJKT':
                $bgColor = '#FF69B4';
                $borderColor = '#C71585';
                $textColor = '#FFFFFF';
                break;
            case 'ACP':
                $bgColor = '#800000';
                $borderColor = '#000000';
                $textColor = '#FFFFFF';
                break;
            case 'AT':
            case 'ATPH':
                $bgColor = '#008000';
                $borderColor = '#004d00';
                $textColor = '#FFFFFF';
                break;
            case 'BCF':
                $bgColor = '#FFD700';
                $borderColor = '#B8860B';
                $textColor = '#000000';
                break;
        }
    @endphp

    {{-- BAGIAN ATAS: Untuk Peserta --}}
    <div style="padding: 10px 0;">
        <span style="background: #e0e0e0; padding: 2px 10px; font-size: 12px; font-weight: bold; border-radius: 3px;">UNTUK PESERTA</span>

        {{-- Header --}}
        <div class="row">
            <div class="col-2 p-0">
                <img src="/img/logo.png" width="70" style="object-fit: contain;">
            </div>
            <div class="col-7 p-0">
                <p class="text-center">
                    <strong class="d-block" style="font-size: 16px;">SISTEM PENERIMAAN MURID BARU {{ now()->year }}/{{ now()->addYear()->year }}</strong>
                    <strong class="d-block" style="font-size: 16px;">SMK DIPONEGORO KARANGANYAR</strong>
                    <span style="font-size: 13px;">Jl. Karanganyar Km. 1,5 Kayugeritan – Karanganyar kab. Pekalongan 51182</span>
                </p>
            </div>
            <div class="col-3 text-center" style="display: flex; align-items: center; justify-content: center;">
                <strong class="mr-2" style="font-size: 14px;">No.</strong>
                <div style="background-color: {{ $bgColor }}; border: 4px solid {{ $borderColor }}; border-radius: 5px; color: {{ $textColor }}; font-weight: bold; padding: 4px 12px; font-size: 14px; -webkit-print-color-adjust: exact; print-color-adjust: exact;">
                    {{ $peserta->no_pendaftaran }}
                </div>
            </div>
        </div>

        <hr style="border: 1px solid black;" class="my-1">

        <div class="text-center" style="margin: 8px 0;">
            <strong style="font-size: 18px; text-decoration: underline;">SURAT KETERANGAN PENERIMAAN BEASISWA</strong>
        </div>

        <div style="font-size: 14px; line-height: 1.6; text-align: justify;">
            Yang bertanda tangan di bawah ini, Panitia Penerimaan Peserta Didik Baru SMK Diponegoro Karanganyar, dengan ini menerangkan bahwa:
        </div>

        <table style="margin: 8px 0 8px 20px; font-size: 14px;" width="80%">
            <tr>
                <td width="25%">Nama Lengkap</td>
                <td width="3%">:</td>
                <td><strong>{{ Str::title($peserta->nama_lengkap) }}</strong></td>
            </tr>
            <tr>
                <td>No. Pendaftaran</td>
                <td>:</td>
                <td><strong>{{ $peserta->no_pendaftaran }}</strong></td>
            </tr>
            <tr>
                <td>Tempat, Tanggal Lahir</td>
                <td>:</td>
                <td><strong>{{ Str::title($peserta->tempat_lahir) }}, {{ $peserta->tanggal_lahir->format('d-m-Y') }}</strong></td>
            </tr>
            <tr>
                <td>Asal Sekolah</td>
                <td>:</td>
                <td><strong>{{ $peserta->asal_sekolah }}</strong></td>
            </tr>
            <tr>
                <td>Jurusan</td>
                <td>:</td>
                <td><strong>{{ $peserta->jurusan->nama }}</strong></td>
            </tr>
            <tr>
                <td>Tahun Ajaran</td>
                <td>:</td>
                <td><strong>{{ $peserta->semester }}</strong></td>
            </tr>
        </table>

        <div style="font-size: 14px; line-height: 1.6; text-align: justify;">
                @php
                    $jenisLabel = match($jenis) {
                        'mwc' => 'MWC',
                        'kip' => 'KIP',
                        'non-akademik' => 'Non Akademik',
                        'yatim-piatu' => 'Yatim Piatu',
                        default => ucfirst($jenis),
                    };
                @endphp
                Adalah benar penerima <strong>Beasiswa {{ $jenisLabel }}</strong> dari sekolah ini.
        </div>

        <div style="background: #f5f5f5; border: 1px solid #ddd; padding: 8px 12px; margin: 8px 0; font-size: 14px;">
            <strong>Keterangan Beasiswa:</strong>
            {{ $keterangan }}
        </div>

        <div style="font-size: 14px; line-height: 1.6; text-align: justify;">
            Surat keterangan ini diberikan untuk keperluan yang bersangkutan dan apabila di kemudian hari terbukti
            tidak benar, maka yang bersangkutan akan dituntut sesuai dengan ketentuan yang berlaku.
        </div>

        <div style="font-size: 14px; line-height: 1.6; text-align: justify;">
            Demikian surat keterangan ini dibuat dengan sebenarnya.
        </div>

        <div class="row mt-3">
            <div class="col-6">&nbsp;</div>
            <div class="col-6 text-center" style="font-size: 14px;">
                Pekalongan, {{ now()->translatedFormat('d F Y') }}
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-6 text-center">
                <div style="font-size: 14px; font-weight: bold; margin-bottom: 50px;">Penerima Beasiswa</div>
                <div style="font-size: 14px; text-decoration: underline; font-weight: bold;">{{ Str::title($peserta->nama_lengkap) }}</div>
            </div>
            <div class="col-6 text-center">
                <div style="font-size: 14px; font-weight: bold; margin-bottom: 50px;">Panitia SPMB</div>
                <div style="font-size: 14px; text-decoration: underline; font-weight: bold;">{{ $user->name }}</div>
            </div>
        </div>
    </div>

    {{-- GARIS POTONG --}}
    <div style="position: relative; margin: 15px 20px; border-top: 2px dashed #999;">
        <span style="position: absolute; top: -10px; left: 50%; transform: translateX(-50%); background: white; padding: 0 10px; font-size: 11px; color: #999;">✂ POTONG DI SINI</span>
    </div>

    {{-- BAGIAN BAWAH: Untuk Arsip --}}
    <div style="padding: 10px 0; position: relative;">
        <span style="background: #e0e0e0; padding: 2px 10px; font-size: 12px; font-weight: bold; border-radius: 3px; position: relative; z-index: 1;">ARSIP SEKOLAH</span>

        {{-- Watermark --}}
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(-30deg); font-size: 48px; font-weight: bold; color: rgba(0,0,0,0.05); white-space: nowrap; pointer-events: none; z-index: 0;">ARSIP SEKOLAH</div>

        <div style="position: relative; z-index: 1;">
            {{-- Header --}}
            <div class="row">
                <div class="col-2 p-0">
                    <img src="/img/logo.png" width="70" style="object-fit: contain;">
                </div>
                <div class="col-7 p-0">
                    <p class="text-center">
                        <strong class="d-block" style="font-size: 16px;">SISTEM PENERIMAAN MURID BARU {{ now()->year }}/{{ now()->addYear()->year }}</strong>
                    <strong class="d-block" style="font-size: 16px;">SMK DIPONEGORO KARANGANYAR</strong>
                        <span style="font-size: 13px;">Jl. Karanganyar Km. 1,5 Kayugeritan – Karanganyar kab. Pekalongan 51182</span>
                    </p>
                </div>
                <div class="col-3 text-center" style="display: flex; align-items: center; justify-content: center;">
                    <strong class="mr-2" style="font-size: 14px;">No.</strong>
                    <div style="background-color: {{ $bgColor }}; border: 4px solid {{ $borderColor }}; border-radius: 5px; color: {{ $textColor }}; font-weight: bold; padding: 4px 12px; font-size: 14px; -webkit-print-color-adjust: exact; print-color-adjust: exact;">
                        {{ $peserta->no_pendaftaran }}
                    </div>
                </div>
            </div>

            <hr style="border: 1px solid black;" class="my-1">

            <div class="text-center" style="margin: 8px 0;">
                <strong style="font-size: 18px; text-decoration: underline;">SURAT KETERANGAN PENERIMAAN BEASISWA</strong>
            </div>

            <div style="font-size: 14px; line-height: 1.6; text-align: justify;">
                Yang bertanda tangan di bawah ini, Panitia Penerimaan Peserta Didik Baru SMK Diponegoro Karanganyar, dengan ini menerangkan bahwa:
            </div>

            <table style="margin: 8px 0 8px 20px; font-size: 14px;" width="80%">
                <tr>
                    <td width="25%">Nama Lengkap</td>
                    <td width="3%">:</td>
                    <td><strong>{{ Str::title($peserta->nama_lengkap) }}</strong></td>
                </tr>
                <tr>
                    <td>No. Pendaftaran</td>
                    <td>:</td>
                    <td><strong>{{ $peserta->no_pendaftaran }}</strong></td>
                </tr>
                <tr>
                    <td>Tempat, Tanggal Lahir</td>
                    <td>:</td>
                    <td><strong>{{ Str::title($peserta->tempat_lahir) }}, {{ $peserta->tanggal_lahir->format('d-m-Y') }}</strong></td>
                </tr>
                <tr>
                    <td>Asal Sekolah</td>
                    <td>:</td>
                    <td><strong>{{ $peserta->asal_sekolah }}</strong></td>
                </tr>
                <tr>
                    <td>Jurusan</td>
                    <td>:</td>
                    <td><strong>{{ $peserta->jurusan->nama }}</strong></td>
                </tr>
                <tr>
                    <td>Tahun Ajaran</td>
                    <td>:</td>
                    <td><strong>{{ $peserta->semester }}</strong></td>
                </tr>
            </table>

            <div style="font-size: 14px; line-height: 1.6; text-align: justify;">
            @php
                $jenisLabel = match($jenis) {
                    'mwc' => 'MWC',
                    'kip' => 'KIP',
                    'non-akademik' => 'Non Akademik',
                    'yatim-piatu' => 'Yatim Piatu',
                    default => ucfirst($jenis),
                };
            @endphp
            Adalah benar penerima <strong>Beasiswa {{ $jenisLabel }}</strong> dari sekolah ini.
            </div>

            <div style="background: #f5f5f5; border: 1px solid #ddd; padding: 8px 12px; margin: 8px 0; font-size: 14px;">
                <strong>Keterangan Beasiswa:</strong>
                {{ $keterangan }}
            </div>

            <div style="font-size: 14px; line-height: 1.6; text-align: justify;">
                Surat keterangan ini diberikan untuk keperluan yang bersangkutan dan apabila di kemudian hari terbukti
                tidak benar, maka yang bersangkutan akan dituntut sesuai dengan ketentuan yang berlaku.
            </div>

            <div style="font-size: 14px; line-height: 1.6; text-align: justify;">
                Demikian surat keterangan ini dibuat dengan sebenarnya.
            </div>

            <div class="row mt-3">
                <div class="col-6">&nbsp;</div>
                <div class="col-6 text-center" style="font-size: 14px;">
                    Pekalongan, {{ now()->translatedFormat('d F Y') }}
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-6 text-center">
                    <div style="font-size: 14px; font-weight: bold; margin-bottom: 50px;">Penerima Beasiswa</div>
                    <div style="font-size: 14px; text-decoration: underline; font-weight: bold;">{{ Str::title($peserta->nama_lengkap) }}</div>
                </div>
                <div class="col-6 text-center">
                    <div style="font-size: 14px; font-weight: bold; margin-bottom: 50px;">Panitia SPMB</div>
                    <div style="font-size: 14px; text-decoration: underline; font-weight: bold;">{{ $user->name }}</div>
                </div>
            </div>
        </div>
    </div>

    @if(!$loop->last)
        <div style="page-break-after: always;"></div>
    @endif
@endforeach

<script>
    window.addEventListener("load", window.print());
</script>
@endsection
