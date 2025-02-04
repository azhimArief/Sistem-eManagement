@extends('layouts/master')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">MAKLUMAT TINDAKAN </h1>
          </div><!-- /.col -->
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/home') }}">Laman Utama</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/tempahankenderaan') }}">Tempahan Kenderaan</a></li>
              <li class="breadcrumb-item active">Tindakan</li>
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
              <div class="card-header bg-purple">
                <h3 class="card-title">Tindakan Seksyen Pentadbiran</h3>
              </div>
              <!-- /.card-header -->
                <div class="card-body">
				<form class="form-horizontal" method="POST" action="{{ url('tempahankenderaan/tindakan/'.$permohonanKenderaan->id_maklumat_permohonan) }}" enctype="multipart/form-data">
				  {{ csrf_field() }}
                  	<div class="form-group row">
					  <label for="status" class="col-sm-2 col-form-label">Status</label>
						<div class="col-sm-4">
							<select class="form-control select2" id="status" name="status" style="width: 100%;">
								<option value="" @if(old('status')=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
								@foreach ($optStatuss as $optStatus)
									<option value="{{ $optStatus->id_status }}" @if(old('id_status')==$optStatus->id_status) {{ 'selected="selected"' }} @endif>{{ $optStatus->status }}</option>
								@endforeach
							</select> 
						</div>
					</div>
					
					<div class="form-group row">
						<label for="catatan" class="col-sm-2 col-form-label">Catatan </label>
						<div class="col-sm-4">
							<textarea id="catatan" name="catatan" type="text" class="form-control" rows="3" placeholder="Catatan"></textarea>
          				</div>
					</div>
				</div>	
				
				<div class="card-header bg-purple">
					<h3 class="card-title">Maklumat Kenderaan</h3>&nbsp;
					<!-- <a href="{{ url('/jadual')}}" target="_blank" ><i style="color: #ffffff;" class="fa fa-question-circle" data-html="true" data-toggle="tooltip" title="Klik untuk lihat jadual pemandu" data-original-title="Klik untuk lihat jadual pemandu"></i></a> -->
				</div>
				
			    <div class="card-body">
				@if ($permohonanKenderaan->id_jenis_perjalanan == 1 )
					<!-- <div class="form-group row">
						<h2 class="card-title"><u><strong> Kenderaan Pergi</strong></u></h2>
					</div> -->
					<p style="color:red">* Sila Semak Jadual Pemandu <a href="{{ url('/jadual')}}" target="_blank" style="color:red"><b>DI SINI</b></a>.</p>
					<div class="form-group row">
						<label for="kenderaan_pergi" class="col-sm-2 col-form-label">No Kenderaan</label>
						<div class="input-group col-sm-4">
							<select class="form-control select2" id="kenderaan_pergi" name="kenderaan_pergi" style="width: 100%;">
								<option value="" @if(old('kenderaan_pergi')=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
								@foreach ($kenderaan as $optKenderaan)
									<option value="{{ $optKenderaan->id_kenderaan }}" @if(old('id_kenderaan')==$optKenderaan->id_kenderaan) {{ 'selected="selected"' }} @endif>{{ $optKenderaan->no_plat }}</option>
								@endforeach
							</select> 
						</div>
					</div>
					<div class="form-group row">
						<label for="id_jenis_pergi" class="col-sm-2 col-form-label">Jenis Kenderaan</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="id_jenis_pergi" name="id_jenis_pergi" placeholder="Jenis Kenderaan" value="{{ old('id_jenis_pergi') }}" readonly="readonly">
						</div>
					</div>
					<div class="form-group row">
						<label for="id_model_pergi" class="col-sm-2 col-form-label">Model Kenderaan</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="id_model_pergi" name="id_model_pergi" placeholder="Model Kenderaan" value="{{ old('id_model_pergi') }}" readonly="readonly">
						</div>
					</div>
					<div class="form-group row">
						<label for="pemandu_pergi" class="col-sm-2 col-form-label">Pemandu</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="pemandu_pergi" name="pemandu_pergi" placeholder="Pemandu" value="{{ old('pemandu_pergi') }}" readonly="readonly">
						</div>
					</div>
					<div class="form-group row">
						<label for="hp_pemandu_pergi" class="col-sm-2 col-form-label">No. Tel. Bimbit Pemandu</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="hp_pemandu_pergi" name="hp_pemandu_pergi" placeholder="No. Tel. Bimbit Pemandu" value="{{ old('hp_pemandu_pergi') }}"  readonly="readonly">
						</div>
					</div>
					@else
					<div class="form-group row">
					
						<label for="jenis_pemandu" class="col-sm-2 col-form-label">Pemandu/Kenderaan  </label> 
						<div class="input-group col-sm-8">
							<div class="col-sm-3"><input type="radio" id="jenis_pemandu" name="jenis_pemandu" value="1" {{ (!old('jenis_pemandu') == '1') ? 'checked' : '' }}> &nbsp; Sama </div>
							<div class="col-sm-3"><input type="radio" id="jenis_pemandub" name="jenis_pemandu" value="2" {{ (old('jenis_pemandu') == '2') ? 'checked' : '' }} class="other"> &nbsp; Berbeza </div>
						</div>
					</div>
					&nbsp;&nbsp;
					<div class="container-fluid">
						
						<p style="color:red">* Sila Semak Jadual Pemandu <a href="{{ url('/jadual')}}" target="_blank" style="color:red"><b>DI SINI</b></a>.</p>
						<div class="row">
							<div class="col-md-6">
								<div class="card card-light">
									<div class="card-header" style="background-color : #E6E6FA">						
										<h3 class="card-title"><strong>Kenderaan Pergi</strong></h3>
										
									</div>
									<div class="card-body">
										<div class="form-group row">
											<label for="kenderaan_pergi" class="col-sm-4 col-form-label">No Kenderaan</label>
											<div class="col-sm-8">
												<select class="form-control select2" id="kenderaan_pergi" name="kenderaan_pergi" style="width: 100%;">
													<option value="" @if(old('kenderaan_pergi')=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
													@foreach ($kenderaan as $optKenderaan)
														<option value="{{ $optKenderaan->id_kenderaan }}" @if(old('id_kenderaan')==$optKenderaan->id_kenderaan) {{ 'selected="selected"' }} @endif>{{ $optKenderaan->no_plat }}</option>
													@endforeach
												</select> 
											</div>
										</div>
										<div class="form-group row">
											<label for="id_jenis_pergi" class="col-sm-4 col-form-label">Jenis Kenderaan</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" id="id_jenis_pergi" placeholder="Jenis Kenderaan" value="" readonly="readonly">
											</div>
										</div>
										<div class="form-group row">
											<label for="id_model_pergi" class="col-sm-4 col-form-label">Model Kenderaan</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" id="id_model_pergi" name="id_model_pergi" placeholder="Model Kenderaan" value="{{ old('id_model_pergi') }}" readonly="readonly">
											</div>
										</div>
										<div class="form-group row">
											<label for="pemandu_pergi" class="col-sm-4 col-form-label">Pemandu</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" id="pemandu_pergi" name="pemandu_pergi" placeholder="Pemandu" value="{{ old('pemandu_pergi') }}" readonly="readonly">
											</div>
										</div>
										<div class="form-group row">
											<label for="hp_pemandu_pergi" class="col-sm-4 col-form-label">No. Tel. Bimbit Pemandu</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" id="hp_pemandu_pergi" name="hp_pemandu_pergi" placeholder="No. Tel. Bimbit Pemandu" value="{{ old('hp_pemandu') }}"  readonly="readonly">
											</div>
										</div>
									</div>  <!-- /.card-body -->
								</div><!-- /.card -->
							</div>
						
							<div class="col-md-6">
							<!-- BAR CHART -->
								<div class="card card-light">
									<div class="card-header" style="background-color : #E6E6FA">						
										<h3 class="card-title"><strong>Kenderaan Balik</strong></h3>
									</div>
									<div class="card-body">
										<div class="form-group row">
											<label for="kenderaan_balik" class="col-sm-4 col-form-label">No Kenderaan</label>
											<div class="input-group col-sm-8">
												<select class="form-control select2" id="kenderaan_balik" name="kenderaan_balik" style="width: 100%;" disabled="disabled">
													<option value="" @if(old('kenderaan_balik')=='') {{ 'selected="selected"' }} @endif >&nbsp;</option>
													@foreach ($kenderaan as $optKenderaan)
														<option value="{{ $optKenderaan->id_kenderaan }}"  @if(old('id_kenderaan')==$optKenderaan->id_kenderaan) {{ 'selected="selected"' }} @endif>{{ $optKenderaan->no_plat }}</option>
													@endforeach
												</select> 
											</div>
										</div>
										<div class="form-group row bg-pale-blue">		
											<label for="id_jenis_balik" class="col-sm-4 col-form-label">Jenis Kenderaan</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" id="id_jenis_balik" name="id_jenis_balik" placeholder="Jenis Kenderaan" value="{{ old('id_jenis_balik') }}" readonly="readonly">
											</div>
										</div>
										<div class="form-group row">
											<label for="id_model_balik" class="col-sm-4 col-form-label">Model Kenderaan</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" id="id_model_balik" name="id_model_balik" placeholder="Model Kenderaan" value="{{ old('id_model_balik') }}" readonly="readonly">
											</div>
										</div>
										<div class="form-group row">
											<label for="pemandu_balik" class="col-sm-4 col-form-label">Pemandu</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" id="pemandu_balik" name="pemandu_balik" placeholder="Pemandu" value="{{ old('pemandu_balik') }}" readonly="readonly">
											</div>
										</div>
										<div class="form-group row">
											<label for="hp_pemandu_balik" class="col-sm-4 col-form-label">No. Tel. Bimbit Pemandu</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" id="hp_pemandu_balik" name="hp_pemandu_balik" placeholder="No. Tel. Bimbit Pemandu" value="{{ old('hp_pemandu_balik') }}" readonly="readonly">
											</div>
										</div>
										
									</div>  <!-- /.card-body -->
								</div><!-- /.card -->
							</div>
						</div>
					</div>
					
					@endif
                </div>	  
				
			  
                <!-- /.card-body -->
				<div class="card-footer">
					<button type="submit" name="submit_tindakan" class="btn btn-info bg-purple">Simpan</button>
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

		$(document).on('change','#status',function(){
			var status=$(this).val();
			var kenderaan_pergi=$('select[name="kenderaan_pergi"]');
			var kenderaan_balik=$('select[name="kenderaan_balik"]');
			
			if(status==4 || status==5) {
				//gagal || semak semula
				$("#jenis_pemandu").attr("disabled", true); //disable field
				$("#jenis_pemandub").attr("disabled", true); //disable field
				kenderaan_pergi.prop("disabled", true); //disable field
    			kenderaan_pergi.val('').prop("removed", true).focus(); //empty field
				$('#id_jenis_pergi').val('').prop("removed", true).focus();
				$('#id_model_pergi').val('').prop("removed", true).focus();
				$('#pemandu_pergi').val('').prop("removed", true).focus();
				$('#hp_pemandu_pergi').val('').prop("removed", true).focus();
				kenderaan_balik.prop("disabled", true); //disable field
    			kenderaan_balik.val('').prop("removed", true).focus(); //empty field
				$('#id_jenis_balik').val('').prop("removed", true).focus();
				$('#id_model_balik').val('').prop("removed", true).focus();
				$('#pemandu_balik').val('').prop("removed", true).focus();
				$('#hp_pemandu_balik').val('').prop("removed", true).focus();
			}
			else {
			//lulus  
				$("#jenis_pemandu").attr("disabled", false); //enable field
				$("#jenis_pemandub").attr("disabled", false); //enable field
				$("#kenderaan_pergi").attr("disabled", false); //enable field
			}
		});
	
		$(document).on('change','#kenderaan_pergi',function(){
			var kenderaan_pergi=$(this).val();
			
			$.ajax({
			type:'get',
			url:'{!!URL::to('cariKenderaan')!!}',
			data:{'id_kenderaan':kenderaan_pergi},
			success:function(data){
				//alert(data.jenis_kenderaan);
				//console.log(div);
				$('#id_jenis_pergi').val(data.jenis_kenderaan);
				$('#id_model_pergi').val(data.jenis_model)
				$('#pemandu_pergi').val(data.nama_pemandu);
				$('#hp_pemandu_pergi').val(data.no_tel_bimbit);

			},
			error:function(){
			}
			});
		});

		$(document).on('change','#kenderaan_balik',function(){
			var kenderaan_balik=$(this).val();
			
			$.ajax({
			type:'get',
			url:'{!!URL::to('cariKenderaan')!!}',
			data:{'id_kenderaan':kenderaan_balik},
			success:function(data){
				//alert(data.jenis_kenderaan);
				//console.log(div);
				$('#id_jenis_balik').val(data.jenis_kenderaan);
				$('#id_model_balik').val(data.jenis_model)
				$('#pemandu_balik').val(data.nama_pemandu);
				$('#hp_pemandu_balik').val(data.no_tel_bimbit);
			},
			error:function(){
			}
			});
		});

		$("input[name='jenis_pemandu']").change(function() {
			if($(this).hasClass('other')) {
				//berbeza
					// $("#semak_kenderaan2").attr("disabled", false); //enable button2
					$("#kenderaan_balik").attr("disabled", false); //enable field
					// $("#hp_pemandu_balik").attr("readonly", false); //enable field
					$('#id_jenis_balik').val('').prop("removed", true).focus();
					$('#id_model_balik').val('').prop("removed", true).focus();
					$('#pemandu_balik').val('').prop("removed", true).focus();
					$('#hp_pemandu_balik').val('').prop("removed", true).focus();
				}
				else {
				//sama  
					// $("#semak_kenderaan2").attr("disabled", true); //disable button2
					$("#kenderaan_balik").attr("disabled", true); //disable field
					$("#hp_pemandu_balik").attr("readonly", true); //disable field
					$('#id_jenis_balik').val('').prop("removed", true).focus();
					$('#id_model_balik').val('').prop("removed", true).focus();
					$('#pemandu_balik').val('').prop("removed", true).focus();
					$('#hp_pemandu_balik').val('').prop("removed", true).focus();
				}
		});
		// $('#jenis_pemandu').click(function(){
		// 	//If the checkbox is checked.
		// 	if($(this).is(':checked')){
		// 		//Enable the button.
		// 		$('#kenderaan_balik').attr("readonly", false);
		// 		$('#hp_pemandu_balik').attr("readonly", false);
		// 		$('#semak_kenderaan2').attr("disabled", false);
		// 	} else{
		// 		//If it is not checked, disable the button.
		// 		$('#kenderaan_balik').attr("readonly", true);
		// 		$('#hp_pemandu_balik').attr("readonly", true);
		// 		$('#semak_kenderaan2').attr("disabled", true);
		// 	}
		// });
		
		bsCustomFileInput.init();
	});
	</script>
@endsection

