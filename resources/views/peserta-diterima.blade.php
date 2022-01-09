@extends('layouts.landing')

@inject('setting', 'App\Models\PpdbSetting')
@inject('carbon', 'Carbon\Carbon')

@section('title', 'Alur dan Persyaratan pendaftar ' . now()->year . ' / ' . now()->addYear()->year)

@section('content')


<!-- Section 1 -->
<div class="w-full text-gray-700 bg-white dark-mode:text-gray-200 dark-mode:bg-gray-800">
  <div x-data="{ open: false }" class="flex flex-col max-w-screen-xl px-4 mx-auto md:items-center md:justify-between md:flex-row md:px-6 lg:px-8">
    <div class="p-4 flex flex-row items-center justify-between">
      <a href="/" class="text-lg font-semibold tracking-widest text-gray-900 uppercase rounded-lg dark-mode:text-white focus:outline-none focus:shadow-outline">PPDB Smedip</a>
      <button class="md:hidden rounded-lg focus:outline-none focus:shadow-outline" @click="open = !open">
        <svg fill="currentColor" viewBox="0 0 20 20" class="w-6 h-6">
          <path x-show="!open" fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z" clip-rule="evenodd"></path>
          <path x-show="open" fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
        </svg>
      </button>
    </div>
    <nav :class="{'flex': open, 'hidden': !open}" class="flex-col flex-grow pb-4 md:pb-0 hidden md:flex md:justify-end md:flex-row">
      <a class="px-4 py-2 mt-2 text-sm font-semibold  rounded-lg dark-mode:bg-gray-700 dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline"
      href="/">Home</a>
      <a class="px-4 py-2 mt-2 text-sm font-semibold text-gray-900 bg-gray-200 bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 md:ml-4 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="/formulir">Formulir Pendaftaran</a>
      {{-- <a class="px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 md:ml-4 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="#">Tempat Belajar</a>
      <a class="px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 md:ml-4 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="#">FAQ</a> --}}
    </nav>
  </div>
</div>

<section class="bg-white max-w-6xl mx-auto" data-aos="zoom-out" data-aos-duration="1200" data-aos-offset="10">
    <img src="/img/smedip-ppdb-banner-2022.png" alt="smedip ppdb banner 2022" class="w-full">
</section>

<!-- Syarat Pendaftaran -->
<section class="py-20 bg-gray-50" data-aos="zoom-in" data-aos-duration="1200" data-aos-offset="10">

    <div class="container items-center max-w-6xl px-4 mx-auto sm:px-20 md:px-32 lg:px-16 mb-10">
        <h2 class="text-xl font-bold">Alur Pendaftaran</h2>
        <div class="bg-white p-5 border-t-2 border-green-500 shadow-md rounded-md mt-3">
            <ul class="text-base">
                <li>
                    - Calon Peserta Didik baru dapat mendaftar secara mandiri melalui website <a href="//s.id/ppdbsmedip22" target="_blank" class="text-green-500">PPDB Online Smedip</a> dan mengisi formulir pendaftaran sesuai data diri peserta.
                </li>
                <li>
                    - Calon Peserta Didik baru dapat langsung datang ke <strong>SMK Diponegoro Karanganyar</strong> dengan membawa berkas persyaratan yang dibutuhkan.
                </li>
                <li>
                    - Setelah dinyatakan diterima, peserta PPDB membayar biaya daftar ulang Sebesar Rp. 150.000,-
                </li>
                <li>
                    - Berkas Pendaftaran dan Biaya Daftar Ulang diserahkan langsung ke <strong>SMK Diponegoro Karanganyar</strong>.
                </li>
                <li>
                    - Jika membutuhkan info lebih lanjut, silahkan hubungi nomor di bawah ini: <br>
                       <i> a.	Bu Widy Setyo Pratiwi, S.Pd. 	:	082221878684 </i><br>
                        <i> b.	Pak Wiwit Setiyono, S.Pd.	:	085600086994</i>
                </li>
            </ul>
        </div>
    </div>

    <div class="container items-center max-w-6xl px-4 mx-auto sm:px-20 md:px-32 lg:px-16 mb-10">
        <h2 class="text-xl font-bold">Berkas Persyaratan Pendaftar</h2>
        <div class="bg-white p-5 border-t-2 border-green-500 shadow-md rounded-md mt-3">
            <ol class="text-base">
                <li>
                    a.	Foto Diri Berwarna Ukuran 3x4 sebanyak <strong> 2 lembar</strong>
                </li>
                <li>
                    b.	Fotokopi Kartu Keluarga/KK sebanyak <strong> 2 lembar</strong>
                </li>
                <li>
                    c.	Fotokopi Akte Kelahiran sebanyak <strong> 2 lembar</strong>
                </li>
                <li>
                    d.	Fotokopi Kartu Indonesia Pintar/KIP sebanyak 2 lembar (bagi yang punya)
                </li>
                <li>
                    e.	Fotokopi Ijazah sebanyak <strong> 2 lembar</strong> (jika sudah ada/menyusul)
                </li>
                <li>
                    f.	Fotokopi Raport/Piagam/Sertifikat bagi yang pernah mendapat peringkat 1/2/3 atau juara 1/2/3 bidang akademik maupun non akademik minimal tingkat <strong> Kabupaten </strong>
                </li>
            </ol>
        </div>
    </div>

    <div class="container items-center max-w-6xl px-4 mx-auto sm:px-20 md:px-32 lg:px-16">

        <h2 class="text-xl font-bold">Hasil Seleksi PPDB</h2>
        @if (now()->gt($carbon->parse($setting->latest()->first()?->body['hasil_seleksi'] ?? now()->addDays(1))))


        <div class="mt-10 flex flex-col">
            <div class="overflow-x-auto">
                <div class="py-2 align-middle inline-block min-w-full">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama Lengkap
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Jurusan
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Asal Sekolah
            </th>
            {{-- <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Role
            </th>
            <th scope="col" class="relative px-6 py-3">
                <span class="sr-only">Edit</span>
            </th> --}}
        </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
              @forelse ((new App\Models\PesertaPPDB)->whereYear('created_at', request('tahun', now()->year))->whereDiterima(1)->get() as $peserta)

              <tr>
                <td class="px-6 py-4 whitespace-nowrap">

                  <div class="ml-4">
                    <div class="text-sm font-medium text-gray-900">
                        {{ $peserta->nama_lengkap }}
                    </div>
                    <div class="text-sm text-gray-500">
                        {{ $peserta->no_pendaftaran }}
                    </div>
                  </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">{{ $peserta->jurusan->nama }}</div>
                <div class="text-sm text-gray-500">{{ $peserta->jurusan->abbreviation }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">{{ $peserta->asal_sekolah }}</div>
                <div class="text-sm text-gray-500">{{ $peserta->tahun_lulus }}</div>
              </td>
            {{-- <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                    {{ $peserta->asal_sekolah }}
                </span>
              </td> --}}

            </tr>
              @empty
              <tr>
                  <td>belum ada peserta untuk di tampilkan</td>
              </tr>

              @endforelse

            <!-- More people... -->
          </tbody>
        </table>
    </div>
</div>
  </div>
</div>
@else
    <div class="p-5 border-t-2 border-green-600 w-full mt-5 bg-white rounded shadow">
        Hasil seleksi akan di umumkan pada <strong class="text-green-600"> {{ $carbon->parse($setting->latest()->first()->body['hasil_seleksi'])->translatedFormat('d F Y') }} </strong>
    </div>
@endif
</div>
</section>
@endsection
