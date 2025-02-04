@extends('layouts/master')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">PENGGUNA</h1>
          </div><!-- /.col -->
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/home') }}">Laman Utama</a></li>
              <li class="breadcrumb-item">Pengguna</li>
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
                <h2 class="card-title" style="margin-top:5px;">Senarai Pengguna</h2>
                <span class="float-right">
                  <!-- <a class="btn btn-sm" data-toggle="modal" data-target="#modal-default"><i class="fa fa-filter"></i> Tapis</a> -->
                  <a href="{{ url('pengguna/tambah') }}" class="btn btn-sm"><i class="fa fa-plus"></i> Tambah</a>
                </span>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <div class="card-body table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                  <thead bgcolor ="#CF9FFF">
                  <tr>
                    <th>Bil.</th>
                    <th>Mykad</th>
                    <th>Nama</th>
                    <th>Bahagian</th>
                    <th>Peranan</th>
                    <th>Status</th>
                    <th>&nbsp;</th>
                    {{-- <th width="10%">&nbsp;</th> --}}
                  </tr>
                  </thead>
                  <tbody>
				          @foreach ($users as $user)
                  <tr>
                    <td>&nbsp;</td>
                    <td><a href="{{ url('pengguna/butiran',$user->id) }}">{{ $user->mykad }}</a></td>
                    <td>{{ $user->nama }}</td>
                    <td>{{ $user->bahagian }}</td>
                    <td>{{ ($user->id_access!='') ? \App\LkpAccess::find($user->id_access)->access_type : '' }}</td>
                    <td>{{ ($user->status_akaun!='') ? \App\LkpStatus::find($user->status_akaun)->status : '' }}</td>
                    <td>
                      <a href="{{ url('pengguna/kemaskini',$user->id) }}" class="btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                      {{-- <a href="{{ url('pengguna/hapus',$user->id) }}" class="btn-sm btn-danger"><i class="fa fa-trash"></i></a> --}}
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
              <h4 class="modal-title">TAPIS SENARAI PENGGUNA</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
			<form class="form-horizontal" method="POST" action="{{ url('pengguna') }}" enctype="multipart/form-data">
			  {{ csrf_field() }}
				<div class="modal-body">
				  <div class="form-group row">
					<label for="status" class="col-sm-3 col-form-label">Status</label>
					<div class="col-sm-9" style="margin-top:7px;">
						@foreach ($optStatusUsers as $optStatusUser)
						<input type="radio" name="status" id="{{ $optStatusUser->status }}" value="{{ $optStatusUser->id_status }}" @if($Srhfield['status']==$optStatusUser->id_status) {{ 'checked="checked"' }} @endif> <label class="form-check-label" for="{{ $optStatusUser->status }}">{{ $optStatusUser->status }}</label> &nbsp;&nbsp;&nbsp;
						@endforeach
					</div>
				  </div>
				</div>
				<div class="modal-footer justify-content-between">
				  <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
				  <span class="float-right">
					  <a href="{{ url('pengguna') }}" class="btn btn-default" name="tapis_risi">Reset</a>
					  <button type="submit" class="btn btn-primary bg-purple" name="tapis_pengguna">Tapis</button>
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

