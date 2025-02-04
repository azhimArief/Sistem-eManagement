@extends('layouts/Calendarmaster')
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
                margin: 0 auto;
                */ font-size: 12px;
            }
            .fc-time {
                display: none;
                /* visibility: hidden; */
            }
            .fc-sat {
                background-color: #F1f5f4
            }
            .fc-sun {
                background-color: #F1f5f4
            }
        </style>
    </head>
    <!-- Content Header (Page header) -->
    <div class="content-header" bgcolor="#d2d5d5">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">TEMPAHAN BILIK</h1>
                </div><!-- /.col -->

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/homeBilikMeet') }}">Laman Utama</a></li>
                        <li class="breadcrumb-item">Jadual Tempahan</li>
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
                            <h2 class="card-title" style="margin-top:5px; bgcolor :#CF9FFF">Jadual Tempahan</h2>
                            <span class="float-right">
                                <!-- <a class="btn btn-sm" data-toggle="modal" data-target="#modal-default"><i class="fa fa-filter"></i> Tapis</a> -->
                                <a class="btn btn-sm" data-toggle="modal" data-target="#modal-default"><i
                                        class="fa fa-filter"></i> Tapis</a>
                                <a href="{{ url('tempahanbilik/tambah') }}" class="btn btn-sm"><i class="fa fa-plus"></i>
                                    Tambah</a>
                            </span>
                        </div>
                    </div>
                    <center>
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
                        </div>
                    </center>

                    {{-- FullCalendar Display --}}
                    <div id="calendar"></div>

                    <div class="container" id="container">
                        <!-- Modal Click Event Calendar -->
                        <div class="modal fade" id="calendarModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title fs-5" id="exampleModalLabel">Butiran Tempahan
                                        </h4>
                                        {{-- <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button> --}}
                                    </div>
                                    <div class="modal-body">
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
                                        <form action="{{ route('tempahanbilik.butiran_bilikcalendar') }}"
                                          method="post">
                                          {{ csrf_field() }}
                                          <input type="hidden" name="idEvent" id="idEvent" value="">
                                          <button type="submit" class="btn btn-primary" id="Lihat">Lihat</button>
                                      </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- MODAL TAPIS  -->
                        <div class="modal fade" id="modal-default">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-purple">
                                        <h5 class="modal-title">Tapis Jadual</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form class="form-horizontal" method="POST"
                                        action="{{ route('tempahanbilik.jadual') }}" enctype="multipart/form-data">
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
                                                <a href="{{ route('tempahanbilik.jadual') }}" class="btn btn-default"
                                                    name="reset">Reset</a>
                                                <button type="submit" class="btn btn-primary bg-purple"
                                                    name="tapis">Carian</button>
                                            </span>
                                        </div>

                                    </form>
                                </div> <!-- /.modal-content -->
                            </div> <!-- /.modal-dialog -->
                        </div>

                    </div>

                    <!-- /.card -->
                </div>
                <!--/.col (right) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
@endsection


@section('script')
    <script> //calendar script
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
                dayNamesShort: ['Ahad', 'Isnin', 'Selasa', 'Rabu', 'Khamis', 'Jumaat', 'Sabtu'],
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
                    document.getElementById('id_tempahan').innerHTML = "<b>ID Tempahan: </b>" + event
                        .id_tempahan;
                    //document.getElementById('namaMeeting').innerHTML = "<b>Nama Mesyuarat: </b>" + event.title;
                    document.getElementById('namaBilik').innerHTML = "<b>Nama Bilik: </b>" + event
                        .namabilik + ", " + event.bahagianbilik + ", Aras-" + event.arasbilik;
                    document.getElementById('pemohon').innerHTML = "<b>Pemohon: </b>" + event.pemohon +
                        " (" + event.bahagian + ") ";
                    document.getElementById('masaMula').innerHTML = "<b>Tarikh Mula: </b>" + day1 +
                        "/" + month1 + "/" + year1 + " <b>Masa Mula:</b> " + event.start_time;
                    document.getElementById('masaTamat').innerHTML = "<b>Tarikh Tamat: </b>" + day2 +
                        "/" + month2 + "/" + year2 + " <b>Masa Tamat: </b> " + event.end_time;
                    document.getElementById('status').innerHTML = "<b>Status Tempahan: </b>" + event
                        .status;
                    document.getElementById('idEvent').value = event.id;

                }
            })
        });
    </script>

    <script type="text/javascript">
        //script for select bilik tapis
        $(document).ready(function() {
            $(document).on('change', '#cariAras', function() {
                var aras = $(this).val();
                var div = $(this).parent().parent();
                var op = " ";
                $.ajax({
                    type: 'get',
                    url: '{!! URL::to('cariBilik') !!}',
                    data: {
                        'aras': aras
                    },
                    success: function(data) {
                        console.log(data);
                        op += '<option value="" selected disabled>-- Pilih Bilik--</option>';
                        for (var i = 0; i < data.length; i++) {
                            op += '<option value="' + data[i].id_bilik + '">' + data[i].bilik +
                                '</option>';
                        }
                        div.find('#cariBilik').html(" ");
                        div.find('#cariBilik').append(op);
                    },
                    error: function() {}
                });
            });
        });
    </script>

    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "fnDrawCallback": function(oSettings) {
                    /* Need to redo the counters if filtered or sorted */
                    if (oSettings.bSorted || oSettings.bFiltered) {
                        for (var i = 0, iLen = oSettings.aiDisplay.length; i < iLen; i++) {
                            $('td:eq(0)', oSettings.aoData[oSettings.aiDisplay[i]].nTr).html(i + 1);
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
