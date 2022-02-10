@extends('layouts.pdf')

@section('title', 'Cetak Kartu')

@section('content')

@foreach ($pesertappdb as $peserta)

        @if($loop->iteration % 6 == 1)
            <div class="row" style="page-break-after: always;">
        @endif

                <div class="col-md-6">
                    <div class="p-2 mb-3" style="border: 3px solid black; border-radius: 10px;">
                    @include('pdf.parts.kartu-pendaftaran', ['peserta' => $peserta])
                    </div>
                </div>

        @if($loop->iteration % 6 == 0)
            </div>
        @endif

@endforeach

@endsection

@section('head')
    <style>
        @page {
            size: A4;
            margin: 0;
        }
    </style>
@endsection
