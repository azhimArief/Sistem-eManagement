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
					
						<form class="form-horizontal" method="POST" action="{{ url('penilaian/catatanpemandu') }}" enctype="multipart/form-data">
						{{ csrf_field() }}
							
						<div class="card-header">
							<h3 class="card-title">CATATAN PEMANDU KENDERAAN BAGI PERKHIDMATAN KENDERAAN JABATAN KEMENTERIAN PERPADUAN NEGARA</h3>
						</div>
						<div class="card-body">
							<div class="form-group row">
								<label for="komen_pemandu" class="col-sm-2 col-form-label">Catatan:</label>
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
				$('#no_tel_penumpang').val(data1.tel);
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

