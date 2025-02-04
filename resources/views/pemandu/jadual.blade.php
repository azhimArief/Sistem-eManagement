@extends('layouts/master')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">JADUAL PEMANDU </h1>
          </div><!-- /.col -->
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/home') }}">Laman Utama</a></li>
              <li class="breadcrumb-item">Pemandu</li>
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
          <div class="card card-info">
            <div class="card-header bg-purple">
              <h2 class="card-title" style="margin-top:5px;">Jadual Pemandu</h2>
              <span class="float-right">
                <a class="btn btn-sm" data-toggle="modal" data-target="#modal-default"><i class="fa fa-filter"></i> Tapis</a>
                
              </span>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <div class="card-body table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead bgcolor ="#CF9FFF">
                  <tr>
                    <th>Bil.</th>
                    <th>Masa Pergi</th>
                    <th>Pemandu</th>
                    <th>Masa Balik</th>
                    <th>Pemandu</th>
                    <th>Destinasi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($maklumats as $m)
                  <tr>
                    <td>&nbsp;</td>
                    <td>{{ Carbon\Carbon::parse($m->tkh_pergi)->format('d-m-Y') }} </br> {{$m->masa_pergi}}</td>
                    <?php if($m->kenderaan_pergi){ 
                            $detail_kenderaan_pergis= DB::select('SELECT k.no_plat, p.nama_pemandu, p.mykad, p.no_tel_bimbit, m.jenis_model
                                  FROM kenderaan k
                                  JOIN lkp_pemandu p ON k.pemandu=p.mykad
                                  JOIN lkp_model m ON k.id_model=m.id_model
                                  WHERE k.id_kenderaan='.$m->kenderaan_pergi.'');
                            }else{ $detail_kenderaan_pergis=[]; } ?>
                            
                    <td>@foreach ($detail_kenderaan_pergis as $dkp)
                      <a href="{{ url('pemandu/butiran',$dkp->mykad) }}">{{ $dkp->nama_pemandu }}</a><br/>
                      {{ $dkp->no_tel_bimbit }}<br/>
                      {{ $dkp->no_plat }}<br/>
                      {{ $dkp->jenis_model }}<br/>
                      <?php //small>{{ $dkp->keterangan }}</small?>
                    </td>  @endforeach
                    <td>{{ Carbon\Carbon::parse($m->tkh_balik)->format('d-m-Y') }} </br> {{$m->masa_balik}}</td>

                    <?php if($m->kenderaan_balik){ 
                            $detail_kenderaan_baliks= DB::select('SELECT k.no_plat, p.nama_pemandu, p.mykad, p.no_tel_bimbit, m.jenis_model
                                  FROM kenderaan k
                                  JOIN lkp_pemandu p ON k.pemandu=p.mykad
                                  JOIN lkp_model m ON k.id_model=m.id_model
                                  WHERE k.id_kenderaan='.$m->kenderaan_balik.'');
                            }else{ $detail_kenderaan_baliks=[]; } ?>

                    <td>@foreach ($detail_kenderaan_baliks as $dkb)
                      <a href="{{ url('pemandu/butiran',$dkb->mykad) }}">{{ ($dkb->nama_pemandu!='') ? $dkb->nama_pemandu : '-'}}</a><br/>
                      {{ $dkb->no_tel_bimbit }}<br/>
                      {{ $dkb->no_plat }}<br/>
                      {{ $dkb->jenis_model }}<br/>
                    
                    </td>  @endforeach
                    <td><b>{{$m->lokasi_tujuan}} </b>
                        </br><small> ( Perjalanan {{ \App\LkpJenisPerjalanan::find($m->id_jenis_perjalanan)->jenis_perjalanan }} )</small>
                        </br><span class="badge bg-white" style="color:#CF9FFF">ID Tempahan: <a target="_blank" href="{{ url('tempahankenderaan/butiran',$m->id_maklumat_permohonan) }}">{{ $m->kod_permohonan }}</a> </span>
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
          <h4 class="modal-title">Tapis Jadual</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form class="form-horizontal" method="POST" action="{{ url('jadual') }}" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="modal-body">
              
              <div class="form-group row">
                <label for="tkh_dari" class="col-sm-4 col-form-label">Tarikh Dari</label>
                <div class="col-sm-8">
                  <input type="date" class="form-control" id="tkh_dari" name="tkh_dari" value="{{ $Srhfield['tkh_dari'] }}">
                </div>
              </div>
              <div class="form-group row">
                <label for="tkh_hingga" class="col-sm-4 col-form-label">Tarikh Hingga</label>
                <div class="col-sm-8">
                  <input type="date" class="form-control" id="tkh_hingga" name="tkh_hingga" value="{{ $Srhfield['tkh_hingga'] }}">
                </div>
              </div>
            
            </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            <span class="float-right">
              <a href="{{ url('jadual') }}" class="btn btn-default" name="tapis">Reset</a>
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

