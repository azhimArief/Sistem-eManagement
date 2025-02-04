@extends('layouts/master')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">HAPUS KENDERAAN</h1>
          </div><!-- /.col -->
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/home') }}">Laman Utama</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/kenderaan') }}">Kenderaan</a></li>
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
            <!-- Horizontal Form -->
            <div class="card card-info">
              <div class="card-header bg-purple">
                <h3 class="card-title">Maklumat Kenderaan</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
			  <form class="form-horizontal" method="POST" action="{{ url('kenderaan/hapus/'.$kenderaan->id_kenderaan) }}" enctype="multipart/form-data">
			  {{ csrf_field() }}
              <div class="card-body">
                <dl class="row">
                  <dt class="col-sm-3">No Kenderaan</dt>
                  <dd class="col-sm-9">{{ $kenderaan->no_plat }}</dd>
                  <dt class="col-sm-3">Jenis Kenderaan</dt>
                  <dd class="col-sm-9">{{ ($kenderaan->id_jenis!='') ? \App\LkpJenisKenderaan::find($kenderaan->id_jenis)->jenis_kenderaan : '' }}</dd>
                  <dt class="col-sm-3">Model Kenderaan</dt>
                  <dd class="col-sm-9">{{ ($kenderaan->id_model!='') ? \App\LkpModel::find($kenderaan->id_model)->jenis_model : '' }}</dd>
                  <dt class="col-sm-3">Bil Penumpang</dt>
                  <dd class="col-sm-9">{{ $kenderaan->Bil_penumpang }}</dd>
                  <dt class="col-sm-3">Nama Pemandu</dt>
                  <dd class="col-sm-9">{{ ($kenderaan->pemandu!='') ? \App\LkpPemandu::find($kenderaan->pemandu)->nama_pemandu : ''  }}</dd>
                  <dt class="col-sm-3">Status</dt>
                  <dd class="col-sm-9">{{ ($kenderaan->id_status!='') ? \App\LkpStatus::find($kenderaan->id_status)->status : ''  }}</dd>
                  <dt class="col-sm-3">Catatan</dt>
                  <dd class="col-sm-9">{{ ($kenderaan->catatan!='') ? $kenderaan->catatan : '-'  }}</dd>
                </dl>
                <!-- /.card-body -->
                <div class="card-footer">
				          <span class="text-danger">Anda pasti ingin hapuskan maklumat kenderaan ini?</span> &nbsp;
                  <button type="submit" name="hapus_kenderaan" class="btn btn-danger">Ya, Hapus</button>
                  <button type="button" class="btn btn-default" onclick="history.back();">Tidak</button>
                </div>
                <!-- /.card-footer -->
            </div>
			</form>
            <!-- /.card -->
          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    
@endsection

