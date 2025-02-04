@extends('layouts/master')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">TEMPAHAN KENDERAAN</h1>
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
				<div class="card-header bg-purple">
					<h3 class="card-title">Maklumat Pemohon</h3>
				</div>
				<!-- /.card-header -->
				<div class="card-body">
				<form class="form-horizontal" method="POST" action="{{ url('tempahankenderaan/tambah') }}" enctype="multipart/form-data">
				{{ csrf_field() }}
				<!-- <div class="form-group row">
					<label for="nama" class="col-sm-3 col-form-label">Nama Pegawai :</label>
					<div class="col-sm-9">
					<input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Pegawai" value="{{ old('nama') }}" required>
					</div>
				</div> -->
					<!-- <div class="form-group row">
						<label for="pihak" class="col-sm-3 col-form-label">Permohonan Bagi  :</label>
						<div class="input-group col-sm-9">
							<div class="col-sm-3"><input type="radio" id="pihak" name="pihak" value="1" @if(!old('pihak')) checked @endif> &nbsp; Diri Sendiri </div>
							<div class="col-sm-3"><input type="radio" id="pihak" name="pihak" value="2" @if(old('pihak')) checked @endif class="other"> &nbsp; Bagi Pihak </div>
						</div>
					</div> -->
					<div class="form-group row">
						<label for="nama" class="col-sm-2 col-form-label">Nama Pemohon :</label>
						<div class="input-group col-sm-10"> <!-- nti value guna Auth:: user -> nama -->
							<input type="text" class="form-control" id="nama" name="nama" placeholder="{{ $pemohon ? $pemohon->nama : Auth::user()->nama }}" value="{{ $pemohon ? $pemohon->nama :  Auth::user()->nama }}" readonly >
						</div>
					</div>
					
					<!-- <div class="form-group row">
						<label for="pohon_bagi" class="col-sm-3 col-form-label">Nama Pemohon :</label>
						<div class="input-group col-sm-9">
							<input type="text" class="form-control" id="pohon_bagi" name="pohon_bagi" placeholder="Nama Pegawai" value="{{ old('pohon_bagi') }}" readonly="readonly">
							<div class="input-group-append">
								<button type="submit" id="semak_nama2" name="semak_nama2" value="" class="input-group-text" disabled="true"><i class="fa fa-search"></i> </button>
							</div>
						</div>
					</div> -->
					<div class="form-group row">
						<label for="jawatan" class="col-sm-2 col-form-label">Jawatan :</label>
						<div class="col-sm-4"> <!-- nti value guna Auth:: user -> jawatan -->
							<input type="text" class="form-control" id="jawatan" name="jawatan" placeholder="Jawatan" value="{{ $pemohon ? $pemohon->jawatan : Auth::user()->jawatan }}" readonly="readonly">
						</div>
						<label for="gred" class="col-sm-2 col-form-label">Gred :</label>
						<div class="col-sm-4"> <!-- nti value guna Auth:: user -> gred -->
							<input type="text" class="form-control" id="gred" name="gred" placeholder="Gred" value="{{ $pemohon ? $pemohon->gred : Auth::user()->gred }}" readonly="readonly">
						</div>
					</div>
					<input type="hidden" class="form-control" id="mykad" name="mykad" value="{{ $pemohon ? $pemohon->mykad : Auth::user()->mykad }}" readonly="readonly">
					<div class="form-group row">
						<label for="bahagian" class="col-sm-2 col-form-label">Bahagian :</label>
						<div class="col-sm-4"> <!-- nti value guna Auth:: user -> bahagian -->
							<input type="text" class="form-control" id="bahagian" name="bahagian" placeholder="Bahagian" value="{{ $pemohon ? $pemohon->bahagian : Auth::user()->bahagian }}" readonly="readonly">
						</div>
						<label for="emel" class="col-sm-2 col-form-label">E-mel <font color= "red">*</font> :</label>
						<div class="col-sm-4"> <!-- nti value guna Auth:: user -> email -->
							<input type="text" class="form-control" id="emel" name="emel" placeholder="E-mel" value="{{ $pemohon ? $pemohon->emel : Auth::user()->email }}" @if($pemohon) readonly="readonly" @endif>
						</div>
					</div>
					<div class="form-group row">
						<label for="telefon" class="col-sm-2 col-form-label">No. Telefon Pejabat <font color= "red">*</font> :</label>
						<div class="col-sm-4">
							{{-- <input type="text" class="form-control" id="telefon" name="telefon" placeholder="No. Tel Pejabat" value="{{ $pemohon ? $pemohon->telefon : \App\PPersonel::find(Auth::user()->mykad)->tel }}" > --}}
							<input type="text" class="form-control" id="telefon" name="telefon" placeholder="No. Tel Pejabat" value="{{ $pemohon ? $pemohon->telefon : $personel->tel }}">
						</div>
						<label for="tel_bimbit" class="col-sm-2 col-form-label">No. Tel. Bimbit <font color= "red">*</font> :</label>
						<div class="col-sm-4">
							{{-- <input type="text" class="form-control" id="tel_bimbit" name="tel_bimbit" placeholder="No. Tel. Bimbit" value="{{ $pemohon ? $pemohon->tel_bimbit : \App\PPersonel::find(Auth::user()->mykad)->tel_bimbit }}"> --}}
							<input type="text" class="form-control" id="telefon" name="telefon" placeholder="No. Tel Pejabat" value="{{ $pemohon ? $pemohon->telefon : $personel->tel_bimbit }}">
						</div>
					</div>	
				</div>
				<div class="card-header bg-purple">
					<h3 class="card-title">Maklumat Penumpang</h3>
				</div>
			    <div class="card-body">
					<div class="form-group row">
						<label for="bil_penumpang" class="col-sm-2 col-form-label">Bil. Penumpang <small><i>  (Termasuk Pemohon)  </i></small>  <font color= "red">*</font>  :</label>
						<div class="col-sm-4">
							<div class="input-group">
								<input type="number" class="form-control" id="bil_penumpang" name="bil_penumpang" placeholder="Bil. Penumpang" min="1" max="4" value="{{ old('bil_penumpang') }}" >
								<div class="input-group-append">
									<div class="input-group-text">Orang</div>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label for="senarai_penumpang" class="col-sm-9 col-form-label">Senarai Penumpang :<br><small><i> (Masukkan maklumat penumpang <b>termasuk</b> pemohon sekiranya pemohon juga akan menaiki kenderaan.) </i></small> </label>
						<!-- <div class="col-sm-4">
							<a class="btn btn-sm btn-primary  bg-purple" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Tambah Maklumat Penumpang</a>
						</div> -->
					</div>
					<textarea class="form-control" style="display:none;" id="maklumat_penumpang" name="maklumat_penumpang">{{ old('maklumat_penumpang') }}</textarea>
					<table id="example1" class="table table-bordered table-striped table-sm">
						<thead bgcolor ="#D8BFD8">
							<tr>
								<th>Bil.</th>
								<th>Nama</th>
								<th>Gred</th>
								<th>Bahagian</th>
								<th>No. Tel. Bimbit</th>
								<th>Emel</th>
								<th width="10%">&nbsp;</th>
							</tr>
						</thead>
						<tbody id="senMJ">
						</tbody>
						<tfoot>
							<tr>
								<td colspan="6" align="center" ><a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Tambah Maklumat Penumpang</a></td>
							</tr>
						</tfoot>
					</table>
				</div>
				
				<div class="card-header bg-purple">
					<h3 class="card-title">Maklumat Tempahan</h3>
				</div>
			    <div class="card-body">
					<div class="form-group row">
						<label for="jenis_perjalanan" class="col-sm-2 col-form-label">Jenis Perjalanan <font color= "red">*</font> :</label>
						<div class="col-sm-4">
							<select class="form-control select2" id="jenis_perjalanan" name="jenis_perjalanan" style="width: 100%;">
								<option value="" @if(old('jenis_perjalanan')=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
								@foreach ($optJenisPerjalanans as $optJenisPerjalanan)
									<option value="{{ $optJenisPerjalanan->id_jenis_perjalanan }}" @if(old('jenis_perjalanan')==$optJenisPerjalanan->id_jenis_perjalanan) {{ 'selected="selected"' }} @endif>{{ $optJenisPerjalanan->jenis_perjalanan }}</option>
								@endforeach
							</select> 
						</div>
						<label for="id_tujuan" class="col-sm-2 col-form-label">Tujuan <font color= "red">*</font> :</label>
						<div class="col-sm-4">
							<select class="form-control select2" id="id_tujuan" name="id_tujuan" style="width: 100%;">
								<option value="" @if(old('id_tujuan')=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
								@foreach ($optTujuans as $optTujuan)
									<option value="{{ $optTujuan->id_tujuan }}" @if(old('id_tujuan')==$optTujuan->id_tujuan) {{ 'selected="selected"' }} @endif>{{ $optTujuan->tujuan }}</option>
								@endforeach
							</select> 
						</div>
					</div>
					<div class="form-group row">
						<label for="tkh_pergi" class="col-sm-2 col-form-label">Tarikh Pergi <font color= "red">*</font> :</label>
						<div class="col-sm-4">
							<div class="input-group date" id="tkh_pergi" data-target-input="nearest" placeholder="Tarikh Pergi">
							<input type="text" id="tkh_pergi" name="tkh_pergi" class="form-control datetimepicker-input" data-target="#tkh_pergi" value="{{ old('tkh_pergi') }}"/>
							<div class="input-group-append" data-target="#tkh_pergi" data-toggle="datetimepicker">
								<div class="input-group-text"><i class="fa fa-calendar"></i></div>
							</div>
							</div>
						</div>
						<label for="tkh_balik" class="col-sm-2 col-form-label">Tarikh Balik <font color= "red">*</font> :</label>
						<div class="col-sm-4">
							<div class="input-group date" id="tkh_balik" data-target-input="nearest" placeholder="Tarikh Balik">
							<input type="text" id="tkh_balik" name="tkh_balik" class="form-control datetimepicker-input" data-target="#tkh_balik" value="{{ old('tkh_balik') }}" />
							<div class="input-group-append" data-target="#tkh_balik" data-toggle="datetimepicker">
								<div class="input-group-text"><i class="fa fa-calendar"></i></div>
							</div>
							</div>
						</div>
					</div> 
					<div class="form-group row">
						<label for="masa_pergi" class="col-sm-2 col-form-label">Masa Pergi <font color= "red">*</font> :</label>
						<div class="col-sm-4">
							<div class="input-group date" id="masa_pergi" data-target-input="nearest" placeholder="Masa Pergi">
								<input type="time" id="masa_pergi" name="masa_pergi" class="form-control" value="{{ old('masa_pergi') }}" />
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-time"></span>
								</span>
							</div>
						</div>
						<label for="masa_balik" class="col-sm-2 col-form-label">Masa Balik <font color= "red">*</font> :</label>
						<div class="col-sm-4">
							<div class="input-group date" id="masa_balik" data-target-input="nearest" placeholder="Masa Balik">
								<input type="time" id="masa_balik" name="masa_balik" class="form-control" value="{{ old('masa_balik') }}"/>
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-time"></span>
								</span>
							</div>
						</div>
					</div> 
					<div class="form-group row">
						<label for="id_negeri" class="col-sm-2 col-form-label">Negeri <font color= "red">*</font> :</label>
						<div class="col-sm-4">
							<select class="form-control select2" id="id_negeri" name="id_negeri" style="width: 100%;">
								<option value="" @if(old('id_negeri')=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
								@foreach ($optNegeris as $optNegeri)
									<option value="{{ $optNegeri->id_negeri }}" @if(old('id_negeri')==$optNegeri->id_negeri) {{ 'selected="selected"' }} @endif>{{ $optNegeri->negeri }}</option>
								@endforeach
							</select> 
						</div>
						<label for="lokasi_tujuan" class="col-sm-2 col-form-label">Lokasi/Tempat <font color= "red">*</font> :</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="lokasi_tujuan" name="lokasi_tujuan" placeholder="Lokasi/Tempat" value="{{ old('lokasi_tujuan') }}" >
						</div>
						
					</div>
					<div class="form-group row">
						<label for="nama_tujuan" class="col-sm-2 col-form-label">Nama Mesyuarat / Seminar / Bengkel / Kursus / Program :</label>
						<div class="col-sm-10">
							<textarea id="nama_tujuan" name="nama_tujuan" type="text" class="form-control" rows="3" value="{{ old('nama_tujuan') }}" placeholder="Nama Mesyuarat / Seminar / Bengkel / Kursus / Program">{{ old('nama_tujuan') }}</textarea>
          				</div>
					</div>
					<div class="form-group row">
						<label for="lampiran" class="col-sm-2 col-form-label">Lampiran <small><i> (Maksimum saiz 1MB)  </i></small> :</label>
						<div class="col-sm-10">
						<input type="file" class="form-control" id="lampiran" name="lampiran">
						</div>
					</div> 
				</div> 
				
                <!-- /.card-body -->
				
				
                <!-- /.card-body -->
				<div class="card-footer">
					<button type="submit" name="submit_tempahankenderaan" class="btn btn-info bg-purple">Hantar</button>
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

	<div class="modal fade" id="modal-default">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
			<div class="modal-header bg-purple">
				<h4 class="modal-title">TAMBAH PENUMPANG</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form class="form-horizontal" method="POST" action="" enctype="multipart/form-data" id="PenumpangForm">
				{{ csrf_field() }}
				<div class="modal-body">
				
				<div class="form-group row">
					<label for="bahagian_penumpang" class="col-sm-3 col-form-label">Bahagian <font color= "red">*</font> </label>
					<div class="col-sm-9">
						<select class="form-control select2" id="bahagian_penumpang" name="bahagian_penumpang" style="width: 100%;">
							<option value="" @if(old('bahagian_penumpang')=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
							@foreach ($optBahagians as $optBahagian)
							<option value="{{ $optBahagian->id }}" title="{{ $optBahagian->bahagian }}" @if(old('bahagian_penumpang')==$optBahagian->id) {{ 'selected="selected"' }} @endif>{{ $optBahagian->bahagian }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="form-group row">
					<label for="nama_penumpang" class="col-sm-3 col-form-label">Nama <font color= "red">*</font> </label>
					<div class="col-sm-9">
					<!-- <input type="text" class="form-control" id="nama_penumpang" name="nama_penumpang" placeholder="Nama" value="{{ old('nama_penumpang') }}"> -->
						<select class="form-control select2" id="nama_penumpang" name="nama_penumpang" style="width: 100%;">
							<option value="" @if(old('nama_penumpang')=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
							<option value="" selected disabled > -- Sila Pilih -- </option>
						</select>	
					</div>
				</div>
				
				<div class="form-group row">
					<label for="gred_penumpang" class="col-sm-2 col-form-label">Gred <font color= "red">*</font> </label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="gred_penumpang" name="gred_penumpang" placeholder="Gred" value="{{ old('gred_penumpang') }}" required>
					</div>
					<label for="no_tel_penumpang" class="col-sm-2 col-form-label">No. Tel. Bimbit <font color= "red">*</font> </label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="no_tel_penumpang" name="no_tel_penumpang" placeholder="No. Tel" value="{{ old('no_tel_penumpang') }}" required>
					</div>
					<label class="col-sm-6 col-form-label"></label>
					<div class="col-sm-6"></div>
					<label for="emel_penumpang" class="col-sm-2 col-form-label">E-mel <font color= "red">*</font> </label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="emel_penumpang" name="emel_penumpang" placeholder="Emel" value="{{ old('emel_penumpang') }}" required>
					</div>
					<input type="hidden" class="form-control" id="mykad_penumpang" name="mykad_penumpang" value="{{ old('mykad_penumpang') }}">
				</div>
				
				</div>
				<div class="modal-footer justify-content-between">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
				<button type="button" class="btn btn-primary bg-purple" id="tambah_penumpang" onclick="tambahPenumpang()" data-dismiss="modal">Tambah</button>
				</div>
			</form>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
<!-- /.modal -->
    
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

	$(document).ready(function(){

		$(document).on('change','#bahagian_penumpang',function(){
			var bahagian_penumpang=$(this).val();
			var div=$(this).parent().parent().parent();
			var op=" ";
			$.ajax({
			type:'get',
			url:'{!!URL::to('cariPegawai')!!}',
			data:{'id':bahagian_penumpang},
			success:function(data){
				console.log(div);
				op+='<option value="" @if(old('nama_penumpang')=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>';
				for(var i=0;i<data.length;i++){
				op+='<option value="'+data[i].name+'">'+data[i].name+'</option>';
				}
				div.find('#nama_penumpang').html(" ");
				div.find('#nama_penumpang').append(op);
			},
			error:function(){
			}
			});
		});

		$(document).on('change','#nama_penumpang',function(){
			var nama_penumpang=$(this).val();
			
			$.ajax({
			type:'get',
			url:'{!!URL::to('cariDetailPegawai')!!}',
			data:{'name':nama_penumpang},
			success:function(data1){
				//alert(data.jenis_kenderaan);
				//console.log(div);
				$('#no_tel_penumpang').val(data1.tel_bimbit);
				$('#emel_penumpang').val(data1.email);
				$('#gred_penumpang').val(data1.gred);
				$('#mykad_penumpang').val(data1.nokp);
			},
			error:function(){ 
			}
			});
		});

		$("input[name='pihak']").change(function() {

			/* nti guna Auth:: user -> jawatan, gred, bahagian */
			var jawatan = "{{ Auth::user()->jawatan }}" ; 
			var gred ="{{ Auth::user()->gred }}" ; 
			var bahagian = "{{ Auth::user()->bahagian }}" ; 
			var emel =  "{{ Auth::user()->email }}" ; 

			if($(this).hasClass('other')) {
			//bagi_pihak
				// $("#semak_nama").attr("disabled",true); //disable button1
				$("#semak_nama2").attr("disabled", false); //enable button2
				$("#pohon_bagi").attr("readonly", false); //enable field
				$('#jawatan').val('').prop("removed", true).focus();
				$('#gred').val('').prop("removed", true).focus();
				$('#bahagian').val('').prop("removed", true).focus();
				$('#emel').val('').prop("removed", true).focus();
			}
			else {
			//diri
				// $("#semak_nama").attr("disabled", false); //enable button1
				$("#semak_nama2").attr("disabled", true); //disable button2
				$("#pohon_bagi").attr("readonly", true); //disable field
				$('#jawatan').val(jawatan);
				$('#gred').val(gred);
				$('#bahagian').val(bahagian);
				$('#emel').val(emel);
			}
		});

		$(document).on('change','#jenis_perjalanan',function(){
			var tkh_balik = $('input[name="tkh_balik"]');
			var masa_balik = $('input[name="masa_balik"]');

			if (this.value == '1') {
				tkh_balik.prop("readonly", true); //disable field
				masa_balik.prop("readonly", true); //disable field
				tkh_balik.val('').prop("removed", true).focus();
				masa_balik.val('').prop("removed", true).focus();
			} else {
				tkh_balik.prop("readonly", false); //enable field
				masa_balik.prop("readonly", false); //enable field
			}
		});
		
		$(document).on('change','#jenis_perjalanan',function(){
			var tkh_pergi = $('input[name="tkh_pergi"]');
			var masa_pergi = $('input[name="masa_pergi"]');

			if (this.value == '4') {
				tkh_pergi.prop("readonly", true); //disable field
				masa_pergi.prop("readonly", true); //disable field
				tkh_pergi.val('').prop("removed", true).focus();
				masa_pergi.val('').prop("removed", true).focus();
			} else {
				tkh_pergi.prop("readonly", false); //enable field
				masa_pergi.prop("readonly", false); //enable field
			}
			
		});
		
		// $('#pihak1').click(function(){
		// 	//If the checkbox is checked.
		// 	if($(this).is('1')){
		// 		//Enable the submit button.
		// 		$('#semak_nama').attr("disabled", false);
		// 	} else{
		// 		//If it is not checked, disable the button.
		// 		$('#semak_nama').attr("disabled", true);
		// 	}
		// });	
	});

	function tambahPenumpang() {
		var maklumat_penumpang = btoa('x|x'+$('#bahagian_penumpang').select2('data')[0].id+'x|x'+$('#bahagian_penumpang').select2('data')[0].text+
		'x|x'+$('#nama_penumpang').select2('data')[0].id+'x|x'+$('#nama_penumpang').select2('data')[0].text+
		'x|x'+$('#no_tel_penumpang').val()+
		'x|x'+$('#emel_penumpang').val()+        
		'x|x'+$('#gred_penumpang').val()+
		'x|x'+$('#mykad_penumpang').val())+
		'|x|x|';

		$('#maklumat_penumpang').val($('#maklumat_penumpang').val() + maklumat_penumpang);

		updatePenumpang();


		$('#nama_penumpang').val('');
		$('#nama_penumpang').select2().trigger('change');
		$('#bahagian_penumpang').val('');
		$('#bahagian_penumpang').select2().trigger('change');
		$('#no_tel_penumpang').val('');
		$('#emel_penumpang').val('');
        $('#gred_penumpang').val('');
		$('#mykad_penumpang').val('');
	}

	function updatePenumpang() {
		var newSenMJ = '';
		var splitMJ = $('#maklumat_penumpang').val().split('|x|x|');
		for(var mj=0; mj<splitMJ.length - 1; mj++) {
			var bil = mj + 1;
			var mAhli = atob(splitMJ[mj]).split('x|x');
			var idbahagian = mAhli[1];
			var bahagian = mAhli[2];
			var idnama = mAhli[3];
			var nama = mAhli[4];
			var no_tel = mAhli[5];
			var emel = mAhli[6];
            var gred = mAhli[7];
			var mykad = mAhli[8];
			
			newSenMJ = newSenMJ+'<tr><td>'+bil+'</td><td>'+nama+'</td><td>'+gred+'</td><td>'+bahagian+'</td><td>'+no_tel+'</td><td>'+emel+'</td><td><button type="button" class="btn btn-sm btn-danger" id="btnRemovePenumpang'+mj+'" onclick="removePenumpang('+mj+');" title="'+splitMJ[mj]+'"><i class="fa fa-trash"></i></button></td></tr>';
		}
		$('#senMJ').html(newSenMJ);
	}

	function removePenumpang(mj1) {
		var maklumat_penumpang = '';
		var splitMJ = $('#maklumat_penumpang').val().split('|x|x|');
		for(var mj=0; mj<splitMJ.length - 1; mj++) {
			if(mj1 != mj) {
			maklumat_penumpang += splitMJ[mj]+'|x|x|';
			}
		}
		$('#maklumat_penumpang').val(maklumat_penumpang);
		updatePenumpang();
	}

</script>
@endsection

