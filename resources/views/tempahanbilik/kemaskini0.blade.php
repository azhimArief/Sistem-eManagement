@extends('layouts/master')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Kemaskini Risi</h1>
          </div><!-- /.col -->
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/home') }}">Laman Utama</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/risi') }}">Risi</a></li>
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
			<form class="form-horizontal" method="POST" action="{{ url('risi/kemaskini/'.$maklumatRisi->id_risi) }}" enctype="multipart/form-data">
			  {{ csrf_field() }}	
            <div class="card card-info card-tabs">				
              <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-one-maklumat_risi-tab" data-toggle="pill" href="#custom-tabs-one-maklumat_risi" role="tab" aria-controls="custom-tabs-one-maklumat_risi" aria-selected="true">
						Maklumat RISI
					</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-maklumat_daftar-tab" data-toggle="pill" href="#custom-tabs-one-maklumat_daftar" role="tab" aria-controls="custom-tabs-one-maklumat_daftar" aria-selected="false">
						Maklumat Pendaftaran RISI
					</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-maklumat_jwtnkuasa-tab" data-toggle="pill" href="#custom-tabs-one-maklumat_jwtnkuasa" role="tab" aria-controls="custom-tabs-one-maklumat_jwtnkuasa" aria-selected="false">
						Maklumat Jawatankuasa 
					</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-maklumat_akaun-tab" data-toggle="pill" href="#custom-tabs-one-maklumat_akaun" role="tab" aria-controls="custom-tabs-one-maklumat_akaun" aria-selected="false">
						Maklumat Akaun
					</a>
                  </li>
                </ul>
              </div>
			  
			  
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-one-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-one-maklumat_risi" role="tabpanel" aria-labelledby="custom-tabs-one-maklumat_risi-tab">
					<div class="form-group row">
					  <dt class="col-sm-3">KodRisi</dt>
					  <dd class="col-sm-9">{{ $maklumatRisi->kod_risi }}</dd>
					</div>
					<div class="form-group row">
					<label for="jenis_risi" class="col-sm-3 col-form-label">Jenis RISI</label>
					<div class="col-sm-3">
						<select class="form-control select2" id="jenis_risi" name="jenis_risi" style="width: 100%;">
							@php old('jenis_risi') == NULL ? $jenis_risi1=$maklumatRisi->id_jenis_risi : $jenis_risi1=old('jenis_risi') @endphp
							<option value="" @if($jenis_risi1=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
							@foreach ($optJenisRisis as $optJenisRisi)
								<option value="{{ $optJenisRisi->id_jenis_risi }}" @if($jenis_risi1==$optJenisRisi->id_jenis_risi) {{ 'selected="selected"' }} @endif>{{ $optJenisRisi->jenis_risi }}</option>
							@endforeach
						</select>
					</div>
					</div>
					<div class="form-group row">
					  <dt class="col-sm-3">Negeri</dt>
					  <dd class="col-sm-9">{{ ($maklumatRisi->negeri!='') ? \App\LkpNegeri::find($maklumatRisi->negeri)->negeri : '' }}</dd>
					</div>
					<div class="form-group row">
					<label for="daerah" class="col-sm-3 col-form-label">Daerah</label>
					<div class="col-sm-3">
						<select class="form-control select2" id="daerah" name="daerah" style="width: 100%;">
							@php old('daerah') == NULL ? $daerah1=$maklumatRisi->id_daerah : $daerah1=old('daerah') @endphp
							<option value="" @if($daerah1=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
							@foreach ($optDaerahs as $optdaerah)
								<option value="{{ $optdaerah->id_daerah }}" @if($daerah1==$optdaerah->id_daerah) {{ 'selected="selected"' }} @endif>{{ $optdaerah->daerah }}</option>
							@endforeach
						</select>
					</div>
					</div>
					<div class="form-group row">
					<label for="parlimen" class="col-sm-3 col-form-label">Parlimen</label>
					<div class="col-sm-3">
						<select class="form-control select2" id="parlimen" name="parlimen" style="width: 100%;">
							@php old('parlimen') == NULL ? $parlimen1=$maklumatRisi->id_jenis_risi : $parlimen1=old('parlimen') @endphp
							<option value="" @if($parlimen1=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
							@foreach ($optParlimens as $optParlimen)
								<option value="{{ $optParlimen->id_parlimen }}" @if($parlimen1==$optParlimen->id_parlimen) {{ 'selected="selected"' }} @endif>{{ $optParlimen->parlimen }}</option>
							@endforeach
						</select>
					</div>
					<label for="dun" class="col-sm-3 col-form-label">DUN</label>
					<div class="col-sm-3">
					  <input type="text" class="form-control" id="dun" name="dun" placeholder="DUN" value="{{ old('dun') == NULL ? $maklumatRisi->dun : old('dun') }}">
					</div>
					</div>
					<div class="form-group row">
					<label for="nama_risi" class="col-sm-3 col-form-label">Nama RISI *</label>
					<div class="col-sm-9">
					  <input type="text" class="form-control" id="nama_risi" name="nama_risi" placeholder="Nama RISI" value="{{ old('nama_risi') == NULL ? $maklumatRisi->nama_risi : old('nama_risi') }}">
					</div>
					</div>
					<div class="form-group row">
					<label for="alamat1" class="col-sm-3 col-form-label">Alamat</label>
					<div class="col-sm-9">
					  <input type="text" class="form-control" id="alamat1" name="alamat1" placeholder="Alamat" value="{{ old('alamat1') == NULL ? $maklumatRisi->alamat1 : old('alamat1') }}">
					</div>
					</div>
					<div class="form-group row">
					<label for="alamat2" class="col-sm-3 col-form-label">&nbsp;</label>
					<div class="col-sm-9">
					  <input type="text" class="form-control" id="alamat2" name="alamat2" placeholder="Alamat" value="{{ old('alamat2') == NULL ? $maklumatRisi->alamat2 : old('alamat2') }}">
					</div>
					</div>
					<div class="form-group row">
					<label for="alamat3" class="col-sm-3 col-form-label">&nbsp;</label>
					<div class="col-sm-9">
					  <input type="text" class="form-control" id="alamat3" name="alamat3" placeholder="Alamat" value="{{ old('alamat3') == NULL ? $maklumatRisi->alamat3 : old('alamat3') }}">
					</div>
					</div>
					<div class="form-group row">
					<label for="poskod" class="col-sm-3 col-form-label">Poskod</label>
					<div class="col-sm-3">
					  <input type="text" class="form-control" id="poskod" name="poskod" placeholder="Poskod" value="{{ old('poskod') == NULL ? $maklumatRisi->poskod : old('poskod') }}" maxlength="5">
					</div>
					<label for="bandar" class="col-sm-3 col-form-label">Bandar</label>
					<div class="col-sm-3">
						<select class="form-control select2" id="bandar" name="bandar" style="width: 100%;">
							@php old('bandar') == NULL ? $bandar1=$maklumatRisi->id_jenis_risi : $jenis1=old('bandar') @endphp
							<option value="" @if($bandar1=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
							@foreach ($optBandars as $optBandar)
								<option value="{{ $optBandar->kod_bandar }}" @if($bandar1==$optBandar->kod_bandar) {{ 'selected="selected"' }} @endif>{{ $optBandar->bandar }}</option>
							@endforeach
						</select>
					</div>
					</div>
					<!--<div class="form-group row">
					  <dt class="col-sm-3">Negeri</dt>
					  <dd class="col-sm-9">{{ ($maklumatRisi->negeri!='') ? \App\LkpNegeri::find($maklumatRisi->negeri)->negeri : '' }}</dd>
					</div>-->
					<div class="form-group row">
					<label for="no_tel" class="col-sm-3 col-form-label">No. Tel</label>
					<div class="col-sm-3">
					  <input type="text" class="form-control" id="no_tel" name="no_tel" placeholder="No. Tel" value="{{ old('no_tel') == NULL ? $maklumatRisi->tel : old('no_tel') }}">
					</div>
					<label for="emel" class="col-sm-3 col-form-label">Emel</label>
					<div class="col-sm-3">
					  <input type="text" class="form-control" id="emel" name="emel" placeholder="Emel" value="{{ old('emel') == NULL ? $maklumatRisi->emel : old('emel') }}">
					</div>
					</div>
					<div class="form-group row">
					<dt class="col-sm-3">Agama</dt>
					<dd class="col-sm-3">{{ ($maklumatRisi->id_agama!='') ? \App\LkpAgama::find($maklumatRisi->id_agama)->nama_agama : '' }}</dd>
					<label for="denominasi" class="col-sm-3 col-form-label">Denominasi</label>
					<div class="col-sm-3">
						<select class="form-control select2" id="denominasi" name="denominasi" style="width: 100%;">
							@php old('denominasi') == NULL ? $denominasi1=$maklumatRisi->id_jenis_risi : $denominasi1=old('denominasi') @endphp
							<option value="" @if($denominasi1=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
							@foreach ($optMazhabs as $optMazhab)
								<option value="{{ $optMazhab->id_mazhab }}" @if($denominasi1==$optMazhab->id_mazhab) {{ 'selected="selected"' }} @endif>{{ $optMazhab->nama_mazhab }}</option>
							@endforeach
						</select>
					</div>
					</div>
					<div class="form-group row">
					<label for="saiz_ri" class="col-sm-3 col-form-label">Saiz Rumah Ibadat</label>
					<div class="col-sm-3">
					  <div class="input-group">
						<input type="text" class="form-control" id="saiz_ri" name="saiz_ri" placeholder="Saiz Rumah Ibadat" value="{{ old('saiz_ri') == NULL ? $maklumatRisi->saiz : old('saiz_ri') }}">
						<div class="input-group-append">
							<div class="input-group-text">Kaki Persegi</div>
						</div>
					  </div>
					</div>
					<label for="tkh_dibangunkan" class="col-sm-3 col-form-label">Tarikh Dibangunkan</label>
					<div class="col-sm-3">
						<div class="input-group date" id="tkh_dibangunkan" data-target-input="nearest" placeholder="Tarikh Dibangunkan">
							<input type="text" id="tkh_dibangunkan" name="tkh_dibangunkan" class="form-control datetimepicker-input" data-target="#tkh_dibangunkan" value="{{ old('tkh_dibangunkan') == NULL ? Carbon\Carbon::parse($maklumatRisi->tkh_bina)->format('d.m.Y') : old('tkh_dibangunkan') }}"/>
							<div class="input-group-append" data-target="#tkh_dibangunkan" data-toggle="datetimepicker">
								<div class="input-group-text"><i class="fa fa-calendar"></i></div>
							</div>
						</div>
					</div>
					</div>
					<div class="form-group row">
					<label for="foto" class="col-sm-3 col-form-label">Foto</label>
					<div class="input-group col-sm-9">
					  <input type="file" class="form-control" id="foto" name="foto">
					  <input type="hidden" class="form-control" id="old_foto" name="old_foto" value="{{ $maklumatRisi->lampiran }}">
					  @if($maklumatRisi->lampiran!='')
					  <div class="input-group-append">
						<a href="{{ url('../'.$maklumatRisi->lampiran) }}" class="input-group-text" target="_blank"><i class="fa fa-paperclip"></i></a>
					  </div>
					  @endif
					</div>
					</div>
				  </div>
				  
                  <div class="tab-pane fade show" id="custom-tabs-one-maklumat_daftar" role="tabpanel" aria-labelledby="custom-tabs-one-maklumat_daftar-tab">
					  <div class="form-group row">
						<label for="status_daftar" class="col-sm-3 col-form-label">Status Pendaftaran</label>
						<div class="col-sm-9" style="margin-top:7px;">
							@php old('status_daftar') == NULL ? $status_daftar1=$maklumatRisi->id_status_risi : $status_daftar1=old('status_daftar') @endphp
							@foreach ($optStatuss as $optStatus)
							<input type="radio" name="status_daftar" id="{{ $optStatus->jenis_status_risi }}" value="{{ $optStatus->id_status_risi }}" @if($status_daftar1==$optStatus->id_status_risi) {{ 'checked="checked"' }} @endif> <label class="form-check-label" for="{{ $optStatus->jenis_status_risi }}">{{ $optStatus->jenis_status_risi }}</label> &nbsp;&nbsp;&nbsp;
							@endforeach
						</div>
					  </div>
					  <div class="form-group row">
						<label for="no_daftar_ros" class="col-sm-3 col-form-label">No. Pendaftaran ROS</label>
						<div class="col-sm-3">
						  <input type="text" class="form-control" id="no_daftar_ros" name="no_daftar_ros" placeholder="No. Pendaftaran ROS" value="{{ old('no_daftar_ros') == NULL ? $maklumatRisi->reg_ros : old('no_daftar_ros') }}">
						</div>
						<label for="no_daftar_pbt" class="col-sm-3 col-form-label">No. Pendaftaran PBT</label>
						<div class="col-sm-3">
						  <input type="text" class="form-control" id="no_daftar_pbt" name="no_daftar_pbt" placeholder="No. Pendaftaran PBT" value="{{ old('no_daftar_pbt') == NULL ? $maklumatRisi->reg_pbt : old('no_daftar_pbt') }}">
						</div>
					  </div>
					  <div class="form-group row">
						<label for="status_tapak" class="col-sm-3 col-form-label">Status Tapak Tanah</label>
						<div class="col-sm-3">
							<select class="form-control select2" id="status_tapak" name="status_tapak" style="width: 100%;">
								@php old('status_tapak') == NULL ? $status_tapak1=$maklumatRisi->id_status_tanah : $jenis_risi1=old('status_tapak') @endphp
								<option value="" @if($status_tapak1=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
								@foreach ($optStatusTanahs as $optStatusTanah)
									<option value="{{ $optStatusTanah->id_status_tanah }}" @if($status_tapak1==$optStatusTanah->id_status_tanah) {{ 'selected="selected"' }} @endif>{{ $optStatusTanah->jenis_tanah }}</option>
								@endforeach
							</select>
						</div>
					  </div>				  
				  </div>
				  
                  <div class="tab-pane fade show" id="custom-tabs-one-maklumat_jwtnkuasa" role="tabpanel" aria-labelledby="custom-tabs-one-maklumat_jwtnkuasa-tab">
				  	<div class="form-group row">
						<label for="status_tapak" class="col-sm-3 col-form-label">Jawatankuasa Harmoni</label>
						<div class="col-sm-3">
							<select class="form-control select2" id="jawatankuasa_harmoni" name="jawatankuasa_harmoni" style="width: 100%;">
								@php old('jawatankuasa_harmoni') == NULL ? $jawatankuasa_harmoni1=$maklumatRisi->id_jwtnkuasa_harmoni : $jenis_risi1=old('jawatankuasa_harmoni') @endphp
								<option value="" @if($jawatankuasa_harmoni1=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
								@foreach ($optJawatankuasaHarmonis as $optJawatankuasaHarmoni)
									<option value="{{ $optJawatankuasaHarmoni->id_jwtnkuasa_harmoni }}" @if($jawatankuasa_harmoni1==$optJawatankuasaHarmoni->id_jwtnkuasa_harmoni) {{ 'selected="selected"' }} @endif>{{ $optJawatankuasaHarmoni->nama_harmoni }}</option>
								@endforeach
							</select>
						</div>
					</div>
					  
					<textarea class="form-control" style="display:none;" id="maklumat_jawatankuasa" name="maklumat_jawatankuasa">{{ old('no_daftar_pbt') == NULL ? $maklumat_jawatankuasa : old('no_daftar_pbt') }}</textarea>
					<table id="example1" class="table table-bordered table-striped">
					  <thead>
					  <tr>
						<th>Bil.</th>
						<th>Nama</th>
						<th>No. Tel</th>
						<th>Jawatan</th>
						<th>Tarikh Lantikan</th>
						<th>Status</th>
						<th width="10%">&nbsp;</th>
					  </tr>
					  </thead>
					  <tbody id="senMJ">
					  </tbody>
					  <tfoot>
						<tr>
							<td colspan="7" align="center"><a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Tambah</a></td>
					    </tr>
					  </tfoot>
					</table>
				  </div>
				  
                  <div class="tab-pane fade show" id="custom-tabs-one-maklumat_akaun" role="tabpanel" aria-labelledby="custom-tabs-one-maklumat_akaun-tab">
					<div class="form-group row">
						<label for="jenis_bank" class="col-sm-3 col-form-label">Jenis Bank</label>
						<div class="col-sm-9">
							<select class="form-control select2" id="jenis_bank" name="jenis_bank" style="width: 100%;">
								@php old('jenis_bank') == NULL ? $jenis_bank1=$maklumatAkaun->id_bank : $jenis_bank1=old('jenis_bank') @endphp
								<option value="" @if($jenis_bank1=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
								@foreach ($optBanks as $optBank)
									<option value="{{ $optBank->id_bank }}" @if($jenis_bank1==$optBank->id_bank) {{ 'selected="selected"' }} @endif>{{ $optBank->nama_bank }}</option>
								@endforeach
							</select>
						</div>
					  </div>
					  <div class="form-group row">
						<label for="jenis_akaun" class="col-sm-3 col-form-label">Jenis Akaun</label>
						<div class="col-sm-9" style="margin-top:7px;">
							@php old('jenis_akaun') == NULL ? $jenis_akaun1=$maklumatAkaun->jenis_acc : $jenis_akaun1=old('jenis_akaun') @endphp
							<input type="radio" name="jenis_akaun" id="simpanan" value="simpanan" @if($jenis_akaun1=='simpanan') {{ 'checked="checked"' }} @endif> <label class="form-check-label" for="simpanan">Simpanan</label> &nbsp;&nbsp;&nbsp;
							<input type="radio" name="jenis_akaun" id="semasa" value="semasa" @if($jenis_akaun1=='semasa') {{ 'checked="checked"' }} @endif> <label class="form-check-label" for="semasa">Semasa</label>
						</div>
					  </div>
					  <div class="form-group row">
						<label for="inputEmail3" class="col-sm-3 col-form-label">No. Akaun</label>
						<div class="col-sm-9">
						  <input type="text" class="form-control" id="no_akaun" name="no_akaun" placeholder="No. Akaun" value="{{ old('nama_risi') == NULL ? $maklumatAkaun->no_acc : old('no_akaun') }}">
						</div>
					  </div>
					  <div class="form-group row">
						<label for="nama_pgg_akaun" class="col-sm-3 col-form-label">Nama Pemegang Akaun</label>
						<div class="col-sm-9">
						  <input type="text" class="form-control" id="nama_pgg_akaun" name="nama_pgg_akaun" placeholder="Nama Pemegang Akaun" value="{{ old('nama_pgg_akaun') == NULL ? $maklumatAkaun->acc_owner : old('nama_pgg_akaun') }}">
						</div>
					  </div>
				  </div>
                </div>
              </div>
			  
			  <div class="card-footer">
					<button type="submit" name="submit_risi" class="btn btn-info">Simpan</button>
					<button type="button" class="btn btn-default float-right" onclick="history.back();">Kembali</button>
			  </div>
			  
			<?php /*
              <div class="card-header">
                <h3 class="card-title">Maklumat RISI</h3>
              </div>
              <!-- /.card-header -->
                <div class="card-body">
				<form class="form-horizontal" method="POST" action="{{ url('risi/kemaskini/'.$maklumatRisi->id_risi) }}" enctype="multipart/form-data">
				  {{ csrf_field() }}
                  <div class="form-group row">
					  <dt class="col-sm-3">KodRisi</dt>
					  <dd class="col-sm-9">{{ $maklumatRisi->kod_risi }}</dd>
                  </div>
				  <div class="form-group row">
                    <label for="jenis_risi" class="col-sm-3 col-form-label">Jenis RISI</label>
                    <div class="col-sm-3">
						<select class="form-control select2" id="jenis_risi" name="jenis_risi" style="width: 100%;">
							@php old('jenis_risi') == NULL ? $jenis_risi1=$maklumatRisi->id_jenis_risi : $jenis_risi1=old('jenis_risi') @endphp
							<option value="" @if($jenis_risi1=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
							@foreach ($optJenisRisis as $optJenisRisi)
								<option value="{{ $optJenisRisi->id_jenis_risi }}" @if($jenis_risi1==$optJenisRisi->id_jenis_risi) {{ 'selected="selected"' }} @endif>{{ $optJenisRisi->jenis_risi }}</option>
							@endforeach
						</select>
                    </div>
                  </div>
				   <div class="form-group row">
					  <dt class="col-sm-3">Negeri</dt>
					  <dd class="col-sm-9">{{ ($maklumatRisi->negeri!='') ? \App\LkpNegeri::find($maklumatRisi->negeri)->negeri : '' }}</dd>
                  </div>
				  
				  <div class="form-group row">
                    <label for="daerah" class="col-sm-3 col-form-label">Daerah</label>
                    <div class="col-sm-3">
						<select class="form-control select2" id="daerah" name="daerah" style="width: 100%;">
							@php old('daerah') == NULL ? $daerah1=$maklumatRisi->id_daerah : $daerah1=old('daerah') @endphp
							<option value="" @if($daerah1=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
							@foreach ($optDaerahs as $optdaerah)
								<option value="{{ $optdaerah->id_daerah }}" @if($daerah1==$optdaerah->id_daerah) {{ 'selected="selected"' }} @endif>{{ $optdaerah->daerah }}</option>
							@endforeach
						</select>
                    </div>
				   </div>
                  <div class="form-group row">
                    <label for="parlimen" class="col-sm-3 col-form-label">Parlimen</label>
                    <div class="col-sm-3">
						<select class="form-control select2" id="parlimen" name="parlimen" style="width: 100%;">
							@php old('parlimen') == NULL ? $parlimen1=$maklumatRisi->id_jenis_risi : $parlimen1=old('parlimen') @endphp
							<option value="" @if($parlimen1=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
							@foreach ($optParlimens as $optParlimen)
								<option value="{{ $optParlimen->id_parlimen }}" @if($parlimen1==$optParlimen->id_parlimen) {{ 'selected="selected"' }} @endif>{{ $optParlimen->parlimen }}</option>
							@endforeach
						</select>
                    </div>
                    <label for="dun" class="col-sm-3 col-form-label">DUN</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" id="dun" name="dun" placeholder="DUN" value="{{ old('dun') == NULL ? $maklumatRisi->dun : old('dun') }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="nama_risi" class="col-sm-3 col-form-label">Nama RISI *</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="nama_risi" name="nama_risi" placeholder="Nama RISI" value="{{ old('nama_risi') == NULL ? $maklumatRisi->nama_risi : old('nama_risi') }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="alamat1" class="col-sm-3 col-form-label">Alamat</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="alamat1" name="alamat1" placeholder="Alamat" value="{{ old('alamat1') == NULL ? $maklumatRisi->alamat1 : old('alamat1') }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="alamat2" class="col-sm-3 col-form-label">&nbsp;</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="alamat2" name="alamat2" placeholder="Alamat" value="{{ old('alamat2') == NULL ? $maklumatRisi->alamat2 : old('alamat2') }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="alamat3" class="col-sm-3 col-form-label">&nbsp;</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="alamat3" name="alamat3" placeholder="Alamat" value="{{ old('alamat3') == NULL ? $maklumatRisi->alamat3 : old('alamat3') }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="poskod" class="col-sm-3 col-form-label">Poskod</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" id="poskod" name="poskod" placeholder="Poskod" value="{{ old('poskod') == NULL ? $maklumatRisi->poskod : old('poskod') }}" maxlength="5">
                    </div>
                    <label for="bandar" class="col-sm-3 col-form-label">Bandar</label>
                    <div class="col-sm-3">
						<select class="form-control select2" id="bandar" name="bandar" style="width: 100%;">
							@php old('bandar') == NULL ? $bandar1=$maklumatRisi->id_jenis_risi : $jenis1=old('bandar') @endphp
							<option value="" @if($bandar1=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
							@foreach ($optBandars as $optBandar)
								<option value="{{ $optBandar->kod_bandar }}" @if($bandar1==$optBandar->kod_bandar) {{ 'selected="selected"' }} @endif>{{ $optBandar->bandar }}</option>
							@endforeach
						</select>
                    </div>
                  </div>
				  <!--<div class="form-group row">
					  <dt class="col-sm-3">Negeri</dt>
					  <dd class="col-sm-9">{{ ($maklumatRisi->negeri!='') ? \App\LkpNegeri::find($maklumatRisi->negeri)->negeri : '' }}</dd>
                  </div>-->
                  <div class="form-group row">
                    <label for="no_tel" class="col-sm-3 col-form-label">No. Tel</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" id="no_tel" name="no_tel" placeholder="No. Tel" value="{{ old('no_tel') == NULL ? $maklumatRisi->tel : old('no_tel') }}">
                    </div>
                    <label for="emel" class="col-sm-3 col-form-label">Emel</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" id="emel" name="emel" placeholder="Emel" value="{{ old('emel') == NULL ? $maklumatRisi->emel : old('emel') }}">
                    </div>
                  </div>
                  <div class="form-group row">
					<dt class="col-sm-3">Agama</dt>
					<dd class="col-sm-3">{{ ($maklumatRisi->id_agama!='') ? \App\LkpAgama::find($maklumatRisi->id_agama)->nama_agama : '' }}</dd>
                    <label for="denominasi" class="col-sm-3 col-form-label">Denominasi</label>
                    <div class="col-sm-3">
						<select class="form-control select2" id="denominasi" name="denominasi" style="width: 100%;">
							@php old('denominasi') == NULL ? $denominasi1=$maklumatRisi->id_jenis_risi : $denominasi1=old('denominasi') @endphp
							<option value="" @if($denominasi1=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
							@foreach ($optMazhabs as $optMazhab)
								<option value="{{ $optMazhab->id_mazhab }}" @if($denominasi1==$optMazhab->id_mazhab) {{ 'selected="selected"' }} @endif>{{ $optMazhab->nama_mazhab }}</option>
							@endforeach
						</select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="saiz_ri" class="col-sm-3 col-form-label">Saiz Rumah Ibadat</label>
                    <div class="col-sm-3">
					  <div class="input-group">
						<input type="text" class="form-control" id="saiz_ri" name="saiz_ri" placeholder="Saiz Rumah Ibadat" value="{{ old('saiz_ri') == NULL ? $maklumatRisi->saiz : old('saiz_ri') }}">
						<div class="input-group-append">
							<div class="input-group-text">Kaki Persegi</div>
						</div>
                      </div>
                    </div>
                    <label for="tkh_dibangunkan" class="col-sm-3 col-form-label">Tarikh Dibangunkan</label>
                    <div class="col-sm-3">
						<div class="input-group date" id="tkh_dibangunkan" data-target-input="nearest" placeholder="Tarikh Dibangunkan">
							<input type="text" id="tkh_dibangunkan" name="tkh_dibangunkan" class="form-control datetimepicker-input" data-target="#tkh_dibangunkan" value="{{ old('tkh_dibangunkan') == NULL ? Carbon\Carbon::parse($maklumatRisi->tkh_bina)->format('d.m.Y') : old('tkh_dibangunkan') }}"/>
							<div class="input-group-append" data-target="#tkh_dibangunkan" data-toggle="datetimepicker">
								<div class="input-group-text"><i class="fa fa-calendar"></i></div>
							</div>
						</div>
					</div>
                  </div>
                  <div class="form-group row">
                    <label for="foto" class="col-sm-3 col-form-label">Foto</label>
                    <div class="input-group col-sm-9">
                      <input type="file" class="form-control" id="foto" name="foto">
                      <input type="hidden" class="form-control" id="old_foto" name="old_foto" value="{{ $maklumatRisi->lampiran }}">
					  @if($maklumatRisi->lampiran!='')
					  <div class="input-group-append">
						<a href="{{ url('../'.$maklumatRisi->lampiran) }}" class="input-group-text" target="_blank"><i class="fa fa-paperclip"></i></a>
					  </div>
					  @endif
                    </div>
                  </div>
				</div>
				
				<div class="card-header">
					<h3 class="card-title">Maklumat Pendaftaran RISI</h3>
				</div>
			    <div class="card-body">
				  <div class="form-group row">
					<label for="status_daftar" class="col-sm-3 col-form-label">Status Pendaftaran</label>
					<div class="col-sm-9" style="margin-top:7px;">
						@php old('status_daftar') == NULL ? $status_daftar1=$maklumatRisi->id_status_risi : $status_daftar1=old('status_daftar') @endphp
						@foreach ($optStatuss as $optStatus)
						<input type="radio" name="status_daftar" id="{{ $optStatus->jenis_status_risi }}" value="{{ $optStatus->id_status_risi }}" @if($status_daftar1==$optStatus->id_status_risi) {{ 'checked="checked"' }} @endif> <label class="form-check-label" for="{{ $optStatus->jenis_status_risi }}">{{ $optStatus->jenis_status_risi }}</label> &nbsp;&nbsp;&nbsp;
						@endforeach
					</div>
				  </div>
                  <div class="form-group row">
                    <label for="no_daftar_ros" class="col-sm-3 col-form-label">No. Pendaftaran ROS</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" id="no_daftar_ros" name="no_daftar_ros" placeholder="No. Pendaftaran ROS" value="{{ old('no_daftar_ros') == NULL ? $maklumatRisi->reg_ros : old('no_daftar_ros') }}">
                    </div>
                    <label for="no_daftar_pbt" class="col-sm-3 col-form-label">No. Pendaftaran PBT</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" id="no_daftar_pbt" name="no_daftar_pbt" placeholder="No. Pendaftaran PBT" value="{{ old('no_daftar_pbt') == NULL ? $maklumatRisi->reg_pbt : old('no_daftar_pbt') }}">
                    </div>
                  </div>
				  <div class="form-group row">
					<label for="status_tapak" class="col-sm-3 col-form-label">Status Tapak Tanah</label>
					<div class="col-sm-3">
						<select class="form-control select2" id="status_tapak" name="status_tapak" style="width: 100%;">
							@php old('status_tapak') == NULL ? $status_tapak1=$maklumatRisi->id_status_tanah : $jenis_risi1=old('status_tapak') @endphp
							<option value="" @if($status_tapak1=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
							@foreach ($optStatusTanahs as $optStatusTanah)
								<option value="{{ $optStatusTanah->id_status_tanah }}" @if($status_tapak1==$optStatusTanah->id_status_tanah) {{ 'selected="selected"' }} @endif>{{ $optStatusTanah->jenis_tanah }}</option>
							@endforeach
						</select>
					</div>
				  </div>
			    </div>
				
				<div class="card-header">
					<h3 class="card-title">Maklumat Jawatankuasa</h3>
					<span class="float-right" style="margin-top:-5px;">
					
					
				 
						<a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Tambah</a>
					</span>
				</div>				
				
				<div class="card-body">
				 <div class="form-group row">
					<label for="status_tapak" class="col-sm-3 col-form-label">Jawatankuasa Harmoni</label>
					<div class="col-sm-3">
						<select class="form-control select2" id="jawatankuasa_harmoni" name="jawatankuasa_harmoni" style="width: 100%;">
							@php old('jawatankuasa_harmoni') == NULL ? $jawatankuasa_harmoni1=$maklumatRisi->id_jwtnkuasa_harmoni : $jenis_risi1=old('jawatankuasa_harmoni') @endphp
							<option value="" @if($jawatankuasa_harmoni1=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
							@foreach ($optJawatankuasaHarmonis as $optJawatankuasaHarmoni)
								<option value="{{ $optJawatankuasaHarmoni->id_jwtnkuasa_harmoni }}" @if($jawatankuasa_harmoni1==$optJawatankuasaHarmoni->id_jwtnkuasa_harmoni) {{ 'selected="selected"' }} @endif>{{ $optJawatankuasaHarmoni->nama_harmoni }}</option>
							@endforeach
						</select>
					</div>
				  </div>
				  
					<textarea class="form-control" style="display:none;" id="maklumat_jawatankuasa" name="maklumat_jawatankuasa">{{ old('no_daftar_pbt') == NULL ? $maklumat_jawatankuasa : old('no_daftar_pbt') }}</textarea>
					<table id="example1" class="table table-bordered table-striped">
					  <thead>
					  <tr>
						<th>Bil.</th>
						<th>Nama</th>
						<th>No. Tel</th>
						<th>Jawatan</th>
						<th>Tarikh Lantikan</th>
						<th>Status</th>
						<th width="10%">&nbsp;</th>
					  </tr>
					  </thead>
					  <tbody id="senMJ">
					  </tbody>
					</table>
				</div>
				
				<div class="card-header">
					<h3 class="card-title">Maklumat Akaun Bank</h3>
				</div>
			    <div class="card-body">
				  <div class="form-group row">
					<label for="jenis_bank" class="col-sm-3 col-form-label">Jenis Bank</label>
					<div class="col-sm-9">
						<select class="form-control select2" id="jenis_bank" name="jenis_bank" style="width: 100%;">
							@php old('jenis_bank') == NULL ? $jenis_bank1=$maklumatAkaun->id_bank : $jenis_bank1=old('jenis_bank') @endphp
							<option value="" @if($jenis_bank1=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
							@foreach ($optBanks as $optBank)
								<option value="{{ $optBank->id_bank }}" @if($jenis_bank1==$optBank->id_bank) {{ 'selected="selected"' }} @endif>{{ $optBank->nama_bank }}</option>
							@endforeach
						</select>
					</div>
				  </div>
                  <div class="form-group row">
					<label for="jenis_akaun" class="col-sm-3 col-form-label">Jenis Akaun</label>
					<div class="col-sm-9" style="margin-top:7px;">
						@php old('jenis_akaun') == NULL ? $jenis_akaun1=$maklumatAkaun->jenis_acc : $jenis_akaun1=old('jenis_akaun') @endphp
						<input type="radio" name="jenis_akaun" id="simpanan" value="simpanan" @if($jenis_akaun1=='simpanan') {{ 'checked="checked"' }} @endif> <label class="form-check-label" for="simpanan">Simpanan</label> &nbsp;&nbsp;&nbsp;
						<input type="radio" name="jenis_akaun" id="semasa" value="semasa" @if($jenis_akaun1=='semasa') {{ 'checked="checked"' }} @endif> <label class="form-check-label" for="semasa">Semasa</label>
					</div>
				  </div>
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">No. Akaun</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="no_akaun" name="no_akaun" placeholder="No. Akaun" value="{{ old('nama_risi') == NULL ? $maklumatAkaun->no_acc : old('no_akaun') }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="nama_pgg_akaun" class="col-sm-3 col-form-label">Nama Pemegang Akaun</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="nama_pgg_akaun" name="nama_pgg_akaun" placeholder="Nama Pemegang Akaun" value="{{ old('nama_pgg_akaun') == NULL ? $maklumatAkaun->acc_owner : old('nama_pgg_akaun') }}">
                    </div>
                  </div>
                </div>
			  
			  
                <!-- /.card-body -->
				<div class="card-footer">
					<button type="submit" name="submit_risi" class="btn btn-info">Simpan</button>
					<button type="button" class="btn btn-default float-right" onclick="history.back();">Kembali</button>
				</div>
				<!-- /.card-footer -->*/?>
            </div>
            </form>
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
              <h4 class="modal-title">Tambah Pengurusan RISI</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
			<form class="form-horizontal" method="POST" action="{{ url('penerbitan/tambah') }}" enctype="multipart/form-data" id="JawatankuasaForm">
			  {{ csrf_field() }}
				<div class="modal-body">
                  <div class="form-group row">
                    <label for="nama_ahli_jwtnkuasa" class="col-sm-3 col-form-label">Nama</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="nama_ahli_jwtnkuasa" name="nama_ahli_jwtnkuasa" placeholder="Nama" value="{{ old('nama_ahli_jwtnkuasa') }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="jawatan_ahli" class="col-sm-3 col-form-label">Jawatan</label>
                    <div class="col-sm-9">
						<select class="form-control select2" id="jawatan_ahli" name="jawatan_ahli" style="width: 100%;">
							<option value="" @if(old('jawatan_ahli')=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
							@foreach ($optJawatanRisis as $optJawatanRisi)
								<option value="{{ $optJawatanRisi->id_jawatan }}" title="{{ $optJawatanRisi->nama_jawatan }}" @if(old('jawatan_ahli')==$optJawatanRisi->id_jawatan) {{ 'selected="selected"' }} @endif>{{ $optJawatanRisi->nama_jawatan }}</option>
							@endforeach
						</select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="no_tel_ahli" class="col-sm-3 col-form-label">No. Tel</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" id="no_tel_ahli" name="no_tel_ahli" placeholder="No. Tel" value="{{ old('no_tel_ahli') }}">
                    </div>
					<label for="emel_ahli" class="col-sm-2 col-form-label">Emel</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" id="emel_ahli" name="emel_ahli" placeholder="Emel" value="{{ old('emel_ahli') }}">
					</div>
                  </div>
                  <div class="form-group row">
                    <label for="tkh_lantikan_ahli" class="col-sm-3 col-form-label">Tarikh Lantikan</label>
                    <div class="col-sm-3">
						<div class="input-group date" id="tkh_lantikan_ahli" data-target-input="nearest" placeholder="Tarikh Lantikan">
							<input type="text" id="tkh_lantikan_ahli" name="tkh_lantikan_ahli" class="form-control datetimepicker-input" data-target="#tkh_lantikan_ahli" value="{{ old('tkh_kuatkuasa') }}"/>
							<div class="input-group-append" data-target="#tkh_lantikan_ahli" data-toggle="datetimepicker">
								<div class="input-group-text"><i class="fa fa-calendar"></i></div>
							</div>
						</div>
                    </div>
					<label for="status_ahli" class="col-sm-2 col-form-label">Status</label>
                    <div class="col-sm-4">
						@foreach ($optStatusAhlis as $optStatusAhli)
						<input type="radio" name="status_ahli" id="{{ $optStatusAhli->jenis_status_risi }}" value="{{ $optStatusAhli->id_status_risi }}" title="{{ $optStatusAhli->jenis_status_risi }}"> <label class="form-check-label" for="{{ $optStatusAhli->jenis_status_risi }}">{{ $optStatusAhli->jenis_status_risi }}</label> &nbsp;&nbsp;&nbsp;
						@endforeach
					</div>
                  </div>
				</div>
				<div class="modal-footer justify-content-between">
				  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				  <button type="button" class="btn btn-primary" id="tambah_jawatankuasa" onclick="tambahJawatankuasa()" data-dismiss="modal">Tambah</button>
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
		
		updateJawatankuasa();
		
		bsCustomFileInput.init();
	});
	
	function tambahJawatankuasa() {
		
		if(typeof $('input[name=status_ahli]:checked').val() === 'undefined' ) var status_ahli = 'x|x'; else var status_ahli = $('input[name=status_ahli]:checked').val()+'x|x'+$('input[name=status_ahli]:checked').attr('title');
		var maklumat_jawatankuasa = btoa('x|x'+$('#nama_ahli_jwtnkuasa').val()+'x|x'+$('#jawatan_ahli').select2('data')[0].id+'x|x'+$('#jawatan_ahli').select2('data')[0].text+'x|x'+$('#no_tel_ahli').val()+'x|x'+$('#emel_ahli').val()+'x|x'+$('input[name=tkh_lantikan_ahli]').val()+'x|x'+status_ahli)+'|x|x|';
		
		$('#maklumat_jawatankuasa').val($('#maklumat_jawatankuasa').val() + maklumat_jawatankuasa);
		
		updateJawatankuasa();
		
		
		$('#nama_ahli_jwtnkuasa').val('');
		$('#jawatan_ahli').val('');
		$('#jawatan_ahli').select2().trigger('change');		
		$('#no_tel_ahli').val('');
		$('#emel_ahli').val('');
		$('input[name=tkh_lantikan_ahli]').val('');
		$('input[name=status_ahli]').prop('checked', false);		
	}
	
	function updateJawatankuasa() {
		var newSenMJ = '';
		var splitMJ = $('#maklumat_jawatankuasa').val().split('|x|x|');
		for(var mj=0; mj<splitMJ.length - 1; mj++) {
			var bil = mj + 1;
			var mAhli = atob(splitMJ[mj]).split('x|x');
			var nama = mAhli[1];
			var idjawatan = mAhli[2];
			var jawatan = mAhli[3];
			var no_tel = mAhli[4];
			var emel = mAhli[5];
			var tkhlantikan = mAhli[6];
			var idstatus = mAhli[7];
			var status = mAhli[8];
			newSenMJ = newSenMJ+'<tr><td>'+bil+'</td><td>'+nama+'</td><td>'+no_tel+'</td><td>'+jawatan+'</td><td>'+tkhlantikan+'</td><td>'+status+'</td><td><button type="button" class="btn btn-sm btn-danger" id="btnRemoveAhli'+mj+'" onclick="removeJawatankuasa('+mj+');"><i class="fa fa-trash"></i></button></td></tr>';
		}
		$('#senMJ').html(newSenMJ);
	}
	
	function removeJawatankuasa(mj1) {
		var maklumat_jawatankuasa = '';
		var splitMJ = $('#maklumat_jawatankuasa').val().split('|x|x|');
		for(var mj=0; mj<splitMJ.length - 1; mj++) {
			if(mj1 != mj) {
				maklumat_jawatankuasa += splitMJ[mj]+'|x|x|';
			}
		}
		$('#maklumat_jawatankuasa').val(maklumat_jawatankuasa);
		updateJawatankuasa();
	}
	</script>
@endsection

