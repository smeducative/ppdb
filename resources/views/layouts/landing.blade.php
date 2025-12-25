<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - SPMB, Sistem Penerimaan Murid Baru SMK Diponegoro Karanganyar</title>
    {{-- description --}}
    <meta name="description" content="@yield('description')">
    {{-- meta open graph --}}
    <meta property="og:title" content="@yield('title') - SPMB, Sistem Penerimaan Murid Baru SMK Diponegoro Karanganyar" />
    <meta property="og:description" content="@yield('description')" />
    <meta property="og:image" content="{{ url('/img/smedip2022-large.jpg') }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="SPMB, Sistem Penerimaan Murid Baru SMK Diponegoro Karanganyar" />
    <meta property="og:locale" content="id_ID" />
    <link rel="shortcut icon" href="/img/logo.png" type="image/png">

    @vite(["resources/css/app.css", "resources/js/app.js"])
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Poppins" media="all">
	<link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @yield('head')
</head>
<body style="font-family: Poppins; scroll-behavior: smooth;">

    @yield('content')

<!-- Section 5 -->
<footer class="bg-red-800 text-white px-5 py-12">
    <div class="max-w-screen-xl mx-auto">

        {{-- logo --}}
        <div class="flex flex-col md:flex-row md:items-center mb-5">
            <div class="mb-5">
                <img src="/img/logo.png" alt="logo" class="h-16 object-cover block">
            </div>
            <div class="ml-3">
                <h1 class="text-xl font-bold">SMK Diponegoro Karanganyar</h1>
                <p class="text-sm">Jl. Raya Karanganyar KM 1.5, Kec. Kayugeritan, Kab. Pekalongan <br> Jawa Tengah 51182</p>
            </div>
        </div>

        <div class="mt-12 text-sm">
            &copy; {{ now()->year }}
            SMK Diponegoro Karanganyar
        </div>
    </div>
</footer>

	<script>
  AOS.init();
</script>

@yield('footer')

</body>
</html>
