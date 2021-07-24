@extends('layouts.pdf')

@section('title', 'Cetak Kwitansi')

@section('content')

@foreach ($pesertappdb->kwitansi as $kwitansi)
<div style="display: block; margin-bottom:66px;">
    @include('pdf.parts.kwitansi', ['kwitansi' => $kwitansi])
</div>
@endforeach

@endsection
