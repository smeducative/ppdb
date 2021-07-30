
    <!-- header -->
    <div class="row">
        <div class="col-2 p-0">
            <img src="/img/logo.png" width="80%" height="90%" class="float-left" style="object-fit: contain;" />
        </div>

        <div class="col-10 p-0">
            <div class="text-center">
                <strong class="d-block" style="font-size: 26px;">LEMBAGA PENDIDIKAN MA'ARIF NU KARANGANYAR</strong>
                <strong class="d-block" style="font-size: 24px;">SMK DIPONEGORO KARANGANYAR</strong>
                <span class="d-block" style="font-size: 18px;">Jl. Karanganyar Km. 1,5 Kayugeritan – Karanganyar
                    51182</span>
                <span style="font-size: 18px;">website: smkdiponegoropekalongan.sch.id e-mail: smkdipo.pekalongan@gmail.com</span>
            </div>
        </div>


    </div>

    <!-- hr -->
    <hr style="border: 2px solid black;">
    <div class="text-center">
        <strong style="font-weight: bolder; font-size: 22px;"> FORMULIR PENDAFTARAN PESERTA DIDIK BARU TAHUN PELAJARAN {{ $peserta->created_at->format('Y') }} / {{ $peserta->created_at->addYear()->format('Y') }} </strong>
    </div>
    <hr style="border: 2px solid black;">

    <!-- isi -->
    <div class="float-right">
        <strong  style="font-size: 20px;">{{ $peserta->no_pendaftaran }}</strong>
    </div>

    <div class="" style="font-size: 19px; margin-left: 22px">
        <!-- identitas diri -->
        <span>A.</span> &ensp; Identitas Diri
        <table style="margin-left: 32px;" width="100%">
            <tr>
                <td width="29.6%">1. &ensp; Nama Lengkap</td>
                <td width="1%">:</td>
                <td>{{ $peserta->nama_lengkap }}</td>
            </tr>
            <tr>
                <td width="29.6%">2. &ensp; Jenis Kelamin</td>
                <td width="1%">:</td>
                <td>{{ $peserta->jenis_kelamin == 'l' ? 'Laki-laki' : 'Perempuan' }}</td>
            </tr>
            <tr>
                <td width="29.6%">3. &ensp; Tempat Lahir</td>
                <td width="1%">:</td>
                <td>{{ $peserta->tempat_lahir }}</td>
            </tr>

            <tr>
                <td width="29.6%">4. &ensp; Tanggal Lahir</td>
                <td width="1%">:</td>
                <td>{{ $peserta->tanggal_lahir->translatedFormat('d F Y') }}</td>
            </tr>
            <tr>
                <td width="29.6%">5. &ensp; NIK</td>
                <td width="1%">:</td>
                <td>{{ $peserta->nik }}</td>
            </tr>
            <tr>
                <td width="29.6%">6. &ensp; Alamat Lengkap</td>
                <td width="1%">:</td>
                <td>{{ $peserta->alamat_lengkap }}</td>
            </tr>
            <tr>
                <td width="29.6%">7. &ensp; Kompetensi Keahlian</td>
                <td width="1%">:</td>
                <td>{{ $peserta->jurusan->nama }}</td>
            </tr>
            <tr>
                <td width="29.6%">8. &ensp; Asal Sekolah</td>
                <td width="1%">:</td>
                <td>{{ $peserta->asal_sekolah }}</td>
            </tr>
            <tr>
                <td width="29.6%">9. &ensp; Tahun Lulus</td>
                <td width="1%">:</td>
                <td>{{ $peserta->tahun_lulus }}</td>
            </tr>
            <tr>
                <td width="29.6%">10. &ensp; NISN </td>
                <td width="1%">:</td>
                <td>{{ $peserta->nisn }}</td>
            </tr>
            <tr>
                <td width="29.6%">11. &ensp; Penerima KIP</td>
                <td width="1%">:</td>
                <td>{{ $peserta->penerima_kip == 'y' ? "Ya" : "Tidak" }}</td>
            </tr>
            <tr>
                <td width="29.6%">12. &ensp; No. KIP</td>
                <td width="1%">:</td>
                <td>{{ $peserta->no_kip }}</td>
            </tr>
            <tr>
                <td width="29.6%">13. &ensp; No. Telepon</td>
                <td width="1%">:</td>
                <td>{{ $peserta->no_hp }}</td>
            </tr>
        </table>

        {{-- identitas orang tua --}}
        <span>B.</span> &ensp; Identitas Orang Tua / Wali
        <div style="margin-left: 32px;">1. Ayah</div>
        <table style="margin-left: 64px;" width="100%">
            <tr>
                <td width="27%">a. &ensp; Nama Ayah</td>
                <td width="1%">:</td>
                <td>{{ $peserta->nama_ayah }}</td>
            </tr>
            <tr>
                <td width="27%">b. &ensp; Pekerjaan Ayah</td>
                <td width="1%">:</td>
                <td>{{ $peserta->pekerjaan_ayah }}</td>
            </tr>
            <tr>
                <td width="27%">c. &ensp; Nomor Telepon Ayah</td>
                <td width="1%">:</td>
                <td>{{ $peserta->no_hp_ayah }}</td>
            </tr>
        </table>
        <div style="margin-left: 32px;">2. Ibu</div>
        <table style="margin-left: 64px;" width="100%">
            <tr>
                <td width="27%">a. &ensp; Nama Ibu</td>
                <td width="1%">:</td>
                <td>{{ $peserta->nama_ibu }}</td>
            </tr>
            <tr>
                <td width="27%">b. &ensp; Pekerjaan Ibu</td>
                <td width="1%">:</td>
                <td>{{ $peserta->pekerjaan_ibu }}</td>
            </tr>
            <tr>
                <td width="27%">c. &ensp; Nomor Telepon Ibu</td>
                <td width="1%">:</td>
                <td>{{ $peserta->no_hp_ibu }}</td>
            </tr>
        </table>

         {{-- Jenis Beasiswa --}}
        <span>C.</span> &ensp; Jenis Beasiswa
        <div style="margin-left: 32px;">1. Akademik</div>
        <table style="margin-left: 64px;" width="100%">
            <tr>
                <td width="27%">a. &ensp; Kelas / Semester / Peringkat</td>
                <td width="1%">:</td>
                <td>@if ($peserta->akademik !== null)
                    {{ $peserta->akademik['kelas'] }} {{ $peserta->akademik['kelas'] ? '-' : '' }}
                    {{ $peserta->akademik['semester'] }} {{ $peserta->akademik['semester'] ? '-' : '' }}
                    {{ $peserta->akademik['peringkat'] }}
                @endif</td>
            </tr>

            <tr>
                <td width="27%">b. &ensp; Hafidz / Hafidzoh</td>
                <td width="1%">:</td>
                <td>@if ($peserta->akademik)
                    {{ $peserta->akademik['hafidz'] }}
                @endif</td>
            </tr>
        </table>

        <div style="margin-left: 32px;">2. Non Akademik</div>
        <table style="margin-left: 64px;" width="100%">
            <tr>
                <td width="27%">a. &ensp; Jenis Lomba</td>
                <td width="1%">:</td>
                <td>{{ optional($peserta->non_akademik)['jenis_lomba'] }}</td>
            </tr>
            <tr>
                <td width="27%">b. &ensp; Juara ke</td>
                <td width="1%">:</td>
                <td>{{ optional($peserta->non_akademik)['juara_ke'] }}</td>
            </tr>
            <tr>
                <td width="27%">c. &ensp; Tingkat</td>
                <td width="1%">:</td>
                <td>{{ optional($peserta->non_akademik)['tingkat'] }}</td>
            </tr>
        </table>

        <div style="margin-left: 32px;">3. Rekomendasi</div>
        <table style="margin-left: 64px;" width="100%">
            <tr>
                <td width="27%">a. &ensp; Rekomendasi MWC</td>
                <td width="1%">:</td>
                <td>{{ $peserta->Rekomendasi_mwc ? 'Ya' : '' }}</td>
            </tr>
        </table>

        <span>D.</span> &ensp; Informasi Pendaftaran
        <table style="margin-left: 32px;" width="100%">
            <tr>
                <td width="29.6%">1. &ensp; Saran Mendaftar Dari</td>
                <td width="1%">:</td>
                <td>{{ $peserta->saran_dari }}</td>
            </tr>
        </table>

        <div class="row">
            <div class="col-md-6">

            </div>
            <div class="col-md-6">
                <div class="text-center mt-5 pr-10">
                    <strong>Karanganyar, {{ $peserta->created_at->translatedFormat('d F Y') }}</strong>
                </div>
            </div>

            <div class="col-md-12 mt-1">

            </div>

            <div class="col-md-6 text-center"> Panitia PPDB</div>
            <div class="col-md-6 text-center"> Calon Peserta Didik </div>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
            <div class="col-md-6 text-center"> ( {{ auth()->user()->name }} )</div>
            <div class="col-md-6 text-center"> ( {{ $peserta->nama_lengkap }} ) </div>
        </div>
    </div>
