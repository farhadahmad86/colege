<!DOCTYPE html>
<html lang='{{ str_replace('_', '-', app()->getLocale()) }}'>
<head>
    <!-- BasicPackage Page Info -->
    <meta charset='utf-8'>
    <title>Financtics</title>
    <meta name='csrf-token' content='{{ csrf_token() }}'>
    <meta content='text/html; charset=utf-8' http-equiv='Content-Type'>
    <!-- Site favicon -->
    <link rel='shortcut icon' href={{asset('public/vendors/images/favicon.png')}}>

    <!-- Mobile Specific Metas -->
    <meta name='viewport' content='width=device-width, initial-scale=0, maximum-scale=0'>

    <link rel='stylesheet' href={{asset('public/vendors/styles/style.css')}}>
    <link rel='stylesheet' href={{asset('public/css/media.css')}}>
    <link rel='stylesheet' href='{{asset('public/vendors/styles/font-awesome/css/font-awesome.min.css')}}'>
    <script src='{{asset('public/vendors/scripts/jquery.min.2.2.1.js')}}'></script>
    <script src='{{asset('public/vendors/scripts/jquery.min3.3.1.js')}}'></script>
    <script type='text/javascript' src='{{ asset('public/vendors/scripts/jquery-1.3.2.js') }}'></script>

    <script type='text/javascript' src='{{ asset('public/vendors/scripts/jquery.shortcuts.min.js') }}'></script>
    @yield('shortcut_script')
    <script src={{asset('public/js/select2/dist/js/select2.min.js')}} type='text/javascript'></script>
    <!-- CSS -->
    <link href={{asset('public/js/select2/dist/css/select2.min.css')}} rel='stylesheet' type='text/css'>
    <link rel='stylesheet' href={{asset('public/vendors/styles/sweetalert2.css')}} />
    <link rel='stylesheet' href={{asset('public/vendors/styles/style-main.css')}}>
    <link rel='stylesheet' href={{asset('public/vendors/styles/table_styles.css')}}>
    <link href='{{ asset('public/vendors/styles/profile_style.css') }}' rel='stylesheet' type='text/css' media='all'/>
    <link rel='stylesheet' href='{{ asset('public/vendors/styles/profile_font-awesome.min.css') }}'/>

    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 49px;
            height: 22px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: '';
            height: 15px;
            width: 15px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #2a88ad;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

        input::-webkit-calendar-picker-indicator {
            display: none;
        }
    </style>
</head>
<body>
@include('include/header')
{{--@include('include/sidebar')--}}
<div class='main-container'>
    <div class='pd-ltr-20 customscroll-10-p height-100-p xs-pd-20-10'>

        @include('inc._messages')
        <div id='app'>
            <div class='row'>

                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12'>

                    <div class='pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage'>


                        <div class='form_header'>
                            <div class='clearfix'>
                                <div class='pull-left'>
                                    <h4 class='text-white get-heading-text'>Product Clubbing</h4>
                                </div>
                                <div class='list_btn'>
                                    <a class='btn list_link add_more_button' href='{{ route('product_clubbing_test') }}' role='button'>
                                        <i class='fa fa-list'></i> view list
                                    </a>
                                </div>
                            </div>
                        </div>


                        <div id='invoice_con' class='gnrl-mrgn-pdng invoice_con for_voucher'>
                            <div id='invoice_bx' class='gnrl-mrgn-pdng gnrl-blk invoice_bx show_scale show_rotate'>

                                <form name='f1' class='f1' id='f1' action='{{ route('submit_product_clubbing') }}' method='post' onsubmit='return popvalidation()' autocomplete='off'>
                                    @csrf
                                    <div class='gnrl-mrgn-pdng gnrl-blk invoice_bx_scrl'>
                                        <div class='gnrl-mrgn-pdng gnrl-blk invoice_cntnt'>

                                            <div class='invoice_row'>

                                                <div class='invoice_col basis_col_23'>
                                                    <div class='invoice_col_bx'>
                                                        <div class='required invoice_col_ttl'>
                                                            <a data-container='body' data-toggle='popover' data-trigger='hover'
                                                               data-placement='bottom' data-html='true'
                                                               data-content='<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.new.product_clubbing.parent_code.description')}}</p>'>
                                                                <l class='fa fa-info-circle'></l>
                                                            </a>

                                                            Parent Code
                                                        </div>
                                                        <div class='invoice_col_input'>
                                                            <div class='invoice_col_short'>
                                                                <a href='{{ route('add_product') }}' class='col_short_btn' target='_blank' data-container='body' data-toggle='popover' data-trigger='hover' data-placement='bottom' data-html='true' data-content='{{config('fields_info.about_form_fields.add.description')}}'>
                                                                    <i class='fa fa-plus'></i>
                                                                </a>
                                                                <a id='refresh_product_code' class='col_short_btn' data-container='body' data-toggle='popover' data-trigger='hover' data-placement='bottom' data-html='true' data-content='{{config('fields_info.about_form_fields.refresh.description')}}'>
                                                                    <i class='fa fa-refresh'></i>
                                                                </a>
                                                            </div>
                                                            <select name='product_parent_code' class='inputs_up form-control' id='product_parent_code' {{$status == 1 ? 'readonly':''}}>
                                                                <option value='0'>Select Code</option>
                                                            </select>
                                                            <span id='demo1' class='validate_sign'> </span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class='invoice_col basis_col_23'>
                                                    <div class='invoice_col_bx'>
                                                        <div class='required invoice_col_ttl'>
                                                            <a data-container='body' data-toggle='popover' data-trigger='hover'
                                                               data-placement='bottom' data-html='true'
                                                               data-content='<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.new.product_clubbing.parent_name.description')}}</p>
                                                       <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.new.product_clubbing.parent_name.benefits')}}</p>'>
                                                                <l class='fa fa-info-circle'></l>
                                                            </a>
                                                            Parent Name
                                                        </div>
                                                        <div class='invoice_col_input'>
                                                            <div class='invoice_col_short'>
                                                                <a href='{{ route('add_product') }}' class='col_short_btn' target='_blank' data-container='body' data-toggle='popover' data-trigger='hover' data-placement='bottom' data-html='true' data-content='{{config('fields_info.about_form_fields.add.description')}}'>
                                                                    <i class='fa fa-plus'></i>
                                                                </a>
                                                                <a id='refresh_product_name' class='col_short_btn' data-container='body' data-toggle='popover' data-trigger='hover' data-placement='bottom' data-html='true' data-content='{{config('fields_info.about_form_fields.refresh.description')}}'>
                                                                    <i class='fa fa-refresh'></i>
                                                                </a>
                                                            </div>
                                                            <select name='product_parent_name' class='inputs_up form-control' id='product_parent_name' {{$status == 1 ? 'readonly':''}}>
                                                                <option value='0'>Select Product</option>
                                                            </select>
                                                            <span id='demo2' class='validate_sign'> </span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class='invoice_col basis_col_11'>
                                                    <div class='invoice_col_bx'>
                                                        <div class='required invoice_col_ttl'>
                                                            <a data-container='body' data-toggle='popover' data-trigger='hover'
                                                               data-placement='bottom' data-html='true'
                                                               data-content='<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.new.product_clubbing.product_code.description')}}</p>
                                                       <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.new.product_clubbing.product_code.benefits')}}</p>
                                                       <h6>Example</h6><p>{{config('fields_info.about_form_fields.new.product_clubbing.product_code.example')}}</p>'>
                                                                <l class='fa fa-info-circle'></l>
                                                            </a>
                                                            Product Code
                                                        </div>
                                                        <div class='invoice_col_input'>
                                                            <input type='text' name='product_code' class='inputs_up text-center form-control' id='product_code' placeholder='Product Code'>
                                                            <span id='demo3' class='validate_sign'></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class='invoice_col basis_col_23'>
                                                    <div class='invoice_col_txt for_voucher_col_bx'>
                                                        <div class='invoice_col_txt with_cntr_jstfy'>
                                                            <div class='invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk'>
                                                                <button id='first_add_more' class='invoice_frm_btn' onclick='add_product()' type='button'>
                                                                    <i class='fa fa-plus'></i> Add
                                                                </button>
                                                            </div>
                                                            <div class='invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk'>
                                                                <button style='display: none;' id='cancel_button' class='invoice_frm_btn' onclick='cancel_all()' type='button'>
                                                                    <i class='fa fa-times'></i> Cancel
                                                                </button>
                                                                <span id='demo201' class='validate_sign'> </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class='invoice_row'>

                                                <div class='invoice_col basis_col_100'>
                                                    <div class='invoice_row'>

                                                        <div class='invoice_col basis_col_100 gnrl-mrgn-pdng'>
                                                            <div class='pro_tbl_con for_voucher_tbl'>
                                                                <div class='pro_tbl_bx'>
                                                                    <table class='table gnrl-mrgn-pdng' id='category_dynamic_table'>
                                                                        <thead>
                                                                        <tr>
                                                                            <th class='text-center tbl_srl_100'> Product Code</th>
                                                                        </tr>
                                                                        </thead>

                                                                        <tbody id='table_body'>
                                                                        <tr>
                                                                            <td colspan='10' align='center'>
                                                                                No Entry
                                                                            </td>
                                                                        </tr>
                                                                        </tbody>

                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>

                                            </div>

                                            <div class='invoice_row'>

                                                <div class='invoice_col basis_col_100'>
                                                    <div class='invoice_col_txt with_cntr_jstfy for_voucher_btns'>
                                                        <div class='invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk'>
                                                            <button type='submit' name='save' id='save' class='invoice_frm_btn' onclick='return popvalidation()'>
                                                                <i class='fa fa-floppy-o'></i> Save
                                                            </button>
                                                            <span id='demo4' class='validate_sign'></span>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>

                                        </div>
                                    </div>


                                    <input type='hidden' name='productsval' id='productsval'>
                                    <input type='hidden' name='delete_products' id='delete_products'>
                                    <input type='hidden' name='status' id='status' value='{{$status}}'>


                                </form>

                            </div>
                        </div>


                    </div>

                </div>


            </div>
        </div>
        @include('include/footer')

    </div>
</div>


<script src={{asset('public/vendors/scripts/script.js')}}></script>
<script src={{asset('public/vendors/scripts/dataTables.min.js')}} type='text/javascript'></script>
<script src={{asset('public/sidebar_js/script.js')}}></script>
<script src={{asset('public/vendors/scripts/sweetalert2.all.js')}}></script>
<script src='https://cdn.jsdelivr.net/npm/sweetalert2@9'></script>
<script type='text/javascript' src='{{ asset('public/vendors/scripts/jquery.validate.min.js') }}'></script>
<script>
    jQuery(document).ready(function () {
        var form_heading = '';
        var form_location = '';
        $('.add-prerequisite__action').on('click', function (e) {
            e.preventDefault();
            console.log('$(this):' + $(this), '$(this).data(\'title\'): ' + $(this).data('title'), '$(this).data(\'href\'): ' + $(this).data('href'));
            form_heading = $(this).data('title');
            form_location = $(this).data('href');
        });
        $('#add-prerequisite--modal').on('show.bs.modal', function (e) {
            $('#add-prerequisite--modal--label').text(form_heading);

            var iframe = $('#' + $(this).attr('id') + ' iframe');
            iframe.attr('src', form_location);
            iframe.on('load', function () {
                iframe.contents().find('body div.header').remove();
                iframe.contents().find('body div.left-side-bar').remove();
                iframe.contents().find('body .main-container div#ftr').remove();
                iframe.contents().find('body .main-container').css('padding-top', '20px');
                iframe.contents().find('body #main_col .form_manage').css('margin', '0');
            });
        });
        $('#add-prerequisite--modal').on('hide.bs.modal', function (e) {
            var iframe = $('#' + $(this).attr('id') + ' iframe');
            iframe.attr('src', 'about:blank');
            iframe = null;

            form_heading = '';
            form_location = '';
        });
        $('#srch_slct').click(function () {
            var get_id = $(this).val();
            $('.frm_hide.show_active').removeClass('show_active');
            $('#' + get_id).addClass('show_active');
        });
        $('.srch_box_opn_icon').click(function () {
            $('.search_form').slideToggle(300);
        });

        $('.all_clm_srch').keyup(function () {
            $('#filter_search').val('normal_search');
        });
        $('.cstm_clm_srch').change(function () {
            $('#filter_search').val('filter_search');
        });

        $content_height = $('#main_col').height();
        if ($content_height <= 620) {
            $('#ftr').addClass('fxd_ftr');
        }
        $('.table').DataTable({
            'paging': false,
            'ordering': true,
            'info': false,
            'bFilter': false,
            'autoWidth': false
        });
    });

    jQuery('.usr_prfl').click(function () {
        var transcation_id = jQuery(this).attr('data-usr_prfl'),
            user_info = jQuery(this).attr('data-user_info');
        url = '{{ route('profile_activity', ['id'=>':id', 'array'=>':user_info']) }}';
        url = url.replace(':id', transcation_id);
        url = url.replace(':user_info', user_info.split(','));

        $('.usr_mdl_bdy').load(url, function () {
            $('#usrMdl').modal({show: true});
        });
    });

    @if (count($errors) > 0)
    Swal.fire({
        title: '<i>Errors</i>',
        html: '<ul class=\'alert alert-danger\'>\n' +
            '        @foreach ($errors->all() as $error)\n' +
            '            <li>\n' +
            '                {{ $error }}\n' +
            '            </li>\n' +
            '            <br>\n' +
            '        @endforeach\n' +
            '    </ul>',
    });
    @endif

    @php
        $company_info = Session::get('company_info');
        if(isset($company_info) || !empty($company_info)){
        $print_logo = $company_info->ci_logo;
        $print_name = $company_info->ci_name;
        $print_ptcl = $company_info->ci_ptcl_number;
        $print_mobile = $company_info->ci_mobile_numer;
        $print_whatsapp = $company_info->ci_whatsapp_number;
        $print_fax = $company_info->ci_fax_number;
        $print_email = $company_info->ci_email;
        $print_address = $company_info->ci_address;
        }else{
        $print_logo = '';
        $print_name = '';
        $print_ptcl = '';
        $print_mobile = '';
        $print_whatsapp = '';
        $print_fax = '';
        $print_email = '';
        $print_address = '';
        }
    @endphp

    $(document).ready(function () {
        $('#fixTable').tableHeadFixer();
    });
    jQuery(function () {
        jQuery('.datepicker1').datepicker({
            language: 'en', dateFormat: 'dd-M-yyyy'
        });
    });
    $('form').submit(function () {

        $(this).find(':submit').attr('disabled', 'disabled');
    });

    $(document).ready(function () {

        $('#sidemenu').on('input', function (event) {
            var val = this.value;
            var url;
            if ($('#searchbar_sidemenu option').filter(function () {

                if (this.value.toUpperCase() === val.toUpperCase()) {

                    url = $(this).attr('data-url');
                }
                return this.value.toUpperCase() === val.toUpperCase();

            }).length) {
                window.location = url;
            }
        });
    });

    function allowOnlyNumber(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

    function allow_only_number_and_decimals(txt, evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode == 46) {
            if (txt.value.indexOf('.') === -1) {
                return true;
            } else {
                return false;
            }
        } else {
            if (charCode > 31 &&
                (charCode < 48 || charCode > 57))
                return false;
        }

        return true;
    }

    function allow_positive_negative_with_decimals(txt, evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode == 46) {
            if (txt.value.indexOf('.') === -1) {
                return true;
            } else {
                return false;
            }
        } else if (charCode == 45) {
            if (txt.value.indexOf('-') === -1) {
                return true;
            } else {
                return false;
            }
        } else {
            if (charCode > 31 &&
                (charCode < 48 || charCode > 57))
                return false;
        }
        return true;
    }

    function validate_positive_negative_with_decimals(value) {

        var regex = /^-?[0-9]+.?[0-9]+$/;
        if (regex.test(value)) {
            return true;
        } else {
            return false;
        }
    }

    function assign_product_parent_value() {
        var parent_code = jQuery('#product_code option:selected').attr('data-parent');
        jQuery('#product').val(parent_code);
    }
    $(document).prop('title', $('.get-heading-text').text());

    (function ($) {
        $.fn.inputFilter = function (inputFilter) {
            return this.on('input keydown keyup mousedown mouseup select contextmenu drop', function () {
                if (inputFilter(this.value)) {
                    this.oldValue = this.value;
                    this.oldSelectionStart = this.selectionStart;
                    this.oldSelectionEnd = this.selectionEnd;
                } else if (this.hasOwnProperty('oldValue')) {
                    this.value = this.oldValue;
                    this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                } else {
                    this.value ='';
                }
            });
        };
    }(jQuery));

    $(document).on('keypress keyup keydown', '.percentage_textbox', function () {
        $(this).inputFilter(function (value) {
            return /^-?\d*[.,]?\d*$/.test(value) && (value ==='' || parseInt(value) <= 100);
        });
    });

    $(window).keydown(function (event) {
        if (event.keyCode == 13) {
            $('#first_add_more').click();
            return false;
        }
    });

    jQuery('#refresh_product_code').click(function () {
        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            url: 'refresh_product_club_code',
            data: {},
            type: 'POST',
            cache: false,
            dataType: 'json',
            success: function (data) {

                jQuery('#product_parent_code').html(' ');
                jQuery('#product_parent_code').append(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
                alert(errorThrown);
            }
        });
    });

    jQuery('#refresh_product_code').click(function () {
        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            url: 'refresh_product_club_name',
            data: {},
            type: 'POST',
            cache: false,
            dataType: 'json',
            success: function (data) {
                jQuery('#product_parent_name').html(' ');
                jQuery('#product_parent_name').append(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
                alert(errorThrown);
            }
        });
    });

    jQuery('#refresh_product_name').click(function () {
        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            url: 'refresh_product_club_code',
            data: {},
            type: 'POST',
            cache: false,
            dataType: 'json',
            success: function (data) {
                jQuery('#product_parent_code').html(' ');
                jQuery('#product_parent_code').append(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
                alert(errorThrown);
            }
        });
    });

    jQuery('#refresh_product_name').click(function () {
        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            url: 'refresh_product_club_name',
            data: {},
            type: 'POST',
            cache: false,
            dataType: 'json',
            success: function (data) {
                jQuery('#product_parent_name').html(' ');
                jQuery('#product_parent_name').append(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
                alert(errorThrown);
            }
        });
    });
    jQuery('#product_parent_code').change(function () {
        var product_code = jQuery('option:selected', this).val();
        jQuery('#product_parent_name').select2('destroy');
        jQuery('#product_parent_name').children('option[value^=' + product_code + ' ');
        jQuery('#product_parent_name option[value="' + product_code + '"]').prop('selected', true);
        jQuery('#product_parent_name').select2();
    });

    jQuery('#product_parent_name').change(function () {
        var product_name = jQuery('option:selected', this).val();
        jQuery('#product_parent_code').select2('destroy');
        jQuery('#product_parent_code').children('option[value^=' + product_name + ']');
        jQuery('#product_parent_code option[value="' + product_name + '"]').prop('selected', true);
        jQuery('#product_parent_code').select2();
    });

    var numberofproducts = 0;
    var counter = 0;
    var delete_counter = 0;
    var products = {};
    var delete_products = {};
    var global_id_to_edit = 0;

    function popvalidation() {
        var product_code = document.getElementById('product_code').value;
        var product_parent_code = document.getElementById('product_parent_code').value;

        var flag_submit = true;
        var focus_once = 0;

        if (product_parent_code == '0') {
            if (focus_once == 0) {
                jQuery('#product_parent_code').focus();
                focus_once = 1;
            }
            flag_submit = false;
        }

        if (numberofproducts == 0) {
            if (product_code =='') {
                if (focus_once == 0) {
                    jQuery('#product_code').focus();
                    focus_once = 1;
                }
                flag_submit = false;
            }
            document.getElementById('demo4').innerHTML = 'Add products';
            flag_submit = false;
        } else {
            document.getElementById('demo4').innerHTML ='';
        }
        return flag_submit;
    }

    function add_product() {
        var product_code = document.getElementById('product_code').value;
        var flag_submit1 = true;
        var focus_once1 = 0;
        if (product_code =='') {
            if (focus_once1 == 0) {
                jQuery('#product_code').focus();
                focus_once1 = 1;
            }
            flag_submit1 = false;
        }

        if (flag_submit1) {

            if (global_id_to_edit != 0) {
                jQuery('#' + global_id_to_edit).remove();
                delete products[global_id_to_edit];
            }

            counter++;
            numberofproducts = Object.keys(products).length;

            if (numberofproducts == 0) {
                jQuery('#table_body').html('');
            }

            products[counter] = [product_code];
            numberofproducts = Object.keys(products).length;

            jQuery('#table_body').append('<tr id=' + counter + ' class="edit_update"><td class="text-center tbl_srl_100">' + product_code + '<div class="edit_update_bx"><a class="edit_link btn btn-sm btn-success" href="#" onclick=edit_product(' + counter + ')><i class="fa fa-edit"></i></a><a href="#" class="delete_link btn btn-sm btn-danger" onclick=delete_product(' + counter + ')><i class="fa fa-trash"></i></a></div></td></tr>');
            jQuery('#productsval').val(JSON.stringify(products));
            jQuery('#cancel_button').hide();
            jQuery('.table-responsive').show();
            jQuery('#save').show();
            jQuery('#first_add_more').html('<i class="fa fa-plus"></i> Add');
            jQuery('#product_code').val('');
            jQuery('.edit_link').show();
            jQuery('.delete_link').show();
            jQuery('#product_code').focus();
        }
    }

    function delete_product(current_item) {
        jQuery('#' + current_item).remove();
        delete_products[delete_counter] = products[current_item];
        delete_counter++;
        jQuery('#delete_products').val(JSON.stringify(delete_products));
        delete products[current_item];
        function isEmpty(obj) {
            for (var key in obj) {
                if (obj.hasOwnProperty(key))
                    return false;
            }
            return true;
        }

        jQuery('#productsval').val(JSON.stringify(products));
        if (isEmpty(products)) {
            numberofproducts = 0;
        }
    }

    function edit_product(current_item) {
        jQuery('#' + current_item).attr('style', 'display:none');
        jQuery('#save').attr('style', 'display:none');
        jQuery('#first_add_more').html('<i class="fa fa-plus"></i> update');
        jQuery('#cancel_button').show();
        jQuery('.edit_link').hide();
        jQuery('.delete_link').hide();
        global_id_to_edit = current_item;
        var temp_products = products[current_item];
        jQuery('#product_code').val(temp_products[0]);
        jQuery('#cancel_button').attr('style', 'display:inline');
        jQuery('#cancel_button').attr('style', 'background-color:red !important');
    }

    function cancel_all() {
        jQuery('#product_code').val('');
        jQuery('#cancel_button').hide();
        jQuery('#' + global_id_to_edit).show();
        jQuery('#save').show();
        jQuery('#first_add_more').html('<i class="fa fa-plus"></i> Add');
        global_id_to_edit = 0;
        jQuery('.edit_link').show();
        jQuery('.delete_link').show();
    }

    var edit_products = {};
    edit_products = '@json($edit_products)';

    $.each(edit_products, function (index, value) {
        if (global_id_to_edit != 0) {
            jQuery('#' + global_id_to_edit).remove();
            delete products[global_id_to_edit];
        }

        counter++;
        numberofproducts = Object.keys(products).length;

        if (numberofproducts == 0) {
            jQuery('#table_body').html();
        }

        products[counter] = [value];
        numberofproducts = Object.keys(products).length;

        jQuery('#table_body').append('<tr id=' + counter + ' class="edit_update"><td class="text-center tbl_srl_100">' + value + '<div class="edit_update_bx"><a class="edit_link btn btn-sm btn-success" href="#" onclick=edit_product(' + counter + ')><i class="fa fa-edit"></i></a><a href="#" class="delete_link btn btn-sm btn-danger" onclick=delete_product(' + counter + ')><i class="fa fa-trash"></i></a></div></td></tr>');
        jQuery('#productsval').val(JSON.stringify(products));
        jQuery('#cancel_button').hide();
        jQuery('.table-responsive').show();
        jQuery('#save').show();
        jQuery('#first_add_more').html('<i class="fa fa-plus"></i> Add');
        jQuery('#product_code').val('');
        jQuery('.edit_link').show();
        jQuery('.delete_link').show();
        jQuery('#product_code').focus();
    });

    jQuery(document).ready(function () {
        alert('asd');
        jQuery('#product_parent_code').select2();
        jQuery('#product_parent_name').select2();
        jQuery('#product_parent_code').append('{!! $product_code !!}');
        jQuery('#product_parent_name').append('{!! $product_name !!}');
    });

    var x = document.getElementById('f1');
    if (x != null && x != 'undefined') {
        x.addEventListener('focus', prvntDflt, true);
        x.addEventListener('blur', prvntDflt, true);
    }

    function prvntDflt(e) {
        if (document.forms['f1']['save'].hasAttribute('disabled')) {
            document.forms['f1']['save'].removeAttribute('disabled');
        }
        e.preventDefault();
    }

    $(document).ready(function () {
        $('#f1').validate();
    });
</script>

</body>
</html>


