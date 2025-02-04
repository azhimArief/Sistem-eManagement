@extends('layouts/CalendarmasterScreen')
@section('content')

    <head>
        <style>
            #calendar {
                /* max-width: 900px;
                    margin: 20px auto; */
            }
            /* .fc-event {
                font-size: 12px
            } */
            .fc-title {
                /* display: block;
                /* margin-left: auto;
                margin-right: auto; */
                width: 50%; 
                margin: 0 auto; */
                font-size: 12px;
            }
            .fc-time {
                display: none;
                /* visibility: hidden; */
            }
            .fc-sat { background-color:	#F1f5f4 }
            .fc-sun { background-color:#F1f5f4 }
            
        </style>
    </head>
    <!-- Content Header (Page header) -->
    <div class="container">
        <section class="content">
            <br><br>
            <div class="container">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12" align="center">
                        <!-- form start -->
                        <!-- Horizontal Form -->
                        <div class="card card-info">
                            <!-- style="margin:0px 250px 40px 250px;" -->
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
                            <div class="card-header bg-purple" align="center">
                                <h5 style="text-transform:uppercase">TEMPAHAN BILIK</h5>
                            </div>
                            <div class="card-body">
                                {{-- <p><b>Modul ini sedang dalam proses pembangunan.</b></p> --}}

                                    <div class="row" style="background-color: #FAF8FF">

                                        <div class="col-sm">
                                            
                                            <table>
                                                <th colspan="6" style="text-align:center">
                                                    <p>Status Tempahan</p>
                                                </th>
                                                <tr>
                                                    <td><a class="btn btn-lg btn-success float-end"></a> </td>
                                                    <td>Lulus &nbsp;</td>
                                                    <td><a class="btn btn-lg btn-danger float-end"></a></td>
                                                    <td>&nbsp;Sedang diproses&nbsp;</td>
                                                    <td><a class="btn btn-lg btn-primary float-end"></a> </td>
                                                    <td>&nbsp;Baru&nbsp;</td>
                                                </tr>
                                                <tr>
                                            </table>
                                            <br>
                                        </div>

                                        <div class="col-sm">
                                                <br>
                                                <a class="btn btn-sm btn-primary float-centre"
                                                    href="{{ route('pemohon.tambah_bilik', ['id' => $result->nokp]) }}"><i
                                                        class="fa fa-plus"></i> Tempahan Baru</a>
                                                <a class="btn btn-sm btn-info float-centre" href="{{ route('pemohon.lihat_bilik') }}"><i class="fa fa-eye"></i> Lihat Profil Bilik</a>
                                                <a class="btn btn-sm btn-secondary float-centre" data-toggle="modal" data-target="#modal-default"><i class="fa fa-filter"></i> Tapis Kalendar</a>
                                                <br>
                                        </div>

                                    </div>
                                    
                                
                                    {{-- FullCalendar Display --}}
                                    <div id="calendar"></div>

                                <div class="container" id="container">
                                    <!-- Modal Click Event Calendar -->
                                    <div class="modal fade" id="calendarModal" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Butiran Tempahan
                                                    </h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p class="text-left text-justify" id='ID'></p> <!-- Tuk debug id -->
                                                    <p class="text-left text-justify" id='id_tempahan'></p>
                                                    {{-- <p class="text-left text-justify" id='namaMeeting'></p> --}}
                                                    <p class="text-left text-justify" id='namaBilik'></p>
                                                    <p class="text-left text-justify" id='pemohon'></p>
                                                    <p class="text-left text-justify" id='masaMula'></p>
                                                    <p class="text-left text-justify" id='masaTamat'></p>
                                                    <p class="text-left text-justify" id='status'></p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Tutup</button>
                                                    <form action="{{ route('pemohon.butiran_bilikcalendar') }}"
                                                        method="post">
                                                        {{ csrf_field() }}
                                                        <input type="hidden" name="idEvent" id="idEvent" value="">
                                                        @if($pemohon)
                                                        <input type="hidden" name="idPemohon" id="idPemohon" value="{{ $pemohon->id_pemohon }}">
                                                        <button type="submit" class="btn btn-primary" id="Lihat">Lihat</button>
                                                        @else
                                                        @endif
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <!--POPUP MODAL SEBELUM PERMOHONAN -->
                                    <div class="modal fade " id="tatacaraModal" tabindex="-1" role="dialog"
                                        aria-labelledby="tatacaraModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-xl" role="document" style="width: 50rem;">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <button type="button" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="card-header bg-purple" align="center">
                                                        <h7 style="text-transform:uppercase">TATACARA PERMOHONAN</h7>
                                                    </div>
                                                    <div class="card-body">
                                                        <p class="text-left text-justify">
                                                            1) Semua permohonan adalah secara atas talian. <br>
                                                            2) Permohonan hendaklah dikemukakan selewat-lewatnya tiga (3)
                                                            hari sebelum tarikh Mesyuarat / Program. <br>
                                                            3) Permohonan adalah terbuka kepada semua warga Kementerian /
                                                            Jabatan. <br>
                                                            4) Keutamaan adalah kepada Mesyuarat / Program yang
                                                            dipengerusikan
                                                            oleh / melibatkan Pengurusan Tertinggi Kementerian / Bahagian
                                                            Tersebut. <br>
                                                            5) Permohonan dari lain-lain Kementerian perlu mengemukakan
                                                            Surat
                                                            Permohonan kepada Setiausaha Bahagian berkenaan. <br>
                                                            6) Sebarang pembatalan tempahan perlu dibuat 2 hari (48 jam)
                                                            sebelum tarikh mesyuarat berlangsung.
                                                        </p>
                                                    </div>

                                                    <div class="card-header bg-purple" align="center">
                                                        <h7 style="text-transform:uppercase">ETIKA PENGGUNAAN BILIK</h7>
                                                    </div>
                                                    <div class="card-body">
                                                        <p class="text-left text-justify">
                                                            1) Pastikan suis lampu dan semua peralatan elektrik ditutup
                                                            selepas
                                                            digunakan. <br>
                                                            2) Pastikan kerusi disusun kemas selepas digunakan. <br>
                                                            3) Pastikan tiada bahan mesyuarat ditinggalkan di meja atau di
                                                            bilik
                                                            mesyuarat selepas mesyuarat. <br>
                                                            4) Pastikan tiada sampah di atas meja dan di atas lantai. <br>
                                                            5) Pastikan pintu bilik ditutup selepas Mesyuarat / Program
                                                            selesai.
                                                            <br>
                                                        </p>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <!-- <button type="submit" name="" class="btn btn-info">Hantar</button> -->
                                    {{-- <button type="button" class="btn-sm btn-default float-right"
                                        onclick="history.back();"><i class="fas fa-redo-alt"></i> | Kembali</button> --}}
                                    {{-- <a href="{{ url('search',$pemohon->mykad) }}" class="btn btn-sm btn-default float-right" title="Laman Utama"><i class="fas fa-redo-alt"></i> | Kembali</a> --}}
                                    <a href="{{ url('search',$result->nokp) }}" class="btn btn-sm btn-default float-right"><i class="fas fa-redo-alt"></i> | Kembali</a>
                                </div>
                                <!-- /.card-footer -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!--/.col (right) -->
                    </div>
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
    </div>

    <!-- MODAL TAPIS  -->
  <div class="modal fade" id="modal-default">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-purple">
          <h5 class="modal-title">Tapis Kalendar</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form class="form-horizontal" method="POST" action="{{ route('pemohon.tambah_tempahanbilik', $result->nokp) }}" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="modal-body">

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">Aras</label>
                </div>
                <select class="custom-select" id="cariAras" name="cariAras">
                    <option value="" selected disabled>-- Pilih Aras --</option>
                    <option value="5">Aras 5</option>
                    <option value="6">Aras 6</option>
                    <option value="7">Aras 7</option>
                    <option value="8">Aras 8</option>
                    <option value="9">Aras 9</option>
                    <option value="10">Aras 10</option>
                </select>
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">Bilik</label>
                </div>
                    <select class="custom-select" id="cariBilik" name="cariBilik">
                        <option value="" selected disabled>-- Pilih Bilik --</option>
                       
                    </select>
            </div>

          </div>

          <div class="modal-footer justify-content-between">
            <span class="float-right">
              <a href="{{ route('pemohon.tambah_tempahanbilik', $result->nokp) }}" class="btn btn-default" name="reset">Reset</a>
              <button type="submit" class="btn btn-primary bg-purple" name="tapis">Carian</button>
            </span>
          </div>

        </form>
      </div> <!-- /.modal-content -->
    </div> <!-- /.modal-dialog -->
  </div>

@endsection

@section('script')
    {{-- Calendar --}}
    <script>
        $(document).ready(function() {

            var calendar = @json($calendar);
            $('#calendar').fullCalendar({
                contentHeight: "auto",
                displayEventTime: true,
                header: {
                    left: 'prev,next,today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                
                events: calendar,
                
                firstDay: 7,
                dayNamesShort: [ 'Ahad', 'Isnin', 'Selasa', 'Rabu', 'Khamis', 'Jumaat', 'Sabtu'],
                //clickable functions
                selectable: true,
                selectHelper: true,
                nowIndicator: true,
                //navLinks: true,
                eventClick: function(event) {
                    //parse tarikh
                    const strD = event.start_date;
                    const strE = event.end_date;
                    const [year1, month1, day1] = strD.split('-');
                    const [year2, month2, day2] = strE.split('-');

                    $('#calendarModal').modal('toggle');
                    //document.getElementById('ID').innerHTML = "Debug ID: " + event.id;
                    document.getElementById('id_tempahan').innerHTML = "<b>ID Tempahan: </b>" + event.id_tempahan;
                    //document.getElementById('namaMeeting').innerHTML = "<b>Nama Mesyuarat: </b>" + event.title;
                    document.getElementById('namaBilik').innerHTML = "<b>Nama Bilik: </b>" + event
                        .namabilik + ", " + event.bahagianbilik + ", Aras-" + event.arasbilik;
                    document.getElementById('pemohon').innerHTML = "<b>Pemohon: </b>" + event.pemohon + " (" + event.bahagian + ") ";
                    document.getElementById('masaMula').innerHTML = "<b>Tarikh Mula: </b>" + day1 + "/" + month1 + "/" + year1 + " <b>Masa Mula:</b> " + event.start_time;
                    document.getElementById('masaTamat').innerHTML = "<b>Tarikh Tamat: </b>" + day2 + "/" + month2 + "/" + year2 + " <b>Masa Tamat: </b> " + event.end_time;
                    document.getElementById('status').innerHTML = "<b>Status Tempahan: </b>" + event
                        .status;
                    document.getElementById('idEvent').value = event.id;
                    if ( event.pemohon_id != {{ $result->nokp }} ) {
                        $('#Lihat').hide();
                    }
                    else {
                        $('#Lihat').show();
                    }
                }
            })
        });

    </script>

    {{-- @if (session('tapis')) 
        <script>
            //bile tapis tatacara x muncul dah
            $("#tatacaraModal").modal('hide');
        </script>
    @else
        <script type="text/javascript">
            //POPUP TATACARA
            $(document).ready(function() {
                $("#tatacaraModal").modal('show');
            });
        </script>
    @endif --}}

    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
    //script for select bilik tapis
        $(document).ready(function(){
            $(document).on('change','#cariAras',function(){
                var aras=$(this).val();
                var div=$(this).parent().parent();
                var op=" ";
                $.ajax({
                    type:'get',
                    url:'{!!URL::to('cariBilik')!!}',
                    data:{'aras':aras},
                    success:function(data){
                    console.log(data);
                    op+='<option value="" selected disabled>-- Pilih Bilik--</option>';
                    for(var i=0;i<data.length;i++){
                        op+='<option value="'+data[i].id_bilik+'">'+data[i].bilik+'</option>';
                    }
                    div.find('#cariBilik').html(" ");
                    div.find('#cariBilik').append(op);
                    },
                    error:function(){
                    }
                });
            });
        });
    
    </script>

    {{-- <script type="text/javascript">
        //POPUP TATACARA
        $(document).ready(function() {
            $("#tatacaraModal").modal('show');
        });
    </script> --}}
@endsection
