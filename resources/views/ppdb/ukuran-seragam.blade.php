@extends('layouts.admin')

@section('title', 'Ukuran Seragam Siswa')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Ukuran Seragam Siswa</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="row">

                <div class="col-md-3 mt-3">
                    <div class="">
                                <div class="form-group">
                                    <label class="form-label">Data Tahun:</label>
                                    <select class="custom-select form-control-border" id="ppdb-tahun">
										@for($i = now()->year; $i >= 2021 ; $i--)
                                        <option value="{{ $i }}">{{ $i }}</option>
										@endfor
                                    </select>
                                </div>
                            </div>
                </div>

                <div class="col-md-12">


                    @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fas fa-check"></i> Success!</h5>
                            {{ session('success') }}
                        </div>
                    @endif


                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Ukuran Seragam Siswa </h3>

                            <div class="card-tools">

                                <form action="{{ route('export.seragam') }}?jurusan={{ request()->segment(4) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-primary">
                                        <i class="fas fa-print"></i> export
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="card-body px-0">
                            @if (!$pesertappdb->isEmpty())

                            <div class="table-responsive text-nowrap">
                                <table class="table table-striped table-bordered" id="list-ppdb">
                                    <thead>
                                        <tr>

                                            <th>No. Pendaftaran</th>
                                            <th>Nama</th>
                                            <th>Baju</th>
                                            <th>Jas</th>
                                            <th>Sepatu</th>
                                            <th>Peci</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pesertappdb as $peserta)
                                        <tr>
                                            <td> {{ $peserta->no_pendaftaran }} </td>
                                            <td> <a href="{{ route('ppdb.show.peserta', $peserta->id) }}">
                                                    {{ $peserta->nama_lengkap }}</a> </td>
                                            <td> {{ $peserta->ukuranSeragam->baju ?? '-' }} </td>
                                            <td> {{ $peserta->ukuranSeragam->jas ?? '-' }} </td>
                                            <td> {{ $peserta->ukuranSeragam->sepatu ?? '-' }} </td>
                                            <td> {{ $peserta->ukuranSeragam->peci ?? '-' }} </td>
                                            <td>
                                                <button class="btn btn-primary ukuran-seragam"
                                                data-uuid="{{ $peserta->id }}"
                                                data-nama="{{ $peserta->nama_lengkap }}"
                                                data-baju="{{ $peserta->ukuranSeragam->baju  ?? '-' }}"
                                                data-jas="{{ $peserta->ukuranSeragam->jas  ?? '-' }}"
                                                data-sepatu="{{ $peserta->ukuranSeragam->sepatu  ?? '-' }}"
                                                data-peci="{{ $peserta->ukuranSeragam->peci  ?? '-' }}"
                                                >Ubah</button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            belum ada peserta
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


</div>
</section>

</div>

<div class="modal fade" id="modal-ukuran" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Ubah Ukuran Seragam</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>

            <form action="{{ route('ppdb.ubah.seragam') }}" method="POST">
                @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama</label> <br>
                    <span id="modal-nama"></span>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Ukuran Baju</label>
                            <input type="text" name="baju" class="form-control" id="modal-baju">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Ukuran Jas</label>
                            <input type="text" name="jas" class="form-control" id="modal-jas">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Ukuran Sepatu</label>
                            <input type="text" name="sepatu" class="form-control" id="modal-sepatu">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Ukuran Peci</label>
                            <input type="text" name="peci" class="form-control" id="modal-peci">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <input type="hidden" name="uuid" id="modal-uuid">
              <button type="submit" class="btn btn-primary">Simpa perubahan</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
@endsection


@section('head')
<!-- DataTables -->
<link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

@endsection

@section('footer')
<!-- DataTables  & Plugins -->
<script src="/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>


<!-- Page specific script -->
<script>
    $(function () {

        $('.ukuran-seragam').on('click', function(e) {
            let u = e.currentTarget.dataset

            let uuid = u.uuid
            let nama = u.nama
            let baju = u.baju
            let jas = u.jas
            let sepatu = u.sepatu
            let peci = u.peci

            $('#modal-uuid').val(uuid)
            $('#modal-nama').html(nama)
            $('#modal-baju').val(baju)
            $('#modal-jas').val(jas)
            $('#modal-sepatu').val(sepatu)
            $('#modal-peci').val(peci)

            $('#modal-ukuran').modal('show')
        })

            $('#list-ppdb').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": false,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
      });
</script>
@endsection
