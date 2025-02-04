@extends('layouts/masterScreen')
@section('content')



<div class="wrapper">

  <div class="container-fluid">
    <div class="row justify-content-center m-5 pb-5">

      <div class="card text-center card-default">
        <div class="col-md-12">
          @if (session('status'))
          <div class="alert" role="alert">
            <!-- <button type="button" class="close" data-dismiss="alert">×</button> -->
            {{ session('status') }}
          </div>
          @elseif(session('failed'))
          <div class="alert" role="alert">
            <!-- <button type="button" class="close" data-dismiss="alert">×</button> -->
            {{ session('failed') }}
          </div>
          @endif
          <!-- <button onclick="history.back()"><i class="fas fa-arrow-left"></i> Kembali</button><br> -->
          <a href="{{ url('/') }}" style="color:black"><i class="fas fa-arrow-left"></i> Kembali</button></a><br>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection


<!-- /* .container1 {
  position: relative;
  width: 100%;
  max-width: 400px;
  
}

.container1 img {
  width: 100%;
  height: auto;
  border-radius: 70%;
  background-color: white;
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}

.container1 .btn {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  background-color: transparent;
  color: black;
  font-size: 20px;
  font-style:bold;
  padding: 12px 24px;
  border: none;
  cursor: pointer;
  border-radius: 5px;
  text-align: center;
  opacity: 0.6;
  transition: 0.3s;
}

.container1 .btn:hover {
  background-color: transparent;
  color: black;
  text-shadow: 4px 2px 4px #000000;
  text-shadow: 4px 2px 4px #ffffff;
  opacity: 1; 
}*/ -->