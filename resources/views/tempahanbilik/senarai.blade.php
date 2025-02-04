@extends('layouts/master')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header" bgcolor ="#d2d5d5">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">TEMPAHAN BILIK</h1>
          </div><!-- /.col -->
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/homeBilikMeet') }}">Laman Utama</a></li>
              <li class="breadcrumb-item">Tempahan Bilik</li>
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
                <a href="{{ url('tempahanbilik/tambah') }}" class="btn btn-sm"><i class="fa fa-plus"></i> Tambah</a>
              </span>
              
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <div class="card-body table-responsive" >
              <table id="example1" class="table table-bordered table-striped" >
                <thead bgcolor ="#CF9FFF">
                  <tr>
                    <th><center>Bil.</center> </th>
                    <th><center>ID Tempahan</center> </th>
                    <th><center>Nama Bilik</center></th>
                    <th><center>Pemohon</center></th>
                    <th><center>Tujuan</center></th>
                    <th><center>Tarikh Mula</center></th>
                    <th><center>Tarikh Tamat</center></th>
                  
                    <th><center>Status</center></th>
                    <th width="7">&nbsp;</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($permohonanBiliks as $permohonanBilik)
                  <?php 
                    $checkPermohonan = App\Tindakan::where('id_permohonan', $permohonanBilik->id_permohonan_bilik)
                                                    ->where('id_status_makan', '!=', null)
                                                    ->first();
                  ?>
                  @if ($checkPermohonan)
                    
                  <tr>
                    <td>&nbsp;</td>
                    <td>
                    <a href="{{ url('tempahanbilik/butiran',$permohonanBilik->id_permohonan_bilik) }}" title="Butiran">{{ $permohonanBilik->kod_permohonan }}</a><br/>
                    </td>
                    {{-- <td>{{ ($permohonanBilik->id_bilik!='') ? \App\LkpBilik::find($permohonanBilik->id_bilik)->bilik : '' }}</td> --}}
                    <td>{{ optional(\App\LkpBilik::find($permohonanBilik->id_bilik))->bilik }}</td>
                    {{-- <td>{{ $permohonanBilik->id_bilik }}</td> --}}
                    <td>{{ ($permohonanBilik->id_pemohon!='') ? \App\Pemohon::find($permohonanBilik->id_pemohon)->nama : '' }}</td>
                    <td>{{ ($permohonanBilik->id_tujuan!='') ? \App\LkpTujuan::find($permohonanBilik->id_tujuan)->tujuan : '' }}</td>
                    {{-- <td>{{ ($permohonanKenderaan->id_jenis_perjalanan!='') ? \App\LkpJenisPerjalanan::find($permohonanKenderaan->id_jenis_perjalanan)->jenis_perjalanan : '' }}</td> --}}
                    <td><center>{{ Carbon\Carbon::parse($permohonanBilik->tkh_mula)->format('d.m.Y') }}</center></td>
                    <td><center>{{ Carbon\Carbon::parse($permohonanBilik->tkh_hingga)->format('d.m.Y') }}</center></td>
                
                    <?php
                      $status = $permohonanBilik->id_status;
                      $color = ""; 
                      switch($status){
                        //permohonan baru
                        case "1": $color="#2C87F0"; if (Auth()->user()->id_access == 1 || Auth()->user()->id_access == 3 || Auth()->user()->id_access == 4) 
                                { $status="Permohonan Baru"; } else{ $status="Permohonan Baru"; } break; //biru
                        //telah dikemaskini
                        case "2": $color="#FFB300"; if (Auth()->user()->id_access == 1 || Auth()->user()->id_access == 3 || Auth()->user()->id_access == 4) 
                                { $status="Dalam Proses"; } else{ $status="Dalam Proses"; } break; //kuning
                        //lulus
                        case "3":  $color="#32CD32"; $status="Lulus"; break; //hijau
                        //Tidak Diluluskan
                        case "4": $color="#FF0000"; $status="Tidak Diluluskan"; break; //merah
                        //semak semula
                        case "5": $color="#165FB3"; $status="Semak Semula"; break; //biru
                        //batal
                        case "6": $color="#CC3300"; $status="Batal"; break; //merah pekat
                        //sah
                        case "11": $color="#006400"; $status="Disahkan"; break; //hijau pekat
                        default : $color="#000000";

                      }
                    ?>
                    <td style ="color:{{$color}};"><center>{{ $status }}</center></td>
                    <td><div class="d-flex justify-content-center">

                    @if (Auth::user()->id_access == '3' || Auth::user()->id_access == '4')
                          <!-- if status permohonan baru/dalam proses/lulus/kemaskini -->
                        @if ($permohonanBilik->id_status == 1 || $permohonanBilik->id_status == 2 || $permohonanBilik->id_status == 3)
                        <a href="{{ url('tempahanbilik/butiran',$permohonanBilik->id_permohonan_bilik) }}" title="Tindakan" class="btn btn-sm btn-primary bg-purple"><i class="fa fa-user-edit"></i></a>
                        @elseif ($permohonanBilik->id_status == 4 || $permohonanBilik->id_status == 6|| $permohonanBilik->id_status == 11)
                        <!-- if gagal/batal/ sah -->
                          <a href="{{ url('tempahanbilik/butiran',$permohonanBilik->id_permohonan_bilik) }}" title="Butiran" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a>
                        @endif
                        <!-- <a href="{{ url('tempahanbilik/hapus',$permohonanBilik->id_permohonan_bilik) }}" class="btn-sm btn-danger"><i class="fa fa-trash"></i></a></div> -->
                        @if ($permohonanBilik->id_status == 3 || $permohonanBilik->id_status == 11) 
                          <a href="{{ url('tempahanbilik/batal/'.$permohonanBilik->id_permohonan_bilik) }}" title="Batal" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i></a>
                        @endif
                        
                    @endif
                    <!-- <a href="{{ url('penilaian/kenderaan',$permohonanBilik->id_maklumat_permohonan) }}" title="Penilaian Kenderaan" class="btn-sm btn-warning"><i class="fa fa-list"></i></a>
                    <a href="{{ url('penilaian/catatanpemandu',$permohonanBilik->id_maklumat_permohonan) }}" title="Catatan Pemandu" class="btn-sm btn-warning bg-orange"><i class="fa fa-list"></i></a> -->
                    </td>
                   </tr> 
                  @endif

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
          <form class="form-horizontal" method="POST" action="{{ url('tempahanbilik') }}" enctype="multipart/form-data">
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
                <label for="tkh_mula" class="col-sm-4 col-form-label">Tarikh Permohonan Dari</label>
                  <div class="col-sm-8">
                    <input type="date" class="form-control" id="tkh_mula" name="tkh_mula" value="{{ $Srhfield['tkh_mula'] }}">
                  </div>
              </div>
              <div class="form-group row">
                <label for="tkh_hingga" class="col-sm-4 col-form-label">Tarikh Permohonan Hingga</label>
                  <div class="col-sm-8">
                    <input type="date" class="form-control" id="tkh_hingga" name="tkh_hingga" value="{{ $Srhfield['tkh_hingga'] }}">
                </div>
              </div> 
            
              
              </div>
            <div class="modal-footer justify-content-between">
              <span class="float-right">
                <a href="{{ url('tempahanbilik') }}" class="btn btn-default" name="tapis">Reset</a>
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
		  "responsive": true, "lengthChange": true, "autoWidth": false,
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

