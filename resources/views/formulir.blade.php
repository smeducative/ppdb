@extends('layouts.landing')

@inject('jurusan', 'App\Models\Jurusan')

@section('title', 'Formulir Pendaftaran')

@section('content')
{{-- header --}}

<!-- Section 1 -->
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
      <a class="px-4 py-2 mt-2 text-sm font-semibold text-gray-900 bg-gray-200 rounded-lg dark-mode:bg-gray-700 dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="#hero">Home</a>
      <a class="px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 md:ml-4 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="#kejuruan">Kejuruan</a>
      <a class="px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 md:ml-4 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="#">Tempat Belajar</a>
      <a class="px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 md:ml-4 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="#">FAQ</a>
    </nav>
  </div>
</div>

@if (session('success'))

@endif

<section class="mt-10 px-5 max-w-7xl mx-auto">
    <h2 class="text-2xl ont-bold">Formulir PPDB</h2>
</section>

    <section class="w-full bg-gray-50 mt-10">
        <!--
  This example requires Tailwind CSS v2.0+
-->
<div class="max-w-7xl mx-auto bg-gray-100 py-5">
  <div class="md:grid md:grid-cols-3 md:gap-6" x-data="{
    step: 1
  }" x-cloak>
    <div class="md:col-span-1">

      {{-- step 1 - data diri --}}
      <div class="px-5" x-show="step === 1" x-transition>
        <h3 class="text-lg font-medium leading-6 text-gray-900">Identitas Diri</h3>
        <p class="mt-1 text-sm text-gray-600">
          Informasi tentang data diri peserta.
        </p>
      </div>

      {{-- step 2 - identitas orang tua --}}
      <div class="px-5" x-show="step === 2" x-transition>
        <h3 class="text-lg font-medium leading-6 text-gray-900">Identitas Orang Tua</h3>
        <p class="mt-1 text-sm text-gray-600">
          Informasi data orang tua peserta.
        </p>
      </div>

      {{-- step 3 - Jenis beasiswa --}}
      <div class="px-5" x-show="step === 3" x-transition>
        <h3 class="text-lg font-medium leading-6 text-gray-900">Jenis Beasiswa</h3>
        <p class="mt-1 text-sm text-gray-600">
          Jenis beasiswa peserta.
        </p>
      </div>
      {{-- end step --}}
    </div>
    <div class="mt-5 md:mt-0 md:col-span-2 px-0 md:px-4">
      <form action="{{ route('ppdb.mendaftar') }}" method="POST">
          @csrf
        <div class="shadow sm:rounded-md sm:overflow-hidden">

          {{-- step 1 - identitas peserta --}}
          <div x-show="step === 1" x-transition class="p-6 md:px-4 md:py-5 bg-white space-y-6">

            {{-- Nama lengkap --}}
            <div class="grid">
              <div class="col-span-3 sm:col-span-2">
                <label class="block text-sm font-medium text-gray-700">
                  Nama Lengkap
                </label>
                <div class="mt-1 flex rounded-md shadow-sm">
                  <input type="text" name="nama_lengkap" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" placeholder="Nama lengkap" required>

                </div>
                 <p class="mt-2 text-sm text-gray-500">
                        Nama Lengkap Peserta
                </p>
              </div>
            </div>

            {{-- Jenis Kelamin --}}

            <fieldset>
              <div>
                <legend class="text-base font-medium text-gray-900">Jenis Kelamin</legend>
              </div>
              <div class="mt-4 space-y-4">
                <div class="flex items-center">
                  <input name="jenis_kelamin" type="radio" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" value="l" checked="checked">
                  <label class="ml-3 block text-sm font-medium text-gray-700">
                    Laki-laki
                  </label>
                </div>
                <div class="flex items-center">
                  <input name="jenis_kelamin" type="radio" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" value="p">
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
                  Tempat Lahir
                </label>
                <div class="mt-1 flex rounded-md shadow-sm">
                  <input type="text" name="tempat_lahir" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" placeholder="Tempat lahir" required>
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
                  Tanggal Lahir
                </label>
                <div class="mt-1 flex rounded-md shadow-sm">
                  <input type="text" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="tanggal_lahir" data-mask required>
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
                  NIK
                </label>
                <div class="mt-1 flex rounded-md shadow-sm">
                  <input type="number" name="nik" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" placeholder="NIK" required>
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
                  <input type="number" name="nisn" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" placeholder="NISN">
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
                  Alamat Lengkap
                </label>
                <div class="mt-1 flex rounded-md shadow-sm">
                  <textarea class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" placeholder="Alamat lengkap" name="alamat_lengkap" required></textarea>
                </div>
                <p class="mt-2 text-sm text-gray-500">
                        Alamat Lengkap Peserta
                    </p>
              </div>
            </div>

            <div class="grid">

              <div class="col-span-6 sm:col-span-3">
                <label class="block text-sm font-medium text-gray-700">Pilihan Jurusan</label>
                <select name="pilihan_jurusan" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                  @foreach($jurusan->get() as $jrs)
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
                  Asal Sekolah
                </label>
                <div class="mt-1 flex rounded-md shadow-sm">
                  <input type="text" name="asal_sekolah" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" placeholder="Asal Sekolah">
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
                  Tahun Lulus
                </label>
                <div class="mt-1 flex rounded-md shadow-sm">
                    <select name="tahun_lulus" autocomplete="country" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @for($i = now()->year; $i >= 2015; $i--)
                        <option value="{{ $i }}"> {{ $i }} </option>
                    @endfor
                    </select>
                 </div>
                  <p class="mt-2 text-sm text-gray-500">
                        tahun Lulus Peserta
                    </p>
              </div>
            </div>


            {{-- Nomer HP --}}
            <div class="grid">
              <div class="col-span-3 sm:col-span-2">
                <label class="block text-sm font-medium text-gray-700">
                  No. HP
                </label>
                <div class="mt-1 flex rounded-md shadow-sm">
                  <input type="number" name="nisn" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" placeholder="No. HP">
                </div>
                 <p class="mt-2 text-sm text-gray-500">
                        No. HP Peserta
                    </p>
              </div>
            </div>

          </div>

          {{-- step 2 - identitas orang tua --}}
          <div x-show="step === 2" x-transition class="p-6 md:px-4 md:py-5 bg-white space-y-6">
            <div class="grid grid-cols-6 gap-6">

              {{-- identitas ayah --}}
              <div class="col-span-6 sm:col-span-3">
                <label class="block text-sm font-medium text-gray-700">Nama Ayah</label>
                <input type="text" name="nama_ayah" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="Nama lengkap Ayah" required>
              </div>

              <div class="col-span-6 sm:col-span-3">
                <label class="block text-sm font-medium text-gray-700">No. HP Ayah</label>
                <input type="text" name="no_ayah" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="No. HP Ayah">
              </div>

              <div class="col-span-6 sm:col-span-3">
                <label class="block text-sm font-medium text-gray-700">Pekerjaan Ayah</label>
                <input type="text" name="pekerjaan_ayah" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="Pekerjaan Ayah">
              </div>

              <div class="col-span-6 sm:col-span-3"></div>

              {{-- idntitas ibu --}}
              <div class="col-span-6 sm:col-span-3">
                <label class="block text-sm font-medium text-gray-700">Nama Ibu</label>
                <input type="text" name="nama_ibu" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="Nama Ibu" required>
              </div>

              <div class="col-span-6 sm:col-span-3">
                <label class="block text-sm font-medium text-gray-700">No. HP Ibu</label>
                <input type="text" name="no_ibu" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="No. HP Ibu">
              </div>

              <div class="col-span-6 sm:col-span-3">
                <label class="block text-sm font-medium text-gray-700">Pekerjaan Ibu</label>
                <input type="text" name="pekerjaan_ibu" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="Pekerjaan Ibu">
              </div>


            </div>

          </div>

          {{-- tep 3 - jenis beasiswa --}}
          <div x-show="step === 3" x-transition class="p-6 md:px-4 md:py-5 bg-white space-y-6">

            <div>

                <div class="font-bold text-xl">
                    <h3>Akademik</h3>
                </div>


                <div class="grid mb-5">
                    <div class="col-span-3 sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Ranking</label>

                        <input type="text" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" data-inputmask='"mask": "9/9/9"' placeholder="kelas/semester/peringkat" name="peringkat" data-mask>
                        <!-- /.input group -->
                    </div>
                     <p class="mt-2 text-sm text-gray-500">
                        Format: kelas / semester / ranking. contoh: 7/1/1
                    </p>
                </div>

                <div class="grid">
                    <div class="col-span-3 sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Hadidz / Hafidzoh</label>
                        <input type="text" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" name="hafidz" placeholder="Hafidz / Hafidzoh"/>
                    </div>
                </div>

                <div class="font-bold text-xl mt-5">
                    <h3>Non Akademik</h3>
                </div>

                <div class="grid mb-5">
                    <div class="col-span-3 sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Jenis Lomba</label>
                        <input type="text" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" name="jenis_lomba" placeholder="misal: kejuaran catur"/>
                    </div>

                </div>

                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-3">
                        <label class="block text-sm font-medium text-gray-700">Juara ke</label>
                        <input type="text" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" name="juara_ke" placeholder="Juara ke" />
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <label class="block text-sm font-medium text-gray-700">Tingkat</label>
                        <select class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" id="jtingkat" style="width: 100%;" name="juara_tingkat" required>
                            <option value="">-- pilih tingkat --</option>
                            @foreach (['kabupaten/kota', 'provinsi', 'nasional'] as $tingkat)

                            <option value="{{ $tingkat }}">{{ $tingkat }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="font-semibold text-xl mt-5">
                    <h3>Rekomendasi</h3>
                </div>

                <div class="grid">
                    {{-- <label>Rekomendasi</label> --}}
                    <div class="mt-4">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input name="rekomendasi_mwc" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="comments" class="font-medium text-gray-700">Rekomendasi MWC</label>
                                <p class="text-gray-500">Merupakan peserta rekomandasi MWC.</p>
                            </div>
                            </div>
                    </div>
                </div>



                <div class="grid my-5">
                    <div class="col-span-3 sm:col-span-2">
                        <label class="block text-sm font-bold text-gray-700">Saran Dari</label>
                        <input type="text" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" name="saran_dari" placeholder="Dapat saran siapa?"/>
                    </div>

                </div>
            </div> <!-- row -->

          </div>


          <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
            <button x-show="step > 1" @click.prevent="step--" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-gray-700 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900">
              Previous
            </button>

            <button x-show="step < 3" @click.prevent="step++" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              Next
            </button>

            <button x-show="step === 3" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              Save
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

    </section>
@endsection

@section('footer')    <!-- jQuery -->
    <script src="/plugins/jquery/jquery.min.js"></script>

    <script src="/plugins/inputmask/jquery.inputmask.min.js"></script>
    <script>
        $(document).ready(function() {
            $('[data-mask]').inputmask()
        })
    </script>
@endsection
