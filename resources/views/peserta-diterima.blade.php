@extends('layouts.landing')

@inject('setting', 'App\Models\PpdbSetting')
@inject('carbon', 'Carbon\Carbon')

@section('title', 'Daftar peserta diterima tahun ' . now()->year)

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
      <a class="px-4 py-2 mt-2 text-sm font-semibold  rounded-lg dark-mode:bg-gray-700 dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="/">Home</a>
      <a class="px-4 py-2 mt-2 text-sm font-semibold text-gray-900 bg-gray-200 bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 md:ml-4 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="/formulir">Formulir Pendaftaran</a>
      {{-- <a class="px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 md:ml-4 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="#">Tempat Belajar</a>
      <a class="px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 md:ml-4 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="#">FAQ</a> --}}
    </nav>
  </div>
</div>

<!-- section 1 -->

<section class="py-20 bg-gray-50" id="tempat-belajar" data-aos="zoom-in" data-aos-duration="1200" data-aos-offset="10">
    <!-- This example requires Tailwind CSS v2.0+ -->
    <div class="container items-center max-w-6xl px-4 mx-auto sm:px-20 md:px-32 lg:px-16">

        <h2 class="h2">Hasil Seleksi PPDB</h2>
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
