@extends('layouts.pdf')

@section('title', 'Cetak Kartu')

@section('content')

<div class="row">
@foreach ($pesertappdb as $peserta)

        <div class="col-md-6 mt-1">
			<div class="p-2 mb-5" style="border: 3px solid black; border-radius: 10px;">
            @include('pdf.parts.kartu-pendaftaran', ['peserta' => $peserta])
			</div>
        </div>

	@if($loop->iteration % 6 == 0)
	<div style="my-2" style="page-break-after: always;">&nbsp;</div>
	@endif

@endforeach
    </div>

@endsection