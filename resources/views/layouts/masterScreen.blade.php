<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Sistem eTempahan</title>
  <link rel="shortcut icon" href="{{ asset ('dist/img/JataNegara.png') }}" type="image/x-icon">
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{asset('plugins/jqvmap/jqvmap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{asset('plugins/daterangepicker/daterangepicker.css')}}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs4.min.css')}}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
  <!-- Toastr Notification -->
  <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
  

  <style>
    .select2-selection__rendered {
      line-height: 1.7 !important;
    }
    .select2-container .select2-selection--single {
      height: calc(2.25rem + 2px) !important;
    }
    .select2-selection__arrow {
      height: calc(2.25rem + 2px) !important;
    }

    footer {
      text-align: center;
      padding-top: 10px;
      padding-bottom: 6px;
      /* background-color: #4B5B99; */
      background-color: purple;
      color: white;
      position: fixed;
      bottom: 0;
      width: 100%;
      line-height: 10px;
    }

    
  /* For device width smaller than 400px: */
    #bg,#bg1 {
      background-image: url('{{ asset('dist/img/bgtest1-small.jpg') }}');
      background-size: cover; 
      background-position: center;
      position: fixed;
      top: 0;
      left: 0;

      min-width: 100%;
      min-height: 100%;
      
    }
    .navbarC {
      padding: 10px;
      background-color: transparent;
      color: #ffffff;
      position: fixed;
      width: 100%;
    }
    
   
    /* For device width 400px and larger: */
    @media only screen and (min-device-width: 400px) {
      #bg { 
        background-image: url('{{ asset('dist/img/bgtest1.jpg') }}');
        background-size: cover; 
        background-position: center;
        position: fixed;
        top: 0;
        left: 0;

        min-width: 100%;
        min-height: 100%;
        filter: blur(0px); 
        -webkit-filter: blur(0px); 
      }

      #bg1 {
        background-image: url('{{ asset('dist/img/bgtest1.1.jpg') }}');
        background-size: cover; 
        background-position: center;
        position: fixed;
        top: 0;
        left: 0;

        min-width: 100%;
        min-height: 100%;
      
      }
      .navbarC {
        padding: 10px;
        background-color: transparent;
        color: #ffffff;
        position: fixed;
        width: 100%;
      }
    }


    button {
      background-color: transparent;
      background-repeat: no-repeat;
      border: none;
      cursor: pointer;
      overflow: hidden;
      outline: none;
    }

</style>
</head>


<!-- <body class="hold-transition"> -->
<body class="reponsive">

<!-- <div id="app"> -->
  @if (Request::is('/'))
  <div id="bg" ></div>
    
    <nav class="navbarC navbar-expand-md">
        <div class="container">
            <!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button> -->

            
        </div>
    </nav>
    @else
    <div id="bg1" ></div>
    
    @endif
  <!-- Main content -->
  
    @if (Request::is('pemohon*') || Request::is('pemandu*'))
		<!-- <main class="m-5 pb-5 col-sm-12"> -->
		<!-- <main class="m-5 col-sm-12" > -->
    <main class="py-5 container-fluid hold-transition">  
    @elseif (Request::is('search') || Request::is('status'))
    <main class="py-4 container-fluid hold-transition">  
    @else
    <main class="py-3 container-fluid hold-transition login-page">  
    @endif
    <div class="row mb-12">
      <div class="col-sm-12">
        @if (!Request::is('/'))
        <div class="image">
          <center><img src="{{asset('dist/img/JataNegara.png')}}" width="70" height="50" alt="User Image"></center>
          <center><font color= "#191975"><h7><b>KEMENTERIAN PERPADUAN NEGARA</b></h7></font></center><BR>
        </div>
        <!-- <div class="login-page"> -->

        @endif
        <center><font color="black"><h1><b>SISTEM eTEMPAHAN</b></h1></font></center>
        <center><h5 class="m-0" >SISTEM TEMPAHAN BILIK MESYUARAT / KENDERAAN JABATAN</h5></center>
        <!-- <center><h4 class="m-0"> </h4></center><br> -->
      </div><!-- /.col -->
      
    </div>  
    <div class="row justify-content-center" >
      @yield('content')
    </div>
  </main>
  
  <!-- @yield('contentB') -->
  <!-- /.content -->
<!-- </div> -->
</body>
<footer>
  <!-- <p> -->
      
    <strong>&copy; <script>document.write(new Date().getFullYear())</script> - Kementerian Perpaduan Negara</strong>
  <br><br><font style="font-size:10px">Paparan terbaik menggunakan pelayar internet Google Chrome atau Mozilla Firefox terkini dengan resolusi 1024 x 768 pixels.</font>
  <!-- </p> -->
</footer>
<!-- /.center-->

<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- bs-custom-file-input -->
<script src="{{asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
<!-- Select2 -->
<script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{asset('plugins/chart.js/Chart.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{asset('plugins/sparklines/sparkline.js')}}"></script>
<!-- JQVMap -->
<script src="{{asset('plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{asset('plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset('plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{asset('plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Summernote -->
<script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('dist/js/demo.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{asset('dist/js/pages/dashboard.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('dist/js/demo.js')}}"></script>
<!-- DataTables  & Plugins -->
<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<!-- PAGE SCRIPTS -->
<script src="{{asset('dist/js/pages/dashboard2.js')}}"></script>
@yield('script')
<!-- Toastr Notification -->
<!-- <script src="http://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script> -->
<script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
{!! Toastr::message() !!}

</html>
