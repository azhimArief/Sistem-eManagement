@extends('layouts/master')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Katerer </h1>
          </div><!-- /.col -->
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/homeBilikMeet') }}">Laman Utama</a></li>
              <li class="breadcrumb-item">Katerer</li>
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
                <h2 class="card-title" style="margin-top:5px;">Senarai Katerer</h2>
                  <span class="float-right">
                    {{-- <a class="btn btn-sm" data-toggle="modal" data-target="#modal-default"><i class="fa fa-filter"></i> Tapis</a> --}}
                    <a href="{{ url('katerer/tambah') }}" class="btn btn-sm"><i class="fa fa-plus"></i> Tambah</a> 
                  </span>
              </div>
              <!-- /.card-header -->
              <!-- form start -->

              <form role="form" action="" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="card-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped" data-url="json/data1.json"
                            data-filter-control="true" data-show-search-clear-button="true">
                            <thead bgcolor="CF9FFF">
                                <tr>
                                    <th>Bil.</th>
                                    <th>Nama Katerer</th>
                                    <th>Alamat</th>
                                    <th>Tarikh Mula</th>
                                    <th>Tarikh Tamat</th>
                                    <th width="10%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($katerers as $katerer)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><a href="{{ url('katerer/butiran', $katerer->id_katerer) }}" class=""> {{ $katerer->nama_katerer   }} </a></td>
                                        <td>{{ $katerer->alamat ?? '-' }}</td>
                                        <td>{{ ($katerer->tkh_mula!='') ? Carbon\Carbon::parse($katerer->tkh_mula)->format('d.m.Y') : '-' }}</td>
                                        <td>{{ ($katerer->tkh_tamat!='') ? Carbon\Carbon::parse($katerer->tkh_tamat)->format('d.m.Y') : '-' }}</td>
                                        <td>
                                          <center>
                                            {{-- <a href="{{ url('katerer/butiran', $katerer->id_katerer) }}" class="btn-sm btn-info"><i class="fa fa-eye"></i></a> --}}
                                            <a href="{{ url('katerer/kemaskini', $katerer->id_katerer) }}" class="btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                            <a href="{{ url('katerer/hapus', $katerer->id_katerer) }}" class="btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                          </center>
                                          
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- /.card-body -->
                    </div>

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
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-purple">
            <h4 class="modal-title">Tapis Senarai Bilik</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form class="form-horizontal" method="POST" action="{{ url('katerer') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="modal-body">

              <div class="form-group row">
                <label for="pilihAras" class="col-sm-4 col-form-label">Pilih Aras</label>
                <div class="col-sm-8">
                  <select class="form-control select2" id="pilihAras" name="pilihAras" style="width: 100%;">
                    {{-- <option value="" @if($Srhfield['pilihAras']=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
                    @foreach ($optionJenisKenderaans as $optionJenisKenderaan)
                      <option value="{{ $optionJenisKenderaan->id_jenis_kenderaan }}" @if($Srhfield['pilihAras']==$optionJenisKenderaan->id_jenis_kenderaan) {{ 'selected="selected"' }} @endif>{{ $optionJenisKenderaan->jenis_kenderaan }}</option>
                    @endforeach --}}
                  </select>
                </div>
              </div>

              <div class="form-group row">
                <label for="pilihBilik" class="col-sm-4 col-form-label">Pilih Bilik</label>
                <div class="col-sm-8">
                  <select class="form-control select2" id="pilihBilik" name="pilihBilik" style="width: 100%;">
                    {{-- <option value="" @if($Srhfield['pilihBilik']=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
                    @foreach ($optionJenisKenderaans as $optionJenisKenderaan)
                      <option value="{{ $optionJenisKenderaan->id_jenis_kenderaan }}" @if($Srhfield['pilihBilik']==$optionJenisKenderaan->id_jenis_kenderaan) {{ 'selected="selected"' }} @endif>{{ $optionJenisKenderaan->jenis_kenderaan }}</option>
                    @endforeach --}}
                  </select>
                </div>
                
                <p>Masih dalam pembangunan</p>
              </div>

            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
              <span class="float-right">
                <a href="{{ url('kenderaan') }}" class="btn btn-default" name="tapis_risi">Reset</a>
                <button type="submit" class="btn btn-primary bg-purple" name="tapis_kenderaan">Tapis</button>
              </span>
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
		$("#example1").DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "responsive": true,
      "pageLength": 10,
		  "fnDrawCallback": function ( oSettings ) {
				/* Need to redo the counters if filtered or sorted */
				if ( oSettings.bSorted || oSettings.bFiltered )
				{
					for ( var i=0, iLen=oSettings.aiDisplay.length ; i<iLen ; i++ )
					{
						$('td:eq(0)', oSettings.aoData[ oSettings.aiDisplay[i] ].nTr ).html( i+1 );
					}
				}
			}
		}).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
		
		

		$('.toastsDefaultDefault').click(function() {
		  $(document).Toasts('create', {
			title: 'Toast Title',
			body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
		  })
		});
	  });
	</script>
@endsection

