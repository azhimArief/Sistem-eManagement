@extends('layouts/masterScreen')
@section('content')

<!-- Content Header (Page header) -->
<!-- <div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-12">
				<button type="button" class="btn btn-light btn-block bg-purple" style="text-transform:uppercase"><h5>Butiran Tempahan Kenderaan</h5></button>
			</div>
		</div> -->
<!-- general form elements disabled -->
<div class="container">
	<br>
	<div class="col-sm-12" >
		<div class="row mb-2">
			<div class="col-sm-12" >
				<button  type="button" class="btn btn-light btn-block bg-purple" style="align:center; text-transform:uppercase"><h5>Butiran Tempahan Kenderaan</h5></button>
			</div>
		</div>
	</div>

	<!-- <h5 class="m-0">ID Tempahan : {{ $permohonanKenderaan->kod_permohonan }}</h5> -->
	<!-- </div> -->
	<!-- /.container-fluid -->
	<div class="container-fluid">
		<div class="row">
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
	</div>
	<!-- Horizontal Form -->
	<div class="col-sm-12">
		<div class="card card-info">
			<dt class="col-sm-12" style="font-size:19px">ID Tempahan :  <strong>{{  $permohonanKenderaan->kod_permohonan }} </strong> &nbsp; &nbsp; | &nbsp; &nbsp; {{ Carbon\Carbon::parse($permohonanKenderaan->created_by)->format('d.m.Y') }}</dt>
			<dd class="col-sm-0"></dd>
			{{-- <dd class="col-sm-0"> {{ optional(\App\PLkpBahagian::where('id', $permohonanKenderaan->id_bahagian)->first())->bahagian }}</dd> --}}

			<div class="card-header bg-purple">
				<h3 class="card-title">Maklumat Pemohon</h3>
			</div>
			<!-- /.card-header -->

			<div class="card-body">
				<dl class="row">
					<dt class="col-sm-2" align ="justify">Nama Pemohon</dt>
					<dd class="col-sm-10">{{ $pemohon->name }}</dd>
					{{-- <dd class="col-sm-10">{{ $pemohon->nama }}</dd> --}}
					<!-- <dt class="col-sm-3">Permohonan Bagi Pihak</dt>
					<dd class="col-sm-9">{{ ($pemohon->pohon_bagi!='') ? $pemohon->pohon_bagi: '-' }}</dd> -->
					<dt class="col-sm-2">Jawatan</dt>
					<dd class="col-sm-4">{{ $pemohon->jawatan }}</dd>
					<dt class="col-sm-2">Gred</dt>
					<dd class="col-sm-4">{{ $pemohon->gred }}</dd>
					<dt class="col-sm-2">Bahagian</dt>
					<dd class="col-sm-4">{{ optional(\App\PLkpBahagian::find($pemohon->bahagian_id))->bahagian ?? '-' }}</dd>
					{{-- <dd class="col-sm-4">{{ $pemohon->bahagian }}</dd> --}}
					<dt class="col-sm-2">E-mel</dt>
					<dd class="col-sm-4">{{ $pemohon->email }}</dd>
					{{-- <dd class="col-sm-4">{{ $pemohon->emel }}</dd> --}}
					<dt class="col-sm-2">No. Tel. Pejabat</dt>
					<dd class="col-sm-4">{{ $pemohon->tel }}</dd>
					{{-- <dd class="col-sm-4">{{ $pemohon->telefon }}</dd> --}}
					<dt class="col-sm-2">No. Tel. Bimbit</dt>
					<dd class="col-sm-4">{{ $pemohon->tel_bimbit }}</dd>

				</dl>
			</div>

			<div class="card-header bg-purple">
				<h3 class="card-title">Maklumat Penumpang </h3>
				&nbsp;&nbsp;<i style="color: #ffffff;" class="fa fa-question-circle" data-html="true" data-toggle="tooltip" title="Maklummat Penumpang Adalah Tidak Termasuk Pemohon." data-original-title="Maklummat Penumpang Adalah Tidak Termasuk Pemohon."></i>
			</div>
			<div class="card-body">
				<dl class="row">
						<dt class="col-sm-2">Bil. Penumpang <br><small><i>  (Bilangan penumpang <b>termasuk</b> pemohon.)  </i></small></dt>
						<dd class="col-sm-4">{{ $permohonanKenderaan->bil_penumpang }} orang </dd>
				</dl>
				<dl class="row">
					<dt class="col-sm-2">Senarai Penumpang</dt>
					@if(!$penumpangs->isEmpty())
					<dt class="col-sm-2">&nbsp;</dt>	
					<dd  class="col-sm-10">
						<table id="example1" class="table table-bordered table-sm table-responsive-sm " style="width:120%">
							<thead bgcolor ="#D8BFD8">
								<tr>
									<th><center>Bil.</center></th>
									<th><center>Nama</center> </th>
									<th><center>Gred</center> </th>
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
								<td> {{ $penumpang->gred }} </td>
								<td>{{ $penumpang->bahagian }}</td>
								<td>{{ $penumpang->no_tel }}</td>
								<td>{{ $penumpang->emel }}</td>

							</tr>
							@endforeach
							</tbody>
						</table>
					</dd>
					@else
						
					<dd class="col-sm-4">-</dd>
					@endif

				</dl>
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
					<dd class="col-sm-4">{{ ($permohonanKenderaan->tkh_pergi!='') ? Carbon\Carbon::parse($permohonanKenderaan->tkh_pergi)->format('d.m.Y') : '-' }}</dd>
					<dt class="col-sm-2">Masa Pergi</dt>
					<dd class="col-sm-4">{{ ($permohonanKenderaan->masa_pergi!='') ? Carbon\Carbon::parse($permohonanKenderaan->masa_pergi)->format('g:i A') : '-' }}</dd>
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

			@if(isset($tindakan))
			<div class="card-header bg-purple">
				<h3 class="card-title">Tindakan Seksyen Pentadbiran</h3>
				
			</div>
			<div class="card-body">
				<dl class="row">
					<dt class="col-sm-2"></center>Status</center></dt>
					<dd class="col-sm-10">{{ ($tindakan->id_status_tempah!='') ? \App\LkpStatus::find($tindakan->id_status_tempah)->status : '' }}</dd>
					<dt class="col-sm-2">Catatan</dt>
					<dd class="col-sm-10">{{ ($tindakan->catatan!='') ? $tindakan->catatan : '-' }}</dd>
					@if( $tindakan->id_status_tempah !== 4 && $tindakan->id_status_tempah !== 5)
					<dt>&nbsp;</dt>
					<dd class="col-sm-12">
						<table class="table table-bordered table-sm table-responsive-sm "  style="width:100%;">
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
								<td >
									<p><strong> No. Kenderaan</strong><span style="margin-left: 95px;"></span>
									{{ ($tindakan->kenderaan_pergi!='') ? \App\Kenderaan::find($tindakan->kenderaan_pergi)->no_plat : 'N/A' }}</p>
									<p><strong>Jenis Kenderaan</strong><span style="margin-left: 78px;"></span>
									{{ ($tindakan->kenderaan_pergi!='') ? $kenderaanPergi->jenis_kenderaan : 'N/A' }}</p>
									<p><strong>Model Kenderaan</strong><span style="margin-left: 72px;"></span>
									{{ ($tindakan->kenderaan_pergi!='') ? $kenderaanPergi->jenis_model : 'N/A' }}</p>
									<p><strong>Nama Pemandu</strong><span style="margin-left: 83px;"></span>
									{{ ($tindakan->kenderaan_pergi!='') ? $kenderaanPergi->nama_pemandu : 'N/A' }}</p>
									<p><strong>No. Tel. Bimbit Pemandu</strong><span style="margin-left: 23px;"></span>
									{{ ($tindakan->kenderaan_pergi!='') ? $kenderaanPergi->no_tel_bimbit : 'N/A' }}</p>
								</td>
								@if(isset($tindakan->kenderaan_balik))
								<td>
									<p><strong>No. Kenderaan</strong><span style="margin-left: 95px;"></span>
									{{ ($tindakan->kenderaan_balik!='') ? \App\Kenderaan::find($tindakan->kenderaan_balik)->no_plat : 'N/A' }}</p>
									<p><strong>Jenis Kenderaan</strong><span style="margin-left: 78px;"></span>
									{{ ($tindakan->kenderaan_balik!='') ? $kenderaanBalik->jenis_kenderaan : 'N/A' }}</p>
									<p><strong>Model Kenderaan</strong><span style="margin-left: 72px;"></span>
									{{ ($tindakan->kenderaan_balik!='') ? $kenderaanBalik->jenis_model : 'N/A' }}</p>
									<p><strong>Nama Pemandu</strong><span style="margin-left: 83px;"></span>
									{{ ($tindakan->kenderaan_balik!='') ? $kenderaanBalik->nama_pemandu : 'N/A' }}</p>
									<p><strong>No. Tel. Bimbit Pemandu</strong><span style="margin-left: 23px;"></span>
									{{ ($tindakan->kenderaan_balik!='') ? $kenderaanBalik->no_tel_bimbit : 'N/A' }}</p>
								</td>
								@endif
							</tr>
						</tbody>
						</table>
					</dd>
					@endif
				</dl>
			</div>
			@endif
			<div class="card-header bg-navy">
				<h3 class="card-title"> Log Tindakan </h3>
			</div>
			<div class="card-body table-responsive">
				<table class="table table-bordered table-sm">
					<thead bgcolor ="#A7C7E7">
						<tr>
							<th>Bil.</th>
							<th>Status</th>
							<th>Tindakan Oleh</th>
							<th>Tarikh</th>
						</tr>
					</thead>
					<tbody>
					@foreach ($tindakans as $tindakan1)
					<tr>
						<td>{{ $loop->iteration }}</td>
						<?php
						$status = $tindakan1->id_status_tempah;
						$color = "";
						switch($status){
							//permohonan baru
							case "1": $color="#FFB300"; $status="Permohonan Baru"; break; //kuning
							//telah dikemaskini
							case "2": $color="#FFB300"; $status="Dikemaskini"; break; //biru
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
						<td>{{ $status }}<br/>
						</td>
						@php
							$name = null;
							foreach ($personels as $personel) {
								if($personel->nokp == $tindakan1->peg_penyelia) {
									$name = $personel->name;
								}
							}
						@endphp
						{{-- <td> {{ ($tindakan1->peg_penyelia!='') ? \App\PPersonel::find($tindakan1->peg_penyelia)->nokp : '' }} </td>  --}}
						<td>
							@php
								echo $name;
							@endphp
						</td>
						{{-- <td> {{ ($tindakan1->peg_penyelia!='') ? \App\PPersonel::find($tindakan1->peg_penyelia)->name : '' }} </td> --}}
						<td>{{ Carbon\Carbon::parse($tindakan1->created_by)->format('d.m.Y H:i') }}</td>

					</tr>
					@endforeach
					</tbody>
				</table>
				<!-- /.card-body -->
			</div>
			<!-- /.card-body -->
			<div class="card-footer">
			<!-- if user PEMOHON -->

				@if($permohonanKenderaan->id_status == 1 || $permohonanKenderaan->id_status == 2 || $permohonanKenderaan->id_status == 5)
				<a href="{{ url('pemohon/tempahankenderaan/kemaskini/'.$permohonanKenderaan->id_maklumat_permohonan) }}" class="btn btn-sm btn-info bg-purple"><i class="fa fa-edit"></i> | Kemaskini</a>
				<a href="{{ url('pemohon/tempahankenderaan/batal/'.$permohonanKenderaan->id_maklumat_permohonan) }}" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> | Batal</a>
				@endif

				<!-- <a href="{{ url('cetak/permohonan/'.$permohonanKenderaan->id_maklumat_permohonan) }}" class="btn btn-sm btn-secondary" target="_blank"><i class="fa fa-print"></i> | Cetak</a> -->
				@if($permohonanKenderaan->id_status == 3 )
				<!-- if status lulus  -->
				<!-- <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#myModal"><i class="fa fa-check"></i> | Sahkan</button> -->
				@endif
				{{-- <button type="button" class="btn btn-sm btn-default float-right" onclick="history.back();"><i class="fas fa-redo-alt"></i> | Kembali</button> --}}
				{{-- <a href="{{ url('pemohon/semak',$pemohon->mykad) }}" class="btn btn-sm btn-default float-right"><i class="fas fa-redo-alt"></i> | Kembali </a> --}}
				<a href="{{ url('pemohon/semak',$pemohon->nokp) }}" class="btn btn-sm btn-default float-right"><i class="fas fa-redo-alt"></i> | Kembali </a>
			</div>
				<!-- /.card-footer -->
		</div>
		<!-- /.card -->
	</div>
				<!-- </div> -->
				<!--/.col (right) -->
			<!-- </div> -->
			<!-- /.row -->
		<!-- </div> -->
	<!-- </div> -->
	<!-- /.container-fluid -->
</div>

	


	<!-- Modal -->
	<div class="modal fade" id="myModal" role="dialog">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">

					<h4 class="modal-title">Pengesahan Tempahan</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<form role="form" method="POST" action="{{ url('pemohon/tempahankenderaan/sahkan/'.$permohonanKenderaan->id_maklumat_permohonan) }}" enctype="multipart/form-data">
					{{ csrf_field() }}

				<div class="modal-body">

					<!-- Status Tindakan -->
					<div class="form-group">
						<h6 class="modal-title">Sila sahkan tempahan anda.</h6>
					</div>

				</div>

				<div class="modal-footer" style="display: flex; align-items: center; justify-content: center;">

					<!-- Butang Submit -->
					<input class="btn btn-info" type="submit" name="button" id="button" value="Setuju" onclick="#" />
					<button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>
					<!-- <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button> -->
					<!-- ./Butang Submit -->
				</div>
				</form>

			</div>
		</div>
	</div>


@endsection

@section('script')
<script>
	$(function () {
		$("#example1").DataTable({
		  "responsive": true, "lengthChange": false, "autoWidth": false,  "searching": false, "info": false, "paging": false, "ordering": false,
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
