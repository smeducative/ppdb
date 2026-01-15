
<div class="row">
    <div class="col-2 p-0">
        <img src="/img/logo.png" width="65%" height="75%" class="float-left" style="object-fit: contain;"/>
    </div>

    <div class="col-6 p-0">
        <p class="text-center">
            <strong class="d-block" style="font-size: 22px;">PANITIA PENERIMAAN PESERTA DIDIK BARU</strong>
            <strong class="d-block">SMK DIPONEGORO KARANGANYAR</strong>
            <span style="font-size: 18px;">Jl. Karanganyar Km. 1,5 Kayugeritan – Karanganyar kab. Pekalongan 51182</span>
        </p>
    </div>

    <div class="col-4 text-center" style="height: 100%;">
        <div style="display: flex;align-items: center;justify-content: center;">

            <strong class="d-inline mr-2">No.</strong>
            @php
                $jurusanAbbr = $kwitansi->pesertaPpdb->jurusan->abbreviation ?? '';
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
            <div class="px-3 py-1 d-inline" style="background-color: {{ $bgColor }}; border: 5px solid {{ $borderColor }}; border-radius: 5px; color: {{ $textColor }}; font-weight: bold; -webkit-print-color-adjust: exact; print-color-adjust: exact;">{{ $kwitansi->pesertaPpdb->no_pendaftaran }}</div>
        </div>
    </div>
</div>

<hr style="border: 1px solid black;" class="m-0 p-0">
<div class="text-center">
    <strong style="font-size: 28px; font-weight: bold;">KWITANSI</strong>
</div>

<table class="table table-borderless text-left">
    <tr>
        <td width="18%">Sudah Terima Dari</td>
        <td width="2%">:</td>
        <td> {{ $kwitansi->pesertaPpdb->nama_lengkap }} </td>
    </tr>
    <tr>
        <td width="18%">Banyaknya Uang</td>
        <td width="2%">:</td>
        <td class="w-full" style="position: relative
        ;"> <img src="/img/kwitansi/image003.png" style="position: absolute; z-index: 0; top: 0; left: 0; right: 0; bottom: 0;" >
            <span class="px-5" style="position: absolute;z-index: 1;">{{ (new App\Helper\Terbilang)->convert($kwitansi->nominal) }} rupiah</span>
        </td>
    </tr>
    </tr>
    <tr>
        <td width="18%">Untuk Pembayaran</td>
        <td width="2%">:</td>
        <td> {{ $kwitansi->jenis_pembayaran }} </td>
    </tr>
</table>

<div class="text-right w-full px-5">
    Pekalongan, {{ $kwitansi->created_at->format('d-m-Y') }}
</div>

<div class="px-3 d-flex mt-2">
    <strong class="mr-2">Terbilang Rp.</strong>

    <div style="position: relative;" class="text-center p-2">
        <img src="/img/kwitansi/image005.png" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0;">
            <span class="px-5" style="position: absolute; z-index: 1;">{{ number_format($kwitansi->nominal, 2, ',', '.') }}</span>
        </div>
</div>

<div class="row mt-5">
    <div class="col-6 text-right">
        <strong>Penerima</strong>
    </div>
    <div class="col-6 text-right" style="padding-right: 120px;">
        <strong class="d-block">Penyetor</strong>

    </div>
</div>

<span style="font-size: 12px;">*kwitansi ini berlaku apabila terdapat stampel panitia</span>
