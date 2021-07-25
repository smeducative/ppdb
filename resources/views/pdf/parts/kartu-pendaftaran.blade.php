
    <!-- header -->
<div class="row p-1 px-3 m-1" style="border: 3px solid black; border-radius: 10px;">
    <div class="col-2 p-0">
        <img src="/img/logo.png" width="65%" height="75%" class="float-left" style="object-fit: contain;" />
    </div>

    <div class="col-10 p-0">
        <div class="text-center">
            <strong class="d-block" style="font-size: 14px;">FORMULIR PENDAFTARAN PESERTA DIDIK BARU</strong>
            <strong class="d-block" style="font-size: 12px;">SMK DIPONEGORO KARANGANYAR</strong>
            <span class="d-block" style="font-size: 11px;">Jl. Karanganyar Km. 1,5 Kayugeritan – Karanganyar 51182</span>
            <span style="font-size: 11px;">website: smkdiponegoropekalongan.sc.id</span>
        </div>
    </div>


        </div>

        <!-- header -->

    <!-- heading -->
    <div class="text-center">
        <strong style="font-weight: 900; font-size: 20px;">KARTU PENDAFTARAN PPDB TH {{ $peserta->created_at->format('Y') . '/' . $peserta->created_at->addYear()->format('Y') }}</strong>
    </div>


    <!-- table  -->

    <table class="table table-borderless m-2" style="font-size: 12px;">
        <tr>
            <td class="p-1" width="30%">No. Pendaftaran</td>
            <td class="p-1" width="5%">:</td>
            <td class="p-1">{{ $peserta->no_pendaftaran }}</td>
        </tr>
        <tr>
            <td class="p-1" width="30%">Nama Lengkap</td>
            <td class="p-1" width="5%">:</td>
            <td class="p-1">{{ $peserta->nama_lengkap }}</td>
        </tr>
        <tr>
            <td class="p-1" width="30%">TTL</td>
            <td class="p-1" width="5%">:</td>
            <td class="p-1">{{ $peserta->tempat_lahir }}, {{ $peserta->tanggal_lahir->format('d-m-Y') }}</td>
        </tr>
        <tr>
            <td class="p-1" width="30%">Kejuruan</td>
            <td class="p-1" width="5%">:</td>
            <td class="p-1">{{ $peserta->jurusan->nama }}</td>
        </tr>
    </table>

    <!-- photo adn ttd -->
    <div class="row">
        <div class="col-md-6">
            <div style="width: 140px; height: 160px; border: 3px solid black; border-radius: 8px; margin: 5px; margin-left: 20px;">
            </div>
        </div>

        <div class="col-md-6 text-center">
            <span>{{ $peserta->created_at->format('d-m-Y') }}</span>
            <strong class="d-block" style="font-size: 11px;">Smk Diponegoro Karanganyar</strong>
            <div style="margin-top: 70px;">(______)</div>
        </div>
    </div>