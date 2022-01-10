@extends('layouts.landing')

@section('title', 'Penerimaan Peserta Didik Baru ' . now()->year . '/' . now()->addYear()->year)
@section('description', 'Telah dibuka penerimaan peserta didik baru. Tahun Ajaran ' . now()->year . '/' . now()->addYear()->year)

@section('content')

<!-- Section 1 -->
<div class="w-full text-gray-700 bg-white dark-mode:text-gray-200 dark-mode:bg-gray-800" data-aos="fade-down">
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
      <a class="px-4 py-2 mt-2 text-sm font-semibold text-gray-900 bg-gray-200 rounded-lg dark-mode:bg-gray-700 dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="#hero">Home</a>
      <a class="px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 md:ml-4 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="#kejuruan">Kejuruan</a>
      <a class="px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 md:ml-4 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="#tempat-belajar">Tempat Belajar</a>
      <a class="px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 md:ml-4 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="#">FAQ</a>
    </nav>
  </div>
</div>

<!-- Section 2 -->
<section class="relative px-2 py-16 xl:py-44 bg-green-100 md:px-0 object-cover" id="hero" data-aos="fade-right" data-aos-duration="1000" data-aos-easing="linear" data-aos-offset="70"  style="background-image: url(/img/smedip2022-large.jpg); background-repeat: no-repeat; background-size: 100%;object-fit: cover; backdrop-filter: blur(6px)">
  <div class="absolute inset-0 filter backdrop-blur-sm xl:backdrop-blur-md bg-black bg-opacity-10"></div>
  <div class="relative container items-center max-w-6xl px-5 md:px-8 mx-auto xl:px-5">
    <div class="flex flex-wrap items-center sm:-mx-3">
      <div class="w-full md:px-3">
        <div class="w-full pb-6 space-y-6 md:space-y-4 lg:space-y-8 xl:space-y-9 sm:pr-5 lg:pr-0 md:pb-0">
          <h1 class="flex flex-col text-xl font-extrabold tracking-tight text-gray-900 sm:text-5xl md:text-4xl lg:text-5xl xl:text-6xl bg-black bg-opacity-20 rounded-xl p-3">
            <div class="block xl:inline text-white">Penerimaan Peserta Didik Baru</div>
            <div class="block text-green-500 xl:inline">SMK Diponegoro Karanganyar</div>
          </h1>
          {{-- <p class="mx-auto text-base text-gray-500 sm:max-w-md lg:text-xl md:max-w-3xl">Belajar tak pernah semenyenangkan ini setelah bergabung dengan smedip.</p> --}}
          <div class="relative flex flex-col sm:flex-row sm:space-x-4">
            <a href="/formulir" class="flex items-center w-full px-6 py-3 mb-3 text-lg text-white bg-green-500 sm:mb-0 hover:bg-green-600 sm:w-auto rounded">
              Pendaftaran PPDB
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </a>
            <a href="{{ route('daftar.peserta.diterima') }}" class="flex items-center px-6 py-3 text-gray-500 bg-gray-100 hover:bg-gray-200 hover:text-gray-600 rounded">
              Alur dan Persyaratan
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Section 3 -->
<section class="w-full bg-white pt-7 pb-7 md:py-10" id="kejuruan" data-aos="fade-right">
    <div class="box-border flex flex-col items-center content-center px-8 mx-auto leading-6 text-black border-0 border-gray-300 border-solid md:flex-row max-w-7xl lg:px-16">

        <!-- Image -->
        <div class="box-border relative w-full max-w-md px-4 mt-5 mb-4 -ml-5 text-center bg-no-repeat bg-contain border-solid md:ml-0 md:mt-0 md:max-w-none lg:mb-0 md:w-1/2 xl:pl-10">
            <img src="https://cdn.devdojo.com/images/december2020/productivity.png" class="p-2 pl-6 pr-5 xl:pl-16 xl:pr-20 ">
        </div>

        <!-- Content -->
        <div class="box-border order-first w-full text-black border-solid md:w-1/2 md:pl-10 md:order-none">
            <h2 class="m-0 text-xl font-semibold leading-tight border-0 border-gray-300 lg:text-3xl md:text-2xl">
                Kejuruan
            </h2>
            <p class="pt-4 pb-8 m-0 leading-7 text-gray-700 border-0 border-gray-300 sm:pr-12 xl:pr-32 lg:text-lg">
                SMK Diponegoro Karanganyar mempunyai 4 Kompetensi Keahlian
            </p>
            <ul class="p-0 m-0 leading-6 border-0 border-gray-300">
                <li class="box-border relative py-1 pl-0 text-left text-gray-500 border-solid">
                    <span class="inline-flex items-center justify-center w-6 h-6 mr-2 text-white bg-green-400 rounded-full"><span class="text-sm font-bold">✓</span></span> Teknik Komputer dan Jaringan
                </li>
                <li class="box-border relative py-1 pl-0 text-left text-gray-500 border-solid">
                    <span class="inline-flex items-center justify-center w-6 h-6 mr-2 text-white bg-green-400 rounded-full"><span class="text-sm font-bold">✓</span></span> Teknik Bisnis Sepeda Motor
                </li>
                <li class="box-border relative py-1 pl-0 text-left text-gray-500 border-solid">
                    <span class="inline-flex items-center justify-center w-6 h-6 mr-2 text-white bg-green-400 rounded-full"><span class="text-sm font-bold">✓</span></span> Agribisnis Tanaman Pangan dan Holtikultura
                </li>
                <li class="box-border relative py-1 pl-0 text-left text-gray-500 border-solid">
                    <span class="inline-flex items-center justify-center w-6 h-6 mr-2 text-white bg-green-400 rounded-full"><span class="text-sm font-bold">✓</span></span> Broadcasting dan Film
                </li>
            </ul>
        </div>
        <!-- End  Content -->
    </div>
</section>

<!-- Section 4 -->
<section class="py-20 bg-gray-50" id="tempat-belajar" data-aos="zoom-in" data-aos-duration="1200" data-aos-offset="10">
  <div class="container items-center max-w-6xl px-4 mx-auto sm:px-20 md:px-32 lg:px-16">
    <div class="flex flex-wrap items-center -mx-3">
      <div class="order-1 w-full px-3 lg:w-1/2 lg:order-0">
        <div class="w-full lg:max-w-md">
          <h2 class="mb-4 text-3xl font-bold leading-tight tracking-tight sm:text-4xl font-heading">Tempat yang nyaman untuk belajar dan berbagi!</h2>
         <!-- <p class="mb-4 font-medium tracking-tight text-gray-400 xl:mb-6">Belajar di smedip sangatlah nyaman dan lebih leluasa untuk bekerja sama dengan teman.</p> -->
          <ul>
            <li class="flex items-center py-2 space-x-4 xl:py-3">
              <svg class="w-8 h-8 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path></svg>
              <span class="font-medium text-gray-500">Tempat yang pas untuk belajar.</span>
            </li>
            <li class="flex items-center py-2 space-x-4 xl:py-3">
              <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
              <span class="font-medium text-gray-500">Belajar kapanpun.</span>
            </li>
            <li class="flex items-center py-2 space-x-4 xl:py-3">
              <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
              <span class="font-medium text-gray-500">Modern dan unggul</span>
            </li>
          </ul>
        </div>
      </div>
      <div class="w-full px-3 mb-12 lg:w-1/2 order-0 lg:order-1 lg:mb-0"><img class="mx-auto sm:max-w-sm lg:max-w-full" src="https://cdn.devdojo.com/images/november2020/feature-graphic.png" alt="feature image"></div>
    </div>
  </div>
</section>
@endsection

@section('footer')
    <script>
        function nav() {
            let nav = document.getElementById('nav')

            nav.classList.toggle('hidden')

        }
    </script>
@endsection
