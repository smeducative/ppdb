@extends('layouts.pdf')

@inject('setting', 'App\Models\PpdbSetting')
@inject('carbon', 'Carbon\Carbon')

@section('title', 'Cetak Surat di terima')

@section('content')
    @foreach ($pesertappdb as $peserta)
        <div style="page-break-after: always">
            @include('pdf.parts.surat-diterima', [
                'peserta' => $peserta,
                'setting' => $setting->latest()->first(),
                'carbon'  => $carbon
            ])
        </div>
    @endforeach
@endsection
