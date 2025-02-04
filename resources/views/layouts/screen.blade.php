@extends('layouts/masterScreen')
@section('content')

<div class="login-box" style="width:100%">
  
  <!-- /.login-logo -->
  <div class="card bg-transparent border-0 shadow-none">
    <!-- Automatic element centering -->
    <div class="lockscreen-wrapper">
      <!-- <div class="lockscreen-logo"> -->
        <!-- <img src="{{asset('dist/img/name2.png')}}" align="center"> -->
        
      <!-- </div> -->

      <div class="image">
        <center><img src="{{asset('dist/img/JataNegara0.jpg')}}" class="img-circle elevation-2" width="190" height="180" alt="User Image"></center>
      </div>

      <!-- User name -->
      <div class="lockscreen-name"></div>
      <!-- START LOCK SCREEN ITEM -->
      <div class="lockscreen-item" >
          {{-- Error Login --}}
          @if (session('status'))
            <div class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert">×</button>
              {{ session('status') }}
            </div>
          @elseif(session('failedLogin'))
            <div class="alert alert-danger" role="alert">
              <button type="button" class="close" data-dismiss="alert">×</button>
              {{ session('failedLogin') }}
            </div>
          @endif

          <!-- lockscreen credentials (contains the form) --> 
          <form action="{{ route('pemohon.search') }}" method="post" class="lockscreen-credentials">
            {{-- @csrf --}}
            {{ csrf_field() }}
            <div class="input-group" bg-purple>
              <input type="text" name="nokp" class="form-control" placeholder="Masukkan No. MyKad"  maxlength="12" >
              <div class="input-group-append">
                <button type="submit" class="btn btn-primary"><i class="fas fa-arrow-right text-muted"></i></button>
              </div>
            </div>
          </form>
        </div>
        <center>
        <div style="background-color: transparent; align:center">
        <a href="{{ route('login') }}">
            <span class="badge bg-purple" style="font-size: 15px"><font color="white" size="4px"> {{ __('LOGIN PENTADBIR') }} </font></span>
        </a>
        </div>

        </center>
        
        
        <div style="background-color: transparent; align:center">

          <center><strong><a href="{{ url(''. "uploads/MANUAL_PENGGUNA_SISTEM_eTempahan-Pemohon.pdf") }}"  target="_blank"><font color="#DA70D6" size="2px"> {{ __('MANUAL PENGGUNA') }} </font></a><a href="mailto:bpm@perpaduan.gov.my"  target="_blank"><font color="#DA70D6" size="2px">&nbsp; &nbsp; | &nbsp; &nbsp; {{ __('HELPLINE') }} &nbsp; &nbsp; </font></a></strong></center>

        </div>
        
      </div>
      
    </div>
</div>
<!-- /.login-box -->
@endsection
