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
          <li class="breadcrumb-item"><a href="{{ url('/home') }}">Laman Utama</a></li>
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
            <h2 class="card-title">Ulasan Oleh Pemandu</h2>
          </div>

          <form class="form-horizontal" method="POST" action="{{ route ('laporan.ulasanpemandu') }}" enctype="multipart/form-data">
            {{ csrf_field() }}

            <div class="card-body">
              <div class="form-group row">
                <!-- pentadbir sistem -->
                  <div class="col-sm-3">
                    <label for="mykad" class="col-form-label">Nama Pemandu : </label>
                    <select class="form-control " id="mykad" name="mykad" style="width: 100%;">
                    <option value="" @if($search['mykad']=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
                    @foreach ($optPemandus as $optPemandu)
                      <option value="{{ $optPemandu->mykad }}" @if($search['mykad']==$optPemandu->mykad) {{ 'selected="selected"' }} @endif>{{ $optPemandu->nama_pemandu }}</option>
                    @endforeach
                    </select> 
                  </div>
                  <div class="col-sm-3">
                    <label for="id_tempahan" class="col-form-label">ID Tempahan :</label>
                      <input type="text" class="form-control" id="id_tempahan" name="id_tempahan" placeholder="ID Tempahan" value="{{ $search['id_tempahan'] }}">
                  </div>
                  <div class="col-sm-3">
                    <label for="tkh_dari" class="col-form-label">Tarikh Dari : </label>
                    <input type="date" class="form-control" id="tkh_dari" name="tkh_dari" value="{{ $search['tkh_dari'] }}">
                  </div>
                  <div class="col-sm-3">
                    <label for="tkh_hingga" class="col-form-label">Tarikh Hingga : </label>
                    <input type="date" class="form-control" id="tkh_hingga" name="tkh_hingga" value="{{ $search['tkh_hingga'] }}">
                  </div>
                  
              </div>
  
              <div class="modal-footer justify-content-between">
                <P></P>
                <span class="float-right">
                  <button type="submit" class="btn btn-info bg-purple" name="search_laporan">Carian</button>
                  <a href="{{ url('/laporan/ulasanpemandu') }}" class="btn btn-default" name="search_laporan">Reset</a>
                </span>
              </div>
  
            </div>

          </form>

          @if(isset($_POST['search_laporan']))
            <!-- /.card-header -->
            <!-- form start -->
            <!-- <div class="card card-info"> -->
          <div class="card-body table-responsive">
            <table id="example1" class="table table-bordered table-striped">
              <thead bgcolor ="#CF9FFF">
                <tr>
                  <th>Bil.</th>
                  <th>Kod Permohonan</th> 
                  <th>Tarikh Perjalanan</th> 
                  <th>Tujuan</th> 
                  <th>Penumpang</th> 
                  <th>Nama Pemandu</th> 
                  <th>Ulasan Penumpang</th> 
                  <th>Ulasan Pemandu</th> 
                  
                </tr>
              </thead>
              <tbody>
                @foreach ($komens as $komen)
                <tr>
                  <td scope="row">{{ $bil++ }}</td>
                  <td>{{ ($komen->id_maklumat_permohonan!='') ? \App\PermohonanKenderaan::find($komen->id_maklumat_permohonan)->kod_permohonan : '-' }}</td>
                  <td>{{ Carbon\Carbon::parse($komen->tkh_pergi)->format('d.m.Y') }}</td>
                  <td>{{ ($komen->id_tujuan!='') ? \App\LkpTujuan::find($komen->id_tujuan)->tujuan : '-' }}</td>
                  <?php 
                    $penumpangs = [];
                    $penumpangs= DB::select('SELECT p.nama
                                  FROM penumpang p
                                  WHERE p.id_tempahan='.$komen->id_maklumat_permohonan.'');
                  ?>
                  <td> 
                    <!-- <b> Pemohon: </b><br>{{ ($komen->id_pemohon!='') ? \App\Pemohon::find($komen->id_pemohon)->nama : '' }} <br> -->
                  @if($penumpangs)
                    <!-- <b> Penumpang: </b><br> -->
                    @foreach ($penumpangs as $penumpang) 
                      <li>{{ $penumpang->nama}}</li>
                    @endforeach
                  @endif
                  </td>
                  <td>{{ ($komen->pemandu!='') ? \App\LkpPemandu::find($komen->pemandu)->nama_pemandu : '-' }}</td>
                  <td>{{ $komen->ulasan }}</td>
                  <td>{{ $komen->komen_pemandu}}</td>
         
                </tr>
                @endforeach
              </tbody>
            <!-- </form> -->
            </table><!-- /.card-body -->
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

    $('.select2').select2();

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