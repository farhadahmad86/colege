<!DOCTYPE html>
<html>
<head>
{{--	<meta name="csrf-token" content="{{ csrf_token() }}">--}}
    @include('include/head')
</head>

<body>
	<div class="login-wrap customscroll d-flex align-items-center flex-wrap justify-content-center pd-20">

		<div class="login-box bg-white box-shadow pd-30 border-radius-5">
			@include('inc._messages')
			<img src="{{asset("public/vendors/images/my_logo.png" )}}" alt="login" class="login-img">

			<h2 class="text-center mb-30">Login</h2>
			<form name="f1" method="post" action="signin" autocomplete="off">
				@csrf
				<div class="input-group custom input-group-lg">
					<input type="text" class="form-control" placeholder="Username" name="user_name" value="{{ isset($username) ? $username: ''}}" required>
					<div class="input-group-append custom">
						<span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></span>
					</div>
				</div>
				<div class="input-group custom input-group-lg">
					<input type="password" class="form-control" placeholder="**********" name="password" id="password" required >
					<div class="input-group-append custom">
{{--						<span class="input-group-text"><i class="fa fa-lock" aria-hidden="true"></i></span>--}}
						<span toggle="#password" class="toggle-password input-group-text"><i class="fa fa-fw fa-eye" aria-hidden="true"></i></span>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="input-group">
							<!--
								use code for form submit
								<input class="btn btn-outline-primary btn-lg btn-block" type="submit" value="Sign In">
							-->
							{{--<a class="btn btn-outline-primary btn-lg btn-block" href="#">Sign In</a>--}}
							<input class="btn btn-outline-primary btn-lg btn-block"  type="submit" name="btn"  value="Sign In">
						</div>
					</div>
					<div class="col-sm-6">
						<div class="forgot-password padding-top-10"><a href="password_reset">Forgot Password</a></div>
					</div>
				</div>
			</form>
		</div>
	</div>
	@include('include/script')

<script>
	$(".toggle-password").click(function() {
		$(this).children('i').toggleClass("fa-eye fa-eye-slash");
		var input = $($(this).attr("toggle"));
		if (input.attr("type") === "password") {
			input.attr("type", "text");
		} else {
			input.attr("type", "password");
		}
	});

</script>
</body>
</html>
