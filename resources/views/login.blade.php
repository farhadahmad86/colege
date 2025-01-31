<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/vendors/styles/gnrlClasses.css') }}"/>

    @include('include/head')
    <style>
        .login_box .login_card, .lst_frm_screen .login_box .login_card {
            min-height: auto !important;
        }

        .fliping .fliping-back-face-h {
            height: auto !important;
            min-height: auto !important;
        }

        .fliping {
            min-height: auto !important;
            display: flex;
            height: 100vh;
            align-items: center;
        }

        .login_con, .lst_frm_screen .login_con {
            background-size: cover;
            background-position: top left;
            height: 100vh;
            padding: 0;
            align-items: center;
            display: flex;
        }

        .fliping .fliping-front-face-h {
            height: auto !important;
            min-height: auto !important;
            background: #ffffff !important;
        }

        .fliping .fliping-front-face-h:after, .fliping .fliping-front-face-v:after {
            width: 100% !important;
            height: 100% !important;
            border: 0 !important;
        }

        input {
            border: 1px solid #ccc !important;
            color: var(--dark) !important;
        }

        .login_box .login_card .card_block .login_btn, .lst_frm_screen .login_box .login_card .card_block .login_btn {
            width: 100%;
        }

        img {
            width: 70% !important;
        }
    </style>
</head>

<body>
@include('inc._messages')
<section class="login_con">
    <div class="container">
        <div class="row justify-content-end align-items-center">
            <div class="col-lg-4">
                <div id="flipping" class="fliping active">

                    <div class="login_box fliping-back-face-h">
                        <!-- login box start -->

                        <form name="f1" method="post" action="{{ route('signin') }}" autocomplete="off">
                            @csrf
                            <div class="login_card login_box_card">

                                <div class="card_block">

                                    <div class="card_blck_logo">
                                        <img src="{{ asset('public/vendors/images/my_logo.png') }}"
                                             alt="Company Logo" width="50%"/>
                                    </div>
                                    <div class="card_block_title">
                                        <!-- card block title start -->
                                        <h5 class="get-heading-text">
                                            Sign In
                                        </h5>
                                    </div><!-- card block title end -->
                                    <div class="card_block_content">
                                        <!-- card block content start -->

                                        <div class="input-field input_bx">
                                            <input id="user_name" type="text" class="validate inputs_up"
                                                   name="user_name" value="{{ isset($username) ? $username : '' }}"
                                                   required placeholder="User Name"/>
                                        </div>
                                        <div class="input-field input_bx">
                                            <input name="password" id="password" required type="password"
                                                   class="validate inputs_up" placeholder="Password"/>
                                            <span toggle="#password" class="toggle_password">
                                                    <i class="fa fa-eye"></i>
                                                </span>
                                        </div>

                                        <ul class="login_ul">
                                            <li>
                                                <label class="keep_me_btn">
                                                    <input type="checkbox" class="filled-in"/>
                                                    <span>Keep me signed in <i class="fa fa-info-circle tooltipped"
                                                                               data-position="bottom"
                                                                               data-tooltip="<h6 class='white-text left-align gnrl-font-bold gnrl-mrgn-pdng keep_me_tool_title'> Keep me signed in </h6> <p class='left-align gnrl-mrgn-pdng gnrl-font keep_me_tool_cntnt'> Protect your account. Uncheck if using <br /> public/shared device. </p>"></i>
                                                        </span>
                                                </label>
                                            </li>
                                        </ul>

                                        <button type="submit" class="login_btn gnrl-btn-hover-two"
                                                name="btn" value="Sign In">
                                            <span>Sign In</span>
                                            <span>Sign In</span>
                                        </button>

                                        <p class="center-align reset_pass">
                                            Need to find <a class="set_reset_pass" href="javascript: void();"> your
                                                user name </a> or <a class="set_reset_pass"
                                                                     href="javascript: void();"> your
                                                email? </a>
                                        </p>
                                    </div><!-- card block content end -->
                                </div>

                            </div>
                        </form>

                    </div><!-- login box end -->

                    <div class="login_box fliping-front-face-h">
                        <form action="{{ route('password_reset_email') }}" method="post" autocomplete="off">
                            @csrf
                            <div class="login_card login_box_card">

                                <div class="card_block">

                                    <div class="card_blck_logo">
                                        <img src="{{ asset('public/vendors/images/my_logo.png') }}"
                                             alt="Company Logo" width="105"/>
                                    </div>

                                    <div class="card_block_title">
                                        <h5>
                                                <span>
                                                    write Your email to
                                                </span>
                                            Recover Your Password
                                        </h5>
                                    </div>

                                    <div class="card_block_content">
                                        <div class="input-field input_bx">
                                            <input id="email" type="email" name="email"
                                                   class="validate inputs_up" class="validate"
                                                   placeholder="User Email">
                                        </div>

                                        <button type="submit" class="login_btn gnrl-btn-hover-two"
                                                name="btn" value="Sent">
                                            <span>Sent</span>
                                            <span>Sent</span>
                                        </button>
                                        <p class="center-align reset_pass">
                                            Back to <a class="set_reset_pass" href="javascript: void();"> Login
                                                Screen </a>
                                        </p>
                                    </div>

                                </div>

                            </div>
                        </form>
                    </div><!-- login box end -->

                </div>
            </div>
        </div>
    </div>
</section>
@include('include/script')

<script>
    $('.set_reset_pass').click(function () {
        $("#flipping").toggleClass("active");
    });
    $(".toggle-password").click(function () {
        $(this).children('i').toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") === "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });


    $(".toggle_password").click(function () {
        $(this).children('i').toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") === "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });
</script>

<script>
    document.addEventListener("contextmenu", event => event.preventDefault()); //block mouse right click
    $(document).keyup(function (e) {
        if (e.which === 123) {
            // block F12 key
            return false;

        }

        if (e.ctrlKey && e.keyCode === 85) {
            // crtl + u key
            return false;

        }
    });
    $(document).keydown(function (e) {
        if (e.which === 123) {
            // block F12 key
            return false;

        }
        if (e.ctrlKey && e.keyCode === 85) {
            // crtl + u key
            return false;

        }
    });
</script>

</body>

</html>
