@extends('layouts/master')
@section('content')

<!-- Content Header (Page header) --> 
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">KEMASKINI MENU MAKAN</h1>
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
                <h3 class="card-title">Ubahsuai Menu Makan</h3>
              </div>
              <!-- /.card-header -->
                <div class="card-body">
				{{-- <form class="form-horizontal" method="POST" action="{{ url('tempahanbilik/tindakan/simpan_ubah_makan'.$permohonanBilik->id_permohonan_bilik) }}" enctype="multipart/form-data"> --}}
				  {{ csrf_field() }}

				  <div class="form-group row">
					<div class="card-body table-responsive">
						<table id="example1" class="table table-bordered table-sm table-responsive-sm">
							<thead bgcolor="#D8BFD8">
								<tr>
									@if($tempahMakans->makan_pagi == '1') <th>
										<center>Makan Pagi</center>
									</th>
									@else
									@endif
				
									@if($tempahMakans->makan_tghari == '1') <th>
										<center>Makan Tengahari</center>
									</th>
									@else
									@endif
				
									@if($tempahMakans->minum_petang == '1') <th>
										<center>Minum Petang</center>
									</th>
									@else
									@endif

									@if($tempahMakans->makan_malam == '1') <th>
										<center>Makan Malam</center>
									</th>
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
													<!-- MODAL UBAH MENU MAKAN  -->
													<div class="modal fade" id="modal-makan-{{  $menuMakan->id_menu_makan }}">
														<div class="modal-dialog">
															<div class="modal-content">
																<div class="modal-header bg-purple">
																<h5 class="modal-title">Ubah Menu Makanan</h5>
																<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																	<span aria-hidden="true">&times;</span>
																</button>
																</div>
																{{-- <form class="form-horizontal" method="POST" action="{{ route('pemohon.tambah_tempahanbilik', $result->nokp) }}" enctype="multipart/form-data"> --}}
																<form class="form-horizontal" method="POST" action="{{ url('tempahanbilik/tindakan/simpan/ubahsuai_makanan/'.$menuMakan->id_menu_makan) }}" 
																	enctype="multipart/form-data">
																{{ csrf_field() }}
																<div class="modal-body">
																	
																	<div class="input-group mb-3">
																		<label class="input-group-text" for="inputGroupSelect01">Menu</label>
																		<div class="col-sm-6">
																			<input type="text" name="menu_baru" id="menu_baru" class="form-control"
																				value="{{ $menuMakan->menu }}" required>
																		</div>
																	</div>

																	<div class="input-group mb-3">
																		<label class="input-group-text" for="inputGroupSelect01">Kalori</label>
																		<div class="col-sm-6">
																			<input type="text" name="kalori_baru" id="kalori_baru" class="form-control"
																				value="{{ $menuMakan->kalori }}" required>
																		</div>
																	</div>

																</div>

																<div class="modal-footer justify-content-between">
																	<span class="float-right">
																	<button type="submit" class="btn btn-primary bg-purple" name="ubah_simpan">Simpan</button>
																	</span>
																</div>

																</form>
															</div> <!-- /.modal-content -->
														</div> <!-- /.modal-dialog -->
													</div>
												
													@if ($menuMakan->jenis_makan == '1')
														<tr>
															<td> {{ $menuMakan->menu }}</td>
															<td>{{ $menuMakan->kalori }} kkal</td>
															<td>
																<center>
																	<a class="btn btn-sm btn-secondary float-centre" data-toggle="modal" data-target="#modal-makan-{{ $menuMakan->id_menu_makan }}"><i class=""></i>
																		Ubah
																	</a>
																</center>
															</td>
														</tr>
													@else
													@endif


												@endforeach
				
											</table>
											{{-- <dt class="col-sm-5">Jumlah Kalori :  {{ $tempahMakans->kalori_pagi }} kkal</dt> --}}
											
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
												</tr>
												
												@foreach ($menuMakans as $menuMakan)
													<!-- MODAL UBAH MENU MAKAN  -->
													<div class="modal fade" id="modal-makan-{{  $menuMakan->id_menu_makan }}">
														<div class="modal-dialog">
															<div class="modal-content">
																<div class="modal-header bg-purple">
																<h5 class="modal-title">Ubah Menu Makanan</h5>
																<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																	<span aria-hidden="true">&times;</span>
																</button>
																</div>
																{{-- <form class="form-horizontal" method="POST" action="{{ route('pemohon.tambah_tempahanbilik', $result->nokp) }}" enctype="multipart/form-data"> --}}
																<form class="form-horizontal" method="POST" action="{{ url('tempahanbilik/tindakan/simpan/ubahsuai_makanan/'.$menuMakan->id_menu_makan) }}" 
																	enctype="multipart/form-data">
																{{ csrf_field() }}
																<div class="modal-body">
																	
																	<div class="input-group mb-3">
																		<label class="input-group-text" for="inputGroupSelect01">Menu</label>
																		<div class="col-sm-6">
																			<input type="text" name="menu_baru" id="menu_baru" class="form-control"
																				value="{{ $menuMakan->menu }}" required>
																		</div>
																	</div>

																	<div class="input-group mb-3">
																		<label class="input-group-text" for="inputGroupSelect01">Kalori</label>
																		<div class="col-sm-6">
																			<input type="text" name="kalori_baru" id="kalori_baru" class="form-control"
																				value="{{ $menuMakan->kalori }}" required>
																		</div>
																	</div>

																</div>

																<div class="modal-footer justify-content-between">
																	<span class="float-right">
																	<button type="submit" class="btn btn-primary bg-purple" name="ubah_simpan">Simpan</button>
																	</span>
																</div>

																</form>
															</div> <!-- /.modal-content -->
														</div> <!-- /.modal-dialog -->
													</div>
												
													@if ($menuMakan->jenis_makan == '2')
													<tr>
														<td>{{ $menuMakan->menu }}</td>
														<td>{{ $menuMakan->kalori }} kkal</td>
														<td>
															<center>
																<a class="btn btn-sm btn-secondary float-centre" data-toggle="modal" data-target="#modal-makan-{{ $menuMakan->id_menu_makan }}"><i class=""></i>
																	Ubah
																</a>
															</center>
														</td>
													</tr>
													
													@else
													@endif
												@endforeach


		
											</table>
										</div>
									</td>
									@else
									@endif
				
									@if($tempahMakans->minum_petang == '1')
										<td>
											{{-- Minum Petang Table --}}
											<div class="container minum_petang">
												<table id="example1" class="table table-bordered table-sm table-responsive-sm">
													<tr>
														<th>Menu</th>
														<th>Kalori</th>
														<th></th>
													</tr>
													{{-- Initial value total kalori --}}
													
													@foreach ($menuMakans as $menuMakan)
														<!-- MODAL UBAH MENU MAKAN  -->
														<div class="modal fade" id="modal-makan-{{  $menuMakan->id_menu_makan }}">
															<div class="modal-dialog">
																<div class="modal-content">
																	<div class="modal-header bg-purple">
																	<h5 class="modal-title">Ubah Menu Makanan</h5>
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																		<span aria-hidden="true">&times;</span>
																	</button>
																	</div>
																	{{-- <form class="form-horizontal" method="POST" action="{{ route('pemohon.tambah_tempahanbilik', $result->nokp) }}" enctype="multipart/form-data"> --}}
																	<form class="form-horizontal" method="POST" action="{{ url('tempahanbilik/tindakan/simpan/ubahsuai_makanan/'.$menuMakan->id_menu_makan) }}" 
																		enctype="multipart/form-data">
																	{{ csrf_field() }}
																	<div class="modal-body">
																		
																		<div class="input-group mb-3">
																			<label class="input-group-text" for="inputGroupSelect01">Menu</label>
																			<div class="col-sm-6">
																				<input type="text" name="menu_baru" id="menu_baru" class="form-control"
																					value="{{ $menuMakan->menu }}" required>
																			</div>
																		</div>

																		<div class="input-group mb-3">
																			<label class="input-group-text" for="inputGroupSelect01">Kalori</label>
																			<div class="col-sm-6">
																				<input type="text" name="kalori_baru" id="kalori_baru" class="form-control"
																					value="{{ $menuMakan->kalori }}" required>
																			</div>
																		</div>

																	</div>

																	<div class="modal-footer justify-content-between">
																		<span class="float-right">
																		<button type="submit" class="btn btn-primary bg-purple" name="ubah_simpan">Simpan</button>
																		</span>
																	</div>

																	</form>
																</div> <!-- /.modal-content -->
															</div> <!-- /.modal-dialog -->
														</div>

													@if ($menuMakan->jenis_makan == '3')
													<tr>
														<td>{{ $menuMakan->menu }}</td>
														<td>{{ $menuMakan->kalori }} kkal</td>
														<td>
															<center>
																<a class="btn btn-sm btn-secondary float-centre" data-toggle="modal" data-target="#modal-makan-{{ $menuMakan->id_menu_makan }}"><i class=""></i>
																	Ubah
																</a>
															</center>
														</td>
													</tr>
													{{-- Kire total kalori --}}
													
													@else
													@endif
													@endforeach
													
												</table>
												{{-- <dt class="col-sm-5">Jumlah Kalori : {{ $tempahMakans->kalori_petang }} kkal</dt> --}}
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
														<th></th>
													</tr>
													{{-- Initial value total kalori --}}
													
													@foreach ($menuMakans as $menuMakan)
														<!-- MODAL UBAH MENU MAKAN  -->
														<div class="modal fade" id="modal-makan-{{  $menuMakan->id_menu_makan }}">
															<div class="modal-dialog">
																<div class="modal-content">
																	<div class="modal-header bg-purple">
																	<h5 class="modal-title">Ubah Menu Makanan</h5>
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																		<span aria-hidden="true">&times;</span>
																	</button>
																	</div>
																	{{-- <form class="form-horizontal" method="POST" action="{{ route('pemohon.tambah_tempahanbilik', $result->nokp) }}" enctype="multipart/form-data"> --}}
																	<form class="form-horizontal" method="POST" action="{{ url('tempahanbilik/tindakan/simpan/ubahsuai_makanan/'.$menuMakan->id_menu_makan) }}" 
																		enctype="multipart/form-data">
																	{{ csrf_field() }}
																	<div class="modal-body">
																		
																		<div class="input-group mb-3">
																			<label class="input-group-text" for="inputGroupSelect01">Menu</label>
																			<div class="col-sm-6">
																				<input type="text" name="menu_baru" id="menu_baru" class="form-control"
																					value="{{ $menuMakan->menu }}" required>
																			</div>
																		</div>

																		<div class="input-group mb-3">
																			<label class="input-group-text" for="inputGroupSelect01">Kalori</label>
																			<div class="col-sm-6">
																				<input type="text" name="kalori_baru" id="kalori_baru" class="form-control"
																					value="{{ $menuMakan->kalori }}" required>
																			</div>
																		</div>

																	</div>

																	<div class="modal-footer justify-content-between">
																		<span class="float-right">
																		<button type="submit" class="btn btn-primary bg-purple" name="ubah_simpan">Simpan</button>
																		</span>
																	</div>

																	</form>
																</div> <!-- /.modal-content -->
															</div> <!-- /.modal-dialog -->
														</div>

														@if ($menuMakan->jenis_makan == '4')
															<tr>
																<td>{{ $menuMakan->menu }}</td>
																<td>{{ $menuMakan->kalori }} kkal</td>
																<td>
																	<center>
																		<a class="btn btn-sm btn-secondary float-centre" data-toggle="modal" data-target="#modal-makan-{{ $menuMakan->id_menu_makan }}"><i class=""></i>
																			Ubah
																		</a>
																	</center>
																</td>
															</tr>
														{{-- Kire total kalori --}}
														
														@else
														@endif
													@endforeach
													
												</table>
											</div>
										</td>
									@else
									@endif

								</tr>
							</tbody>
						</table>
					</div>
				</div>
					
				</div>	
				
			  
                <!-- /.card-body -->
				<div class="card-footer">
					{{-- <button type="submit" name="submit_tindakan" class="btn btn-info bg-purple">Selesai</button> --}}
					<a href="{{ url('tempahanbilik/tindakan/'.$tempahMakans->id_permohonan_bilik) }}" name="selesai" class="btn btn-sm btn-primary float-centre">Selesai</a>
					{{-- <button type="button" class="btn btn-default float-right" onclick="history.back();">Kembali</button> --}}
					<a href="{{ url('tempahanbilik/tindakan/'.$tempahMakans->id_permohonan_bilik) }}" class="tn btn-default float-right">Kembali</a>
				</div>
				<!-- /.card-footer -->
              {{-- </form> --}}
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

