        <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="dlabnav">
            <div class="dlabnav-scroll">
				<ul class="metismenu" id="menu">

                    <li><a href="{{ route('admin.dashboard') }}" class="" aria-expanded="false">
							<i class="fas fa-home"></i>
							<span class="nav-text">Dashboard</span>
						</a>
					</li>
					
					<li><a href="{{ route('admin.users') }}" class="" aria-expanded="false">
							<i class="fas fa-users"></i>
							<span class="nav-text">Registered Users</span>
						</a>
					</li>
					
                    <li><a href="{{ route('admin.product.category') }}" class="" aria-expanded="false">
							<i class="fas fa-info-circle"></i>
							<span class="nav-text">Category</span>
						</a>
					</li>
					<li><a href="{{ route('admin.product.subcategory') }}" class="" aria-expanded="false">
							<i class="fa fa-check-circle"></i>
							<span class="nav-text">SubCategory</span>
						</a>
					</li> 
					<li><a href="{{ route('admin.product.submenu') }}" class="" aria-expanded="false">
							<i class="fa fa-list-ol"></i>
							<span class="nav-text">Sub Menu List</span>
						</a>
					</li> 
					<li><a class="has-arrow " href="javascript:void()" aria-expanded="false">
						<i class="fa fa-th-large"></i>
							<span class="nav-text">Product</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a href="{{ route('admin.product') }}">All Product</a></li>
                            <li><a href="{{ route('admin.product.add') }}">Add New Product</a></li>
							<li><a href="{{ route('admin.color') }}">Color</a></li>
                        </ul>
                    </li>
                                       
                    <li><a href="{{ route('shop.by.call.to.action') }}" class="" aria-expanded="false">
							<i class="fa fa-check-circle"></i>
							<span class="nav-text">Call to Action</span>
						</a>
					</li>
                    <li><a href="{{ route('shop.by.index') }}" class="" aria-expanded="false">
							<i class="fa fa-child"></i>
							<span class="nav-text">Shop By Age</span>
						</a>
					</li>
                    <li><a href="{{ route('by.price.index') }}" class="" aria-expanded="false">
							<i class="fa fa-tag"></i>
							<span class="nav-text">Shop By Price</span>
						</a>
					</li>
                    <li><a href="{{ route('shop-by-reels.index') }}" class="" aria-expanded="false">
							<i class="fa fa-tag"></i>
							<span class="nav-text">Shop By Reels</span>
						</a>
					</li>
                    <li><a href="{{ route('admin.coupon_code') }}" class="" aria-expanded="false">
							<i class="fa fa-gift"></i>
							<span class="nav-text">Coupon Code</span>
						</a>
					</li>
					
					
					<li><a href="{{ route('admin.order.list') }}" class="" aria-expanded="false">
							<i class="fas fa-file-invoice"></i>
							<span class="nav-text">Orders</span>
						</a>
					</li>
					
					<li><a href="{{ route('admin.banner.show') }}" class="" aria-expanded="false">
							<i class="fa fa-image"></i>
							<span class="nav-text">Banner Image</span>
						</a>
					</li>

					<li><a class="has-arrow " href="javascript:void()" aria-expanded="false">
						<i class="fa fa-gift"></i>
							<span class="nav-text">Masters</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a href="{{ route('gift-wrap.index') }}">Gift Wrap</a></li>
							<li><a href="{{ route('shipping-price.index') }}">Shipping Price</a></li>
							<li><a href="{{ route('milestone.index') }}">Mile Stone Setup</a></li>
							<li><a href="{{ route('privacy.policy') }}">Privacy Policy</a></li>
							<li><a href="{{ route('terms') }}">Terms & Conditions</a></li>
                        </ul>
                    </li>
					
					<li><a class="has-arrow " href="javascript:void()" aria-expanded="false">
						<i class="fa fa-cogs"></i>
							<span class="nav-text">General settings</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a href="{{ route('admin.profile') }}">Admin Profile</a></li>
							<li><a href="{{ route('password.change') }}">Change password</a></li>
                        </ul>
                    </li>
                </ul>
				
	
			</div>
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->