@extends('layouts.pdf')

@section('title', 'Cetak Kwitansi')

@section('content')

@foreach ($kwitansi as $peserta)
<div style="display: block; margin-bottom:66px;">
    @include('pdf.parts.kwitansi', $peserta)
</div>
@endforeach

@endsection
