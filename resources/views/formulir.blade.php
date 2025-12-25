@extends('layouts.landing')

@inject('jurusan', 'App\Models\Jurusan')

@section('title', 'Formulir Pendaftaran')

@section('content')
    {{-- header --}}

    <!-- Section 1 -->
    <!-- Section 1 -->
    <div class="dark-mode:text-gray-200 dark-mode:bg-gray-800 w-full bg-white text-gray-700">
        <div x-data="{ open: false }"
            class="mx-auto flex max-w-screen-xl flex-col px-4 md:flex-row md:items-center md:justify-between md:px-6 lg:px-8">
            <div class="flex flex-row items-center justify-between p-4">
                <a href="/"
                    class="dark-mode:text-white focus:shadow-outline rounded-lg text-lg font-semibold uppercase tracking-widest text-gray-900 focus:outline-none">SPMB, Sistem Penerimaan Murid Baru
                    Smedip</a>
                <button class="focus:shadow-outline rounded-lg focus:outline-none md:hidden" @click="open = !open">
                    <svg fill="currentColor" viewBox="0 0 20 20" class="h-6 w-6">
                        <path x-show="!open" fill-rule="evenodd"
                            d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z"
                            clip-rule="evenodd"></path>
                        <path x-show="open" fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <nav :class="{ 'flex': open, 'hidden': !open }"
                class="hidden flex-grow flex-col pb-4 md:flex md:flex-row md:justify-end md:pb-0">
                <a class="dark-mode:bg-gray-700 dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 focus:shadow-outline mt-2 rounded-lg px-4 py-2 text-sm font-semibold hover:bg-gray-200 hover:text-gray-900 focus:bg-gray-200 focus:text-gray-900 focus:outline-none md:mt-0"
                    href="/">Home</a>
                <a class="dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 focus:shadow-outline mt-2 rounded-lg bg-gray-200 bg-transparent px-4 py-2 text-sm font-semibold text-gray-900 hover:bg-gray-200 hover:text-gray-900 focus:bg-gray-200 focus:text-gray-900 focus:outline-none md:ml-4 md:mt-0"
                    href="/formulir">Formulir Pendaftaran</a>
                {{-- <a class="px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 md:ml-4 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="#">Tempat Belajar</a>
      <a class="px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 md:ml-4 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="#">FAQ</a> --}}
            </nav>
        </div>
    </div>

    <section class="mx-auto max-w-6xl bg-yellow-500" data-aos="zoom-out" data-aos-duration="1200" data-aos-offset="10">
        <img src="https://lh3.googleusercontent.com/pw/AP1GczMenXq1bXZpSufQO-SZnVbfsu28elUC6JV45DuVKMVYHuTb1ySXr7Sw8qiaiN_8kpE1Dn4r1BXQpglMePUqGoqLVBdeNSp4caD6JaYuT5VIJxcpPCw=w2400"
            alt="smedip ppdb banner 2022" class="w-full">
    </section>

    <section class="mx-auto mt-10 max-w-6xl p-5">

        @if (session('success'))
            <div class="mb-10 border-l-2 border-green-700 bg-green-100 px-4 py-5 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <h2 class="text-2xl font-bold">Formulir SPMB</h2>
        <p class="text-base">Isi formulir di bawah sesuai dengan data dirimu</p>
    </section>

    <section class="w-full bg-gray-100 py-12">
        <form action="{{ route('ppdb.mendaftar') }}" method="POST">
            @csrf
            <div class="mx-auto max-w-6xl bg-gray-100 py-5">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        {{-- step 1 - data diri --}}
                        <div class="px-5">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Identitas Diri</h3>
                            <p class="mt-1 text-sm text-gray-600">
                                Informasi tentang data diri peserta.
                            </p>
                        </div>
                    </div>
                    <div class="mt-5 px-0 md:col-span-2 md:mt-0 md:px-4">
                        <div class="shadow sm:overflow-hidden sm:rounded-md">

                            {{-- step 1 - identitas peserta --}}
                            <div class="space-y-6 rounded border border-gray-300 bg-white p-6 shadow md:px-4 md:py-5">

                                {{-- Nama lengkap --}}
                                <div class="grid">
                                    <div class="col-span-3 sm:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700">
                                            Nama Lengkap <span class="text-red-600">* wajib diisi</span>
                                        </label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <input type="text" name="nama_lengkap"
                                                class="block w-full flex-1 rounded-none rounded-r-md border-gray-300 focus:border-red-500 focus:ring-red-500 sm:text-sm"
                                                placeholder="Nama lengkap sesuai Ijazah" required>
                                        </div>
                                        <p class="mt-2 text-sm text-gray-500">
                                            Nama lengkap peserta sesuai yang tercantum di Ijazah
                                        </p>
                                    </div>
                                </div>

                                {{-- Jenis Kelamin --}}

                                <fieldset>
                                    <div>
                                        <legend class="text-base font-medium text-gray-900">Jenis Kelamin <span
                                                class="text-red-600">* wajib diisi</span></legend>
                                    </div>
                                    <div class="mt-4 space-y-4">
                                        <div class="flex items-center">
                                            <input name="jenis_kelamin" type="radio"
                                                class="h-4 w-4 border-gray-300 text-red-600 focus:ring-red-500"
                                                value="l" checked="checked">
                                            <label class="ml-3 block text-sm font-medium text-gray-700">
                                                Laki-laki
                                            </label>
                                        </div>
                                        <div class="flex items-center">
                                            <input name="jenis_kelamin" type="radio"
                                                class="h-4 w-4 border-gray-300 text-red-600 focus:ring-red-500"
                                                value="p">
                                            <label class="ml-3 block text-sm font-medium text-gray-700">
                                                Perempuan
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>
                                {{-- Tempat Lahir --}}
                                <div class="grid">
                                    <div class="col-span-3 sm:col-span-2">
                                        <label for="company-website" class="block text-sm font-medium text-gray-700">
                                            Tempat Lahir <span class="text-red-600">* wajib diisi</span>
                                        </label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <input type="text" name="tempat_lahir"
                                                class="block w-full flex-1 rounded-none rounded-r-md border-gray-300 focus:border-red-500 focus:ring-red-500 sm:text-sm"
                                                placeholder="Tempat lahir" required>
                                        </div>
                                        <p class="mt-2 text-sm text-gray-500">
                                            Tempat Lahir Peserta
                                        </p>
                                    </div>
                                </div>

                                {{-- Tanggal Lahir --}}
                                <div class="grid">
                                    <div class="col-span-3 sm:col-span-2">
                                        <label for="company-website" class="block text-sm font-medium text-gray-700">
                                            Tanggal Lahir <span class="text-red-600">* wajib diisi</span>
                                        </label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <input type="text"
                                                class="block w-full flex-1 rounded-none rounded-r-md border-gray-300 focus:border-red-500 focus:ring-red-500 sm:text-sm"
                                                data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy"
                                                placeholder="dd-mm-yyyy" name="tanggal_lahir" data-mask required>
                                        </div>
                                        <p class="mt-2 text-sm text-gray-500">
                                            Tanggal Lahir Peserta
                                        </p>
                                    </div>
                                </div>

                                {{-- nik --}}
                                <div class="grid">
                                    <div class="col-span-3 sm:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700">
                                            NIK <span class="text-red-600">* wajib diisi</span>
                                        </label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <input type="number" name="nik"
                                                class="block w-full flex-1 rounded-none rounded-r-md border-gray-300 focus:border-red-500 focus:ring-red-500 sm:text-sm"
                                                placeholder="NIK" required>
                                        </div>
                                        <p class="mt-2 text-sm text-gray-500">
                                            16 angka NIK sesuai yang tercantum di KK
                                        </p>
                                    </div>
                                </div>

                                {{-- nisn --}}
                                <div class="grid">
                                    <div class="col-span-3 sm:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700">
                                            NISN
                                        </label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <input type="number" name="nisn"
                                                class="block w-full flex-1 rounded-none rounded-r-md border-gray-300 focus:border-red-500 focus:ring-red-500 sm:text-sm"
                                                placeholder="NISN">
                                        </div>
                                        <p class="mt-2 text-sm text-gray-500">
                                            NISN Peserta
                                        </p>
                                    </div>
                                </div>

                                {{-- alamat lengkap --}}
                                <div class="grid">
                                    <div class="col-span-3 sm:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700">
                                            Alamat Lengkap <span class="text-red-600">* wajib diisi</span>
                                        </label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <textarea
                                                class="block w-full flex-1 rounded-none rounded-r-md border-gray-300 focus:border-red-500 focus:ring-red-500 sm:text-sm"
                                                placeholder="Alamat lengkap sesuai KK" name="alamat_lengkap" required></textarea>
                                        </div>
                                        <p class="mt-2 text-sm text-gray-500">
                                            Alamat Lengkap Peserta, lihat di KK
                                        </p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-3 gap-6">
                                    <div class="col-span-3 sm:col-span-1">
                                        <label for="dukuh"
                                            class="block text-sm font-medium text-gray-700">Dukuh</label>
                                        <input type="text" name="dukuh" id="dukuh" autocomplete="dukuh"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm"
                                            placeholder="Dukuh">
                                    </div>

                                    <div class="col-span-3 sm:col-span-1">
                                        <label for="rt" class="block text-sm font-medium text-gray-700">RT</label>
                                        <input type="text" name="rt" id="rt" autocomplete="rt"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm"
                                            placeholder="RT">
                                    </div>

                                    <div class="col-span-3 sm:col-span-1">
                                        <label for="rw" class="block text-sm font-medium text-gray-700">RW</label>
                                        <input type="text" name="rw" id="rw" autocomplete="rw"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm"
                                            placeholder="RW">
                                    </div>

                                    <div class="col-span-3 sm:col-span-1">
                                        <label for="desa_kelurahan"
                                            class="block text-sm font-medium text-gray-700">Desa/Kelurahan</label>
                                        <input type="text" name="desa_kelurahan" id="desa_kelurahan"
                                            autocomplete="desa_kelurahan"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm"
                                            placeholder="Desa/Kelurahan">
                                    </div>

                                    <div class="col-span-3 sm:col-span-1">
                                        <label for="kecamatan"
                                            class="block text-sm font-medium text-gray-700">Kecamatan</label>
                                        <input type="text" name="kecamatan" id="kecamatan" autocomplete="kecamatan"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm"
                                            placeholder="Kecamatan">
                                    </div>

                                    <div class="col-span-3 sm:col-span-1">
                                        <label for="kabupaten_kota"
                                            class="block text-sm font-medium text-gray-700">Kabupaten/Kota</label>
                                        <input type="text" name="kabupaten_kota" id="kabupaten_kota"
                                            autocomplete="kabupaten_kota"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm"
                                            placeholder="Kabupaten/Kota">
                                    </div>

                                    <div class="col-span-3 sm:col-span-1">
                                        <label for="provinsi"
                                            class="block text-sm font-medium text-gray-700">Provinsi</label>
                                        <input type="text" name="provinsi" id="provinsi" autocomplete="provinsi"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm"
                                            placeholder="Provinsi">
                                    </div>

                                    <div class="col-span-3 sm:col-span-1">
                                        <label for="kode_pos" class="block text-sm font-medium text-gray-700">Kode
                                            Pos</label>
                                        <input type="text" name="kode_pos" id="kode_pos" autocomplete="kode_pos"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm"
                                            placeholder="Kode Pos">
                                    </div>
                                </div>

                                <div class="grid">

                                    <div class="col-span-6 sm:col-span-3">
                                        <label class="block text-sm font-medium text-gray-700">Pilihan Jurusan <span
                                                class="text-red-600">* wajib diisi</span></label>
                                        <select name="pilihan_jurusan"
                                            class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 shadow-sm focus:border-red-500 focus:outline-none focus:ring-red-500 sm:text-sm"
                                            required>
                                            @foreach ($jurusan->get() as $jrs)
                                                <option value="{{ $jrs->id }}"> {{ $jrs->nama }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500">
                                        Jurusan pilihan
                                    </p>
                                </div>

                                {{-- asal sekolah --}}

                                <div class="grid">
                                    <div class="col-span-3 sm:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700">
                                            Asal Sekolah <span class="text-red-600">* wajib diisi</span>
                                        </label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <select id="asal-sekolah" name="asal_sekolah"
                                                class="block w-full flex-1 rounded-none rounded-r-md border-gray-300 focus:border-red-500 focus:ring-red-500 sm:text-sm"
                                                placeholder="Asal Sekolah"></select>
                                        </div>
                                        <p class="mt-2 text-sm text-gray-500">
                                            Asal Sekolah Peserta
                                        </p>
                                    </div>
                                </div>

                                {{-- tahun lulus --}}
                                <div class="grid">
                                    <div class="col-span-3 sm:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700">
                                            Tahun Lulus <span class="text-red-600">* wajib diisi</span>
                                        </label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <select name="tahun_lulus"
                                                class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 shadow-sm focus:border-red-500 focus:outline-none focus:ring-red-500 sm:text-sm"
                                                required>
                                                @for ($i = now()->year; $i >= 2015; $i--)
                                                    <option value="{{ $i }}"> {{ $i }} </option>
                                                @endfor
                                            </select>
                                        </div>
                                        <p class="mt-2 text-sm text-gray-500">
                                            tahun Lulus Peserta
                                        </p>
                                    </div>
                                </div>

                                {{-- Penerima KIP --}}
                                <div class="grid">
                                    <div class="col-span-3 sm:col-span-2">
                                        <div class="flex items-start">
                                            <div class="flex h-5 items-center">
                                                <input name="penerima_kip" type="checkbox"
                                                    class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-500"
                                                    id="pkip" onclick='fkip()'>
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="comments" class="font-medium text-gray-700">Penerima
                                                    KIP</label>
                                                <p class="text-gray-500">Merupakan peserta Penerima KIP.</p>
                                            </div>
                                        </div>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <input type="text" name="no_kip"
                                                class="block w-full flex-1 rounded-none rounded-r-md border-gray-300 focus:border-red-500 focus:ring-red-500 disabled:cursor-not-allowed disabled:bg-gray-500 disabled:opacity-20 sm:text-sm"
                                                id="input-kip" placeholder="No. KIP" disabled>
                                        </div>
                                        <p class="mt-2 text-sm text-gray-500">
                                            No. KIP
                                        </p>
                                    </div>
                                </div>


                                {{-- Nomer HP --}}
                                <div class="grid">
                                    <div class="col-span-3 sm:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700">
                                            No. HP <span class="text-red-600">* wajib diisi</span>
                                        </label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <input type="number" name="no_hp"
                                                class="block w-full flex-1 rounded-none rounded-r-md border-gray-300 focus:border-red-500 focus:ring-red-500 sm:text-sm"
                                                placeholder="No. HP" required>
                                        </div>
                                        <p class="mt-2 text-sm text-gray-500">
                                            No. HP Peserta
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-span-3 p-3"></div>
                    {{-- step 2 --}}
                    <div class="md:col-span-1">
                        {{-- step 2 - identitas orang tua --}}
                        <div class="px-5" x-show="step === 2" x-transition>
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Identitas Orang Tua</h3>
                            <p class="mt-1 text-sm text-gray-600">
                                Informasi data orang tua peserta.
                            </p>
                        </div>
                    </div>
                    <div class="mt-5 px-0 md:col-span-2 md:mt-0 md:px-4">

                        {{-- step 2 - identitas orang tua --}}
                        <div x-show="step === 2" x-transition
                            class="space-y-6 rounded border border-gray-300 bg-white p-6 shadow md:px-4 md:py-5">
                            <div class="grid grid-cols-6 gap-6">

                                {{-- identitas ayah --}}
                                <div class="col-span-6 sm:col-span-3">
                                    <label class="block text-sm font-medium text-gray-700">Nama Ayah <span
                                            class="text-red-600">* wajib diisi</span></label>
                                    <input type="text" name="nama_ayah"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm"
                                        placeholder="Nama lengkap Ayah" required>
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label class="block text-sm font-medium text-gray-700">No. HP Ayah</label>
                                    <input type="text" name="no_ayah"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm"
                                        placeholder="No. HP Ayah">
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label class="block text-sm font-medium text-gray-700">Pekerjaan Ayah</label>
                                    <input type="text" name="pekerjaan_ayah"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm"
                                        placeholder="Pekerjaan Ayah">
                                </div>

                                <div class="col-span-6 sm:col-span-3"></div>

                                {{-- idntitas ibu --}}
                                <div class="col-span-6 sm:col-span-3">
                                    <label class="block text-sm font-medium text-gray-700">Nama Ibu <span
                                            class="text-red-600">* wajib diisi</span></label>
                                    <input type="text" name="nama_ibu"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm"
                                        placeholder="Nama Ibu" required>
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label class="block text-sm font-medium text-gray-700">No. HP Ibu</label>
                                    <input type="text" name="no_ibu"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm"
                                        placeholder="No. HP Ibu">
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label class="block text-sm font-medium text-gray-700">Pekerjaan Ibu</label>
                                    <input type="text" name="pekerjaan_ibu"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm"
                                        placeholder="Pekerjaan Ibu">
                                </div>


                            </div>

                        </div>
                    </div>
                    {{-- end: step 2 --}}

                    <div class="col-span-3 p-3"></div>
                    {{-- step 3 --}}
                    <div class="md:col-span-1">
                        {{-- step 3 - Jenis beasiswa --}}
                        <div class="px-5">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Jenis Beasiswa / Prestasi</h3>
                            <p class="mt-1 text-sm text-gray-600">
                                Jenis beasiswa peserta. diisi jika peserta memiliki beasiswa atau prestasi.
                            </p>
                        </div>
                        {{-- end step --}}
                    </div>
                    <div class="mt-5 px-0 md:col-span-2 md:mt-0 md:px-4">
                        {{-- tep 3 - jenis beasiswa --}}
                        <div class="space-y-6 rounded border border-gray-300 bg-white p-6 shadow md:px-4 md:py-5">

                            <div>

                                <div class="text-xl font-bold">
                                    <h3>Akademik</h3>
                                </div>


                                <div class="mb-5 grid">
                                    <div class="col-span-3 sm:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700">Peringkat kelas (Apabila
                                            pernah mendapatkan peringkat 1, 2 atau 3)</label>

                                        <input type="text"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm"
                                            placeholder="kelas/semester/peringkat" name="Kelas / Semester / Peringkat">

                                        <!-- /.input group -->
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500">
                                        Contoh: Kelas 9 / Semester 1 / Peringkat 1
                                    </p>
                                </div>

                                <div class="grid">
                                    <div class="col-span-3 sm:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700">Hafidz / Hafidzoh (minimal 1
                                            juz Al-Qur'an)</label>
                                        <input type="text"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm"
                                            name="hafidz" placeholder="Contoh: juz 1" />
                                    </div>
                                </div>

                                <div class="mt-5 text-xl font-bold">
                                    <h3>Non Akademik</h3>
                                </div>

                                <div class="mb-5 grid">
                                    <div class="col-span-3 sm:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700">Jenis Lomba</label>
                                        <input type="text"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm"
                                            name="jenis_lomba" placeholder="misal: kejuaran catur" />
                                    </div>

                                </div>

                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-3">
                                        <label class="block text-sm font-medium text-gray-700">Juara ke</label>
                                        <input type="text"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm"
                                            name="juara_ke" placeholder="Juara ke" />
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label class="block text-sm font-medium text-gray-700">Tingkat</label>
                                        <select
                                            class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 shadow-sm focus:border-red-500 focus:outline-none focus:ring-red-500 sm:text-sm"
                                            id="jtingkat" style="width: 100%;" name="juara_tingkat">
                                            <option value="">-- pilih tingkat --</option>
                                            @foreach (['kabupaten/kota', 'Karesidenan', 'provinsi', 'nasional'] as $tingkat)
                                                <option value="{{ $tingkat }}">{{ $tingkat }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="text-sm text-gray-600">
                                    Kejuaraan minimal tingkat Kabupaten / kota
                                </div>

                                <div class="mt-5 text-xl font-semibold">
                                    <h3>Rekomendasi</h3>
                                </div>

                                <div class="grid">
                                    {{-- <label>Rekomendasi</label> --}}
                                    <div class="mt-4">
                                        <div class="flex items-start">
                                            <div class="flex h-5 items-center">
                                                <input name="rekomendasi_mwc" type="checkbox"
                                                    class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-500">
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="comments" class="font-medium text-gray-700">Rekomendasi
                                                    MWC</label>
                                                <p class="text-gray-500">Merupakan peserta rekomandasi MWC.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <div class="my-5 grid">
                                    <div class="col-span-3 sm:col-span-2">
                                        <label class="block text-sm font-bold text-gray-700">Saran Dari</label>
                                        <input type="text"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm"
                                            name="saran_dari" placeholder="Dapat saran siapa?" />
                                    </div>

                                </div>
                            </div> <!-- row -->

                        </div>


                        <div class="bg-gray-50 px-4 py-3 text-right sm:px-6">
                            <button
                                class="inline-flex justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                Submit
                            </button>
                        </div>

                    </div>
                    {{-- end: step 3 --}}
                </div>
            </div>

    </section>
    </form>
@endsection

@section('head')
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
@endsection

@section('footer') <!-- jQuery -->
    <script src="/plugins/jquery/jquery.min.js"></script>

    <script src="/plugins/inputmask/jquery.inputmask.min.js"></script>
    <script>
        $(document).ready(function() {
            $('[data-mask]').inputmask()

            const offlineSchoolData = [{
                    nama: "MTS MA'ARIF KARANGANYAR",
                    bentuk_pendidikan: "MTs",
                    status: "Swasta"
                },
                {
                    nama: "SMP N 1 KARANGANYAR",
                    bentuk_pendidikan: "SMP",
                    status: "Negeri"
                },
                {
                    nama: "SMP N 2 KARANGANYAR",
                    bentuk_pendidikan: "SMP",
                    status: "Negeri"
                },
                {
                    nama: "MTS YMI WONOPRINGGO",
                    bentuk_pendidikan: "MTs",
                    status: "Swasta"
                },
                {
                    nama: "SMP N 4 KAJEN",
                    bentuk_pendidikan: "SMP",
                    status: "Negeri"
                },
                {
                    nama: "SMP ISLAM WONOPRINGGO",
                    bentuk_pendidikan: "SMP",
                    status: "Swasta"
                },
                {
                    nama: "SMP N 1 WONOPRINGGO",
                    bentuk_pendidikan: "SMP",
                    status: "Negeri"
                },
                {
                    nama: "SMP ISLAM YMI WONOPRINGGO",
                    bentuk_pendidikan: "SMP",
                    status: "Swasta"
                },
                {
                    nama: "SMP SATU ATAP BRENGKOLANG",
                    bentuk_pendidikan: "SMP",
                    status: "Negeri"
                },
                {
                    nama: "SMP N 3 KAJEN",
                    bentuk_pendidikan: "SMP",
                    status: "Negeri"
                },
                {
                    nama: "MTS YAPIK KARANGANYAR",
                    bentuk_pendidikan: "MTs",
                    status: "Swasta"
                },
                {
                    nama: "MTS SYARIF HIDAYATULLAH",
                    bentuk_pendidikan: "MTs",
                    status: "Swasta"
                },
                {
                    nama: "SMP NUSANTARA GONDANG",
                    bentuk_pendidikan: "SMP",
                    status: "Swasta"
                },
                {
                    nama: "SMP NU KAJEN",
                    bentuk_pendidikan: "SMP",
                    status: "Swasta"
                },
                {
                    nama: "MTS HASBULLAH",
                    bentuk_pendidikan: "MTs",
                    status: "Swasta"
                }
            ];

            new TomSelect('#asal-sekolah', {
                valueField: 'nama',
                labelField: 'nama',
                searchField: 'nama',
                options: offlineSchoolData,
                create: true,
                // Custom search function for offline data
                score: function(search) {
                    const scoringFunction = this.getScoreFunction(search);
                    return function(item) {
                        return scoringFunction(item);
                    };
                },
                // Custom render functions remain the same
                render: {
                    option: function(item, escape) {
                        return `<div class="py-2">
                <div class="mb-1">
                    <span class="h4">${escape(item.nama)}</span>
                </div>
                <div class="text-gray-500">Bentuk Pendidikan: ${escape(item.bentuk_pendidikan)}</div>
                <div class="text-gray-500">Status: ${escape(item.status)}</div>
            </div>`;
                    },
                    item: function(item, escape) {
                        return `
            <div class="mb-1">
                <span class="h4">${escape(item.nama)}</span>
            </div>`;
                    }
                },
            });

        })

        function fkip() {
            let kip = $('#pkip:checked').length;

            if (kip) {
                $('#input-kip').prop('disabled', false)
            } else {

                $('#input-kip').prop('disabled', true)
                $('#input-kip').val('')
            }

        }
    </script>
@endsection
