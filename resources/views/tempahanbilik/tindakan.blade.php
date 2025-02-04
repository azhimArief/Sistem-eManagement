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
              <li class="breadcrumb-item"><a href="{{ url('/homeBilikMeet') }}">Laman Utama</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/tempahanbilik') }}">Tempahan Bilik</a></li>
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
				<form class="form-horizontal" method="POST" action="{{ url('tempahanbilik/tindakan/'.$permohonanBilik->id_permohonan_bilik) }}" enctype="multipart/form-data">
				  {{ csrf_field() }}

                  	<div class="form-group row">
					  <label for="statusTempah" class="col-sm-3 col-form-label">Status Tempahan Bilik  <font color="red">*</font></label>
						<div class="col-sm-4">
							<select class="form-control select2" id="statusTempah" name="statusTempah" style="width: 100%;" required>
								<option value="" @if(old('statusTempah')=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
								@foreach ($optStatuss as $optStatus)
									<option value="{{ $optStatus->id_status }}" @if(old('statusTempah')==$optStatus->id_status) {{ 'selected="selected"' }} @endif>{{ $optStatus->status }}</option>
								@endforeach
							</select> 
						</div>
					</div>

					<div class="form-group row">
						@if ($permohonanBilik->tempah_makan == '1')

							<label for="statusMakan" class="col-sm-3 col-form-label">Tempahan Makanan </label>

							<div class="card-body table-responsive">
								<table id="example1" class="table table-bordered table-sm table-responsive-sm">
									<thead bgcolor ="#D8BFD8">
										<tr>
											@if($tempahMakans->makan_pagi == '1')  <th><center>Makan Pagi</center> </th> 
											@else
											@endif
	
											@if($tempahMakans->makan_tghari == '1')  <th><center>Makan Tengahari</center> </th> 
											@else
											@endif
	
											@if($tempahMakans->minum_petang == '1') <th><center>Minum Petang</center> </th> 
											@else
											@endif
	
											@if($tempahMakans->makan_malam == '1') <th><center>Makan Malam</center> </th> 
											@else
											@endif
										</tr>
									</thead>
									<tbody>
	
										<tr>
	
											@if($tempahMakans->makan_pagi == '1') 
												<td> 
														{{-- Makan Pagi Table --}}
														<div class="container makan_pagi">
															<table id="example1" class="table table-bordered table-sm table-responsive-sm">
	
																<tr>
																	<th>Menu</th>
																	<th>Kalori</th>
																	{{-- <th>&nbsp;</th> --}}
																</tr>
																@foreach ($menuMakans as $menuMakan)
	
																	@if ($menuMakan->jenis_makan == '1')
																		<tr>
																			<td> {{ $menuMakan->menu }}</td>	
																			<td>{{ $menuMakan->kalori }} kkal</td>
																		
																		</tr>														
																	@else
																	@endif
	
																@endforeach
													
	
																<tr>
																	<td colspan="3"><center><b>Jenis Hidangan : {{ ($tempahMakans->id_jenis_hidangan1!='') ? \App\LkpJenisHidangan ::find($tempahMakans->id_jenis_hidangan1)->jenis_hidangan : '' }}</b> </center></td>
																</tr>
	
																{{-- <tr>
																	
																	<td colspan="3"><center><b><a class="btn btn-sm btn-warning float-centre" href="{{ route('tempahanbilik.ubahsuai_makanan', $tempahMakans->id_tempah_makan) }}"><i class=""></i> 
																		Ubahsuai Menu 
																		</a></b> </center>
																	</td>
																</tr> --}}
												
															</table>
														</div>
												</td>
											@else
											@endif
	
											@if($tempahMakans->makan_tghari == '1') 
												<td> 
														{{-- Makan Tengahari Table --}}
														<div class="container makan_tengahari">
															<table id="example1" class="table table-bordered table-sm table-responsive-sm">
	
																<tr>
																	<th>Menu</th>
																	<th>Kalori</th>
																	{{-- <th>&nbsp;</th> --}}
																</tr>
																@foreach ($menuMakans as $menuMakan)
	
																	@if ($menuMakan->jenis_makan == '2')
																		<tr>
																			<td> {{ $menuMakan->menu }}</td>	
																			<td>{{ $menuMakan->kalori }} kkal</td>
																		
																		</tr>														
																	@else
																	@endif
	
																@endforeach
													
	
																<tr>
																	<td colspan="3"><center><b>Jenis Hidangan : {{ ($tempahMakans->id_jenis_hidangan2!='') ? \App\LkpJenisHidangan ::find($tempahMakans->id_jenis_hidangan2)->jenis_hidangan : '' }}</b> </center></td>
																</tr>
	
																{{-- <tr>
																	
																	<td colspan="3"><center><b><a class="btn btn-sm btn-warning float-centre" name="" href="{{ route('tempahanbilik.ubahsuai_makanan', $tempahMakans->id_tempah_makan) }}"><i class=""></i> 
																		Ubahsuai Menu 
																		</a></b> </center>
																	</td>
																</tr> --}}
												
															</table>
														</div>
												</td>
											@else
											@endif
	
	
											@if($tempahMakans->minum_petang == '1') 
												<td> 
														{{-- Makan Petang Table --}}
														<div class="container makan_petang">
															<table id="example1" class="table table-bordered table-sm table-responsive-sm">
	
																<tr>
																	<th>Menu</th>
																	<th>Kalori</th>
																	{{-- <th>&nbsp;</th> --}}
																</tr>
																@foreach ($menuMakans as $menuMakan)
	
																	@if ($menuMakan->jenis_makan == '3')
																		<tr>
																			<td> {{ $menuMakan->menu }}</td>	
																			<td>{{ $menuMakan->kalori }} kkal</td>
																		
																		</tr>														
																	@else
																	@endif
	
																@endforeach
													
	
																<tr>
																	<td colspan="3"><center><b>Jenis Hidangan : {{ ($tempahMakans->id_jenis_hidangan3!='') ? \App\LkpJenisHidangan ::find($tempahMakans->id_jenis_hidangan3)->jenis_hidangan : '' }}</b> </center></td>
																</tr>
	
																{{-- <tr>
																	
																	<td colspan="3"><center><b><a class="btn btn-sm btn-warning float-centre" name="" href="{{ route('tempahanbilik.ubahsuai_makanan', $tempahMakans->id_tempah_makan) }}"><i class=""></i> 
																		Ubahsuai Menu 
																		</a></b> </center>
																	</td>
																</tr> --}}
												
															</table>
														</div>
												</td>
											@else
											@endif
							
	
											@if($tempahMakans->makan_malam == '1') 
												<td> 
														{{-- Makan Malam Table --}}
														<div class="container makan_malam">
															<table id="example1" class="table table-bordered table-sm table-responsive-sm">
	
																<tr>
																	<th>Menu</th>
																	<th>Kalori</th>
																	{{-- <th>&nbsp;</th> --}}
																</tr>
																@foreach ($menuMakans as $menuMakan)
	
																	@if ($menuMakan->jenis_makan == '4')
																		<tr>
																			<td> {{ $menuMakan->menu }}</td>	
																			<td>{{ $menuMakan->kalori }} kkal</td>
																		
																		</tr>														
																	@else
																	@endif
	
																@endforeach
													
	
																<tr>
																	<td colspan="3"><center><b>Jenis Hidangan : {{ ($tempahMakans->id_jenis_hidangan4!='') ? \App\LkpJenisHidangan ::find($tempahMakans->id_jenis_hidangan4)->jenis_hidangan : '' }}</b> </center></td>
																</tr>
	
																{{-- <tr>
																	
																	<td colspan="3"><center><b><a class="btn btn-sm btn-warning float-centre" name="" href="{{ route('tempahanbilik.ubahsuai_makanan', $tempahMakans->id_tempah_makan) }}"><i class=""></i> 
																		Ubahsuai Menu 
																		</a></b> </center>
																	</td>
																</tr> --}}
												
															</table>
														</div>
												</td>
											@else
											@endif
	
											
										</tr>
										<tr>
																	
											<td colspan="4"><center><b><a class="btn btn-sm btn-warning float-centre" name="" href="{{ route('tempahanbilik.ubahsuai_makanan', $tempahMakans->id_tempah_makan) }}"><i class=""></i> 
												Ubahsuai Menu 
												</a></b> </center>
											</td>
										</tr>
	
									</tbody>
	
								</table>
							</div>

						@else
						@endif
						
						 
					</div>

					@if ($permohonanBilik->tempah_makan == 1)
						<div class="form-group row">
							<label for="statusMakan" class="col-sm-3 col-form-label">Status Tempahan Makanan  <font color="red">*</font></label>
							<div class="col-sm-4">
								<select class="form-control select2" id="statusMakan" name="statusMakan" style="width: 100%;" required>
									<option value="" @if(old('statusMakan')=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
									@foreach ($optStatuss as $optStatus)
										<option value="{{ $optStatus->id_status }}" @if(old('statusMakan')==$optStatus->id_status) {{ 'selected="selected"' }} @endif>{{ $optStatus->status }}</option>
									@endforeach
								</select> 
							</div>
						</div>

						<div class="form-group row">
							<label for="pembekal" class="col-sm-3 col-form-label">Pembekal/Katering </label>
							<div class="col-sm-4">
								<select class="form-control select2" id="pembekal" name="pembekal" style="width: 100%;">
									<option value="" @if(old('pembekal')=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
									@foreach ($katerers as $katerer)
										<option value="{{ $katerer->id_katerer }}" @if(old('pembekal')==$katerer->id_katerer) {{ 'selected="selected"' }} @endif>{{ $katerer->nama_katerer }}</option>
									@endforeach
								</select>
							</div>
						</div>

						<div class="form-group row">
							<label for="harga" class="col-sm-3 col-form-label">Harga Makanan (RM)</label>
							<div class="col-sm-4">
								<input type="text" name="harga" id="harga" class="form-control" placeholder="cth: 50.70">
							</div>
						</div>
						
					@else
					@endif
					

					

					

					<div class="form-group row">
						<label for="catatan" class="col-sm-3 col-form-label">Catatan </label>
						<div class="col-sm-4">
							<textarea id="catatan" name="catatan" type="text" class="form-control" rows="3" placeholder="Catatan"></textarea>
          				</div>
					</div>

				</div>		  
				
			  
                <!-- /.card-body -->
				<div class="card-footer">
					<button type="submit" name="submit_tindakan" class="btn btn-info bg-purple">Simpan</button>
					<a href="{{ url('tempahanbilik/butiran/'.$permohonanBilik->id_permohonan_bilik) }}" class="tn btn-default float-right">Kembali</a>
					{{-- <button type="button" class="btn btn-default float-right" onclick="history.back();">Kembali</button> --}}
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


	    <!-- MODAL UBAH MENU MAKAN  -->
		<div class="modal fade" id="modal-makan">
			<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-purple">
				<h5 class="modal-title">Tapis Kalendar</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				</div>
				{{-- <form class="form-horizontal" method="POST" action="{{ route('pemohon.tambah_tempahanbilik', $result->nokp) }}" enctype="multipart/form-data"> --}}
				<form class="form-horizontal" method="POST" action="" enctype="multipart/form-data">
				{{ csrf_field() }}
				<div class="modal-body">

					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<label class="input-group-text" for="inputGroupSelect01">Aras</label>
						</div>
						
					</div>

					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<label class="input-group-text" for="inputGroupSelect01">Bilik</label>
						</div>
							
					</div>

				</div>

				<div class="modal-footer justify-content-between">
					<span class="float-right">
					<button type="submit" class="btn btn-primary bg-purple" name="tapis">Tapis</button>
					</span>
				</div>

				</form>
			</div> <!-- /.modal-content -->
			</div> <!-- /.modal-dialog -->
		</div>

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

