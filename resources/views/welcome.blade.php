@extends('layouts.landing')

@section('title', 'Penerimaan Peserta Didik Baru 2025/2026')
@section('description', 'Telah dibuka penerimaan peserta didik baru. Tahun Ajaran 2025/2026')

@inject('jurusan', 'App\Models\Jurusan')

@section('content')
{{--  --}}
<x-navbar-menu />
<x-hero />
<x-alur-dan-persyaratan />
<x-kompetensi-keahlian />
<x-fasilitas-sekolah />
<x-rincian-beasiswa />
<x-footer />
@endsection

@section('footer')
    <script>
        function nav() {
            let nav = document.getElementById('nav')

            nav.classList.toggle('hidden')

        }
    </script>
@endsection
