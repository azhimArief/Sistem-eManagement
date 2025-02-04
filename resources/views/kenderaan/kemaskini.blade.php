@extends('layouts/master')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">KEMASKINI KENDERAAN</h1>
          </div><!-- /.col -->
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/home') }}">Laman Utama</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/kenderaan') }}">Kenderaan</a></li>
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
            <!-- Horizontal Form -->
            <div class="card card-info">
              <div class="card-header bg-purple">
                <h3 class="card-title">Maklumat Kenderaan</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form class="form-horizontal" method="POST" action="{{ url('kenderaan/kemaskini/'.$kenderaan->id_kenderaan) }}" enctype="multipart/form-data">
			  {{ csrf_field() }}
                <div class="card-body">
                  <div class="form-group row">
                    <label for="no_plat" class="col-sm-3 col-form-label">No Kenderaan  <font color="red">*</font> </label>
                    <div class="col-sm-5">
                      <input type="text" class="form-control" id="no_plat" name="no_plat" placeholder="No Kenderaan" value="{{ old('no_plat') == NULL ? $kenderaan->no_plat : old('no_plat') }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="jenis" class="col-sm-3 col-form-label">Jenis kenderaan  <font color="red">*</font> </label>
                    <div class="col-sm-5">
                    <select class="form-control select2" id="jenis" name="jenis" style="width: 100%;">
                      {{ old('jenis') == NULL ? $jenis1=$kenderaan->id_jenis : $jenis1=old('jenis') }}
                      <option value="" @if($jenis1=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
                      @foreach ($optionJenisKenderaans as $optionJenisKenderaan)
                        <option value="{{ $optionJenisKenderaan->id_jenis_kenderaan }}" @if($jenis1==$optionJenisKenderaan->id_jenis_kenderaan) {{ 'selected="selected"' }} @endif>{{ $optionJenisKenderaan->jenis_kenderaan }}</option>
                      @endforeach
                    </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="model" class="col-sm-3 col-form-label">Model kenderaan  <font color="red">*</font> </label>
                    <div class="col-sm-5">
                    <select class="form-control select2" id="model" name="model" style="width: 100%;">
                      {{ old('model') == NULL ? $model1=$kenderaan->id_model : $model1=old('model') }}
                      <option value="" @if($model1=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
                      @foreach ($optionModels as $optionModel)
                        <option value="{{ $optionModel->id_model }}" @if($model1==$optionModel->id_model) {{ 'selected="selected"' }} @endif>{{ $optionModel->jenis_model }}</option>
                      @endforeach
                    </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="Bil_penumpang" class="col-sm-3 col-form-label">Bil Penumpang</label>
                    <div class="col-sm-5">
                      <input type="number" class="form-control" id="Bil_penumpang" name="Bil_penumpang" placeholder="Bil Penumpang" value="{{ old('Bil_penumpang') == NULL ? $kenderaan->Bil_penumpang : old('Bil_penumpang') }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="nama_pemandu" class="col-sm-3 col-form-label">Nama Pemandu  <font color="red">*</font> </label>
                    <div class="col-sm-5">
                    <select class="form-control select2" id="nama_pemandu" name="nama_pemandu" style="width: 100%;">
                      {{ old('jenis') == NULL ? $nama_pemandu1=$kenderaan->pemandu : $nama_pemandu1=old('nama_pemandu') }}
                      <option value="" @if($nama_pemandu1=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
                      @foreach ($optionPemandus as $optionPemandu)
                        <option value="{{ $optionPemandu->mykad }}" @if($nama_pemandu1==$optionPemandu->mykad) {{ 'selected="selected"' }} @endif>{{ $optionPemandu->nama_pemandu }}</option>
                      @endforeach
                    </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="status" class="col-sm-3 col-form-label">Status Kenderaan  <font color="red">*</font> </label>
                    <div class="col-sm-5">
                    <select class="form-control select2" id="status" name="status" style="width: 100%;">
                      {{ old('status') == NULL ? $status1=$kenderaan->id_status : $status1=old('status') }}
                      <option value="" @if($status1=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
                      @foreach ($optionStatuss as $optionStatus)
                        <option value="{{ $optionStatus->id_status }}" @if($status1==$optionStatus->id_status) {{ 'selected="selected"' }} @endif>{{ $optionStatus->status }}</option>
                      @endforeach
                    </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="catatan" class="col-sm-3 col-form-label">Catatan</label>
                    <div class="col-sm-5">
                      <textarea id="catatan" name="catatan" type="text" class="form-control{{ $errors->has('catatan') ? ' is-invalid' : '' }}" rows="3">{{ $kenderaan->catatan }}</textarea>
                    </div>
                  </div>
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



