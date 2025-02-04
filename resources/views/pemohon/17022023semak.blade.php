@extends('layouts.masterScreen')

@push('css')
<style type="text/css">
body {
  font-family: cursive !important;
}

a.disabled1:hover {
  cursor: not-allowed;
}
</style>
@endpush
@section('content')
<style type="text/css">

</style>

<div class="container">
  <br>
  <!-- Content Header (Page header) -->
  <div class="col-sm-12">
    <div class="row mb-2">
      <div class="col-sm-12">
        <button type="button" class="btn btn-purple btn-block bg-purple"><h5>SEMAK STATUS TEMPAHAN</h5></button>
      </div>
    </div>
  </div>
  <!-- /.content-header -->

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


          <!-- general form elements disabled -->
          <div class="card card-info">
            <div class="card-header bg-purple">
              <h3 class="card-title">Maklumat Pegawai</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="form-group row">
                <dt class="col-sm-2">Nama Pegawai</dt>
                <dd class="col-sm-10">{{ ($pemohon->nama!='') ? $pemohon->nama : $pemohon->name }}</dd>
              </div>
              <!-- <div class="form-group row">
              <dt class="col-sm-3">Permohonan Bagi Pihak</dt>
              <dd class="col-sm-9">{{ ($pemohon->pohon_bagi!='') ? $pemohon->pohon_bagi: '-' }}</dd>
              </div> -->
              <div class="form-group row">
                <dt class="col-sm-2">Jawatan</dt>
                <dd class="col-sm-4">{{ $pemohon->jawatan }}</dd>
                <dt class="col-sm-2">Gred</dt>
                <dd class="col-sm-4">{{ $pemohon->gred }}</dd>
              </div>
              <div class="form-group row">
                <dt class="col-sm-2">Bahagian</dt>
                <dd class="col-sm-4">{{ ($pemohon->bahagian!='') ? $pemohon->bahagian : \App\PLkpBahagian::find($pemohon->bahagian_id)->bahagian }}</dd>
                <dt class="col-sm-2">E-mel</dt>
                <dd class="col-sm-4">{{ ($pemohon->emel!='') ? $pemohon->emel : $pemohon->email }}</dd>
              </div>
              <div class="form-group row">
                <dt class="col-sm-2">No. Tel. Pejabat</dt>
                <dd class="col-sm-4">{{ $pemohon->telefon ?? $pemohon->tel ?? $personel->tel }}</dd>
                <dt class="col-sm-2">No. Tel. Bimbit</dt>
                <dd class="col-sm-4">{{ $pemohon->tel_bimbit ?? $personel->tel_bimbit }}</dd>
                
              </div> 
            </div>	
            
          </div>
          <!-- card -->

          <div class="card card-info card-tabs">
            <div class="card-header p-0 pt-1 bg-purple">
              <ul class="nav nav-tabs nav-justified" id="custom-tabs-one-tab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="custom-tabs-one-kenderaan-tab" data-toggle="pill" href="#custom-tabs-one-kenderaan" role="tab" aria-controls="custom-tabs-one-kenderaan" aria-selected="true"><strong>SENARAI TEMPAHAN KENDERAAN</strong></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link disabled1" id="custom-tabs-one-bilik-tab" data-toggle="pill" href="#custom-tabs-one-bilik" role="tab" aria-controls="custom-tabs-one-bilik" aria-selected="true"><strong>SENARAI TEMPAHAN BILIK</strong></a>
                </li>
              </ul>
            </div>

            <div class="card-body">
              <div class="tab-content" id="custom-tabs-one-tabContent">

                <div class="tab-pane fade show active" id="custom-tabs-one-kenderaan" role="tabpanel" aria-labelledby="custom-tabs-one-kenderaan-tab">

                  <!-- /.card-header -->
                  <!-- form start -->
                  <div class="card-body table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                      <thead bgcolor="CF9FFF">
                        <tr>
                          <th>Bil.</th>
                          <th>ID Tempahan</th>
                          <th>Tujuan</th>
                          <th>Lokasi</th>
                          <th>Jenis Perjalanan</th>
                          <th>Tarikh Permohonan</th>
                          <th>Status</th>
                          <th width="10%">&nbsp;</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($permohonanKenderaans as $permohonanKenderaan)
                        <tr>
                          <th scope="row">{{ $loop->iteration }}</th>
                          <td><a href="{{ url('pemohon/tempahankenderaan/butiran',$permohonanKenderaan->id_maklumat_permohonan) }}" title="Butiran">{{ $permohonanKenderaan->kod_permohonan }}</a></td>
                          <td>{{ ($permohonanKenderaan->id_tujuan!='') ?\App\LkpTujuan::find($permohonanKenderaan->id_tujuan)->tujuan : '-' }}</td>
                          <td>{{ $permohonanKenderaan->lokasi_tujuan }}{{ ($permohonanKenderaan->id_negeri!='') ? ', '.\App\RLkpNegeri::find($permohonanKenderaan->id_negeri)->negeri : '' }} </td>
                          <td>{{ ($permohonanKenderaan->id_jenis_perjalanan!='') ?\App\LkpJenisPerjalanan::find($permohonanKenderaan->id_jenis_perjalanan)->jenis_perjalanan : '' }}</td>
                          <td>{{ Carbon\Carbon::parse($permohonanKenderaan->created_by)->format('d.m.Y') }}</td>
                 
                          <?php
                            $status = $permohonanKenderaan->id_status;
                            $color = ""; 
                            switch($status){
                              //permohonan baru
                              case "1": $color="#FFB300"; $status="Dalam Proses"; break; //kuning
                              //telah dikemaskini
                              case "2": $color="#FFB300"; $status="Dalam Proses"; break; //biru
                              //lulus
                              case "3":  $color="#32CD32"; $status="Lulus"; break; //hijau
                              //Tidak Diluluskan
                              case "4": $color="#FF0000"; $status="Tidak Diluluskan"; break; //merah
                              //semak semula
                              case "5": $color="#2C87F0"; $status="Semak Semula"; break; //biru
                              //batal
                              case "6": $color="#CC3300"; $status="Batal"; break; //merah pekat
                              //sah
                              case "11": $color="#006400"; $status="Disahkan"; break; //hijau pekat
                              default : $color="#000000";

                            }
                          ?>
                          <td style ="color:{{$color}};">{{ $status }}</td>
                          <td align="center">
                            @if ($permohonanKenderaan->id_status == 1 || $permohonanKenderaan->id_status == 2 || $permohonanKenderaan->id_status == 5 )
                            <a href="{{route('pemohon.kemaskini_tempahankenderaan', ['id' => $permohonanKenderaan->id_maklumat_permohonan ])}}" title="Kemaskini" class="btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                            <a href="{{ route('pemohon.batal_tempahankenderaan',$permohonanKenderaan->id_maklumat_permohonan) }}" title="Batal" class="btn-sm btn-danger"><i class="fa fa-ban"></i></a>
                            @else
                            <!-- <a href="{{ url('pemohon/penilaian',$pemohon->mykad) }}" title="Penilaian Kenderaan" class="btn-sm btn-warning"><i class="fa fa-list"></i></a> -->
                            <a href="{{ url('pemohon/tempahankenderaan/butiran',$permohonanKenderaan->id_maklumat_permohonan) }}" title="Butiran" class="btn-sm btn-dark bg-navy"><i class="fa fa-eye"></i></a>
                            @endif
                            <!-- <a href="{{ url('penilaian/kenderaan',$permohonanKenderaan->id_maklumat_permohonan) }}" title="Penilaian Kenderaan" class="btn-sm btn-warning"><i class="fa fa-list"></i></a> -->
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                    <!-- /.card-body -->
                  </div>
                </div>
                <!--/.col (right) -->

                <div class="tab-pane fade" id="custom-tabs-one-bilik" role="tabpanel" aria-labelledby="custom-tabs-one-bilik-tab">
                  <div class="card-body table-responsive">
                     <table id="example2" class="table table-bordered table-striped">
                      <thead bgcolor="CF9FFF">
                        <tr>
                          <th>Bil.</th>
                          <th>ID Tempahan</th>
                          <th>Nama Bilik</th>
                          <th>Tujuan</th>
                          <th>Tarikh Mula</th>
                          <th>Tarikh Akhir</th>
                          <th>Status</th>
                          <th></th>
                        </tr>
                      </thead> 
                      <tbody>
                        @foreach ($permohonanBiliks as $permohonanBilik) 
                        <tr>
                          <td><center>{{ $loop->iteration }}.</center></td>
                          {{-- <td><center><a href="{{ url('pemohon/tempahanbilik/butiran',$permohonanBilik->id_permohonan_bilik, $pemohon->id_pmohon) }}" title="Butiran">{{ $permohonanBilik->kod_permohonan }}</a></center></td> --}}
                          {{-- <td><center><a href="pemohon/tempahanbilik/butiran/{{ $permohonanBilik->id_permohonan_bilik }}/{{  $pemohon->id_pemohon }}" title="Butiran">{{ $permohonanBilik->kod_permohonan }}</a></center></td> --}}
                          <td><center><a href="{{ route('pemohon.butiran_tempahanbilik', ['id' => $permohonanBilik->id_permohonan_bilik, 'id2' => $pemohon->id_pemohon]) }}" title="Butiran">{{ $permohonanBilik->kod_permohonan }}</a></center></td>
                            <td>{{ ($permohonanBilik->id_pemohon!='') ? \App\LkpBilik::find($permohonanBilik->id_bilik)->bilik : '-' }}</td>
                            <td>{{ ($permohonanBilik->id_tujuan!='') ? \App\LkpTujuan::find($permohonanBilik->id_tujuan)->tujuan : '-' }}</td>
                            <td><center>{{ Carbon\Carbon::parse($permohonanBilik->tkh_mula)->format('d.m.Y') }}</center></td>
                            <td><center>{{ Carbon\Carbon::parse($permohonanBilik->tkh_hingga)->format('d.m.Y') }}</center></td>
                            <?php
                               $status = $permohonanBilik->id_status;
                               $color = ""; 
                               switch($status){
                              //permohonan baru
                              case "1": $color="#FFB300"; $status="Permohonan Baru"; break; //kuning
                              //telah dikemaskini
                              case "2": $color="#2D04CE"; $status="Dalam Proses"; break; //biru pekat
                              //lulus
                              case "3":  $color="#32CD32"; $status="Lulus"; break; //hijau
                              //Tidak Diluluskan
                              case "4": $color="#FF0000"; $status="Tidak Diluluskan"; break; //merah
                              //semak semula
                              case "5": $color="#2C87F0"; $status="Semak Semula"; break; //biru
                              //batal
                              case "6": $color="#CC3300"; $status="Batal"; break; //merah pekat
                              //sah
                              case "11": $color="#006400"; $status="Disahkan"; break; //hijau pekat
                              default : $color="#000000"; //hitam

                            }
                          ?>
                          <td style ="color:{{$color}};">{{ $status }}</td>
                          <td align="center">
                            @if ($permohonanBilik->id_status == 1 || $permohonanBilik->id_status == 5 )
                            <a href="{{ route('pemohon.kemaskini_tempahanbilik', ['id' => $permohonanBilik->id_permohonan_bilik ])}}" title="Kemaskini" class="btn-sm btn-warning"><i class="fa fa-pencil-alt"></i></a>
                            <a href="{{ route('pemohon.batal_tempahanbilik',$permohonanBilik->id_permohonan_bilik) }}" title="Batal" class="btn-sm btn-danger"><i class="fa fa-ban"></i></a>
                            @else
                            <!-- <a href="{{ url('pemohon/penilaian',$pemohon->mykad) }}" title="Penilaian Kenderaan" class="btn-sm btn-warning"><i class="fa fa-list"></i></a> -->
                            <center><a href="{{ route('pemohon.butiran_tempahanbilik', ['id' => $permohonanBilik->id_permohonan_bilik, 'id2' => $pemohon->id_pemohon]) }}" title="Butiran" class="btn-sm btn-dark bg-navy"><i class="fa fa-eye"></i></a></center>
                            {{-- <a href="{{ url('pemohon/tempahanbilik/butiran',$permohonanBilik->id_permohonan_bilik) }}" title="Butiran" class="btn-sm btn-dark bg-navy"><i class="fa fa-eye"></i></a> --}}
                            @endif
                          </td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>                 
                  </div>
                </div>

              </div><!-- /.tab content -->
              <div class="card-footer">
                {{-- <button type="button" class="btn btn-default float-right btn-sm" onclick="history.back();"><i class="fas fa-redo-alt"></i> | Kembali</button> --}}
                {{-- <a href="{{ url('search',$personel->nokp) }}" class="btn btn-sm btn-default float-right" title="Laman Utama"><i class="fa fa-home"></i> | Laman Utama</a> --}}
                <a href="{{ url('search',$personel->nokp) }}" class="btn btn-sm btn-default float-right"><i class="fas fa-redo-alt"></i> | Kembali </a>

              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card-body -->
          </div>
        </div>
        
      </div>
      <!-- /.row -->
    </div>
  </section>
</div><!-- /.container-->
      <!--  -->
@endsection

  @section ('script')

  <script>
  $(function () {
    $('#example1').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
      "pageLength": 5,

      language: {
                    search: "Cari :",
                    zeroRecords:    "Tiada rekod yang sepadan ditemui",
                    zeroRecords:    "Tiada data",
                }
    });

    $('#example2').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
      "pageLength": 5,

      language: {
                    search: "Cari :",
                    zeroRecords:    "Tiada rekod yang sepadan ditemui",
                    zeroRecords:    "Tiada data",
                }
    });

  });

</script>

@endsection
