@extends('layouts/master')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h3 class="m-0">LAPORAN</h3>
      </div><!-- /.col -->

      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('/homeBilikMeet') }}">Laman Utama</a></li>
          <li class="breadcrumb-item">Laporan</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        @if (session('status'))
        <div class="alert alert-success" role="alert">
          <button type="button" class="close" data-dismiss="alert">×</button>
          {{ session('status') }}
        </div>
        @elseif(session('failed'))
        <div class="alert alert-danger" role="alert">
          <button type="button" class="close" data-dismiss="alert">×</button>
          {{ session('failed') }}
        </div>
        @endif
        <!-- Horizontal Form -->
        <div class="card card-info">
          <div class="card-header bg-purple">
            <h2 class="card-title">Laporan Katerer</h2>
          </div>

          <form class="form-horizontal" method="POST" action="{{ route ('laporanbilik.katerer') }}" enctype="multipart/form-data">
            {{ csrf_field() }}

          <div class="card-body">
            <div class="form-group row">
              <!-- pentadbir sistem -->
              <div class="col-sm-4">
                <label for="katerer" class="col-form-label">Nama Katerer : </label>
                <select class="form-control select2" id="katerer" name="katerer" style="width: 100%;">
                <option value="" @if($search['katerer']=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
                @foreach ($katerers as $katerer)
                  <option value="{{ $katerer->id_katerer }}" @if($search['katerer']==$katerer->id_katerer) {{ 'selected="selected"' }} @endif>{{ $katerer->nama_katerer }}</option>
                @endforeach
                </select>
              </div>
              <div class="col-sm-4">
                <label for="tkh_mula" class="col-form-label">Tarikh Dari : </label>
                <input type="date" class="form-control" id="tkh_mula" name="tkh_mula" value="{{ $search['tkh_mula'] }}">
              </div>
              <div class="col-sm-4">
                <label for="tkh_hingga" class="col-form-label">Tarikh Hingga :</label>
                <input type="date" class="form-control" id="tkh_hingga" name="tkh_hingga" value="{{ $search['tkh_hingga'] }}">
              </div> 
             
            </div>
              <!-- </div>
              <div class="form-group row"> -->
            <div class="modal-footer justify-content-between">
                <p></p>
              <span class="float-right">
              <!-- <div class="col-sm-3"> -->
                <!-- <label for="submit" class="col-form-label">&nbsp; </label><br> -->
                <button type="submit" class="btn btn-info bg-purple" name="search_laporan">Carian</button>
                <a href="{{ url('/laporbilik/katerer') }}" class="btn btn-default" name="search_laporan">Reset</a>
              </span>
            </div>
            
          </div>
        </div>
          </form>

          @if(isset($_POST['search_laporan']))
            <!-- /.card-header -->
            <!-- form start -->
          <div class="card card-info">
            <div class="card-body table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead bgcolor ="#CF9FFF">
                  <tr>
                    <th>Bil.</th>
                    <th>Kod Permohonan</th> 
                    <th>Nama Katerer</th> 
                    <th>Tujuan</th> 
                    <th>Tempat</th> 
                    <th>Tarikh Mula</th> 
                    <th>Tarikh Hingga</th> 
                    <th>Harga Makan</th> 
                    
                  </tr>
                </thead>
                <tbody>
                  @foreach ($permohonanBiliks as $permohonanBilik)
                  <tr>
                    <td scope="row">{{ $bil++ }}</td>
                    <td>{{ $permohonanBilik->kod_permohonan }}</td>
                    {{-- <td>{{ $permohonanBilik->pembekal }}</td> --}}
                        @php
                            $nameKaterer = null;
                            foreach ($katerers as $katerer) {
                              if($katerer->id_katerer == $permohonanBilik->pembekal) {
                                $nameKaterer = $katerer->nama_katerer;
                              }
                            }
                        @endphp
                    <td>
                        @php
                          echo $nameKaterer;
                        @endphp
                    </td>
                    <td>{{ ($permohonanBilik->id_tujuan!='') ? \App\LkpTujuan::find($permohonanBilik->id_tujuan)->tujuan : '-' }}</td>
                    {{-- <td>{{ ($permohonanBilik->id_bilik!='') ? \App\LkpBilik::find($permohonanBilik->id_bilik)->bilik: '-' }}</td>  --}}
                    <td>{{ optional(\App\LkpBilik::find($permohonanBilik->id_bilik))->bilik }}</td>
                    <td>{{ ($permohonanBilik->tkh_mula!='') ? $permohonanBilik->tkh_mula : '-' }}</td>
                    <td>{{ ($permohonanBilik->tkh_hingga!='') ? $permohonanBilik->tkh_hingga : '-' }}</td>
                    <td>RM{{ ($permohonanBilik->kadar_harga!='') ? $permohonanBilik->kadar_harga : '-' }}</td>
                  </tr>
                  @endforeach
                </tbody>
              <!-- </form> -->
              </table><!-- /.card-body -->
            </div>
          </div>
          @endif
        </div><!-- /.card -->
         
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->

</section>


@endsection
@section('script')
<script>
  $(function () {
    $("#example1").DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "responsive": true,
      "buttons": ["csv", "excel", "pdf", "print"],
      // "columnDefs": [
      //       {
      //           "targets": [ 5, 7, 8, 9, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23],
      //           "visible": false,
      //           "searchable": false
      //       }
      //   ]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  });
  </script>
@endsection