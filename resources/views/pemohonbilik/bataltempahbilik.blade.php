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
	<div class="col-sm-12">
		<div class="row mb-2">
			<div class="col-sm-12">
				<button type="button" class="btn btn-danger btn-block" style="text-transform:uppercase"><h5>Batal Tempahan Bilik</h5></button>
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
			
	<div class="col-sm-12">
		<div class="card card-info">
			<dt class="col-sm-12" style="font-size:19px">ID Tempahan :  <strong>{{  $permohonanBiliks->kod_permohonan }} </strong> &nbsp; &nbsp; | &nbsp; &nbsp; {{ Carbon\Carbon::parse($permohonanBiliks->created_at)->format('d.m.Y') }}</dt>
			<dd class="col-sm-0"></dd>

			<div class="card-header bg-purple">
                <h3 class="card-title">Maklumat Pemohon</h3>
			</div>
              <!-- /.card-header -->
              <!-- form start -->
			<form class="form-horizontal" method="POST" action="{{ url('pemohon/tempahanbilik/batal/'.$permohonanBiliks->id_permohonan_bilik) }}" enctype="multipart/form-data">
			{{ csrf_field() }}
			 <!-- style="margin:0px 0px 5px 0px; width:70%;"  -->
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
					{{-- <dd class="col-sm-4">{{ $pemohon->bahagian_id }}</dd> --}}
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
				<h3 class="card-title">Maklumat Tempahan</h3>
			</div>
			<div class="card-body">
				<dl class="row">
					<dt class="col-sm-2">Tujuan</dt>
					<dd class="col-sm-4">{{ ($permohonanBiliks->id_tujuan!='') ? \App\LkpTujuan::find($permohonanBiliks->id_tujuan)->tujuan : '' }}</dd>
					<dt class="col-sm-2">Pengerusi </dt>
						@php
							$namePengerusi = null;
							foreach ($personels as $personel) {
								if($personel->id == $permohonanBiliks->nama_pengerusi) {
									$namePengerusi = $personel->name;
								}
							}
						@endphp
					<dd class="col-sm-4">
						@php
							echo $namePengerusi;
						@endphp
					</dd>
					<dt class="col-sm-2">Tarikh Mula</dt>
					<dd class="col-sm-4">
						{{ Carbon\Carbon::parse($permohonanBiliks->tkh_mula)->format('d.m.Y') }}
						<?php
							\Carbon\Carbon::setLocale('ms');
							echo '('.\Carbon\Carbon::parse($permohonanBiliks->tkh_mula)->dayName.')'; 
						?>
					</dd>
					<dt class="col-sm-2">Masa Mula</dt>
					<dd class="col-sm-4">{{ Carbon\Carbon::parse($permohonanBiliks->masa_mula)->format('g:i A') }}</dd>
					<dt class="col-sm-2">Tarikh Tamat</dt>
					<dd class="col-sm-4">
						{{ ($permohonanBiliks->tkh_hingga!='') ? Carbon\Carbon::parse($permohonanBiliks->tkh_hingga)->format('d.m.Y') : '-' }}
						<?php
							\Carbon\Carbon::setLocale('ms');
							echo '('.\Carbon\Carbon::parse($permohonanBiliks->tkh_hingga)->dayName.')'; 
						?>
					</dd>
					<dt class="col-sm-2">Masa Tamat</dt>
					<dd class="col-sm-4">{{ ($permohonanBiliks->masa_hingga!='') ? Carbon\Carbon::parse($permohonanBiliks->masa_hingga)->format('g:i A') : '-' }}</dd>
					<dt class="col-sm-2">Nama Bilik</dt>
					<dd class="col-sm-4">{{ $OptBiliks->bilik }}, {{ $OptBiliks->bahagian }}, Aras {{ $OptBiliks->aras }}</dd>
					{{-- <dd class="col-sm-4">{{ ($permohonanBiliks->id_bilik!='') ? \App\LkpBilik::find($permohonanBiliks->id_bilik)->bilik : '' }}</dd> --}}
					<dt class="col-sm-2">Bil. Ahli Mesyuarat <br><small><i>  (Bilangan Ahli Mesyuarat yang <b>terlibat</b>.)  </i></small></dt>
					<dd class="col-sm-4">{{ $permohonanBiliks->bil_peserta }} orang </dd>

					<dt class="col-sm-2">Nama Mesyuarat / Seminar / Bengkel / Kursus / Program </dt>
					<dd class="col-sm-10">{{ ($permohonanBiliks->nama_tujuan!='') ? $permohonanBiliks->nama_tujuan :'-' }}</dd>	

					<dt class="col-sm-2"><br>Makanan</dt>
					<dd class="col-sm-10"><br>@if($permohonanBiliks->tempah_makan =='1') Diperlukan<br> @else Tidak Diperlukan @endif</dd>

					
					{{-- Kuar Senarai Makanan --}}
					@if ($permohonanBiliks->tempah_makan == '1')
					<dt class="col-sm-10"> <br>Senarai Tempahan Makanan</dt>
						<div class="card-body table-responsive">
							<table id="example1" class="table table-bordered table-sm table-responsive-sm">
								<thead bgcolor ="#D8BFD8">
									<tr>
										@if($tempahMakans->makan_pagi == '1')  <th><center>Makan Pagi</center> </th> 
										@else
										@endif

										@if($tempahMakans->makan_tghari == '1')  <th><center>Makan Tengahari</center> </th> 
										@else
										@endif

										@if($tempahMakans->minum_petang == '1') <th><center>Minum Petang</center> </th> 
										@else
										@endif

										@if($tempahMakans->makan_malam == '1') <th><center>Makan Malam</center> </th> 
										@else
										@endif
									</tr>
								</thead>
								<tbody>
									<tr>
										@if($tempahMakans->makan_pagi == '1') 
											<td> 
													{{-- Makan Pagi Table --}}
													<div class="container makan_pagi">
														<table id="example1" class="table table-bordered table-sm table-responsive-sm">
															<tr">
																<th>Menu</th>
																<th>Kalori</th>
															</tr>
															@foreach ($menuMakans as $menuMakan)
																@if ($menuMakan->jenis_makan == '1')
																	<tr>
																		<td>{{ $menuMakan->menu }}</td>	
																		<td>{{ $menuMakan->kalori }} kkal</td>	
																	</tr>
																@else
																@endif
															@endforeach
															<tr>
																<td colspan="2"><center><b>Jenis Hidangan : {{ ($tempahMakans->id_jenis_hidangan1!='') ? \App\LkpJenisHidangan ::find($tempahMakans->id_jenis_hidangan1)->jenis_hidangan : '' }}</b> </center></td>
															</tr>
															<tr>
																<td colspan="2"><center><b>Jumlah Kalori : {{ $tempahMakans->kalori_pagi }} kkal</b> </center> </td>
															</tr>
														</table>
														{{-- <dt class="col-sm-5">Jumlah Kalori :  {{ $tempahMakans->kalori_pagi }} kkal</dt> --}}
													</div>
											</td>
										@else
										@endif

										@if($tempahMakans->makan_tghari == '1') 
											<td>												
													{{-- Makan Tengahari Table --}}
													<div class="container makan_tengahari">
														<table id="example1" class="table table-bordered table-sm table-responsive-sm">
															<tr>
																<th>Menu</th>
																<th>Kalori</th>
															</tr>
															@foreach ($menuMakans as $menuMakan)
																@if ($menuMakan->jenis_makan == '2')
																	<tr>
																		<td>{{ $menuMakan->menu }}</td>	
																		<td>{{ $menuMakan->kalori }} kkal</td>	
																	</tr>
																@else
																@endif
															@endforeach
															<tr>
																<td colspan="2"><center><b>Jenis Hidangan : {{ ($tempahMakans->id_jenis_hidangan2!='') ? \App\LkpJenisHidangan ::find($tempahMakans->id_jenis_hidangan2)->jenis_hidangan : '' }}</b> </center></td>
															</tr>
															<tr>
																<td colspan="2"><center><b>Jumlah Kalori : {{ $tempahMakans->kalori_tengahari }} kkal</b> </center> </td>
															</tr>
														</table>
														{{-- <dt class="col-sm-5">Jumlah Kalori : {{ $tempahMakans->kalori_tengahari }} kkal</dt> --}}
													</div>									
											</td>
										@else
										@endif	

										@if($tempahMakans->minum_petang == '1') 	
											<td>	
													{{-- Minum Petang Table --}}
													<div class="container minum_petang">
														<table id="example1" class="table table-bordered table-sm table-responsive-sm">
															<tr>
																<th>Menu</th>
																<th>Kalori</th>
															</tr>
															@foreach ($menuMakans as $menuMakan)
																@if ($menuMakan->jenis_makan == '3')
																	<tr>
																		<td>{{ $menuMakan->menu }}</td>	
																		<td>{{ $menuMakan->kalori }} kkal</td>	
																	</tr>
																@else
																@endif
															@endforeach
															<tr>
																<td colspan="2"><center><b>Jenis Hidangan : {{ ($tempahMakans->id_jenis_hidangan3!='') ? \App\LkpJenisHidangan ::find($tempahMakans->id_jenis_hidangan3)->jenis_hidangan : '' }}</b> </center></td>
															</tr>
															<tr>
																<td colspan="2"><center><b>Jumlah Kalori : {{ $tempahMakans->kalori_petang }} kkal</b> </center> </td>
															</tr>
														</table>
														{{-- <dt class="col-sm-5">Jumlah Kalori : {{ $tempahMakans->kalori_petang }} kkal</dt> --}}
													</div>	
											</td>
										@else
										@endif

										@if($tempahMakans->makan_malam == '1') 	
											<td>	
													{{-- Makan Malam Table --}}
													<div class="container makan_malam">
														<table id="example1" class="table table-bordered table-sm table-responsive-sm">
															<tr>
																<th>Menu</th>
																<th>Kalori</th>
															</tr>
															@foreach ($menuMakans as $menuMakan)
																@if ($menuMakan->jenis_makan == '4')
																	<tr>
																		<td>{{ $menuMakan->menu }}</td>	
																		<td>{{ $menuMakan->kalori }} kkal</td>	
																	</tr>
																@else
																@endif
															@endforeach
															<tr>
																<td colspan="2"><center><b>Jenis Hidangan : {{ ($tempahMakans->id_jenis_hidangan4!='') ? \App\LkpJenisHidangan ::find($tempahMakans->id_jenis_hidangan4)->jenis_hidangan : '' }}</b> </center></td>
															</tr>
															<tr>
																<td colspan="2"><center><b>Jumlah Kalori : {{ $tempahMakans->kalori_malam }} kkal</b> </center> </td>
															</tr>
														</table>
														{{-- <dt class="col-sm-5">Jumlah Kalori : {{ $tempahMakans->kalori_petang }} kkal</dt> --}}
													</div>	
											</td>
										@else
										@endif
									</tr>
								</tbody>
							</table>
						</div> 
						<dt class="col-sm-12"><br>Harga Tempahan Makanan : RM {{ $tempahMakans->kadar_harga ?? "-"}}</dt>
						
					@else		
					@endif
					
					<dt class="col-sm-4"><br> Alasan Pembatalan: 
						<textarea class="form-control" name="catatanBatal" id="catatanBatal" cols="2" rows="1"></textarea>
					</dt>
						
				</dl>
			</div>
				
			<!-- /.card-body -->
			<div class="card-footer">
			  <span class="text-danger">Anda pasti ingin batalkan tempahan ini?</span> &nbsp;
			  <button type="submit" name="batal_tempahan" class="btn btn-danger">Ya, Batal</button>
			  {{-- <button type="button" class="btn btn-default" onclick="history.back();">Tidak</button> --}}
			  <a href="{{ url('/pemohon/tempahanbilik/butiran/' . $permohonanBiliks->id_permohonan_bilik . '/' . $permohonanBiliks->id_pemohon) }}" 
				class="btn btn-default"> Tidak</a>
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

