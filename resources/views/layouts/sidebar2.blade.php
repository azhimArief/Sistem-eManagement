<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <!-- Add icons to the links using the .nav-icon class
          with font-awesome or any other icon font library -->
    <li class="nav-item menu-open">
      <a href="{{ url('dashboard') }}" class="nav-link active">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
      </a>
    </li>

    <li class="nav-header">Pemohon</li>
    <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-edit"></i>
        <p>Tempahan Kenderaan <i class="right fas fa-angle-left"></i></p>
			</a>

      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{ url('tempahankenderaan/tambah') }}" class="nav-link">
            <i class="far nav-icon"></i>
            <p>Tempahan Baru </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ url('tempahankenderaan') }}" class="nav-link">
            <i class="far nav-icon"></i>
            <p>Semak Status Tempahan </p>
          </a>
        </li>
      </ul>
    </li>

    <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-edit"></i>
        <p>Tempahan Bilik <i class="right fas fa-angle-left"></i></p>
			</a>

		  <ul class="nav nav-treeview">  
        <li class="nav-item">
          <a href="{{ url('risi/tambah') }}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Tempahan Baru </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ url('risi') }}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Semak Status Tempahan </p>
          </a>
        </li>
      </ul>
    </li>

    <li class="nav-header">Penyelia</li>
    <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-users"></i>
        <p> Tempahan Kenderaan <i class="right fas fa-angle-left"></i></p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ url('kenderaan/senarai') }}" class="nav-link">
            <i class="nav-icon fas fa-edit"></i>
            <p>Senarai</p>
          </a>
        </li>
        <!-- <li class="nav-item">
          <a href="{{ url('pengguna/tambah') }}" class="nav-link">
            <i class="nav-icon far fa-plus-square"></i>
            <p>Tambah Pengguna</p>
          </a>
        </li> -->
        <li class="nav-item">
          <a href="{{ url('penyeliakenderaan/pemandu/tambah') }}" class="nav-link">
            <i class="nav-icon far fa-plus-square"></i>
            <p>Tambah Pemandu</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ url('penyeliakenderaan/kenderaan/tambah') }}" class="nav-link">
            <i class="nav-icon far fa-plus-square"></i>
            <p>Tambah Kenderaan</p>
          </a>
        </li>
        
      </ul>
    </li>
    <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-users"></i>
        <p> Tempahan Bilik <i class="right fas fa-angle-left"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ url('pengguna') }}" class="nav-link">
            <i class="nav-icon fas fa-edit"></i>
            <p>Senarai </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ url('pengguna/tambah') }}" class="nav-link">
            <i class="nav-icon far fa-plus-square"></i>
            <p>Tambah Pengguna</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ url('pengguna/tambah') }}" class="nav-link">
            <i class="nav-icon far fa-plus-square"></i>
            <p>Tambah Bilik</p>
          </a>
        </li>
        
      </ul>
      <li class="nav-item has-treeview">
        <a href="{{ route('logout') }}"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link" >
          <i class="nav-icon fas fa-sign-out-alt"></i>
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