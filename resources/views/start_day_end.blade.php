
@extends('extend_index')

@section('styles_get')
{{--    <link rel="stylesheet" type="text/css" href="{{ asset('public/_api/dayend/src/css/day_end.css') }}" />--}}
@stop

@section('content')

    <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">
                    <div class="form_header"><!-- form header start -->
                        <div class="clearfix">
                            <div class="pull-left">
                                <h4 class="text-white get-heading-text">Start Day End (Description)</h4>
                            </div>
                            <div class="list_btn list_mul">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm dropdown-toggle grp_btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-wrench"></i> Settings
                                    </button>

                                    <div class="dropdown-menu dropdown-menu-right print_act_drp hide_column" x-placement="bottom-end">
                                        <button type="button" class="dropdown-item" id="lck_un_lck">
                                            {!! ( (isset($dynd_status) && !empty($dynd_status) && $dynd_status === 'UN_LOCKED' ) ? '<i class="fa fa-unlock"></i> '.ucwords(strtolower(str_replace('_', '', $dynd_status))) : '<i class="fa fa-lock"></i> '.ucwords(strtolower(str_replace('_', '', $dynd_status))) ) !!} Day End
                                        </button>
                                    </div>
                                </div>
                            </div><!-- list btn -->
                        </div>
                    </div><!-- form header close -->


                    <div class="row">
                        <div class="col-md-12">
                            <div class="tile">
                                @php
                                    use Illuminate\Support\Facades\Auth;
                                    $user_id =Auth::user()->user_id;
                                @endphp

                                <p class="m-0">
                                    Executing day end is a one-way transaction which means you will not be able to get back to a previous date once the date is processed after executing the day end.
                                </p>
                                <p class="m-0">
                                    Please make sure you have no pending task on the current date and if there are any, do perform them before the execution of a day end.
                                </p>
                                <p class="m-0">
                                    On the execution of a day end, your current date is marked as locked and system moves ahead to the next date.
                                </p>
                                <br />

                                <div>
                                    <p class="m-0" style='text-align: justify'>
                                        <span style='color: green;'>
                                            <strong>Recommendation: </strong>
                                        </span>
                                        <br />
                                        View report without execution before Executing the Day End.
                                        <br />
                                        <button class="btn btn-warning mr-2 mb-2 view_rprt text-white">
                                            View Report without Execution
                                        </button>
                                    </p>
                                </div>

                                <br />
                                <br />

                                <fieldset class="dyend_fldst">
                                    <legend>
                                        Danger Zone
                                    </legend>
                                    <p class="m-0" style='color: red;'>
                                        Do make sure your day end is unlocked before trying to execute it. This is a security restriction deliberately placed to ensure no accidental execution of day end is committed.
                                    </p>
                                    <p class="m-0">
                                        If you are willing to Execute the day end process please check this box for confirmation
                                    </p>
                                    <p class="m-0">
                                        <label for="cb">
                                            <input id='cb' type='checkbox' name="cb">&nbsp;&nbsp;
                                            Accept/Confirm to Execution
                                        </label>
                                    </p>

                                    <p class="mt-2 mb-2">

                                        <button type="button" class="btn btn-danger mr-2 mb-2 view dyend_view  disabled" disabled="disabled">
                                            {!! ( (isset($dynd_status) && !empty($dynd_status) && $dynd_status === 'UN_LOCKED' ) ? '<i class="fa fa-lock"></i>' : '<i class="fa fa-unlock"></i>' ) !!} Execute Day End
                                        </button>
    {{--                                    <a href="{{config('global_variables.execute_day_end').$user_id}}" class="btn btn-danger mr-2 mb-2" id="ex_day_end" data-toggle="modal" data-target="#myModal">Execute Day End</a>--}}


    {{--                                    <a href="{{ route('close_day_end') }}" class="btn btn-danger mr-2 mb-2">Start Day End</a>--}}
                                    </p>
                                </fieldset>

                            </div>
                        </div>
                    </div>

                </div> <!-- white column form ends here -->


            </div><!-- col end -->


        </div><!-- row end -->

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg mdl_wdth">
            <div class="modal-content base_clr">
                <div class="modal-header">

                    <div class="btn-group hide_info" id="prnt_btn_dynd">
                        <button type="button" class="btn btn-primary grp_btn tb_drop_down" id="btnPrint">
                            Print This Screen
                        </button>
                        <button type="button" class="btn btn-primary dropdown-toggle grp_btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>

                        <div class="dropdown-menu dropdown-menu-right print_act_drp hide_column" x-placement="bottom-end">
                            <button type="button" class="dropdown-item tb_drop_down" onclick="prnt_cus('pdf')">
                                <i class="fa fa-print"></i> Print
                            </button>
                            <button type="button" class="dropdown-item tb_drop_down" id="" onclick="prnt_cus('download_pdf')">
                                <i class="fa fa-print"></i> Download PDF
                            </button>
                        </div>
                    </div>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body printMe">

                    <div id="lck_un_lck_con" class="login-wrap d-flex align-items-center flex-wrap justify-content-center pd-20 hide_info">
                        <form action="{{ route('day_end_unlock') }}" method="post" class="prnt_lst_frm">
                            @csrf
                            <div class="login-box bg-white box-shadow pd-30 border-radius-5">
                                <h4 class="text-center mb-30 get-heading-text">
                                    Enter Your Password to Confirm to Continue
                                </h4>
                                <div class="input-group custom input-group-lg">
                                    <input type="password" class="form-control" placeholder="Enter Your Password" name="lck_un_lck_pass" id="lck_un_lck_pass" value="" required >
                                    <input type="hidden" class="form-control" name="lck_un_lck_duid" id="lck_un_lck_duid" value="{{$user_id}}" >
                                    <div class="input-group-append custom">
                                        <span toggle="#lck_un_lck_pass" class="toggle-password input-group-text">
                                            <i class="fa fa-fw fa-eye" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="input-group">
                                            <input class="btn btn-outline-primary btn-lg btn-block" type="submit" value="{!! ( (isset($dynd_status) && !empty($dynd_status) && $dynd_status === 'UN_LOCKED' ) ? ucwords(strtolower(str_replace('_', '', $dynd_status))) : ucwords(strtolower(str_replace('_', '', $dynd_status))) ) !!} Day End">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div id="dynd_chk_pass" class="login-wrap d-flex align-items-center flex-wrap justify-content-center pd-20 show_info">
                        <form class="prnt_lst_frm1" onsubmit="return false;">
                            <div class="login-box bg-white box-shadow pd-30 border-radius-5">
                                <h4 class="text-center mb-30 get-heading-text">
                                    Enter Your Password to Confirm to Continue
                                </h4>
                                <div class="input-group custom input-group-lg">
                                    <input type="password" class="form-control" placeholder="Enter Your Password" name="password" id="password" value="" required >
                                    <input type="hidden" class="form-control" name="uid" id="uid" value="{{$user_id}}" >
                                    <div class="input-group-append custom">
                                        <span toggle="#password" class="toggle-password input-group-text"><i class="fa fa-fw fa-eye" aria-hidden="true"></i></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="input-group">
                                            <input class="btn btn-outline-primary btn-lg btn-block" type="button" name="btn" id="ex_day_end" data-type="execute" value="Execute Day End">
                                        </div>
                                        <div id="dynd_chk_status" class="text-center text-danger"></div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div id="dynd_chk_rprt" class="hide_info"></div>
                    <input type="hidden" id="chck_two_pass" value="">
                </div>
            </div>
        </div>
    </div>


    <form name="ledger" id="ledger" action="{{ route('account_ledger') }}" method="post" target="_blank">
        @csrf
        <input name="account_id" id="account_id" type="hidden">
        <input name="account_name" id="account_name" type="hidden">

    </form>
@endsection

@section('scripts')

    <script type="text/javascript">

        var url_day_end_exe = '{{ route("execute_day_end") }}',
            url_day_end_rprt = '{{ route("day_end_report") }}',
            uid = $("#uid").val(),
            base = '',
            url,
            tableformat,
            chk_two_pass,
            cls_chng;

        $("#ex_day_end").click(function () {
            var upassword = $("#password").val(),
                type = $(this).data('type');
            if ( type === 'execute' ) {
                if ($("#cb").is(':checked')) {
                    if( upassword.length !== '' && upassword.length > 5 ) {
                        $('#dynd_chk_rprt').html();
                        $("#chck_two_pass").val('execute');
                        jQuery(".pre-loader").fadeToggle("medium");
                        base = url_day_end_exe;
                        getMessage(url_day_end_exe);
                    }
                }
            }
            else{
                if( upassword.length !== '' && upassword.length > 5 ) {
                    $('#dynd_chk_rprt').html();
                    $("#chck_two_pass").val('report');
                    jQuery(".pre-loader").fadeToggle("medium");
                    base = url_day_end_rprt;
                    getMessage(url_day_end_rprt);
                }
            }
        });

        $("#cb").click(function () {
            if( $("#cb").is(':checked') ) {
                $(".view.dyend_view").removeAttr('disabled');
                $(".view.dyend_view").removeClass('disabled');
            }
            else{
                $(".view.dyend_view").attr('disabled','disabled');
                $(".view.dyend_view").addClass('disabled');
            }
        });

        $(".view").click(function () {
            if( $("#cb").is(':checked') ) {
                $('#dynd_chk_rprt').html();
                $('#dynd_chk_status').html();
                $("#ex_day_end").data('type','execute');
                $("#ex_day_end").val('Execute Day End');
                $("#dynd_chk_pass").addClass('show_info').removeClass('hide_info');
                $("#dynd_chk_rprt").addClass('hide_info').removeClass('show_info');
                $("#lck_un_lck_con").addClass('hide_info').removeClass('show_info');
                $("#prnt_btn_dynd").addClass('hide_info').removeClass('show_info');
                $('#myModal').modal({show: true});
            }
        });

        $(".view_rprt").click(function () {
            $('#dynd_chk_rprt').html();
            $('#dynd_chk_status').html();
            $("#ex_day_end").data('type','report');
            $("#ex_day_end").val('Day End Report');
            $("#dynd_chk_pass").addClass('show_info').removeClass('hide_info');
            $("#dynd_chk_rprt").addClass('hide_info').removeClass('show_info');
            $("#lck_un_lck_con").addClass('hide_info').removeClass('show_info');
            $("#prnt_btn_dynd").addClass('hide_info').removeClass('show_info');
            $('#myModal').modal({show: true});
        });

        $("#lck_un_lck").click(function () {
            $('#dynd_chk_rprt').html();
            $('#dynd_chk_status').html();
            $("#lck_un_lck_con").addClass('show_info').removeClass('hide_info');
            $("#dynd_chk_pass").addClass('hide_info').removeClass('show_info');
            $("#dynd_chk_rprt").addClass('hide_info').removeClass('show_info');
            $("#prnt_btn_dynd").addClass('hide_info').removeClass('show_info');
            $('#myModal').modal({show: true});
        });

        // $(".view_rprt").click(function () {
        //     $('#dynd_chk_rprt').html();
        //     $('#dynd_chk_status').html();
        //     $("#lck_un_lck_con").addClass('hide_info').removeClass('show_info');
        //     $("#dynd_chk_pass").addClass('hide_info').removeClass('show_info');
        //     $("#dynd_chk_rprt").addClass('hide_info').removeClass('show_info');
        //     getMessage(url_day_end_rprt);
        //     base = url_day_end_rprt;
        //     $('#myModal').modal({show: true});
        // });

        $(".toggle-password").click(function() {
            $(this).children('i').toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") === "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });

        $("#dynd_chk_rprt").on("change","#tb_drop_down", function(){
            tableformat = $("#tb_drop_down").val();
        });


        function getMessage(url_day_end_exe) {
            var upassword = $("#password").val(),
                url_day_end = url_day_end_exe;

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: url_day_end,
                method: 'GET',
                data: {
                    uid: uid,
                    upassword: upassword,
                },
                datatype:'json',
                success:function(data) {
                    console.log(data);
                    jQuery(".pre-loader").fadeToggle("medium");
                    if( data.status === 'true') {
                        $("#dynd_chk_pass").addClass('hide_info').removeClass('show_info');
                        $("#dynd_chk_rprt").addClass('show_info').removeClass('hide_info');
                        $("#prnt_btn_dynd").removeClass('hide_info');
                        $('#dynd_chk_rprt').html(data.data);
                        $('#dynd_chk_status').html();
                    }
                    else if( data.status === 'false') {
                        $("#dynd_chk_pass").addClass('show_info').removeClass('hide_info');
                        $("#dynd_chk_rprt").addClass('hide_info').removeClass('show_info');
                        $("#prnt_btn_dynd").addClass('hide_info').removeClass('show_info');
                        $('#dynd_chk_status').html(data.message);
                    }
                }
            });
        }

        function prnt_cus(str){
            chk_two_pass = $("#chck_two_pass").val();
            if( chk_two_pass === 'execute'){
                cls_chng = 'prnt_lst_frm';
            }
            else{
                cls_chng = 'prnt_lst_frm1';
            }
            var slug = JSON.stringify( $("."+cls_chng).serializeArray() ),
                url = base+'?array='+slug+'&str='+str+'&tableformat='+tableformat;

            if( str === 'download_pdf' || str === 'download_excel') {
                download_pdf_excl(url);
            }

            if( str === 'pdf') {
                pdf_preView(url);
            }
        }

        function download_pdf_excl(url){
            var a = document.createElement('a');
            a.href = url;
            a.download = base.toString().split('/').pop();
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        }

        function pdf_preView(url){
            var w = 900,
                h = 400,
                left = (screen.width/2)-(w/2),
                top = (screen.height/2)-(h/2);

            var WinPrint = window.open(url, '', 'toolbar=no, location=no, directories=no, status=no, menubar=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
            WinPrint.document.close();
            WinPrint.onload = function() {
                WinPrint.focus();
                // WinPrint.print();
                // setTimeout(function () { WinPrint.close(); }, 1500);
            };
        }


    </script>
    {{--    add code by shahzaib end --}}

    <script>
        jQuery.fn.extend({
            printElem: function() {
                var cloned = this.clone();
                var printSection = $('#printSection');
                if (printSection.length == 0) {
                    printSection = $('<div id="printSection"></div>')
                    $('body').append(printSection);
                }
                printSection.append(cloned);
                var toggleBody = $('body *:visible');
                toggleBody.hide();
                $('#printSection, #printSection *').show();
                window.print();
                printSection.remove();
                toggleBody.show();
            }
        });

        $(document).ready(function(){
            $(document).on('click', '#btnPrint', function(){
                $('.main_container').printElem();
            });
        });

        // function _unlockButton(cb) {
        //     document.getElementById('unlock').disabled = !cb.checked;
        // }


    </script>

    <script>
        jQuery("#dynd_chk_rprt").on("click", ".day-end-ledger", function () {
            var account_id = jQuery(this).attr("data-id");
            var account_name = jQuery(this).attr("data-name");

            jQuery("#account_id").val(account_id);
            jQuery("#account_name").val(account_name);
            jQuery("#ledger").submit();
        });

    </script>


@endsection


