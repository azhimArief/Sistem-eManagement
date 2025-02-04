@extends('layouts/masterScreen')
@section('content')

<style>
table, tr, td {
    border: none;
    border-style: hidden;
}

.container1 {
  position: relative;
  /* position: absolute;  */
  /* position: fixed; */
  width: 100%;
}

.image1 {
  display: block;
  /* width: 100%;
  height: auto; */
  padding: 20;
  width:130; 
  height:110;
  /* border-radius: 50%; */
  /* box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); */
}

.overlay1 {
  position: absolute;
  top: 3;
  bottom: 0;
  left: 6.5;
  right: 0;
  /* height: 100%;
  width: 100%; */
  width:115; 
  height:100;
  opacity: 0;
  transition: .5s ease;
  background-color:#301934;
  border-radius: 50%;
  /* font-size:10px; */
}

.container1:hover .overlay1 {
  opacity: 1;
}

.text {
  color: white;
  font-size: 16px;
  position: absolute;
  top: 50%;
  left: 50%;
  -webkit-transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
  text-align: center;
}
a.disabled {
  pointer-events: none;
  cursor: default;
}

</style>

<div class="container">
<!-- <div class="wrapper"> -->

  <div class="container-fluid m-0">
		<!-- <div class="col-md-12"> -->
    <!-- <div class="row justify-content-center m-5 pb-5"> -->
    <div class="row justify-content-center pb-5" style="margin-top:25px">

      <div class="card text-center card-primary">
          @if($result)
          <div class="card-header bg-purple" >
            <h3 class="card-title">Maklumat Pegawai Perpaduan</h3>
          </div>

          <div class="card-body" >
            <div class='table-responsive'>

                <table id="kp-table" class="table " style="border-style: hidden; border: 0px transparent">

                  <tr>
                    <th>Nama Pegawai</th>
                    <td> : </td>
                    <td>{{ $result->name }}</td>
                  </tr>

                  <tr>
                    <th>No. Kad Pengenalan</th>
                    <td> : </td>
                    <td>{{ $result->nokp }}</td>
                    <input id="nokp" type="hidden" class="form-control" name="nokp" value="{{ $result->nokp }}">
                  </tr>

                  <tr>
                    <th>Agensi</th>
                    <td> : </td>
                    <td>{{ ($result->agensi_id!='') ? \App\PLkpAgensi::find($result->agensi_id)->agensi : ' ' }}</td>
                  </tr>

                  <tr>
                    <th>Bahagian</th>
                    <td> : </td>
                    <td>{{ ($result->bahagian_id!='') ? \App\PLkpBahagian::find($result->bahagian_id)->bahagian : ' ' }}</td>
                  </tr>

                  <tr>
                    <th>Jawatan</th>
                    <td> : </td>
                    <td>{{ $result->jawatan }}</td>
                  </tr>

                  <tr>
                    <th>E-mel</th>
                    <td> : </td>
                    <td>{{ $result->email }}</td>
                  </tr>

                  <!-- <tr>
                    <th>No. Telefon Pejabat</th>
                    <td> : </td>
                    <td><input type="text" class="form-control" id="telefon" name="telefon" placeholder="No. Tel. Pejabat" value="{{ old('telefon') }}"></td>
                  </tr>

                  <tr>
                    <th>No. Telefon Bimbit</th>
                    <td> : </td>
                    <td><input type="text" class="form-control" id="tel_bimbit" name="tel_bimbit" placeholder="No. Tel. Bimbit" value="{{ old('tel_bimbit') }}"></td>
                  </tr> -->

                </table>
            </div><!-- /.table -->
            <div class='table-responsive-sm' style="height:100%">
              <div class="input-group-append">
                <!-- <form action="{{ url('/aduan/create') }}" method="post">@csrf<input id="nokp" type="hidden" name="nokp" value="{{ $result->nokp }}"><button type="submit" class="btn btn-app bg-success btn-lg"><i class="fas fa-tools"></i>Aduan ICT</button></form>

                <form action="{{ url('/pinjam/mohon') }}" method="post">@csrf<input id="nokp" type="hidden" class="form-control" name="nokp" value="{{ $result->nokp }}"><button type="submit" class="btn btn-app bg-warning"><i class="fas fa-laptop"></i>Pinjaman ICT</button></form>

                <form action="{{ url('/pinjam/mohon') }}" method="post">@csrf<input id="nokp" type="hidden" class="form-control" name="nokp" value="{{ $result->nokp }}"><button type="submit" class="btn btn-app bg-danger"><i class="fas fa-search"></i>Semakan</button></form> -->

                <!-- <div class="container1"> -->
                  <!-- <form action="{{ url('/pemohon/tempahankenderaan') }}" method="post">@csrf<input id="nokp" type="hidden" name="nokp" value="{{ $result->nokp }}"> -->
                  <!-- <a href="{{ url('/pemohon/tempahankenderaan',$result->nokp ) }}"> -->
                    <!-- <img src="{{ asset('dist/img/car.png') }}" alt="" style="width:150; height:130" > -->
                    <!-- <img style="width:150; height:130" >
                    <button class="btn">Permohonan Kenderaan</button>
                  </a> -->
                  <!-- </form> -->
                <!-- </div> &nbsp;&nbsp; -->
                <div class="container1">
                  <img src="{{ asset('dist/img/vehicle.png') }}" alt="img" class="image1" >
                  <div class="overlay1">
                    <a href="{{ url('/pemohon/tempahankenderaan',$result->nokp ) }}">
                      <div class="text">Tempahan Kenderaan</div>
                    </a>
                  </div>
                </div> &nbsp;&nbsp; &nbsp;&nbsp;
                <div class="container1">
                  <img src="{{ asset('dist/img/calendar-icon.png') }}" alt="img" class="image1" >
                  <div class="overlay1">
                    <a href="{{route('pemohon.tambah_tempahanbilik',['id'=>$result->nokp])}}">
                      <div class="text">Tempahan Bilik Mesyuarat</div>
                    </a>
                  </div>
                </div> &nbsp;&nbsp; &nbsp;&nbsp;
                <div class="container1">
                  <img src="{{ asset('dist/img/magnifying.png') }}" alt="img" class="image1" >
                  <div class="overlay1">
                    <a href="{{ url('/pemohon/semak',$result->nokp ) }}">
                      <div class="text">Semak Tempahan</div>
                    </a>
                  </div>
                </div>
                
              <!-- </div>
              </br>
              <div class="input-group-append"> -->
                <div class="container1">
                  <img src="{{ asset('dist/img/rating.png') }}" alt="img" class="image1" >
                  <div class="overlay1">
                    <a href="{{ url('/pemohon/penilaian',$result->nokp ) }}">
                      <div class="text">Penilaian Perkhidmatan Kenderaan</div>
                    </a>
                  </div>
                </div>
                @if($pemandu)
                &nbsp;&nbsp; &nbsp;&nbsp;
                <div class="container1">
                  <img src="{{ asset('dist/img/write.png') }}" alt="img" class="image1" >
                  <div class="overlay1">
                    <a href="{{ url('/pemandu/catatan',$result->nokp ) }}">
                      <div class="text">Catatan Pemandu Kenderaan</div>
                    </a>
                  </div>
                </div>
                @endif
              </div>
            </div>
          </div>
          @else
          <div class="card-header bg-purple">
            <h3 class="card-title">Rekod Pegawai Tidak Ditemui. </h3>
          </div>
          <div class="card-body" >
            <div class="text-center">
              Sila hubungi Seksyen Sumber Manusia untuk menyemak rekod anda dalam Sistem Personel Perpaduan.
            </div>
          </div>
          @endif
          
          {{-- <button onclick="history.back()"><i class="fas fa-arrow-left"></i> Kembali</button><br>      --}}
          <a class="nav-link text-danger " href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="nav-icon fas fa-sign-out-alt"></i> Log Keluar

          </a>

          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: one;">
              {{ csrf_field() }}
          </form>
      </div>
    </div>
    </div>
  <!-- </div> -->
</div>
@endsection

<script>
$(function () {
  $("#kp-table").DataTable({
    "responsive": true,
    "autoWidth": false,
    "border" : false,
  });
});
</script>

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