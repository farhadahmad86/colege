<div class="left-side-bar">
    <div class="brand-logo">
        <a href="index">
            <img src="public/vendors/images/my_logo.png" alt="">

        </a>
    </div>
    <div class="menu-block customscroll">
        <div class="sidebar-menu">
            <ul id="accordion-menu">
                <li>
                    <a href="index" class="dropdown-toggle no-arrow">
                        <span class="fa fa-home"></span><span class="mtext">Home</span>
                    </a>
                </li>


                <li class="dropdown">
                    <a href="#" class="dropdown-toggle">
                        <span class="fa fa-user-circle-o"></span><span class="mtext">General</span>
                    </a>
                    <ul class="submenu">

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle">
                                <span class="fa fa-area-chart"></span><span class="mtext">Region</span>
                            </a>
                            <ul class="submenu child">
                                <li><a href="add_region">Add Region </a></li>
                                <li><a href="region_list">Region List</a></li>
                            </ul>
                        </li>
                        {{--tool tip--}}
                        {{--<span style="float: right" class="fa fa-info-circle" data-toggle="tooltip" data-placement="bottom" title="Hoorayasdasdfasdasdas asdaxdasdas ad asd asd!"></span>--}}

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle">
                                <span class="fa fa-pie-chart"></span><span class="mtext">Area</span>
                            </a>
                            <ul class="submenu child">
                                <li><a href="add_area">Add Area</a></li>
                                <li><a href="area_list">Area List</a></li>
                            </ul>
                        </li>


                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle">
                                <span class="fa fa-industry"></span><span class="mtext">Sector</span>
                            </a>
                            <ul class="submenu child">
                                <li><a href="add_sector">Add Sector</a></li>
                                <li><a href="sector_list">Sector List</a></li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle">
                                <span class="fa fa-group"></span><span class="mtext">User Group</span>
                            </a>
                            <ul class="submenu child">
                                <li><a href="add_user_group">Add Group</a></li>
                                <li><a href="user_group_list">Group List</a></li>
                            </ul>
                        </li>



                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle">
                                <span class="fa fa-user"></span><span class="mtext">Register Account</span>
                            </a>
                            <ul class="submenu child">
                                <li><a href="account_registration">Chart of Accounts</a></li>
                                <li><a href="receivables_account_registration">Receivables Account</a></li>
                                <li><a href="payables_account_registration">Payables Account</a></li>
                            </ul>
                        </li>

                        {{--<li><a href="account_registration">Register Account</a></li>--}}
                        <li><a href="account_list">Account Reports</a></li>
                        <li><a href="account_receivable_payable_list">Ledger Reports</a></li>
                        <li><a href="default_account_list">Default Account List</a></li>

                    </ul>
                </li>


                <li class="dropdown">
                    <a href="#" class="dropdown-toggle">
                        <span class="fa fa-product-hunt"></span><span class="mtext">Products</span>
                    </a>
                    <ul class="submenu">

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle">
                                <span class="fa fa-group"></span><span class="mtext">Group</span>
                            </a>
                            <ul class="submenu child">
                                <li><a href="add_group">Add Group</a></li>
                                <li><a href="group_list">Group List</a></li>
                            </ul>
                        </li>


                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle">
                                <span class="fa fa-tags"></span><span class="mtext">Category</span>
                            </a>
                            <ul class="submenu child">
                                <li><a href="add_category">Add Category</a></li>
                                <li><a href="category_list">Category List</a></li>
                            </ul>
                        </li>


                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle">
                                <span class="fa fa-balance-scale"></span><span class="mtext">Unit</span>
                            </a>
                            <ul class="submenu child">
                                <li><a href="add_main_unit">Add Main Unit</a></li>
                                <li><a href="main_unit_list">Main Unit List</a></li>
                                <li><a href="add_unit">Add Unit</a></li>
                                <li><a href="unit_list">Unit List</a></li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle">
                                <span class="fa fa-shopping-bag"></span><span class="mtext">Product</span>
                            </a>
                            <ul class="submenu child">
                                <li><a href="add_product">Add </a></li>
                                <li><a href="product_list"> List</a></li>
                                <li><a href="product_loss"> Loss</a></li>
                                <li><a href="product_loss_list"> Lost List</a></li>
                                <li><a href="product_recover"> Recover</a></li>
                                <li><a href="product_recover_list"> Recover List</a></li>
                            </ul>
                        </li>

                    </ul>
                </li>


                <li class="dropdown">
                    <a href="#" class="dropdown-toggle">
                        <span class="fa fa-clone"></span><span class="mtext">Purchase Invoice</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="purchase_invoice">Add Invoice</a></li>
                        <li><a href="purchase_invoice_on_net">Add On-Cash Invoice</a></li>
                        <li><a href="purchase_invoice_list"> Invoice List</a></li>
                        <li><a href="purchase_return_full_invoice"> Return Full Invoice</a></li>
                        <li><a href="purchase_return_partial_invoice"> Return Partial Invoice</a></li>
                        <li><a href="purchase_return_without_invoice"> Return Without Invoice</a></li>
                        <li><a href="purchase_return_invoice_list"> Return Invoice List</a></li>

                    </ul>
                </li>

                 <li class="dropdown">
                    <a href="#" class="dropdown-toggle">
                        <span class="fa fa-clone"></span><span class="mtext">Sale Invoice</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="sale_invoice">Add Invoice</a></li>
                        <li><a href="sale_invoice_on_net">Add On-Cash Invoice</a></li>
                        <li><a href="sale_invoice_list"> Invoice List</a></li>
                        <li><a href="sale_return_full_invoice"> Return Full Invoice</a></li>
                        <li><a href="sale_return_partial_invoice"> Return Partial Invoice</a></li>
                        <li><a href="sale_return_without_invoice"> Return Without Invoice</a></li>
                        <li><a href="sale_return_invoice_list"> Return Invoice List</a></li>

                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle">
                        <span class="fa fa-files-o"></span><span class="mtext">Voucher</span>
                    </a>
                    <ul class="submenu">

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle">
                                <span class="fa fa-file"></span><span class="mtext">Journal Voucher</span>
                            </a>
                            <ul class="submenu child">
                                <li><a href="journal_voucher">Add Voucher</a></li>
                                <li><a href="journal_voucher_bank">Bank Journal Voucher</a></li>
                                <li><a href="journal_voucher_list">Voucher List</a></li>
                            </ul>
                        </li>


                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle">
                                <span class="fa fa-file"></span><span class="mtext">Cash Receipt Voucher</span>
                            </a>
                            <ul class="submenu child">
                                <li><a href="cash_receipt_voucher">Add Voucher</a></li>
                                <li><a href="cash_receipt_voucher_list">Voucher List</a></li>
                            </ul>
                        </li>


                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle">
                                <span class="fa fa-file"></span><span class="mtext">Cash Payment Voucher</span>
                            </a>
                            <ul class="submenu child">
                                <li><a href="cash_payment_voucher">Add Voucher</a></li>
                                <li><a href="cash_payment_voucher_list">Voucher List</a></li>
                            </ul>
                        </li>


                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle">
                                <span class="fa fa-file"></span><span class="mtext">Bank Receipt Voucher</span>
                            </a>
                            <ul class="submenu child">
                                <li><a href="bank_receipt_voucher">Add Voucher</a></li>
                                <li><a href="bank_receipt_voucher_list">Voucher List</a></li>
                            </ul>
                        </li>


                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle">
                                <span class="fa fa-file"></span><span class="mtext">Bank Payment Voucher</span>
                            </a>
                            <ul class="submenu child">
                                <li><a href="bank_payment_voucher">Add Voucher</a></li>
                                <li><a href="bank_payment_voucher_list">Voucher List</a></li>
                            </ul>
                        </li>

                    </ul>
                </li>


                <li class="dropdown">
                    <a href="#" class="dropdown-toggle">
                        <span class="fa fa-bar-chart"></span><span class="mtext">Chart of Accounts</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="chart_of_account">Chart of Accounts View</a></li>
                    </ul>
                </li>


                <li class="dropdown">
                    <a href="#" class="dropdown-toggle">
                        <span class="fa fa-user"></span><span class="mtext">Employees</span>
                    </a>
                <ul class="submenu">

                    <li><a href="add_employee">Add Employee</a></li>
                    <li><a href="employee_list">Employee List</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle">
                        <span class="fa fa-power-off"></span><span class="mtext">Day End</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="close_day_end">Run Day End</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle">
                        <span class="fa fa-file"></span><span class="mtext">System Reports</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="trial_balance">Trial Balance</a></li>
                        <li><a href="income_statement">Income Statement</a></li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle">
                                <span class="fa fa-file"></span><span class="mtext">General Reports</span>
                            </a>
                            <ul class="submenu child">
                                <li><a href="region_list">Region Report</a></li>
                                <li><a href="area_list">Area Report</a></li>
                                <li><a href="sector_list">Sector Report</a></li>
                                <li><a href="account_receivable_payable_list">Parties Info Report</a></li>
                                <li><a href="product_list">Product Info Report</a></li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle">
                                <span class="fa fa-file"></span><span class="mtext">Party Wise Report</span>
                            </a>
                            <ul class="submenu child">
                                <li><a href="account_receivable_payable_list">Parties Detail Ledger Report</a></li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle">
                                <span class="fa fa-file"></span><span class="mtext">Purchase Sale Report</span>
                            </a>
                            <ul class="submenu child">
                                <li><a href="purchase_invoice_list">Invoice Wise Purchase Summary Report</a></li>
                                <li><a href="sale_invoice_list">Invoice Wise Sale Summary Report</a></li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle">
                                <span class="fa fa-file"></span><span class="mtext">Product Wise Report</span>
                            </a>
                            <ul class="submenu child">
                                <li><a href="product_list">Product Wise Stock Report</a></li>
                                <li><a href="product_wise_report">Product Purchases & Sales Report</a></li>
                                <li><a href="product_wise_return_report">Product Purchases & Sales Return Report</a></li>
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