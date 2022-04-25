<aside class="navbar-aside" id="offcanvas_aside">
            <div class="aside-top">
                <a href="/" class="brand-wrap">
                    <img src="{{ URL::asset('dashboard/assets/imgs/theme/logo.svg') }}" class="logo" alt="Nest Dashboard" />
                </a>
                <div>
                    <button class="btn btn-icon btn-aside-minimize"><i class="text-muted material-icons md-menu_open"></i></button>
                </div>
            </div>
            <nav>
                <ul class="menu-aside">
                    <li class="menu-item {{ ($currentDashboardMenu == 'dashboard') ? 'active' : ''}}">
                        <a class="menu-link" href="{{ url('user/dashboard')}}">
                            <i class="icon material-icons md-home"></i>
                            <span class="text">Beranda</span>
                        </a>
                    </li>
                    <li class="menu-item {{ ($currentDashboardMenu == 'products') ? 'active' : ''}}">
                        <a class="menu-link" href="{{ url('user/products')}}">
                            <i class="icon material-icons md-shopping_bag"></i>
                            <span class="text">Daftar Produk</span>
                        </a>
                    </li>
                    <li class="menu-item {{ ($currentDashboardMenu == 'orders') ? 'active' : ''}}">
                        <a class="menu-link" href="{{ url('user/orders')}}">
                            <i class="icon material-icons md-shopping_cart"></i>
                            <span class="text">Daftar Order</span>
                        </a>
                        
                    </li>
                    
                   
                    <li class="menu-item {{ ($currentDashboardMenu == 'transactions') ? 'active' : ''}}">
                        <a class="menu-link" href="{{ url('user/transactions')}}">
                            <i class="icon material-icons md-monetization_on"></i>
                            <span class="text">Transaksi</span>
                        </a>
                       
                    </li>
                    <li class="menu-item {{ ($currentDashboardMenu == 'profiles') ? 'active' : ''}}">
                        <a class="menu-link" href="{{ url('user/profile')}}">
                            <i class="icon material-icons md-person"></i>
                            <span class="text">Profil</span>
                        </a>
                        
                    </li>
                    <li class="menu-item {{ ($currentDashboardMenu == 'vendors') ? 'active' : ''}}">
                        <a class="menu-link" href="{{ url('user/shop') }}">
                            <i class="icon material-icons md-store"></i>
                            <span class="text">Toko</span>
                        </a>
                        
                    </li>
                    
                   
                </ul>
                <hr />
                <ul class="menu-aside">
                    <li class="menu-item {{ ($currentDashboardMenu == 'settings') ? 'active' : ''}}">
                        <a class="menu-link" href="{{ url('user/settings')}}">
                            <i class="icon material-icons md-settings"></i>
                            <span class="text">Setting</span>
                        </a>
                    </li>
                    
                </ul>
                <br />
                <br />
            </nav>
        </aside>