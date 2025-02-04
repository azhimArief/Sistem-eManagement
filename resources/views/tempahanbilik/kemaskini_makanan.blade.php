@extends('layouts/master')
@section('content')

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
  
				<form class="form-horizontal" method="POST" action="{{ url('tempahanbilik/kemaskini/simpan_makanan/'.$tempahmakan->id_tempah_makan) }}" enctype="multipart/form-data">
                    @csrf
                    @if ($tempahmakan)
                        @if ($tempahmakan->makan_pagi == '1')
                            {{-- Makan Pagi Form --}}
                            <div class="makan_pagi">
                                <div class="card-header bg-purple">
                                    <h3 class="card-title">Makan Pagi</h3>
                                </div>
                                <div class="card-body" style="text-align:left"> 
                                    <div class="container">
                                        <table id="example2" class="table table-bordered">
                                        <thead bgcolor="CF9FFF">
                                        <tr>
                                            <th>Menu</th>
                                            <th>Kalori</th>
                                            <th>&nbsp;</th>
                                        </tr>
                                        </thead> 
                                        <tbody>
                                        @foreach ($menumakan as $menumakans)
                                            <!-- MODAL UBAH MENU MAKAN  -->
                                            <div class="modal fade" id="modal-makan-{{  $menumakans->id_menu_makan }}">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-purple">
                                                        <h5 class="modal-title">Kemaskini Menu Makanan</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                        </div>
                                                        {{-- <form class="form-horizontal" method="POST" action="{{ url('tempahanbilik/tindakan/simpan/ubahsuai_makanan/'.$menuMakan->id_menu_makan) }}" enctype="multipart/form-data"> --}}
                                                        <form class="form-horizontal" method="POST" action="{{ url('/tempahanbilik/kemaskini/simpan_makanan/' . $tempahmakan->id_tempah_makan) }}" enctype="multipart/form-data">
                                                            {{ csrf_field() }}
                                                            <div class="modal-body">

                                                                <input type="hidden" name="id_menu_makan" value="{{ $menumakans->id_menu_makan }}">
                                                                
                                                                <div class="input-group mb-3">
                                                                    <label class="input-group-text" for="inputGroupSelect01">Menu</label>
                                                                    <div class="col-sm-6">
                                                                        <input type="text" name="menu_baru" id="menu_baru" class="form-control"
                                                                            value="{{ $menumakans->menu }}" required>
                                                                    </div>
                                                                </div>

                                                                <div class="input-group mb-3">
                                                                    <label class="input-group-text" for="inputGroupSelect01">Kalori</label>
                                                                    <div class="col-sm-6">
                                                                        <input type="text" name="kalori_baru" id="kalori_baru" class="form-control"
                                                                            value="{{ $menumakans->kalori }}" required>
                                                                    </div>
                                                                </div>
                                                                {{-- <input type="hidden" name="jenis_makan" value="{{ $menumakans->jenis_makan }}"> --}}

                                                            </div>

                                                            <div class="modal-footer justify-content-between">
                                                                <span class="float-right">
                                                                    <button type="submit" class="btn btn-primary bg-purple" name="edit_makanan">Simpan</button>
                                                                </span>
                                                            </div>

                                                        </form>
                                                    </div> <!-- /.modal-content -->
                                                </div> <!-- /.modal-dialog -->
                                            </div>

                                            @if($menumakans->jenis_makan == '1')
                                                <tr>
                                                    <td>{{ ($menumakans->menu) ?? '-' }}</td>
                                                    <td>{{ ($menumakans->kalori) ?? '-' }}</td>
                                                    <td align="center">
                                                        <a href="{{ route('tempahanbilik.hapus_makanan',$menumakans->id_menu_makan) }}" title="Buang" class="btn-sm btn-danger"> <i class="fa fa-trash"></i></a>
                                                        <a class="btn-sm btn-success" data-toggle="modal" data-target="#modal-makan-{{ $menumakans->id_menu_makan }}"><i class=""></i> <i class="fa fa-pen"></i></a>
                                                    </td>
                                                </tr>
                                            @else
                                            @endif       
                                        @endforeach 
                                        </tbody>
                                        </table>
                                    </div> 

                                        <div class="form-group row">
                                            <label for="id_jenis_hidangan1" class="col-sm-3 col-form-label" style="text-align:left">Jenis Hidangan</label>
                                            <div class="col-sm-3">
                                            
                                                <select class="form-control select2" id="id_jenis_hidangan1" name="id_jenis_hidangan1" style="width: 100%;" >
                                                    @php old('id_jenis_hidangan1') == NULL ? $jenis1=$tempahmakan->id_jenis_hidangan1 : $jenis1=old('id_jenis_hidangan1') @endphp
                                                    <option value=""
                                                        @if ($jenis1 == '') {{ 'selected="selected"' }} @endif>&nbsp;
                                                    </option>
                                                    @foreach ($optJenisHidangans as $optJenisHidangan)
                                                        <option value="{{ $optJenisHidangan->id_jenis_hidangan }}"
                                                            @if ($jenis1 == $optJenisHidangan->id_jenis_hidangan) {{ 'selected="selected"' }} @endif>
                                                            {{ $optJenisHidangan->jenis_hidangan }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="input_pagi" class="col-sm-3 col-form-label" style="text-align:left">Menu</label>
                                            <div class="col-sm-3">
                                                <div class="input-group">
                                                    <input type="hidden" name="jenis_makan1" value="1"> 
                                                    <input type="hidden" name="id_makan1" value="{{ $tempahmakan->id_tempah_makan }}">
                                                    {{-- <input type="text" class="form-control" id="input_pagi" name="input_pagi"
                                                        placeholder="Menu Makan" min="1" max="40"
                                                        value="{{ old('input_pagi') }}" > --}}
                                                    <textarea name="input_pagi" class="form-control" id="input_pagi" cols="30" rows="2" placeholder="Menu Makan">{{ old('input_pagi') }}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="kalori_pagi" class="col-sm-3 col-form-label" style="text-align:left">Kalori 
                                                <br><font color="red">*Wajib Isi jumlah kalori (rujuk buku panduan menu)</font> </label>
                                            <div class="col-sm-3">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="kalori_pagi" name="kalori_pagi"
                                                        placeholder="Kalori" min="1" max="40"
                                                        value="{{ old('kalori_pagi') }}" >
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card-footer">
                                            @if (!isset($tindakan))
                                                <button type="submit" name="makanpagi" class="btn btn-blue float-right btn-sm bg-blue"><i
                                                        class="fa fa-save"></i> | Simpan</button>
                                            @endif
                                        </div>

                                </div>
                            </div>
                        @else
                        @endif

                        @if ($tempahmakan->makan_tghari == '1')
                            {{-- Makan Tengahari Form --}}
                            <div class="makan_tengahari">
                                <div class="card-header bg-purple">
                                    <h3 class="card-title">Makan Tengahari</h3>
                                </div>
                                <div class="card-body" style="text-align:left"> 
                                    <div class="container">
                                        <table id="example2" class="table table-bordered">
                                        <thead bgcolor="CF9FFF">
                                        <tr>
                                            <th>Menu</th>
                                            <th>Kalori</th>
                                            <th>&nbsp;</th>
                                        </tr>
                                        </thead> 
                                        <tbody>
                                            @foreach ($menumakan as $menumakans)

                                                <!-- MODAL UBAH MENU MAKAN  -->
                                                <div class="modal fade" id="modal-makan-{{  $menumakans->id_menu_makan }}">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-purple">
                                                            <h5 class="modal-title">Kemaskini Menu Makanan</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                            </div>
                                                            {{-- <form class="form-horizontal" method="POST" action="{{ url('tempahanbilik/tindakan/simpan/ubahsuai_makanan/'.$menuMakan->id_menu_makan) }}" enctype="multipart/form-data"> --}}
                                                            <form class="form-horizontal" method="POST" action="{{ url('/tempahanbilik/kemaskini/simpan_makanan/' . $tempahmakan->id_tempah_makan) }}" enctype="multipart/form-data">
                                                                {{ csrf_field() }}
                                                                <div class="modal-body">

                                                                    <input type="hidden" name="id_menu_makan" value="{{ $menumakans->id_menu_makan }}">
                                                                    
                                                                    <div class="input-group mb-3">
                                                                        <label class="input-group-text" for="inputGroupSelect01">Menu</label>
                                                                        <div class="col-sm-6">
                                                                            <input type="text" name="menu_baru" id="menu_baru" class="form-control"
                                                                                value="{{ $menumakans->menu }}" required>
                                                                        </div>
                                                                    </div>

                                                                    <div class="input-group mb-3">
                                                                        <label class="input-group-text" for="inputGroupSelect01">Kalori</label>
                                                                        <div class="col-sm-6">
                                                                            <input type="text" name="kalori_baru" id="kalori_baru" class="form-control"
                                                                                value="{{ $menumakans->kalori }}" required>
                                                                        </div>
                                                                    </div>
                                                                    {{-- <input type="hidden" name="jenis_makan" value="{{ $menumakans->jenis_makan }}"> --}}

                                                                </div>

                                                                <div class="modal-footer justify-content-between">
                                                                    <span class="float-right">
                                                                        <button type="submit" class="btn btn-primary bg-purple" name="edit_makanan">Simpan</button>
                                                                    </span>
                                                                </div>

                                                            </form>
                                                        </div> <!-- /.modal-content -->
                                                    </div> <!-- /.modal-dialog -->
                                                </div>

                                                @if($menumakans->jenis_makan == '2')
                                                    <tr>
                                                        <td>{{ ($menumakans->menu) ?? '-' }}</td>
                                                        <td>{{ ($menumakans->kalori) ?? '-' }}</td>
                                                        <td align="center">
                                                            <a href="{{ route('tempahanbilik.hapus_makanan',$menumakans->id_menu_makan) }}" title="Buang" class="btn-sm btn-danger"> <i class="fa fa-trash"></i></a>
                                                            <a class="btn-sm btn-success" data-toggle="modal" data-target="#modal-makan-{{ $menumakans->id_menu_makan }}"><i class=""></i> <i class="fa fa-pen"></i></a>
                                                        </td>
                                                    </tr>
                                                @endif       
                                        @endforeach 
                                        </tbody>
                                        </table>
                                    </div> 
                                    
                                        <div class="form-group row">
                                            <label for="id_jenis_hidangan2" class="col-sm-3 col-form-label" style="text-align:left">Jenis Hidangan</label>
                                            <div class="col-sm-3">
                                            
                                                <select class="form-control select2" id="id_jenis_hidangan2" name="id_jenis_hidangan2" style="width: 100%;" >
                                                    @php old('id_jenis_hidangan2') == NULL ? $jenis2=$tempahmakan->id_jenis_hidangan2 : $jenis2=old('id_jenis_hidangan2') @endphp
                                                    <option value=""
                                                        @if ($jenis2 == '') {{ 'selected="selected"' }} @endif>&nbsp;
                                                    </option>
                                                    @foreach ($optJenisHidangans as $optJenisHidangan)
                                                        <option value="{{ $optJenisHidangan->id_jenis_hidangan }}"
                                                            @if ($jenis2 == $optJenisHidangan->id_jenis_hidangan) {{ 'selected="selected"' }} @endif>
                                                            {{ $optJenisHidangan->jenis_hidangan }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="input_tengahari" class="col-sm-3 col-form-label" style="text-align:left">Menu</label>
                                            <div class="col-sm-22">
                                                <div class="input-group">
                                                    <input type="hidden" name="jenis_makan2" value="2"> 
                                                    <input type="hidden" name="id_makan2" value="{{ $tempahmakan->id_tempah_makan }}">
                                                    {{-- <input type="text" class="form-control" id="input_tengahari" name="input_tengahari"
                                                        placeholder="Menu Makan" min="1" max="40"
                                                        value="{{ old('input_tengahari') }}" > --}}
                                                    <textarea name="input_tengahari" class="form-control" id="input_tengahari" cols="30" rows="2" placeholder="Menu Makan">{{ old('input_tengahari') }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        
                                         <div class="form-group row">
                                            <label for="kalori_tengahari" class="col-sm-3 col-form-label" style="text-align:left">Kalori
                                                <br><font color="red">*Wajib Isi jumlah kalori (rujuk buku panduan menu)</font></label>
                                            <div class="col-sm-22">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="kalori_tengahari" name="kalori_tengahari"
                                                        placeholder="Kalori" min="1" max="40"
                                                        value="{{ old('kalori_tengahari') }}" >
                                                </div>
                                            </div>
                                        </div>
                                       
                                        <div class="card-footer">
                                            @if (!isset($tindakan))
                                                <button type="submit" name="makantengahari" class="btn btn-blue float-right btn-sm bg-blue"><i
                                                        class="fa fa-save"></i> | Simpan</button>
                                            @endif
                                        </div>

                                </div>
                            </div>
                        @else
                        @endif

                        @if ($tempahmakan->minum_petang == '1')
                            {{-- Makan Petang Form --}}
                            <div class="makan_petang">
                                <div class="card-header bg-purple">
                                    <h3 class="card-title">Makan Petang</h3>
                                </div>
                                <div class="card-body" style="text-align:left"> 
                                    <div class="container">
                                        <table id="example2" class="table table-bordered">
                                        <thead bgcolor="CF9FFF">
                                        <tr>
                                            <th>Menu</th>
                                            <th>Kalori</th>
                                            <th>&nbsp;</th>
                                        </tr>
                                        </thead> 
                                        <tbody>
                                            @foreach ($menumakan as $menumakans)
                                                <!-- MODAL UBAH MENU MAKAN  -->
                                                <div class="modal fade" id="modal-makan-{{  $menumakans->id_menu_makan }}">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-purple">
                                                            <h5 class="modal-title">Kemaskini Menu Makanan</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                            </div>
                                                            {{-- <form class="form-horizontal" method="POST" action="{{ url('tempahanbilik/tindakan/simpan/ubahsuai_makanan/'.$menuMakan->id_menu_makan) }}" enctype="multipart/form-data"> --}}
                                                            <form class="form-horizontal" method="POST" action="{{ url('/tempahanbilik/kemaskini/simpan_makanan/' . $tempahmakan->id_tempah_makan) }}" enctype="multipart/form-data">
                                                                {{ csrf_field() }}
                                                                <div class="modal-body">

                                                                    <input type="hidden" name="id_menu_makan" value="{{ $menumakans->id_menu_makan }}">
                                                                    
                                                                    <div class="input-group mb-3">
                                                                        <label class="input-group-text" for="inputGroupSelect01">Menu</label>
                                                                        <div class="col-sm-6">
                                                                            <input type="text" name="menu_baru" id="menu_baru" class="form-control"
                                                                                value="{{ $menumakans->menu }}" required>
                                                                        </div>
                                                                    </div>

                                                                    <div class="input-group mb-3">
                                                                        <label class="input-group-text" for="inputGroupSelect01">Kalori</label>
                                                                        <div class="col-sm-6">
                                                                            <input type="text" name="kalori_baru" id="kalori_baru" class="form-control"
                                                                                value="{{ $menumakans->kalori }}" required>
                                                                        </div>
                                                                    </div>
                                                                    {{-- <input type="hidden" name="jenis_makan" value="{{ $menumakans->jenis_makan }}"> --}}

                                                                </div>

                                                                <div class="modal-footer justify-content-between">
                                                                    <span class="float-right">
                                                                        <button type="submit" class="btn btn-primary bg-purple" name="edit_makanan">Simpan</button>
                                                                    </span>
                                                                </div>

                                                            </form>
                                                        </div> <!-- /.modal-content -->
                                                    </div> <!-- /.modal-dialog -->
                                                </div>

                                                @if($menumakans->jenis_makan == '3')
                                                    <tr>
                                                        <td>{{ ($menumakans->menu) ?? '-' }}</td>
                                                        <td>{{ ($menumakans->kalori) ?? '-' }}</td>
                                                        <td align="center">
                                                            <a href="{{ route('tempahanbilik.hapus_makanan',$menumakans->id_menu_makan) }}" title="Buang" class="btn-sm btn-danger"> <i class="fa fa-trash"></i></a>
                                                            <a class="btn-sm btn-success" data-toggle="modal" data-target="#modal-makan-{{ $menumakans->id_menu_makan }}"><i class=""></i> <i class="fa fa-pen"></i></a>
                                                        </td>
                                                    </tr>
                                                @endif       
                                        @endforeach 
                                        </tbody>
                                        </table>
                                    </div> 

                                        <div class="form-group row">
                                            <label for="id_jenis_hidangan3" class="col-sm-3 col-form-label" style="text-align:left">Jenis Hidangan</label>
                                            <div class="col-sm-3">
                                            
                                                <select class="form-control select2" id="id_jenis_hidangan3" name="id_jenis_hidangan3" style="width: 100%;" >
                                                    @php old('id_jenis_hidangan3') == NULL ? $jenis3=$tempahmakan->id_jenis_hidangan3 : $jenis3=old('id_jenis_hidangan3') @endphp
                                                    <option value=""
                                                        @if ($jenis3 == '') {{ 'selected="selected"' }} @endif>&nbsp;
                                                    </option>
                                                    @foreach ($optJenisHidangans as $optJenisHidangan)
                                                        <option value="{{ $optJenisHidangan->id_jenis_hidangan }}"
                                                            @if ($jenis3 == $optJenisHidangan->id_jenis_hidangan) {{ 'selected="selected"' }} @endif>
                                                            {{ $optJenisHidangan->jenis_hidangan }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>
            
                                        <div class="form-group row">
                                            <label for="input_petang" class="col-sm-3 col-form-label" style="text-align:left">Menu</label>
                                            <div class="col-sm-3">
                                                <div class="input-group">
                                                    <input type="hidden" name="jenis_makan3" value="3">
                                                    <input type="hidden" name="id_makan3" value="{{ $tempahmakan->id_tempah_makan }}">
                                                    {{-- <input type="text" class="form-control" id="input_petang" name="input_petang"
                                                        placeholder="Menu Makan" min="1" max="40"
                                                        value="{{ old('input_petang') }}" > --}}
                                                    <textarea name="input_petang" class="form-control" id="input_petang" cols="30" rows="2" placeholder="Menu Makan">{{ old('input_petang') }}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="kalori_petang" class="col-sm-3 col-form-label" style="text-align:left">Kalori
                                                <br><font color="red">*Wajib Isi jumlah kalori (rujuk buku panduan menu)</font></label>
                                            <div class="col-sm-3">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="kalori_petang" name="kalori_petang"
                                                        placeholder="Kalori" min="1" max="40"
                                                        value="{{ old('kalori_petang') }}" >
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card-footer">
                                            @if (!isset($tindakan))
                                                <button type="submit" name="makanpetang" class="btn btn-blue float-right btn-sm bg-blue"><i
                                                        class="fa fa-save"></i> | Simpan</button>
                                            @endif
                                        </div>

                                </div>
                            </div>
                        @else
                        @endif

                        @if ($tempahmakan->makan_malam == '1')
                            {{-- Makan Malam Form --}}
                            <div class="makan_malam">
                                <div class="card-header bg-purple">
                                    <h3 class="card-title">Makan Malam</h3>
                                </div>
                                <div class="card-body" style="text-align:left"> 
                                    <div class="container">
                                        <table id="example2" class="table table-bordered">
                                        <thead bgcolor="CF9FFF">
                                        <tr>
                                            <th>Menu</th>
                                            <th>Kalori</th>
                                            <th>&nbsp;</th>
                                        </tr>
                                        </thead> 
                                        <tbody>
                                            @foreach ($menumakan as $menumakans)
                                                <!-- MODAL UBAH MENU MAKAN  -->
                                                <div class="modal fade" id="modal-makan-{{  $menumakans->id_menu_makan }}">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-purple">
                                                            <h5 class="modal-title">Kemaskini Menu Makanan</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                            </div>
                                                            {{-- <form class="form-horizontal" method="POST" action="{{ url('tempahanbilik/tindakan/simpan/ubahsuai_makanan/'.$menuMakan->id_menu_makan) }}" enctype="multipart/form-data"> --}}
                                                            <form class="form-horizontal" method="POST" action="{{ url('/tempahanbilik/kemaskini/simpan_makanan/' . $tempahmakan->id_tempah_makan) }}" enctype="multipart/form-data">
                                                                {{ csrf_field() }}
                                                                <div class="modal-body">

                                                                    <input type="hidden" name="id_menu_makan" value="{{ $menumakans->id_menu_makan }}">
                                                                    
                                                                    <div class="input-group mb-3">
                                                                        <label class="input-group-text" for="inputGroupSelect01">Menu</label>
                                                                        <div class="col-sm-6">
                                                                            <input type="text" name="menu_baru" id="menu_baru" class="form-control"
                                                                                value="{{ $menumakans->menu }}" required>
                                                                        </div>
                                                                    </div>

                                                                    <div class="input-group mb-3">
                                                                        <label class="input-group-text" for="inputGroupSelect01">Kalori</label>
                                                                        <div class="col-sm-6">
                                                                            <input type="text" name="kalori_baru" id="kalori_baru" class="form-control"
                                                                                value="{{ $menumakans->kalori }}" required>
                                                                        </div>
                                                                    </div>
                                                                    {{-- <input type="hidden" name="jenis_makan" value="{{ $menumakans->jenis_makan }}"> --}}

                                                                </div>

                                                                <div class="modal-footer justify-content-between">
                                                                    <span class="float-right">
                                                                        <button type="submit" class="btn btn-primary bg-purple" name="edit_makanan">Simpan</button>
                                                                    </span>
                                                                </div>

                                                            </form>
                                                        </div> <!-- /.modal-content -->
                                                    </div> <!-- /.modal-dialog -->
                                                </div>

                                                @if($menumakans->jenis_makan == '4')
                                                    <tr>
                                                        <td>{{ ($menumakans->menu) ?? '-' }}</td>
                                                        <td>{{ ($menumakans->kalori) ?? '-' }}</td>
                                                        <td align="center">
                                                            <a href="{{ route('tempahanbilik.hapus_makanan',$menumakans->id_menu_makan) }}" title="Buang" class="btn-sm btn-danger"> <i class="fa fa-trash"></i></a>
                                                            <a class="btn-sm btn-success" data-toggle="modal" data-target="#modal-makan-{{ $menumakans->id_menu_makan }}"><i class=""></i> <i class="fa fa-pen"></i></a>
                                                        </td>
                                                    </tr>
                                                @endif       
                                        @endforeach 
                                        </tbody>
                                        </table>
                                    </div> 

                                        <div class="form-group row">
                                            <label for="id_jenis_hidangan4" class="col-sm-3 col-form-label" style="text-align:left">Jenis Hidangan</label>
                                            <div class="col-sm-3">
                                            
                                                <select class="form-control select2" id="id_jenis_hidangan4" name="id_jenis_hidangan4" style="width: 100%;" >
                                                    @php old('id_jenis_hidangan4') == NULL ? $jenis4=$tempahmakan->id_jenis_hidangan4 : $jenis4=old('id_jenis_hidangan4') @endphp
                                                    <option value=""
                                                        @if ($jenis4 == '') {{ 'selected="selected"' }} @endif>&nbsp;
                                                    </option>
                                                    @foreach ($optJenisHidangans as $optJenisHidangan)
                                                        <option value="{{ $optJenisHidangan->id_jenis_hidangan }}"
                                                            @if ($jenis4 == $optJenisHidangan->id_jenis_hidangan) {{ 'selected="selected"' }} @endif>
                                                            {{ $optJenisHidangan->jenis_hidangan }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>
            
                                        <div class="form-group row">
                                            <label for="input_malam" class="col-sm-3 col-form-label" style="text-align:left">Menu</label>
                                            <div class="col-sm-3">
                                                <div class="input-group">
                                                    <input type="hidden" name="jenis_makan4" value="4">
                                                    <input type="hidden" name="id_makan4" value="{{ $tempahmakan->id_tempah_makan }}">
                                                    {{-- <input type="text" class="form-control" id="input_malam" name="input_malam"
                                                        placeholder="Menu Makan" min="1" max="40"
                                                        value="{{ old('input_malam') }}" > --}}
                                                    <textarea name="input_malam" class="form-control" id="input_malam" cols="30" rows="2" placeholder="Menu Makan">{{ old('input_malam') }}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="kalori_malam" class="col-sm-3 col-form-label" style="text-align:left">Kalori
                                                <br><font color="red">*Wajib Isi jumlah kalori (rujuk buku panduan menu)</font></label>
                                            <div class="col-sm-3">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="kalori_malam" name="kalori_malam"
                                                        placeholder="Kalori" min="1" max="40"
                                                        value="{{ old('kalori_malam') }}" >
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card-footer">
                                            @if (!isset($tindakan))
                                                <button type="submit" name="makanmalam" class="btn btn-blue float-right btn-sm bg-blue"><i
                                                        class="fa fa-save"></i> | Simpan</button>
                                            @endif
                                        </div>

                                </div>
                            </div>
                        @else
                        @endif
                    @endif
                    
                    <!-- <hr> -->
                    <div class="card-footer justify-content-center">
                            <button type="submit" name="hantar" class="btn btn-purple float-left btn-sm bg-purple"><i
                                    class="fa fa-paper-plane"></i> | Selesai</button>
                        {{-- <button type="button" class="btn btn-default float-right btn-sm" onclick="history.back();"><i
                                class="fas fa-redo-alt"></i> | Kembali</button> --}}
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

		$(document).on('change','#jenis_perjalanan',function(){
			var tkh_balik = $('input[name="tkh_balik"]');
			var masa_balik = $('input[name="masa_balik"]');

			if (this.value == '1') {
				tkh_balik.prop("disabled", true); //disable field
				masa_balik.prop("readonly", true); //disable field
				tkh_balik.val('').prop("removed", true).focus();
				masa_balik.val('').prop("removed", true).focus();

			} else {
				tkh_balik.prop("disabled", false); //enable field
				masa_balik.prop("readonly", false); //enable field
			}
		});
		
	});

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

