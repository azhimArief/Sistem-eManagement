@extends('layouts/master')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">BUTIRAN TEMPAHAN</h1>
          </div><!-- /.col -->
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/homeBilikMeet') }}">Laman Utama</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/tempahanbilik') }}">Tempahan Bilik</a></li>
              <li class="breadcrumb-item active">Butiran</li>
            </ol>
          </div>
          <!-- /.col -->
        </div><!-- /.row -->
		
		<h5 class="m-0">ID Tempahan : {{ $permohonanBilik->kod_permohonan }}</h5>
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
			<div class="card card-info ">
              <div class="card-header bg-purple">
                <h3 class="card-title">Maklumat Pemohon</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
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
				<h3 class="card-title">Maklumat Tempahan</h3>
			</div>
			<div class="card-body">
				<dl class="row">
					<dt class="col-sm-2">Tujuan</dt>
					<dd class="col-sm-4">{{ ($permohonanBilik->id_tujuan!='') ? \App\LkpTujuan::find($permohonanBilik->id_tujuan)->tujuan : '' }}</dd>
					<dt class="col-sm-2">Pengerusi  </dt>
						@php
							$namePengerusi = null;
							foreach ($personels as $personel) {
								if($personel->id == $permohonanBilik->nama_pengerusi) {
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
						{{ Carbon\Carbon::parse($permohonanBilik->tkh_mula)->format('d.m.Y') }}
						<?php
							\Carbon\Carbon::setLocale('ms');
							echo '('.\Carbon\Carbon::parse($permohonanBilik->tkh_mula)->dayName.')'; 
						?>
					</dd>
					<dt class="col-sm-2">Masa Mula</dt>
					<dd class="col-sm-4">{{ Carbon\Carbon::parse($permohonanBilik->masa_mula)->format('g:i A') }}</dd>
					<dt class="col-sm-2">Tarikh Tamat</dt>
					<dd class="col-sm-4">
						{{ ($permohonanBilik->tkh_hingga!='') ? Carbon\Carbon::parse($permohonanBilik->tkh_hingga)->format('d.m.Y') : '-' }}
						<?php
							\Carbon\Carbon::setLocale('ms');
							echo '('.\Carbon\Carbon::parse($permohonanBilik->tkh_hingga)->dayName.')'; 
						?>
					</dd>
					<dt class="col-sm-2">Masa Tamat</dt>
					<dd class="col-sm-4">{{ ($permohonanBilik->masa_hingga!='') ? Carbon\Carbon::parse($permohonanBilik->masa_hingga)->format('g:i A') : '-' }}</dd>
					<dt class="col-sm-2">Nama Bilik</dt>
					@if ( $OptBiliks )
						<dd class="col-sm-4">{{ $OptBiliks->bilik }}, {{ $OptBiliks->bahagian }}, Aras {{ $OptBiliks->aras }}</dd>
					@else
						<dd class="col-sm-4"> - </dd>
					@endif
					{{-- <dd class="col-sm-4">{{ ($permohonanBiliks->id_bilik!='') ? \App\LkpBilik::find($permohonanBiliks->id_bilik)->bilik : '' }}</dd> --}}
					<dt class="col-sm-2">Bil. Ahli Mesyuarat <br><small><i>  (Bilangan Ahli Mesyuarat yang <b>terlibat</b>.)  </i></small></dt>
					<dd class="col-sm-4">{{ $permohonanBilik->bil_peserta }} orang </dd>

					<dt class="col-sm-2">Nama Mesyuarat / Seminar / Bengkel / Kursus / Sesi Perbincangan </dt>
					<dd class="col-sm-10">{{ ($permohonanBilik->nama_tujuan!='') ? $permohonanBilik->nama_tujuan :'-' }}</dd>
					<br>	

					<dt class="col-sm-2"><br>Makanan</dt>
					<dd class="col-sm-10"><br>@if($permohonanBilik->tempah_makan =='1') Diperlukan<br> @else Tidak Diperlukan @endif</dd>

					
					{{-- Kuar Senarai Makanan --}}
					@if ($permohonanBilik->tempah_makan == '1')
						<dt class="col-sm-10"> <br>Senarai Tempahan Makanan</dt>
					
						<div class="card-body table-responsive">
							<table id="example1" class="table table-bordered table-sm table-responsive-sm ">

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

						<dt class="col-sm-5"><br>Harga Tempahan Makanan (Per Pax) : RM {{ $tempahMakans->kadar_harga ?? "-"}} <br></dt>
						
					@else		
					@endif
					
					@if ( $tindakans->count() == 0 )
							<dt class="col-sm-10"><br> <font color="red"> Status :  Maklumat tidak dimasuk dengan betul. Sila tekan kemaskini dan kemaskini semula tempahan anda.</font> </dt>
					@else
					@endif
					
				</dl>
			</div>

			@if($permohonanBilik->id_status == 3 || $permohonanBilik->id_status == 4 || $permohonanBilik->id_status == 6)
				<div class="card-header bg-purple">
					<h3 class="card-title">Status Permohonan</h3>	
				</div>
				<div class="card-body">
					<dl class="row">
						<dt class="col-sm-3"></center>Status Tempahan Bilik</center></dt>
						<dd class="col-sm-3">{{ ($permohonanBilik->id_status!='') ? \App\LkpStatus::find($permohonanBilik->id_status)->status : ' - ' }}</dd>
						<dt class="col-sm-3"></center>Status Tempahan Makanan</center></dt>
							@if ( $tindakanStatus->id_status_makan == 3 || $tindakanStatus->id_status_makan == 4 || $tindakanStatus->id_status_makan == 6 
									&& $permohonanBilik->tempah_makan != 2)
								<dd class="col-sm-3">{{ ($tindakanStatus->id_status_makan!='') ? \App\LkpStatus::find($tindakanStatus->id_status_makan)->status : ' - ' }}</dd>
							@else
								<dd class="col-sm-3">  -  </dd>
							@endif
						<dt class="col-sm-3">Pembekal/ Katerer</dt>
						
							@if ( $permohonanBilik->id_status == 3 && $tindakanStatus->id_status_makan == 3)
								@php
									$NamaKaterer = null;
									foreach ($katerers as $katerer) {
										if($katerer->id_katerer == $tempahMakans->pembekal) {
											$NamaKaterer = $katerer->nama_katerer;
										}
									}
								@endphp
								<dd class="col-sm-7">
									@php
										echo $NamaKaterer;
									@endphp
								</dd>
							@else
								<dd class="col-sm-7"> - </dd>
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
							{{-- <dd class="col-sm-10">{{ ($tindakanStatus->peg_penyelia!='') ? \App\PPersonel::find($tindakanStatus->peg_penyelia)->name : '' }}</dd> --}}
						@else
							<dd class="col-sm-6"> <br> - </dd>
						@endif
					</dl>
				</div>
			
			@else 
			@endif


			<div class="card-header bg-navy">
				<h3 class="card-title"> Log Tindakan </h3>
			</div>
			<div class="card-body table-responsive">
                <table id="example1" class="table table-bordered table-sm">
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
                    <td><center>{{ $loop->iteration }}.</center></td>
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
                    <td>@if ($tindakan1->id_status_tempah == 3 || $tindakan1->id_status_tempah == 5) 
						<a href="{{ url('tempahanbilik/butiran_tindakan',$tindakan1->id_tindakan) }}"> @endif {{ $status }}</a><br/> 
					</td>
						@php
							$name = null;
							foreach ($personels as $personel) {
								if($personel->nokp == $tindakan1->peg_penyelia) {
									$name = $personel->name;
								}
							}
						@endphp
						<td>
							@php
								echo $name;
							@endphp
						</td>
					{{-- <td> {{ $tindakan1->peg_penyelia }} </td>  --}}
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
				<!-- if user PENYELIA -->
				@if ( Auth::user()->id_access == '3' || Auth::user()->id_access == '4')
					@if($permohonanBilik->id_status == 1 || $permohonanBilik->id_status == 2 || $permohonanBilik->id_status == 5)
					<!-- baru, kemaskini @ semak semula -->
					<a href="{{ url('tempahanbilik/kemaskini/'.$permohonanBilik->id_permohonan_bilik) }}" class="btn btn-primary">Kemaskini</a>
						@if(!isset($tindakan))
							<a href="{{ url('tempahanbilik/tindakan/'.$permohonanBilik->id_permohonan_bilik) }}" class="btn btn-primary bg-purple" >Tindakan</a>
							<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTindakan">Tindakan</button> -->
						@endif
						<a href="{{ url('tempahanbilik/batal/'.$permohonanBilik->id_permohonan_bilik) }}" class="btn btn-danger">Batal</a>
					@elseif($permohonanBilik->id_status == 3  || $permohonanBilik->id_status == 11 )
					<a href="{{ url('tempahanbilik/kemaskini/'.$permohonanBilik->id_permohonan_bilik) }}" class="btn btn-primary">Kemaskini</a>
					<a href="{{ url('tempahanbilik/batal/'.$permohonanBilik->id_permohonan_bilik) }}" class="btn btn-danger">Batal</a>
					@else
					@endif

					<a href="{{ url('/tempahanbilik/cetak_butiran/'.$permohonanBilik->id_permohonan_bilik) }}" class="btn btn-warning">Cetak</a>
				<!-- if user  PEMOHON-->
				@elseif (Auth::user()->mykad == $pemohon->nokp)
					@if($permohonanBilik->id_status == 1 || $permohonanBilik->id_status == 2 || $permohonanBilik->id_status == 5)
						<a href="{{ url('tempahanbilik/kemaskini/'.$permohonanBilik->id_permohonan_bilik) }}" class="btn btn-info">Kemaskini</a>
						<a href="{{ url('tempahanbilik/batal/'.$permohonanBilik->id_permohonan_bilik) }}" class="btn btn-danger">Batal</a>
					@endif
				@endif
				@if(Auth::user()->mykad == $pemohon->nokp && $permohonanBilik->id_status == 3 )
					<!-- if status lulus  -->
					<!-- <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">Sahkan</button> -->
				@endif
				{{-- if dari jadual tempahan --}}
				@if ( isset($kalendar) ) 
					<a href="{{ url('tempahanbilik/jadual') }}" class="btn btn-default float-right">Kembali</a>
				@else
					<a href="{{ url('tempahanbilik/') }}" class="btn btn-default float-right">Kembali</a>
				@endif
				
				{{-- <button type="button" class="btn btn-default float-right" onclick="history.back();">Kembali</button> --}}
			</div> 
                <!-- /.card-footer -->
            <!-- /.card -->
          </div>
		  
		  {{-- <!-- Modal -->
		<div class="modal fade" id="myModal" role="dialog">
			<div class="modal-dialog modal-md">
				<div class="modal-content">
					<div class="modal-header bg-success">
						
						<h4 class="modal-title">Pengesahan Tempahan</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
 
					<form role="form" method="POST" action="{{ url('tempahankenderaan/sahkan/'.$permohonanKenderaan->id_maklumat_permohonan) }}" enctype="multipart/form-data">
               			 {{ csrf_field() }}
 
					<div class="modal-body">
 
						<!-- Status Tindakan -->
						<div class="form-group">
							<h6 class="modal-title">Sila sahkan tempahan anda.</h6>
						</div>
 
					</div>
 
					<div class="modal-footer" style="display: flex; align-items: center; justify-content: center;">
						
						<!-- Butang Submit -->
						<input class="btn btn-primary" type="submit" name="button" id="button" value="Setuju" onclick="#" />
						<button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>
      					<!-- <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button> -->
						<!-- ./Butang Submit -->
					</div>
					</form>
 
				</div>
			</div>
		</div> --}}
		  
		  
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
		  "responsive": true, "lengthChange": false, "autoWidth": false,  "searching": false, "ordering" : false, "info" : false, "paging": false,
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

