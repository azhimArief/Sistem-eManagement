@extends('layouts/master')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">KEMASKINI TINDAKAN</h1>
          </div><!-- /.col -->
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/home') }}">Laman Utama</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/tempahankenderaan') }}">Tempahan Kenderaan</a></li>
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
            <!-- Horizontal Form -->
            <div class="card card-info">
              
              <div class="card-header bg-purple">
                <h3 class="card-title">Tindakan Seksyen Pentadbiran</h3>
              </div>
                <!-- /.card-header -->
                
                <div class="card-body">
                  <!-- form start -->
              <form class="form-horizontal" method="POST" action="{{ url('tempahankenderaan/kemaskini_tindakan/'.$permohonanKenderaan->id_maklumat_permohonan) }}" enctype="multipart/form-data">
			  {{ csrf_field() }}
                  <div class="form-group row">
                    <label for="no_plat" class="col-sm-2 col-form-label">Status </label>
                    <div class="col-sm-4">
                      <select class="form-control select2" id="status" name="status" style="width: 100%;">
                        {{ old('status') == NULL ? $status1=$tindakan->id_status_tempah : $status1=old('status') }}
                        <option value="" @if($status1=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
                        @foreach ($optStatuss as $optionStatus)
                          <option value="{{ $optionStatus->id_status }}" @if($status1==$optionStatus->id_status) {{ 'selected="selected"' }} @endif>{{ $optionStatus->status }}</option>
                        @endforeach
                      </select> 
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="catatan" class="col-sm-2 col-form-label">Catatan</label>
                    <div class="col-sm-4">
                      <textarea id="catatan" name="catatan" type="text" class="form-control{{ $errors->has('catatan') ? ' is-invalid' : '' }}" rows="3">{{ $tindakan->catatan }}</textarea>
                    </div>
                  </div>
                </div>
                <div class="card-header bg-purple">
                  <h3 class="card-title">Maklumat Kenderaan</h3>
                </div>
                
                <div class="card-body">
                @if($permohonanKenderaan->id_jenis_perjalanan == 1 || $permohonanKenderaan->id_jenis_perjalanan == 4)
                <p style="color:red">* Sila Semak Jadual Pemandu <a href="{{ url('/jadual')}}" target="_blank" style="color:red"><b>DI SINI</b></a>.</p>
                  <div class="form-group row">
                    <label for="kenderaan_pergi" class="col-sm-2 col-form-label">No kenderaan</label>
                    <div class="col-sm-4">
                      <select class="form-control select2" id="kenderaan_pergi" name="kenderaan_pergi" style="width: 100%;">
                        {{ old('kenderaan_pergi') == NULL ? $kenderaan_pergi1=$tindakan->kenderaan_pergi : $kenderaan_pergi1=old('kenderaan_pergi') }}
                        <option value="" @if($kenderaan_pergi1=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
                        @foreach ($kenderaans as $kenderaan)
                          <option value="{{ $kenderaan->id_kenderaan }}" @if($kenderaan_pergi1==$kenderaan->id_kenderaan) {{ 'selected="selected"' }} @endif>{{ $kenderaan->no_plat }}</option>
                        @endforeach
                      </select> 
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="id_jenis_pergi" class="col-sm-2 col-form-label">Jenis Kenderaan</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" id="id_jenis_pergi" name="id_jenis_pergi" placeholder="Jenis Kenderaan" value="{{ $tindakan->kenderaan_pergi !== NULL ? $kenderaanPergi->jenis_kenderaan : old('id_jenis_pergi') }}" readonly="readonly">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="id_model_pergi" class="col-sm-2 col-form-label">Model Kenderaan</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" id="id_model_pergi" name="id_model_pergi" placeholder="Model Kenderaan" value="{{ $tindakan->kenderaan_pergi !== NULL ? $kenderaanPergi->jenis_model : old('id_model_pergi') }}" readonly="readonly">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="pemandu_pergi" class="col-sm-2 col-form-label">Pemandu</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" id="pemandu_pergi" name="pemandu_pergi" placeholder="Nama Pemandu" value="{{ $tindakan->kenderaan_pergi !== NULL ? $kenderaanPergi->nama_pemandu : old('pemandu_pergi') }}" readonly="readonly">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="hp_pemandu_pergi" class="col-sm-2 col-form-label">No Tel Bimbit Pemandu</label>
                    <div class="col-sm-4">
                    <input type="text" class="form-control" id="hp_pemandu_pergi" name="hp_pemandu_pergi" placeholder="No Tel Bimbit Pemandu" value="{{ $tindakan->kenderaan_pergi !== NULL ? $kenderaanPergi->no_tel_bimbit : old('hp_pemandu_pergi') }}">
                    </div>
                  </div>
                
                @else
                  <div class="form-group row">
            
                    <label for="jenis_pemandu" class="col-sm-2 col-form-label">Pemandu/Kenderaan  </label> 
                    <div class="input-group col-sm-8">
                      <div class="col-sm-3"><input type="radio" id="jenis_pemandu" name="jenis_pemandu" value="1" {{ $tindakan->kenderaan_balik == $tindakan->kenderaan_balik ? 'checked' : '' }}> &nbsp; Sama </div>
                      <div class="col-sm-3"><input type="radio" id="jenis_pemandu" name="jenis_pemandu" value="2" {{ $tindakan->kenderaan_balik !== $tindakan->kenderaan_balik ? 'checked' : '' }} class="other"> &nbsp; Berbeza </div>
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
                              <label for="kenderaan_pergi" class="col-sm-4 col-form-label">No kenderaan</label>
                              <div class="col-sm-8">
                                <select class="form-control select2" id="kenderaan_pergi" name="kenderaan_pergi" style="width: 100%;">
                                  {{ old('kenderaan_pergi') == NULL ? $kenderaan_pergi1=$tindakan->kenderaan_pergi : $kenderaan_pergi1=old('kenderaan_pergi') }}
                                  <option value="" @if($kenderaan_pergi1=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
                                  @foreach ($kenderaans as $kenderaan)
                                    <option value="{{ $kenderaan->id_kenderaan }}" @if($kenderaan_pergi1==$kenderaan->id_kenderaan) {{ 'selected="selected"' }} @endif>{{ $kenderaan->no_plat }}</option>
                                  @endforeach
                                </select> 
                              </div>
                            </div>
                            <div class="form-group row">
                              <label for="id_jenis_pergi" class="col-sm-4 col-form-label">Jenis Kenderaan</label>
                              <div class="col-sm-8">
                              <input type="text" class="form-control" id="id_jenis_pergi" name="id_jenis_pergi" placeholder="Jenis Kenderaan" value="{{ $tindakan->kenderaan_pergi !== NULL ? $kenderaanPergi->jenis_kenderaan : old('id_jenis_pergi') }}" readonly="readonly">
                              </div>
                            </div>
                            <div class="form-group row">
                              <label for="id_model_pergi" class="col-sm-4 col-form-label">Model Kenderaan</label>
                              <div class="col-sm-8">
                                <input type="text" class="form-control" id="id_model_pergi" name="id_model_pergi" placeholder="Model Kenderaan" value="{{ $tindakan->kenderaan_pergi !== NULL ? $kenderaanPergi->jenis_model : old('id_model_pergi') }}" readonly="readonly">
                              </div>
                            </div>
                            <div class="form-group row">
                              <label for="pemandu_pergi" class="col-sm-4 col-form-label">Pemandu</label>
                              <div class="col-sm-8">
                                <input type="text" class="form-control" id="pemandu_pergi" name="pemandu_pergi" placeholder="Nama Pemandu" value="{{ $tindakan->kenderaan_pergi !== NULL ? $kenderaanPergi->nama_pemandu : old('pemandu_pergi') }}" readonly="readonly">
                              </div>
                            </div>
                            <div class="form-group row">
                              <label for="hp_pemandu_pergi" class="col-sm-4 col-form-label">No Tel Bimbit Pemandu</label>
                              <div class="col-sm-8">
                              <input type="text" class="form-control" id="hp_pemandu_pergi" name="hp_pemandu_pergi" placeholder="No Tel Bimbit Pemandu" value="{{ $tindakan->kenderaan_pergi !== NULL ? $kenderaanPergi->no_tel_bimbit : old('hp_pemandu_pergi') }}" readonly="readonly">
                              </div>
                            </div>
                          </div>
                        </div><!-- /.card -->
                      </div>
                      <div class="col-md-6">
                        <div class="card card-light">
                          <div class="card-header" style="background-color : #E6E6FA">						
                            <h3 class="card-title"><strong>Kenderaan Balik</strong></h3>
                          </div>
                          <div class="card-body">
                          <div class="form-group row">
                              <label for="kenderaan_balik" class="col-sm-4 col-form-label">No kenderaan</label>
                              <div class="col-sm-8">
                                <select class="form-control select2" id="kenderaan_balik" name="kenderaan_balik" style="width: 100%;">
                                  {{ old('kenderaan_balik') == NULL ? $kenderaan_balik1=$tindakan->kenderaan_balik : $kenderaan_balik1=old('kenderaan_balik') }}
                                  <option value="" @if($kenderaan_balik1=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
                                  @foreach ($kenderaans as $kenderaan)
                                    <option value="{{ $kenderaan->id_kenderaan }}" @if($kenderaan_balik1==$kenderaan->id_kenderaan) {{ 'selected="selected"' }} @endif>{{ $kenderaan->no_plat }}</option>
                                  @endforeach
                                </select> 
                              </div>
                            </div>
                            <div class="form-group row">
                              <label for="id_jenis_balik" class="col-sm-4 col-form-label">Jenis Kenderaan</label>
                              <div class="col-sm-8">
                                <input type="text" class="form-control" id="id_jenis_balik" name="id_jenis_balik" placeholder="Jenis Kenderaan" value="{{ $tindakan->kenderaan_balik !== NULL ? $kenderaanBalik->jenis_kenderaan : old('id_jenis_balik') }}" readonly="readonly">
                              </div>
                            </div>
                            <div class="form-group row">
                              <label for="id_model_balik" class="col-sm-4 col-form-label">Model Kenderaan</label>
                              <div class="col-sm-8">
                                <input type="text" class="form-control" id="id_model_balik" name="id_model_balik" placeholder="Model Kenderaan" value="{{ $tindakan->kenderaan_balik !== NULL ? $kenderaanBalik->jenis_model : old('id_model_balik') }}" readonly="readonly">
                              </div>
                            </div>
                            <div class="form-group row">
                              <label for="pemandu_balik" class="col-sm-4 col-form-label">Pemandu</label>
                              <div class="col-sm-8">
                                <input type="text" class="form-control" id="pemandu_balik" name="pemandu_balik" placeholder="Nama Pemandu" value="{{ $tindakan->kenderaan_balik !== NULL ? $kenderaanBalik->nama_pemandu : old('pemandu_balik') }}" readonly="readonly">
                              </div>
                            </div>
                            <div class="form-group row">
                              <label for="hp_pemandu_balik" class="col-sm-4 col-form-label">No Tel Bimbit Pemandu</label>
                              <div class="col-sm-8">
                              <input type="text" class="form-control" id="hp_pemandu_balik" name="hp_pemandu_balik" placeholder="No Tel Bimbit Pemandu" value="{{ $tindakan->kenderaan_balik !== NULL ? $kenderaanBalik->no_tel_bimbit : old('hp_pemandu_balik') }}" readonly="readonly">
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
                  <button type="submit" name="submit_kemaskini_tindakan" class="btn btn-info bg-purple">Simpan</button>
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

    //
		$("input[name='jenis_pemandu']").change(function() {
			if($(this).hasClass('other')) {
				//berbeza
					// $("#semak_kenderaan2").attr("disabled", false); //enable button2
					$("#kenderaan_balik").attr("disabled", false); //enable field
					$("#hp_pemandu_balik").attr("readonly", false); //enable field
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

	});

	</script>
@endsection



