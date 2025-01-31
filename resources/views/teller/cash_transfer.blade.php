<!DOCTYPE html>
<html>
<head>

    @include('include/head')

</head>
<body>
@include('include/header')
@include('include/teller_sidebar')
<div class="main-container">
    <div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
        @include('inc._messages')

        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <!-- <div class="title">
                        <h4>Account Registration</h4>
                    </div> -->
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Cash Transfer</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">

            <div class="clearfix">
                <div class="pull-left">
                    <h4 class="text-blue get-heading-text">Cash Transfer</h4>
                </div>
                <a class="btn btn-primary add_more_button" href="{{route("teller/reject_cash_transfer_list")}}" role="button" target="_blank" data-toggle="tooltip" data-placement="bottom" title="Reject Cash Transfer List"><li class="fa fa-ban"></li></a>
                <a class="btn btn-primary add_more_button" href="{{route("teller/approve_cash_transfer_list")}}" role="button" target="_blank" data-toggle="tooltip" data-placement="bottom" title="Approve Cash Transfer List"><li class="fa fa-check"></li></a>
                <a class="btn btn-primary add_more_button" href="{{route("teller/pending_cash_transfer_list")}}" role="button" target="_blank" data-toggle="tooltip" data-placement="bottom" title="Pending Cash Transfer List"><li class="fa fa-clock-o"></li></a>
            </div>

            <form name="f1" class="f1" id="f1" action="submit_cash_transfer" onsubmit="return form_validation()" method="post">
                @csrf
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <label class="required">Cash Transfer To</label>
                            <span id="demo1" class="validate_sign"> </span>
                            <select name="cash_transfer_to" class="form-control" id="cash_transfer_to" autofocus style="width: 100%">
                                <option value="">Cash Transfer To</option>

                                @foreach($tellers as $teller)
                                    <option value="{{$teller->user_id}}">{{$teller->user_name}}</option>
                                @endforeach

                            </select>

                        </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <label class="required">Amount</label>
                                <span id="demo2" class="validate_sign"> </span>
                                <input type="text" name="amount" id="amount" class="form-control"
                                       placeholder="Amount" autocomplete="off" onkeypress="return isNumber(event)"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <label class="">Remarks</label>
                                <span id="demo3" class="validate_sign"> </span>
                                <textarea name="remarks" id="remarks" class="remarks form-control"></textarea>
                            </div>

                        </div>

                        <div class="form-group row">
                            <div class="col-lg-1 col-md-1"></div>
                            <div class="col-lg-2 col-md-2 col-sm-2">
                                <button type="reset" name="cancel" id="cancel" class="cancel_button form-control">
                                    Cancel
                                </button>
                            </div>
                            <div class="col-lg-6 col-md-6"></div>
                            <div class="col-lg-2 col-md-2 col-sm-2">
                                <button type="submit" name="save" id="save" class="save_button form-control">Save
                                </button>
                            </div>
                        </div>

                    </div> <!-- left column ends here -->
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        {{--<div class="show_info_div">--}}

                        {{--</div>--}}

                    </div> <!-- right columns ends here -->

                </div> <!--  main row ends here -->


            </form>
        </div> <!-- white column form ends here -->

        @include('include/footer')
    </div>
</div>
@include('include/script')


<script>
    jQuery(document).ready(function () {
        // Initialize select2
        jQuery("#cash_transfer_to").select2();
    });
</script>

<script type="text/javascript">

    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    function form_validation()
    {
        var cash_transfer_to  = document.getElementById("cash_transfer_to").value;
        var amount  = document.getElementById("amount").value;

        var flag_submit = true;
        var focus_once = 0;

        if(cash_transfer_to.trim() == "")
        {
            document.getElementById("demo1").innerHTML = "Required";
            if (focus_once == 0) { jQuery("#cash_transfer_to").focus(); focus_once = 1;}
            flag_submit = false;
        }else{
            document.getElementById("demo1").innerHTML = "";
        }

        if(amount.trim() == "")
        {
            document.getElementById("demo2").innerHTML = "Required";
            if (focus_once == 0) { jQuery("#amount").focus(); focus_once = 1;}
            flag_submit = false;
        }else{
            document.getElementById("demo2").innerHTML = "";
        }
        return flag_submit;
    }

</script>
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
</body>
</html>
