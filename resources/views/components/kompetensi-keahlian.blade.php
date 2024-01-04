@inject('kompetensi', 'App\Models\Jurusan')

<div class="bg-white" data-aos="fade-up" data-aos-duration="1000" data-aos-easing="linear" data-aos-offset="70">

    <main class="max-w-screen-xl mx-auto px-5 grid lg:grid-cols-3 place-items-center pt-16 pb-8 md:pt-8 gap-6">
      <div class="md:order-0 block lg:col-span-1">
        <img
            src='/img/siswa-4-1.png'
            alt="siswa"
            class="w-full max-w-md mx-auto p-5 md:p-0 object-cover object-center"
        />
      </div>
      <div class="lg:col-span-2">
        <h1 class="text-2xl lg:text-3xl xl:text-5xl font-bold lg:tracking-tight">
          Program Keahlian
        </h1>
        <div class="text-lg mt-4 text-slate-600 max-w-xl flex flex-col">
            <p class="mb-5">
                Banyak pilihan program keahlian yang dapat dipilih sesuai dengan minat dan bakat siswa.
            </p>
            @foreach ($kompetensi->latest('id')->get() as $j)
            {{-- bullet --}}
            <div>
                <span class="text-2xl font-semibold text-slate-700">-</span>
                <span>{{ $j->nama }} ({{ $j->abbreviation }})</span>
            </div>
            @endforeach
        </div>

      </div>
    </main>
</div>
