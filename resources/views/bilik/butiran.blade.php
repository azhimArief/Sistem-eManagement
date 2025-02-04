@extends('layouts/master')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">BUTIRAN BILIK</h1>
          </div><!-- /.col -->
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/homeBilikMeet') }}">Laman Utama</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/bilik') }}">Bilik</a></li>
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
                <h3 class="card-title">Maklumat Bilik </h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <div class="card-body">
              <dl class="row">
                <dt class="col-sm-3">Nama Bilik</dt>
                <dd class="col-sm-9">{{ $biliks->bilik }}</dd>
                <dt class="col-sm-3">Bahagian</dt>
                <dd class="col-sm-9">{{ ($biliks->id_bahagian!='') ? \App\PLkpBahagian ::find($biliks->id_bahagian)->bahagian : '' }}</dd>
                <dt class="col-sm-3">Kapasiti Bilik</dt>
                <dd class="col-sm-9">{{ $biliks->kapasiti_bilik ?? '-'}}<br></dd>
                <dt class="col-sm-3">Aras</dt>
                <dd class="col-sm-9">{{ $biliks->aras ?? '-'}}</dd>
                <dt class="col-sm-3">Kemudahan Bilik</dt>
                <dd class="col-sm-9">{{ $biliks->kemudahan_bilik ?? '-' }}<br></dd>
                <dt class="col-sm-3">Gambar Bilik</dt>
                <dd class="col-sm-5" text-align:left>
                      @if ($biliks->gambar_bilik == null)
                            -
                      @else
                          <a href="{{ url('' . $biliks->gambar_bilik) }}" target="_blank"><img
                          class="img-fluid mb-3" src="{{ url('' . $biliks->gambar_bilik) }}"
                          alt="Photo" width="400" height="400"></a>
                      @endif
                </dd>
              </dl>
                <!-- /.card-body -->
                <div class="card-footer">
                  <a href="{{ url('bilik/kemaskini/'.$biliks->id_bilik) }}" class="btn btn-info bg-purple">Kemaskini</a>
                  <a href="{{ url('bilik/hapus/'.$biliks->id_bilik) }}" class="btn btn-danger">Hapus</a>
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

