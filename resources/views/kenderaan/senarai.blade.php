@extends('layouts/master')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">KENDERAAN</h1>
          </div><!-- /.col -->
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/home') }}">Laman Utama</a></li>
              <li class="breadcrumb-item">Kenderaan</li>
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
                <h2 class="card-title" style="margin-top:5px;">Senarai Kenderaan</h2>
				<span class="float-right">
					<a class="btn btn-sm" data-toggle="modal" data-target="#modal-default"><i class="fa fa-filter"></i> Tapis</a>
					<a href="{{ url('kenderaan/tambah') }}" class="btn btn-sm"><i class="fa fa-plus"></i> Tambah</a>
				</span>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <div class="card-body table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                  <thead bgcolor ="#CF9FFF">
                    <tr>
                      <th>Bil.</th>
                      <th>No. Kenderaan</th>
                      <th>Jenis</th>
                      <th>Model</th>
                      <th>Bil. Penumpang</th>
                      <th>Pemandu</th>
                      <th>Status</th>
                      <th width="10%">&nbsp;</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach ($kenderaans as $kenderaan)
                    <?php
                      // cari pemandu from kenderaan. kalau ada baru kelua
                      $driver = App\LkpPemandu::where('mykad',$kenderaan->pemandu)->first();
                      if($driver and $kenderaan->id_jenis != 3)
                      {
                        $nama_driver = $driver->nama_pemandu;
                      }
                    ?>
                    <tr>
                      <td>{{$loop->iteration}}</td>
                      <td>
                      <a href="{{ url('kenderaan/butiran',$kenderaan->id_kenderaan) }}">{{ $kenderaan->no_plat }}</a><br/>  
                      </td>
                      <td>{{ ($kenderaan->id_jenis!='') ? \App\LkpJenisKenderaan::find($kenderaan->id_jenis)->jenis_kenderaan : '' }}</td>
                      <td>{{ ($kenderaan->id_model!='') ? \App\LkpModel::find($kenderaan->id_model)->jenis_model : '' }}</td>
                      <td>{{ $kenderaan->Bil_penumpang }}</td>
                      {{-- if bus driver ignore name --}}
                      @if($kenderaan->id_jenis != 3)
                        {{-- kalau  --}}
                        <td>{{ $nama_driver }}</td>
                      @else
                        <td>-</td>
                      @endif
                      <td>{{ ($kenderaan->id_status!='') ? \App\LkpStatus::find($kenderaan->id_status)->status : '' }}</td>
                      <td>
                        <a href="{{ url('kenderaan/kemaskini',$kenderaan->id_kenderaan) }}" class="btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                        <a href="{{ url('kenderaan/hapus',$kenderaan->id_kenderaan) }}" class="btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
                <!-- /.card-body -->
            </div>
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
              <h4 class="modal-title">Tapis Senarai kenderaan</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="form-horizontal" method="POST" action="{{ url('kenderaan') }}" enctype="multipart/form-data">
              {{ csrf_field() }}
              <div class="modal-body">
                <div class="form-group row">
                  <label for="jenis" class="col-sm-4 col-form-label">Jenis kenderaan</label>
                  <div class="col-sm-8">
                    <select class="form-control select2" id="jenis" name="jenis" style="width: 100%;">
                      <option value="" @if($Srhfield['jenis']=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
                      @foreach ($optionJenisKenderaans as $optionJenisKenderaan)
                        <option value="{{ $optionJenisKenderaan->id_jenis_kenderaan }}" @if($Srhfield['jenis']==$optionJenisKenderaan->id_jenis_kenderaan) {{ 'selected="selected"' }} @endif>{{ $optionJenisKenderaan->jenis_kenderaan }}</option>
                      @endforeach
                    </select>
                  </div>
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
		  "responsive": true, "lengthChange": false, "autoWidth": false,
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

