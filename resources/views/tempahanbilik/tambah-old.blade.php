@extends('layouts/master')
@section('content')
<style>
	#yaMakanan, #tempahMakan, #notisNoMakanan {
		display: none;
	}
</style>

<!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">TEMPAHAN BILIK</h1>
          </div><!-- /.col -->
          
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/home') }}">Laman Utama</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/tempahankenderaan') }}">Tempahan Bilik</a></li>
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
				
				<!-- BUTIRAN PEMOHON -->
                <div class="card-header bg-purple">
                    <h3 class="card-title">Maklumat Pemohon </h3>
                </div>
                <form role="form" action="{{ route('tempahanbilik.simpan_tambah', $result->nokp) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <!-- Nama Pemohon -->
                    <div class="card-body">

                        <!-- style="margin:0 0px 5px 0px; width:70%" -->
                        <div class="form-group row">
                            <label for="nama" class="col-sm-3" style="text-align:left">Nama Pegawai </label>
                            <div class="input-group col-sm-9 ">
                                <input type="text" class="form-control" id="nama" name="nama"
                                    value="{{ $result->name }}" readonly>
                                {{-- <input type="hidden" class="form-control" id="nokp" name="nokp"
                                    value="{{ $result->nokp }}"> --}}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="jawatan" class="col-sm-3 col-form-label" style="text-align:left">Jawatan </label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="jawatan" name="jawatan"
                                    placeholder="Jawatan"
                                    value="{{ old('jawatan') == null ? $result->jawatan : old('jawatan') }}"
                                    readonly="readonly">
                            </div>

                            <label for="gred" class="col-sm-3 col-form-label" style="">Gred </label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="gred" name="gred" placeholder="Gred"
                                    value="{{ old('gred') == null ? $result->gred : old('gred') }}" readonly="readonly">
                            </div>
                        </div>

                        <!-- <input type="hidden" class="form-control" id="mykad" name="mykad" value="{{ old('nokp') == null ? $result->nokp : old('nokp') }}"> -->
                        <div class="form-group row">
                            <label for="bahagian" class="col-sm-3 col-form-label" style="text-align:left">Bahagian </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="bahagian" name="bahagian"
                                    placeholder="Bahagian"
                                    value="{{ $result->bahagian_id != '' ? \App\PLkpBahagian::find($result->bahagian_id)->bahagian : old('bahagian') }}"
                                    readonly="readonly">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="emel" class="col-sm-3 col-form-label" style="text-align:left">E-mel <font color= "red">*</font>  </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="emel" name="emel" placeholder="E-mel" value="{{ old('emel') == NULL ? $result->email : old('emel') }}" required>
                            </div>
                        </div>
        
                        <div class="form-group row">
                            <label for="telefon" class="col-sm-3 col-form-label" style="text-align:left">No. Telefon Pejabat <font color= "red">*</font>  </label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="telefon" name="telefon" placeholder="No. Tel. Pejabat" value="{{ old('telefon') == NULL ? $result->tel : old('telefon') }}" required>
                            </div>
        
                            <label for="tel_bimbit" class="col-sm-3 col-form-label" style="text-align:left">No. Telefon Bimbit <font color= "red">*</font>  </label>
                            <div class="col-sm-3">
                                {{-- <input type="text" class="form-control" id="tel_bimbit" name="tel_bimbit" placeholder="No. Tel Bimbit" value="{{ old('tel_bimbit') == NULL ? $result->tel_bimbit : old('tel_bimbit') }}" required> --}}
                                <input type="text" class="form-control" id="tel_bimbit" name="tel_bimbit" placeholder="No. Tel Bimbit" value="{{ old('tel_bimbit') == NULL ? $result->tel_bimbit : $pemohon->tel_bimbit }}" required>
                            </div>
                        </div>

                    </div>

                    <div class="card-header bg-purple">
                        <h3 class="card-title">Maklumat Tempahan</h3>
                    </div>
                    <p></p>
                    <div class="card-body" style="text-align:left">

                        <div class="form-group row">
                            <label for="id_tujuan" class="col-sm-3 col-form-label" style="text-align:left">Tujuan <font
                                    color="red">*</font> 
                            </label>
                            <div class="col-sm-6">
                                <select class="form-control select2" id="id_tujuan" name="id_tujuan" style="width: 100%;" onchange="makananDisable()" required>
                                    <option value=""
                                        @if (old('id_tujuan') == '') {{ 'selected="selected"' }} @endif>&nbsp;</option>
                                    @foreach ($optTujuans as $optTujuan)
                                        <option value="{{ $optTujuan->id_tujuan }}"
                                            @if (old('id_tujuan') == $optTujuan->id_tujuan) {{ 'selected="selected"' }} @endif>
                                            {{ $optTujuan->tujuan }}
                                        </option>
                                    @endforeach
                                </select>
                                
                                <label for="notisMakanan" class="col-sm-12 col-form-label" style="text-align:left" id="notisMakanan">
                                    <small><font color="red"><italic>* (Hanya mesyuarat dan sesi perbincangan akan disediakan tempahan makanan)</italic></font></small>
                                </label>
                            </div>

                            
                        </div>
                        <div class="form-group row">
                            <label for="nama_tujuan" class="col-sm-3 col-form-label" style="text-align:left">Keterangan
                                <font color="red">*</font>
                            </label>
                            <div class="col-sm-9">
                                <textarea id="nama_tujuan" name="nama_tujuan" type="text" class="form-control" rows="1"
                                    value="{{ old('nama_tujuan') }}"
                                    placeholder="Nama Mesyuarat / Perbincangan / Seminar / Bengkel / Kursus / Program" required>{{ old('nama_tujuan') }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nama_pengerusi" class="col-sm-3 col-form-label" style="text-align:left">Nama Pengerusi
                                <font color="red">*</font>
                            </label>
                            {{-- <div class="col-sm-4">
                                <input type="text" name="nama_pengerusi" id="nama_pengerusi" class="form-control"
                                    value="{{ old('nama_pengerusi') }}">
                            </div> --}}
                            <div class="col-sm-4">
                                <select class="form-control select2" id="nama_pengerusi" name="nama_pengerusi"
                                    style="width: 100%; text-align:left" required>
                                    <option value=""
                                        @if (old('nama_pengerusi') == '') {{ 'selected="selected"' }} @endif>&nbsp;
                                    </option>
                                    @foreach ($pengerusi as $pengerusiS)
                                        @if ($pengerusiS->agensi_id == 1)
                                            <option value="{{ $pengerusiS->id }}"
                                                @if (old('nama_pengerusi') == $pengerusiS->id) {{ 'selected="selected"' }} @endif>
                                                {{ $pengerusiS->name }} , {{ $pengerusiS->gred ?? '' }}  
                                                
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <div class="form-group row">
                            <label for="id_negeri" class="col-sm-3 col-form-label" style="text-align:left">Nama Bilik
                                Mesyuarat <font color="red">*</font> </label>
                            <div class="col-sm-4">
                                <select class="form-control select2" id="id_bilik" name="id_bilik"
                                    style="width: 100%; text-align:left" required>
                                    <option value=""
                                        @if (old('id_bilik') == '') {{ 'selected="selected"' }} @endif>&nbsp;
                                    </option>
                                    @foreach ($OptBilik as $biliks)
                                        <option value="{{ $biliks->id_bilik }}"
                                            @if (old('id_bilik') == $biliks->id_bilik) {{ 'selected="selected"' }} @endif>
                                            {{ $biliks->bilik }}, ( {{ $biliks->bahagian }} ) Aras-{{ $biliks->aras }}  
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tkh_mula" class="col-sm-3 col-form-label" style="text-align:left">Tarikh Mula
                                <font color="red">*</font>
                            </label>
                            <div class="col-sm-3">
                                <div class="input-group date" id="tkh_mula" data-target-input="nearest"
                                    placeholder="Tarikh Mula">
                                    <input type="text" id="tkh_pergi" name="tkh_mula"
                                        class="form-control datetimepicker-input" data-target="#tkh_mula"
                                        value="{{ old('tkh_mula') }}" required />
                                    <div class="input-group-append" data-target="#tkh_mula" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                            <label for="masa_mula" class="col-sm-3 col-form-label" style="text-align:left">Masa Mula
                                <font color="red">*</font>
                            </label>
                            <div class="col-sm-3">
                                <div class="input-group date" id="masa_mula" data-target-input="nearest"
                                    placeholder="Masa Mula">
                                    <input type="time" id="masa_mula" name="masa_mula" class="form-control"
                                        value="{{ old('masa_mula') }}" required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-time"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tkh_hingga" class="col-sm-3 col-form-label" style="text-align:left">Tarikh Tamat
                                <font color="red">*</font>
                            </label>
                            <div class="col-sm-3">
                                <div class="input-group date" id="tkh_hingga" data-target-input="nearest"
                                    placeholder="Tarikh Tamat">
                                    <input type="text" id="tkh_hingga" name="tkh_hingga"
                                        class="form-control datetimepicker-input" data-target="#tkh_hingga"
                                        value="{{ old('tkh_hingga') }}" required />
                                    <div class="input-group-append" data-target="#tkh_hingga"
                                        data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                            <label for="masa_hingga" class="col-sm-3 col-form-label" style="text-align:left">Masa Tamat
                                <font color="red">*</font>
                            </label>
                            <div class="col-sm-3">
                                <div class="input-group date" id="masa_hingga" data-target-input="nearest"
                                    placeholder="Masa Tamat">
                                    <input type="time" id="masa_hingga" name="masa_hingga" class="form-control"
                                        value="{{ old('masa_hingga') }}" required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-time"></span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="bil_penumpang" class="col-sm-3 col-form-label" style="text-align:left">Bil.
                                Pegawai yang terlibat <font color="red">*</font> </label>
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <input type="number" class="form-control" id="jumlah_pegawai" name="jumlah_pegawai"
                                        placeholder="Bil. Pegawai" min="1" max="40"
                                        value="{{ old('jumlah_pegawai') }}" required >
                                    <div class="input-group-append">
                                        <div class="input-group-text">Orang</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="card-header bg-purple">
                        <h3 class="card-title">Tempahan Makanan</h3>
                    </div>
                    <div class="card-body" style="text-align:left">

                        <div class="form-group row" id="divMakananEnable">
                            <label for="makanan" class="col-sm-2 col-form-label" style="text-align:left">Makanan 
                                <font color="red">*</font></label>

                            <label for="hidangan-radio" class="col-sm-2 col-form-label"><input type="radio"
                                    id="hidangan" name="hidangan-radio" value="1" {{ old('hidangan-radio') =="1" ? 'checked' : '' }} onclick="showHidangan(0)" />
                                Diperlukan</label>

                            <label for="hidangan-radio" class="col-sm-2 col-form-label"><input type="radio"
                                    id="hidanganTidak" name="hidangan-radio" value="2" {{ old('hidangan-radio') =="2" ? 'checked' : '' }} onclick="showHidangan(1)" /> Tidak Diperlukan</label>
                            
                        </div>

                        <div class="form-group row" id="yaMakanan">
                            <label for="jenis_makanan" class="col-sm-2 col-form-label" style="text-align:left">Waktu makan
                                <font color="red">*</font></label>
                            <label for="hidangan-radio" class="col-sm-2 col-form-label"><input type="checkbox"
                                     name="checkbox_makan[]" value="1" />
                                    Sarapan Pagi
                            </label>
                            <label for="hidangan-radio" class="col-sm-2 col-form-label"><input type="checkbox"
                                     name="checkbox_makan[]" value="2" />
                                    Makan Tengahari
                            </label>
                            <label for="hidangan-radio" class="col-sm-2 col-form-label"><input type="checkbox"
                                    name="checkbox_makan[]" value="3" />
                                    Minum Petang
                            </label>
                            <label for="hidangan-radio" class="col-sm-2 col-form-label"><input type="checkbox"
                                    name="checkbox_makan[]" value="4" />
                                    Makan Malam
                            </label>
                        </div>

                    </div>

                    <!-- <hr> -->
                    <div class="card-footer justify-content-center">
                        @if (!isset($tindakan))
                            <button type="submit" id="hantar" class="btn btn-purple float-left btn-sm bg-purple"><i
                                    class="fa fa-paper-plane"></i> |
                                Hantar</button>
                            <button type="submit" id="tempahMakan"
                                    class="btn btn-purple float-left btn-sm bg-purple"><i class="fa fa-paper-plane"></i> |
                                    Seterusnya</button>
                        @endif
                        <button type="button" class="btn btn-default float-right btn-sm" onclick="history.back();"><i
                                class="fas fa-redo-alt"></i> | Kembali</button>
                    </div>

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
					<label for="no_tel_penumpang" class="col-sm-3 col-form-label">No. Tel. Bimbit <font color= "red">*</font> </label>
					<div class="col-sm-3">
						<input type="text" class="form-control" id="no_tel_penumpang" name="no_tel_penumpang" placeholder="No. Tel" value="{{ old('no_tel_penumpang') }}" required>
					</div>
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
<script>
	//Check Radio button Makanan Diperlukan untuk muncul form Isi Makanan
	function showHidangan(x) {
		if (x == 0) {
			document.getElementById("hantar").style.display = "none";
			document.getElementById("yaMakanan").style.display = "block";
			document.getElementById("tempahMakan").style.display = "block";
		} 
		else {
			document.getElementById("hantar").style.display = "block";
			document.getElementById("yaMakanan").style.display = "none";
			document.getElementById("tempahMakan").style.display = "none";
		}
	}

	function makananDisable() {

		var e = document.getElementById("id_tujuan").value;
		if ( e == 1 || e == 8) {
			document.getElementById("hidangan").disabled = false;
			document.getElementById("hidanganTidak").disabled = false;
			document.getElementById("hidanganTidak").checked = false;
			document.getElementById("yaMakanan").style.display = "none";
		}
		else {
			document.getElementById("hidangan").disabled = true;
			document.getElementById("hidanganTidak").disabled = true;
			document.getElementById("hidanganTidak").checked = true;
			document.getElementById("yaMakanan").style.display = "none";
		}
	}

</script>

	@if (session ('failMakan')) 
        <script>

            document.getElementById("hantar").style.display = "none";
            document.getElementById("yaMakanan").style.display = "block";
            document.getElementById("tempahMakan").style.display = "block";

            var e = document.getElementById("id_tujuan").value;
            if ( e == 1 || e == 8) {
                document.getElementById("hidangan").disabled = false;
                document.getElementById("hidanganTidak").disabled = false;
                document.getElementById("hidanganTidak").checked = false;
                document.getElementById("yaMakanan").style.display = "block";
            }
            else {
                document.getElementById("hidangan").disabled = true;
                document.getElementById("hidanganTidak").disabled = true;
                document.getElementById("hidanganTidak").checked = true;
                document.getElementById("yaMakanan").style.display = "none";
            }

        </script>
    @endif
    @if ( session ('noMakanan') )
        <script>

            var e = document.getElementById("id_tujuan").value;
            if ( e == 1 || e == 8) {
                document.getElementById("hidangan").disabled = false;
                document.getElementById("hidanganTidak").disabled = false;
                document.getElementById("hidanganTidak").checked = false;
                document.getElementById("yaMakanan").style.display = "block";
            }
            else {
                document.getElementById("hidangan").disabled = true;
                document.getElementById("hidanganTidak").disabled = true;
                document.getElementById("hidanganTidak").checked = true;
                document.getElementById("yaMakanan").style.display = "none";
            }

        </script>
    @endif

<script type="text/javascript">
	$(function () {
	//Initialize Select2 Elements
	$('.select2').select2();

	$('#tkh_mula').datetimepicker({
		format: 'DD.MM.YYYY'
	});
	$('#tkh_hingga').datetimepicker({
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
		var maklumat_penumpang = btoa('x|x'+$('#bahagian_penumpang').select2('data')[0].id+'x|x'+$('#bahagian_penumpang').select2('data')[0].text+'x|x'+$('#nama_penumpang').select2('data')[0].id+'x|x'+$('#nama_penumpang').select2('data')[0].text+'x|x'+$('#no_tel_penumpang').val()+'x|x'+$('#emel_penumpang').val()+'x|x'+$('#mykad_penumpang').val())+'|x|x|';

		$('#maklumat_penumpang').val($('#maklumat_penumpang').val() + maklumat_penumpang);

		updatePenumpang();


		$('#nama_penumpang').val('');
		$('#nama_penumpang').select2().trigger('change');
		$('#bahagian_penumpang').val('');
		$('#bahagian_penumpang').select2().trigger('change');
		$('#no_tel_penumpang').val('');
		$('#emel_penumpang').val('');
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
			var mykad = mAhli[7];
			newSenMJ = newSenMJ+'<tr><td>'+bil+'</td><td>'+nama+'</td><td>'+bahagian+'</td><td>'+no_tel+'</td><td>'+emel+'</td><td><button type="button" class="btn btn-sm btn-danger" id="btnRemovePenumpang'+mj+'" onclick="removePenumpang('+mj+');" title="'+splitMJ[mj]+'"><i class="fa fa-trash"></i></button></td></tr>';
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

