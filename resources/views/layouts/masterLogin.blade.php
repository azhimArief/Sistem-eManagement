<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Sistem eTempahan</title>
  <link rel="shortcut icon" href="{{ asset ('dist/img/JataNegara.png') }}" type="image/x-icon">
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="{{asset('plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css')}}">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="{{asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- Toastr Notification -->
   <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">

  <style>

    footer {
      text-align: center;
      padding-top: 10px;
      padding-bottom: 6px;
      /* padding: 10px; */
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
      
    }
</style>
</head>
<body class="hold-transition login-page">
<div id="app">
  <div id="bg"></div>
    
  <div class="container-fluid">
    <!-- <div class="row mb-2"> -->
      
      <div class="col-sm-12">
        <div class="image">
          <center><img src="{{asset('dist/img/JataNegara.png')}}" width="70" height="50" alt="User Image"></center>
          <center><font color= "#191975" size="2px"><b>KEMENTERIAN PERPADUAN NEGARA</b></font></center>
        </div>
        <center><font color= "black"><h2><b>SISTEM eTEMPAHAN</b></h2></font></center>
        <!-- <center><h4 class="m-0"> </h4></center><br> -->
      </div><!-- /.col -->
    <!-- </div> -->
  </div>

  <!-- Main content -->
    @yield('contentLogin')
  <!-- /.content -->
</div>
</body>
<footer>
  <!-- <p><strong>&copy; <script>document.write(new Date().getFullYear())</script> - Kementerian Perpaduan Negara</strong></p> -->
  <strong>&copy; <script>document.write(new Date().getFullYear())</script> - Kementerian Perpaduan Negara</strong>
  <br><br><font style="font-size:10px">Paparan terbaik menggunakan pelayar internet Google Chrome atau Mozilla Firefox terkini dengan resolusi 1024 x 768 pixels.</font>
</footer>
<!-- /.center-->

<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="{{asset('plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.js')}}"></script>
<!-- OPTIONAL SCRIPTS -->
<script src="{{asset('dist/js/demo.js')}}"></script>
<!-- Bootstrap Switch -->
<script src="{{asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('dist/js/demo.js')}}"></script>
<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="{{asset('plugins/jquery-mousewheel/jquery.mousewheel.js')}}"></script>
<script src="{{asset('plugins/raphael/raphael.min.js')}}"></script>
<script src="{{asset('plugins/jquery-mapael/jquery.mapael.min.js')}}"></script>
<script src="{{asset('plugins/jquery-mapael/maps/usa_states.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{asset('plugins/chart.js/Chart.min.js')}}"></script>
<!-- PAGE SCRIPTS -->
<script src="{{asset('dist/js/pages/dashboard2.js')}}"></script>
<!-- Toastr Notification -->
<script src="http://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
{!! Toastr::message() !!}

</html>
