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
            <h2 class="card-title">Laporan Pergerakan Pemandu</h2>
          </div>

          <form class="form-horizontal" method="POST" action="{{ route ('laporan.pemandu') }}" enctype="multipart/form-data">
            {{ csrf_field() }}

          <div class="card-body">
            
            <div class="form-group row">
                <div class="col-sm-4">
                  <label for="mykad" class="col-form-label">Nama Pemandu : </label>
                  <select class="form-control select2" id="mykad" name="mykad" style="width: 100%;">
                  <option value="" @if($search['mykad']=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
                  @foreach ($optPemandus as $optPemandu)
                    <option value="{{ $optPemandu->mykad }}" @if($search['mykad']==$optPemandu->mykad) {{ 'selected="selected"' }} @endif>{{ $optPemandu->nama_pemandu }}</option>
                  @endforeach
                  </select>
                </div>
                <div class="col-sm-4">
                  <label for="mykad" class="col-form-label">No. Kenderaan : </label>
                  <select class="form-control select2" id="no_kenderaan" name="no_kenderaan" style="width: 100%;">
                    <option value="" @if($search['no_kenderaan']=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
                    @foreach ($optKenderaans as $optKenderaan)
                      <option value="{{ $optKenderaan->id_kenderaan }}" @if($search['no_kenderaan']==$optKenderaan->id_kenderaan) {{ 'selected="selected"' }} @endif>{{ $optKenderaan->no_plat }}</option>
                    @endforeach
                  </select>
                </div>
            </div>

            <div class="form-group row">
              <!-- pentadbir sistem -->
                <div class="col-sm-4">
                  <label for="tkh_dari" class="col-form-label">Tarikh Dari : </label>
                  <input type="date" class="form-control" id="tkh_dari" name="tkh_dari" value="{{ $search['tkh_dari'] }}">
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
                <a href="{{ url('/laporan/pemandu') }}" class="btn btn-default" name="search_laporan">Reset</a>
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
                    <th>Nama Pemandu</th> 
                    {{-- <th>Tujuan</th>  --}}
                    <th>Senarai Penumpang</th> 
                    <th>Lokasi</th> 
                    <th>Tarikh Pergi</th> 
                    <th>Masa Pergi</th> 
                    <th>Tarikh Balik</th> 
                    <th>Masa Balik</th> 
                    
                  </tr>
                </thead>
                <tbody>
                  @foreach ($pemanduKenderaans as $pemanduKenderaan)
                  <tr>
                    <td scope="row">{{ $bil++ }}</td>
                    <td>{{ $pemanduKenderaan->kod_permohonan }}</td>
                    <td>{{ \App\LkpPemandu::find($pemanduKenderaan->pemandu)->nama_pemandu }}</td>
                    {{-- <td>{{ $pemanduKenderaan->pemandu }}</td> --}}
                    <td>
                        {{-- {{ ($pemanduKenderaan->id_tujuan!='') ? \App\LkpTujuan::find($pemanduKenderaan->id_tujuan)->tujuan : '-' }} --}}
                        {{-- {{ $pemanduKenderaan->nama }} --}}
                        <ul>
                          @foreach ($penumpangs as $penumpang)
                              @if( $pemanduKenderaan->id_maklumat_permohonan == $penumpang->id_tempahan)
                                {{-- <ul> --}}
                                <li>{{ $penumpang->nama }}</li>
                                {{-- </ul>{{ $penumpang->nama }} <br>  --}}
                              @endif
                          @endforeach
                        </ul>
                    </td>
                    <td>@if($pemanduKenderaan->kenderaan_pergi == $pemanduKenderaan->id_kenderaan) KPN&rarr;{{ $pemanduKenderaan->lokasi_tujuan }} @endif 
                      @if($pemanduKenderaan->kenderaan_pergi == $pemanduKenderaan->id_kenderaan && $pemanduKenderaan->kenderaan_balik == $pemanduKenderaan->id_kenderaan) <br> @endif
                        @if($pemanduKenderaan->kenderaan_balik == $pemanduKenderaan->id_kenderaan) {{ $pemanduKenderaan->lokasi_tujuan }}&rarr;KPN @endif 
                    </td>
                    <td>{{ ($pemanduKenderaan->kenderaan_pergi == $pemanduKenderaan->id_kenderaan) ? $pemanduKenderaan->tkh_pergi : '-' }}</td>
                    <td>{{ ($pemanduKenderaan->kenderaan_pergi == $pemanduKenderaan->id_kenderaan) ? $pemanduKenderaan->masa_pergi : '-' }}</td>
                    <td>{{ ($pemanduKenderaan->kenderaan_balik == $pemanduKenderaan->id_kenderaan) ? $pemanduKenderaan->tkh_balik : '-' }}</td>
                    <td>{{ ($pemanduKenderaan->kenderaan_balik == $pemanduKenderaan->id_kenderaan) ? $pemanduKenderaan->masa_balik : '-' }}</td>
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