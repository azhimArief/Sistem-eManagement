@extends('layouts/master')

@section('content')

    {{-- @if ($permohonanBiliks->tempah_makan == '1'){
        <style>
                #yaMakanan, #tempahMakan {
                    display: block;
                }
                #hantar  {
                    display: none;
                }
            </style>
    }             
    @else{
         <style>
                #yaMakanan, #tempahMakan,  {
                    display: none;
                }
                #hantar {
                    display: block;
                }
            </style>
    }      
    @endif --}}
    @if ($permohonanBiliks->tempah_makan == '1')
        <style>
                #yaMakanan, #tempahMakan {
                    display: block;
                }
                #hantar  {
                    display: none;
                }
        </style>
                
    @else
         <style>
                #yaMakanan, #tempahMakan  {
                    display: none;
                }
                #hantar {
                    display: block;
                }
        </style>
        
    @endif


    <!-- Content Header (Page header) -->
    <div class="content-header">
 
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">KEMASKINI TEMPAHAN BILIK</h1>
          </div><!-- /.col -->
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/homeBilikMeet') }}">Laman Utama</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/tempahanbilik') }}">Tempahan Bilik</a></li>
              <li class="breadcrumb-item active">Kemaskini</li>
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
  
				<form class="form-horizontal" method="POST" action="{{ url('/tempahanbilik/kemaskini/simpan/'.$permohonanBiliks->id_permohonan_bilik) }}" enctype="multipart/form-data">
				   <!-- Nama Pemohon -->
                    <div class="card-body">
					{{ csrf_field() }}
                        <!-- style="margin:0 0px 5px 0px; width:70%" -->
                        <div class="form-group row">
                            <label for="nama" class="col-sm-3" style="text-align:left">Nama Pegawai </label>
                            <div class="input-group col-sm-9 ">
                                <input type="text" class="form-control" id="nama" name="nama"
                                    value="{{ $pemohon->name }}" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="jawatan" class="col-sm-3 col-form-label" style="text-align:left">Jawatan </label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="jawatan" name="jawatan"
                                    placeholder="Jawatan"
                                    value="{{ old('jawatan') == null ? $pemohon->jawatan : old('jawatan') }}"
                                    readonly="readonly">
                            </div>

                            <label for="gred" class="col-sm-3 col-form-label" style="">Gred </label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="gred" name="gred" placeholder="Gred"
                                    value="{{ old('gred') == null ? $pemohon->gred : old('gred') }}" readonly="readonly">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="bahagian" class="col-sm-3 col-form-label" style="text-align:left">Bahagian </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="bahagian" name="bahagian"
                                    placeholder="Bahagian"
                                    value="{{ old('bahagian') == null ? optional(\App\PLkpBahagian::find($pemohon->bahagian_id))->bahagian : old('bahagian') }}"
                                    readonly="readonly">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="emel" class="col-sm-3 col-form-label" style="text-align:left">E-mel <font color= "red">*</font>  </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="emel" name="emel" placeholder="E-mel" value="{{ old('emel') == NULL ? $pemohon->email : old('emel') }}" >
                            </div>
                        </div>
        
                        <div class="form-group row">
                            <label for="telefon" class="col-sm-3 col-form-label" style="text-align:left">No. Telefon Pejabat <font color= "red">*</font>  </label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="telefon" name="telefon" placeholder="No. Tel. Pejabat" value="{{ old('telefon') == NULL ? $pemohon->tel : old('telefon') }}">
                            </div>
        
                            <label for="tel_bimbit" class="col-sm-3 col-form-label" style="text-align:left">No. Telefon Bimbit <font color= "red">*</font>  </label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="tel_bimbit" name="tel_bimbit" placeholder="No. Tel Bimbit" value="{{ old('tel_bimbit') == NULL ? $pemohon->tel_bimbit : old('tel_bimbit') }}">
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
                                    color="red">*</font> </label>
                            <div class="col-sm-6">
                                <select class="form-control select2" id="id_tujuan" name="id_tujuan" style="width: 100%;" onchange="makananDisable()" 
                                    required>
                                    @php old('id_tujuan') == NULL ? $tujuan1=$permohonanBiliks->id_tujuan : $tujuan1=old('id_tujuan') @endphp
                                    <option value=""
                                        @if ($tujuan1 == '') {{ 'selected="selected"' }} @endif>&nbsp;</option>
                                    @foreach ($optTujuans as $optTujuan)
                                        <option value="{{ $optTujuan->id_tujuan }}"
                                            @if ($tujuan1 == $optTujuan->id_tujuan) {{ 'selected="selected"' }} @endif>
                                            {{ $optTujuan->tujuan }}</option>
                                    @endforeach
                                </select>

                                <label for="notisMakanan" class="col-sm-12 col-form-label" style="text-align:left" id="notisMakanan">
                                    <small><font color="red">* Hanya mesyuarat & sesi perbincangan akan disediakan tempahan makanan.</font></small>
                                </label>
                            </div>

                            
                        </div>
                        <div class="form-group row">
                            <label for="nama_tujuan" class="col-sm-3 col-form-label" style="text-align:left">Keterangan
                                <font color="red">*</font>
                            </label>
                            <div class="col-sm-9">
                                <textarea id="nama_tujuan" name="nama_tujuan" type="text" class="form-control" rows="1" required>{{ $permohonanBiliks->nama_tujuan }}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">

                            <label for="nama_pengerusi" class="col-sm-3 col-form-label" style="text-align:left">Nama Pengerusi
                                <font color="red">*</font>
                            </label>
                            <div class="col-sm-9">
                                <select class="form-control select2" id="nama_pengerusi" name="nama_pengerusi" style="width: 100%;"
                                   required>
                                   @php old('nama_pengerusi') == NULL ? $nama_pengerusi1=$permohonanBiliks->nama_pengerusi : $nama_pengerusi1=old('nama_pengerusi') @endphp
                                   <option value=""
                                       @if ($nama_pengerusi1 == '') {{ 'selected="selected"' }} @endif>&nbsp;</option>
                                   @foreach ($pengerusi as $pengerusiS)
                                        @if ($pengerusiS->agensi_id == 1 || $pengerusiS->agensi_id == 3)
                                            <option value="{{ $pengerusiS->id }}"
                                                @if ($nama_pengerusi1 == $pengerusiS->id) {{ 'selected="selected"' }} @endif>
                                                {{ $pengerusiS->name }} , {{ $pengerusiS->jawatan ?? '' }} 
                                            </option>
                                        @endif
                                   @endforeach
                               </select>
                           </div>
                           
                        </div>
                        
                        <div class="form-group row">
                            <label for="id_negeri" class="col-sm-3 col-form-label" style="text-align:left">Nama Bilik
                                Mesyuarat<font color="red">*</font> </label>
                            <div class="col-sm-9">
                                <select class="form-control select2" id="id_bilik" name="id_bilik"
                                    style="width: 100%;">
                                    @php old('id_bilik') == NULL ? $bilik1=$permohonanBiliks->id_bilik : $bilik1=old('id_bilik') @endphp
                                    <option value=""
                                        @if ($bilik1 == '') {{ 'selected="selected"' }} @endif>&nbsp;
                                    </option>
                                    @foreach ($optBiliks as $optBilik)
                                        <option value="{{ $optBilik->id_bilik }}"
                                            @if ($bilik1 == $optBilik->id_bilik) {{ 'selected="selected"' }} @endif>
                                            {{ $optBilik->bilik }}, ( {{ $optBilik->bahagian }} ) Aras-{{ $optBilik->aras }} 
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
                                        value="{{ old('tkh_mula') == null ? Carbon\Carbon::parse($permohonanBiliks->tkh_mula)->format('d.m.Y') : old('tkh_mula') }}"
                                        required />
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
                                        value="{{ $permohonanBiliks->masa_mula }}" required />
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
                                        value="{{ old('tkh_hingga') == null ? Carbon\Carbon::parse($permohonanBiliks->tkh_hingga)->format('d.m.Y') : old('tkh_hingga') }}"
                                        required />
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
                                        value="{{ $permohonanBiliks->masa_hingga }}" required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-time"></span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="jumlah_pegawai" class="col-sm-3 col-form-label" style="text-align:left">Bil.
                                Pegawai yang terlibat <font color="red">*</font> </label>
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <input type="number" class="form-control" id="jumlah_pegawai" name="jumlah_pegawai"
                                        placeholder="Bil. Pegawai" min="1" max="60"
                                        value="{{ $permohonanBiliks->bil_peserta }}" required>
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
                        
                        <div class="form-group row">
                            <label for="makanan" class="col-sm-2 col-form-label" style="text-align:left">Makanan
                            </label>
                            @if( $permohonanBiliks->tempah_makan == 1)
                                <label for="hidangan-radio" class="col-sm-2 col-form-label"><input type="radio"
                                    id="hidangan" name="hidangan-radio" value="1" onclick="showHidangan(0)" checked />
                                Diperlukan</label>
                            <label for="hidangan-radio" class="col-sm-2 col-form-label"><input type="radio"
                                    id="hidanganTidak" name="hidangan-radio" value="2" onclick="showHidangan(1)" />
                                Tidak
                                Diperlukan</label>
                            
                            @elseif ( $permohonanBiliks->id_tujuan != 1 && $permohonanBiliks->id_tujuan != 8)
                                <label for="hidangan-radio" class="col-sm-2 col-form-label"><input type="radio"
                                    id="hidangan" name="hidangan-radio" value="1" onclick="showHidangan(0)" disabled/>
                                Diperlukan</label>
                                <label for="hidangan-radio" class="col-sm-2 col-form-label"><input type="radio"
                                    id="hidanganTidak" name="hidangan-radio" value="2" onclick="showHidangan(1)" checked disabled/>
                                Tidak
                                Diperlukan</label>
                            
                            @else 
                                <label for="hidangan-radio" class="col-sm-2 col-form-label"><input type="radio"
                                    id="hidangan" name="hidangan-radio" value="1" onclick="showHidangan(0)" />
                                Diperlukan</label>
                            <label for="hidangan-radio" class="col-sm-2 col-form-label"><input type="radio"
                                    id="hidanganTidak" name="hidangan-radio" value="2" onclick="showHidangan(1)" checked/>
                                Tidak
                                Diperlukan</label>
                            
                            @endif
                        </div>

                        <div class="form-group row" id="yaMakanan">
                            
                            <label for="jenis_makanan" class="col-sm-2 col-form-label" style="text-align:left">Jenis makanan</label>
                            @if ($tempahMakans->makan_pagi == '1')
                                <label for="hidangan-radio" class="col-sm-2 col-form-label"><input type="checkbox"
                                        name="checkbox_makan[]" value="1" checked />
                                        Sarapan Pagi
                                </label>
                            @else 
                                 <label for="hidangan-radio" class="col-sm-2 col-form-label"><input type="checkbox"
                                    name="checkbox_makan[]" value="1" />
                                     Sarapan Pagi
                                </label>
                            @endif

                            @if ($tempahMakans->makan_tghari == "1")
                                <label for="hidangan-radio" class="col-sm-2 col-form-label"><input type="checkbox"
                                        name="checkbox_makan[]" value="2" checked/>
                                        Makan Tengahari
                                </label>
                            @else
                                <label for="hidangan-radio" class="col-sm-2 col-form-label"><input type="checkbox"
                                    name="checkbox_makan[]" value="2" />
                                    Makan Tengahari
                                 </label>
                            @endif
                                

                            @if ($tempahMakans->minum_petang == "1")
                                <label for="hidangan-radio" class="col-sm-2 col-form-label"><input type="checkbox"
                                        name="checkbox_makan[]" value="3" checked/>
                                        Minum Petang
                                </label>
                            @else
                                <label for="hidangan-radio" class="col-sm-2 col-form-label"><input type="checkbox"
                                        name="checkbox_makan[]" value="3" />
                                        Minum Petang
                                </label>
                            @endif


                            @if ($tempahMakans->makan_malam == "1")
                                <label for="hidangan-radio" class="col-sm-2 col-form-label"><input type="checkbox"
                                        name="checkbox_makan[]" value="4" checked/>
                                        Makan Malam
                                </label>
                            @else
                                <label for="hidangan-radio" class="col-sm-2 col-form-label"><input type="checkbox"
                                        name="checkbox_makan[]" value="4" />
                                        Makan Malam
                                </label>
                            @endif
                                
                        </div>

                    </div>

                    <!-- <hr> -->
                    <div class="card-footer justify-content-center">
                        @if (!isset($tindakan))
                        <button type="submit" id="hantar" class="btn btn-purple float-left btn-sm bg-purple"><i
                                class="fa fa-paper-plane"></i> |
                                Hantar
                        </button>
                        <button type="submit" id="tempahMakan"
                                class="btn btn-purple float-left btn-sm bg-purple"><i class="fa fa-paper-plane"></i> |
                                Seterusnya
                        </button>
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
   
@endsection

@section('script')
	<script>

        //Check Radio button Makanan Diperlukan untuk muncul form Isi Makanan
        function showHidangan(x) {
            if (x == 0) {
                document.getElementById("hantar").style.display = "none";
                document.getElementById("yaMakanan").style.display = "block";
                document.getElementById("tempahMakan").style.display = "block";
            } else {
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
        $(function() {
            // $("#jquery-ui-dialog").dialog();

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

	
    </script>
		
@endsection

