@extends('layouts/master')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">BUTIRAN KATERER</h1>
          </div><!-- /.col -->
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/homehomeBilikMeet') }}">Laman Utama</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/katerer') }}">Katerer</a></li>
              <li class="breadcrumb-item active">Butiran</li>
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
                <h3 class="card-title">Maklumat Katerer </h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <div class="card-body">
              <dl class="row">

                <dt class="col-sm-3">Nama Katerer</dt>
                <dd class="col-sm-9">{{ $katerers->nama_katerer ?? '-'}}</dd>
                <dt class="col-sm-3">Alamat</dt>
                <dd class="col-sm-9">{{ $katerers->alamat ?? '-'}}</dd>
                <dt class="col-sm-3"><br> Nama Untuk Dihubungi</dt>
                <dd class="col-sm-9"><br> {{ $katerers->person_in_charge ?? '-'}}</dd>
                <dt class="col-sm-3">Emel</dt>
                <dd class="col-sm-9">{{ $katerers->emel ?? '-'}}</dd>
                <dt class="col-sm-3">Nombor Untuk Dihubungi</dt>
                <dd class="col-sm-9">{{ $katerers->no_tel_katerer ?? '-'}}</dd>
                <dt class="col-sm-3">Tarikh Mula</dt>
                <dd class="col-sm-9 ">{{ ($katerers->tkh_mula!='') ? Carbon\Carbon::parse($katerers->tkh_mula)->format('d.m.Y') : '-' }}</dd>
                <dt class="col-sm-3">Tarikh Tamat</dt>
                <dd class="col-sm-9">{{ ($katerers->tkh_tamat!='') ? Carbon\Carbon::parse($katerers->tkh_tamat)->format('d.m.Y') : '-' }}</dd>
            
              </dl>
                <!-- /.card-body -->
                <div class="card-footer">
                  <a href="{{ url('katerer/kemaskini/'.$katerers->id_katerer) }}" class="btn btn-info bg-purple">Kemaskini</a>
                  <a href="{{ url('katerer/hapus/'.$katerers->id_katerer) }}" class="btn btn-danger">Hapus</a>
                  <button type="button" class="btn btn-default float-right" onclick="history.back();">Kembali</button>
                </div>
                <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    
@endsection

