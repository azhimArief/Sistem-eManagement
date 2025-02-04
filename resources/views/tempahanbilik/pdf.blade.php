
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport"
		content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>{{ $permohonanKenderaan->kod_permohonan }}</title>


<!-- <style type="text/css" media="screen">
	html {
		font-family: sans-serif;
		font-size: 14px;
		margin: 50px 90px;
	}
	table {
		border-collapse: collapse;
	}
	th {
		text-align: inherit;
	}	
	.table {
		width: 100%;
		margin-bottom: 1rem;
		color: #212529;
	}
	.table th,
	.table td {
		padding: 0.75rem;
		vertical-align: top;
		border: 1px solid #dee2e6;
	}
	.table thead th {
		vertical-align: bottom;
		border: 2px solid #dee2e6;
	}
	.table tbody + tbody {
		border: 2px solid #dee2e6;
	}
</style> -->
<style type="text/css" media="screen">
    @page {
        size: auto;   /* auto is the initial value */
        margin: 0;  /* this affects the margin in the printer settings */
    }

    body {
    font-family: Tahoma, sans-serif;
    font-size:13px;
    }

    table {
        /*border-collapse: collapse;
        width: 100%;*/
    }

    th, td {
        padding: 10px;
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
        width:50%;
    }

    .right-col {
        width:50%;
    }

    .sign-row {
        height:100px;
    }

    .container {
        /*margin-top: 100px;*/
        /*margin-bottom: 100px;*/
        margin-right: 150px;
        margin-left: 50px;
        /*background-color: lightblue;*/
    }

    h3 {
        color:black !important;
        font-weight: bold;
    }

    .slip {
        font-size:20px;
        font-weight: bold;
    }

    .title {
        font-size:14px;
        font-weight: bold;
        font-color:black;
    }
    
    .capitalize {
    text-transform: capitalize;
    }

	.uppercase {
    text-transform: uppercase;
    }

</style>

</head>
<!-- Content Header (Page header) -->
 <div class="content-header">
      <!-- <div class="container-fluid"> -->
	  	<div class="col-md-12">
			<center> 
				<p><img src="{{asset('dist/img/JataNegara.png')}}" height="80px"></p>
				<p ><strong>KEMENTERIAN PERPADUAN NEGARA</strong></p>
				<p>Unit Pengurusan Logistik, <br> Seksyen Pentadbiran dan Aset,
				Bahagian Khidmat Pengurusan<br>
				Aras 7, Blok F9, Kompleks F, Lebuh Perdana Timur A,<br>Presint 1, 62000 Putrajaya<br>Tel. : +603-8091 8150 / 8140  &nbsp;|&nbsp; Emel : mohdsaad@perpaduan.gov.my / azreeman@perpaduan.gov.my</p>
				<p><h2><strong>BORANG TEMPAHAN PERKHIDMATAN KENDERAAN JABATAN</strong></h2></p>
			</center>
			<hr width="100%">
		</div>
		<!-- <p>ID Tempahan : <strong> {{ $permohonanKenderaan->kod_permohonan }} </strong></p> -->
      <!-- </div> -->
  </div>
    
  <section class="content">
  	<div class="container-fluid">
		

		<div class="container">
			<div class="col-md-12">

				<div class="card-body">                    
					<dl class="row">
						<!-- BUTIRAN PEMOHON -->
						<dt class="col-sm-3"><strong><h3 class="card-title ">ID Tempahan  : {{ $permohonanKenderaan->kod_permohonan }} &nbsp; | &nbsp; {{ Carbon\Carbon::parse($permohonanKenderaan->created_by)->format('d.m.Y') }}</h3></strong></dt>
						<dd class="col-sm-0"></dd>
					</dl>
						<dt class="col-sm-12"><strong><h3 class="card-title uppercase">Maklumat Pemohon </h3></strong></dt>
						<dd class="col-sm-0"></dd>
							<br>
					<dl class="row">		
						<dt class="col-sm-3">Nama Pegawai  :</dt>
						<dd class="col-sm-9">
							<span style="text-transform:uppercase">  {{ ($pemohon->nama!='') ? $pemohon->nama : '-' }} </span></dd> 
						<table class="table1" style="width: 100%">
						<tbody>
							<tr>
								<td class="border-0">
									<p><strong>Jawatan</strong></p> 
								</td>
								<td class="border-0" style="align: right; width:75%">
									<p>{{ $pemohon->jawatan }}<p>
								</td>
								<td class="border-0">
									<p><strong>Gred</strong></p> 
								</td>
								<td>
									<p>{{ $pemohon->gred }}<p>
								</td>
							</tr>
							<tr>
								<td class="border-0">
									<p><strong>Bahagian</strong></p> 
								</td>
								<td class="border-0" style="align: right">
									<p>{{ $pemohon->bahagian }}<p>
								</td>
								<td class="border-0">
									<p><strong>E-mel</strong></p> 
								</td>
								<td>
									<p>{{ $pemohon->emel }}<p>
								</td>
							</tr>
							<tr>
								<td class="border-0">
									<p><strong>No Tel Pejabat</strong></p> 
								</td>
								<td class="border-0">
									<p>{{ $pemohon->telefon }}<p>
								</td>
								<td class="border-0">
									<p><strong>No Tel Bimbit</strong></p> 
								</td>
								<td>
									<p>{{ $pemohon->tel_bimbit }}<p>
								</td>
							</tr>
						</tbody>
					</table>

						<dt class="col-sm-3">Jawatan / Gred :</dt>
						<dd class="col-sm-9">
							<span style="text-transform:uppercase">  {{ ($pemohon->jawatan!='') ? $pemohon->jawatan : '-' }} &nbsp; / &nbsp;  {{ ($pemohon->gred!='') ? $pemohon->gred : '-' }} </span></dd>

						<dt class="col-sm-3">Bahagian  :</dt>
						<dd class="col-sm-9">
							<span style="text-transform:uppercase">  {{ ($pemohon->bahagian!='') ? $pemohon->bahagian : '-' }} </span></dd>

						<dt class="col-sm-3">E-mel  :</dt>
						<dd class="col-sm-9"> {{ ($pemohon->emel!='') ? $pemohon->emel : '-' }} </dd>

						<dt class="col-sm-3">No. Telefon Pejabat  :</dt>
						<dd class="col-sm-3"> {{ ($pemohon->telefon!='') ? $pemohon->telefon : '-' }} </dd>

						<dt class="col-sm-3">No. Telefon Bimbit  :</dt>
						<dd class="col-sm-3"> {{ ($pemohon->tel_bimbit!='') ? $pemohon->tel_bimbit : '-' }} </dd>
					</dl>
				
					<dl class="row">
						<dt class="col-sm-12"><strong><h3 class="card-title">Maklumat Tempahan</h3></strong></dt>
						<dd class="col-sm-0"></dd>
							<br>
							
						<dt class="col-sm-3">Jenis Perjalanan  :</dt>
						<dd class="col-sm-9">
							<span style="text-transform:uppercase">{{ ($permohonanKenderaan->id_tujuan!='') ? \App\LkpTujuan::find($permohonanKenderaan->id_tujuan)->tujuan : '' }}</span></dd>

						<dt class="col-sm-3">Tujuan  :</dt>
						<dd class="col-sm-9">
							<span style="text-transform:uppercase">{{ ($permohonanKenderaan->id_tujuan!='') ? \App\LkpTujuan::find($permohonanKenderaan->id_tujuan)->tujuan : '' }}</span></dd>

						<dt class="col-sm-3">Tarikh Pergi  :</dt>
						<dd class="col-sm-3">
							<span style="text-transform:uppercase">{{ ($permohonanKenderaan->tkh_pergi!='') ? Carbon\Carbon::parse($permohonanKenderaan->tkh_pergi)->format('d.m.Y') : '-' }}</span></dd>

						<dt class="col-sm-3">Tarikh Balik  :</dt>
						<dd class="col-sm-3">
							<span style="text-transform:uppercase">{{ ($permohonanKenderaan->tkh_balik!='') ? Carbon\Carbon::parse($permohonanKenderaan->tkh_balik)->format('d.m.Y') : '-' }}</span></dd>

						<dt class="col-sm-3">Masa Pergi  :</dt>
						<dd class="col-sm-9">
							<span style="text-transform:uppercase">{{ ($permohonanKenderaan->masa_pergi!='') ? Carbon\Carbon::parse($permohonanKenderaan->masa_pergi)->format('g:i A') : '-' }}</span></dd>

						<dt class="col-sm-3">Masa Balik  :</dt>
						<dd class="col-sm-9">
							<span style="text-transform:uppercase">{{ ($permohonanKenderaan->masa_balik!='') ? Carbon\Carbon::parse($permohonanKenderaan->masa_balik)->format('g:i A') : '-' }}</span></dd>

						<dt class="col-sm-3">Lokasi/Tempat  :</dt>
						<dd class="col-sm-9">
							<span style="text-transform:uppercase">{{ ($permohonanKenderaan->lokasi_tujuan!='') ? $permohonanKenderaan->lokasi_tujuan : '' }}</span></dd>
											
						<dt class="col-sm-3">Nama Mesyuarat <br>/ Seminar / Bengkel / Kursus / Program  :</dt>
						<dd class="col-sm-3">{{ ($permohonanKenderaan->keterangan_lanjut!='') ? $permohonanKenderaan->keterangan_lanjut : '' }}</dd>

						<dt class="col-sm-3">Masa Mesyuarat  :</dt>
						<dd class="col-sm-3">{{ Carbon\Carbon::parse($permohonanKenderaan->masa_mesyuarat)->format('H:i:s') }}</dd>

						<dt class="col-sm-3">Lampiran  :</dt>
						<dd class="col-sm-3">@if($permohonanKenderaan->lampiran!='')
							<a href="{{ url(''.$permohonanKenderaan->lampiran) }}" class="btn-sm btn-default" target="_blank"><i class="fa fa-paperclip"></i> Lampiran </a>
							@else -
							@endif</dd>

						
					</dl>
				</div>
			</div>
		</div>
	</div>
	<!-- /.container-fluid -->
    </section>
</html>

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

