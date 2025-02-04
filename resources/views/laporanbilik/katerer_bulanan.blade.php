@extends('layouts/master')
@section('content')

<head>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
</head>

<style>
  table {
      width: 100%;
      border-collapse: collapse;
  }
  th {
      background-color: #f4a460;
      border: 1px solid black;
      padding: 10px;
      text-align: center;
  }

  @media print {
      body * {
          font-family: "Arial", sans-serif;
          font-size: 12pt;
          visibility: hidden; /* Hide everything */
      }
      #example, #example *, #title {
          visibility: visible; /* Only show the table and the title */
      }

      .top-div {
        display: none;
      }

      /* Ensure both title and table are positioned correctly */
      #example, #title {
          position: absolute;
          left: 0;
          width: 100%;
      }

      #title {
          top: 0; /* Title at the top */
          text-align: center;
          margin-bottom: 20px;
          font-size: 1.2em;
      }

      #example {
          top: 100px; /* Push table down below the title */
      }

      /* Remove all margins/padding for print */
      body, html {
          margin: 0;
          padding: 0;
      }
  }
</style>

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid top-div">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h3 class="m-0">LAPORAN</h3>
      </div><!-- /.col -->

      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('/homeBilikMeet') }}">Laman Utama</a></li>
          <li class="breadcrumb-item">Laporan</li>
        </ol>
      </div><!-- /.col -->
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
        <div class="card card-info top-div">
          <div class="card-header bg-purple">
            <h2 class="card-title">Laporan Katerer</h2>
          </div>

          <form class="form-horizontal" method="POST" action="{{ route ('laporanbilik.katerer_bulanan') }}" enctype="multipart/form-data">
            {{ csrf_field() }}

            <div class="card-body">
              <div class="form-group row">
                <!-- pentadbir sistem -->
                <div class="col-sm-4">
                  <label for="katerer" class="col-form-label">Nama Katerer : </label>
                  <select class="form-control select2" id="katerer" name="katerer" style="width: 100%;">
                  <option value="" @if($search['katerer']=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
                  @foreach ($katerers as $katerer)
                    <option value="{{ $katerer->id_katerer }}" @if($search['katerer']==$katerer->id_katerer) {{ 'selected="selected"' }} @endif>{{ $katerer->nama_katerer }}</option>
                  @endforeach
                  </select>
                </div>
                {{-- <div class="col-sm-4">
                  <label for="tkh_mula" class="col-form-label">Tarikh Dari : </label>
                  <input type="date" class="form-control" id="tkh_mula" name="tkh_mula" value="{{ $search['tkh_mula'] }}">
                </div> --}}
                {{-- <div class="col-sm-4">
                  <label for="tkh_hingga" class="col-form-label">Tarikh Hingga :</label>
                  <input type="date" class="form-control" id="tkh_hingga" name="tkh_hingga" value="{{ $search['tkh_hingga'] }}">
                </div> --}}
                
                <div class="col-sm-4">
                    <label for="bulan" class="col-form-label">Bulan & Tahun :</label>
                    <input type="month" class="form-control" id="bulan" name="bulan" min="2020-01" max="2030-12" value="{{ $search['bulan'] }}">
                </div> 

                <div class="col-sm-4">
                    <label for="katerer" class="col-form-label">Bahagian : </label>
                    <select class="form-control select2" id="bahagian" name="bahagian" style="width: 100%;">
                      <option value="" @if($search['bahagian']=='') {{ 'selected="selected"' }} @endif>&nbsp;</option>
                      @foreach ($bahagians as $bahagian)
                        <option value="{{ $bahagian->bahagian }}" @if($search['bahagian']==$bahagian->bahagian) {{ 'selected="selected"' }} @endif>{{ $bahagian->bahagian }}</option>
                      @endforeach
                  </select>
                </div>
              
              </div>
                <!-- </div>
                <div class="form-group row"> -->
              <div class="modal-footer justify-content-between">
                  <p></p>
                <span class="float-right">
                <!-- <div class="col-sm-3"> -->
                  <!-- <label for="submit" class="col-form-label">&nbsp; </label><br> -->
                  <button type="submit" class="btn btn-info bg-purple" name="search_laporan">Carian</button>
                  <a href="{{ url('/laporbilik/katerer/bulanan') }}" class="btn btn-default" name="search_laporan">Reset</a>
                </span>
              </div>
              
            </div>
          </form>
        </div>

          @if(isset($_POST['search_laporan']))
          <div class="card card-info">
            <div class="card-body table-responsive">
                <button type="button" class="btn-sm btn-success" id="exportExcel"> <i class="fa fa-file-excel" aria-hidden="true"></i> &nbsp;Export Excel</button>
                <button type="button" class="btn-sm btn-info" onclick="window.print()"> <i class="fa fa-print" aria-hidden="true"></i> &nbsp;Cetak </button>

                <h5 style="text-align: center; text-decoration: strong;" id="title">  
                    TEMPAHAN MAKANAN BAGI TAKLIMAT / LAWATAN DAN MESYUARAT DALAMAN
                    <br>
                    @if (isset($monthName))
                        {{-- <br> --}}
                        BULAN {{ $monthName }} {{ date('Y', strtotime($search['bulan'])) }}
                    @endif

                    {{-- BULAN 2024  --}}
                    @if (isset($namaKaterer))
                        {{-- <br> --}}
                        ({{ $namaKaterer }})
                    @endif

                    {{-- NAMA BAHAGIAN  --}}
                    @if (isset($namaBahagian))
                        <br>
                        {{ strtoupper($namaBahagian) }}
                    @endif

                    <br>
                    KEMENTERIAN PERPADUAN NEGARA
                </h5>

                {{-- <table id="example1" class="table table-bordered" width="100%"> --}}
                <table id="example" class="table table-bordered">
                  <thead>
                    <tr>
                      <th>BIL</th>
                      <th>BAHAGIAN</th>
                      <th>TAJUK / TARIKH / TEMPAT</th>
                      <th>DI PENGERUSI</th>
                      <th>JUMLAH PAX (RM)</th>
                      <th>PENGESAHAN OLEH BKP</th>
                    </tr>
                  </thead>
                  <tbody>
                      @foreach ($permohonanBiliks as $permohonanBilik)
                          <tr>
                            <td scope="row" rowspan="4">{{ $bil++ }}</td>
                            <td rowspan="4">
                                {{ $permohonanBilik->bahagian }} 
                                {{-- id: {{ $permohonanBilik->id_permohonan_bilik }} --}}
                                {{-- <br>   --}}
                                {{-- {{ optional(\App\LkpKaterer::find($permohonanBilik->pembekal))->nama_katerer ?? '-' }} --}}
                            </td>
                            <td > <strong>TAJUK: </strong> {{ $permohonanBilik->nama_tujuan }} </td>
                            <td  rowspan="4"> 
                                  <?php 
                                      $pengerusi = optional(\App\PPersonel::find($permohonanBilik->nama_pengerusi));
                                  ?>
                                  {{ $pengerusi->name }}
                            </td>
                            <td> {{ $permohonanBilik->bil_peserta }} pax </td>
                            <td rowspan="4"> </td>
                          </tr>
                          <tr>
                            <td>
                                <strong>TARIKH: </strong>  
                                {{ Carbon\Carbon::parse($permohonanBilik->tkh_mula)->format('d.m.Y') }} |
                                  <?php
                                    \Carbon\Carbon::setLocale('ms');
                                    echo '('.\Carbon\Carbon::parse($permohonanBilik->tkh_mula)->dayName.')'; 
                                  ?>
                            </td>
                            <td>
                                  @php
                                      $makan = ''; // Initialize as an empty string
                                  @endphp

                                  @if ($permohonanBilik->makan_pagi == 1)
                                      @php
                                          $makan .= 'pagi '; // Concatenate 'pagi' to the string
                                      @endphp
                                  @endif

                                  @if ($permohonanBilik->makan_tghari == 1)
                                      @php
                                          $makan .= 'tengahari '; // Concatenate 'tengahari' to the string
                                      @endphp
                                  @endif

                                  @if ($permohonanBilik->minum_petang == 1)
                                      @php
                                          $makan .= 'petang '; // Concatenate 'petang' to the string
                                      @endphp
                                  @endif

                                  @if ($permohonanBilik->makan_malam == 1)
                                      @php
                                          $makan .= 'malam '; // Concatenate 'malam' to the string
                                      @endphp
                                  @endif

                                  {{ $makan }} <!-- trim() is used to remove any trailing spaces -->
                                  {{-- {{ trim($makan) }} <!-- trim() is used to remove any trailing spaces --> --}}
                            </td>
                          </tr>
                          <tr>
                            <td>
                                <strong>MASA: </strong>  
                                {{ ($permohonanBilik->masa_mula!='') ? Carbon\Carbon::parse($permohonanBilik->masa_mula)->format('g:i A') : '-' }}
                                - 
                                {{ ($permohonanBilik->masa_hingga!='') ? Carbon\Carbon::parse($permohonanBilik->masa_hingga)->format('g:i A') : '-' }}
                            </td>
                            <td> RM {{ $permohonanBilik->kadar_harga }} </td>
                          </tr>
                          <tr>
                            <td> 
                                <strong>TEMPAT: </strong>
                                <?php 
                                  $bilik = optional(\App\LkpBilik::find($permohonanBilik->id_bilik));
                                ?>
                                {{ $bilik->bilik }}, Aras {{ $bilik->aras }}
                            </td>
                            <td>
                                <?php
                                  $total = $permohonanBilik->kadar_harga * $permohonanBilik->bil_peserta;
                                  echo 'RM'.$total;
                                ?>
                            </td>
                          </tr>
                      @endforeach
                  </tbody>
                </table><!-- /.card-body -->
              </div>
            </div>
          @endif
        </div><!-- /.card -->
         
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</section>


@endsection
@section('script')
{{-- <script>
  $(function () {
        $("#example1").DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": true,
          "responsive": true,
          "buttons": ["csv", "excel", "pdf", "print"],
          // "columnDefs": [
          //       {
          //           "targets": [ 5, 7, 8, 9, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23],
          //           "visible": false,
          //           "searchable": false
          //       }
          //   ]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      });
</script> --}}

{{-- <script>
  document.getElementById('exportExcel').addEventListener('click', function () {
      var table = document.getElementById('example');
      var wb = XLSX.utils.table_to_book(table, {sheet: "Sheet JS"});
      XLSX.writeFile(wb, 'table.xlsx');
  });
</script> --}}

{{-- <script>
  document.getElementById('exportExcel').addEventListener('click', function () {
      var table = document.getElementById('example');

      // Get the dynamic value for Katerer Nama
      var katererNama = "{{ $namaKaterer }}";
      var monthName = "{{ $monthName }}";
      var year = "{{ date('Y', strtotime($search['bulan'])) }}";
      
      // Create a new workbook
      var wb = XLSX.utils.book_new();

      // Convert the HTML table to a worksheet (starting from a row after the title)
      var ws = XLSX.utils.table_to_sheet(table, {origin: 'A5'});

      // Add the title at the top (row 1 to 3)
      XLSX.utils.sheet_add_aoa(ws, [
          ["TEMPAHAN MAKANAN BAGI TAKLIMAT / LAWATAN DAN MESYUARAT DALAMAN"], // Row 1
          ["BULAN " + monthName + " " + year + "(" + katererNama + ")"], // Row 2
          ["KEMENTERIAN PERPADUAN NEGARA"], // Row 3
          [] // Empty row for spacing (Row 4)
      ], { origin: 'A1' });

      // Append the worksheet to the workbook
      XLSX.utils.book_append_sheet(wb, ws, "Laporan Katerer");

      // Export the Excel file
      XLSX.writeFile(wb, 'Laporan_Katerer.xlsx');
  });
</script> --}}

<script>
  document.getElementById('exportExcel').addEventListener('click', function () {
      var table = document.getElementById('example');

      // Get the dynamic value for Katerer Nama
      var katererNama = "{{ $namaKaterer }}";
      var monthName = "{{ $monthName }}";
      var year = "{{ date('Y', strtotime($search['bulan'])) }}";

      // Create a new workbook
      var wb = XLSX.utils.book_new();

      // Convert the HTML table to a worksheet (starting from a row after the title)
      var ws = XLSX.utils.table_to_sheet(table, {origin: 'A5'});

      // Construct the title rows based on the values of monthName, year, and katererNama
      var titleRows = [
          ["TEMPAHAN MAKANAN BAGI TAKLIMAT / LAWATAN DAN MESYUARAT DALAMAN"], // Row 1
      ];

      // Construct the second row dynamically
      var row2 = [];
      var titlePart = '';
      //if (monthName || year || katererNama) {
          if (monthName) {
              var titlePart = "BULAN";
              titlePart += " " + monthName;
              titlePart += " " + year;
          }
          if (katererNama) {
              titlePart += " (" + katererNama + ")";
          }
          row2.push(titlePart);
      //}

      // Add the second row if it has content
      if (row2.length > 0) {
          titleRows.push(row2);
      }

      // Add the third row (static content)
      titleRows.push(["KEMENTERIAN PERPADUAN NEGARA"]);

      // Add an empty row for spacing (Row 4)
      titleRows.push([]);

      // Add the title to the worksheet
      XLSX.utils.sheet_add_aoa(ws, titleRows, { origin: 'A1' });


      // Append the worksheet to the workbook
      XLSX.utils.book_append_sheet(wb, ws, "Laporan Katerer");

      // Export the Excel file
      XLSX.writeFile(wb, 'Laporan_Katerer.xlsx');
  });
</script>



@endsection