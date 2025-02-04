@extends('layouts/masterScreen')
@section('content')
<!-- Content Header (Page header) -->
<!-- <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
			&nbsp;

          <div class="col-sm-6"> -->
            <!-- <h1 class="m-0">Borang Penilaian Pemandu</h1> -->
         
      <!-- </div> -->
  <!-- </div> -->
    
<div class="container" align="center">
	<br>
	<div class="container-fluid">
		<div class="col-md-9">
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
	
	<div class="col-sm-9">
		<div class="card card-info">
			<div class="card-header bg-purple" align="center">
				<h5 style="text-transform:uppercase">CATATAN PEMANDU KENDERAAN BAGI PERKHIDMATAN KENDERAAN JABATAN<br>KEMENTERIAN PERPADUAN NEGARA</h5>
			</div>
			<div class="card-body" style="text-align:left" >
			<!-- style="margin:10px 50px 10px 50px;" -->
			<form class="form-horizontal" method="POST" action="{{ url('pemandu/catatan/'.$mykad) }}" enctype="multipart/form-data">
			{{ csrf_field() }}
				<div class="form-group row">
					<label for="id_tempahan" class="col-sm-4 col-form-label">ID Tempahan : <font color= "red">*</font> </label>
					<div class="col-sm-8">
						<select class="form-control select2" id="id_tempahan" name="id_tempahan" required>
							<option value="" @if($Srhfield['id_tempahan']=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
							@foreach ($id_tempahans as $id_tempahan)
							<option value="{{ $id_tempahan->id_permohonan }}" >{{ \App\PermohonanKenderaan::find($id_tempahan->id_permohonan)->kod_permohonan }}</option>
							@endforeach
						</select>
					</div>
				</div> 

				<div class="form-group row">
					<label for="komen_pemandu" class="col-sm-9 col-form-label" style="text-align:left;">Catatan : <font color= "red">*</font> </label>
					<div class="col-sm-12">
						<textarea id="komen_pemandu" name="komen_pemandu" type="text" class="form-control" rows="5" value="{{ old('komen_pemandu') }}" placeholder="" required>{{ old('komen_pemandu') }}</textarea>
					</div>
				</div>
				
			</div>
			
			<!-- /.card-body -->
			<div class="card-footer">
				<button type="submit" name="" class="btn btn-info bg-purple float-left">Hantar</button>
				<button type="button" class="btn btn-default float-right" onclick="history.back();">Kembali</button>
			</div>
			<!-- /.card-footer -->
			</form>	
		</div>
	</div>
	<!--/.col (right) -->
</div><!-- /.container -->
   
@endsection

@section('script')
<script type="text/javascript">
	

</script>
@endsection

