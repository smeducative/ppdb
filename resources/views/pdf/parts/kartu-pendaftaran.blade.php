<!-- header -->
<div class="row p-1 px-3 m-1" style="border: 3px solid black; border-radius: 10px;">
    <div class="col-2 p-0">
        <img src="/img/logo.png" width="65%" height="75%" class="float-left" style="object-fit: contain;" />
    </div>

    <div class="col-10 p-0">
        <div class="text-center">
            <strong class="d-block" style="font-size: 14px;">FORMULIR PENDAFTARAN PESERTA DIDIK BARU</strong>
            <strong class="d-block" style="font-size: 12px;">SMK DIPONEGORO KARANGANYAR</strong>
            <span class="d-block" style="font-size: 12px;">Jl. Karanganyar Km. 1,5 Kayugeritan – Karanganyar kab.
                Pekalongan 51182</span>
            <span style="font-size: 11px;">website: smkdiponegoropekalongan.sch.id</span>
        </div>
    </div>


</div>

<!-- header -->

<!-- heading -->
<div class="text-center">
    <strong style="font-weight: 900; font-size: 20px;">KARTU PENDAFTARAN SPMB TA
        {{ $peserta->created_at->format('Y') . '/' . $peserta->created_at->addYear()->format('Y') }}</strong>
</div>


<!-- table  -->

@php
    $jurusanAbbr = $peserta->jurusan->abbreviation ?? '';
    $bgColor = '#FFFFFF';
    $borderColor = '#000000';
    $textColor = '#000000';
    
    // Mapping warna background, border, dan text berdasarkan jurusan
    // TSM & TKR: BIRU MUDA DAN BIRU TUA
    // TJKT & ACP: PINK DAN MAROON
    // AT: HIJAU
    // BCF: KUNING
    switch ($jurusanAbbr) {
        case 'TBSM':
        case 'TSM':
            // Biru Muda (Light Sky Blue)
            $bgColor = '#87CEFA'; 
            $borderColor = '#00689e'; // Darker version of bg
            $textColor = '#000000';
            break;
        case 'TKR':
        case 'TKRO':
            // Biru Tua (Dark Blue)
            $bgColor = '#00008B'; 
            $borderColor = '#000000'; // Black border for contrast
            $textColor = '#FFFFFF';
            break;
        case 'TKJ':
        case 'TJKT':
            // Pink (Hot Pink)
            $bgColor = '#FF69B4'; 
            $borderColor = '#C71585'; // Medium Violet Red
            $textColor = '#FFFFFF';
            break;
        case 'ACP':
            // Maroon
            $bgColor = '#800000'; 
            $borderColor = '#000000';
            $textColor = '#FFFFFF';
            break;
        case 'AT':
        case 'ATPH':
            // Hijau (Green)
            $bgColor = '#008000'; 
            $borderColor = '#004d00'; // Darker Green
            $textColor = '#FFFFFF';
            break;
        case 'BCF':
            // Kuning (Gold)
            $bgColor = '#FFD700'; 
            $borderColor = '#B8860B'; // Dark Golden Rod
            $textColor = '#000000';
            break;
    }
@endphp

<table class="m-2" style="font-size: 16px;">
    <tr>
        <td class="p-1" width="37%">No. Pendaftaran</td>
        <td class="p-1" width="5%">:</td>
        <td class="">
            <span style="background-color: {{ $bgColor }}; color: {{ $textColor }}; border: 2px solid {{ $borderColor }}; border-radius: 5px; padding: 2px 5px; font-weight: bold; display: inline-block; -webkit-print-color-adjust: exact; print-color-adjust: exact;">
                {{ $peserta->no_pendaftaran }}
            </span>
        </td>
    </tr>
    <tr>
        <td class="p-1" width="37%">Nama Lengkap</td>
        <td class="p-1" width="5%">:</td>
        <td class="">{{ $peserta->nama_lengkap }}</td>
    </tr>
    <tr>
        <td class="p-1" width="37%">TTL</td>
        <td class="p-1" width="5%">:</td>
        <td class="">{{ $peserta->tempat_lahir }}, {{ $peserta->tanggal_lahir->translatedFormat('d F Y') }}</td>
    </tr>
    <tr>
        <td class="p-1" width="37%">Program Keahlian</td>
        <td class="p-1" width="5%">:</td>
        <td class="">{{ $peserta->jurusan->nama }}</td>
    </tr>
</table>

<!-- photo adn ttd -->
<div class="row mt-2">
    <div class="col-md-6">
        <div
            style="width: 120px; height: 140px; border: 3px solid black; border-radius: 8px; margin: 5px; margin-left: 20px;">
        </div>
    </div>

    <div class="col-md-6 text-center">
        <span>Pekalongan, {{ $peserta->created_at->translatedFormat('d F Y') }}</span>
        <strong class="d-block" style="font-size: 16px;">Panitia Pendaftaran</strong>
        <div style="margin-top: 50px;">( {{ auth()->user()->name }} )</div>
    </div>
</div>
