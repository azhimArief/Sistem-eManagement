@extends('layouts/master')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Hapus Pengguna</h1>
          </div><!-- /.col -->
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/home') }}">Laman Utama</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/pengguna') }}">Pengguna</a></li>
              <li class="breadcrumb-item active">Hapus</li>
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
			
			 <form class="form-horizontal" method="POST" action="{{ url('pengguna/hapus/'.$user->id) }}" enctype="multipart/form-data">
			 {{ csrf_field() }}
            <!-- Horizontal Form -->
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Maklumat Pengguna</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <div class="card-body">
				<dl class="row">
					<dt class="col-sm-3">No. Mykad</dt>
					<dd class="col-sm-9">{{ $user->mykad }}</dd>
					<dt class="col-sm-3">Nama</dt>
					<dd class="col-sm-9">{{ $user->nama }}</dd>
					<dt class="col-sm-3">Bahagian</dt>
					<dd class="col-sm-9">{{ $user->bahagian }}</dd>
					<dt class="col-sm-3">Jawatan</dt>
					<dd class="col-sm-9">{{ $user->jawatan }}</dd>
					<dt class="col-sm-3">Emel</dt>
					<dd class="col-sm-9">{{ $user->email }}</dd>
					<dt class="col-sm-3">Status</dt>
					<dd class="col-sm-9">{{ ($user->status_akaun!='') ? \App\LkpStatusRisi::find($user->status_akaun)->jenis_status_risi : '' }}</dd>
					<dt class="col-sm-3">Peranan</dt>
					<dd class="col-sm-9"></dd>
				</dl>
            </div>
				
			<div class="card-header">
				<h3 class="card-title">Maklumat Login</h3>
			</div>
			<div class="card-body">
				<dl class="row">
					<dt class="col-sm-3">ID Pengguna</dt>
					<dd class="col-sm-9">{{ $user->id_pengguna }}</dd>
					<dt class="col-sm-3">Kata Laluan</dt>
					<dd class="col-sm-3">************</dd>
				</dl>
            </div>		
				
			<!-- /.card-body -->
			<div class="card-footer">
			  <span class="text-danger">Anda pasti ingin hapuskan Pengguna ini?</span> &nbsp;
			  <button type="submit" name="hapus_pengguna" class="btn btn-danger">Ya, Hapus</button>
			  <button type="button" class="btn btn-default" onclick="history.back();">Tidak</button>
			</div>
                <!-- /.card-footer -->
            <!-- /.card -->
          </div>
		  </form>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    
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
	  });
	</script>
@endsection

