<div class="left-side-bar">
    <div class="brand-logo">
        <a href={{route("index" )}}>
            <img src={{asset("public/vendors/images/my_logo.png")}} alt="">

        </a>
    </div>

    @php
        $first_level_modules = Session::get('first_level_modules');
        $second_level_modules = Session::get('second_level_modules');
        $third_level_modules = Session::get('third_level_modules');
    @endphp

    <div class="menu-block customscroll">
        <div class="sidebar-menu">
            <ul id="accordion-menu" class="accordion-menu">
                <li>
                    <a href="{{route("index")}}" class="dropdown-toggle no-arrow">
                        <span class="fa fa-home"></span><span class="mtext">Home</span>
                    </a>
                </li>

                @if(in_array(1,$first_level_modules))

                    <li class="dropdown">
                        <a class="dropdown-toggle">
                            <span class="fa fa-user-circle-o"></span><span class="mtext">Registration</span>
                        </a>
                        <ul class="submenu">

                            @if(in_array(110,$second_level_modules))
                                <li class="dropdown">
                                    <a class="dropdown-toggle">
                                        <span class="fa fa-area-chart"></span><span
                                                class="mtext">Party Registration</span>
                                    </a>
                                    <ul class="submenu child">
                                        @if(in_array(1101,$third_level_modules))
                                            <li><a href="{{route("add_region")}}">Add Region</a></li>
                                        @endif
                                        @if(in_array(1102,$third_level_modules))
                                            <li><a href="{{route("add_area")}}">Add Area</a></li>
                                        @endif
                                        @if(in_array(1103,$third_level_modules))
                                            <li><a href="{{route("add_sector")}}">Add Sector</a></li>
                                        @endif
                                        @if(in_array(1104,$third_level_modules))
                                            <li><a href="{{route("receivables_account_registration")}}">Client</a></li>
                                        @endif
                                        @if(in_array(1105,$third_level_modules))
                                            <li><a href="{{route("payables_account_registration")}}">Supplier</a></li>
                                        @endif

                                    </ul>
                                </li>

                            @endif
                            @if(in_array(111,$second_level_modules))
                                <li class="dropdown">
                                    <a class="dropdown-toggle">
                                        <span class="fa fa-area-chart"></span><span
                                                class="mtext">Account Registration</span>
                                    </a>
                                    <ul class="submenu child">
                                        @if(in_array(1111,$third_level_modules))
                                            <li><a href="{{route("bank_account_registration")}}">Bank Account</a></li>
                                        @endif
                                        @if(in_array(1112,$third_level_modules))
                                            <li><a href="{{route("salary_account_registration")}}">Salary Account</a>
                                            </li>
                                        @endif
                                        @if(in_array(1113,$third_level_modules))
                                            <li><a href="{{route("expense_account_registration")}}">Expense Account</a>
                                            </li>
                                        @endif
                                        @if(in_array(1114,$third_level_modules))
                                            <li><a href="{{route("first_level_chart_of_account")}}">Control Account</a>
                                            </li>
                                        @endif
                                        @if(in_array(1115,$third_level_modules))
                                            <li><a href="{{route("add_second_level_chart_of_account")}}">Group
                                                    Account</a></li>
                                        @endif
                                        @if(in_array(1116,$third_level_modules))
                                            <li><a href="{{route("add_third_level_chart_of_account")}}">Parent
                                                    Account</a></li>
                                        @endif
                                        @if(in_array(1117,$third_level_modules))
                                            <li><a href="{{route("default_account_list")}}">Fixed Account</a></li>
                                        @endif
                                        @if(in_array(1118,$third_level_modules))
                                            <li><a href="{{route("add_account_group")}}">Reporting Group</a></li>
                                        @endif
                                        @if(in_array(1119,$third_level_modules))
                                            <li><a href="{{route("account_registration")}}">Entry Account</a></li>
                                        @endif

                                    </ul>
                                </li>
                            @endif
                            @if(in_array(112,$second_level_modules))
                                <li class="dropdown">
                                    <a class="dropdown-toggle">
                                        <span class="fa fa-area-chart"></span><span
                                                class="mtext">General Registrations</span>
                                    </a>
                                    <ul class="submenu child">

                                        @if(in_array(1121,$third_level_modules))
                                            <li><a href="{{route("cash_transfer")}}">Cash Transfer</a></li>
                                        @endif
                                        @if(in_array(1122,$third_level_modules))
                                            <li><a href="{{route("pending_cash_receive_list")}}">Cash Receive</a></li>
                                        @endif
                                        @if(in_array(1123,$third_level_modules))
                                            <li><a href="{{route("add_credit_card_machine")}}">Credit card Machine</a>
                                            </li>
                                        @endif
                                        @if(in_array(1124,$third_level_modules))
                                            <li><a href="{{route("add_warehouse")}}">Warehouse</a></li>
                                        @endif
                                        @if(in_array(1125,$third_level_modules))
                                            <li><a href="{{route("add_employee")}}">Employee</a></li>
                                        @endif

                                    </ul>
                                </li>
                            @endif
                            @if(in_array(113,$second_level_modules))

                                <li class="dropdown">
                                    <a class="dropdown-toggle">
                                        <span class="fa fa-area-chart"></span><span
                                                class="mtext">Product Registrations</span>
                                    </a>
                                    <ul class="submenu child">
                                        @if(in_array(1131,$third_level_modules))
                                            <li><a href="{{route("add_main_unit")}}">Measurement Main Unit</a></li>
                                        @endif
                                        @if(in_array(1132,$third_level_modules))
                                            <li><a href="{{route("add_unit")}}">Measurement Unit</a></li>
                                        @endif
                                        @if(in_array(1133,$third_level_modules))
                                            <li><a href="{{route("add_group")}}">Group</a></li>
                                        @endif
                                        @if(in_array(1134,$third_level_modules))
                                            <li><a href="{{route("add_category")}}">Category</a></li>
                                        @endif
                                        @if(in_array(1135,$third_level_modules))
                                            <li><a href="{{route("add_product")}}">Product</a></li>
                                        @endif
                                        @if(in_array(1136,$third_level_modules))
                                            <li><a href="{{route("add_services")}}">Services</a></li>
                                        @endif
                                        @if(in_array(1137,$third_level_modules))
                                            <li><a href={{route("add_transfer_product_stock")}}>Transfer Product
                                                    Stock</a></li>
                                        @endif
                                        @if(in_array(1138,$third_level_modules))
                                            <li><a href={{route("product_loss")}}>Loss Product</a></li>
                                        @endif
                                        @if(in_array(1139,$third_level_modules))
                                            <li><a href={{route("product_recover")}}>Recover Product</a></li>
                                        @endif

                                    </ul>
                                </li>

                            @endif
                            @if(in_array(114,$second_level_modules))
                                <li class="dropdown">
                                    <a class="dropdown-toggle">
                                        <span class="fa fa-area-chart"></span><span class="mtext">Opening Balance</span>
                                    </a>
                                    <ul class="submenu child">

                                        @if(in_array(1141,$third_level_modules))
                                            <li><a href="{{route("account_opening_balance")}}">Account Opening
                                                    Balance</a></li>
                                        @endif
                                        @if(in_array(1142,$third_level_modules))
                                            <li><a href="{{route("parties_opening_balance")}}">Parties Opening
                                                    Balance</a></li>
                                        @endif

                                    </ul>
                                </li>
                            @endif


                        </ul>
                    </li>

                @endif

                @if(in_array(2,$first_level_modules))
                    <li class="dropdown">
                        <a class="dropdown-toggle">
                            <span class="fa fa-user-circle-o"></span><span class="mtext">Invoices</span>
                        </a>
                        <ul class="submenu">

                            @if(in_array(210,$second_level_modules))

                                <li class="dropdown">
                                    <a class="dropdown-toggle">
                                        <span class="fa fa-area-chart"></span><span
                                                class="mtext">Purchase Invoice</span>
                                    </a>
                                    <ul class="submenu child">

                                        @if(in_array(2101,$third_level_modules))
                                            <li><a href="{{route("purchase_invoice_on_net")}}">Cash Invoice</a></li>
                                        @endif
                                        @if(in_array(2102,$third_level_modules))
                                            <li><a href="{{route("purchase_invoice")}}">Credit Invoice</a></li>
                                        @endif
                                        @if(in_array(2103,$third_level_modules))
                                            <li><a href="{{route("purchase_return_full_invoice")}}">Return Invoice
                                                    (Full)</a></li>
                                        @endif
                                        @if(in_array(2104,$third_level_modules))
                                            <li><a href="{{route("purchase_return_partial_invoice")}}">Return Invoice
                                                    (Partial)</a></li>
                                        @endif
                                        @if(in_array(2105,$third_level_modules))
                                            <li><a href="{{route("purchase_return_without_invoice")}}">Return Invoice
                                                    (Without Invoice)</a></li>
                                        @endif

                                    </ul>
                                </li>
                            @endif
                            @if(in_array(211,$second_level_modules))
                                <li class="dropdown">
                                    <a class="dropdown-toggle">
                                        <span class="fa fa-area-chart"></span><span class="mtext">Sale Invoice</span>
                                    </a>
                                    <ul class="submenu child">

                                        @if(in_array(2111,$third_level_modules))
                                            <li><a href="{{route("sale_invoice_on_net")}}">Cash/POS Invoice</a></li>
                                        @endif
                                        @if(in_array(2112,$third_level_modules))
                                            <li><a href="{{route("sale_invoice")}}">Credit Invoice</a></li>
                                        @endif
                                        @if(in_array(2113,$third_level_modules))
                                            <li><a href="{{route("services_invoice")}}">Services Invoice</a></li>
                                        @endif
                                        @if(in_array(2114,$third_level_modules))
                                            <li><a href="{{route("services_invoice_on_cash")}}">Cash Services
                                                    Invoice</a></li>
                                        @endif
                                        @if(in_array(2115,$third_level_modules))
                                            <li><a href="{{route("sale_return_full_invoice")}}">Return Invoice
                                                    (Full)</a></li>
                                        @endif
                                        @if(in_array(2116,$third_level_modules))
                                            <li><a href="{{route("sale_return_partial_invoice")}}">Return Invoice
                                                    (Partial)</a></li>
                                        @endif
                                        @if(in_array(2117,$third_level_modules))
                                            <li><a href="{{route("sale_return_without_invoice")}}">Return Invoice
                                                    (Without Invoice)</a></li>
                                        @endif
                                    </ul>
                                </li>
                            @endif
                            @if(in_array(212,$second_level_modules))
                                <li class="dropdown">
                                    <a class="dropdown-toggle">
                                        <span class="fa fa-area-chart"></span><span
                                                class="mtext">Tax Invoice (Purchase)</span>
                                    </a>
                                    <ul class="submenu child">

                                        @if(in_array(2121,$third_level_modules))
                                            <li><a href="{{route("income_tax_purchase_invoice")}}">Income Tax
                                                    Invoice</a></li>
                                        @endif
                                        @if(in_array(2122,$third_level_modules))
                                            <li><a href="{{route("sale_tax_purchase_invoice")}}">Sale Tax Invoice</a>
                                            </li>
                                        @endif


                                    </ul>
                                </li>
                            @endif
                            @if(in_array(213,$second_level_modules))

                                <li class="dropdown">
                                    <a class="dropdown-toggle">
                                        <span class="fa fa-area-chart"></span><span
                                                class="mtext">Tax Invoice (Sales)</span>
                                    </a>
                                    <ul class="submenu child">

                                        @if(in_array(2131,$third_level_modules))
                                            <li><a href="{{route("income_tax_sale_invoice")}}">Income Tax Invoice</a>
                                            </li>
                                        @endif
                                        @if(in_array(2132,$third_level_modules))
                                            <li><a href="{{route("sale_tax_sale_invoice")}}">Sale Tax Invoice</a></li>
                                        @endif
                                        @if(in_array(2133,$third_level_modules))
                                            <li><a href="{{route("service_tax_invoice")}}">Service Tax Invoice</a></li>
                                        @endif

                                    </ul>
                                </li>
                            @endif

                        </ul>
                    </li>

                @endif

                @if(in_array(3,$first_level_modules))
                    <li class="dropdown">
                        <a class="dropdown-toggle">
                            <span class="fa fa-user-circle-o"></span><span class="mtext">Finance</span>
                        </a>
                        <ul class="submenu">
                            @if(in_array(310,$second_level_modules))
                                <li class="dropdown">
                                    <a class="dropdown-toggle">
                                        <span class="fa fa-area-chart"></span><span class="mtext">Cash Vouchers</span>
                                    </a>
                                    <ul class="submenu child">

                                        @if(in_array(3101,$third_level_modules))
                                            <li><a href="{{route("cash_receipt_voucher")}}">Cash Receipt Voucher</a>
                                            </li>
                                        @endif
                                        @if(in_array(3102,$third_level_modules))
                                            <li><a href="{{route("cash_payment_voucher")}}">Cash Payment Voucher</a>
                                            </li>
                                        @endif

                                    </ul>
                                </li>
                            @endif
                            @if(in_array(311,$second_level_modules))
                                <li class="dropdown">
                                    <a class="dropdown-toggle">
                                        <span class="fa fa-area-chart"></span><span class="mtext">Bank Vouchers</span>
                                    </a>
                                    <ul class="submenu child">

                                        @if(in_array(3111,$third_level_modules))
                                            <li><a href="{{route("online_payment_receive")}}">Online Payment
                                                    Received</a></li>
                                        @endif
                                        @if(in_array(3112,$third_level_modules))
                                            <li><a href="{{route("online_payment_paid")}}">Online Payment Paid</a></li>
                                        @endif
                                        @if(in_array(3113,$third_level_modules))
                                            <li><a href="{{route("add_post_dated_cheque_issue")}}">Post Dated Cheque
                                                    Issue</a></li>
                                        @endif
                                        @if(in_array(3114,$third_level_modules))
                                            <li><a href="{{route("add_post_dated_cheque_received")}}">Post Dated Cheque
                                                    Received</a></li>
                                        @endif
                                        @if(in_array(3115,$third_level_modules))
                                            <li><a href="{{route("bank_receipt_voucher")}}">Bank Receipt Voucher</a>
                                            </li>
                                        @endif
                                        @if(in_array(3116,$third_level_modules))
                                            <li><a href="{{route("bank_payment_voucher")}}">Bank Payment Voucher</a>
                                            </li>
                                        @endif
                                        @if(in_array(3117,$third_level_modules))
                                            <li><a href="{{route("journal_voucher_bank")}}">Bank Journal Voucher</a>
                                            </li>
                                        @endif

                                    </ul>
                                </li>

                            @endif
                            @if(in_array(312,$second_level_modules))
                                <li class="dropdown">
                                    <a class="dropdown-toggle">
                                        <span class="fa fa-area-chart"></span><span
                                                class="mtext">Journal Vouchers</span>
                                    </a>
                                    <ul class="submenu child">

                                        @if(in_array(3121,$third_level_modules))
                                            <li><a href="{{route("journal_voucher")}}">Journal Voucher</a></li>
                                        @endif

                                    </ul>
                                </li>

                            @endif
                            @if(in_array(313,$second_level_modules))

                                <li class="dropdown">
                                    <a class="dropdown-toggle">
                                        <span class="fa fa-area-chart"></span><span
                                                class="mtext">Expense Vouchers</span>
                                    </a>
                                    <ul class="submenu child">

                                        @if(in_array(3131,$third_level_modules))
                                            <li><a href="{{route("expense_payment_voucher")}}">Expense Payment
                                                    Voucher</a></li>
                                        @endif

                                    </ul>
                                </li>

                            @endif
                            @if(in_array(314,$second_level_modules))

                                <li class="dropdown">
                                    <a class="dropdown-toggle">
                                        <span class="fa fa-area-chart"></span><span class="mtext">Salary Vouchers</span>
                                    </a>
                                    <ul class="submenu child">

                                        @if(in_array(3141,$third_level_modules))
                                            <li><a href="{{route("add_advance_salary")}}">Advance Salary </a></li>
                                        @endif
                                        @if(in_array(3142,$third_level_modules))
                                            <li><a href="{{route("salary_slip_voucher")}}">Generate Salary Slip</a></li>
                                        @endif
                                        @if(in_array(3143,$third_level_modules))
                                            <li><a href="{{route("salary_payment_voucher")}}">Salary Payment Voucher</a>
                                            </li>
                                        @endif

                                    </ul>
                                </li>

                            @endif

                        </ul>
                    </li>
                @endif

                @if(in_array(4,$first_level_modules))

                    <li class="dropdown">
                        <a class="dropdown-toggle">
                            <span class="fa fa-user-circle-o"></span><span class="mtext">Registration Report</span>
                        </a>
                        <ul class="submenu">
                            @if(in_array(410,$second_level_modules))
                                <li class="dropdown">
                                    <a class="dropdown-toggle">
                                        <span class="fa fa-area-chart"></span><span class="mtext">Party Registration Reports</span>
                                    </a>
                                    <ul class="submenu child">

                                        @if(in_array(4101,$third_level_modules))
                                            <li><a href="{{route("region_list")}}">Region</a></li>
                                        @endif
                                        @if(in_array(4102,$third_level_modules))
                                            <li><a href="{{route("area_list")}}">Area</a></li>
                                        @endif
                                        @if(in_array(4103,$third_level_modules))
                                            <li><a href="{{route("sector_list")}}">Sector</a></li>
                                        @endif
                                        @if(in_array(4104,$third_level_modules))
                                            <li><a href="{{route("account_receivable_payable_list")}}">Parties Info
                                                    Reports</a></li>
                                        @endif

                                    </ul>
                                </li>

                            @endif
                            @if(in_array(411,$second_level_modules))
                                <li class="dropdown">
                                    <a class="dropdown-toggle">
                                        <span class="fa fa-area-chart"></span><span
                                                class="mtext">Account Registration</span>
                                    </a>
                                    <ul class="submenu child">

                                        @if(in_array(4111,$third_level_modules))
                                            <li><a href="{{route("chart_of_account")}}">Chart of Account Tree View</a>
                                            </li>
                                        @endif
                                        @if(in_array(4112,$third_level_modules))
                                            <li><a href="{{route("default_account_list_view")}}">Fixed Account</a></li>
                                        @endif
                                        @if(in_array(4113,$third_level_modules))
                                            <li><a href="{{route("account_group_list")}}">Reporting Group</a></li>
                                        @endif
                                        @if(in_array(4114,$third_level_modules))
                                            <li><a href="{{route("account_list")}}">Entry Account</a></li>
                                        @endif

                                    </ul>
                                </li>

                            @endif
                            @if(in_array(412,$second_level_modules))

                                <li class="dropdown">
                                    <a class="dropdown-toggle">
                                        <span class="fa fa-area-chart"></span><span
                                                class="mtext">General Registrations</span>
                                    </a>
                                    <ul class="submenu child">

                                        @if(in_array(4121,$third_level_modules))
                                            <li><a href="{{route("credit_card_machine_list")}}">Credit card Machine</a>
                                            </li>
                                        @endif
                                        @if(in_array(4122,$third_level_modules))
                                            <li><a href="{{route("warehouse_list")}}">Warehouse</a></li>
                                        @endif
                                        @if(in_array(4123,$third_level_modules))
                                            <li><a href="{{route("employee_list")}}">Employee</a></li>
                                        @endif

                                    </ul>
                                </li>
                            @endif
                            @if(in_array(413,$second_level_modules))

                                <li class="dropdown">
                                    <a class="dropdown-toggle">
                                        <span class="fa fa-area-chart"></span><span
                                                class="mtext">Product Registrations</span>
                                    </a>
                                    <ul class="submenu child">

                                        @if(in_array(4131,$third_level_modules))
                                            <li><a href="{{route("main_unit_list")}}">Measurement Main Unit</a></li>
                                        @endif
                                        @if(in_array(4132,$third_level_modules))
                                            <li><a href="{{route("unit_list")}}">Measurement Unit</a></li>
                                        @endif
                                        @if(in_array(4133,$third_level_modules))
                                            <li><a href="{{route("group_list")}}">Group</a></li>
                                        @endif
                                        @if(in_array(4134,$third_level_modules))
                                            <li><a href="{{route("category_list")}}">Category</a></li>
                                        @endif
                                        @if(in_array(4135,$third_level_modules))
                                            <li><a href="{{route("product_list")}}">Product</a></li>
                                        @endif

                                    </ul>
                                </li>

                            @endif

                        </ul>
                    </li>
                @endif

                @if(in_array(5,$first_level_modules))

                    <li class="dropdown">
                        <a class="dropdown-toggle">
                            <span class="fa fa-user-circle-o"></span><span class="mtext">Inventory Reports</span>
                        </a>
                        <ul class="submenu">

                            @if(in_array(510,$second_level_modules))
                                <li class="dropdown">
                                    <a class="dropdown-toggle">
                                        <span class="fa fa-area-chart"></span><span
                                                class="mtext">Purchase Reports</span>
                                    </a>
                                    <ul class="submenu child">

                                        @if(in_array(5101,$third_level_modules))
                                            <li><a href="{{route("purchase_invoice_list")}}">Purchase Invoice</a></li>
                                        @endif
                                        @if(in_array(5102,$third_level_modules))
                                            <li><a href="{{route("purchase_return_invoice_list")}}">Purchase Return
                                                    Invoices</a></li>
                                        @endif
                                        @if(in_array(5103,$third_level_modules))
                                            <li><a href="{{route("income_tax_purchase_invoice_list")}}">Income Tax
                                                    Invoices</a></li>
                                        @endif
                                        @if(in_array(5104,$third_level_modules))
                                            <li><a href="{{route("sale_tax_purchase_invoice_list")}}">Sale Tax
                                                    Invoices</a></li>
                                        @endif

                                    </ul>
                                </li>

                            @endif
                            @if(in_array(511,$second_level_modules))
                                <li class="dropdown">
                                    <a class="dropdown-toggle">
                                        <span class="fa fa-area-chart"></span><span class="mtext">Sale Reports</span>
                                    </a>
                                    <ul class="submenu child">

                                        @if(in_array(5111,$third_level_modules))
                                            <li><a href="{{route("sale_invoice_list")}}">Sale Invoice</a></li>
                                        @endif
                                        @if(in_array(5112,$third_level_modules))
                                            <li><a href="{{route("sale_return_invoice_list")}}">Sale Return Invoices</a>
                                            </li>
                                        @endif
                                        @if(in_array(5113,$third_level_modules))
                                            <li><a href="{{route("income_tax_sale_invoice_list")}}">Income Tax
                                                    Invoices</a></li>
                                        @endif
                                        @if(in_array(5114,$third_level_modules))
                                            <li><a href="{{route("sale_tax_sale_invoice_list")}}">Sale Tax Invoices</a>
                                            </li>
                                        @endif
                                        @if(in_array(5115,$third_level_modules))
                                            <li><a href="{{route("service_tax_sale_invoice_list")}}">Service Tax
                                                    Invoices</a></li>
                                        @endif

                                    </ul>
                                </li>
                            @endif

                        </ul>
                    </li>
                @endif

                @if(in_array(6,$first_level_modules))

                    <li class="dropdown">
                        <a class="dropdown-toggle">
                            <span class="fa fa-user-circle-o"></span><span class="mtext">Party Ledger</span>
                        </a>
                        <ul class="submenu">


                            @if(in_array(610,$second_level_modules))
                                <li class="dropdown">
                                    <a class="dropdown-toggle">
                                        <span class="fa fa-area-chart"></span><span class="mtext">Parties Wise Detail Report</span>
                                    </a>
                                    <ul class="submenu child">

                                        @if(in_array(6101,$third_level_modules))
                                            <li><a href="{{route("party_wise_opening_closing")}}">Party Wise Opening
                                                    Closing</a></li>
                                        @endif
                                    </ul>
                                </li>

                            @endif
                            @if(in_array(611,$second_level_modules))
                                <li class="dropdown">
                                    <a class="dropdown-toggle">
                                        <span class="fa fa-area-chart"></span><span
                                                class="mtext">Account Receivable</span>
                                    </a>
                                    <ul class="submenu child">

                                        @if(in_array(6111,$third_level_modules))
                                            <li><a href="{{route("account_receivable_list")}}">Sale Parties</a></li>
                                        @endif
                                    </ul>
                                </li>
                            @endif
                            @if(in_array(612,$second_level_modules))
                                <li class="dropdown">
                                    <a class="dropdown-toggle">
                                        <span class="fa fa-area-chart"></span><span class="mtext">Account Payable</span>
                                    </a>
                                    <ul class="submenu child">

                                        @if(in_array(6121,$third_level_modules))
                                            <li><a href="{{route("account_payable_list")}}">Purchase Parties</a></li>
                                        @endif
                                    </ul>
                                </li>
                            @endif

                            @if(in_array(613,$second_level_modules))

                                <li class="dropdown">
                                    <a class="dropdown-toggle">
                                        <span class="fa fa-area-chart"></span><span class="mtext">Aging Reports</span>
                                    </a>
                                    <ul class="submenu child">

                                        @if(in_array(6131,$third_level_modules))
                                            <li><a href="{{route("aging_report_party_wise_purchase")}}">Party Wise
                                                    Purchase Aging</a></li>
                                        @endif
                                        @if(in_array(6132,$third_level_modules))
                                            <li><a href="{{route("aging_report_party_wise_sale")}}">Party Wise Sale
                                                    Aging</a></li>
                                        @endif
                                        @if(in_array(6133,$third_level_modules))
                                            <li><a href="{{route("aging_report_product_wise")}}">Product Wise Aging</a>
                                            </li>
                                        @endif

                                    </ul>
                                </li>
                            @endif

                        </ul>
                    </li>

                @endif

                @if(in_array(7,$first_level_modules))
                    <li class="dropdown">
                        <a class="dropdown-toggle">
                            <span class="fa fa-user-circle-o"></span><span class="mtext">Profit Reports</span>
                        </a>
                        <ul class="submenu">

                            @if(in_array(710,$second_level_modules))


                                <li class="dropdown">
                                    <a class="dropdown-toggle">
                                        <span class="fa fa-area-chart"></span><span class="mtext">Invoice Wise Profit Report</span>
                                    </a>
                                    <ul class="submenu child">

                                        @if(in_array(7101,$third_level_modules))
                                            <li><a href="{{route("sale_person_wise_profit")}}">Sale Man Wise Profit</a>
                                            </li>
                                        @endif
                                        @if(in_array(7102,$third_level_modules))
                                            <li><a href="{{route("client_wise_profit")}}">Client Wise Profit</a></li>
                                        @endif
                                        @if(in_array(7103,$third_level_modules))
                                            <li><a href="{{route("supplier_wise_profit")}}">Supplier Wise Profit</a>
                                            </li>
                                        @endif
                                        @if(in_array(7104,$third_level_modules))
                                            <li><a href="{{route("product_wise_profit")}}">Product Wise Profit</a></li>
                                        @endif
                                        @if(in_array(7105,$third_level_modules))
                                            <li><a href="{{route("sale_invoice_wise_profit")}}">Invoice Wise Profit</a>
                                            </li>
                                        @endif

                                    </ul>
                                </li>
                            @endif


                        </ul>
                    </li>
                @endif
                @if(in_array(8,$first_level_modules))
                    <li class="dropdown">
                        <a class="dropdown-toggle">
                            <span class="fa fa-user-circle-o"></span><span class="mtext">Product Reports</span>
                        </a>
                        <ul class="submenu">

                            @if(in_array(810,$second_level_modules))

                                <li class="dropdown">
                                    <a class="dropdown-toggle">
                                        <span class="fa fa-area-chart"></span><span
                                                class="mtext">Product Ledger Report</span>
                                    </a>
                                    <ul class="submenu child">
                                        @if(in_array(8101,$third_level_modules))
                                            <li><a href="{{route("product_ledger_stock_wise")}}">Product Ledger Stock
                                                    Wise</a></li>
                                        @endif
                                        @if(in_array(8102,$third_level_modules))
                                            <li><a href="{{route("product_ledger_amount_wise")}}">Product Ledger Amount
                                                    Wise</a></li>
                                        @endif
                                        @if(in_array(8103,$third_level_modules))
                                            <li><a href="{{route("product_last_purchase_rate_verification")}}">Product
                                                    Last Purchase Rate Verification</a></li>
                                        @endif
                                        @if(in_array(8104,$third_level_modules))
                                            <li><a href="{{route("product_last_sale_rate_verification")}}">Product Last
                                                    Sale Rate Verification</a></li>
                                        @endif
                                    </ul>
                                </li>
                            @endif

                        </ul>
                    </li>
                @endif

                @if(in_array(9,$first_level_modules))
                    <li class="dropdown">
                        <a class="dropdown-toggle">
                            <span class="fa fa-user-circle-o"></span><span class="mtext">Module</span>
                        </a>
                        <ul class="submenu">

                            @if(in_array(910,$second_level_modules))

                                <li class="dropdown">
                                    <a class="dropdown-toggle">
                                        <span class="fa fa-area-chart"></span><span class="mtext">Module Creation</span>
                                    </a>
                                    <ul class="submenu child">
                                        @if(in_array(9101,$third_level_modules))
                                            <li><a href="{{route("add_modular_group")}}">Add Modular Group</a></li>
                                        @endif
                                    </ul>
                                </li>
                            @endif

                        </ul>
                    </li>
                @endif

                {{--                <li class="dropdown">--}}
                {{--                    <a class="dropdown-toggle">--}}
                {{--                        <span class="fa fa-user-circle-o"></span><span class="mtext">Party Ledgers</span>--}}
                {{--                    </a>--}}
                {{--                    <ul class="submenu">--}}

                {{--                        <li class="dropdown">--}}
                {{--                            <a class="dropdown-toggle">--}}
                {{--                                <span class="fa fa-area-chart"></span><span class="mtext">Party Wise Reports</span>--}}
                {{--                            </a>--}}
                {{--                            <ul class="submenu child">--}}
                {{--                                <li><a href="{{route("account_receivable_payable_list")}}">Party Ledgers</a></li>--}}
                {{--                            </ul>--}}
                {{--                        </li>--}}

                {{--                        <li class="dropdown">--}}
                {{--                            <a class="dropdown-toggle">--}}
                {{--                                <span class="fa fa-area-chart"></span><span class="mtext">Sale Reports</span>--}}
                {{--                            </a>--}}
                {{--                            <ul class="submenu child">--}}
                {{--                                <li><a href="{{route("sale_invoice_list")}}">Sale Invoice</a></li>--}}
                {{--                                <li><a href="{{route("sale_return_invoice_list")}}">Sale Return Invoices</a></li>--}}
                {{--                                <li><a href="{{route("income_tax_sale_invoice_list")}}">Income Tax Invoices</a></li>--}}
                {{--                                <li><a href="{{route("sale_tax_sale_invoice_list")}}">Sale Tax Invoices</a></li>--}}
                {{--                                <li><a href="{{route("service_tax_sale_invoice_list")}}">Service Tax Invoices</a></li>--}}
                {{--                            </ul>--}}
                {{--                        </li>--}}

                {{--                    </ul>--}}
                {{--                </li>--}}


            </ul>
        </div>
    </div>
</div>
