@extends('layouts/masterScreen')
@section('content')

<!-- Content Header (Page header) -->
<!-- <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
		  	<button type="button" class="btn btn-info btn-block" style="text-transform:uppercase"><h5>Borang penilaian perkhidmatan kenderaan jabatan<br>kementerian perpaduan negara</h5></button> -->
            <!-- <h5 class="m-0" style="text-transform:uppercase; text-align:center">Borang penilaian perkhidmatan kenderaan jabatan<br>kementerian perpaduan negara</h5>
          </div> -->
		  <!-- /.col -->
          
     
          
          <!-- /.col -->
        <!-- </div> -->
		<!-- /.row -->
      <!-- </div> -->
	  <!-- /.container-fluid -->
  <!-- </div> -->
<div class="container" align="center">
<br>
	<!-- <div class="col-sm-11">
		<div class="row mb-2">
			<div class="col-sm-12">
				
			</div>
		</div>
	</div>	 -->
	<div class="container-fluid">
		<div class="col-md-11">
			<div class="row">
				<!-- left column -->
				<div class="col-md-12">
					@if (session('status'))
					<div class="alert alert-success"  style="text-align:left" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						{{ session('status') }}
					</div>
					@elseif(session('failed'))
					<div class="alert alert-danger" style="text-align:left" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						{{ session('failed') }}
					</div>
					@endif 
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-11">
		<!-- form start -->
		<!-- Horizontal Form -->
		<div class="card card-info">
		<!-- style="margin:0px 250px 40px 250px;" -->
			<div class="card-header bg-purple" align="center">
				<h5 style="text-transform:uppercase">Borang penilaian perkhidmatan kenderaan jabatan<br>kementerian perpaduan negara</h5>
			</div>
			<!-- /.card-header -->
			<div class="card-body" style="text-align:left" >
			<!-- style="margin:10px 50px 10px 50px;" -->
			<form class="form-horizontal" method="POST" action="{{ url('pemohon/penilaian/'.$mykad) }}" enctype="multipart/form-data">
			{{ csrf_field() }}
				
				<!-- <div class="modal-footer justify-content-between">
					<P></P>
					<span class="float-right">
					<button type="submit" class="btn btn-info" name="permohonan">Hantar</button>
					<a href="{{ url('POWER') }}" class="btn btn-default" name="tapis_risi">Reset</a>
					</span>
				</div> -->
				
				<div class=" col-sm-11 row">
					<p align="justify">Terima kasih kerana menggunakan Perkhidmatan Kenderaan Jabatan Kementerian Perpaduan Negara. Mohon Kerjasama untuk memberikan penilaian dan maklum balas bagi perkhidmatan Kenderaan Jabatan Kementerian Perpaduan Negara yang telah disediakan seperti berikut:</p>
				</div>
				<div class="form-group row">
					<label for="id_tempahan" class="col-sm-2 col-form-label">ID Tempahan :  <font color= "red">*</font> </label>
					<div class="col-sm-5">
						<select class="form-control select2" id="id_tempahan" name="id_tempahan" required>
							<option value="" @if($Srhfield['id_tempahan']=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
							@foreach ($id_tempahans as $id_tempahan)
							<option value="{{ $id_tempahan->id_tempahan }}" >{{ \App\PermohonanKenderaan::find($id_tempahan->id_tempahan)->kod_permohonan }}</option>
							@endforeach
						</select>
					</div>
				</div> 

				@foreach($lkpSoalans as $lkpSoalan)
				<div class="form-group row">
					<label for="soalan[{{  $lkpSoalan->id_soalan }}]" class="col-sm-12 col-form-label">{{ $lkpSoalan->id_soalan }}. {{  $lkpSoalan->soalan }} <font color= "red">*</font> </label>
					<input type="hidden" class="form-control" id="soalan[{{  $lkpSoalan->id_soalan }}]" name="soalan[{{  $lkpSoalan->id_soalan }}]" value="{{ $lkpSoalan->id_soalan }}"> 
					<div class="col-sm-11">
					&emsp;<input type="radio" id="skala[{{  $lkpSoalan->id_soalan }}]" value="5" name="skala[{{  $lkpSoalan->id_soalan }}]" required>  &emsp; Sangat Baik &emsp;<br>
					&emsp;<input type="radio" id="skala[{{  $lkpSoalan->id_soalan }}]" value="4"  name="skala[{{  $lkpSoalan->id_soalan }}]" required>  &emsp; Baik &emsp;<br>
					&emsp;<input type="radio" id="skala[{{  $lkpSoalan->id_soalan }}]" value="3"  name="skala[{{  $lkpSoalan->id_soalan }}]"  required>  &emsp; Memuaskan &emsp;<br>
					&emsp;<input type="radio" id="skala[{{  $lkpSoalan->id_soalan }}]" value="2"  name="skala[{{  $lkpSoalan->id_soalan }}]" required>  &emsp; Kurang Memuaskan &emsp;<br>
					&emsp;<input type="radio" id="skala[{{  $lkpSoalan->id_soalan }}]" value="1"  name="skala[{{  $lkpSoalan->id_soalan }}]"  required>  &emsp; Sangat Tidak Memuaskan &emsp;<br>
						
					</div>
				</div>
				@endforeach

				<div class="form-group row">
					<label for="ulasan" class="col-sm-3 col-form-label">Ulasan :</label>
					<div class="col-sm-11">
						<textarea id="ulasan" name="ulasan" type="text" class="form-control" rows="3" value="{{ old('ulasan') }}" placeholder="">{{ old('ulasan') }}</textarea>
					</div>
				</div>
			
			</div>
		
			
			<!-- /.card-body -->
			<div class="card-footer">
				<button type="submit" name="submit_tempahankenderaan" class="btn btn-info bg-purple float-left">Hantar</button>
				<button type="button" class="btn btn-default float-right" onclick="history.back();">Kembali</button>
			</div>
			<!-- /.card-footer -->
			
			</form>
		</div>
		<!-- /.card -->			
	</div>
	<!--/.col (right) -->
       
</div><!-- /.container -->

    
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

