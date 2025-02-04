@extends('layouts.adminLayout.admin_design')
@section('content')
<!--sidebar-menu-->
@include('layouts.adminLayout.admin_sidebar')

<!--sidebar-menu-->
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="{{ url('/#') }}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Utama</a> <a href="">eKAPP</a> 
    <a href="{{ url('/admin/ekapp/create') }}" class="current">Ambil Penilaian</a> </div>
    
    <h1>Kursus Asas Pertubuhan Online (eKAPP)</h1>
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div><br />
    @endif
  </div>
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
            <h5>Borang Penilaian</h5>
          </div>
          <div class="">
          
            <form class="form-horizontal" method="post" action="{{ route('penilaian.create') }}" name="basic_validate" id="basic_validate" novalidate="novalidate">{{ csrf_field() }}
   
            <label for="name" class="col-lg-1.5 col-form-label"><center><b><u>BORANG PENILAIAN PERKHIDMATAN KENDERAAN JABATAN KEMENTERIAN PERPADUAN NEGARA </u></b></center></label>
			<label for="name" class="col-lg-1.5 col-form-label">Terima kasih kerana menggunakan Perkhidmatan Kenderaan Jabatan Kementerian Perpaduan Negara. Mohon kerjasama untuk memberikan penilaian dan maklum balas bagi perkhidmatan Kenderaan Jabatan Kementerian Perpaduan Negara yang telah disediakan seperti yang berikut:</label>

            <div class="control-group ">
                <div class="controls">

                    @foreach($soalan as $que)
                      
                      <label for="name" class="col-lg-1.5 col-form-label">{!!$que->name!!} : </label>
                      <input class="form-control" type="hidden" name="content_id[{{$que->id}}]" value="{{$que->id}}" >
                      <label for="name" class="col-lg-10 col-form-label">{!!$que->description!!}</label>
                              
                      @foreach($pilihan as $key=>$pilih)
                        @if($que->id == $pilih->content_id)
                                      
                          <input type="radio" name="pili[{{$que->id}}]" value="{{$pilih->id}}" required> {!!$pilih->name!!}<br>
                                      
                        @endif
                      @endforeach
                                  
                      <br>
                                  
                      <div class="col-lg-10"><input class="form-control" type="hidden" name="jawapan[{{$que->id}}]" value="{{$que->answer}}" ></div>
                        
                    @endforeach
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Seterusnya</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    
  </div>
</div>

@endsection