@extends('layouts/master')
@section('content')
<section class="content">
  <div class="row">
    <div class="col-12" id="accordion">
      <div class="card card-purple card-outline">
        <a class="d-block w-100">
          <div class="card-header" >
              <h2 class="card-title w-100"  align="center">
                <font color="purple">Selamat Datang <b> {{ Auth::user()->nama }}</b> ke Sistem eTempahan.</font>
              </h2>
          </div>
        </a>
        <!-- <div id="collapseOne" class="collapse show" data-parent="#accordion">
          <div class="card-body" style="background-color:purple">
            <font color="white">Selamat Datang <b> {{ Auth::user()->nama }}</b>.</font>
          </div>
        </div> -->
      </div>
  </div>
  </div>
  <div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-purple">
          <div class="inner">
            <h3>{{ $countPermohonan -> count()}}</h3>
            <p>Jumlah Permohonan</p>
          </div>
          <div class="icon">
            <i class="fa fa-car"></i>
          </div>
          <!-- <a href="{{ route('tempahankenderaan.index')}}" class="small-box-footer">Seterusnya <i class="fas fa-arrow-circle-right"></i></a> -->
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
          <div class="inner">
            <h3>{{ $countPermohonanBaru -> count()}}</h3>
            <p>Permohonan Baru</p>
          </div>
          <div class="icon">
            <i class="fa fa-list"></i>
          </div>
          <!-- <a href="{{ route('tempahankenderaan.index')}}" class="small-box-footer">Seterusnya <i class="fas fa-arrow-circle-right"></i></a> -->
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
          <div class="inner">
          <h3>{{ $countPermohonanLulus -> count()}}</h3>
            <p>Permohonan Lulus</p>
          </div>
          <div class="icon">
            <i class="fa fa-check"></i>
          </div>
          <!-- <a href="{{ route('tempahankenderaan.index')}}" class="small-box-footer">Seterusnya <i class="fas fa-arrow-circle-right"></i></a> -->
        </div>
      </div>
        <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
          <div class="inner">
          <h3>{{ $countPermohonanGagal -> count()}}</h3>
            <p>Permohonan Gagal / Batal</p>
          </div>
          <div class="icon">
            <i class="fa fa-times"></i>
          </div>
          <!-- <a href="{{ route('tempahankenderaan.index')}}" class="small-box-footer">Seterusnya <i class="fas fa-arrow-circle-right"></i></a> -->
        </div>
      </div>
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <!-- DONUT CHART -->
        <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title">Jumlah Permohonan Mengikut Tujuan</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <div id="piechart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></div>
            <!-- <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas> -->
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
        
      </div>
      <div class="col-md-6">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Jumlah Permohonan Mengikut Bulan</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <div id="chart_div" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></div>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>
     <!-- /.row -->
    <div class="row">
      <div class="col-md-12">
        <div class="card card-default">
          <div class="card-header bg-teal">
            <h3 class="card-title"><b>Jadual Pergerakan</b></h3>
            <div class="card-tools">
              <span class="badge bg-light" style="font-size: 17px;"><strong><div style="text-transform:uppercase" id="runningTime"></div></strong></span>
              
            </div>
          </div>
          <div class="card-body">
            <table id="table" class="table table-sm" style="width:100%;">
              <thead style="background-color: #E6E1E9">
                <tr>
                  <!-- <th style="width: 10px"></th> -->
                  <th>MASA</th>
                  <th>PEMANDU</th>
                  <th>DESTINASI</th>
                  <!-- <th>PENUMPANG</th> -->
                  <th>TUJUAN</th>
                  <!-- <th style="width: 40px">Label</th> -->
                </tr>
              </thead>
              <tbody>
                @foreach ($pergerakans as $pergerakan)
                <tr>
                  <td>{{ Carbon\Carbon::parse($pergerakan->tkh_pergi)->format('d M Y') }} </br> {{ Carbon\Carbon::parse($pergerakan->masa_pergi)->format('g:i A')}}</td>
                    <?php 
                            // $detail_kenderaan_pergis= DB::select('SELECT k.no_plat, p.nama_pemandu, p.mykad, p.no_tel_bimbit, m.jenis_model
														// FROM kenderaan k
														// JOIN lkp_pemandu p ON k.pemandu=p.mykad
														// JOIN lkp_model m ON k.id_model=m.id_model
														// WHERE k.id_kenderaan='.$pergerakan->kenderaan_pergi.''); 

                            $detail_kenderaan_pergis = App\Kenderaan::join('lkp_pemandu', 'lkp_pemandu.mykad', '=', 'kenderaan.mykad')
                                                                ->join('lkp_model', 'lkp_model.id_model', '=', 'kenderaan.id_model')
                                                                ->where('kenderaan.id_kenderaan', $pergerakan->kenderaan_pergi);
                    ?>
                            
                  <td>@foreach ($detail_kenderaan_pergis as $dkp)
                    <!-- <a href="{{ url('pemandu/butiran',$dkp->mykad) }}">{{ $dkp->nama_pemandu }}</a><br/> -->
                    {{ $dkp->nama_pemandu }}<br/>
                    {{ $dkp->no_tel_bimbit }}<br/>
                    {{ $dkp->no_plat }}<br/>
                    {{ $dkp->jenis_model }}<br/>
                    <?php //small>{{ $dkp->keterangan }}</small?>
                  </td>  @endforeach
                  <td><b>{{ ($pergerakan->id_negeri!='') ? \App\RLkpNegeri::find($pergerakan->id_negeri)->negeri : ''  }} </b><br>{{ $pergerakan->lokasi_tujuan }}</br></td>
                  <td><b>{{ ($pergerakan->id_tujuan!='') ? \App\LkpTujuan::find($pergerakan->id_tujuan)->tujuan : ''  }} </b><br>{{ $pergerakan->keterangan_lanjut }}</br></td>
                </tr>
                @if($pergerakan->kenderaan_balik)
                <tr>
                  <td>{{ Carbon\Carbon::parse($pergerakan->tkh_balik)->format('d M Y') }} </br> {{ Carbon\Carbon::parse($pergerakan->masa_balik)->format('g:i A')}}</td>

                  <?php   $detail_kenderaan_baliks=[];
                          $detail_kenderaan_baliks= DB::select('SELECT k.no_plat, p.nama_pemandu, p.mykad, p.no_tel_bimbit, m.jenis_model
                                FROM kenderaan k
                                JOIN lkp_pemandu p ON k.pemandu=p.mykad
                                JOIN lkp_model m ON k.id_model=m.id_model
                                WHERE k.id_kenderaan='.$pergerakan->kenderaan_balik.'');
                   ?>

                  <td>@foreach ($detail_kenderaan_baliks as $dkb)
                    <!-- <a href="{{ url('pemandu/butiran',$dkb->mykad) }}">{{ ($dkb->nama_pemandu!='') ? $dkb->nama_pemandu : '-'}}</a><br/> -->
                    {{ $dkb->nama_pemandu }}<br/>
                    {{ $dkb->no_tel_bimbit }}<br/>
                    {{ $dkb->no_plat }}<br/>
                    {{ $dkb->jenis_model }}<br/>
                  
                  </td> @endforeach
                  <td><b>KPN </b><br></td>
                  <td><b>{{ ($pergerakan->id_tujuan!='') ? \App\LkpTujuan::find($pergerakan->id_tujuan)->tujuan : ''  }} </b><br>{{ $pergerakan->keterangan_lanjut }}</br></td>
                </tr>
                @endif
               
                @endforeach
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>
     <!-- /.row -->
  </div><!-- /.container-fluid -->
      
</section>
@endsection

@section('script')
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> -->
<script type="text/javascript">
  $(document).ready(function() {
    setInterval(runningTime, 1000);
  });
  
  function runningTime() {
    $.ajax({
      url: '{!!URL::to('clock')!!}',
      success: function(data) {
        $('#runningTime').html(data);
      },
    });
  }
  
</script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    google.charts.setOnLoadCallback(drawMultSeries);

    function drawChart() {

      var data = google.visualization.arrayToDataTable([
        ['Tujuan', 'Jumlah Permohonan'],
        @foreach($countTujuan as $countTujuan )
        ['{!! addslashes($countTujuan->tujuan) !!}', {{ $countTujuan->bil }}],
        @endforeach
      ]);

      var options = {
        chartArea: {top:20, bottom: 20, width:"100%", height:"100%"},
        pieHole: 0.4,
      };

      var chart = new google.visualization.PieChart(document.getElementById('piechart'));

      chart.draw(data, options);
    }

    function drawMultSeries() {
        var data = google.visualization.arrayToDataTable([
          ['Bulan ', 'Permohonan', { role: 'style' }],
          @foreach($countBulan as $countBulan )
          ['{!! addslashes($countBulan->bulan) !!}', {{ $countBulan->permohonan }}, 'color: #E0B0FF'],
          @endforeach
        ]);

        var options = {
          responsive: true,
          maintainAspectRatio : false,
          // legend: { position: 'top', textStyle:{fontSize:10}, alignment:'center', color: '#C5A5CF' },
          bar: { gap: 5, Width: "2%"},
          chartArea:{left:45, top:20, bottom: 45, width:'100%',height:'100%'},
          hAxis: {
            title: 'Bulan',
            titleTextStyle: {bold:'true'},
            minValue: 0,
            textPosition: 'out',
            textStyle:{fontSize:10},
            slantedText:'true',
            gridlines: {minSpacing:0},
          },
          vAxis: {
            title: 'Permohonan',
            titleTextStyle: {bold:'true'},
            textStyle:{fontSize:10},
            gridlines: {minSpacing:20},
          }
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
</script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
          <script type="text/javascript">
            $(function () {
              $("#table").DataTable({
                "paging": false,
                "searching": false,
                "ordering": false,
                "info": false,
                "autoWidth": true,
                "responsive": true,
                "buttons": ["csv", "excel", "pdf", "print"]
              }).buttons().container().appendTo('#table_wrapper .col-md-6:eq(0)').css("position", "bottom");

              $("#table2").DataTable({
                "paging": false,
                "searching": false,
                "ordering": false,
                "info": false,
                "autoWidth": true,
                "responsive": true,
                "buttons": ["csv", "excel", "pdf", "print"]
              }).buttons().container().appendTo('#table2_wrapper .col-md-6:eq(0)').css("position", "bottom");

            });
          </script>
<script>
  $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */
    //-------------
    //- DONUT CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
    var donutData  = {
      labels: [
          'Chrome',
          'IE',
          'FireFox',
          'Safari',
          'Opera',
          'Navigator',
      ],
      datasets: [
        {
          data: [700,500,400,600,300,100],
          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
        }
      ]
    }
    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(donutChartCanvas, {
      type: 'doughnut',
      data: donutData,
      options: donutOptions
    })
  })
</script>
@endsection
