@extends('layouts/master')
@section('content')

<!-- Content Header (Page header) --> 
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">KEMASKINI TINDAKAN </h1>
          </div><!-- /.col -->
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/homeBilikMeet') }}">Laman Utama</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/tempahanbilik') }}">Tempahan Bilik</a></li>
              <li class="breadcrumb-item active">Kemaskini Tindakan</li>
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
				<form class="form-horizontal" method="POST" action="{{ url('tempahanbilik/kemaskini_tindakan/'.$tindakan->id_tindakan) }}" enctype="multipart/form-data">
				  {{ csrf_field() }}

          			<div class="form-group row">
					  <label for="statusTempah" class="col-sm-3 col-form-label">Status Tempahan Bilik</label>
						<div class="col-sm-4">
							<select class="form-control select2" id="statusTempah" name="statusTempah" style="width: 100%;" required>
								@php old('statusTempah') == NULL ? $statusTempah1 = $tindakan->id_status_tempah : $statusTempah1 = old('statusTempah') @endphp
								<option value="" @if ($statusTempah1 == '') {{ 'selected="selected"' }} @endif>&nbsp;</option>
									@foreach ($optStatuss as $optStatus)
									<option value="{{ $optStatus->id_status }}"
										@if ($statusTempah1 == $optStatus->id_status) {{ 'selected="selected"' }} @endif>
										{{ $optStatus->status }}
									</option>
									@endforeach
							</select>
						</div>
					</div>

					<div class="form-group row">
						<label for="statusMakan" class="col-sm-3 col-form-label">Status Tempahan Makanan</label>
						  <div class="col-sm-4">
							  <select class="form-control select2" id="statusMakan" name="statusMakan" style="width: 100%;" required> 
								@php old('statusMakan') == NULL ? $statusTempah1 = $tindakan->id_status_makan : $statusTempah1 = old('statusMakan') @endphp
								<option value="" @if ($statusTempah1 == '') {{ 'selected="selected"' }} @endif>&nbsp;</option>
									@foreach ($optStatuss as $optStatus)
									<option value="{{ $optStatus->id_status }}"
										@if ($statusTempah1 == $optStatus->id_status) {{ 'selected="selected"' }} @endif>
										{{ $optStatus->status }}
									</option>
									@endforeach
							  </select> 
						  </div>
					</div>

					<div class="form-group row">
						<label for="pembekal" class="col-sm-3 col-form-label">Pembekal </label>
						<div class="col-sm-4">
							<select class="form-control select2" id="pembekal" name="pembekal" style="width: 100%;" required> 
								@php old('pembekal') == NULL ? $pembekal1 = $tempahMakans->pembekal : $pembekal1 = old('pembekal') @endphp
								<option value="" @if ($pembekal1 == '') {{ 'selected="selected"' }} @endif>&nbsp;</option>
									@foreach ($katerers as $katerer)
									<option value="{{ $katerer->id_katerer }}"
										@if ($pembekal1 == $katerer->id_katerer) {{ 'selected="selected"' }} @endif>
										{{ $katerer->nama_katerer }}
									</option>
									@endforeach
							</select> 
          				</div>
					</div>

					<div class="form-group row">
						<label for="harga" class="col-sm-3 col-form-label">Harga Makanan (RM)</label>
						<div class="col-sm-4">
							<input type="text" name="harga" id="harga" class="form-control" value="{{ $tempahMakans->kadar_harga  }}" required>
          	</div>
					</div>

					<div class="form-group row">
						<label for="catatan" class="col-sm-3 col-form-label">Catatan </label>
						<div class="col-sm-4">
							<textarea id="catatan" name="catatan" type="text" class="form-control" rows="3" placeholder="">{{ $tindakan->catatan  }}</textarea>
          				</div>
					</div>

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

