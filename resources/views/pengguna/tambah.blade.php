@extends('layouts/master')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">TAMBAH PENGGUNA</h1>
          </div><!-- /.col -->
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/home') }}">Laman Utama</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/pengguna') }}">Pengguna</a></li>
              <li class="breadcrumb-item active">Tambah</li>
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
            <!-- form start -->
            <!-- Horizontal Form -->
            <div class="card card-info">
              <div class="card-header bg-purple">
                <h3 class="card-title">Maklumat Pengguna</h3>
              </div>
              <!-- /.card-header -->
                <div class="card-body">
				<form class="form-horizontal" method="POST" action="{{ url('pengguna/tambah') }}" enctype="multipart/form-data">
				  {{ csrf_field() }}
                  <div class="form-group row">
                    <label for="mykad" class="col-sm-3 col-form-label">Mykad <font color="red"> *</font></label>
                    <div class="input-group col-sm-6">
                      <input type="text" class="form-control" id="mykad" name="mykad" placeholder="Mykad" value="{{ old('mykad') }}">
                      <div class="input-group-append">
                        <button type="submit" name="semak_mykad" value="semak_mykad" class="input-group-text bg-primary"><i class="fa fa-search"></i> Semak</button>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="nama" class="col-sm-3 col-form-label">Nama</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama" value="{{ old('nama') }}" readonly="readonly">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="bahagian" class="col-sm-3 col-form-label">Bahagian</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" id="bahagian" name="bahagian" placeholder="Bahagian" value="{{ old('bahagian') }}" readonly="readonly">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="jawatan" class="col-sm-3 col-form-label">Jawatan</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" id="jawatan" name="jawatan" placeholder="Jawatan" value="{{ old('jawatan') }}" readonly="readonly">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="gred" class="col-sm-3 col-form-label">Gred</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" id="gred" name="gred" placeholder="Gred" value="{{ old('gred') }}" readonly="readonly">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="emel" class="col-sm-3 col-form-label">Emel <font color="red"> *</font></label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" id="emel" name="emel" placeholder="Emel" value="{{ old('emel') }}" >
                    </div>
                  </div>
                <div class="form-group row">
                  <label for="status" class="col-sm-3 col-form-label">Status <font color="red"> *</font></label>
                  <div class="col-sm-6" style="margin-top:7px;">
                    @foreach ($optStatusUsers as $optStatusUser)
                    <input type="radio" name="status" id="{{ $optStatusUser->status }}" value="{{ $optStatusUser->id_status }}"> <label class="form-check-label" for="{{ $optStatusUser->status }}">{{ $optStatusUser->status }}</label> &nbsp;&nbsp;&nbsp;
                    @endforeach
                  </div>
                </div>
                <div class="form-group row">
                  <label for="peranan" class="col-sm-3 col-form-label">Peranan <font color="red"> *</font></label>
                  <div class="col-sm-6">
                    <select class="form-control select2" id="peranan" name="peranan" style="width: 100%;">
                      <option value="" @if(old('peranan')=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
                      @foreach ($optAccesss as $optAccess)
                        <option value="{{ $optAccess->id_access }}" @if(old('peranan')==$optAccess->id_access) {{ 'selected="selected"' }} @endif>{{ $optAccess->access_type }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
			    	  </div>	
				
              <div class="card-header bg-purple">
                <h3 class="card-title">Maklumat Login</h3>
              </div>
                <div class="card-body">
                  <div class="form-group row">
                    <label for="id_pengguna" class="col-sm-3 col-form-label">ID Pengguna <font color="red"> *</font></label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" id="id_pengguna" name="id_pengguna" placeholder="ID Pengguna" value="{{ old('mykad') }}" readonly="readonly">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="kata_laluan" class="col-sm-3 col-form-label">Kata Laluan <font color="red"> *</font></label>
                    <div class="col-sm-6">
                      <input type="password" class="form-control" id="kata_laluan" name="kata_laluan" placeholder="Kata Laluan" value="">
                    </div>
                  </div>
                </div>	  
			  
                <!-- /.card-body -->
				<div class="card-footer">
					<button type="submit" name="submit_pengguna" class="btn btn-info bg-purple">Simpan</button>
					<button type="button" class="btn btn-default float-right" onclick="history.back();">Kembali</button>
				</div>
				<!-- /.card-footer -->
              </form>
            </div>
            <!-- /.card -->			
          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    
@endsection

@section('script')
	<script>
	$(function () {
		//Initialize Select2 Elements
		$('.select2').select2();
		
		bsCustomFileInput.init();
	});
	</script>
@endsection

