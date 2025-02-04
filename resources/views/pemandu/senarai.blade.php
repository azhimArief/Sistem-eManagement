@extends('layouts/master')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">PEMANDU</h1>
          </div><!-- /.col -->
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/home') }}">Laman Utama</a></li>
              <li class="breadcrumb-item">Pemandu</li>
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
                <h2 class="card-title" style="margin-top:5px;">Senarai Pemandu</h2>
                  <span class="float-right">
                    <!-- <a class="btn btn-sm" data-toggle="modal" data-target="#modal-default"><i class="fa fa-filter"></i> Tapis</a> -->
                    <a href="{{ url('pemandu/tambah') }}" class="btn btn-sm"><i class="fa fa-plus"></i> Tambah</a>
                </span>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <div class="card-body table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                  <thead  bgcolor ="#CF9FFF">
                  <tr>
                    <th>Bil.</th>
                    <th>No Kad Pengenalan</th>
                    <th>Nama</th>
                    <th>Bahagian</th>
                    <th>Gred</th>
                    <th><center>Status</center></th>
                    <th width="10%">&nbsp;</th>
                  </tr>
                  </thead>
                  <tbody>
				          @foreach ($pemandus as $pemandu)
                  <tr>
                    <td>&nbsp;</td>
                    <td>
                      <a href="{{ url('pemandu/butiran',$pemandu->mykad) }}">{{ $pemandu->mykad }}</a><br/>
                      <?php //small>{{ $Pemandu->keterangan }}</small?>
                    </td>
                    <td>{{ $pemandu->nama_pemandu }}</td>
                    <td>{{ $pemandu->bahagian }}</td>
                    <td>{{ $pemandu->gred_pemandu }}</td>
                    <td><center><i class='fas fa-user-alt' @if ( $pemandu->status==9) style='color: green' title="Aktif" @else style='color: red' title="Tidak Aktif" @endif>  </i></center></td>
                    <td>
                      <a href="{{ url('pemandu/kemaskini',$pemandu->mykad) }}" class="btn-sm btn-primary" title="Kemaskini"><i class="fa fa-edit"></i></a>
                      <a href="{{ url('pemandu/hapus',$pemandu->mykad) }}" class="btn-sm btn-danger" title="Hapus"><i class="fa fa-trash"></i></a>
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

