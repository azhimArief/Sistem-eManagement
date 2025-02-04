@extends('layouts/master')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">BUTIRAN PEMANDU</h1>
          </div><!-- /.col -->
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/home') }}">Laman Utama</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/pemandu') }}">Pemandu</a></li>
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
                <h3 class="card-title">Maklumat Pemandu</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <div class="card-body">
                <dl class="row">
                  <dt class="col-sm-3">No Kad Pengenalan</dt>
                  <dd class="col-sm-9">{{ $pemandu->mykad }}</dd>
                  <dt class="col-sm-3">Nama Pemandu</dt>
                  <dd class="col-sm-9">{{ $pemandu->nama_pemandu }}</dd>
                  <dt class="col-sm-3">Gred</dt>
                  <dd class="col-sm-9">{{ $pemandu->gred_pemandu }}</dd>
                  <dt class="col-sm-3">Bahagian</dt>
                  <dd class="col-sm-9">{{ $pemandu->bahagian }}</dd>
                  <dt class="col-sm-3">No. Tel. Bimbit</dt>
                  <dd class="col-sm-9">{{ $pemandu->no_tel_bimbit }}</dd>
                  <dt class="col-sm-3">Emel</dt>
                  <dd class="col-sm-9">{{ $pemandu->email }}</dd>
                  <dt class="col-sm-3">Status</dt>
                  <dd class="col-sm-9">{{ ($pemandu->status!='') ?  \App\LkpStatus::find($pemandu->status)->status : '' }}</dd>
                  
                  
                </dl>
                <!-- /.card-body -->
                <div class="card-footer">
                  <a href="{{ url('pemandu/kemaskini/'.$pemandu->mykad) }}" class="btn btn-info bg-purple">Kemaskini</a>
                  <a href="{{ url('pemandu/hapus/'.$pemandu->mykad) }}" class="btn btn-danger">Hapus</a>
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

