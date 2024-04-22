<div id="layoutSidenav_nav">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-danger">
        <!-- Navbar Brand-->
        <i class="fa-solid fa-bag-shopping text-white ps-3"></i>
        <a class="navbar-brand ps-2" href="index.html">SIMS Web App</a>
        <!-- #sidebarToggle -->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0">
            <i class="fas fa-bars text-white"></i>
        </button>
    </nav>
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <a class="nav-link {{ Request::is('products') ? 'active' : '' }}" href="{{ url('/products') }}">
                    <div class="sb-nav-link-icon">
                        <i class="fa-solid fa-cube"></i>
                    </div>
                    Produk
                </a>
                <a class="nav-link {{ Request::is('profile') ? 'active' : '' }}" href="{{ url('/profile') }}">
                    <div class="sb-nav-link-icon">
                        <i class="fa-regular fa-user"></i>
                    </div>
                    Profil
                </a>
                <a class="nav-link {{ Request::is('logout') ? 'active' : '' }}" href="{{ url('/logout') }}">
                    <div class="sb-nav-link-icon">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    </div>
                    Logout
                </a>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            {{ Auth::user()->name }}
        </div>
    </nav>
</div>
