<div class="startbar d-print-none">
	<div class="brand">
		<a href="/home" class="logo">
		<span>
		<img src="<?=$ketnoi->site('favicon');?>" alt="logo-small" class="logo-sm">
		</span>
		<span>
		<img src="<?=$ketnoi->site('logo');?>" alt="logo-large" class="logo-lg logo-light">
		<img src="<?=$ketnoi->site('logo');?>" alt="logo-large" class="logo-lg logo-dark">
		</span>
		</a>
	</div>
	<div class="startbar-menu">
		<div class="startbar-collapse" id="startbarCollapse">
			<div class="d-flex align-items-start flex-column w-100">
				<ul class="navbar-nav mb-auto w-100">
					<!-- SYSTEM ADMINISTRATION -->
					<li class="menu-label mt-2">
						<small class="label-border">
							<div class="border_left hidden-xs"></div>
							<div class="border_right"></div>
						</small>
						<span>System Administration</span>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/admin/dashboard">
						<i class="fa-solid fa-chart-line menu-icon" style="color:#3B82F6;"></i> 
						<span>Dashboard</span>
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/admin/activity-logs">
						<i class="fa-solid fa-clock-rotate-left menu-icon" style="color:#8B5CF6;"></i> 
						<span>Activity Log</span>
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/admin/settings">
						<i class="fa-solid fa-sliders menu-icon" style="color:#F59E0B;"></i>
						<span>Settings</span>
						</a>
					</li>
					<!-- USER SERVICE REGISTRATION -->
					<li class="menu-label mt-2">
						<small class="label-border">
							<div class="border_left hidden-xs"></div>
							<div class="border_right"></div>
						</small>
						<span>User Service Registration</span>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/admin/user-manager">
						<i class="fa-solid fa-users-gear menu-icon" style="color:#10B981;"></i>
						<span>User Management</span>
						</a>
					</li>
					<!-- Bank & e-Wallet Management -->
					<li class="menu-label mt-2">
						<small class="label-border">
							<div class="border_left hidden-xs"></div>
							<div class="border_right"></div>
						</small>
						<span>Bank & e-Wallet Management</span>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/admin/bank/user-banks">
						<i class="fa-solid fa-landmark menu-icon" style="color:#22C55E;"></i>
						<span>User Bank Accounts</span>
						</a>
					</li>
					<!-- VPS Configuration -->
					<li class="menu-label mt-2">
						<small class="label-border">
							<div class="border_left hidden-xs"></div>
							<div class="border_right"></div>
						</small>
						<span>VPS Configuration</span>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/admin/cloudvps/operating-system">
						<i class="fa-solid fa-laptop-code menu-icon" style="color:#6366F1;"></i>
						<span>Operating System</span>
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/admin/cloudvps/addon">
						<i class="fa-solid fa-layer-group menu-icon" style="color:#06B6D4;"></i>
						<span>Addon VPS</span>
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/admin/cloudvps/server-hosting">
						<i class="fa-solid fa-database menu-icon" style="color:#EC4899;"></i>
						<span>Hosting Server</span>
						</a>
					</li>
					<!-- PACKAGE -->
					<li class="menu-label mt-2">
						<small class="label-border">
							<div class="border_left hidden-xs"></div>
							<div class="border_right"></div>
						</small>
						<span>Package</span>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/admin/package/package-hosting">
						<i class="fa-solid fa-cube menu-icon" style="color:#FB923C;"></i>
						<span>Package Hosting</span>
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/admin/package/package-cloudvps">
						<i class="fa-solid fa-boxes-packing menu-icon" style="color:#84CC16;"></i>
						<span>Package VPS</span>
						</a>
					</li>
					<!-- HISTORY -->
					<li class="menu-label mt-2">
						<small class="label-border">
							<div class="border_left hidden-xs"></div>
							<div class="border_right"></div>
						</small>
						<span>History</span>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/admin/history/history-recharge">
						<i class="fa-solid fa-coins menu-icon" style="color:#F97373;"></i>
						<span>History Recharge</span>
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/admin/history/history-buy-hosting">
						<i class="fa-solid fa-cart-shopping menu-icon" style="color:#D946EF;"></i>
						<span>History Buy Hosting</span>
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/admin/history/card-history">
						<i class="fa-solid fa-credit-card-alt menu-icon" style="color:#0EA5E9;"></i>
						<span>Card History</span>
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/admin/history/orders">
						<i class="fa-solid fa-receipt menu-icon" style="color:#8B5CF6;"></i>
						<span>Orders History</span>
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/admin/history/invoices">
						<i class="fa-solid fa-file-invoice menu-icon" style="color:#0EA5E9;"></i>
						<span>Invoices</span>
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/admin/history/purchased-cloudvps">
						<i class="fa-solid fa-cloud-arrow-up menu-icon" style="color:#6366F1;"></i>
						<span>Purchased CloudVPS</span>
						</a>
					</li>
					<!-- FEATURES -->
					<li class="menu-label mt-2">
						<small class="label-border">
							<div class="border_left hidden-xs"></div>
							<div class="border_right"></div>
						</small>
						<span>Features</span>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/admin/features/posts">
						<i class="fa-solid fa-blog menu-icon" style="color:#64748B;"></i> 
						<span>Posts</span>
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/admin/features/ranks">
						<i class="fa-solid fa-medal menu-icon" style="color:#EAB308;"></i> 
						<span>Ranks</span>
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/admin/features/discount">
						<i class="fa-solid fa-percent menu-icon" style="color:#10B981;"></i>
						<span>Discounts</span>
						</a>
					</li>
					<!-- LOGOUT -->
					<li class="menu-label mt-2">
						<small class="label-border">
							<div class="border_left hidden-xs"></div>
							<div class="border_right"></div>
						</small>
						<span>Account</span>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/home">
						<i class="fa-solid fa-arrow-right-from-bracket menu-icon" style="color:#EF4444;"></i>
						<span>Logout</span>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>