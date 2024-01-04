
<div class="bg-teal-200">

    <main class="max-w-screen-xl mx-auto px-5 grid lg:grid-cols-2 place-items-center pt-3 pb-8 md:pb-0 md:pt-8">
      <div class="md:order-1 block" data-aos="fade-left" data-aos-duration="1000" data-aos-easing="linear" data-aos-offset="70">
        <img
          src='/img/siswa-1.png'
          alt="siswa"
          class="w-full max-w-md mx-auto p-5 md:p-0"
        />
      </div>
      <div data-aos="fade-right" data-aos-duration="1000" data-aos-easing="linear" data-aos-offset="70">
        <h1 class="text-5xl lg:text-6xl xl:text-7xl font-bold lg:tracking-tight">
          Penerimaan Peserta Didik Baru
        </h1>
        <p class="text-lg mt-4 text-slate-600 max-w-xl">
            Telah dibuka penerimaan peserta didik baru. Tahun Ajaran {{ now()->year }}/{{ now()->addYear()->year }}.
        </p>
        <p class="text-xl font-bold underline">
            SMK Diponegoro Karanganyar
        </p>
        <div class="mt-6 flex flex-col sm:flex-row gap-3">
          <x-ui.link
            href="/formulir"
            target="_blank"
            rel="noopener">
                Pendaftaran
                 <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </x-ui.link
          >
          <x-ui.link
            size="lg"
            style="outline"
            rel="noopener"
            href="https://drive.google.com/file/d/17zamo0Rg6KE4Y283BSQfJ7HohjHx_jeq/view?usp=sharing"
            target="_blank">Unduh Brosur</x-ui.link
          >
        </div>
      </div>
    </main>
</div>
