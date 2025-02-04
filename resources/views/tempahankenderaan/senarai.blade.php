@extends('layouts/master')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header" bgcolor ="#d2d5d5">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">TEMPAHAN KENDERAAN</h1>
          </div><!-- /.col -->
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/home') }}">Laman Utama</a></li>
              <li class="breadcrumb-item">Tempahan Kenderaan</li>
            </ol>
          </div>
          
          <!-- /.col -->
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
          <div class="card card-info"  >
            <div class="card-header bg-purple" >
              <h2 class="card-title" style="margin-top:5px; bgcolor :#CF9FFF"  >Senarai Tempahan</h2>
              <span class="float-right">
                <!-- <a class="btn btn-sm" data-toggle="modal" data-target="#modal-default"><i class="fa fa-filter"></i> Tapis</a> -->
                <a class="btn btn-sm" data-toggle="modal" data-target="#modal-default"><i class="fa fa-filter"></i> Tapis</a>
                <a href="{{ url('tempahankenderaan/tambah') }}" class="btn btn-sm"><i class="fa fa-plus"></i> Tambah</a>
              </span>
              
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <div class="card-body table-responsive" >
              <table id="example1" class="table table-bordered table-striped" >
                <thead bgcolor ="#CF9FFF">
                  <tr>
                    <th><center>Bil.</center></th>
                    <th><center>ID Tempahan</center></th>
                    <th><center>Pemohon</center></th>
                    <th><center>Tujuan</center></th>
                    <th><center>Jenis Perjalanan</center></th>
                    <th><center>Tarikh Permohonan</center></th>
					<th><center>Tarikh Perjalanan Pergi</center></th>
					<th><center>Tarikh Perjalan Balik</center></th>
                  
                    <th><center>Status</center></th>
					<th><center>Tindakan</center></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($permohonanKenderaans as $permohonanKenderaan)
                  <tr>
                    <td>&nbsp;</td>
                    <td>
                    <a href="{{ url('tempahankenderaan/butiran',$permohonanKenderaan->id_maklumat_permohonan) }}" title="Butiran">{{ $permohonanKenderaan->kod_permohonan }}</a><br/>
                    </td>
                    <td>{{ ($permohonanKenderaan->id_pemohon!='') ? \App\Pemohon::find($permohonanKenderaan->id_pemohon)->nama : '' }}</td>
                    <td>{{ ($permohonanKenderaan->id_tujuan!='') ? \App\LkpTujuan::find($permohonanKenderaan->id_tujuan)->tujuan : '' }}</td>
                    <td>{{ ($permohonanKenderaan->id_jenis_perjalanan!='') ? \App\LkpJenisPerjalanan::find($permohonanKenderaan->id_jenis_perjalanan)->jenis_perjalanan : '' }}</td>
                    <td><center>{{ Carbon\Carbon::parse($permohonanKenderaan->created_by)->format('d.m.Y') }}</center></td>
                    
                    <td><center>@if($permohonanKenderaan->tkh_pergi != null)
                      {{ Carbon\Carbon::parse($permohonanKenderaan->tkh_pergi)->format('d.m.Y') }} @else - @endif</center></td>
                    <td><center>@if($permohonanKenderaan->tkh_balik != null)
                      {{ Carbon\Carbon::parse($permohonanKenderaan->tkh_balik)->format('d.m.Y') }} @else - @endif</center></td>
                
                    <?php
                      $status = $permohonanKenderaan->id_status;
                      $color = ""; 
                      switch($status){
                        //permohonan baru
                        case "1": $color="#FFB300"; if (Auth()->user()->id_access == 1 || Auth::user()->id_access == '3' || Auth::user()->id_access == '4') 
                                { $status="Permohonan Baru"; } else{ $status="Dalam Proses"; } break; //kuning
                        //telah dikemaskini
                        case "2": $color="#FFB300"; if (Auth()->user()->id_access == 1 || Auth::user()->id_access == '3' || Auth::user()->id_access == '4') 
                                { $status="Dikemaskini"; } else{ $status="Dalam Proses"; } break; //biru
                        //lulus
                        case "3":  $color="#32CD32"; $status="Lulus"; break; //hijau
                        //gagal
                        case "4": $color="#FF0000"; $status="Gagal"; break; //merah
                        //semak semula
                        case "5": $color="#2C87F0"; $status="Semak Semula"; break; //biru
                        //batal
                        case "6": $color="#CC3300"; $status="Batal"; break; //merah pekat
                        //sah
                        case "11": $color="#006400"; $status="Disahkan"; break; //hijau pekat
                        default : $color="#000000";

                      }
                    ?>
                    <td style ="color:{{$color}};"><center>{{ $status }}</center></td>
                    <td><div class="d-flex justify-content-center">

                  @if (Auth::user()->id_access == '1' || Auth::user()->id_access == '4')
                        <!-- if status permohonan baru/lulus/kemaskini -->
                      @if ($permohonanKenderaan->id_status == 1 || $permohonanKenderaan->id_status == 2 || $permohonanKenderaan->id_status == 3)
                      <a href="{{ url('tempahankenderaan/butiran',$permohonanKenderaan->id_maklumat_permohonan) }}" title="Tindakan" class="btn btn-sm btn-primary bg-purple"><i class="fa fa-user-edit"></i></a>
                      @elseif ($permohonanKenderaan->id_status == 4 || $permohonanKenderaan->id_status == 6|| $permohonanKenderaan->id_status == 11)
                      <!-- if gagal/batal/ sah -->
                        <a href="{{ url('tempahankenderaan/butiran',$permohonanKenderaan->id_maklumat_permohonan) }}" title="Butiran" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a>
                      @endif
                      <!-- <a href="{{ url('tempahankenderaan/hapus',$permohonanKenderaan->id_pemohon) }}" class="btn-sm btn-danger"><i class="fa fa-trash"></i></a></div> -->
                      @if ($permohonanKenderaan->id_status == 3 || $permohonanKenderaan->id_status == 11) 
                        <a href="{{ url('tempahankenderaan/batal/'.$permohonanKenderaan->id_maklumat_permohonan) }}" title="Batal" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i></a>
                        @endif
                      

                    @endif
                    <!-- <a href="{{ url('penilaian/kenderaan',$permohonanKenderaan->id_maklumat_permohonan) }}" title="Penilaian Kenderaan" class="btn-sm btn-warning"><i class="fa fa-list"></i></a>
                    <a href="{{ url('penilaian/catatanpemandu',$permohonanKenderaan->id_maklumat_permohonan) }}" title="Catatan Pemandu" class="btn-sm btn-warning bg-orange"><i class="fa fa-list"></i></a> -->
                    </td>
                  </tr>
                  @endforeach
                
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>	
  <!-- modal  -->
  <div class="modal fade" id="modal-default">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-purple">
            <h4 class="modal-title">Tapis Senarai</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form class="form-horizontal" method="POST" action="{{ url('tempahankenderaan') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="modal-body">
              <div class="form-group row">
                <label for="kod_permohonan" class="col-sm-4 col-form-label">ID Tempahan</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="kod_permohonan" name="kod_permohonan" placeholder="Kod Permohonan" value="{{ $Srhfield['kod_permohonan'] }}">
                </div>
              </div>
              <div class="form-group row">
                <label for="tujuan" class="col-sm-4 col-form-label">Tujuan</label>
                <div class="col-sm-8">
                  <select class="form-control select2" id="tujuan" name="tujuan" style="width: 100%;">
                  <option value="" @if($Srhfield['tujuan']=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
                      @foreach ($optTujuan as $optTujuan)
                          <option value="{{ $optTujuan->id_tujuan }}" @if($Srhfield['tujuan']==$optTujuan->id_tujuan) {{ 'selected="selected"' }} @endif>{{ $optTujuan->tujuan }}</option>
                      @endforeach
                    </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="status" class="col-sm-4 col-form-label">Status Permohonan</label>
                  <div class="col-sm-8">
                  <select class="form-control select2" id="status" name="status" style="width: 100%;">
                    <option value="" @if($Srhfield['status']=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
                    @foreach ($optStatus as $optStatus)
                      <option value="{{ $optStatus->id_status }}" @if($Srhfield['status']==$optStatus->id_status) {{ 'selected="selected"' }} @endif>{{ $optStatus->status }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="tkh_dari" class="col-sm-4 col-form-label">Tarikh Permohonan Dari</label>
                  <div class="col-sm-8">
                    <input type="date" class="form-control" id="tkh_dari" name="tkh_dari" value="{{ $Srhfield['tkh_dari'] }}">
                  </div>
              </div>
              <div class="form-group row">
                <label for="tkh_hingga" class="col-sm-4 col-form-label">Tarikh Permohonan Hingga</label>
                  <div class="col-sm-8">
                    <input type="date" class="form-control" id="tkh_hingga" name="tkh_hingga" value="{{ $Srhfield['tkh_hingga'] }}">
                </div>
              </div> 
			  
			   <div class="form-group row">
                <label for="tkh_dari" class="col-sm-4 col-form-label">Tarikh Perjalanan Pergi</label>
                  <div class="col-sm-8">
                    <input type="date" class="form-control" id="tkh_pergi" name="tkh_pergi" value="{{ $Srhfield['tkh_pergi'] }}">
                  </div>
              </div>
              <div class="form-group row">
                <label for="tkh_hingga" class="col-sm-4 col-form-label">Tarikh Perjalanan Balik</label>
                  <div class="col-sm-8">
                    <input type="date" class="form-control" id="tkh_balik" name="tkh_balik" value="{{ $Srhfield['tkh_balik'] }}">
                </div>
              </div> 
            
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
              <span class="float-right">
                <a href="{{ url('tempahankenderaan') }}" class="btn btn-default" name="tapis">Reset</a>
                <button type="submit" class="btn btn-primary bg-purple" name="tapis">Tapis</button>
              </span>
            </div>
          </form>
        </div> <!-- /.modal-content -->
      </div> <!-- /.modal-dialog -->
    </diV>
@endsection


@section('script')
	<script>
	$(function () {
		$("#example1").DataTable({
		  "responsive": true, "lengthChange": false, "autoWidth": false,
		  "fnDrawCallback": function ( oSettings ) {
				/* Need to redo the counters if filtered or sorted */
				if ( oSettings.bSorted || oSettings.bFiltered )
				{
					for ( var i=0, iLen=oSettings.aiDisplay.length ; i<iLen ; i++ )
					{
						$('td:eq(0)', oSettings.aoData[ oSettings.aiDisplay[i] ].nTr ).html( i+1 );
					}
				}
			}
		}).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
		
		

		$('.toastsDefaultDefault').click(function() {
		  $(document).Toasts('create', {
			title: 'Toast Title',
			body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
		  })
		});
	  });
	</script>
@endsection

