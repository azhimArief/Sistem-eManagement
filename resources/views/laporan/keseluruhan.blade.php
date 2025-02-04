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
            <h2 class="card-title">Laporan Permohonan Keseluruhan</h2>
          </div>

          <form class="form-horizontal" method="POST" action="{{ route ('laporan.keseluruhan') }}" enctype="multipart/form-data">
            {{ csrf_field() }}

          <div class="card-body">
            <div class="form-group row">
              <!-- pentadbir sistem -->
               <div class="col-sm-4">
                <label for="negeri" class="col-form-label">Tujuan : </label>
                <select class="form-control select2" id="id_tujuan" name="id_tujuan" style="width: 100%;">
								<option value="" @if($search['tujuan']=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
								@foreach ($optTujuans as $optTujuan)
									<option value="{{ $optTujuan->id_tujuan }}" @if($search['tujuan']==$optTujuan->id_tujuan) {{ 'selected="selected"' }} @endif>{{ $optTujuan->tujuan }}</option>
								@endforeach
								</select> 
              </div>

              <div class="col-sm-4">
                <label for="jenis_perjalanan" class="col-form-label">Jenis Perjalanan : </label>
                <select class="form-control select2" id="id_jenis_perjalanan" name="id_jenis_perjalanan" style="width: 100%;">
								<option value="" @if($search['jenis_perjalanan']=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
								@foreach ($optJenisPerjalanans as $optJenisPerjalanan)
									<option value="{{ $optJenisPerjalanan->id_jenis_perjalanan }}" @if($search['jenis_perjalanan']==$optJenisPerjalanan->id_jenis_perjalanan) {{ 'selected="selected"' }} @endif>{{ $optJenisPerjalanan->jenis_perjalanan }}</option>
								@endforeach
								</select> 
              </div>

              <div class="col-sm-4">
                <label for="status" class="col-form-label">Status Permohonan : </label>
                <select class="form-control select2" id="status" name="status">
                  <option value="" @if($search['status']=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
                  @foreach ($optStatus as $optStatuss)
                  <option value="{{ $optStatuss->id_status }}" @if($search['status']==$optStatuss->id_status) {{ 'selected="selected"' }}  @endif>{{ $optStatuss->status }}</option>
                  @endforeach
                </select>
              </div>
            <!-- <div>
            <div class="form-group row"> -->
              <div class="col-sm-4">
                <label for="tkh_dari" class="col-form-label">Tarikh Dari : </label>
                <input type="date" class="form-control" id="tkh_dari" name="tkh_dari" value="{{ $search['tkh_dari'] }}">
              </div>
              <div class="col-sm-4">
                <label for="tkh_hingga" class="col-form-label">Tarikh Hingga :</label>
                <input type="date" class="form-control" id="tkh_hingga" name="tkh_hingga" value="{{ $search['tkh_hingga'] }}">
              </div> 
            </div>

            <div class="modal-footer justify-content-between">
              <P></P>
              <span class="float-right">
                <button type="submit" class="btn btn-info bg-purple" name="search_laporan">Carian</button>
                <a href="{{ url('/laporan/keseluruhan') }}" class="btn btn-default" name="search_laporan">Reset</a>
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
                      <th>Pemohon</th> 
                      <th>Jenis Perjalanan</th> 
                      <th>Tarikh Pergi</th> 
                      <th>Tarikh Balik</th> 
                      <th>Tujuan</th>  
                      <th>Lokasi</th> 
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($permohonanKenderaans as $permohonanKenderaan)
                    <tr>
                      <td scope="row">{{ $bil++ }}</td>
                      <td>{{ $permohonanKenderaan->kod_permohonan }}</td>
                      <td>{{ ($permohonanKenderaan->id_pemohon!='') ? \App\Pemohon::find($permohonanKenderaan->id_pemohon)->nama : '-' }}</td>
                      <td>{{ ($permohonanKenderaan->id_jenis_perjalanan!='') ? \App\LkpJenisPerjalanan::find($permohonanKenderaan->id_jenis_perjalanan)->jenis_perjalanan : '-' }}</td>
                      <td>{{ ($permohonanKenderaan->tkh_pergi!='') ? $permohonanKenderaan->tkh_pergi : '-' }}</td>
                      <td>{{ ($permohonanKenderaan->tkh_balik!='') ? $permohonanKenderaan->tkh_balik : '-' }}</td>
                      <td>{{ ($permohonanKenderaan->id_tujuan!='') ? \App\LkpTujuan::find($permohonanKenderaan->id_tujuan)->tujuan: '-' }}</td>
					            <td>{{ ($permohonanKenderaan->lokasi_tujuan!='') ? $permohonanKenderaan->lokasi_tujuan: '-' }}</td>
                      <td>{{ ($permohonanKenderaan->id_status==2) ? 'Pemohonan Baru': \App\LkpStatus::find($permohonanKenderaan->id_status)->status }}</td>
                    </tr>
                    @endforeach
                  </tbody>
                <!-- </form> -->
                </table><!-- /.card-body -->
            @endif
            <!-- <div align="center">
    <a href="{{ route('laporan.excel') }}" class="btn btn-success">Export to Excel</a>
   </div> -->
              </div>
          </div><!-- /.card -->
          </div><!--/.col (right) -->
      </div><!-- /.row -->
  </div><!-- /.container-fluid -->
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