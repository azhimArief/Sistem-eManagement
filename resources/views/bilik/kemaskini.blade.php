@extends('layouts/master')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">KEMASKINI BILIK</h1>
          </div><!-- /.col -->
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/homeBilikMeet') }}">Laman Utama</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/bilik') }}">Bilik</a></li>
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
                <h3 class="card-title">Maklumat Bilik</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form class="form-horizontal" method="POST" action="{{ url('bilik/kemaskini/'.$biliks->id_bilik) }}" enctype="multipart/form-data">
			            {{ csrf_field() }}
                <div class="card-body">

                  <div class="form-group row">
                    <label for="nama_bilik" class="col-sm-3 col-form-label">Nama Bilik  <font color="red">*</font> </label>
                    <div class="col-sm-5">
                      <input type="text" class="form-control" id="nama_bilik" name="nama_bilik" placeholder="Nama Bilik" value="{{ old('nama_bilik') == NULL ? $biliks->bilik : old('nama_bilik') }}">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="bahagian" class="col-sm-3 col-form-label">Bahagian  <font color="red">*</font> </label>
                    <div class="col-sm-5">
                    <select class="form-control select2" id="bahagian" name="bahagian" style="width: 100%;" required>
                      {{ old('jenis') == NULL ? $bahagian1=$biliks->id_bahagian : $bahagian1=old('bahagian') }}
                      <option value="" @if($bahagian1=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
                      @foreach ($optBahagians as $optBahagian)
                        <option value="{{ $optBahagian->id }}" @if($bahagian1==$optBahagian->id) {{ 'selected="selected"' }} @endif>{{ $optBahagian->bahagian }}</option>
                      @endforeach
                    </select>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="kapasiti" class="col-sm-3 col-form-label">Kapasiti Bilik </label>
                    <div class="col-sm-5">
                      <input type="text" class="form-control" id="kapasiti" name="kapasiti" placeholder="Kapasiti Bilik" value="{{ old('kapasiti') == NULL ? $biliks->kapasiti_bilik : old('kapasiti') }}">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="aras" class="col-sm-3 col-form-label">Aras <font color="red">*</font> </label>
                    <div class="col-sm-5">
                      <input type="text" class="form-control" id="aras" name="aras" placeholder="Aras Bilik" value="{{ old('aras') == NULL ? $biliks->aras : old('aras') }}" required>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="kemudahan" class="col-sm-3 col-form-label">Kemudahan Bilik</label>
                    <div class="col-sm-5">
                      <input type="text" class="form-control" id="kemudahan" name="kemudahan" placeholder="Kemudahan Bilik" value="{{ old('kemudahan') == NULL ? $biliks->kemudahan_bilik : old('kemudahan') }}">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="gambar_bilik" class="col-sm-3 col-form-label">Gambar Bilik   </label>
                    <div class="col-sm-5">
                        @if ($biliks->gambar_bilik == null)
                             <input type="file" name="gambar_bilik" id="gambar_bilik">
                        @else
                            <a href="{{ url('' . $biliks->gambar_bilik) }}" target="_blank"><img
                            class="img-fluid mb-3" src="{{ url('' . $biliks->gambar_bilik) }}"
                            alt="Photo" width="200" height="200"></a>
                            <br>
                            <input type="file" name="gambar_bilik" id="gambar_bilik" value="{{ $biliks->gambar_bilik }}"> 
                            <button type="submit" name="buang_gambar" class="btn btn-outline-danger btn-sm float-right"> Buang Gambar</button>
                         @endif
                    </div>
                  </div>

                  {{-- <div class="form-group row">
                    <label for="catatan" class="col-sm-3 col-form-label">Gambar Bilik</label>
                    <div class="col-sm-5">
                      <textarea id="catatan" name="catatan" type="text" class="form-control{{ $errors->has('catatan') ? ' is-invalid' : '' }}" rows="3">{{ $kenderaan->catatan }}</textarea>
                    </div>
                  </div>
                </div> --}}
                
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



