<div class="left-side-bar">
    <div class="brand-logo">
        <a href="{{route("index")}}">
            <img src="{{asset("public/vendors/images/my_logo.png")}}" alt="">

        </a>
    </div>
    <div class="menu-block customscroll">
        <div class="sidebar-menu">
            <ul id="accordion-menu" class="accordion-menu">
                <li>
                    <a href="{{route("teller/dashboard")}}" class="dropdown-toggle no-arrow">
                        <span class="fa fa-home"></span><span class="mtext">Home</span>
                    </a>
                </li>

                <li>
                    <a href="{{route("teller/account_ledger")}}" class="dropdown-toggle no-arrow">
                        <span class="fa fa-list"></span><span class="mtext">Ledger</span>
                    </a>
                </li>

                 <li class="dropdown">
                    <a class="dropdown-toggle">
                        <span class="fa fa-clone"></span><span class="mtext">Sale Invoice</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="{{route("teller/sale_invoice")}}">Cash Invoice</a></li>
                        <li><a href="{{route("teller/sale_return_invoice")}}"> Return Invoice</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a class="dropdown-toggle">
                        <span class="fa fa-wrench"></span><span class="mtext">Cash Receive</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="{{route("teller/pending_cash_receive_list")}}">Pending Cash Receive</a></li>
                        <li><a href="{{route("teller/approve_cash_receive_list")}}">Approved Cash Receive</a></li>
                        <li><a href="{{route("teller/reject_cash_receive_list")}}">Rejected Cash Receive</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a class="dropdown-toggle">
                        <span class="fa fa-wrench"></span><span class="mtext">Cash Transfer</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="{{route("teller/cash_transfer")}}">Cash Transfer</a></li>
                        <li><a href="{{route("teller/pending_cash_transfer_list")}}">Pending Cash Receive</a></li>
                        <li><a href="{{route("teller/approve_cash_transfer_list")}}">Approved Cash Receive</a></li>
                        <li><a href="{{route("teller/reject_cash_transfer_list")}}">Rejected Cash Receive</a></li>
                    </ul>
                </li>


{{--                <li class="dropdown">--}}
{{--                    <a class="dropdown-toggle">--}}
{{--                        <span class="fa fa-wrench"></span><span class="mtext">Profile</span>--}}
{{--                    </a>--}}
{{--                    <ul class="submenu">--}}
{{--                        <li><a href="{{route("teller/change_password")}}">Change Password</a></li>--}}
{{--                    </ul>--}}
{{--                </li>--}}

            </ul>
        </div>
    </div>
</div>
