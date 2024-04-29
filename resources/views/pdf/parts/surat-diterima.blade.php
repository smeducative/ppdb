<!-- header -->
<div class="row">
    <div class="col-2 p-0">
        <img src="/img/logo.png" width="90%" height="100%" class="float-left" style="object-fit: contain;" />
    </div>

    <div class="col-10 p-0">
        <div class="text-center">
            <strong class="d-block" style="font-size: 26px;">PANITIA PENERIMAAN PESERTA DIDIK BARU</strong>
            <strong class="d-block" style="font-size: 26px;">LEMBAGA PENDIDIKAN MA'ARIF NU KARANGANYAR</strong>
            <strong class="d-block" style="font-size: 24px;">SMK DIPONEGORO KARANGANYAR</strong>
            <strong class="d-block" style="font-size: 24px;">TAHUN AJARAN
                {{ now()->year }}/{{ now()->addYear()->year }}</strong>
            <span class="d-block" style="font-size: 18px;">Jl. Karanganyar Km. 1,5 Kayugeritan – Karanganyar
                51182</span>
            <span style="font-size: 18px;">website: smkdiponegoropekalongan.sch.id e-mail:
                smkdipo.pekalongan@gmail.com</span>
        </div>
    </div>


</div>

<!-- hr -->
<hr style="border: 2px solid black;" class="my-0">

<table style="margin-top: 18px; font-size: 21px;" width="55%">
    <tr>
        <td width="13%">No</td>
        <td>:</td>
        <td> &nbsp; {{ optional($setting->body)['no_surat'] }}</td>
    </tr>
    <tr>
        <td>Lamp.</td>
        <td>:</td>
        <td> &nbsp; 1 lembar</td>
    </tr>
    <tr>
        <td style="justify-content: start;">Hal</td>
        <td>:</td>
        <td style="padding-left: 10px;"> <strong>Pemberitahuan Pengumuman Hasil Seleksi
                Penerimaan Peserta Didik Baru
            </strong> </td>
    </tr>
</table>

<div class="row mb-5" style="font-size: 21px">
    <div class="col-4">&nbsp;</div>
    <div class="col-4">&nbsp;</div>
    <div class="col-4" style="font-size: 19px;">
        <strong class="d-block">Kepada:</strong>
        <strong class="d-block">Yth. Orang Tua/Wali Siswa Baru</strong>
        <strong class="d-block">Di:</strong>
        <span class="ml-3">Tempat</span>
    </div>
</div>

<div style="font-size: 20px">

    <strong style="font-size: 18px;" class="d-block">Assalamu’alaikum Wr. Wb.</strong>
    <p style="font-size: 18px;">
        Teriring puja dan puji syukur kehadirat Allah SWT serta Sholawat salam teruntuk Baginda Rasulullah SAW. Bersama
        ini kami
        sampaikan bahwa, putra/putri Bapak/Ibu yang tersebut di bawah ini
    </p>

    <table style="margin-left: 60px; font-size: 18px;">
        <tr>
            <td width="30%">Nama</td>
            <td>:</td>
            <td> &nbsp; {{ $peserta->nama_lengkap }}</td>
        </tr>
        <tr>
            <td width="30%">Nomor Pendaftaran</td>
            <td>:</td>
            <td> &nbsp; {{ $peserta->no_pendaftaran }}</td>
        </tr>
        <tr>
            <td width="30%">Alamat</td>
            <td>:</td>
            <td> &nbsp; {{ $peserta->alamat_lengkap }}</td>
        </tr>
        <tr>
            <td width="30%">Asal Sekolah</td>
            <td>:</td>
            <td> &nbsp; {{ $peserta->asal_sekolah }}</td>
        </tr>
    </table>

    <p style="margin-top: 18px;">
        Berdasarkan hasil ujian seleksi Penerimaan Peserta Didik Baru SMK Diponegoro TA.
        {{ now()->year }}/{{ now()->addYear()->year }} dinyatakan :
    </p>
    <div class="text-center" style="font-size: 20px; border: 2px solid black; padding: 14px;">
        <strong class="d-block">
            LULUS/<strike>TIDAK LULUS</strike> dan DITERIMA/<strike>TIDAK</strike>
        </strong>
        <small class="d-block">Pada Program Keahlian:</small>
        <strong class="d-block">{{ $peserta->jurusan->nama }} ({{ $peserta->jurusan->abbreviation }})</strong>
    </div>

    <div class="mt-2" style="font-size: 18px;">
        Sehubungan dengan terbatas kelas yang ada, maka Bapak/Ibu/Saudara dapat segera langsung melaksanakan
        <strong>registrasi daftar
            ulang setelah dinyatakan diterima.</strong> <br>
        <strong>
            Apabila sebelum batas akhir yang telah ditentukan
            ({{ $carbon->parse($setting->body['batas_akhir_ppdb'])->translatedFormat('d F Y') }})
        </strong>, kelas/rombel yang tersedia telah terpenuhi quotanya
        (jumlah peserta didik yang diterima), maka dengan berat hati kami sampaikan Putra/Putri Bapak/Ibu <strong>tidak
            dapat diterima</strong>
        di kelas tersebut. <br>
        Biaya registrasi yang telah dibayarkan ke SMK Diponegoro Karanganyar <strong>tidak dapat diambil</strong>
        kembali apabila Putra/Putri
        Bapak/Ibu diterima di SMA/SMK lain dengan syarat dan ketentuan yang telah ditetapkan sekolah. Adapun besaran
        biaya
        registrasi terlampir.
        <br><br>
        Demikian surat pemberitahuan ini disampaikan. Atas perhatian dan kerjasamanya disampaikan terima kasih.
        <br>
        <strong>

            Wassalamu’alaikum Wr. Wb.
        </strong>

    </div>
</div>

<div class="row mt-5" style="font-size: 20px">
    <div class="col-6">&nbsp;</div>
    <div class="col-6 text-center">
        <strong class="d-block">Karanganyar, {{ now()->translatedFormat('d F Y') }}</strong>
    </div>

    <div class="col-6">&nbsp;</div>
    <div class="col-6 mt-5">&nbsp;</div>
    <div class="col-6">&nbsp;</div>
    <div class="col-6 mt-5 text-center">
        ( {{ auth()->user()->name }} )
    </div>

    <div class="col-12 mt-5" style="font-size: 16px">
        <strong>Nb:* Hari
            {{ $carbon->parse($setting->body['batas_akhir_ppdb'])->subDay()->translatedFormat('l. d F Y') }}</strong>
        Pukul 07.00, Siswa berangkat memakai seragam Osis SMP/MTs untuk <strong>persiapan/pembekalan
            kegiatan Makesta.</strong>
    </div>
</div>
