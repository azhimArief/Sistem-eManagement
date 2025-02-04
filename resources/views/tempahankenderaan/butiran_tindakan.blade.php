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
					<dt class="col-sm-2">Status</dt>
					<dd class="col-sm-10">{{ ($tindakan->id_status_tempah!='') ? \App\LkpStatus::find($tindakan->id_status_tempah)->status : '' }}</dd>		
					<dt class="col-sm-2">Catatan</dt>
					<dd class="col-sm-10">{{ ($tindakan->catatan!='') ? $tindakan->catatan : '-' }}</dd>
					@if( $tindakan->id_status_tempah !== 4 && $tindakan->id_status_tempah !== 5)
					<dt>&nbsp;</dt>
					<dd class="col-sm-12">
						<table class="table table-bordered table-sm">
							<thead bgcolor ="#D8BFD8">
								<tr>
									@if(isset($tindakan->kenderaan_balik))
									<th><center>Kenderaan Pergi</center></th>
									<th><center>Kenderaan Balik</center></th>
									@else
									<th>Kenderaan</th>
									@endif
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>
										<p><strong> No Kenderaan</strong><span style="margin-left: 145px;"></span>
										{{ ($tindakan->kenderaan_pergi!='') ? \App\Kenderaan::find($tindakan->kenderaan_pergi)->no_plat : 'N/A' }}</p>
										<p><strong>Jenis Kenderaan</strong><span style="margin-left: 128px;"></span>
										{{ ($tindakan->kenderaan_pergi!='') ? \App\LkpJenisKenderaan::find($kenderaanPergi->id_jenis)->jenis_kenderaan : 'N/A' }}</p>	
										<p><strong>Model Kenderaan</strong><span style="margin-left: 122px;"></span>
										{{ ($tindakan->kenderaan_pergi!='') ? \App\LkpModel::find($kenderaanPergi->id_model)->jenis_model : 'N/A' }}</p>		
										<p><strong>Nama Pemandu</strong><span style="margin-left: 133px;"></span>
										{{ ($tindakan->kenderaan_pergi!='') ? $kenderaanPergi->nama_pemandu : 'N/A' }}</p>
										<p><strong>No. Tel. Bimbit Pemandu</strong><span style="margin-left: 70px;"></span>
										{{ ($tindakan->kenderaan_pergi!='') ? $kenderaanPergi->no_tel_bimbit : 'N/A' }}</p>					
									</td>		
									@if(isset($tindakan->kenderaan_balik))
									<td>
										<p><strong>No Kenderaan</strong><span style="margin-left: 145px;"></span>
										{{ ($tindakan->kenderaan_balik!='') ? \App\Kenderaan::find($tindakan->kenderaan_balik)->no_plat : 'N/A' }}</p>		
										<p><strong>Jenis Kenderaan</strong><span style="margin-left: 128px;"></span>
										{{ ($tindakan->kenderaan_balik!='') ? \App\LkpJenisKenderaan::find($kenderaanBalik->id_jenis)->jenis_kenderaan : 'N/A' }}</p>	
										<p><strong>Model Kenderaan</strong><span style="margin-left: 122px;"></span>
										{{ ($tindakan->kenderaan_balik!='') ? \App\LkpModel::find($kenderaanBalik->id_model)->jenis_model : 'N/A' }}</p>	
										<p><strong>Nama Pemandu</strong><span style="margin-left: 133px;"></span>
										{{ ($tindakan->kenderaan_balik!='') ? $kenderaanBalik->nama_pemandu : 'N/A' }}</p>
										<p><strong>No. Tel. Bimbit Pemandu</strong><span style="margin-left: 70px;"></span>
										{{ ($tindakan->kenderaan_balik!='') ? $kenderaanBalik->no_tel_bimbit : 'N/A' }}</p>					
									</td>
									@endif
								</tr>
							</tbody>	
						</table>
					</dd>
				@endif
					<dt class="col-sm-2">Tindakan Oleh</dt>
					<?php
						$pegawai = App\PPersonel::where('nokp',$tindakan->peg_penyelia)->first();
					?>
					<dd class="col-sm-10">{{ $pegawai->name }}</dd>		
					<dt class="col-sm-2">Tarikh Tindakan</dt>
					<dd class="col-sm-10">{{ ($tindakan->created_by!='') ? Carbon\Carbon::parse($tindakan->created_by)->format('d.m.Y H:i:s') : '' }}</dd>			
				</dl>
				
            </div>
			@endif
			
			<!-- /.card-body -->
			<div class="card-footer">
				
				<a href="{{ url('tempahankenderaan/kemaskini_tindakan',$tindakan->id_permohonan) }}" class="btn btn-info bg-purple">Kemaskini Tindakan</a>
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

