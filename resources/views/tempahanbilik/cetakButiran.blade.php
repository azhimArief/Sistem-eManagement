 @extends('layouts.master')

@section('content')


    <style type="text/css" media="print">
        @page {
            size: portrait;
            /* auto is the initial value */
            margin: 80px 0px 20px 20px;
            /* this affects the margin in the printer settings  atas, kanan, bawah, kiri */
        }

		/* @page {
			size: A4;
			margin: 0;
		} */

        @page lcp {
            size: landscape;
            /* auto is the initial value */
            margin: 20px 20px 20px 20px;
            /* this affects the margin in the printer settings  atas, kanan, bawah, kiri*/
        }

        @media print {
            .nextPage {
                page-break-after: always;
            }
        }

        div.landscape-content {
            page: lcp;
        }

        body {
            font-family: "Arial", sans-serif;
            font-size: 12px;
        }

        table {
            border-collapse: collapse;
            width:85%;
            border: 1px solid black;
			/* border-top: 1px solid black;
            border-bottom: 1px solid black; */
            /* border-collapse: collapse; */
        }

        th, tr {
            padding: 10px;
            /* border-left: 1px solid black;
            border-right: 1px solid black; */

        }

        td {
            padding: 10px;
            border-top: 1px solid black;
            border-left: 1px solid black;
            border-right: 1px solid black;
            border-bottom: 1px transparent;
            border-collapse: collapse;
        }

        .bottom-line {
            border-bottom: 1px solid;
        }

        .right-line {
            border-right: 1px solid;
        }


        .top-line {
            border-top: 1px solid;
        }

        .left-col {
            width: 40%;
        }

        .right-col {
            width: 60%;
        }

        .sign-row {
            height: 300px;
        }

        h3 {
            /* color: blue !important; */
        }

        .slip {
            font-size: 20px;
            font-weight: bold;
        }

        .title {
            font-size: 12px;
            font-weight: bold;
            font-color: blue;
        }

        .capitalize {
            text-transform: capitalize;
        }

        .center {
            text-align: center;
            margin-left: auto;
            margin-right: auto;
        }

        .container {
            text-align: left;
            margin-left: 80px;
            margin-right: auto;
        }		

		#printPageButton {
			display: none;
		}

		.main-footer {
			display: none;
		}
		
    </style>

    <!-- <body onload="window.print(); window.close(); "> -->
    <!-- <body onload="window.print()"> -->

    <body>
        <br>

        <section name='sectionContainer' class="content">
            <div class="col-md-12">
				<center> 
					<p><img src="{{asset('dist/img/JataNegara.png')}}" height="80px"></p>
					<p ><strong>KEMENTERIAN PERPADUAN NEGARA</strong></p>
					<p>	
						{{-- Cawangan Keurusetiaan, <br>  --}}
						Seksyen Pengurusan Kualiti dan Inovasi,
						Bahagian Khidmat Pengurusan<br>
						Aras 7, Blok F9, Kompleks F, Lebuh Perdana Timur A,<br>Presint 1, 62000 Putrajaya<br>Tel. : +603-8091 8119 / 8145  &nbsp;|&nbsp; Emel : norainiyasin@perpaduan.gov.my / shahiruddin@perpaduan.gov.my</p>
					<p><h4><strong> TEMPAHAN BILIK MESYUARAT </strong></h4></p>
				</center>
				<hr width="80%" style="border: 1px solid black ">
			</div>
            <div class="col-md-12">

            </div>
            <div class="container">
                <div class="col-md-12">

                    <div class="card-body">

                        <dl class="row">
							<!-- BUTIRAN PEMOHON -->
							<dt class="col-sm-7"><strong><h5><b> ID Tempahan  : {{ $permohonanBiliks->kod_permohonan }} &nbsp; | &nbsp; {{ Carbon\Carbon::parse($permohonanBiliks->created_at)->format('d.m.Y') }}</b></h5></strong></dt>
							<dd class="col-sm-0"></dd>
						</dl>

                        <h6 class="m-0"><strong><u>Maklumat Pemohon</u></strong></h6>
						<br>
						<dl class="row">		
							<dt class="col-sm-2"><strong>Nama Pemohon  :</strong> </dt>
							<dd class="col-sm-9"> {{ $pemohon->name ?? '-' }} </dd> 
	
							<dt class="col-sm-2"><strong>Jawatan / Gred :</strong> </dt>
							<dd class="col-sm-9"> {{ $pemohon->jawatan ?? '-' }} &nbsp; / &nbsp;  {{ $pemohon->gred ?? '-' }} </dd>
	
							<dt class="col-sm-2"><strong>Bahagian  :</strong> </dt>
							<dd class="col-sm-4"> {{ optional(\App\PLkpBahagian::find($pemohon->bahagian_id))->bahagian }} </dd>
								{{-- <span style="text-transform:uppercase">  {{ ($pemohon->bahagian!='') ? $pemohon->bahagian : '-' }} </span> --}}
							
							<dt class="col-sm-2"><strong>E-mel  :</strong></dt>
							<dd class="col-sm-3"> {{ $pemohon->email ?? '-' }} </dd>
	
							<dt class="col-sm-2"><strong>No. Telefon Pejabat  :</strong></dt>
							<dd class="col-sm-4"> {{ $pemohon->tel ?? '-' }} </dd>
	
							<dt class="col-sm-2"><strong>No. Telefon Bimbit  :</strong></dt>
							<dd class="col-sm-3"> {{ $pemohon->tel_bimbit ?? '-' }} </dd>
						</dl>
						<br>

						<h6 class="m-0"><strong><u>Maklumat Tempahan</u></strong></h6>
						<br>
						<dl class="row">

							<dt class="col-sm-2"><strong>Tujuan  :</strong> </dt>
							<dd class="col-sm-4">{{ ($permohonanBiliks->id_tujuan!='') ? \App\LkpTujuan::find($permohonanBiliks->id_tujuan)->tujuan : '' }}</dd>

							<dt class="col-sm-2"><strong>Pengerusi  :</strong> </dt>
							<dd class="col-sm-4">{{ ($permohonanBiliks->nama_pengerusi!='') ? \App\PPersonel::find($permohonanBiliks->nama_pengerusi)->name : '' }}</dd>
	
							<dt class="col-sm-2"><strong>Tarikh Mula  :</strong></dt>
							<dd class="col-sm-4">{{ ($permohonanBiliks->tkh_mula!='') ? Carbon\Carbon::parse($permohonanBiliks->tkh_mula)->format('d.m.Y') : '-' }}
								<?php
									\Carbon\Carbon::setLocale('ms');
									echo '('.\Carbon\Carbon::parse($permohonanBiliks->tkh_mula)->dayName.')'; 
								?>
							</dd>
	
							<dt class="col-sm-2"><strong>Tarikh Tamat  :</strong></dt>
							<dd class="col-sm-4">{{ ($permohonanBiliks->tkh_hingga!='') ? Carbon\Carbon::parse($permohonanBiliks->tkh_hingga)->format('d.m.Y') : '-' }}
								<?php
									\Carbon\Carbon::setLocale('ms');
									echo '('.\Carbon\Carbon::parse($permohonanBiliks->tkh_hingga)->dayName.')'; 
								?>
							</dd>
	
							<dt class="col-sm-2"><strong>Masa Mula  :</strong></dt>
							<dd class="col-sm-4">{{ ($permohonanBiliks->masa_mula!='') ? Carbon\Carbon::parse($permohonanBiliks->masa_mula)->format('g:i A') : '-' }}</dd>
	
							<dt class="col-sm-2"><strong>Masa Tamat  :</strong></dt>
							<dd class="col-sm-4">{{ ($permohonanBiliks->masa_hingga!='') ? Carbon\Carbon::parse($permohonanBiliks->masa_hingga)->format('g:i A') : '-' }}</dd>

							<dt class="col-sm-2"><strong> Bil. Ahli Mesyuarat  :</strong></dt>
							<dd class="col-sm-10"> {{ $permohonanBiliks->bil_peserta }} orang </dd>
	
							<dt class="col-sm-2"><strong>Nama Bilik  :</strong></dt>
							<dd class="col-sm-4">{{ $OptBiliks->bilik }}, {{ $OptBiliks->bahagian }}, Aras {{ $OptBiliks->aras }}</dd>

							<dt class="col-sm-12"></dt>
                            <dd class="col-sm-0"></dd>

							<dt class="col-sm-2"><strong>Nama Mesyuarat / Seminar / Bengkel / Kursus / Sesi Perbincangan  </strong></dt>
							<dd class="col-sm-10">{{ ($permohonanBiliks->nama_tujuan!='') ? $permohonanBiliks->nama_tujuan : '' }}</dd>
						</dl>
							
						<dl class="row"> 
						{{-- Kuar Senarai Makanan --}}
							@if ($permohonanBiliks->tempah_makan == '1')
								<dt class="col-sm-12"></dt>
								<dd class="col-sm-12"><br></dd>
								<h6 class="m-0"><strong><u><br> Senarai Tempahan Makanan</u></strong></h6>
								{{-- <dt class="col-sm-12"><strong><h3 class="card-title">Senarai Tempahan Makanan</h3></strong></dt> --}}
								<dt class="col-sm-12"><br></dt>
								<dd class="col-sm-12"></dd>

								<table border="2" width="50%" cellpadding="0" cellspacing="0"> 

										{{-- MAKAN PAGI --}}
										<thead bgcolor ="#D8BFD8">
											{{-- <tr>
												@if($tempahMakans->makan_pagi == '1')  <th><center>Makan Pagi</center>  </th> 
												@else
												@endif
											</tr> --}}
										</thead>
										<tbody>
											<tr>
												@if($tempahMakans->makan_pagi == '1') 
													<td> 
															@if($tempahMakans->makan_pagi == '1')  <center><h6 class="m-0"><strong><u> Makan Pagi</u></strong></h6></center>
															@else
															@endif
															{{-- Makan Pagi Table --}}
															{{-- <div class="container makan_pagi"> --}}

																{{-- <table id="example1" class="table table-bordered table-sm table-responsive-sm"> --}}
																<table id="example1" class="table table-bordered table-sm table-responsive-sm">
																	<tr>
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

															{{-- </div> --}}
													</td>
												@else
												@endif
											</tr>									
										</tbody>
								
										{{-- MAKAN TENGAHARI --}}
										<thead bgcolor ="#D8BFD8">
											{{-- <tr>
												@if($tempahMakans->makan_tghari == '1')  <th> <center>Makan Tengahari</center>  </th> 
												@else
												@endif
											</tr> --}}
										</thead>
										<tbody>
											<tr>
												@if($tempahMakans->makan_tghari == '1') 
													<td>	
															@if($tempahMakans->makan_tghari == '1')  <center><h6 class="m-0"><strong><u> Makan Tengahari</u></strong></h6></center>
															@else
															@endif											
															{{-- Makan Tengahari Table --}}
															{{-- <div class="container makan_tengahari"> --}}

																<table id="example1" class="table table-bordered table-sm table-responsive-sm">
																	<tr>
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

															{{-- </div>									 --}}
													</td>
												@else
												@endif	
											</tr>									
										</tbody>

										{{-- MINUM PETANG --}}
										<thead bgcolor ="#D8BFD8">
											{{-- <tr>
												@if($tempahMakans->minum_petang == '1') <th><center>Minum Petang </center> </th> 
												@else
												@endif
											</tr> --}}
										</thead>
										<tbody>
											<tr>
												@if($tempahMakans->minum_petang == '1') 	
													<td>	
															@if($tempahMakans->minum_petang == '1')  <center><h6 class="m-0"><strong><u> Minum Petang</u></strong></h6></center>
															@else
															@endif
															{{-- Minum Petang Table --}}
															{{-- <div class="container minum_petang"> --}}
																<table id="example1" class="table table-bordered table-sm table-responsive-sm">
																	<tr>
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

															{{-- </div>	 --}}
													</td>
												@else
												@endif
											</tr>									
										</tbody>

										{{-- MAKAN MALAM --}}
										<thead bgcolor ="#D8BFD8">
											{{-- <tr>
												@if($tempahMakans->makan_malam == '1') <th><center>Makan Malam</center>  </th> 
												@else
												@endif
											</tr> --}}
										</thead>
										<tbody>
											<tr>
												@if($tempahMakans->makan_malam == '1') 	
													<td>	
															@if($tempahMakans->makan_malam == '1')  <center><h6 class="m-0"><strong><u> Makan Malam</u></strong></h6></center>
															@else
															@endif
															{{-- Makan Malam Table --}}
															{{-- <div class="container makan_malam"> --}}
																<table id="example1" class="table table-bordered table-sm table-responsive-sm">
																	<tr>
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

															{{-- </div>	 --}}
													</td>
												@else
												@endif
											</tr>									
										</tbody>

									</table>
	
								{{-- <dt class="col-sm-5"><br><strong>Harga Tempahan Makanan (Per Pax) : RM {{ $tempahMakans->kadar_harga ?? "-"}}</strong>  <br></dt> --}}
								<dt class="col-sm-10"></dt>
								<dd class="col-sm-10"></dd>
								<dt class="col-sm-4"><strong>Harga Tempahan Makanan (Per Pax) : RM {{ $tempahMakans->kadar_harga ?? "-"}}</strong></dt>
								<dd class="col-sm-8"><br> </dd>
								
							@else		
							@endif
						</dl>
							
						<dl class="row">
							@if($permohonanBiliks->id_status == 3 || $permohonanBiliks->id_status == 4 || $permohonanBiliks->id_status == 6)
									{{-- <dt class="col-sm-12"><strong><h3 class="card-title"><br><br> Status Permohonan</h3></strong></dt> --}}
									<h6 class="m-0"><strong><u><br> Status Permohonan <br><br></u></strong></h6>
									<dt class="col-sm-12"></dt>
									<dd class="col-sm-12"></dd>
	
									<dt class="col-sm-2"><strong>Status Tempahan Bilik</strong></dt>
									<dd class="col-sm-3"><span style="text-transform:uppercase">{{ ($permohonanBiliks->id_status!='') ? \App\LkpStatus::find($permohonanBiliks->id_status)->status : ' - ' }} </span> </dd>
									<dt class="col-sm-2"><strong>Status Tempahan Makanan</strong></dt>
										@if ( $tindakanStatus->id_status_makan == 3 || $tindakanStatus->id_status_makan == 4 || $tindakanStatus->id_status_makan == 6 
												&& $permohonanBiliks->tempah_makan != 2)
											<dd class="col-sm-4"> <span style="text-transform:uppercase">{{ ($tindakanStatus->id_status_makan!='') ? \App\LkpStatus::find($tindakanStatus->id_status_makan)->status : ' - ' }}</span></dd>
										@else
											<dd class="col-sm-4">  -  </dd>
										@endif
									<dt class="col-sm-2"><strong>Pembekal/ Katerer</strong> </dt>
									
										@if ( $permohonanBiliks->id_status == 3 && $tindakanStatus->id_status_makan == 3)
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
	
									<dt class="col-sm-2"><strong>Catatan</strong> </dt>
									<dd class="col-sm-9">{{ ($tindakanStatus->catatan!='') ? $tindakanStatus->catatan : '-' }}</dd>
									<dt class="col-sm-2"> <strong>Pegawai pelulus</strong> </dt>
									@if ($tindakanStatus->id_status_tempah	 == 3)
										@php
											$name = null;
											foreach ($personels as $personel) {
												if($personel->nokp == $tindakanStatus->peg_penyelia) {
													$name = $personel->name;
												}
											}
										@endphp
										<dd class="col-sm-7">
											@php
												echo $name;
											@endphp
										</dd>
										{{-- <dd class="col-sm-10">{{ ($tindakanStatus->peg_penyelia!='') ? \App\PPersonel::find($tindakanStatus->peg_penyelia)->name : '' }}</dd> --}}
									@else
										<dd class="col-sm-7"> - </dd>
									@endif
							@else 
							@endif
						</dl>

                    </div>
                </div>

                <div class="card-footer">
                    <button type="button" id="printPageButton" class="btn btn-default float-right" onclick="window.print();">Cetak</button>
                    <button type="button" id="printPageButton" class="btn btn-default float-right" onclick="history.back();">Kembali</button>
                </div>
				
			</div>

        </section>
    </body>

    </section>

@endsection

@section('script')
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "searching": false,
                "ordering": false,
                "info": false,
                "paging": false,
                "fnDrawCallback": function(oSettings) {
                    /* Need to redo the counters if filtered or sorted */
                    if (oSettings.bSorted || oSettings.bFiltered) {
                        for (var i = 0, iLen = oSettings.aiDisplay.length; i < iLen; i++) {
                            $('td:eq(0)', oSettings.aoData[oSettings.aiDisplay[i]].nTr).html(i + 1);
                        }
                    }
                }
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
