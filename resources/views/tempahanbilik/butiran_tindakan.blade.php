@extends('layouts/master')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">BUTIRAN TINDAKAN</h1>
          </div><!-- /.col -->
          
          <!-- <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/home') }}">Laman Utama</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/Permohonan') }}">Permohonan</a></li>
              <li class="breadcrumb-item active">Butiran</li>
            </ol>
          </div> -->
          
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
              
		
			@if(isset($tindakan))
			<div class="card-header bg-purple">
				<h3 class="card-title">Tindakan Seksyen Pentadbiran</h3>
			</div>
			<div class="card-body">
				<dl class="row">
					<dt class="col-sm-2">Status Tempahan Bilik</dt>
					<dd class="col-sm-4">{{ ($tindakan->id_status_tempah!='') ? \App\LkpStatus::find($tindakan->id_status_tempah)->status : '' }}</dd>		
					<dt class="col-sm-3"></center>Status Tempahan Makanan</center></dt>
					<dd class="col-sm-3">{{ ($tindakan->id_status_makan!='') ? \App\LkpStatus::find($tindakan->id_status_makan)->status : '' }}</dd>

					<dt class="col-sm-2">Pembekal/ Katerer</dt>
						@if ( $tindakan->id_status_tempah == 3 && $tindakan->id_status_makan == 3)
							@php
								$NamaKaterer = null;
								foreach ($katerers as $katerer) {
									if($katerer->id_katerer == $tempahMakans->pembekal) {
										$NamaKaterer = $katerer->nama_katerer;
									}
								}
							@endphp
							<dd class="col-sm-10">
								@php
									echo $NamaKaterer;
								@endphp
							</dd>
						@else
							<dd class="col-sm-10"> - </dd>
						@endif

					<dt class="col-sm-2">Catatan</dt>
					<dd class="col-sm-10">{{ ($tindakan->catatan!='') ? $tindakan->catatan : '-' }}</dd>
					<dt class="col-sm-2"><br> Tindakan Oleh</dt>
						@php
							$name = null;
							foreach ($personels as $personel) {
								if($personel->nokp == $tindakan->peg_penyelia) {
									$name = $personel->name;
								}
							}
						@endphp
						<dd class="col-sm-10">
							@php
								echo '<br>' . $name;
							@endphp
						</dd>
					{{-- <dd class="col-sm-10">{{ ($tindakan->peg_penyelia!='') ? \App\PPersonel::find($tindakan->peg_penyelia)->name : '' }}</dd>	 --}}
					<dt class="col-sm-2">Tarikh Tindakan</dt>
					<dd class="col-sm-10">{{ ($tindakan->created_by!='') ? Carbon\Carbon::parse($tindakan->created_by)->format('d.m.Y H:i') : '' }}</dd>			
				</dl>
				
            </div>
			@endif
			
			<!-- /.card-body -->
			<div class="card-footer">
				
				<a href="{{ url('tempahanbilik/kemaskini_tindakan',$tindakan->id_tindakan) }}" class="btn btn-info bg-purple">Kemaskini Tindakan</a>
				<button type="button" class="btn btn-default float-right" onclick="history.back();">Kembali</button>
			</div>
                <!-- /.card-footer -->
            <!-- /.card -->
          </div>		  
		  
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    
@endsection

@section('script')
	<script>
	$(function () {
		$("#example1").DataTable({
		  "responsive": true, "lengthChange": false, "autoWidth": false,  "searching": false,
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
	  });
	</script>
@endsection

