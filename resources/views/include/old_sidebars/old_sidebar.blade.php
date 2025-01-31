<div class="left-side-bar">
    <div class="brand-logo">
        <a href={{route("index" )}}>
            <img src={{asset("public/vendors/images/my_logo.png")}} alt="">

        </a>
    </div>
    <div class="menu-block customscroll">
        <div class="sidebar-menu">
            <ul id="accordion-menu">
                <li>
                    <a href="{{route("index")}}" class="dropdown-toggle no-arrow">
                        <span class="fa fa-home"></span><span class="mtext">Home</span>
                    </a>
                </li>


                <li class="dropdown">
                    <a href="#" class="dropdown-toggle">
                        <span class="fa fa-user-circle-o"></span><span class="mtext">General</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="{{route("account_registration")}}">Chart of Accounts</a></li>
                        <li><a href="{{route("add_account_group")}}">Add Account Group</a></li>
                        <li><a href="{{route("add_region")}}">Add Region </a></li>
                        <li><a href="{{route("add_area")}}">Add Area</a></li>
                        <li><a href="{{route("add_sector")}}">Add Sector</a></li>
                        <li><a href="{{route("receivables_account_registration")}}">Receivables Account</a></li>
                        <li><a href="{{route("payables_account_registration")}}">Payables Account</a></li>
                        <li><a href="{{route("account_list")}}">Account Reports</a></li>
                        <li><a href="{{route("account_receivable_payable_list")}}">Ledger Reports</a></li>
                        <li><a href="{{route("chart_of_account")}}">Chart of Accounts Tree View</a></li>
                        <li><a href="{{route("default_account_list")}}">Default Account List</a></li>
                        <li><a href="{{route("cash_transfer")}}">Cash Transfer</a></li>
                        <li><a href="{{route("pending_cash_receive_list")}}">Cash Receive</a></li>
                    </ul>
                </li>


                <li class="dropdown">
                    <a href="#" class="dropdown-toggle">
                        <span class="fa fa-product-hunt"></span><span class="mtext">Products</span>
                    </a>
                    <ul class="submenu">
                                <li><a href="{{route("add_group")}}">Add Group</a></li>
                                <li><a href="{{route("add_category")}}">Add Category</a></li>
                                <li><a href="{{route("add_main_unit")}}">Add Main Unit</a></li>
                                <li><a href="{{route("add_unit")}}">Add Unit</a></li>
                                <li><a href="{{route("add_warehouse")}}">Add Warehouse</a></li>
                                <li><a href="{{route("add_product")}}">Add Product</a></li>
                                <li><a href="{{route("add_services")}}">Add Services</a></li>
                                <li><a href="{{route("add_transfer_product_stock")}}">Transfer Product Stock</a></li>
                                <li><a href="{{route("product_loss")}}">Loss Product</a></li>
                                <li><a href="{{route("product_recover")}}">Recover Product</a></li>
                    </ul>
                </li>


                <li class="dropdown">
                    <a href="#" class="dropdown-toggle">
                        <span class="fa fa-clone"></span><span class="mtext">Purchase Invoice</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="{{route("purchase_invoice")}}">New Invoice</a></li>
                        <li><a href="{{route("purchase_invoice_on_net")}}">Cash Invoice</a></li>
                        <li><a href="{{route("purchase_return_full_invoice")}}"> Return Full Invoice</a></li>
                        <li><a href="{{route("purchase_return_partial_invoice")}}"> Return Partial Invoice</a></li>
                        <li><a href="{{route("purchase_return_without_invoice")}}"> Return Without Invoice</a></li>
"
                    </ul>
                </li>


                <li class="dropdown">
                    <a href="#" class="dropdown-toggle">
                        <span class="fa fa-clone"></span><span class="mtext">Tax Invoice ( Purchase )</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="{{route("income_tax_purchase_invoice")}}">Income Tax Invoice</a></li>
                        <li><a href="{{route("sale_tax_purchase_invoice")}}">Sale Tax Invoice</a></li>
{{--                        <li><a href="{{route("service_tax_purchase_invoice")}}">Service Tax Invoice</a></li>--}}
                    </ul>
                </li>


                <li class="dropdown">
                    <a href="#" class="dropdown-toggle">
                        <span class="fa fa-clone"></span><span class="mtext">Tax Invoice ( Sale )</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="{{route("income_tax_sale_invoice")}}">Income Tax Invoice</a></li>
                        <li><a href="{{route("sale_tax_sale_invoice")}}">Sale Tax Invoice</a></li>
                        <li><a href="{{route("service_tax_invoice")}}">Service Tax Invoice</a></li>

                    </ul>
                </li>

                 <li class="dropdown">
                    <a href="#" class="dropdown-toggle">
                        <span class="fa fa-clone"></span><span class="mtext">Sale Invoice</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="{{route("sale_invoice")}}">New Invoice</a></li>
                        <li><a href="{{route("sale_invoice_on_net")}}">Cash Invoice</a></li>
                        <li><a href="{{route("services_invoice")}}">Services Invoice</a></li>
                        <li><a href="{{route("services_invoice_on_cash")}}">Cash Services Invoice</a></li>
                        <li><a href="{{route("sale_return_full_invoice")}}"> Return Full Invoice</a></li>
                        <li><a href="{{route("sale_return_partial_invoice")}}"> Return Partial Invoice</a></li>
                        <li><a href="{{route("sale_return_without_invoice")}}"> Return Without Invoice</a></li>

                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle">
                        <span class="fa fa-files-o"></span><span class="mtext">Voucher</span>
                    </a>
                    <ul class="submenu">
                                <li><a href="{{route("journal_voucher")}}">Journal Voucher</a></li>
                                <li><a href="{{route("journal_voucher_bank")}}">Bank Journal Voucher</a></li>
                                <li><a href="{{route("expense_payment_voucher")}}">Expense Payment Voucher</a></li>
                                <li><a href="{{route("salary_slip_voucher")}}">Generate Salary Slip</a></li>
                                <li><a href="{{route("salary_payment_voucher")}}">Salary Payment Voucher</a></li>
                                <li><a href="{{route("cash_receipt_voucher")}}">Cash Receipt Voucher</a></li>
                                <li><a href="{{route("cash_payment_voucher")}}">Cash Payment Voucher</a></li>
                                <li><a href="{{route("bank_receipt_voucher")}}">Bank Receipt Voucher</a></li>
                                <li><a href="{{route("bank_payment_voucher")}}">Bank Payment Voucher</a></li>
{{--                                <li><a href="{{route("service_tax_invoice")}}">Service Tax Invoice</a></li>--}}

                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle">
                        <span class="fa fa-user"></span><span class="mtext">Employees</span>
                    </a>
                <ul class="submenu">
                    <li><a href="{{route("add_employee")}}">Add Employee</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle">
                        <span class="fa fa-power-off"></span><span class="mtext">Day End</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="{{route("close_day_end")}}">Run Day End</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle">
                        <span class="fa fa-file"></span><span class="mtext">System Reports</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="{{route("trial_balance")}}">Trial Balance</a></li>
                        <li><a href="{{route("income_statement")}}">Income Statement</a></li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle">
                                <span class="fa fa-file"></span><span class="mtext">General Reports</span>
                            </a>
                            <ul class="submenu child">
                                <li><a href="{{route("region_list")}}">Region Report</a></li>
                                <li><a href="{{route("area_list")}}">Area Report</a></li>
                                <li><a href="{{route("sector_list")}}">Sector Report</a></li>
                                <li><a href="{{route("account_receivable_payable_list")}}">Parties Info Report</a></li>
                                <li><a href="{{route("group_list")}}">Group List</a></li>
                                <li><a href="{{route("category_list")}}">Category List</a></li>
                                <li><a href="{{route("main_unit_list")}}">Main Unit List</a></li>
                                <li><a href="{{route("unit_list")}}">Unit List</a></li>
                                <li><a href="{{route("product_list")}}">Product Info Report</a></li>
                                <li><a href="{{route("product_loss_list")}}">Product Lost List</a></li>
                                <li><a href="{{route("product_recover_list")}}">Product Recover List</a></li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle">
                                <span class="fa fa-file"></span><span class="mtext">Party Wise Report</span>
                            </a>
                            <ul class="submenu child">
                                <li><a href="{{route("account_receivable_payable_list")}}">Parties Detail Ledger Report</a></li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle">
                                <span class="fa fa-file"></span><span class="mtext">Purchase Sale Report</span>
                            </a>
                            <ul class="submenu child">
                                <li><a href="{{route("purchase_invoice_list")}}">Invoice Wise Purchase Summary Report</a></li>
                                <li><a href="{{route("sale_invoice_list")}}">Invoice Wise Sale Summary Report</a></li>
                                <li><a href="{{route("purchase_return_invoice_list")}}">Purchase Return Invoice List</a></li>
                                <li><a href="{{route("sale_return_invoice_list")}}">Sale Return Invoice List</a></li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle">
                                <span class="fa fa-file"></span><span class="mtext">Product Wise Report</span>
                            </a>
                            <ul class="submenu child">
                                <li><a href="{{route("product_list")}}">Product Wise Stock Report</a></li>
                                <li><a href="{{route("product_wise_report")}}">Product Purchases & Sales Report</a></li>
                                <li><a href="{{route("product_wise_return_report")}}">Product Purchases & Sales Return Report</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle">
                        <span class="fa fa-wrench"></span><span class="mtext">Utilities</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="#">Global Configuration</a></li>
                        <li><a href="#">BackUp Management</a></li>
                        <li><a href="#">Daily Date Closing</a></li>
                        <li><a href="{{route("change_password")}}">Change Password</a></li>
                    </ul>
                </li>


                {{--<li class="dropdown">--}}
                    {{--<a href="javascript:;" class="dropdown-toggle">--}}
                        {{--<span class="fa fa-list"></span><span class="mtext">Multi Level Menu</span>--}}
                    {{--</a>--}}
                    {{--<ul class="submenu">--}}
                        {{--<li><a href="javascript:;">Level 1</a></li>--}}
                        {{--<li><a href="javascript:;">Level 1</a></li>--}}
                        {{--<li><a href="javascript:;">Level 1</a></li>--}}
                        {{--<li class="dropdown">--}}
                            {{--<a href="javascript:;" class="dropdown-toggle">--}}
                                {{--<span class="fa fa-plug"></span><span class="mtext">Level 2</span>--}}
                            {{--</a>--}}
                            {{--<ul class="submenu child">--}}
                                {{--<li><a href="javascript:;">Level 2</a></li>--}}
                                {{--<li><a href="javascript:;">Level 2</a></li>--}}
                            {{--</ul>--}}
                        {{--</li>--}}
                        {{--<li><a href="javascript:;">Level 1</a></li>--}}
                        {{--<li><a href="javascript:;">Level 1</a></li>--}}
                        {{--<li><a href="javascript:;">Level 1</a></li>--}}
                    {{--</ul>--}}
                {{--</li>--}}
            </ul>
        </div>
    </div>
</div>

{{--<script>--}}

    {{--$( document ).ready(function() {--}}

        {{--var url = window.location;--}}

{{--// for sidebar menu entirely but not cover treeview--}}
        {{--$('ul.accordion-menu a').filter(function() {--}}
            {{--return this.href == url;--}}
        {{--}).parent().addClass('active');--}}

{{--// for treeview--}}
        {{--$('ul.accordion-menu a').filter(function() {--}}
            {{--return this.href == url;--}}
        {{--}).parentsUntil(".sidebar-menu > .accordion-menu").addClass('active');--}}
    {{--});--}}

{{--</script>--}}