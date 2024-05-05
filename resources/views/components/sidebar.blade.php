    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="" class="brand-link text-center">
            <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">

                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <a href="/" class="nav-link {{ $menuActive == null ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>

                    @if (Auth::user()->role == 'superadmin' || Auth::user()->role == 'superuser')
                    <li class="nav-header">Super Admin</li>
                    <li class="nav-item">
                        <a href="{{ route('super.cabang') }}" class="nav-link {{ $menuActive == 'branch' ? 'active' : '' }}">
                            <i class="fas fa-building nav-icon"></i>
                            <p>
                                Master Cabang
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('super.admin') }}" class="nav-link {{ $menuActive == 'admin' ? 'active' : '' }}">
                            <i class="fas fa-chalkboard-teacher nav-icon"></i>
                            <p>
                                Master Admin
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('super.kepala') }}" class="nav-link {{ $menuActive == 'maping' ? 'active' : '' }}">
                            <i class="fas fa-people-arrows nav-icon"></i>
                            <p>
                                Mapping Kepala
                            </p>
                        </a>
                    </li>
                    @endif

                    @if (Auth::user()->role == 'admin' && @$kepala->branch != null)
                    <li class="nav-header">Admin</li>
                    <li class="nav-item {{ $menuOpen == 'karyawan' ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ $menuOpen == 'karyawan' ? 'active' : '' }}">
                            <i class="fas fa-users nav-icon"></i>
                            <p>
                                Master Karyawan
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.karyawan', ['type' => 'gudang']) }}" class="nav-link {{ $menuActive == 'gudang' ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Gudang</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.karyawan', ['type' => 'kasir']) }}" class="nav-link {{ $menuActive == 'kasir' ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Kasir</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.karyawan', ['type' => 'mekanik']) }}" class="nav-link {{ $menuActive == 'mekanik' ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Mekanik</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('gudang.mobil.merk') }}" class="nav-link {{ $menuActive == 'merk-mobil' ? 'active' : '' }}">
                            <i class="fas fas fa-car nav-icon"></i>
                            <p>
                                Data Mobil
                            </p>
                        </a>
                    </li>
                
                    <li class="nav-item {{ $menuOpen == 'produk' ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ $menuOpen == 'produk' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-shopping-cart"></i>
                            <p>
                                Master Produk
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.produk.merk') }}" class="nav-link {{ $menuActive == 'merk' ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Merk Produk</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('gudang.produk.master') }}" class="nav-link {{ $menuActive == 'master' ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Data Produk</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endif

                    @if (Auth::user()->role == 'gudang')
                    <li class="nav-header">Gudang</li>
                    <li class="nav-item">
                        <a href="{{ route('gudang.vendor') }}" class="nav-link {{ $menuActive == 'vendor' ? 'active' : '' }}">
                            <i class="fas fa-user-astronaut nav-icon"></i>
                            <p>
                                Master Vendor
                            </p>
                        </a>
                    </li>

                    @endif


                    @if (Auth::user()->role == 'mekanik')
                    <li class="nav-header">Mekanik</li>
                    <li class="nav-item">
                        <a href="{{ route('mekanik.pelanggan') }}" class="nav-link {{ $menuActive == 'pelanggan' ? 'active' : '' }}">
                            <i class="fas fa-user-astronaut nav-icon"></i>
                            <p>
                                Data Customer
                            </p>
                        </a>
                    </li>
                    @endif

                    @if (Auth::user()->role == 'kasir')
                    <li class="nav-header">Kasir</li>
                    <li class="nav-item">
                        <a href="{{ route('kasir.transaksi.nonservice') }}" class="nav-link {{ $menuActive == 'nonservice' ? 'active' : '' }}">
                            <i class="fas fa-shopping-cart nav-icon"></i>
                            <p>
                                Transaksi
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('kasir') }}" class="nav-link {{ $menuActive == 'transaksi' ? 'active' : '' }}">

                            <i class="fab fa-usps nav-icon"></i>
                            <p>
                                Data Service
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('kasir.riwayat') }}" class="nav-link {{ $menuActive == 'riwayat' ? 'active' : '' }}">
                            <i class="fas fa-history nav-icon"></i>
                            <p>
                                Riwayat Transaksi
                            </p>
                        </a>
                    </li>
                    @endif

                    <li class="nav-header">Pengaturan</li>
                    <li class="nav-item">
                        <a href="{{ route('auth.change') }}" class="nav-link {{ $menuActive == 'ganti-password' ? 'active' : '' }}">
                            <i class="fas fa-key nav-icon"></i>
                            <p>
                                Ubah Password
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('auth.logout') }}" class="nav-link" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            <form id="logout-form" action="{{ route('auth.logout') }}" method="POST">
                                @csrf
                            </form>
                            <i class="fas fa-sign-out-alt nav-icon"></i>
                            <p>
                                Logout
                            </p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>