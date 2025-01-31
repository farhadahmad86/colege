@extends('extend_index')

@section('styles_get')
    <link href="{{asset("public/css/treeview.css" )}}" rel="stylesheet">

    <style>

        /*nabeel*/
        .input-group {
            margin-bottom: 0px;
        }


        body {
            background-color: white;
        }

        .app-content {
            background-color: white;
            padding-top: 70px !important;
            margin-top: 0;
        }


        .fin-wizard {
            position: relative;
            padding: 10px;
            max-width: 1540px;
            margin: 0 auto;
        }

        .fin-wizard--head, .fin-wizard--body {
        }


        .progress {
            position: relative;
        }

        .progress-text {
            position: absolute;
            top: -1px;
            left: 50%;
            color: white;
            font-weight: bold;
            transform: translateX(-50%);
        }

        .fin-wizard--status {
        }

        .fin-wizard--status ul {
            width: auto;
            margin: 5px auto;
            list-style: none;
            font-size: 11px;
            text-align: center;
            font-weight: bold;
        }

        .fin-wizard--status ul li {
            display: inline-block;
            padding: 1px 5px;
            min-width: 90px;
        }

        .fin-wizard--status ul li:nth-child(1) {
            background-color: #ffd9d9;
            border: 2px solid #fb0000;
        }

        .fin-wizard--status .required-info {
            width: 5px;
            height: 5px;
            background: red;
            border-radius: 50px;
            display: inline-block;
            margin: 0 2px 2px 0;
        }

        /*.fin-wizard--status ul li:nth-child(2) {
            background-color: rgba(0, 0, 0, 0.35);
            border: 2px solid rgb(0, 0, 0);
        }
        .info {
            width: 5px;
            height: 5px;
            background: black;
            border-radius: 50px;
            display: inline-block;
            margin: 0 2px 2px 0;
        }*/
        .fin-wizard--status ul li:nth-child(2) {
            background-color: rgb(217, 255, 217);
            border: 2px solid #00a700;
        }

        .fin-wizard--status .completed {
            width: 5px;
            height: 5px;
            background: #00c500;
            border-radius: 50px;
            display: inline-block;
            margin: 0 2px 2px 0;
        }

        .fin-wizard--status ul li:nth-child(3) {
            background-color: rgb(196, 231, 255);
            border: 2px solid rgb(0, 135, 255);
        }

        .fin-wizard--status .active {
            width: 5px;
            height: 5px;
            background: blue;
            border-radius: 50px;
            display: inline-block;
            margin: 0 2px 2px 0;
        }

        .fin-wizard--status ul li:nth-child(4) {
            background-color: rgb(222, 222, 222);
            border: 2px solid rgb(122, 122, 122);
        }

        .fin-wizard--status .disabled {
            width: 5px;
            height: 5px;
            background: #7d7d7d;
            border-radius: 50px;
            display: inline-block;
            margin: 0 2px 2px 0;
        }

        /*.fin-wizard--status ul {
            width: 300px;
            margin: 5px auto;
            list-style: none;
            font-size: 11px;
            text-align: center;
            font-weight: bold;
        }
        .fin-wizard--status ul li {
            display: inline-block;
            padding: 1px 5px;
            min-width: 70px;
        }
        .fin-wizard--status ul li:nth-child(1) { background-color: rgb(123,226,124); }
        .fin-wizard--status ul li:nth-child(2) { background-color: rgb(123,184,226); }
        .fin-wizard--status ul li:nth-child(3) { background-color: #eaeaea; }*/


        .fin-wizard--body {
            padding-top: 10px;
        }

        .fin-wizard--body--content {
            display: flex;
            flex-direction: column;
        }

        .fin-wizard--body--content--row {
            flex: 1;
            display: flex;
            flex-direction: row;
            align-items: center;
        }

        .fin-wizard--body--content--row--heading {
            display: flex;
            width: 190px;
            min-width: 190px;
            border: 1px solid #00d501;
            border-radius: 5px;
            background-color: #d4fdd4;
            height: 90px;
            align-items: center;
            padding: 0 10px;
            margin-right: 10px;
        }

        .fin-wizard--body--content--row--action {
            padding: 10px;
        }

        .fin-wizard--body--content--row--action .fin-wizard__action {
            font-size: 9px;
            width: 116px; /* prev: 127px; */
            height: 90px; /* prev: 100px; */
            font-weight: bold;
            white-space: normal;
            background: white;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .fin-wizard__action--complete {
            color: green;
            border: 2px solid rgb(123, 226, 124);
            background-color: #e8ffe8 !important;
        }

        .fin-wizard__action--complete:hover {
            box-shadow: 0 0 8px 2px rgb(123, 226, 124) !important;
        }

        .fin-wizard__action--complete::after {
            /*content: '\2714'; !* 0021 exclamation *!*/
            width: 15px;
            height: 15px;
            background: green;
            position: absolute;
            top: -5px;
            right: -5px;
            border-radius: 50%;
            color: white;
            padding: 1px 0;
            font-size: 9px;
        }

        .fin-wizard__action--active {
            color: rgb(0, 135, 255);
            border: 2px solid rgb(123, 184, 226);
            background-color: rgb(231, 244, 255) !important;
        }

        .fin-wizard__action--active:hover {
            box-shadow: 0 0 8px 2px rgb(123, 184, 226) !important;
        }

        .fin-wizard__action--disabled {
            color: black;
            border: 2px solid gray;
            background-color: #d7d5d5 !important;
        }

        .fin-wizard__action--disabled:hover {
            cursor: not-allowed !important;
        }

        .fin-wizard--body--content--row--action i {
            display: flex;
            align-items: center;
            justify-content: center;
            flex: 1;
            margin: 0 !important;
            font-size: 30px !important;
        }

        .fin-wizard--body--content--row--action span {
            flex: 0.5;
        }

        .fin-wizard--body--content--row--action .required-info--action {
            position: absolute;
            top: 2px;
            right: 2px;
            width: 4px;
            height: 4px;
            background: red;
            border-radius: 50px;
        }


        .modal-dialog {
            width: 100%;
            height: 100%;
            margin: 0;
            max-width: 100%;
        }

        .modal-content {
            width: 90%;
            height: 90vh;
            margin: auto;
        }

        .modal-header,
        .modal-footer {
            border: unset;
            background-color: #dcdcdc;
            padding: 10px 20px;
        }

        .modal-body {
            overflow: unset;
        }


        /* Testing css */
        /*        .fin-wizard__action
                {
                    font-size: 9px;
                    width: 116px; !* prev: 127px; *!
                    height: 90px; !* prev: 100px; *!
                    font-weight: bold;
                    white-space: normal;
                    background: white;
                    border: 2px solid rgb(123,226,124);
                    color: green;
                    display: flex;
                    flex-direction: column;
                }*/
        /*  => Check mark.
        content: '\2714'; // 0021 exclamation
        width: 20px;
        height: 20px;
        background: green;
        position: absolute;
        top: -5px;
        right: -5px;
        border-radius: 50%;
        color: white;
        padding: 1px 0;
        font-size: 12px;
        */

        /*TEmp change to buttons*/
        .fin-wizard--body--content--row--heading {
            height: 50px;
        }

        .fin-wizard--body--content--row--action .fin-wizard__action {
            font-size: 10px;
            width: 130px;
            height: 50px;
        }

        .fin-wizard--body--content--row--action span {
            align-items: center;
            align-self: center;
            display: flex;
            flex: 1;
        }

        /*.fin-wizard--body--content--row--action .required-info--action {
            width: 3px;
            height: 3px;
        }*/


        /*popup icon*/
        .fin-wizard__action .popup_icon {
            /*position: absolute;top: 6px;right: 9px;width: 18px;height: 18px;*/
            position: absolute;
            top: -2px;
            left: -2px;
            width: 15px;
            height: 15px;
            margin: 0;
            padding: 0;
            /*z-index: 1;*/
            display: none;
        }

        .fin-wizard__action .popup_icon i { /*padding: 0; margin: 0; font-size: 11px; vertical-align: unset;*/
            font-size: 10px !important;
            line-height: 15px;
        }

        .fin-wizard__action:hover .popup_icon,
        .fin-wizard__action:focus .popup_icon {
            top: -2px;
            left: -2px;
            display: block;
        }
    </style>

@endsection



@section('content')

    @php
        $sc_welcome_wizard = $systemConfig->sc_welcome_wizard;
        $perActionProgress = 100 / $systemConfig->getTotalWizardActions();
        $completedProgress = $sc_welcome_wizard['total_completed'] * $perActionProgress;
        $activeProgress = $sc_welcome_wizard['total_active'] * $perActionProgress;
        $activeProgressTotal = $activeProgress + $completedProgress;
    @endphp


    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">


            <form name="edit" id="edit" action="{{ route('account_ledger') }}" target="_blank" method="post">
                @csrf
                <input name="account_name" id="account_name" type="hidden">
                <input name="account_id" id="account_id" type="hidden">
            </form>


            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">


                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Chart Of Accounts Tree View</h4>
                        </div>
                    </div>
                </div><!-- form header close -->


                <div class="row">
                    <div class="col-md-6">
                        <h3 class="title_cus flx">
                            <img src="{{ asset("public/vendors/images/tree.png") }}" style="width: 65px;">
                            Chart Of Accounts List
                        </h3>
                        <ul id="tree1">
                            @php
                                $count=0;
                            @endphp
                            @foreach($categories as $index => $category)
                                <li class="heads head-{{$index+1}}">
                                    @php
                                        $index += 1;
                                        $imagePath = "public/vendors/images/coa_tree_icon_$index.png";
                                        // $imagePath = "public/vendors/images/assets5.png";
                                    @endphp
                                    <img src="{{ asset($imagePath) }}" style="width: 25px;margin: 5px;">
                                    {{  $category->coa_code.' - '.$category->coa_head_name }}

                                    {{--                                                nabeel panga--}}
                                    {{-- <div class="col-md-6">
                                        <form name="f1" class="f1" id="f1" action="store_chart_of_account" method="post"
                                              onsubmit="return checkForm()">
                                            @csrf
                                            <div hidden class="row">
                                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                    <div class="input_bx">
                                                        <label class="required">Code</label>
                                                        <input type="number" name="code" id="code"
                                                               value="{{$category->coa_code}}"
                                                               class="inputs_up form-control" placeholder="Code"
                                                               autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                            <div hidden class="row">
                                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                    <div class="input_bx">
                                                        <label class="required">Name</label>
                                                        <input type="text" name="name" id="name"
                                                               value="{{$category->coa_head_name}}"
                                                               class="inputs_up form-control" placeholder="Name"
                                                               autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                            <div hidden class="row">
                                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                    <div class="input_bx">
                                                        <label class="required">Parent</label>
                                                        <input type="number" name="parent" id="parent"
                                                               value="{{$category->coa_parent}}"
                                                               class="inputs_up form-control" placeholder="Parent"
                                                               autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                            <div hidden class="row">
                                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                    <div class="input_bx">
                                                        <label class="required">Level</label>
                                                        <input type="number" name="level" id="level"
                                                               value="{{$category->coa_level}}"
                                                               class="inputs_up form-control" placeholder="Quantity"
                                                               autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="input-group input-group-sm col-lg-8 col-md-8 col-sm-8">
                                                    <input type="text" name="account_name" id="account_name"
                                                           class="border form-control" placeholder="Account Name"
                                                           autocomplete="off" style="height: 30px;">

                                                    <span class="input-group-append">
<button type="submit" name="save" id="save" type="button" style="background: #305a72;color: white;"
        class="btn btn-info btn-flat"><i class="fa fa-floppy-o"></i> Save</button>
</span>
                                                </div>

                                            </div>
                                        </form>
                                    </div> --}}


                                    @if(count($category->childs))
                                        @include('manageChild',['childs' => $category->childs ,'count' =>$count, 'index' => $index-1])
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>


                </div>

            </div>

        </div><!-- col end -->


    </div><!-- row end -->


@endsection

@section('scripts')

    <script>
        $(document).ready(function () {

            $('.popup_icon').tooltip();

            $('.fin-wizard__action--disabled').attr('disabled', true);

            var form_heading = '';
            var form_location = '';
            $('.fin-wizard__action').on('click', function (e) {
                e.preventDefault();
                form_heading = $(this).text();
                form_location = $(this).data('href');
            });
            $('#fin-wizard--modal ').on('show.bs.modal', function (e) {
                $('#fin-wizard--modal--label').text(form_heading);

                var iframe = $('#' + $(this).attr('id') + ' iframe');
                iframe.attr("src", form_location);
                iframe.on("load", function () {
                    iframe.contents().find("body div.header").remove();
                    iframe.contents().find("body div.left-side-bar").remove();
                    iframe.contents().find("body .main-container div#ftr").remove();
                    iframe.contents().find("body .main-container").css('padding-top', '20px');
                    iframe.contents().find("body #main_col .form_manage").css('margin', '0');
                });
            });
            $('#fin-wizard--modal').on('hide.bs.modal', function (e) {
                var iframe = $('#' + $(this).attr('id') + ' iframe');
                iframe.attr("src", "about:blank");
                iframe = null;

                form_heading = '';
                form_location = '';

                ajaxGetWizardInfo();
            });

            function ajaxGetWizardInfo() {
                jQuery.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });
                jQuery.ajax({

                    url: '{{ route('ajax-get-wizard-info') }}',
                    type: 'get',
                    cache: false,
                    dataType: 'json',
                    beforeSend: function () {
                        console.log('ajax report before');
                    },
                    success: function (data) {
                        console.log('response report:', data);
                        if (data['result'] === true) {
                            $.each(data['data']['sc_welcome_wizard'], function (key, value) {
                                if (value == 1) {
                                    $('#' + key).removeClass("fin-wizard__action--active").removeClass("fin-wizard__action--disabled").addClass("fin-wizard__action--complete").attr('disabled', false);
                                    if (key == 'admin_profile') {
                                        $('#' + key).parent().remove();
                                    }
                                } else if (value == 0) {
                                    $('#' + key).removeClass("fin-wizard__action--complete").removeClass("fin-wizard__action--disabled").addClass("fin-wizard__action--active").attr('disabled', false);
                                } else if (value == -1) {
                                    $('#' + key).removeClass("fin-wizard__action--active").removeClass("fin-wizard__action--complete").addClass("fin-wizard__action--disabled").attr('disabled', true);
                                }
                            });

                            var completedProgress = data['data']['sc_welcome_wizard']['total_completed'] * {{ $perActionProgress }};
                            var activeProgress = data['data']['sc_welcome_wizard']['total_active'] * {{ $perActionProgress }};
                            var activeProgressTotal = activeProgress + completedProgress;
                            console.log('completedProgress: ' + completedProgress, 'activeProgressTotal: ' + activeProgressTotal, 'activeProgress: ' + activeProgress);
                            $('.fin-wizard--progress #progress-bar-completed').css('width', completedProgress + '%');
                            $('.fin-wizard--progress #progress-bar-active').css('width', activeProgress + '%');
                            $('.fin-wizard--progress .progress-text').html('').html(completedProgress.toFixed(0) + '% Completed : ' + activeProgressTotal.toFixed(0) + '% Active');

                            if (data['data']['sc_welcome_wizard']['wizard_completed'] == 1) {
                                $('.fin-wizard__close').css('display', 'block');
                            }
                        }
                    },
                    error: function (xhr, textStatus, errorThrown, jqXHR) {
                        console.log(xhr, textStatus, errorThrown, jqXHR);
                    },
                    complete: function () {
                        console.log('ajax report Complete');
                    }
                });
            }

        });


        /*
        var app = $("#companyInfoModalFrame").contents().find("#app").html();
        $("#companyInfoModalFrame").contents().find("body").html('');
        $("#companyInfoModalFrame").contents().find("body").html(
            $('<div id="app">'+ app +'</div>')
        );


        var app = $(this).contents().find("#app").html();
        $(this).contents().find("body").html(
            $('<div id="app">'+ app +'</div>')
        );
        */
    </script>



    <script src="{{asset("public/js/treeview.js")}}"></script>

    <script>
        jQuery(".edit").click(function () {

            var account_name = jQuery(this).attr("data-account_name");
            var account_id = jQuery(this).attr("data-account_id");

            jQuery("#account_name").val(account_name);
            jQuery("#account_id").val(account_id);

            jQuery("#edit").submit();
        });

    </script>

@endsection

