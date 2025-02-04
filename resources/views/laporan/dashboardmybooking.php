<br>
<section class="content">
    <div class="row">
        <div class="col-12" id="accordion">
            <div class="card card-primary card-outline">
                <a class="d-block w-100">
                    <div class="card-header">
                        <h2 class="card-title w-100">
                            Sistem Permohonan Geran Kewangan MITRA (SPGKM) 
                        </h2>
                    </div>
                </a>
                <div id="collapseOne" class="collapse show" data-parent="#accordion">
                    <div class="card-body">
                        Selamat Datang <b> {{ Auth::user()->nama }}</b>.
                    </div>
                </div>
            </div>
        </div>
    </div>
@if (Auth::user()->id_access == '2' or Auth::user()->id_access == '3' or Auth::user()->id_access == '4')
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-orange">
              <div class="inner">
                <h3>{{ $countPermohonan -> count()}}</h3>
                <p>Jumlah Permohonan</p>
              </div>
              <div class="icon">
                <i class="ion ion-folder"></i>
              </div>
              <!-- <a href="{{ route('permohonan.index')}}" class="small-box-footer">Seterusnya <i class="fas fa-arrow-circle-right"></i></a> -->
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-2 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{ $countPermohonanBaru -> count()}}</h3>
                <p>Permohonan Baru</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <!-- <a href="{{ route('permohonan.index')}}" class="small-box-footer">Seterusnya <i class="fas fa-arrow-circle-right"></i></a> -->
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-2 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
              <h3>{{ $countPermohonanLulus -> count()}}</h3>
                <p>Permohonan Lulus</p>
              </div>
              <div class="icon">
              <i class="ion ion-pie-graph"></i>
              </div>
              <!-- <a href="{{ route('permohonan.index')}}" class="small-box-footer">Seterusnya <i class="fas fa-arrow-circle-right"></i></a> -->
            </div>
          </div>
           <!-- ./col -->
           <div class="col-lg-2 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
              <h3>{{ $countPermohonanGagal -> count()}}</h3>
                <p>Permohonan Gagal</p>
              </div>
              <div class="icon">
              <i class="ion ion-pie-graph"></i>
              </div>
              <!-- <a href="{{ route('permohonan.index')}}" class="small-box-footer">Seterusnya <i class="fas fa-arrow-circle-right"></i></a> -->
            </div>
          </div>
          <!-- ./col -->
          <!-- <div class="col-lg-2 col-6">
            small box
            <div class="small-box bg-danger">
              <div class="inner">
              <h3>{{ $countOrganisasi -> count()}}</h3>
                <p>Jumlah NGO Berdaftar</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="" class="small-box-footer">Seterusnya <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div> -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                @foreach($sumBajet as $sumBajett)
              <h3> RM 
                <!-- @if ($sumBajett->s > 1000000) {{ substr($sumBajett->s,-9,-6).",".substr($sumBajett->s,-6,-3).",".substr($sumBajett->s,-3) }}
              @elseif ($sumBajett->s > 100000) {{ substr($sumBajett->s,-6,-3).",".substr($sumBajett->s,-3) }}
              @elseif ($sumBajett->s > 1000) {{ substr($sumBajett->s,-3) }}
              @endif -->
              {{  number_format($sumBajett->s,2)  }}
              </h3>@endforeach
                <p>Kos Penganjuran Program</p>
              </div>
              <div class="icon">
                <!-- <i class="ion ion-person-add"></i> --><i class="fas fa-coins"></i>

              </div>
              <!-- <a href="" class="small-box-footer">Seterusnya <i class="fas fa-arrow-circle-right"></i></a> -->
            </div>
          </div>
          <!-- ./col -->
        </div>

        <!-- Mengikut Bidang + Mengikut Organisasi  -->
        
        <div class="row">
          <!-- text input left -->
          <div class="col-sm-6">
              <!-- Poskod -->
              
              <div class="form-group">
                <h3 class="card-title">Jumlah Permohonan Mengikut Bidang </h3>         

                <!-- <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div> -->
              
                <div class="card-body">
                  <div id="piechart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></div> 
                </div>
              </div>
          </div>

          <!-- text input right -->
          <div class="col-sm-6">
              <!-- Dropdown Negeri -->
              <div class="form-group">
                <h3 class="card-title">Jumlah Permohonan Mengikut Organisasi  </h3>                       
                  <!-- <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button>
                  </div> -->
                
                  <div class="card-body">
                    <div id="chart2_div" style="min-height: 250; height: 250px; max-height: 250px; max-width: 100%;"></div> 
                  </div>
                </div>
              </div>
          </div>
        </div>
        <!-- /Mengikut Bidang + Mengikut Organisasi  -->


        <!-- Kos Mengikut Bidang + Kos Mengikut Organisasi  -->
        <div class="row">
          <!-- text input left -->
          <div class="col-sm-6">
              <!-- Poskod -->
              <div class="form-group">
                <h3 class="card-title">Jumlah Kos Penganjuran Program Mengikut Bidang </h3>         

                <!-- <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div> -->
              
                <div class="card-body">
                  <div id="piechart2" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></div> 
                </div>
              </div>
          </div>

          <!-- text input right -->
          <div class="col-sm-6">
              <!-- Dropdown Negeri -->
              <div class="form-group">
                <h3 class="card-title">Jumlah Kos Penganjuran Program Mengikut Organisasi  </h3>                       
                  <!-- <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button>
                  </div> -->
                
                  <div class="card-body">
                    <div id="chart4_div" style="min-height: 250; height: 250px; max-height: 250px; max-width: 100%;"></div> 
                  </div>
                </div>
              </div>
          </div>
        </div>
        <!-- /Mengikut Bidang + Mengikut Organisasi  -->



<!-- 
        <div class="">
          <div class="card-header">                  
          <h3 class="card-title">Jumlah Kos Penganjuran Program Mengiktu Bidang </h3>         
          
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        
          <div class="card-body">
            <div id="chart3_div" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></div> 
          </div>
        </div>

        <div class="">
          <div class="card-header">                  
          <h3 class="card-title">JUMLAH KOS PENGANJURAN PROGRAM MENGIKUT JENIS ORGANISASI  </h3>         
          
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        
          <div class="card-body">
            <div id="chart4_div" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></div> 
          </div>
        </div> -->

        
     @endif
</section>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

          <script type="text/javascript">
            google.charts.load('current', {packages: ['corechart']});
            google.charts.setOnLoadCallback(drawMultSeries);

            function drawMultSeries() {
                  var data = google.visualization.arrayToDataTable([
                    ['Organisasi ', 'Bilangan Permohonan'],
                    @foreach($countOrgProgram as $countOrgProgram )
                    ['{!! addslashes($countOrgProgram->jenis_org) !!}', {{ $countOrgProgram->bilmohon }}],
                    @endforeach
                  ]);

                  var options = {
                    responsive: true,
                    maintainAspectRatio : false,
                    legend: { position: 'top', textStyle:{fontSize:10}, alignment:'center' },
                    bar: { gap: 5, Width: "2%"},
                    chartArea:{left:45, top:20, bottom: 45, width:'100%',height:'100%'},
                    hAxis: {
                      title: 'Jenis Organisasi',
                      titleTextStyle: {bold:'true'},
                      minValue: 0,
                      textPosition: 'out',
                      textStyle:{fontSize:10},
                      slantedText:'true',
                      gridlines: {minSpacing:0},
                    },
                    vAxis: {
                      title: 'Jumlah Permohonan',
                      titleTextStyle: {bold:'true'},
                      textStyle:{fontSize:10},
                      gridlines: {minSpacing:20},
                    }
                  };

                  var chart = new google.visualization.ColumnChart(document.getElementById('chart2_div'));
                  chart.draw(data, options);
                }
</script>

<script type="text/javascript">
              google.charts.load('current', {'packages':['corechart']});
              google.charts.setOnLoadCallback(drawChart);

              function drawChart() {

                var data = google.visualization.arrayToDataTable([
                  ['Bidang', 'Bilangan Permohonan'],
                  @foreach($countProgram as $countProgram )
                  ['{!! addslashes($countProgram->nama_bidang) !!}', {{ $countProgram->bilprogram }}],
                  @endforeach
                ]);

                var options = {
                  chartArea: {top:20, bottom: 20, width:"100%", height:"100%"}
                };

                var chart = new google.visualization.PieChart(document.getElementById('piechart'));

                chart.draw(data, options);
              }
</script>

           
<script type="text/javascript">
              google.charts.load('current', {'packages':['corechart']});
              google.charts.setOnLoadCallback(drawChart);

              function drawChart() {

                var data = google.visualization.arrayToDataTable([
                    ['Bidang ', 'Kos'],
                    @foreach($countKosBidang as $countKosBidang )
                    ['{!! addslashes($countKosBidang->nama_bidang) !!}', {{ $countKosBidang->kosbidang }}],
                    @endforeach
                  ]);

                var options = {
                  chartArea: {top:20, bottom: 20, width:"100%", height:"100%"}
                };

                var chart = new google.visualization.PieChart(document.getElementById('piechart2'));

                chart.draw(data, options);
              }
</script>

<script type="text/javascript">
            google.charts.load('current', {packages: ['corechart']});
            google.charts.setOnLoadCallback(drawMultSeries);

            function drawMultSeries() {
                  var data = google.visualization.arrayToDataTable([
                    ['Organisasi ', 'Kos Penganjuran'],
                    @foreach($countKosOrg as $countKosOrg )
                    ['{!! addslashes($countKosOrg->jenis_org) !!}', {{ $countKosOrg->kosorganisasi }}],
                    @endforeach
                  ]);

                  var options = {
                    responsive: true,
                    maintainAspectRatio : false,
                    legend: { position: 'top', textStyle:{fontSize:10}, alignment:'center' },
                    bar: { gap: 5, Width: "2%"},
                    chartArea:{left:45, top:20, bottom: 45, width:'100%',height:'100%'},
                    hAxis: {
                      title: 'Jenis Organisasi',
                      titleTextStyle: {bold:'true'},
                      minValue: 0,
                      textPosition: 'out',
                      textStyle:{fontSize:10},
                      slantedText:'true',
                      gridlines: {minSpacing:0},
                    },
                    vAxis: {
                      title: 'Jumlah Kos Penganjuran Program Mengikut Jenis Organisasi',
                      titleTextStyle: {bold:'true'},
                      textStyle:{fontSize:10},
                      gridlines: {minSpacing:20},
                    }
                  };

                  var chart = new google.visualization.ColumnChart(document.getElementById('chart4_div'));
                  chart.draw(data, options);
                }
          </script>