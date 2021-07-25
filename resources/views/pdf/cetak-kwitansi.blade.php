@extends('layouts.pdf')

@section('title', 'Cetak Kwitansi')

@section('content')

@foreach ($pesertappdb->kwitansi as $kwitansi)
<div style="display: block; margin-bottom:66px;">
    @include('pdf.parts.kwitansi', ['kwitansi' => $kwitansi])
</div>


	@if($loop->iteration % 3 === 0)
	<div class="page-break"></div>
	@endif
@endforeach

@endsection