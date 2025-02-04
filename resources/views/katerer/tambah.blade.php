@extends('layouts/master')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">TAMBAH KATERER</h1>
          </div><!-- /.col -->
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/homeBilikMeet') }}">Laman Utama</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/katerer') }}">Katerer</a></li>
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
                <h3 class="card-title">Maklumat Katerer</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form class="form-horizontal" method="POST" action="{{ url('katerer/tambah') }}" enctype="multipart/form-data">
			            {{ csrf_field() }}
                <div class="card-body"  style=align:center>

                  <div class="form-group row">
                    <label for="nama_katerer" class="col-sm-3 col-form-label">Nama Katerer  <font color="red">*</font> </label>
                    <div class="col-sm-5">
                      <input type="text" class="form-control" id="nama_katerer" name="nama_katerer" placeholder="Nama Katerer" value="{{ old('nama_katerer') }}" required>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="alamat" class="col-sm-3 col-form-label">Alamat </label>
                    <div class="col-sm-5">
                      <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat Katerer" value="{{ old('alamat') }}">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="person" class="col-sm-3 col-form-label">Nama Untuk Dihubungi  </label>
                    <div class="col-sm-5">
                      <input type="text" class="form-control" id="person" name="person" placeholder="Nama Untuk Dihubungi" value="{{ old('person') }}">
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label for="emel" class="col-sm-3 col-form-label">Emel <font color="red">*</font> </label>
                    <div class="col-sm-5">
                      <input type="text" class="form-control" id="emel" name="emel" placeholder="Emel Katerer" value="{{ old('emel') }}">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="notel" class="col-sm-3 col-form-label">No Tel <font color="red">*</font> </label>
                    <div class="col-sm-5">
                      <input type="text" class="form-control" id="notel" name="notel" placeholder="No Telefon Untuk Dihubungi" value="{{ old('notel') }}">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="tkh_mula" class="col-sm-3 col-form-label">Tarikh Mula <font color="red">*</font> </label>
                    <div class="col-sm-4">
                      <div class="input-group date" id="tkh_mula" data-target-input="nearest" placeholder="Tarikh Mula">
                          <input type="text" id="tkh_mula" name="tkh_mula"
                              class="form-control datetimepicker-input" data-target="#tkh_mula"
                              value="{{ old('tkh_mula') }}" required />
                          <div class="input-group-append" data-target="#tkh_mula" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                          </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="tkh_tamat" class="col-sm-3 col-form-label">Tarikh Tamat <font color="red">*</font> </label>
                    <div class="col-sm-4">
                      <div class="input-group date" id="tkh_tamat" data-target-input="nearest" placeholder="Tarikh Tamat">
                          <input type="text" id="tkh_tamat" name="tkh_tamat"
                              class="form-control datetimepicker-input" data-target="#tkh_tamat"
                              value="{{ old('tkh_tamat') }}" required />
                          <div class="input-group-append" data-target="#tkh_tamat" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                          </div>
                      </div>
                    </div>
                  </div>

				  </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" name="submit_katerer" class="btn btn-info bg-purple">Simpan</button>
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
		
		$('#tkh_mula').datetimepicker({
			format: 'DD.MM.YYYY'
		});
		$('#tkh_tamat').datetimepicker({
			format: 'DD.MM.YYYY'
		});
	});
	</script>
@endsection

