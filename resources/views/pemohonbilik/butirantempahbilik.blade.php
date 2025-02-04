@extends('layouts/masterScreen')
@section('content')

<!-- Content Header (Page header) -->

<div class="container" onload="window.location.reload()">
	<br>
	<div class="col-sm-12" >
		<div class="row mb-2">
			<div class="col-sm-12" >
				<button  type="button" class="btn btn-light btn-block bg-purple" style="align:center; text-transform:uppercase"><h5>Butiran Tempahan Bilik</h5></button>
			</div>
		</div>
	</div>

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
			<dt class="col-sm-12" style="font-size:19px">ID Tempahan :  <strong>{{  $permohonanBiliks->kod_permohonan }} </strong> &nbsp; &nbsp; | &nbsp; &nbsp; {{ Carbon\Carbon::parse($permohonanBiliks->created_at)->format('d.m.Y') }}</dt>
			<dd class="col-sm-0"></dd>
			{{-- <dd class="col-sm-0"> {{ optional(\App\PLkpBahagian::where('id', $permohonanBiliks->id_bahagian)->first())->bahagian }}</dd> --}}

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
					<dt class="col-sm-2">Pengerusi  </dt>
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
					{{-- <dd class="col-sm-4">{{ $OptBiliks->bilik }}, {{ $OptBiliks->bahagian }}, Aras {{ $OptBiliks->aras }}</dd> --}}
					@if ( $OptBiliks )
						<dd class="col-sm-4">{{ $OptBiliks->bilik }}, {{ $OptBiliks->bahagian }}, Aras {{ $OptBiliks->aras }}</dd>
					@else
						<dd class="col-sm-4"> - </dd>
					@endif
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

								{{-- MAKAN PAGI --}}
								<thead bgcolor ="#D8BFD8">
									<tr>
										@if($tempahMakans->makan_pagi == '1')  <th><center>Makan Pagi</center> </th> 
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
														{{-- <table id="example1" class="table table-bordered table-sm table-responsive-sm"> --}}
														<table id="example1" class="table ">
															<tr class="table-success">
																<th>Menu</th>
																<th>Kalori</th>
															</tr>
															{{-- Initial value total kalori --}}
															<?php
																$totalKalpagi = 0; 
															?>
															@foreach ($menuMakans as $menuMakan)
																@if ($menuMakan->jenis_makan == '1')
																	<tr>
																		<td>{{ $menuMakan->menu }}</td>	
																		<td>{{ $menuMakan->kalori }} kkal</td>	
																	</tr>
																	{{-- Kire total kalori --}}
																	<?php
																		$totalKalpagi+= $menuMakan->kalori; 
																	?>
																@else
																@endif
															@endforeach
															<tr>
																<td colspan="2"><b>Jenis Hidangan : {{ ($tempahMakans->id_jenis_hidangan1!='') ? \App\LkpJenisHidangan ::find($tempahMakans->id_jenis_hidangan1)->jenis_hidangan : '' }}</b> </td>
															</tr>
															<tr>
																<td colspan="2"><b>Jumlah Kalori : <?php echo $totalKalpagi; ?> kkal</b> </td>
															</tr>
														</table>
														{{-- <dt class="col-sm-5">Jumlah Kalori :  {{ $tempahMakans->kalori_pagi }} kkal</dt> --}}
													</div>
											</td>
										@else
										@endif
									</tr>									
								</tbody>

								{{-- MAKAN TENGAHARI --}}
								<thead bgcolor ="#D8BFD8">
									<tr>
										@if($tempahMakans->makan_tghari == '1')  <th><center>Makan Tengahari</center> </th> 
										@else
										@endif
									</tr>
								</thead>
								<tbody>
									<tr>
										@if($tempahMakans->makan_tghari == '1') 
											<td>												
													{{-- Makan Tengahari Table --}}
													<div class="container makan_tengahari">
														<table id="example1" class="table table-bordered table-sm table-responsive-sm">
															<tr class="table-success">
																<th>Menu</th>
																<th>Kalori</th>
															</tr>
															{{-- Initial value total kalori --}}
															<?php
																$totalKaltengahari = 0; 
															?>
															@foreach ($menuMakans as $menuMakan)
																@if ($menuMakan->jenis_makan == '2')
																	<tr>
																		<td>{{ $menuMakan->menu }}</td>	
																		<td>{{ $menuMakan->kalori }} kkal</td>	
																	</tr>
																	{{-- Kire total kalori --}}
																	<?php
																		$totalKaltengahari+= $menuMakan->kalori; 
																	?>
																@else
																@endif
															@endforeach
															<tr>
																<td colspan="2"><b>Jenis Hidangan : {{ ($tempahMakans->id_jenis_hidangan2!='') ? \App\LkpJenisHidangan ::find($tempahMakans->id_jenis_hidangan2)->jenis_hidangan : '' }}</b> </td>
															</tr>
															<tr>
																<td colspan="2"><b>Jumlah Kalori : <?php echo $totalKaltengahari ?> kkal</b>  </td>
															</tr>
														</table>
														{{-- <dt class="col-sm-5">Jumlah Kalori : {{ $tempahMakans->kalori_tengahari }} kkal</dt> --}}
													</div>									
											</td>
										@else
										@endif	
									</tr>									
								</tbody>

								{{-- MINUM PETANG --}}
								<thead bgcolor ="#D8BFD8">
									<tr>
										@if($tempahMakans->minum_petang == '1') <th><center>Minum Petang</center> </th> 
										@else
										@endif
									</tr>
								</thead>
								<tbody>
									<tr>
										@if($tempahMakans->minum_petang == '1') 	
											<td>	
													{{-- Minum Petang Table --}}
													<div class="container minum_petang">
														<table id="example1" class="table table-bordered table-sm table-responsive-sm">
															<tr class="table-success">
																<th>Menu</th>
																<th>Kalori</th>
															</tr>
															{{-- Initial value total kalori --}}
															<?php
																$totalKalpetang = 0; 
															?>
															@foreach ($menuMakans as $menuMakan)
																@if ($menuMakan->jenis_makan == '3')
																	<tr>
																		<td>{{ $menuMakan->menu }}</td>	
																		<td>{{ $menuMakan->kalori }} kkal</td>	
																	</tr>
																	{{-- Kire total kalori --}}
																	<?php
																		$totalKalpetang+= $menuMakan->kalori; 
																	?>
																@else
																@endif
															@endforeach
															<tr>
																<td colspan="2"><b>Jenis Hidangan : {{ ($tempahMakans->id_jenis_hidangan3!='') ? \App\LkpJenisHidangan ::find($tempahMakans->id_jenis_hidangan3)->jenis_hidangan : '' }}</b> </td>
															</tr>
															<tr>
																<td colspan="2"><b>Jumlah Kalori : <?php echo $totalKalpetang ?> kkal</b> </td>
															</tr>
														</table>
														{{-- <dt class="col-sm-5">Jumlah Kalori : {{ $tempahMakans->kalori_petang }} kkal</dt> --}}
													</div>	
											</td>
										@else
										@endif
									</tr>									
								</tbody>

								{{-- MAKAN MALAM --}}
								<thead bgcolor ="#D8BFD8">
									<tr>
										@if($tempahMakans->makan_malam == '1') <th><center>Makan Malam</center> </th> 
										@else
										@endif
									</tr>
								</thead>
								<tbody>
									<tr>
										@if($tempahMakans->makan_malam == '1') 	
											<td>	
													{{-- Makan Malam Table --}}
													<div class="container makan_malam">
														<table id="example1" class="table table-bordered table-sm table-responsive-sm">
															<tr class="table-success">
																<th>Menu</th>
																<th>Kalori</th>
															</tr>
															{{-- Initial value total kalori --}}
															<?php
																$totalKalmalam = 0; 
															?>
															@foreach ($menuMakans as $menuMakan)
																@if ($menuMakan->jenis_makan == '4')
																	<tr>
																		<td>{{ $menuMakan->menu }}</td>	
																		<td>{{ $menuMakan->kalori }} kkal</td>	
																	</tr>
																	{{-- Kire total kalori --}}
																	<?php
																		$totalKalmalam+= $menuMakan->kalori; 
																	?>
																@else
																@endif
															@endforeach
															<tr>
																<td colspan="2"><b>Jenis Hidangan : {{ ($tempahMakans->id_jenis_hidangan4!='') ? \App\LkpJenisHidangan ::find($tempahMakans->id_jenis_hidangan4)->jenis_hidangan : '' }}</b> </td>
															</tr>
															<tr>
																<td colspan="2"><b>Jumlah Kalori : <?php echo $totalKalmalam ?> kkal</b>  </td>
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
						{{-- card body table responsive --}}
						<dt class="col-sm-5"><br>Harga Tempahan Makanan (Per Pax) : RM {{ $tempahMakans->kadar_harga ?? "-"}}</dt>
					@else		
					@endif
					
					
				</dl>
			</div>

			<div class="card-header bg-purple">
				<h3 class="card-title">Status Permohonan</h3>	
			</div>
			<div class="card-body">
				<dl class="row">
					@if ( isset($tindakanStatus))
						<dt class="col-sm-3"></center>Status Tempahan Bilik</center></dt>
						<dd class="col-sm-3">{{ ($tindakanStatus->id_status_tempah!='') ? \App\LkpStatus::find($tindakanStatus->id_status_tempah)->status : '' }}</dd>
						<dt class="col-sm-3"></center>Status Tempahan Makanan</center></dt>
							@if ( $tindakanStatus->id_status_makan == 3 || $tindakanStatus->id_status_makan == 4 || $tindakanStatus->id_status_makan == 6 
									&& $permohonanBiliks->tempah_makan != 2)
								<dd class="col-sm-3">{{ ($tindakanStatus->id_status_makan!='') ? \App\LkpStatus::find($tindakanStatus->id_status_makan)->status : ' - ' }}</dd>
							@else
								<dd class="col-sm-3">  -  </dd>
							@endif
						<dt class="col-sm-3">Catatan</dt>
						<dd class="col-sm-7">{{ ($tindakanStatus->catatan!='') ? $tindakanStatus->catatan : '-' }}</dd>
						<dt class="col-sm-3"><br> Pegawai pelulus</dt>
						@if ($tindakanStatus->id_status_tempah	 == 3)
							@php
								$name = null;
								foreach ($personels as $personel) {
									if($personel->nokp == $tindakanStatus->peg_penyelia) {
										$name = $personel->name;
									}
								}
							@endphp
							<dd class="col-sm-6">
								@php
									echo '<br>'.$name;
								@endphp
							</dd>
						@else
							<dd class="col-sm-6"> <br>- </dd>
						@endif
					@else
						<dt class="col-sm-2"><font color="red"> Status</font></dt>
						<dd class="col-sm-10"> <font color="red">Maklumat tidak dimasuk dengan betul. Sila tekan kemaskini dan kemaskini semula tempahan anda.</font> </dd>
					@endif
					
				</dl>
			</div>


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
							case "2": $color="#FFB300"; $status="Dalam Proses"; break; //biru
							//lulus
							case "3":  $color="#32CD32"; $status="Lulus"; break; //hijau
							//Tidak Diluluskan
							case "4": $color="#FF0000"; $status="Tidak Diluluskan"; break; //merah
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
						{{-- <td> {{ ($tindakan1->id_status_tempah!='') ? \App\LkpStatus::find($tindakan1->id_status_tempah)->status : '' }} </td> --}}
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
						<td>{{ Carbon\Carbon::parse($tindakan1->created_by)->format('d.m.Y H:i') }}</td>
					</tr>
					@endforeach
					</tbody>
				</table>
				<!-- /.card-body -->
			</div>

			<!-- /.card-body -->
			<div class="card-footer">

				@if($cariPemohon->id_pemohon == $idPemohon)
					@if($permohonanBiliks->id_status == 1 ||  $permohonanBiliks->id_status == 5)
					<a href="{{ url('pemohon/tempahanbilik/kemaskini/'.$permohonanBiliks->id_permohonan_bilik) }}" class="btn btn-sm btn-info bg-purple"><i class="fa fa-edit"></i> | Kemaskini</a>
					<a href="{{ url('pemohon/tempahanbilik/batal/'.$permohonanBiliks->id_permohonan_bilik) }}" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> | Batal</a>
					@else
					@endif
				@endif
				{{-- @if($permohonanBiliks->id_status == 3 )
				@endif --}}
				{{-- <button type="button" class="btn btn-sm btn-default float-right" onclick="history.back();"><i class="fas fa-redo-alt"></i> | Kembali</button> --}}
				{{-- <a href="{{ url('/search/'.$pemohon->mykad) }}" class="btn btn-sm btn-default float-right" title="Laman Utama"><i class="fa fa-home"></i> | Laman Utama</a> --}}
				{{-- <a href="{{ url('pemohon/semak',$pemohon->mykad) }}" class="btn btn-sm btn-default float-right"><i class="fas fa-redo-alt"></i> | Kembali </a> --}}
				<a href="{{ url('pemohon/semak',$pemohon->nokp) }}" class="btn btn-sm btn-default float-right"><i class="fas fa-redo-alt"></i> | Kembali </a>
				{{-- <a href="{{ url('/pemohon/tempahanbilik/'.$pemohon->mykad) }}" class="btn btn-sm btn-default float-right" title="Kalendar Tempahan"><i class="fa fa-calendar"></i> |</a>
				<a href="{{ url('pemohon/semak/'.$pemohon->mykad) }}" class="btn btn-sm btn-default float-right" title="Semak Tempahan"><i class="fa fa-list"></i> | </a> --}}
				
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


@endsection

@section('script')
<script>
</script>
@endsection
