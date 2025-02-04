@extends('layouts/master')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h3 class="m-0" style="text-transform:uppercase">Borang penilaian perkhidmatan kenderaan jabatan kementerian perpaduan negara</h3>
          </div><!-- /.col -->
          
     
          
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
				<!-- <div class="card-header">
					<h3 class="card-title">Maklumat Pemohon</h3>
				</div> -->
				<!-- /.card-header -->
				<div class="card-body" style="padding:10 40 40 40;">
				<form class="form-horizontal" method="POST" action="{{ url('penilaian/borang') }}" enctype="multipart/form-data">
				{{ csrf_field() }}
			
					<div class=" col-sm-11 row">
						Terima kasih kerana menggunakan Perkhidmatan Kenderaan Jabatan Kementerian Perpaduan Negara. Mohon Kerjasama untuk memberikan penilaian dan maklum balas bagi perkhidmatan Kenderaan Jabatan Kementerian Perpaduan Negara yang telah disediakan seperti berikut:
						<br><br>
					</div>
					@foreach($lkpSoalans as $lkpSoalan)
					<div class="form-group row">
						<label for="soalan[{{  $lkpSoalan->id_soalan }}]" class="col-sm-12 col-form-label">{{ $lkpSoalan->id_soalan }}. {{  $lkpSoalan->soalan }}</label>
						<input type="hidden" class="form-control" id="soalan[{{  $lkpSoalan->id_soalan }}]" name="soalan[{{  $lkpSoalan->id_soalan }}]" value="{{ $lkpSoalan->id_soalan }}"> 
						<div class="col-sm-12" style="margin-right:60px;">
							<input type="radio" id="skala[{{  $lkpSoalan->id_soalan }}]" value="5" name="skala[{{  $lkpSoalan->id_soalan }}]" > Sangat Baik &emsp;
							<input type="radio" id="skala[{{  $lkpSoalan->id_soalan }}]" value="4"  name="skala[{{  $lkpSoalan->id_soalan }}]" > Baik &emsp;
							<input type="radio" id="skala[{{  $lkpSoalan->id_soalan }}]" value="3"  name="skala[{{  $lkpSoalan->id_soalan }}]"  > Memuaskan &emsp;
							<input type="radio" id="skala[{{  $lkpSoalan->id_soalan }}]" value="2"  name="skala[{{  $lkpSoalan->id_soalan }}]" > Kurang Memuaskan &emsp;
							<input type="radio" id="skala[{{  $lkpSoalan->id_soalan }}]" value="1"  name="skala[{{  $lkpSoalan->id_soalan }}]"  > Sangat Tidak Memuaskan &emsp;
						</div>
					</div>
					@endforeach

					<div class="form-group row">
						<label for="ulasan" class="col-sm-3 col-form-label">Ulasan :</label>
						<div class="col-sm-11">
							<textarea id="ulasan" name="ulasan" type="text" class="form-control" rows="5" value="{{ old('ulasan') }}" placeholder="">{{ old('ulasan') }}</textarea>
          				</div>
					</div>
				
				</div>
			
				
                <!-- /.card-body -->
				<div class="card-footer">
					<button type="submit" name="submit_tempahankenderaan" class="btn btn-info">Hantar</button>
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
<script type="text/javascript">
	$(function () {
	//Initialize Select2 Elements
	$('.select2').select2();

	$('#tkh_pergi').datetimepicker({
		format: 'DD.MM.YYYY'
	});
	$('#tkh_balik').datetimepicker({
		format: 'DD.MM.YYYY'
	});

	updatePenumpang();

	bsCustomFileInput.init();
	});

</script>
@endsection

