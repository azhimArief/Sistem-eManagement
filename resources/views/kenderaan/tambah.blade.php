@extends('layouts/master')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">TAMBAH KENDERAAN</h1>
          </div><!-- /.col -->
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/home') }}">Laman Utama</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/kenderaan') }}">Kenderaan</a></li>
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
                <h3 class="card-title">Maklumat Kenderaan</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form class="form-horizontal" method="POST" action="{{ url('kenderaan/tambah') }}" enctype="multipart/form-data">
			  {{ csrf_field() }}
                <div class="card-body"  style=align:center>
                  <div class="form-group row">
                    <label for="no_plat" class="col-sm-3 col-form-label" for="no_plat">No. Kenderaan <font color="red">*</font> </label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" id="no_plat" name="no_plat" placeholder="No. Kenderaan" value="{{ old('no_plat') }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="jenis" class="col-sm-3 col-form-label" for="jenis">Jenis Kenderaan  <font color="red">*</font> </label>
                    <div class="col-sm-6">
                      <select class="form-control select2" id="jenis" name="jenis" style="width: 100%;">
                        <option value="" @if(old('jenis')=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
                        @foreach ($optionJeniskenderaans as $optionJeniskenderaan)
                          <option value="{{ $optionJeniskenderaan->id_jenis_kenderaan }}" @if(old('jenis')==$optionJeniskenderaan->id_jenis_kenderaan) {{ 'selected="selected"' }} @endif>{{ $optionJeniskenderaan->jenis_kenderaan }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="model" class="col-sm-3 col-form-label" for="model">Model Kenderaan  <font color="red">*</font> </label>
                    <div class="col-sm-6">
                      <select class="form-control select2" id="model" name="model" style="width: 100%;">
                        <option value="" @if(old('model')=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
                        @foreach ($optionModels as $optionModel)
                          <option value="{{ $optionModel->id_model }}" @if(old('model')==$optionModel->id_model) {{ 'selected="selected"' }} @endif>{{ $optionModel->jenis_model }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="Bil_penumpang" class="col-sm-3 col-form-label" for="Bil_penumpang">Bilangan Penumpang </label>
                    <div class="col-sm-6">
                      <input type="number" class="form-control" id="Bil_penumpang" name="Bil_penumpang" placeholder="Bilangan Penumpang" value="{{ old('Bil_penumpang') }}">
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label for="pemandu" class="col-sm-3 col-form-label">Nama Pemandu  <font color="red">*</font> </label>
                    <div class="input-group col-sm-6">
                      <select class="form-control select2" id="pemandu" name="pemandu" style="width: 100%;">
                        <option value="" @if(old('pemandu')=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
                        @foreach ($optionPemandus as $optionPemandu)
                          <option value="{{ $optionPemandu->mykad }}" @if(old('pemandu')==$optionPemandu->mykad) {{ 'selected="selected"' }} @endif>{{ $optionPemandu->nama_pemandu }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="status" class="col-sm-3 col-form-label">Status Kenderaan  <font color="red">*</font> </label>
                    <div class="input-group col-sm-6">
                      <select class="form-control select2" id="status" name="status" style="width: 100%;">
                        <option value="" @if(old('status')=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
                        @foreach ($optionStatuss as $optionStatus)
                          <option value="{{ $optionStatus->id_status }}" @if(old('status')==$optionStatus->id_status) {{ 'selected="selected"' }} @endif>{{ $optionStatus->status }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="catatan" class="col-sm-3 col-form-label">Catatan</label>
                    <div class="col-sm-6">
                      <textarea id="catatan" name="catatan" type="text" class="form-control" rows="3" value="{{ old('catatan') }}" placeholder="Catatan">{{ old('catatan') }}</textarea>
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
                  <button type="submit" name="submit_kenderaan" class="btn btn-info bg-purple">Simpan</button>
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
	});
	</script>
@endsection

