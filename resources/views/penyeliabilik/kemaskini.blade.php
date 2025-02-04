@extends('layouts/master')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Kemaskini Pengguna</h1>
          </div><!-- /.col -->
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/home') }}">Laman Utama</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/pengguna') }}">Pengguna</a></li>
              <li class="breadcrumb-item active">Kemaskini</li>
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
              <div class="card-header">
                <h3 class="card-title">Maklumat Pengguna</h3>
              </div>
              <!-- /.card-header -->
                <div class="card-body">
				<form class="form-horizontal" method="POST" action="{{ url('pengguna/kemaskini/'.$user->id) }}" enctype="multipart/form-data">
				  {{ csrf_field() }}
                  <dl class="row">
					<dt class="col-sm-3">No. Mykad</dt>
					<dd class="col-sm-9">{{ $user->mykad }}</dd>
					<dt class="col-sm-3">Nama</dt>
					<dd class="col-sm-9">{{ $user->nama }}</dd>
					<dt class="col-sm-3">Bahagian</dt>
					<dd class="col-sm-9">{{ $user->bahagian }}</dd>
					<dt class="col-sm-3">Jawatan</dt>
					<dd class="col-sm-9">{{ $user->jawatan }}</dd>
					<dt class="col-sm-3">Emel</dt>
					<dd class="col-sm-9">{{ $user->email }}</dd>
				  </dl>
				  <div class="form-group row">
					<label for="status" class="col-sm-3 col-form-label">Status</label>
					<div class="col-sm-9" style="margin-top:7px;">
						@php old('status') == NULL ? $status1=$user->status_akaun : $status1=old('status') @endphp
						@foreach ($optStatusUsers as $optStatusUser)
						<input type="radio" name="status" id="{{ $optStatusUser->jenis_status_risi }}" value="{{ $optStatusUser->id_status_risi }}" @if($status1==$optStatusUser->id_status_risi) {{ 'checked="checked"' }} @endif> <label class="form-check-label" for="{{ $optStatusUser->jenis_status_risi }}">{{ $optStatusUser->jenis_status_risi }}</label> &nbsp;&nbsp;&nbsp;
						@endforeach
					</div>
				  </div>
				  
				  <div class="form-group row">
                    <label for="peranan" class="col-sm-3 col-form-label">Peranan</label>
                    <div class="col-sm-9">
						<select class="form-control select2" id="peranan" name="peranan" style="width: 100%;">
							<option value="" @if(old('peranan')=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
							@foreach ($optAccesss as $optAccess)
								<option value="{{ $optAccess->id_access }}" @if(old('peranan')==$optAccess->id_access) {{ 'selected="selected"' }} @endif>{{ $optAccess->access_type }}</option>
							@endforeach
						</select>
                    </div>
                  </div>
				</div>	
				
				<div class="card-header">
					<h3 class="card-title">Maklumat Login</h3>
				</div>
			    <div class="card-body">
                  <dl class="row">
					<dt class="col-sm-3">ID Pengguna</dt>
					<dd class="col-sm-9">{{ $user->id_pengguna }}</dd>
				  </dl>
                  <div class="form-group row">
                    <label for="kata_laluan" class="col-sm-3 col-form-label">Kata Laluan</label>
                    <div class="col-sm-9">
                      <input type="password" class="form-control" id="kata_laluan" name="kata_laluan" placeholder="Kata Laluan" value="">
                    </div>
                  </div>
                </div>	  
			  
                <!-- /.card-body -->
				<div class="card-footer">
					<button type="submit" name="submit_pengguna" class="btn btn-info">Simpan</button>
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

