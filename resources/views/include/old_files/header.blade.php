	<div class="pre-loader"></div>
	<div class="header clearfix">
		<div class="header-right">
			<div class="brand-logo">
				<a href="index">
					<img src={{asset("public/vendors/images/logo.png")}} alt="" class="mobile-logo">
				</a>
			</div>
			<div class="menu-icon">
				<span></span>
				<span></span>
				<span></span>
				<span></span>
			</div>

			<div class="user-info-dropdown">
			<div class="dropdown">
					<a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
						<span class="user-icon"><i class="fa fa-user-o"></i></span>
						@php
						$user = Auth::user();
						@endphp
						<span class="user-name">{{$user->user_name}}</span>
					</a>
					<div class="dropdown-menu dropdown-menu-right">
						<!-- <a class="dropdown-item" href="profile.php"><i class="fa fa-user-md" aria-hidden="true"></i> Profile</a>
						<a class="dropdown-item" href="profile.php"><i class="fa fa-cog" aria-hidden="true"></i> Setting</a>
						<a class="dropdown-item" href="faq.php"><i class="fa fa-question" aria-hidden="true"></i> Help</a> -->
						<a class="dropdown-item" href="edit_profile"><i class="fa fa-sign-out" aria-hidden="true"></i>Change Profile</a>
						<a class="dropdown-item" href="change_password"><i class="fa fa-sign-out" aria-hidden="true"></i>Change Password</a>
						<a class="dropdown-item" href={{route("logout")}}><i class="fa fa-sign-out" aria-hidden="true"></i> Log Out</a>
					</div>
				</div>
			</div>

			<div class="user-info-dropdown">
				<div class="dropdown">

					@php
						use App\Http\Controllers\DayEndController;
						$get_day_end = new DayEndController();
            			$day_end = $get_day_end->day_end();
					@endphp
					<span style="float: right">Financial Date: {{$day_end->de_datetime}}</span><br>
					<span style="float: right">Current Date: {{date("Y-m-d")}}</span>
				</div>
			</div>




			{{--<!-- <div class="user-notification">--}}
				{{--<div class="dropdown">--}}
					{{--<a class="dropdown-toggle no-arrow" href="#" role="button" data-toggle="dropdown">--}}
						{{--<i class="fa fa-bell" aria-hidden="true"></i>--}}
						{{--<span class="badge notification-active"></span>--}}
					{{--</a>--}}
					{{--<div class="dropdown-menu dropdown-menu-right">--}}
						{{--<div class="notification-list mx-h-350 customscroll">--}}
							{{--<ul>--}}
								{{--<li>--}}
									{{--<a href="#">--}}
										{{--<img src="vendors/images/img.jpg" alt="">--}}
										{{--<h3 class="clearfix">John Doe <span>3 mins ago</span></h3>--}}
										{{--<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...</p>--}}
									{{--</a>--}}
								{{--</li>--}}
								{{--<li>--}}
									{{--<a href="#">--}}
										{{--<img src="vendors/images/img.jpg" alt="">--}}
										{{--<h3 class="clearfix">John Doe <span>3 mins ago</span></h3>--}}
										{{--<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...</p>--}}
									{{--</a>--}}
								{{--</li>--}}
								{{--<li>--}}
									{{--<a href="#">--}}
										{{--<img src="vendors/images/img.jpg" alt="">--}}
										{{--<h3 class="clearfix">John Doe <span>3 mins ago</span></h3>--}}
										{{--<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...</p>--}}
									{{--</a>--}}
								{{--</li>--}}
								{{--<li>--}}
									{{--<a href="#">--}}
										{{--<img src="vendors/images/img.jpg" alt="">--}}
										{{--<h3 class="clearfix">John Doe <span>3 mins ago</span></h3>--}}
										{{--<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...</p>--}}
									{{--</a>--}}
								{{--</li>--}}
								{{--<li>--}}
									{{--<a href="#">--}}
										{{--<img src="vendors/images/img.jpg" alt="">--}}
										{{--<h3 class="clearfix">John Doe <span>3 mins ago</span></h3>--}}
										{{--<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...</p>--}}
									{{--</a>--}}
								{{--</li>--}}
								{{--<li>--}}
									{{--<a href="#">--}}
										{{--<img src="vendors/images/img.jpg" alt="">--}}
										{{--<h3 class="clearfix">John Doe <span>3 mins ago</span></h3>--}}
										{{--<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...</p>--}}
									{{--</a>--}}
								{{--</li>--}}
								{{--<li>--}}
									{{--<a href="#">--}}
										{{--<img src="vendors/images/img.jpg" alt="">--}}
										{{--<h3 class="clearfix">John Doe <span>3 mins ago</span></h3>--}}
										{{--<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...</p>--}}
									{{--</a>--}}
								{{--</li>--}}
							{{--</ul>--}}
						{{--</div>--}}
					{{--</div>--}}
				{{--</div>--}}
			{{--</div> -->--}}
		</div>
	</div>