@extends('layouts.pdf')

@section('title', 'Cetak Kartu')

@section('content')

<div class="row">
@foreach ($pesertappdb as $peserta)

        <div class="col-md-5 m-3" style="border: 3px solid black; border-radius: 10px;">
            @include('pdf.parts.kartu-pendaftaran', ['peserta' => $peserta])
        </div>
@endforeach
    </div>

@endsection
