@extends('layouts/master')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Tempahan Kenderaan</h1>
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
				<div class="card-header">
					<h3 class="card-title">Maklumat Pemohon</h3>
				</div>
				<!-- /.card-header -->
				<div class="card-body">
				<form class="form-horizontal" method="POST" action="{{ url('tempahankenderaan/tambah') }}" enctype="multipart/form-data">
				{{ csrf_field() }}
			
				<div class="card-header">
					<h3 class="card-title">Maklumat Penumpang</h3>
					<span class="float-right" style="margin-top:-5px;">
					<a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Tambah</a>
					</span>
				</div>
				<div class="card-body">
					<textarea class="form-control" style="display:none;" id="maklumat_penumpang" name="maklumat_penumpang">{{ old('maklumat_penumpang') }}</textarea>
					<table id="example1" class="table table-bordered table-striped">
					<thead>
						<tr>
						<th>Bil.</th>
						<th>Nama</th>
						<th>Bahagian</th>
						<th>No. Tel</th>
						<th>Emel</th>
						<th width="10%">&nbsp;</th>
						</tr>
					</thead>
					<tbody id="senMJ">
					</tbody>
					</table>
				</div>
				
                <!-- /.card-body -->
				<div class="card-footer">
					<button type="submit" name="submit_tempahankenderaan" class="btn btn-info">Hantar</button>
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
			<div class="modal-header">
				<h4 class="modal-title">Tambah Pengurusan POWER</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form class="form-horizontal" method="POST" action="" enctype="multipart/form-data" id="PenumpangForm">
				{{ csrf_field() }}
				<div class="modal-body">
				
				<div class="form-group row">
					<label for="bahagian_penumpang" class="col-sm-3 col-form-label">Bahagian</label>
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
					<label for="nama_penumpang" class="col-sm-3 col-form-label">Nama</label>
					<div class="col-sm-9">
					<!-- <input type="text" class="form-control" id="nama_penumpang" name="nama_penumpang" placeholder="Nama" value="{{ old('nama_penumpang') }}"> -->
						<select class="form-control select2" id="nama_penumpang" name="nama_penumpang" style="width: 100%;">
							<option value="" @if(old('nama_penumpang')=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
							<option value="" selected disabled > -- Sila Pilih -- </option>
						</select>	
					</div>
				</div>
				
				<div class="form-group row">
					<label for="no_tel_penumpang" class="col-sm-3 col-form-label">No. Tel. Bimbit</label>
					<div class="col-sm-3">
					<input type="text" class="form-control" id="no_tel_penumpang" name="no_tel_penumpang" placeholder="No. Tel" value="{{ old('no_tel_penumpang') }}">
					</div>
					<label for="emel_penumpang" class="col-sm-2 col-form-label">E-mel</label>
					<div class="col-sm-4">
					<input type="text" class="form-control" id="emel_penumpang" name="emel_penumpang" placeholder="Emel" value="{{ old('emel_penumpang') }}">
					</div>
				</div>
				
				</div>
				<div class="modal-footer justify-content-between">
				<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
				<button type="button" class="btn btn-primary" id="tambah_penumpang" onclick="tambahPenumpang()" data-dismiss="modal">Tambah</button>
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
$(function () {
  //Initialize Select2 Elements
  $('.select2').select2();

  $('#tkh_dibangunkan').datetimepicker({
    format: 'DD.MM.YYYY'
  });
  $('#tkh_lantikan_ahli').datetimepicker({
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
		},
		error:function(){
		}
		});
	});
});

function tambahPenumpang() {

  
  var maklumat_penumpang = btoa('x|x'+$('#bahagian_penumpang').select2('data')[0].id+'x|x'+$('#bahagian_penumpang').select2('data')[0].text+'x|x'+$('#nama_penumpang').select2('data')[0].id+'x|x'+$('#nama_penumpang').select2('data')[0].text+'x|x'+$('#no_tel_penumpang').val()+'x|x'+$('#emel_penumpang').val())+'|x|x|';

  $('#maklumat_penumpang').val($('#maklumat_penumpang').val() + maklumat_penumpang);

  updatePenumpang();


  $('#nama_penumpang').val('');
  $('#nama_penumpang').select2().trigger('change');
  $('#bahagian_penumpang').val('');
  $('#bahagian_penumpang').select2().trigger('change');
  $('#no_tel_penumpang').val('');
  $('#emel_penumpang').val('');
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
    newSenMJ = newSenMJ+'<tr><td>'+bil+'</td><td>'+nama+'</td><td>'+bahagian+'</td><td>'+no_tel+'</td><td>'+emel+'</td><td><button type="button" class="btn btn-sm btn-danger" id="btnRemovePenumpang'+bil+'" onclick="removePenumpang('+bil+');" title="'+splitMJ[mj]+'"><i class="fa fa-trash"></i></button></td></tr>';
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

