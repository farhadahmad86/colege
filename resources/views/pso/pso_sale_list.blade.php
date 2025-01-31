<!DOCTYPE html>
<html>
<head>

    @include('include/head')

</head>
<body>

@include('include/header')

@include('include.sidebar_shahzaib')

{{--<script src="https://code.jquery.com/jquery-3.3.1.js"></script>--}}


{{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">--}}
{{--<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">--}}

<script type="text/javascript">

    function validate_form() {
        var search = document.getElementById("search").value;

        var flag_submit = true;

        if (search.trim() == "") {
            document.getElementById("demo1").innerHTML = "Required";
            jQuery("#search").focus();
            flag_submit = false;
        } else {
            document.getElementById("demo1").innerHTML = "";
        }

        return flag_submit;
    }
</script>


<div class="main-container">
    <div class="pd-ltr-20 customscroll-10-p height-100-p xs-pd-20-10">
        @include('inc._messages')

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9 col-xl-9">

                <div class="page-header">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <!-- <div class="title">
                                <h4>Account Registration</h4>
                            </div> -->
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Sale List</li>
                                </ol>
                            </nav>
                        </div>
                    </div>

                </div>

                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">

                    <div class="form_header"><!-- form header start -->
                        <div class="clearfix">
                            <div class="pull-left">
                                <h4 class="text-white file_name">Sale List</h4>
                            </div>
                        </div>
                    </div><!-- form header close -->

                    <div class="search_form">
                        <div class="row">

                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">

                                <div class="form-group">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="required">
                                            Search
                                        </label>
                                        <select class="inputs_up form-control" id="srch_slct">
                                            <option value="all_data">All Data</option>
                                            <option value="full_search" selected>Full Search</option>
                                        </select>
                                    </div>
                                </div>

                            </div>


                            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">


                                <div id="full_search" class="frm_hide show_active">
                                    <form action="pso_sale_list" name="form1" id="form1" method="post" onsubmit="return validate_form()">
                                        <div class="row">
                                            @csrf

                                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <div class="row">
                                                        <div class="form-group col-lg-9 col-md-9 col-sm-12">
                                                            <div class="input-group">
                                                                <input type="search" list="browsers" class="inputs_up form-control" name="search" id="search" placeholder="Search ..."
                                                                       value="{{ isset($search) ? $search : '' }}" autocomplete="off" required>

                                                                <datalist id="browsers">
                                                                    @foreach($employee_names as $value)
                                                                        <option value="{{$value}}">
                                                                    @endforeach
                                                                </datalist>
                                                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-3 col-sm-12">
                                                            <button class="save_button form-control" name="go" id="go">Go!</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> <!-- left column ends here -->
                                        </div>
                                    </form>
                                </div>

                                <div id="all_data" class="frm_hide">
                                    <form action="pso_sale_list" name="form" id="form" method="post">
                                        @csrf

                                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                <button type="submit" name="save" id="save" class="save_button form-control m-0" style=" width: 120px !important;">
                                                    <i class="fa fa-search"></i> All
                                                </button>
                                            </div>
                                        </div> <!-- right columns ends here -->
                                    </form>
                                </div>

                            </div>

                        </div>
                    </div>

                    @include('include/print_button')

                    <div class="table-responsive" id="printTable">
                        <table class="table table-bordered table-sm" id="fixTable">
                            <thead>
                            <tr>
                                <th scope="col" align="center">Sr#</th>
                                <th scope="col" align="center">Date/Time</th>
                                <th scope="col" align="center">Emp Name</th>
                                <th scope="col" align="center">Cash Amount</th>
                                <th scope="col" align="center">Credit Amount</th>
                                <th scope="col" align="center">Card Amount</th>
                                <th scope="col" align="center">Total Amount</th>
                                <th scope="col" align="center">Remarks</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $sr=1;
                            @endphp
                            @forelse($sales as $sale)

                                <tr>
                                    <td class="align_left edit">{{$sr}}</td>
                                    <td class="align_left edit">{{$sale->ps_datetime}}</td>
                                    <td class="align_left edit">{{$sale->user_name}}</td>
                                    <td class="align_left edit">{{$sale->ps_cash_amount}}</td>
                                    <td class="align_left edit">{{$sale->ps_credit_amount}}</td>
                                    <td class="align_left edit">{{$sale->ps_card_amount}}</td>
                                    <td class="align_left edit">{{$sale->ps_total_amount}}</td>
                                    <td class="align_left edit">{{$sale->ps_remarks}}</td>
                                </tr>
                                @php
                                    $sr++;
                                @endphp
                            @empty
                                <tr>
                                    <td colspan="11">
                                        <center><h3 style="color:#554F4F">No Entry</h3></center>
                                    </td>
                                </tr>.
                            @endforelse
                            </tbody>
                        </table>

                    </div>
                    <span class="hide_column">{{ $sales ->links() }}</span>
                </div> <!-- white column form ends here -->


            </div><!-- col end -->
        </div><!-- row end -->


        @include('include/footer')


    </div>
</div>

@include('include/script')

</body>
</html>
