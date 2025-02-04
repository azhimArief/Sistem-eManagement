@extends('layouts/master')
@section('content')
<style>
.switch {
  position: relative;
  display: inline-block;
  width: 90px;
  height: 36px;
}

.switch input {display:none;}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ca2222;
  -webkit-transition: .4s;
  transition: .4s;
  border-radius: 6px;
}

.slider:before {
  position: absolute;
  content: "";
  height: 34px;
  width: 32px;
  top: 1px;
  left: 1px;
  right: 1px;
  bottom: 1px;
  background-color: white;
  transition: 0.4s;
  border-radius: 6px;
}

input:checked + .slider {
  background-color: #2ab934;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(55px);
}

.slider:after {
  content:'Tidak Aktif';
  color: white;
  display: block;
  position: absolute;
  transform: translate(-50%,-50%);
  top: 50%;
  left: 60%;
  font-size: 10px;
  font-family: Verdana, sans-serif;
  text-align: right;
}
input:checked + .slider:after {
  content:'Aktif';
  left: 30%;
  text-align: left;
}

</style>

<!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">TAMBAH PEMANDU</h1>
          </div><!-- /.col -->
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/home') }}">Laman Utama</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/pemandu') }}">Pemandu</a></li>
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
            <!-- Horizontal Form -->
            <div class="card card-info">
              <div class="card-header bg-purple">
                <h3 class="card-title">Maklumat Pemandu</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form class="form-horizontal" method="POST" action="{{ url('pemandu/tambah') }}" enctype="multipart/form-data">
			  {{ csrf_field() }}
                <div class="card-body">
                <div class="form-group row">
                    <label for="mykad" class="col-sm-3 col-form-label">Mykad <font color= "red">*</font></label>
                    <div class="input-group col-sm-6">
                      <input type="text" class="form-control" id="mykad" name="mykad" placeholder="Mykad" value="{{ old('mykad') }}">
                      <div class="input-group-append">
                        <button type="submit" name="semak_mykad" value="semak_mykad" class="input-group-text bg-primary"><i class="fa fa-search"></i>  Semak</button>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="nama_pemandu" class="col-sm-3 col-form-label">Nama Pemandu</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" id="nama_pemandu" name="nama_pemandu" placeholder="Nama Pemandu" value="{{ old('nama_pemandu') }}" readonly="readonly">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="gred" class="col-sm-3 col-form-label">Gred</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" id="gred" name="gred" placeholder="Gred" value="{{ old('gred') }}" readonly="readonly">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="bahagian" class="col-sm-3 col-form-label">Bahagian</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" id="bahagian" name="bahagian" placeholder="Bahagian" value="{{ old('bahagian') }}" readonly="readonly">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="no_tel_bimbit" class="col-sm-3 col-form-label">No. Tel. Bimbit <font color= "red">*</font></label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" id="no_tel_bimbit" name="no_tel_bimbit" placeholder="No. Tel. Bimbit" value="{{ old('no_tel_bimbit') }}" >
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="email" class="col-sm-3 col-form-label">Emel <font color= "red">*</font></label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" id="email" name="email" placeholder="Emel" value="{{ old('email') }}" >
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Status <font color= "red">*</font></label>
                    <div class="input-group-prepend">
                      <div class="col-sm-9">
                      <label class="switch">
                        <input type="checkbox" id="status"name="status" data-on="1" data-off="0"  checked="checked" value="9">
                        <div class="slider"></div>
                      </label>
                  </div>
                </div>

				  <?php /*div class="form-group row">
					<label for="inputEmail3" class="col-sm-3 col-form-label" for="status">Status</label>
					<div class="col-sm-9">
						<select class="form-control select2" id="status" name="status" style="width: 100%;">
							<option value="" @if(old('status')=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
							@foreach ($optionStatuss as $optionStatus)
								<option value="{{ $optionStatus->id_status_risi }}" @if(old('status')==$optionStatus->id_status_risi) {{ 'selected="selected"' }} @endif>{{ $optionStatus->jenis_status_risi }}</option>
							@endforeach
						</select>
					</div */?>
				  </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" name="submit_pemandu" class="btn btn-info bg-purple">Simpan</button>
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
		$('.select2').select2()
		
		$('#tkh_kuatkuasa').datetimepicker({
			format: 'DD.MM.YYYY'
		});

    $("#status").change(function(){
      if($(this).prop("checked") == true){
        $('#status').val('9');
      }else{
        $('#status').val('10');
      }
    });
	});
	</script>
@endsection

