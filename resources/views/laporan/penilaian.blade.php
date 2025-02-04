@extends('layouts/master')
@section('content')

<style>
.checked {
  color: orange;
}
</style>
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
            <h2 class="card-title">Penilaian Perkhimatan Kenderaan</h2>
          </div>

         
            <!-- /.card-header -->
            <!-- form start -->
            <!-- <div class="card card-info"> -->
          <div class="card-body table-responsive">
            
            <table id="example1" class="table table-bordered table-striped">
              <thead bgcolor ="#CF9FFF">
                <tr>
                  <th>Bil.</th>
                  <th>Pemandu</th> 
                  <th>Keterampilan Diri</th> 
                  <th>Disiplin Masa</th> 
                  <th>Mahir Jalan</th> 
                  <th>Pemanduan Berhemah</th> 
                  <th>Ruang Dalam Kenderaan</th> 
                  <th>Purata Keseluruhan</th>
                  
                </tr>
              </thead>
              <tbody>
                @foreach ($ratings as $rating)
                <tr>
                  <td scope="row">{{ $bil++ }}</td>
                  <td>{{ ($rating->pemandu!='') ? \App\LkpPemandu::find($rating->pemandu)->nama_pemandu : '-'  }}</td>
                  {{-- <td>{{$rating->pemandu}}</td> --}}
                  <td><center>{{ number_format($rating->s1,1) }} &#9733;</center></td>
                  <td><center>{{ number_format($rating->s2,1) }} &#9733;</center></td>
                  <td><center>{{ number_format($rating->s3,1) }} &#9733;</center></td>
                  <td><center>{{ number_format($rating->s4,1) }} &#9733;</center></td>
                  <td><center>{{ number_format($rating->s5,1) }} &#9733;</center></td>
                  <?php 
                    $overall=0.0;
                    $overall=($rating->s1+$rating->s2+$rating->s3+$rating->s4+$rating->s5)/5;
                  ?>
                  <td><center>
                    <span class="badge bg-warning" style="font-size: 15px">{{ number_format($overall,1) }} &#9733;</span>
                  </center></td>
                </tr>
                <!-- <span class="fa fa-star @if ($overall>=1) checked @endif" style="font-size: 12px"></span>
                    <span class="fa fa-star @if ($overall>=2) checked @endif" style="font-size: 12px"></span>
                    <span class="fa fa-star @if ($overall>=3) checked @endif" style="font-size: 12px"></span>
                    <span class="fa fa-star @if ($overall>=4) checked @endif" style="font-size: 12px"></span>
                    <span class="fa fa-star @if ($overall>=5) checked @endif" style="font-size: 12px"></span>
                  </center></td> -->
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="8" style="font-size: 11px">
                    <strong>5.0 &#9733; </strong> - Sangat Baik <br> 
                    <strong>4.0 &#9733; </strong> - Baik <br>
                    <strong>3.0 &#9733; </strong> - Memuaskan <br>
                    <strong>2.0 &#9733; </strong> - Kurang Memuaskan <br>
                    <strong>1.0 &#9733; </strong> - Sangat Tidak Memuaskan
                  </td>
                </tr>
              </tfoot>
            <!-- </form> -->
            </table><!-- /.card-body -->
          </div>
         
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
