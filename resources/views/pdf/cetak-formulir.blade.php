@extends('layouts.pdf')

@section('title', 'Cetak Formulir')


@section('content')

@foreach ($pesertappdb as $peserta)
<div style="page-break-after: always">
    @include('pdf.parts.formulir-pendaftaran')
</div>
@endforeach
@endsection
