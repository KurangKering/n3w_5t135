  <nav class="navbar-default navbar-side sidebar" role="navigation">
      <div id="sideNav" href="{{ url('/') }}"><i class="fa fa-caret-right"></i></div>

      <div class="sidebar-collapse">
         <div class="profile-userpic">

            <img src="{{ Auth::user()->file_photo ? Storage::url(Auth::user()->file_photo) : Storage::url('photo-profil/default-profile.jpg')}}" alt="" class="img-responsive text-center"/>


            <div class="profile-usertitle">
                <div class="profile-usertitle-name">
                    
                    {{ Auth::check() ? Auth::user()->name : '' }}
                </div>
                <div class="profile-usertitle-job">
                    {{ Auth::check() ? Auth::user()->getRoleNames()[0] : '' }}
                </div>
            </div>
        {{-- <ul>
            <li class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <img src="{{ Storage::url('photo-profil/default-profile.jpg') }}" alt="" class="img-responsive"/>

                    <br>
                    <div class=" user-info">
                        John Doe ee<b class="caret"></b><span>Super Admin</span>
                    </div>
                </a>
                <!-- Dropdown menu -->
                <ul class="dropdown-menu">
                    <li><a href="#"><i class="fa fa-user"></i> Profile</a></li>
                    <li><a href="#"><i class="fa fa-cogs"></i> Settings</a></li>
                    <li><a href="login.html"><i class="fa fa-power-off"></i> Logout</a></li>
                </ul>
            </li>
        </ul> --}}
    </div>
    <div class="clearfix"></div>
    <ul class="nav" id="main-menu">
        <li class="divider"></li>

        @if (Auth::check())
        <li>
            <a class="{{ active_sidebar('/') }}" href="/"><i class="fa fa-dashboard"></i> Dashboard</a>
        </li>
        @if(Auth::user()->hasRole('Administrator'))
        <li>
            <a class="{{ active_sidebar('sistem/*') }}" href="{{ route('users.index') }}"><i class="glyphicon glyphicon-chevron-up"></i> Sistem<span class="fa arrow"></span></a>
            <ul class="nav nav-second-level">

                <li>
                    <a href="{{ route('users.index') }}">Pengguna</a>
                </li>
                    {{-- <li>
                        <a href="{{ route('roles.index') }}">Hak Akses</a>
                    </li> --}}
                </ul>
            </li>
            @elseif (Auth::user()->hasRole('Member'))
            <li>
                <a class="{{ active_sidebar('mahasiswa') }}" href="{{ route('mahasiswa.index') }}"><i class="fa fa-table"></i> Data Mahasiswa</a>
            </li>
            <li>
                <a class="{{ active_sidebar('pegawai') }}" href="{{ route('pegawai.index') }}"><i class="fa fa-table"></i> Data Pegawai</a>
            </li>
            <li>
                <a class="{{ active_sidebar('pemasukan/*') }}" href="{{ route('mahasiswa.index') }}"><i class="glyphicon glyphicon-chevron-up"></i> Pemasukan<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                   <li>
                    <a href="{{ route('pendaftaran.index') }}">Pendaftaran</a>
                </li>
                <li>
                    <a href="{{ route('pembayaran_semester.index') }}">Pembayaran Semester</a>
                </li>
                <li>
                    <a href="{{ route('pemasukan_lain.index') }}">Pemasukan Lainnya</a>
                </li>
            </ul>
        </li>
        <li>
            <a class="{{ active_sidebar('pengeluaran/*') }}" href="{{ route('mahasiswa.index') }}"><i class="glyphicon glyphicon-chevron-down"></i> Pengeluaran<span class="fa arrow"></span></a>
            <ul class="nav nav-second-level">

                <li>
                    <a href="{{ route('pembayaran_gaji.index') }}">Pembayaran Gaji Dosen</a>
                </li>
                <li>
                    <a href="{{ route('pengeluaran_lain.index') }}">Pengeluaran Lainnya</a>
                </li>
            </ul>
        </li>

        @elseif (Auth::user()->hasRole('Ketua'))
        <li>
            <a class="{{ active_sidebar('laporan') }}" href="{{ route('laporan.index') }}"><i class="fa fa-table"></i> Laporan Keuangan</a>
        </li>
        <li>
            <a class="{{ active_sidebar('history') }}" href="{{ route('history.index') }}"><i class="fa fa-table"></i> History</a>
        </li>
        
        @endif
        @endif
    </ul>

</div>

</nav>