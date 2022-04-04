<aside class="navbar-aside" id="offcanvas_aside">
            <div class="aside-top">
                <a href="index.html" class="brand-wrap">
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
                            <span class="text">Dashboard</span>
                        </a>
                    </li>
                    <li class="menu-item {{ ($currentDashboardMenu == 'products') ? 'active' : ''}}">
                        <a class="menu-link" href="{{ url('user/products')}}">
                            <i class="icon material-icons md-shopping_bag"></i>
                            <span class="text">Products</span>
                        </a>
                    </li>
                    <li class="menu-item {{ ($currentDashboardMenu == 'orders') ? 'active' : ''}}">
                        <a class="menu-link" href="{{ url('user/orders')}}">
                            <i class="icon material-icons md-shopping_cart"></i>
                            <span class="text">Orders</span>
                        </a>
                        
                    </li>
                    
                   
                    <li class="menu-item {{ ($currentDashboardMenu == 'transactions') ? 'active' : ''}}">
                        <a class="menu-link" href="{{ url('user/transactions')}}">
                            <i class="icon material-icons md-monetization_on"></i>
                            <span class="text">Transactions</span>
                        </a>
                       
                    </li>
                    <li class="menu-item has-submenu {{ ($currentDashboardMenu == 'profiles') ? 'active' : ''}}">
                        <a class="menu-link" href="#">
                            <i class="icon material-icons md-person"></i>
                            <span class="text">Profile</span>
                        </a>
                        <div class="submenu">
                            <a href="{{ url('user/profile')}}" class="{{ ($currentDashboardSubMenu == 'users') ? 'active' : ''}}">User Profile</a>
                            <a href="{{ url('user/shop')}}" class="{{ ($currentDashboardSubMenu == 'shops') ? 'active' : ''}}">Shop Information</a>
                        </div>
                    </li>
                    
                   
                </ul>
                <hr />
                <ul class="menu-aside">
                    <li class="menu-item {{ ($currentDashboardMenu == 'settings') ? 'active' : ''}}">
                        <a class="menu-link" href="{{ url('user/settings')}}">
                            <i class="icon material-icons md-settings"></i>
                            <span class="text">Settings</span>
                        </a>
                    </li>
                    
                </ul>
                <br />
                <br />
            </nav>
        </aside>