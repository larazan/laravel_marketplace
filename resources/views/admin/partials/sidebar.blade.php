 <!--
	====================================
	——— LEFT SIDEBAR WITH FOOTER
	=====================================
-->
<aside class="left-sidebar bg-sidebar">
	<div id="sidebar" class="sidebar sidebar-with-footer">
		<!-- Aplication Brand -->
		<div class="app-brand">
			<a href="{{ url('admin/dashboard') }}">
			<span class="brand-name">Laravel Dashboard</span>
			</a>
		</div>
		<!-- begin sidebar scrollbar -->
		<div class="sidebar-scrollbar">

			<!-- sidebar menu -->
			<ul class="nav sidebar-inner" id="sidebar-menu">
				<li  class="has-sub  {{ ($currentAdminMenu == 'dashboard') ? 'expand active' : ''}}">
					<a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#dashboard"
						aria-expanded="false" aria-controls="dashboard">
						<i class="mdi mdi-chart-pie"></i>
						<span class="nav-text">Dashboard</span> <b class="caret"></b>
					</a>
					<ul class="collapse {{ ($currentAdminMenu == 'dashboard') ? 'show' : ''}}"  id="dashboard"
						data-parent="#sidebar-menu">
						<div class="sub-menu">
							<li class="{{ ($currentAdminSubMenu == 'analytic') ? 'active' : ''}}">
								<a class="sidenav-item-link" href="{{ url('admin/dashboard')}}">
								<span class="nav-text">Analytic</span>
								</a>
							</li>
						</div>
					</ul>
				</li>
				<li  class="has-sub   {{ ($currentAdminMenu == 'catalog') ? 'expand active' : ''}}">
					<a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#catalog"
						aria-expanded="false" aria-controls="catalog">
						<i class="mdi mdi-view-dashboard-outline"></i>
						<span class="nav-text">Catalog</span> <b class="caret"></b>
					</a>
					<ul  class="collapse {{ ($currentAdminMenu == 'catalog') ? 'show' : ''}}"  id="catalog"
						data-parent="#sidebar-menu">
						<div class="sub-menu">
							<li class="{{ ($currentAdminMenu == 'catalog') ? 'show' : ''}}">
								<a class="sidenav-item-link" href="{{ url('admin/products')}}">
								<span class="nav-text">Products</span>
								</a>
							</li>
							<li class="{{ ($currentAdminSubMenu == 'category') ? 'active' : ''}}">
								<a class="sidenav-item-link" href="{{ url('admin/categories')}}">
								<span class="nav-text">Categories</span>
								</a>
							</li>
							<li class="{{ ($currentAdminSubMenu == 'brand') ? 'active' : ''}}">
								<a class="sidenav-item-link" href="{{ url('admin/brands')}}">
								<span class="nav-text">Brands</span>
								</a>
							</li>
							<li class="{{ ($currentAdminSubMenu == 'ingredient') ? 'active' : ''}}">
								<a class="sidenav-item-link" href="{{ url('admin/ingredients')}}">
								<span class="nav-text">Ingredients</span>
								</a>
							</li>
							<li class="{{ ($currentAdminSubMenu == 'attribute') ? 'active' : ''}}">
								<a class="sidenav-item-link" href="{{ url('admin/attributes')}}">
								<span class="nav-text">Attributes</span>
								</a>
							</li>
							<li class="{{ ($currentAdminSubMenu == 'review') ? 'active' : ''}}">
								<a class="sidenav-item-link" href="{{ url('admin/reviews')}}">
								<span class="nav-text">Reviews</span>
								</a>
							</li>
						</div>
					</ul>
				</li>
                
                <li  class="has-sub {{ ($currentAdminMenu == 'marketplace') ? 'expand active' : ''}}">
					<a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#shop"
						aria-expanded="false" aria-controls="article">
						<i class="mdi mdi-newspaper"></i>
						<span class="nav-text">Shops</span> <b class="caret"></b>
					</a>
					<ul  class="collapse {{ ($currentAdminMenu == 'marketplace') ? 'show' : ''}}"  id="shop"
						data-parent="#sidebar-menu">
						<div class="sub-menu">
							<li class="{{ ($currentAdminSubMenu == 'shop') ? 'active' : ''}}">
								<a class="sidenav-item-link" href="{{ url('admin/shops')}}">
								<span class="nav-text">Shops List</span>
								</a>
							</li>
							<li class="{{ ($currentAdminSubMenu == 'region') ? 'active' : ''}}">
								<a class="sidenav-item-link" href="{{ url('admin/regions')}}">
								<span class="nav-text">Region List</span>
								</a>
							</li>
							
						</div>
					</ul>
				</li>

				<li  class="has-sub {{ ($currentAdminMenu == 'article') ? 'expand active' : ''}}">
					<a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#article"
						aria-expanded="false" aria-controls="article">
						<i class="mdi mdi-newspaper"></i>
						<span class="nav-text">Article</span> <b class="caret"></b>
					</a>
					<ul  class="collapse {{ ($currentAdminMenu == 'article') ? 'show' : ''}}"  id="article"
						data-parent="#sidebar-menu">
						<div class="sub-menu">
							<li class="{{ ($currentAdminSubMenu == 'article') ? 'active' : ''}}">
								<a class="sidenav-item-link" href="{{ url('admin/articles')}}">
								<span class="nav-text">Article</span>
								</a>
							</li>
							<li class="{{ ($currentAdminSubMenu == 'category_article') ? 'active' : ''}}">
								<a class="sidenav-item-link" href="{{ url('admin/category_articles')}}">
								<span class="nav-text">Categories</span>
								</a>
							</li>
							
						</div>
					</ul>
				</li>
               
				<li  class="has-sub {{ ($currentAdminMenu == 'order') ? 'expand active' : ''}}">
					<a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#orders"
						aria-expanded="false" aria-controls="orders">
						<i class="mdi mdi-cart-outline"></i>
						<span class="nav-text">Orders</span> <b class="caret"></b>
					</a>
					<ul class="collapse {{ ($currentAdminMenu == 'order') ? 'show' : ''}}"  id="orders"
						data-parent="#sidebar-menu">
						<div class="sub-menu">
							<li  class="{{ ($currentAdminSubMenu == 'order') ? 'active' : ''}}" >
								<a class="sidenav-item-link" href="{{ url('admin/orders')}}">
								<span class="nav-text">Orders</span>
								</a>
							</li>
							<li class="{{ ($currentAdminSubMenu == 'trashed-order') ? 'active' : ''}}">
								<a class="sidenav-item-link" href="{{ url('admin/orders/trashed')}}">
								<span class="nav-text">Trashed</span>
								</a>
							</li>
							<li class="{{ ($currentAdminSubMenu == 'shipment') ? 'active' : ''}}">
								<a class="sidenav-item-link" href="{{ url('admin/shipments')}}">
								<span class="nav-text">Shipments</span>
								</a>
							</li>
						</div>
					</ul>
				</li>
               
               
				<li  class="has-sub {{ ($currentAdminMenu == 'report') ? 'expand active' : ''}}">
					<a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#report"
						aria-expanded="false" aria-controls="report">
						<i class="mdi mdi-signal-cellular-outline"></i>
						<span class="nav-text">Reports</span> <b class="caret"></b>
					</a>
					<ul class="collapse {{ ($currentAdminMenu == 'report') ? 'show' : ''}}"  id="report"
						data-parent="#sidebar-menu">
						<div class="sub-menu">
							<li  class="{{ ($currentAdminSubMenu == 'report-revenue') ? 'active' : ''}}" >
								<a class="sidenav-item-link" href="{{ url('admin/reports/revenue')}}">
								<span class="nav-text">Revenue</span>
								</a>
							</li>
							<li  class="{{ ($currentAdminSubMenu == 'report-product') ? 'active' : ''}}" >
								<a class="sidenav-item-link" href="{{ url('admin/reports/product')}}">
								<span class="nav-text">Products</span>
								</a>
							</li>
							<li  class="{{ ($currentAdminSubMenu == 'report-inventory') ? 'active' : ''}}" >
								<a class="sidenav-item-link" href="{{ url('admin/reports/inventory')}}">
								<span class="nav-text">Inventories</span>
								</a>
							</li>
							<li  class="{{ ($currentAdminSubMenu == 'report-payment') ? 'active' : ''}}" >
								<a class="sidenav-item-link" href="{{ url('admin/reports/payment')}}">
								<span class="nav-text">Payments</span>
								</a>
							</li>
						</div>
					</ul>
				</li>
				
				<li  class="has-sub {{ ($currentAdminMenu == 'role-user') ? 'expand active' : ''}}">
					<a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#auth"
						aria-expanded="false" aria-controls="auth">
						<i class="mdi mdi-account-multiple-outline"></i>
						<span class="nav-text">Users &amp; Roles</span> <b class="caret"></b>
					</a>
					<ul class="collapse {{ ($currentAdminMenu == 'role-user') ? 'show' : ''}}"  id="auth"
						data-parent="#sidebar-menu">
						<div class="sub-menu">
							<li  class="{{ ($currentAdminSubMenu == 'user') ? 'active' : ''}}" >
								<a class="sidenav-item-link" href="{{ url('admin/users')}}">
								<span class="nav-text">Users</span>
								</a>
							</li>
							<!-- <li class="{{ ($currentAdminSubMenu == 'role') ? 'active' : ''}}">
								<a class="sidenav-item-link" href="{{ url('admin/roles')}}">
								<span class="nav-text">Roles</span>
								</a>
							</li> -->
						</div>
					</ul>
				</li>  
                <li  class="has-sub {{ ($currentAdminMenu == 'general') ? 'expand active' : ''}}">
					<a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#general"
						aria-expanded="false" aria-controls="general">
						<i class="mdi mdi-settings"></i>
						<span class="nav-text">General</span> <b class="caret"></b>
					</a>
					<ul class="collapse {{ ($currentAdminMenu == 'general') ? 'show' : ''}}"  id="general"
						data-parent="#sidebar-menu">
						<div class="sub-menu">
							<li  class="{{ ($currentAdminSubMenu == 'slide') ? 'active' : ''}}" >
								<a class="sidenav-item-link" href="{{ url('admin/slides')}}">
								<span class="nav-text">Slides</span>
								</a>
							</li>
							<li  class="{{ ($currentAdminSubMenu == 'subscribe') ? 'active' : ''}}" >
								<a class="sidenav-item-link" href="{{ url('admin/subscribes')}}">
								<span class="nav-text">Subscribes</span>
								</a>
							</li>
							<li  class="{{ ($currentAdminSubMenu == 'logs') ? 'active' : ''}}" >
								<a class="sidenav-item-link" href="{{ url('admin/logs')}}">
								<span class="nav-text">Log Activity</span>
								</a>
							</li>
						</div>
					</ul>
				</li>     

				<li  class="has-sub {{ ($currentAdminMenu == 'setting') ? 'active' : ''}}">
					<a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#setting"
						aria-expanded="false" aria-controls="article">
						<i class="mdi mdi-newspaper"></i>
						<span class="nav-text">Setting</span> <b class="caret"></b>
					</a>
					<ul  class="collapse {{ ($currentAdminMenu == 'setting') ? 'show' : ''}}"  id="setting"
						data-parent="#sidebar-menu">
						<div class="sub-menu">
							<li class="{{ ($currentAdminSubMenu == 'set') ? 'active' : ''}}">
								<a class="sidenav-item-link" href="{{ url('admin/setting')}}">
								<span class="nav-text">Setting</span>
								</a>
							</li>
							
							
						</div>
					</ul>
				</li>

			</ul>
		</div>
	</div>
</aside>