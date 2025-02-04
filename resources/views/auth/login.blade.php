@extends('layouts/masterLogin')
@section('contentLogin')


<div class="login-box" style="width:100%">
  <!-- <div class="login-logo">
    <a href=""><b>Log</b>Masuk</a> <br><small>[Rumah Ibadat Selain Islam]</small>
  </div> -->
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body" style="margin:0; padding:2">
      <p class="login-box-msg">
          @if(session('failedLogin'))
            <div class="alert alert-danger" role="alert">
              <button type="button" class="close" data-dismiss="alert">×</button>
              {{ session('failedLogin') }}
            </div>
          @endif  

          @error('mykad') 
            <div class="alert alert-danger" role="alert">
              <button type="button" class="close" data-dismiss="alert">×</button>
              Login Gagal. <br>
              {{ $message }}
            </div>
            {{-- <div class="text-danger text-strong">{{ $message }}</div>  --}}
          @enderror
      </p>

      <form method="POST" action="{{ route('login') }}">
      {{-- @csrf --}}
      {{ csrf_field() }}
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="mykad" placeholder="Masukkan ID Pengguna">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block bg-purple">Log Masuk</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->
@endsection
