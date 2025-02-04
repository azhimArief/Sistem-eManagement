@extends('layouts/master')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Hapus Maklumat Tempahan</h1>
          </div><!-- /.col -->
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/home') }}">Laman Utama</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/tempahanbilik') }}">Tempahan Bilik</a></li>
              <li class="breadcrumb-item active">Hapus</li>
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
			
			 <form class="form-horizontal" method="POST" action="{{ url('tempahankenderaan/hapus/'.$pemohon->id_permohonan) }}" enctype="multipart/form-data">
			 {{ csrf_field() }}
            <!-- Horizontal Form -->
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Maklumat Pemohon</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <div class="card-body">
				<dl class="row">
					<dt class="col-sm-3">Nama Pegawai</dt>
					<dd class="col-sm-9">{{ $pemohon->nama }}</dd>
					<dt class="col-sm-3">Permohonan Bagi Pihak</dt>
					<dd class="col-sm-9">{{ ($pemohon->pohon_bagi!='') ? $pemohon->pohon_bagi: '-' }}</dd>
					<dt class="col-sm-3">Jawatan</dt>
					<dd class="col-sm-3">{{ $pemohon->jawatan }}</dd>
					<dt class="col-sm-3">Gred</dt>
					<dd class="col-sm-3">{{ $pemohon->gred }}</dd>
					<dt class="col-sm-3">Bahagian</dt>
					<dd class="col-sm-3">{{ $pemohon->bahagian }}</dd>
					<dt class="col-sm-3">E-mel</dt>
					<dd class="col-sm-3">{{ $pemohon->emel }}</dd>
					<dt class="col-sm-3">No. Tel. Pejabat</dt>
					<dd class="col-sm-3">{{ $pemohon->telefon }}</dd>
					<dt class="col-sm-3">No. Tel. Bimbit</dt>
					<dd class="col-sm-3">{{ $pemohon->tel_bimbit }}</dd>
				</dl>
            </div>
				
			<div class="card-header">
				<h3 class="card-title">Maklumat Tempahan</h3>
			</div>
			<div class="card-body">
				<dl class="row">
					<dt class="col-sm-3">Jenis Perjalanan</dt>
					<dd class="col-sm-3">{{ ($maklumatPermohonan->id_jenis_permohonan!='') ? \App\LkpJenisPerjalanan::find($maklumatPermohonan->id_jenis_permohonan)->jenis_perjalanan : '' }}</dd>
					<dt class="col-sm-3">Tujuan</dt>
					<dd class="col-sm-3">{{ ($maklumatPermohonan->id_tujuan!='') ? \App\LkpTujuan::find($maklumatPermohonan->id_tujuan)->tujuan : '' }}</dd>
					<dt class="col-sm-3">Tarikh Pergi</dt>
					<dd class="col-sm-3">{{ Carbon\Carbon::parse($maklumatPermohonan->tkh_pergi)->format('d.m.Y') }}</dd>
					<dt class="col-sm-3">Tarikh Balik</dt>
					<dd class="col-sm-3">{{ Carbon\Carbon::parse($maklumatPermohonan->tkh_balik)->format('d.m.Y') }}</dd>
					<dt class="col-sm-3">Masa Pergi</dt>
					<dd class="col-sm-3">{{ Carbon\Carbon::parse($maklumatPermohonan->masa_pergi)->format('g:i A') }}</dd>
					<dt class="col-sm-3">Masa Balik</dt>
					<dd class="col-sm-3">{{ Carbon\Carbon::parse($maklumatPermohonan->masa_balik)->format('g:i A') }}</dd>
					<dt class="col-sm-3">Lokasi/Tempat</dt>
					<dd class="col-sm-3">{{ $maklumatPermohonan->lokasi_tujuan }}</dd>
					<dt class="col-sm-3">Bil. Penumpang</dt>
					<dd class="col-sm-3">{{ $maklumatPermohonan->bil_penumpang }}</dd>
					<dt class="col-sm-3">Nama Mesyuarat / Seminar / Bengkel / Kursus / Program </dt>
					<dd class="col-sm-9">{{ $maklumatPermohonan->nama_tujuan }}</dd>
					<dt class="col-sm-3">Lampiran</dt>
					<dd class="col-sm-9">
						@if($maklumatPermohonan->lampiran!='')
						<a href="{{ url('../'.$maklumatPermohonan->lampiran) }}" class="btn-sm btn-default" target="_blank"><i class="fa fa-paperclip"></i> {{ $maklumatPermohonan->lampiran }}</a>
						@endif
					</dd>
				</dl>
            </div>
				
			<!-- /.card-body -->
			<div class="card-footer">
			  <span class="text-danger">Anda pasti ingin hapuskan maklumat tempahan ini?</span> &nbsp;
			  <button type="submit" name="hapus_tempahan" class="btn btn-danger">Ya, Hapus</button>
			  <button type="button" class="btn btn-default" onclick="history.back();">Tidak</button>
			</div>
                <!-- /.card-footer -->
            <!-- /.card -->
          </div>
		  </form>
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
	  });
	</script>
@endsection

