@if (Auth::check())
<div class="sidebar-collapse">
    <ul class="nav metismenu" id="side-menu">
        <li class="nav-header">
            @php
            $user = Auth::user();
            $pathPhoto = $user->file_photo ? Storage::url($user->file_photo) : '';
            $fullPath = '';
            if ($pathPhoto) {
                $fileName = File::name($pathPhoto);
                $fileExt = File::extension($pathPhoto);
                $dirName = File::dirname($pathPhoto);
                $fullPath = "$dirName/$fileName-small.$fileExt";
            } else {
                $fullPath = asset('images/default-picture-small.png');
            }
            @endphp
            <div class="dropdown profile-element"> <span>
                <img alt="image" class="img-circle" src="{{ $fullPath }}" />
            </span>
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{ Auth::user()->name }}</strong>
                </span> <span class="text-muted text-xs block">{{ implode(Auth::user()->getRoleNames()->toArray()) }} <b class="caret"></b></span> </span> </a>
                <ul class="dropdown-menu animated fadeInRight m-t-xs">
                    <li><a href="{{ route('profil.index') }}">Profile</a></li>
                </ul>
            </div>
            <div class="logo-element">
                STIES
            </div>
        </li>
        <li class="{{ active_sidebar('/') }}">
            <a href="{{ url('/') }}"> <span class="nav-label">Dashboard</span></a>
        </li>

        @if (Auth::user()->hasRole('Administrator'))
        <li class="{{ active_sidebar('users') }}">
            <a href="{{ route('users.index') }}"> <span class="nav-label">Pengguna</span></a>
        </li>

        @elseif (Auth::user()->hasRole('Ketua'))
        <li class="{{ active_sidebar('laporan') }}">
            <a href="{{ route('laporan.index') }}"> <span class="nav-label">Laporan Keuangan</span></a>
        </li>

        <li class="{{ active_sidebar('history') }}">
            <a href="{{ route('history.index') }}"> <span class="nav-label">History</span></a>
        </li>
        @elseif (Auth::user()->hasRole('Member'))

        <li class="{{ active_sidebar('mahasiswa') }}" ><a href="{{ route('mahasiswa.index') }}"> <span class="nav-label">Data Mahasiswa</span></a>
        </li>
        <li class="{{ active_sidebar('pegawai') }}"><a href="{{ route('pegawai.index')  }}"> <span class="nav-label">Data Pegawai</span></a>
        </li>
        <li class="{{ active_sidebar('pemasukan/*') }}">
            <a href="#"> <span class="nav-label">Pemasukan</span> <span class="fa arrow"></span></a>
            <ul class="nav nav-second-level">
                <li class="{{ active_sidebar('*pendaftaran*') }}"><a href="{{ route('pendaftaran.index') }}">Pendaftaran</a></li>
                <li class="{{ active_sidebar('*pembangunan*') }}"><a href="{{ route('pembangunan.index') }}">Pembangunan</a></li>
                <li class="{{ active_sidebar('*pembayaran_semester*') }}"><a href="{{ route('pembayaran_semester.index') }}">Pembayaran Semester</a></li>
                <li class="{{ active_sidebar('*pemasukan_lain*') }}"><a href="{{ route('pemasukan_lain.index') }}">Pemasukan Lain</a></li>
            </ul>
        </li>
        <li class="{{ active_sidebar('pengeluaran/*') }}">
            <a href="#"> <span class="nav-label">Pengeluaran</span> <span class="fa arrow"></span></a>
            <ul class="nav nav-second-level">
                <li class="{{ active_sidebar('*embayaran_gaji*') }}"><a href="{{ route('pembayaran_gaji.index') }}">Pembayaran Gaji Dosen</a></li>
                <li class="{{ active_sidebar('*pengeluaran_lain*') }}"><a href="{{ route('pengeluaran_lain.index') }}">Pengeluaran Lain</a></li>
            </ul>
        </li>

        @endif
    </ul>

</div>

@endif
