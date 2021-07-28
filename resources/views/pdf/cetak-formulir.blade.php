@extends('layouts.pdf')

@section('title', 'Cetak Formulir')
@inject('carbon', 'Carbon\Carbon')

@section('content')

@foreach ($pesertappdb as $peserta)
<div style="page-break-after: always">
    @include('pdf.parts.formulir-pendaftaran', [
        'peserta' => $peserta,
        'carbon' => $carbon,
    ])
</div>
@endforeach
@endsection
