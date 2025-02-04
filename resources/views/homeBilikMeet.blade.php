@extends('layouts/master')
@section('content')
<section class="content">
  <div class="row">
    <div class="col-12" id="accordion">
      <div class="card card-purple card-outline">
        <a class="d-block w-100">
          <div class="card-header" >
              <h2 class="card-title w-100"  align="center">
                <font color="purple">Selamat Datang <b> {{ Auth::user()->nama }}</b> ke Sistem eTempahan (Modul Tempahan Bilik Mesyuarat)</font>
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
            <p>Bilangan Permohonan</p>
          </div>
          <div class="icon">
            <i class="fa fa-window-maximize" aria-hidden="true"></i>
          </div>

        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
          <div class="inner">
            <h3>{{ $countPermohonanBaru -> count()}}</h3>
            <p>Bilangan Permohonan Baru</p>
          </div>
          <div class="icon">
            <i class="fa fa-list"></i>
          </div>

        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
          <div class="inner">
          <h3>{{ $countPermohonanLulus -> count()}}</h3>
            <p>Bilangan Permohonan Lulus</p>
          </div>
          <div class="icon">
            <i class="fa fa-check"></i>
          </div>

        </div>
      </div>
        <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
          <div class="inner">
          <h3>{{ $countPermohonanGagal -> count()}}</h3>
            <p>Bilangan Permohonan Tidak Lulus</p>
          </div>
          <div class="icon">
            <i class="fa fa-times"></i>
          </div>

        </div>
      </div>
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
  <div class="container-fluid">
    <div class="row">

      <div class="col-md-6">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Bilangan Permohonan Mengikut Bulan</h3>
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

      <div class="col-md-6">
        <!-- DONUT CHART -->
        <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title">Bilangan Permohonan Mengikut Tujuan</h3>
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
    </div>

      <div class="col-md-12">
        <div class="card card-navy">
          <div class="card-header">
            <h3 class="card-title">Bilangan Permohonan Mengikut Bahagian/Unit</h3>
          </div>

          <div class="card-body">
            <div id="chartBilik" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></div>
          </div>
        </div>
      </div>

      <div class="col-md-12">
        <div class="card card-navy">
          <div class="card-header">
            <h3 class="card-title">Bilangan Tempahan Mengikut Katerer</h3>
          </div>
          <div class="card-body">
            <div id="chartKaterer" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

</section>
@endsection

@section('script')
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
            title: 'Bil. Permohonan',
            format: '#',
            minValue: 0,
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
  google.charts.load('current', {packages: ['corechart']});
  google.charts.setOnLoadCallback(drawMultSeries);

  function drawMultSeries() {
        var data = google.visualization.arrayToDataTable([
          ['Bahagian ', 'Bilik Mesyuarat Perpaduan 3 - Aras 5', 'Bilik Bincang 1 - Aras 5', 'Bilik Mesyuarat Utama - Aras 5', 'Bilik Bincang 1 - Aras 5', 'Bilik Bincang 2 - Aras 5',
          'War Room - Aras 6', 'Bilik Bincang 1 - Aras 6', 'Bilik Bincang 2 - Aras 6', 'Bilik Bincang - Aras 6',
          'Bilik Mesyuarat - Aras 7', 'Bilik Bincang - Aras 7', 'Bilik Latihan Komputer 1 - Aras 7', 'Bilik Latihan Komputer 2 - Aras 7',
          'Bilik Mesyuarat Perpaduan 2 - Aras 8', 'Bilik Bincang - Aras 8', 'Bilik Bincang 1 - Aras 8', 'Bilik Bincang 2 - Aras 8',
          'Bilik Bincang - Aras 9', 'Bilik Mesyuarat - Aras 9', 'Bilik Bincang - Aras 9',
          'Bilik Mesyuarat Perpaduan - Aras 10', 'Bilik Bincang 1 - Aras 10', 'Bilik Bincang 2 - Aras 10'],

          @foreach($biliks as $bilik )
          ['{!! addslashes($bilik->singkatan) !!}', {{ $bilik->BilikMesyuaratPerpaduan3A5 }}, {{ $bilik->BilikBincang1A5 }}, {{ $bilik->BilikMesyuaratUtamaA5 }}, {{ $bilik->BilikBincang1A52 }}, {{ $bilik->BilikBincang2A5 }}, {{ $bilik->warRoomA6 }}, {{ $bilik->BilikBincang1A6 }}, {{ $bilik->BilikBincang2A6 }}, {{ $bilik->BilikBincangA6 }}, {{ $bilik->BilikMesyuaratA7 }}, {{ $bilik->BilikBincangA7 }}, {{ $bilik->BilikLatihanKomputer1A7 }}, {{ $bilik->BilikLatihanKomputer2A7 }}, {{ $bilik->BilikMesyuaratPerpaduan2A8 }}, {{ $bilik->BilikBincangA8 }}, {{ $bilik->BilikBincang1A8 }}, {{ $bilik->BilikBincang2A8 }}, {{ $bilik->BilikBincangA9 }}, {{ $bilik->BilikMesyuaratA9 }}, {{ $bilik->BilikBincang2A9 }}, {{ $bilik->BilikMesyuaratPerpaduanA10 }}, {{ $bilik->BilikBincang1A10 }}, {{ $bilik->BilikBincang2A10 }} ],
          @endforeach
        ]);

        var options = {
          isStacked:true,
          responsive: true,
          maintainAspectRatio : false,
          legend: { position: 'top', textStyle:{fontSize:10}, alignment:'center' },
          bar: { gap: 4, Width: "10%"},
          chartArea:{left:20, top:20, bottom: 45, width:'100%',height:'100%'},
          // colors: ['#0288D1', '#D32F2F', '#FFA000', '#512DA8', '#689F38', '#795548', '#707B7C'],
          hAxis: {
            title: 'Bahagian/Seksyen/Unit',
            titleTextStyle: {bold:'true'},
            minValue: 5,
            textPosition: 'out',
            textStyle:{fontSize:11},
            slantedText:'true',
            gridlines: {minSpacing:5},
          },
          vAxis: {
            title: 'Bilik',
            titleTextStyle: {bold:'true'},
            textStyle:{fontSize:11},
            gridlines: {minSpacing:20},
          }
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chartBilik'));
        chart.draw(data, options);
      }
</script>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
        google.charts.load('current', {packages: ['corechart']});
        google.charts.setOnLoadCallback(drawMultSeries);

        function drawMultSeries() {
              var data = google.visualization.arrayToDataTable([
                ['Katerer ', 'Bil. Katerer ', { role: 'annotation' }, { role: 'style' } ],
                @foreach($countKaterers as $countKaterer )
                ['{!! addslashes($countKaterer->nama_katerer) !!}', {{ $countKaterer->bilkaterer }}, {{ ($countKaterer->jumlah) }}, 'color: #22ABA8'],
                @endforeach
              ]);

              var formatter = new google.visualization.NumberFormat({pattern: 'RM##,###.00'});
              formatter.format(data,2);

              var options = {
                responsive: true,
                isStacked:false,
                maintainAspectRatio : false,
                legend: { position: 'none' },
                bar: { gap: 150, Width: "3%"},
                chartArea:{left:45, top:20, bottom: 45, width:'100%',height:'100%'},
                hAxis: {
                  title: 'Katerer',
                  titleTextStyle: {bold:'true'},
                  minValue: 0,
                  textPosition: 'out',
                  textStyle:{fontSize:10},
                  slantedText:'false',
                  gridlines: {minSpacing:0},
                },
                vAxis: {
                  title: 'Bil. Tempahan',
                  format: '#',
                  minValue: 0,
                  titleTextStyle: {bold:'true'},
                  textStyle:{fontSize:10},
                  gridlines: {minSpacing:20},
                }
              };

              var chart = new google.visualization.ColumnChart(document.getElementById('chartKaterer'));
              chart.draw(data, options);
            }
      </script>
@endsection
