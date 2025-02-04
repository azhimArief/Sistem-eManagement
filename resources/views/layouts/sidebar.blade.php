<style>
[class*="sidebar-dark-"] {
  background-color:	#301934;
  /* color:black */
}
  .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link.active,
.sidebar-light-primary .nav-sidebar > .nav-item > .nav-link.active {
  background-color:#5D3FD3;
  /* color: #fff; */
}

</style>
<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <!-- Add icons to the links using the .nav-icon class
          with font-awesome or any other icon font library -->
    @if (Auth::user()->id_access == '1' || Auth::user()->id_access == '2' || Auth::user()->id_access == '4') 
      <li class="{{ Request::is('home') ? 'nav-item menu-open' : 'nav-item' }}">
        <a href="{{ url('/home') }}" class="{{ Request::is('home') ? 'nav-link active' : 'nav-link' }}">
          <i class="nav-icon fas fa-tachometer-alt"></i>
          <p>Dashboard Kenderaan</p>
        </a>
      </li>
    @endif
    

    @if (Auth::user()->id_access == '3' || Auth::user()->id_access == '2' || Auth::user()->id_access == '4') 
      <li class="{{ Request::is('homeBilikMeet') ? 'nav-item menu-open' : 'nav-item' }}">
        <a href="{{ url('homeBilikMeet') }}" class="{{ Request::is('homeBilikMeet') ? 'nav-link active' : 'nav-link' }}">
          <i class="nav-icon fas fa-tachometer-alt"></i>
          <p>Dashboard Mesyuarat</p>
        </a>
      </li>
    @endif
    
    
    <li class="nav-header">Permohonan</li>
    {{-- Tempahan Kenderaan --}}
    @if (Auth::user()->id_access == '1' || Auth::user()->id_access == '2' || Auth::user()->id_access == '4') 
      <li class="{{ Request::is('tempahankenderaan*') ? 'nav-item menu-open' : 'nav-item' }}">
        <a href="#" class="{{ Request::is('tempahankenderaan*') ? 'nav-link active' : 'nav-link' }}">
          <i class="nav-icon fa fa-car"></i>
          <p>Tempahan Kenderaan <i class="right fas fa-angle-left"></i></p>
        </a>

        <ul class="nav nav-treeview">
          @if (Auth::user()->id_access == '1' || Auth::user()->id_access == '4')  
            <li class="nav-item">
              <a href="{{ url('tempahankenderaan/tambah') }}" class="{{ Request::is('tempahankenderaan/tambah') ? 'nav-link active' : 'nav-link' }}">
                <i class="far fa-circle nav-icon" style="color:#FF00FF"></i>  
                <p>Tempahan Baru </p>
              </a>
            </li>
          @endif
          <li class="nav-item">
            <a href="{{ url('tempahankenderaan') }}" class="{{ Request::is('tempahankenderaan') ? 'nav-link active' : 'nav-link' }}">
              <i class="far fa-circle nav-icon"  style="color:#FF00FF"></i>
              <p>Senarai Tempahan </p>
            </a>
          </li>
        </ul>
      </li>
    @endif
      
      {{-- Tempahan Bilik Mesyuarat --}}
    @if (Auth::user()->id_access == '3' || Auth::user()->id_access == '2' || Auth::user()->id_access == '4') 
        <li class="{{ Request::is('tempahanbilik*') ? 'nav-item menu-open' : 'nav-item' }}" >
        <a href="#" class="{{ Request::is('tempahanbilik*') ? 'nav-link active' : 'nav-link' }} " >
          <i class="nav-icon fas fa-columns"></i>
          <p>Tempahan Bilik <i class="right fas fa-angle-left"></i></p>
        </a>
        
          <ul class="nav nav-treeview">  
            @if (Auth::user()->id_access == '3' || Auth::user()->id_access == '4')
              <li class="nav-item">
                <a href="{{ url('tempahanbilik/tambah') }}" class="{{ Request::is('tempahanbilik/tambah') ? 'nav-link active' : 'nav-link' }}">
                  <i class="far fa-circle text-info nav-icon "></i>
                  <p>Tempahan Baru </p>
                </a>
              </li>
            @endif
            <li class="nav-item">
              <a href="{{ url('tempahanbilik/jadual') }}" class="{{ Request::is('tempahanbilik/jadual') ? 'nav-link active' : 'nav-link' }}">
                <i class="far fa-circle nav-icon text-info"></i>
                <p>Jadual Tempahan </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('tempahanbilik') }}" class="{{ Request::is('tempahanbilik') ? 'nav-link active' : 'nav-link' }}">
                <i class="far fa-circle nav-icon text-info"></i>
                <p>Senarai Tempahan </p>
              </a>
            </li>
          </ul>
        </li>
      @endif
    
	
	<!-- <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-edit"></i>
        <p>Penilaian<i class="right fas fa-angle-left"></i></p>
      </a>

      <ul class="nav nav-treeview">  
        <li class="nav-item">
          <a href="{{ url('penilaian/borang') }}" class="nav-link">
            <i class="far fa-circle text-warning nav-icon "></i>
            <p>Penilaian Kenderaan</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ url('penilaian/catatanpemandu') }}" class="nav-link">
            <i class="far fa-circle nav-icon text-warning"></i>
            <p>Penilaian Pemandu</p>
          </a>
        </li>
      </ul>
    </li> -->
	
    <!-- </li> -->
    @if (Auth::user()->id_access == '1' || Auth::user()->id_access == '3' || Auth::user()->id_access == '4')
      <li class="nav-header">Pentadbir Sistem </li>

        @if (Auth::user()->id_access == '1' || Auth::user()->id_access == '4') 
          {{-- Tetapan Kenderaan --}}
          <li class="{{ (Request::is('kenderaan') || Request::is('pemandu') || Request::is('jadual')) ? 'nav-item menu-open' : 'nav-item' }}">
            <a href="#" class="{{ (Request::is('kenderaan') || Request::is('pemandu') || Request::is('jadual')) ? 'nav-link active' : 'nav-link' }}">
              <i class="nav-icon fa fa-car"></i>
              <p> Tetapan Kenderaan <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('kenderaan') }}" class="{{ Request::is('kenderaan') ? 'nav-link active' : 'nav-link' }}">
                  <i class="nav-icon far fa-circle" style="color:#FF00FF"></i>
                  <p>Senarai Kenderaan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('pemandu') }}" class="{{ Request::is('pemandu') ? 'nav-link active' : 'nav-link' }}">
                  <i class="nav-icon far fa-circle" style="color:#FF00FF"></i>
                  <p>Senarai Pemandu</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('jadual') }}" class="{{ Request::is('jadual') ? 'nav-link active' : 'nav-link' }}">
                  <i class="nav-icon far fa-circle" style="color:#FF00FF"></i>
                  <p>Jadual Pemandu</p>
                </a>
              </li>
            </ul>
          </li>
        @endif
      
      
        @if (Auth::user()->id_access == '3' || Auth::user()->id_access == '4')
          {{-- Tetapan Bilik --}}
          <li class="{{ Request::is('bilik*') ? 'nav-item menu-open' : 'nav-item' }} ">
            <a href="#" class="{{ Request::is('bilik*') ? 'nav-link active' : 'nav-link' }} ">
              <i class="nav-icon fas fa-columns"></i>
              <p> Tetapan Bilik <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('bilik') }}" class="{{ Request::is('bilik') ? 'nav-link active' : 'nav-link' }}">
                  <i class="nav-icon far fa-circle text-info"></i>
                  <p> Senarai Bilik</p>
                </a>
              </li>
            </ul>
          </li>

          {{-- Tetapan Katerer --}}
          <li class="{{ Request::is('katerer*') ? 'nav-item menu-open' : 'nav-item' }} ">
            <a href="#" class="{{ Request::is('katerer*') ? 'nav-link active' : 'nav-link' }} ">
              {{-- <i class="nav-icon fas fa-food"></i> --}}
              <i class="nav-icon fas fa-utensils"></i>
              <p> Tetapan Katerer <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('katerer') }}" class="{{ Request::is('katerer') ? 'nav-link active' : 'nav-link' }}">
                  <i class="nav-icon far fa-circle text-warning"></i>
                  <p> Senarai Katerer</p>
                </a>
              </li>
            </ul>
          </li>
        @endif
      

        {{-- Pengguna --}}
        <li class="{{ Request::is('pengguna') ? 'nav-item menu-open' : 'nav-item' }}">
          <a href="{{ url('pengguna') }}" class="{{ Request::is('pengguna') ? 'nav-link active' : 'nav-link' }}">
            <i class="nav-icon fas fa-users"></i>
            <p> Pengguna 
            </p>
          </a>
        </li>
    
    @endif    

    @if(Auth::user()->id_access == '1' || Auth::user()->id_access == '2' || Auth::user()->id_access == '3' || Auth::user()->id_access == '4') 
        <li class="nav-header">Laporan</li> 
        @if(Auth::user()->id_access == '1' || Auth::user()->id_access == '2' || Auth::user()->id_access == '4') 
          {{-- Laporan Kenderaan --}}
          <li class="{{ Request::is('laporan*') ? 'nav-item menu-open' : 'nav-item' }}">
            <a href="#" class="{{ Request::is('laporan*') ? 'nav-link active' : 'nav-link' }}">
              <i class="nav-icon fa fa-car"></i>
              <p>Laporan Kenderaan<i class="right fas fa-angle-left"></i></p>
              {{-- <p>Laporan Keseluruhan<i class="right fas fa-angle-left"></i></p> --}}
            </a>
            <ul class="nav nav-treeview">
              <!-- <li class="nav-item">
                <a href="{{ url('kenderaan') }}" class="{{ Request::is('laporan/permohonan') ? 'nav-link active' : 'nav-link' }}">
                  <i class="nav-icon far fa-circle text-info"></i>
                  <p>Senarai Permohonan</p>
                </a>
              </li> -->
              <li class="nav-item">
                <a href="{{ url('laporan/pemandu') }}" class="{{ Request::is('laporan/pemandu') ? 'nav-link active' : 'nav-link' }}">
                  <i class="nav-icon far fa-circle" style="color:#FF00FF"></i>
                  <p>Pergerakan Pemandu</p>
                </a>
              </li>
          
              <li class="nav-item">
                <a href="{{ url('laporan/keseluruhan') }}" class="{{ Request::is('laporan/keseluruhan') ? 'nav-link active' : 'nav-link' }}">
                  <i class="nav-icon far fa-circle"  style="color:#FF00FF"></i>
                  <p>Laporan Keseluruhan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('laporan/penilaian') }}" class="{{ Request::is('laporan/penilaian') ? 'nav-link active' : 'nav-link' }}">
                  <i class="nav-icon far fa-circle"  style="color:#FF00FF"></i>
                  <p>Laporan Penilaian</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('laporan/ulasanpemandu') }}" class="{{ Request::is('laporan/ulasanpemandu') ? 'nav-link active' : 'nav-link' }}">
                  <i class="nav-icon far fa-circle "  style="color:#FF00FF"></i>
                  <p>Ulasan Pemandu</p>
                </a>
              </li>
            </ul>
          </li>
        @endif

        @if (Auth::user()->id_access == '2' || Auth::user()->id_access == '3' || Auth::user()->id_access == '4')
            {{-- Laporan Bilik --}}
          <li class="{{ Request::is('laporbilik*') ? 'nav-item menu-open' : 'nav-item' }}">
            <a href="#" class="{{ Request::is('laporbilik*') ? 'nav-link active' : 'nav-link' }}">
              <i class="nav-icon fa fa-columns"></i>
              <p>Laporan Bilik<i class="right fas fa-angle-left"></i></p>
            </a>

            <ul class="nav nav-treeview">

              <li class="nav-item">
                <a href="{{ url('laporbilik/keseluruhan') }}" class="{{ Request::is('laporbilik/keseluruhan') ? 'nav-link active' : 'nav-link' }}">
                  <i class="nav-icon far fa-circle text-info"></i>
                  <p>Laporan Keseluruhan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('laporbilik/katerer') }}" class="{{ Request::is('laporbilik/katerer') ? 'nav-link active' : 'nav-link' }}">
                  <i class="nav-icon far fa-circle text-info"></i>
                  <p>Laporan Katerer</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('laporbilik/katerer/bulanan') }}" class="{{ Request::is('laporbilik/katerer/bulanan') ? 'nav-link active' : 'nav-link' }}">
                  <i class="nav-icon far fa-circle text-info"></i>
                  <p>Laporan Katerer Bulanan(Testing)</p>
                </a>
              </li>
              
            </ul>
          </li>   
        @endif
    @endif
    

    <!-- </li> -->
    @if (Auth::user()->id_access == '1' || Auth::user()->id_access == '3' || Auth::user()->id_access == '4')
      <li class="nav-header">Manual Pengguna </li>
    
      <li class="nav-item has-treeview">
        <a href="{{ url(''. "uploads/MANUAL_PENGGUNA_SISTEM_eTempahan-Pemohon.pdf") }}" class="nav-link" target="_blank">
          <i class="nav-icon far fa-circle" style="color:orange"></i>
          <p>Pemohon</p>
        </a>
      </li>

      <li class="nav-item has-treeview">
        <a href="{{ url(''. "uploads/MANUAL_PENGGUNA_SISTEM_eTempahan-Pentadbir_Sistem.pdf") }}" class="nav-link" target="_blank">
          <i class="nav-icon far fa-circle"  style="color:orange"></i>
          <p>Pentadbir Sistem</p>
        </a>
      </li>
      
    {{-- </li> --}}
    @endif   

    <li class="nav-header">Sistem</li>     
      <li class="nav-item has-treeview">
        <a href="{{ route('logout') }}"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link" >
          <i class="nav-icon fas fa-sign-out-alt "></i>
          <p>Log Keluar</p>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
          </form>
        </a>
      </li>
    </li>

  </ul>
</nav>
<!-- /.sidebar-menu -->
</div>