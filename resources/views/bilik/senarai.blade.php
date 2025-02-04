@extends('layouts/master')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">BILIK </h1>
          </div><!-- /.col -->
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/homeBilikMeet') }}">Laman Utama</a></li>
              <li class="breadcrumb-item">Bilik</li>
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
                <h2 class="card-title" style="margin-top:5px;">Senarai Bilik</h2>
                  <span class="float-right">
                    <a class="btn btn-sm" data-toggle="modal" data-target="#modal-default"><i class="fa fa-filter"></i> Tapis</a>
                    <a href="{{ url('bilik/tambah') }}" class="btn btn-sm"><i class="fa fa-plus"></i> Tambah</a> 
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
                                    <th>Nama Bilik</th>
                                    <th>Kapasiti</th>
                                    <th>Aras</th>
                                    <th>Kemudahan Bilik</th>
                                    <th>Gambar Bilik</th>
                                    <th width="10%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($biliks as $bilik)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        {{-- <td>{{ $bilik->bilik }} ({{ $bilik->bahagian }})</td> --}}
                                        {{-- <td>{{ $bilik->bilik }} ({{ $bilik->bahagian }})</td> --}}
                                        <td><a href="{{ url('bilik/butiran', $bilik->id_bilik) }}" class=""> {{ $bilik->bilik }} ({{ $bilik->bahagian }}) </a></td>
                                        <td>{{ $bilik->kapasiti_bilik ?? '-' }}</td>
                                        <td>{{ $bilik->aras }} </td>
                                        <td>{{ $bilik->kemudahan_bilik ?? '-' }} </td>
                                        <td>
                                            @if ($bilik->gambar_bilik == null)
                                                -
                                            @else
                                                <center><a href="{{ url('' . $bilik->gambar_bilik) }}" target="_blank"><img
                                                        class="img-fluid mb-3" src="{{ url('' . $bilik->gambar_bilik) }}"
                                                        alt="Photo" width="60" height="60"></a>
                                                </center>
                                            @endif
                                        </td>
                                        <td> 
                                          <center>
                                            {{-- <a href="{{ url('bilik/butiran', $bilik->id_bilik) }}" class="btn-sm btn-info"><i class="fa fa-eye"></i></a> --}}
                                            <a href="{{ url('bilik/kemaskini', $bilik->id_bilik) }}" class="btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                            <a href="{{ url('bilik/hapus', $bilik->id_bilik) }}" class="btn-sm btn-danger"><i class="fa fa-trash"></i></a>
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
          <form class="form-horizontal" method="POST" action="{{ url('bilik') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="modal-body">

              <div class="form-group row">
                <label for="pilihAras" class="col-sm-4 col-form-label">Pilih Aras</label>
                <div class="col-sm-8">
                  <select class="custom-select" id="pilihAras" name="pilihAras">
                      <option value="" selected disabled>-- Pilih Aras --</option>
                      <option value="5">Aras 5</option>
                      <option value="6">Aras 6</option>
                      <option value="7">Aras 7</option>
                      <option value="8">Aras 8</option>
                      <option value="9">Aras 9</option>
                      <option value="10">Aras 10</option>
                  </select>
                </div>
              </div>

            </div>
            <div class="modal-footer justify-content-between">
              <span class="float-right">
                <a href="{{ url('bilik') }}" class="btn btn-default" name="tapis_reset">Reset</a>
                <button type="submit" class="btn btn-primary bg-purple" name="tapis_bilik">Tapis</button>
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

