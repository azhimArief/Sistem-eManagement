@extends('layouts/master')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Borang Penilaian Pemandu</h1>
          </div><!-- /.col -->
          
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/home') }}">Laman Utama</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/tempahankenderaan') }}">Tempahan Kenderaan</a></li>
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
					
						<form class="form-horizontal" method="POST" action="{{ url('penilaian/catatanpemandu/'.$permohonanKenderaan->id_maklumat_permohonan) }}" enctype="multipart/form-data">
						{{ csrf_field() }}
							
						<div class="card-header">
							<h3 class="card-title">CATATAN PEMANDU KENDERAAN BAGI PERKHIDMATAN KENDERAAN JABATAN KEMENTERIAN PERPADUAN NEGARA</h3>
						</div>
						<div class="card-body">
							<div class="form-group row">
								<label for="komen_pemandu" class="col-sm-1 col-form-label">Catatan:</label>
								<div class="col-sm-10">
									<textarea id="komen_pemandu" name="komen_pemandu" type="text" class="form-control" rows="5" value="{{ old('komen_pemandu') }}" placeholder="">{{ old('komen_pemandu') }}</textarea>
								</div>
							</div>
						</div>
						<!-- /.card-body -->
						<div class="card-footer">
							<button type="submit" name="" class="btn btn-info">Hantar</button>
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
	

</script>
@endsection

