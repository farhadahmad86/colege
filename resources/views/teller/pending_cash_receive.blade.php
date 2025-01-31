<!DOCTYPE html>
<html>
<head>
    @include('include/head')
</head>
<body>
@include('include/header')
@include('include/teller_sidebar')

<script type="text/javascript">

    function validate_form()
    {
        var search  = document.getElementById("search").value;

        var flag_submit = true;

        if(search.trim() == "")
        {
            document.getElementById("demo1").innerHTML = "Required";
            jQuery("#search").focus();
            flag_submit = false;
        }else{
            document.getElementById("demo1").innerHTML = "";
        }

        return flag_submit;
    }
</script>



<div class="main-container">
    <div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
        @include('inc._messages')


        <form action="pending_cash_receive_list" name="form1" id="form1" method="post" onsubmit="return validate_form()">
            <div class="row">
            @csrf

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group row">
                        <div class="col-md-8 col-lg-8">
                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                            <div class="input-group">
                                <input type="search" class="form-control" name="search" id="search"
                                       placeholder="Search ..." value="{{ isset($search) ? $search : '' }}" autocomplete="off" required>
                                <span class="input-group-btn">
                            <button class="btn btn-default" name="go" id="go">Go!</button>
                        </span>
                            </div>
                        </div>


                    </div>

                </div> <!-- left column ends here -->

            {{--</div>--}}

        </form>

        <form action="pending_cash_receive_list" name="form" id="form" method="post">
            @csrf
            {{--<div class="row">--}}

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="form-group row">
                    <div class="col-md-12 col-lg-12">
                        <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                        <div class="input-group">
                            <button type="submit" name="save" id="save" class="save_button form-control" style=" width: 120px !important;">All</button>
                        </div>
                    </div>

                </div>
            </div> <!-- right columns ends here -->

    </form>
    </div>


        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <!-- <div class="title">
                        <h4>Account Registration</h4>
                    </div> -->
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Pending Cash Receive</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">

            <div class="clearfix">
                <div class="pull-left">
                    <h4 class="text-blue get-heading-text">Pending Cash Receive</h4>
                </div>

            </div>

            <form name="approve_form" id="approve_form" action="{{route("teller/approve_cash_receive")}}" method="post">
                @csrf
                <input name="approve" id="approve" type="hidden">
            </form>


            <div class="table-responsive" id="parent">
                <table class="table table-bordered fixed_header" id="fixTable">
                    <thead>
                    <tr>
                        <th scope="col" style="width:80px; text-align: center !important" align="center" data-sortable="true" data-field="name">Send To</th>
                        <th scope="col" style="width:50px; text-align: center !important" align="center">Amount</th>
                        <th scope="col" style="width:50px; text-align: center !important" align="center">Remarks</th>
                        <th scope="col" style="width:80px; text-align: center !important" align="center">Status</th>
                        <th scope="col" style="width:80px; text-align: center !important" align="center">Date/Time</th>
                        <th scope="col" style="width:80px; text-align: center !important" align="center">Action</th>
                        {{--<th scope="col" style="width:80px; text-align: center !important" align="center">Reject</th>--}}
                    </tr>
                    </thead>


                    <tbody>
                    @php
                        $sr=1;
                    @endphp
                    @forelse($cash_receives as $cash_receive)

                        <tr>
                            <td class="align_center">{{$cash_receive->user_name}}</td>
                            <td class="align_right">{{$cash_receive->ct_amount}}</td>
                            <td class="align_center">{{$cash_receive->ct_remarks}}</td>
                            <td class="align_center">{{$cash_receive->ct_status}}</td>
                            <td class="align_center">{{date('d/m/Y g:i A', strtotime($cash_receive->ct_send_datetime))}}</td>
                            <td class="align_center"><li class="fa fa-check approve" style="padding: 0 6px; cursor: pointer" data-id="{{$cash_receive->ct_id}}"></li>|
                                <li class="fa fa-ban reject" style="padding: 0 6px;cursor: pointer" data-id="{{$cash_receive->ct_id}}" data-toggle="modal" data-target="#exampleModal"></li></td>
                            {{--<td class="align_center"><li class="fa fa-ban"></li></td>--}}
                        </tr>
                        @php
                            $sr++;
                        @endphp
                    @empty
                        <tr>
                            <td colspan="11">
                                <center><h3 style="color:#554F4F">No Entry</h3></center>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

            </div>
            {{ $cash_receives ->links() }}
        </div> <!-- white column form ends here -->

        @include('include/footer')
    </div>
</div>


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Reject Transaction</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route("teller/reject_cash_receive")}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Reason:</label>
                        <textarea class="form-control" id="reason" name="reason" required></textarea>

                        <input type="hidden" name="reject" id="reject">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Send message</button>
                </div>
            </form>
        </div>
    </div>
</div>

@include('include/script')
<script>
    jQuery(".approve").click(function () {

        var approve = jQuery(this).attr("data-id");

        jQuery("#approve").val(approve);
        jQuery("#approve_form").submit();
    });


    jQuery(".reject").click(function () {
        var reject = jQuery(this).attr("data-id");
        jQuery("#reject").val(reject);
    });
</script>


</body>
</html>