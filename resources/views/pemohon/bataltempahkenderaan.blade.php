@extends('layouts/masterScreen')
@section('content')


            <!-- Horizontal Form -->
<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		
	
	</div><!-- /.container-fluid -->
</div>
<div class="container">
<br>
	<div class="col-sm-11">
		<div class="row mb-2">
			<div class="col-sm-12">
				<button type="button" class="btn btn-danger btn-block" style="text-transform:uppercase"><h5>Batal Tempahan Kenderaan</h5></button>
			</div>
		</div>
	</div>	
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
			</div>
	
		</div>
	</div><!-- /.container-fluid -->
			
	<div class="col-sm-11">
		<div class="card card-info">
			<div class="card-header bg-purple">
                <h3 class="card-title">Maklumat Pemohon</h3>
			</div>
              <!-- /.card-header -->
              <!-- form start -->
			<form class="form-horizontal" method="POST" action="{{ url('pemohon/tempahankenderaan/batal/'.$permohonanKenderaan->id_maklumat_permohonan) }}" enctype="multipart/form-data">
			{{ csrf_field() }}
			 <!-- style="margin:0px 0px 5px 0px; width:70%;"  -->
			<div class="card-body">
				<dl class="row">
					<dt class="col-sm-2" align ="justify">Nama Pemohon</dt>
					<dd class="col-sm-10">{{ $pemohon->name }}</dd>
					<!-- <dt class="col-sm-3">Permohonan Bagi Pihak</dt>
					<dd class="col-sm-9">{{ ($pemohon->pohon_bagi!='') ? $pemohon->pohon_bagi: '-' }}</dd> -->
					<dt class="col-sm-2">Jawatan</dt>
					<dd class="col-sm-4">{{ $pemohon->jawatan }}</dd>
					<dt class="col-sm-2">Gred</dt>
					<dd class="col-sm-4">{{ $pemohon->gred }}</dd>
					<dt class="col-sm-2">Bahagian</dt>
					<dd class="col-sm-4">{{ optional(\App\PLkpBahagian::find($pemohon->bahagian_id))->bahagian ?? '-' }}</dd>
					<dt class="col-sm-2">E-mel</dt>
					<dd class="col-sm-4">{{ $pemohon->email }}</dd>
					<dt class="col-sm-2">No. Tel. Pejabat</dt>
					<dd class="col-sm-4">{{ $pemohon->tel }}</dd>
					<dt class="col-sm-2">No. Tel. Bimbit</dt>
					<dd class="col-sm-4">{{ $pemohon->tel_bimbit }}</dd>
					
				</dl>
            </div>
			
			<div class="card-header bg-purple">
				<h3 class="card-title">Maklumat Penumpang </h3>
			</div>
			<div class="card-body">
				<dl class="row">
						<dt class="col-sm-2">Bil. Penumpang <small><i>  (Termasuk Pemohon)  </i></small></dt>
						<dd class="col-sm-4">{{ $permohonanKenderaan->bil_penumpang }} orang </dd>
				</dl>
			@if(!$penumpangs->isEmpty())
			<!-- <dt class="col-sm-3">Senarai Penumpang</dt> -->
                <table id="example1" class="table table-bordered table-sm table-responsive-sm ">
                	<thead bgcolor ="#D8BFD8">
						<tr>
							<th><center>Bil.</center></th>
							<th><center>Nama</center> </th>
							<th><center>Bahagian</center></th>
							<th><center>No. Tel. Bimbit</center></th>
							<th><center>Emel</center></th>
							<!-- <th></th> -->
						</tr>
                  	</thead>
                  	<tbody>
						@foreach ($penumpangs as $penumpang)
						<tr>
							<td>{{ $loop->iteration }}</td>
							<td> {{ $penumpang->nama }} </td>
							<td>{{ $penumpang->bahagian }}</td>
							<td>{{ $penumpang->no_tel }}</td>
							<td>{{ $penumpang->emel }}</td>
							
						</tr>
						@endforeach
                  	</tbody>
                </table>
                <!-- /.card-body -->
			@endif
			</div>
			
			<div class="card-header bg-purple">
				<h3 class="card-title">Maklumat Tempahan</h3>
			</div>
			<div class="card-body">
				<dl class="row">
					<dt class="col-sm-2">Jenis Perjalanan</dt>
					<dd class="col-sm-4">{{ ($permohonanKenderaan->id_jenis_perjalanan!='') ? \App\LkpJenisPerjalanan::find($permohonanKenderaan->id_jenis_perjalanan)->jenis_perjalanan : '' }}</dd>
					<dt class="col-sm-2">Tujuan</dt>
					<dd class="col-sm-4">{{ ($permohonanKenderaan->id_tujuan!='') ? \App\LkpTujuan::find($permohonanKenderaan->id_tujuan)->tujuan : '' }}</dd>
					<dt class="col-sm-2">Tarikh Pergi</dt>
					<dd class="col-sm-4">{{ Carbon\Carbon::parse($permohonanKenderaan->tkh_pergi)->format('d.m.Y') }}</dd>
					<dt class="col-sm-2">Masa Pergi</dt>
					<dd class="col-sm-4">{{ Carbon\Carbon::parse($permohonanKenderaan->masa_pergi)->format('g:i A') }}</dd>
					<dt class="col-sm-2">Tarikh Balik</dt>
					<dd class="col-sm-4">{{ ($permohonanKenderaan->tkh_balik!='') ? Carbon\Carbon::parse($permohonanKenderaan->tkh_balik)->format('d.m.Y') : '-' }}</dd>
					<dt class="col-sm-2">Masa Balik</dt>
					<dd class="col-sm-4">{{ ($permohonanKenderaan->masa_balik!='') ? Carbon\Carbon::parse($permohonanKenderaan->masa_balik)->format('g:i A') : '-' }}</dd>
					<dt class="col-sm-2">Negeri</dt>
					<dd class="col-sm-4">{{ ($permohonanKenderaan->id_negeri!='') ? \App\RLkpNegeri::find($permohonanKenderaan->id_negeri)->negeri : '' }}</dd>
					<dt class="col-sm-2">Lokasi/Tempat</dt>
					<dd class="col-sm-4">{{ $permohonanKenderaan->lokasi_tujuan }}</dd>
					
					<dt class="col-sm-2">Nama Mesyuarat / Seminar / Bengkel / Kursus / Program </dt>
					<dd class="col-sm-10">{{ ($permohonanKenderaan->keterangan_lanjut!='') ? $permohonanKenderaan->keterangan_lanjut :'-' }}</dd>
					<dt class="col-sm-2">Lampiran</dt>
					<dd class="col-sm-10" text-align:left>
						@if($permohonanKenderaan->lampiran!='')
						<a href="{{ url(''.$permohonanKenderaan->lampiran) }}" class="btn-sm btn-default" target="_blank"><i class="fa fa-paperclip"></i> {{ $permohonanKenderaan->lampiran }}</a>
						@else -
						@endif
					</dd>
				</dl>
            </div>
				
			<!-- /.card-body -->
			<div class="card-footer">
			  <span class="text-danger">Anda pasti ingin batalkan tempahan ini?</span> &nbsp;
			  <button type="submit" name="batal_tempahan" class="btn btn-danger">Ya, Batal</button>
			  <button type="button" class="btn btn-default" onclick="history.back();">Tidak</button>
			</div>
			<!-- /.card-footer -->
			
			</form>
		
		</div>
         <!-- /.card -->
	</div>
	<!-- /.col -->
</div><!-- /.container-->
@endsection

@section('script')
	<script>
	$(function () {
		$("#example1").DataTable({
		  "responsive": true, "lengthChange": false, "autoWidth": false, "searching" : false,  "ordering" : false, "info" : false, "paging": false,
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

