<div class="pre-loader"></div>

<div class="top-header header clearfix ">
    <div class="header-right">
        <div class="brand-logo">
            <a href="{{ url('/') }}">
                <img src={{asset("public/vendors/images/logo.png")}} alt="" class="mobile-logo">
            </a>
        </div>
        <div class="menu-icon btn btn-outline-secondary">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>

        {{--@if ($systm_config->sc_welcome_wizard['wizard_completed'] == 0)--}}
        @php
            use App\Models\College\Branch;
               $user = Auth::user();
               $branches_count = Branch::whereIn('branch_id',explode(',',$user->user_branch_id))->where('branch_type','=','H/O')->select('branch_id','branch_name','branch_no')->count();
              if($branches_count == 0){
                  $branches = Branch::whereIn('branch_id',explode(',',$user->user_branch_id))->select('branch_id','branch_name','branch_no')->get();
              }else{
                  $branches = Branch::where('branch_clg_id',$user->user_clg_id)->select('branch_id','branch_name','branch_no')->get();
              }
        @endphp
        @if($user->user_status=='Employee')
            <div class="welcome-wizard btn btn-success btn-sm">
                <a href="{{ route('wizard.index') }}" class="welcome-wizard__action">Welcome Wizard</a>
            </div>
        @endif
        {{--        <div class="welcome-wizard btn btn-info btn-sm mt-3">--}}
        {{--            <a href="{{ route('student_dashboard') }}" class="welcome-wizard__action">S-Dash</a>--}}
        {{--        </div>--}}
        <a class="welcome-wizard btn btn-info btn-sm mt-3" href="{{ route('student_dashboard') }}">S-Dash</a>
        <div class="user-info-dropdown">
            <div class="dropdown">
                <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                    <span class="user-icon">{{$user->user_name[0]}}</span>
                <!-- <span class="user-name">{{$user->user_name}}</span> -->
                </a>
                <div class="dropdown-menu dropdown-menu-right top_drop_admin">
                    <span class="arrow"></span>
                    <!-- <a class="dropdown-item" href="profile.php"><i class="fa fa-user-md" aria-hidden="true"></i> Profile</a>
                    <a class="dropdown-item" href="profile.php"><i class="fa fa-cog" aria-hidden="true"></i> Setting</a>
                    <a class="dropdown-item" href="faq.php"><i class="fa fa-question" aria-hidden="true"></i> Help</a> -->
                    <b class="card-header"><span class="user-name">{{$user->user_name}}</span></b>
                    <a class="dropdown-item" href="edit_profile"><i class="fa fa-user-md" aria-hidden="true"></i>Change Profile</a>
                    <a class="dropdown-item" href="change_password"><i class="fa fa-cog" aria-hidden="true"></i>Change Password</a>
                    <a class="dropdown-item" href={{route("logout")}}><i class="fa fa-sign-out" aria-hidden="true"></i> Log Out</a>
                </div>
            </div>
        </div>
        @php
            use App\Http\Controllers\DayEndController;
            use App\Http\Controllers\PackagesController;
            $get_day_end = new DayEndController();
            $get_remaining_days = new PackagesController();
            $day_end = $get_day_end->day_end();
            $financials_days = $get_day_end->day_end_start_date();
            $user_remaining_days = $get_remaining_days->user_expiry_alert();
            $branch_name = Session::get('branch_name');
            $branch_no = Session::get('branch_no');
        @endphp
        @if($user->user_status=='Employee')

            <nav class="navbar navbar-expand-lg navbar-light user-navbar">
                <!-- <a class="navbar-brand" href="#"></a>         -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item welcome-wizard__action fianacial">
                            <span class="fianacial_text d-block">Financial Days:</span>
                            <b>{{$financials_days}}</b>

                        </li>
                        <li class="nav-item welcome-wizard__action expiry">
                            <span class="expiry_text d-block">License Expire After:</span>
                            <b>{{$user_remaining_days}}</b>
                            <span class="expiry_text">Days</span>
                        </li>
                        <li class="nav-item">
                            <span class="d-block">Expiry Date: </span>
                            {{ date('d-m-Y', strtotime(str_replace('/', '-', $user->user_expiry_date))) }}
                        </li>
                        <li class="nav-item">
                            <span class="d-block">Financial Date:</span>
                            {{ date('d-m-Y', strtotime(str_replace('/', '-', $day_end->de_datetime))) }}
                        </li>
                        <li class="nav-item">
                                    <span class="d-block">
                                        Current Date:
                                    </span>
                            {{date("d-m-Y")}}
                        </li>
                        <li class="nav-item">
                            <div class="dropdown">
                                <button class="btn btn-info dropdown-toggle" type="button" id="branchSelectButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{$branch_name}} {{$branch_no}}
                                </button>
                                <div class="dropdown-menu" aria-labelledby="branchSelectButton">
                                    @foreach($branches as $branch)
                                        <a class="dropdown-item" href="{{route("branch.branch_session",$branch->branch_id)}}">{{$branch->branch_name}} {{$branch->branch_no}}</a>
                                    @endforeach
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="user-reminders d-none">
                <ul>
                    <li class="nav-item welcome-wizard__action fianacial">
                        <span class="fianacial_text">Financial Days:</span>
                        <b>{{$financials_days}}</b>
                    </li>
                    <li class="nav-item welcome-wizard__action expiry">
                        <span class="expiry_text">License Expire After:</span>
                        <b>{{$user_remaining_days}}</b>
                        <span class="expiry_text">Days</span>
                    </li>
                    <li class="nav-item">
                        <span>Expiry Date: </span>
                        {{$user->user_expiry_date}}
                    </li>
                    <li class="nav-item">
                        <span>Financial Date:</span>
                        {{$day_end->de_datetime}}
                    </li>
                    <li class="nav-item">
                                <span>
                                    Current Date:
                                </span>
                        {{date("Y-m-d")}}
                    </li>
                </ul>
            </div>
        @endif
        <div class="user-notification mr-auto">
            @if($user->user_status=='Non Employee')
                @php
                    $cart = App\Models\AddToCartModal::where('atc_created_by',$user->user_id)
                     ->leftJoin('financials_products', 'financials_products.pro_p_code', '=', 'financials_add_to_cart.atc_pro_code')
                     ->select('financials_add_to_cart.*', 'financials_products.pro_image as image')->get();
                @endphp
                <div class="cart-dropdown my-cart">
                    <button type="button" class="btn btn-info" data-toggle="dropdown">
                        <i class="fa fa-shopping-cart" aria-hidden="true"></i> Cart <span class="badge badge-pill badge-danger cart_no">
                            {{$cart->count()}}
                        </span>
                    </button>
                    <div class="dropdown-menu">
                        <div class="row total-header-section">
                            <div class="col-lg-6 col-sm-6 col-6">
                                <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span class="badge badge-pill badge-danger cart_no">{{$cart->count()}}</span>
                            </div>
                            @php $total = 0 @endphp
                            @foreach($cart as  $details)
                                @php $total += $details->atc_price * $details->atc_qty @endphp
                            @endforeach
                            <div class="col-lg-6 col-sm-6 col-6 total-section text-right">
                                <p>Total: <span class="text-info" id="total">RS- {{ $total }}</span></p>
                            </div>
                        </div>
                        <div class="scrollbar operation">
                            @foreach($cart as $id => $details)
                                <div class="row cart-detail">
                                    <div class="col-lg-4 col-sm-4 col-4 cart-detail-img">
                                        <img src="{{ $details->image }}"/>
                                    </div>
                                    <div class="col-lg-8 col-sm-8 col-8 cart-detail-product">
                                        <p>{{ $details->atc_pro_name }}</p>
                                        <span class="price text-info"> RS-{{ $details->atc_price }}</span> <span class="count"> Quantity:{{ $details->atc_qty }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-12 text-center checkout">
                                <a href="{{ route('cart') }}" class="btn btn-primary btn-sm btn-block">View all</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <style>
            .dates_manage p {
                margin: 0 15px 0 0;
            }

            .scrollbar {
                float: left;
                max-height: 300px;
                overflow-y: scroll;
                overflow-x: clip;
            }

            .operation::-webkit-scrollbar-track {
                -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
                background-color: #F5F5F5;
            }

            .operation::-webkit-scrollbar {
                width: 6px;
                background-color: #F5F5F5;
            }

            .operation::-webkit-scrollbar-thumb {
                background-color: #2A88AD;
            }

            .user-notification .my-cart .checkout .btn {
                font-size: 1rem;
                height: auto !important;
            }

            .user-notification {
                padding: 10px 20px 10px 0 !important;
            }

            .user-notification .my-cart {
                padding: 0;
                position: relative;
            }

            .user-notification .my-cart .navbar ul {
                padding: 0;
                list-style: none;
                display: flex;
                margin: 0;
            }

            .user-notification .my-cart .product_box {
                position: relative;
                padding: 10px;
                margin-bottom: 20px;
                box-shadow: 0 0px 8px #ccc;
                text-align: center;
            }

            .user-notification .my-cart .product_box .caption p {
                margin: 0;
            }

            .user-notification .my-cart .product_box .caption p a {
                background: #FF9800;
                color: #fff;
            }

            .user-notification .my-cart button.btn.btn-info {
                background: rgba(48, 90, 114, 1);
            }

            .user-notification .my-cart button.btn.btn-info:hover {
                background: rgba(48, 122, 165, 1);
                border-color: rgba(48, 90, 114, 1);
                color: #fff;
            }

            .user-notification .my-cart .text-info {
                color: rgba(48, 90, 114, 1) !important;
            }

            .user-notification .my-cart .product_box img {
                width: 80%;
            }

            .user-notification .my-cart .product_box .caption {
                margin: 7px;
            }

            .user-notification .my-cart .main-section {
                background-color: #F8F8F8;
            }

            .user-notification .my-cart .cart-dropdown {
                float: right;
                padding-right: 30px;
            }

            .user-notification .my-cart .btn {
                box-shadow: none !important;
            }

            .user-notification .my-cart.cart-dropdown .dropdown-menu {
                padding: 20px;
                top: 10px !important;
                width: 350px !important;
                left: -150px !important;
                box-shadow: 0px 5px 30px black;
            }

            .user-notification .my-cart .total-header-section {
                border-bottom: 1px solid #d2d2d2;
            }

            .user-notification .my-cart .total-section p {
                margin-bottom: 20px;
            }

            .user-notification .my-cart .cart-detail {
                padding: 15px 0px;
                border-bottom: 1px solid #e1e1e1;
            }

            .user-notification .my-cart .cart-detail:last-child {
                border-bottom: 0;
            }

            .user-notification .my-cart .cart-detail-img img {
                width: 100%;
                height: 100%;
            }

            .user-notification .my-cart .cart-detail-product p {
                margin: 0px;
                color: #000;
                font-weight: 500;
            }

            .user-notification .my-cart .cart-detail .price {
                font-size: 12px;
                margin-right: 10px;
                font-weight: 500;
            }

            .user-notification .my-cart .cart-detail .count {
                color: #C2C2DC;
            }

            .checkout {
                border-top: 1px solid #d2d2d2;
                padding-top: 15px;
            }

            .checkout .btn-primary {
                height: 45px;
                background: rgba(48, 90, 114, 1);
                font-size: 22px;
                padding: 3px 0 0;
            }

            .checkout .btn-primary:hover {
                background: rgba(48, 122, 165, 1);
                border-color: rgba(48, 90, 114, 1);
                color: #fff;
            }

            .user-notification .my-cart .dropdown-menu:before {
                content: " ";
                position: absolute;
                top: -20px;
                right: 50px;
                border: 10px solid transparent;
                border-bottom-color: #fff;
            }
        </style>
    </div>
</div>
<script>
    $(document).ready(function () {
        if ('{!! $financials_days !!}' >= 355) {

            $(".fianacial").css({"background": "red", "animation": "shadow-pulse 1s infinite", "color": "white", "text-align": "center",});
            $(".expiry_text").css({"color": "white"});
        }
        if ('{!! $user_remaining_days !!}' <= 15) {

            $(".expiry").css({"background": "red", "animation": "shadow-pulse 1s infinite", "color": "white", "text-align": "center",});
            $(".expiry_text").css({"color": "white"});
        }
    });
</script>
