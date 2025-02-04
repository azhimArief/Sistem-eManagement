@extends('layouts.masterScreen')
@section('content')

    <head>
        <link href="https://unpkg.com/bootstrap-table@1.21.0/dist/bootstrap-table.min.css" rel="stylesheet">

        <script src="https://unpkg.com/bootstrap-table@1.21.0/dist/bootstrap-table.min.js"></script>
        <script
            src="https://unpkg.com/bootstrap-table@1.21.0/dist/extensions/filter-control/bootstrap-table-filter-control.min.js">
        </script>

        <style>
            .dataTables_paginate {
                float: right;
            }
            .dataTables_length {
                float: left;
            }
            .dataTables_info {
                float: left;
            }
        </style>
    </head>
    <div class="container" align="center">
        <br>

          
        <div class="col-sm-11">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <button type="button" class="btn btn-light btn-block bg-purple">
                        <h5> MAKLUMAT PROFIL BILIK </h5>
                    </button>
                </div>
            </div>
        </div>
        
        <div class="container-fluid">
            <div class="col-md-11">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        @if (session('status'))
                            <div class="alert alert-success" style="text-align:left" role="alert">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                {{ session('status') }}
                            </div>
                        @elseif(session('failed'))
                            <div class="alert alert-danger" style="text-align:left" role="alert">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                {{ session('failed') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- general form elements disabled -->
        <div class="col-sm-11">
            <div class="card card-info">

                    @csrf
                    <div class="card-body">
                        <a class="btn btn-sm float-right" data-toggle="modal" data-target="#modal-default"><i class="fa fa-filter"></i> Tapis Senarai</a>
                        <div class="table-responsive">
                            {{-- <table id="example1" class="table table-bordered table-striped" data-url="json/data1.json"
                                data-filter-control="true" data-show-search-clear-button="true"> --}}
                            <table id="example1" class="table table-bordered table-striped">
                                <thead bgcolor="CF9FFF">
                                    <tr>
                                        <th>Bil.</th>
                                        <th>Nama Bilik</th>
                                        <th>Kapasiti</th>
                                        <th>Aras</th>
                                        <th>Kemudahan Bilik</th>
                                        <th>Gambar Bilik</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($biliks as $bilik)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ $bilik->bilik }} ({{ $bilik->bahagian }})</td>
                                            <td>{{ $bilik->kapasiti_bilik ?? '-' }}</td>
                                            <td>{{ $bilik->aras }} </td>
                                            <td>{{ $bilik->kemudahan_bilik ?? '-' }} </td>
                                            <td>
                                                @if ($bilik->gambar_bilik == null)
                                                    -
                                                @else
                                                    <center><a href="{{ url('' . $bilik->gambar_bilik) }}" target="_blank"><img
                                                            class="img-fluid mb-3" src="{{ url('' . $bilik->gambar_bilik) }}"
                                                            alt="Photo" width="60" height="60"></a>
                                                    </center> 
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- /.card-body -->
                        </div>

                    </div>


                    <!-- <hr> -->
                    <div class="card-footer justify-content-center">
                        <button type="button" class="btn btn-default float-right btn-sm" onclick="history.back();"><i
                                class="fas fa-redo-alt"></i> | Kembali</button>
                    </div>

            </div>

        </div>
        <!-- </div> -->
    </div>

    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header bg-purple">
              <h4 class="modal-title">Tapis Senarai Bilik</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="form-horizontal" method="POST" action="{{ url('/pemohon/lihatbilik/') }}" enctype="multipart/form-data">
              {{ csrf_field() }}
              <div class="modal-body">
  
                <div class="form-group row">
                  <label for="pilihAras" class="col-sm-4 col-form-label">Pilih Aras</label>
                  <div class="col-sm-8">
                    <select class="custom-select" id="pilihAras" name="pilihAras">
                        <option value="" selected disabled>-- Pilih Aras --</option>
                        <option value="5">Aras 5</option>
                        <option value="6">Aras 6</option>
                        <option value="7">Aras 7</option>
                        <option value="8">Aras 8</option>
                        <option value="9">Aras 9</option>
                        <option value="10">Aras 10</option>
                    </select>
                  </div>
                </div>
  
              </div>
              <div class="modal-footer justify-content-between">
                <span class="float-right">
                  <a href="{{ url('/pemohon/lihatbilik/') }}" class="btn btn-default" name="tapis_reset">Reset</a>
                  <button type="submit" class="btn btn-primary bg-purple" name="tapis_bilik">Tapis</button>
                </span>
              </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

@endsection

@section('script')
    <script type="text/javascript">
        $(function() {

            $('#example1').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "pageLength": 10,

                language: {
                    search: "Cari :",
                    zeroRecords:    "Tiada rekod yang sepadan ditemui",
                }
            });
        });
    </script>
@endsection
