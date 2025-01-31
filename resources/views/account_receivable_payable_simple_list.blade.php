@extends('extend_index')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Client/Supplier Information</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

                <div class="search_form m-0 p-0">
                    <form class="highlight prnt_lst_frm" action="{{ route('account_receivable_payable_simple_list') . ((isset($restore_list) && $restore_list == 1) ? '?restore_list=1' : '') }}"
                          name="form1" id="form1" method="post">
                        @csrf
                        <div class="row">
                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        All Column Search
                                    </label>
                                    <input tabindex="1" autofocus type="search" list="browsers" class="inputs_up form-control all_clm_srch" name="search" id="search" placeholder="Search ..."
                                           value="{{ isset($search) ? $search : '' }}" autocomplete="off">
                                    <datalist id="browsers">
                                        @foreach($account_list as $value)
                                            <option value="{{$value}}">
                                        @endforeach
                                    </datalist>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div><!-- end input box -->
                            </div>
                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        Select Region
                                    </label>
                                    <select tabindex="2" class="inputs_up form-control cstm_clm_srch" name="region" id="region" style="width: 90%">
                                        <option value="">Select Region</option>
                                        @foreach($regions as $region)
                                            <option value="{{$region->reg_id}}" {{ $region->reg_id == $search_region ? 'selected="selected"' : '' }}>{{$region->reg_title}}</option>
                                        @endforeach
                                    </select>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div>

                            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">

                                <div class="row">


                                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label class="required">
                                                Select Area
                                            </label>
                                            <select tabindex="3" class="inputs_up form-control cstm_clm_srch" name="area" id="area" style="width: 90%">
                                                <option value="">Select Area</option>
                                                @foreach($areas as $area)
                                                    <option value="{{$area->area_id}}" {{ $area->area_id == $search_area ? 'selected="selected"' : '' }}>{{$area->area_title}}</option>
                                                @endforeach
                                            </select>
                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label class="required">
                                                Select Sector
                                            </label>
                                            <select tabindex="4" class="inputs_up form-control cstm_clm_srch" name="sector" id="sector" style="width: 90%">
                                                <option value="">Select Sector</option>
                                                @foreach($sectors as $sector)
                                                    <option value="{{$sector->sec_id}}" {{ $sector->sec_id == $search_sector ? 'selected="selected"' : '' }}>{{$sector->sec_title}}</option>
                                                @endforeach
                                            </select>
                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label class="required">
                                                Select Ledger Access Group
                                            </label>
                                            <select tabindex="5" class="inputs_up form-control cstm_clm_srch" name="group" id="group" style="width: 90%">
                                                <option value="">Select Account Ledger Access Group</option>
                                                @foreach($groups as $group)
                                                    <option value="{{$group->ag_id}}" {{ $group->ag_id == $search_group ? 'selected="selected"' : '' }}>{{$group->ag_title}}</option>
                                                @endforeach
                                            </select>
                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label class="required">
                                                Select Sale Person
                                            </label>
                                            <select tabindex="5" class="inputs_up form-control cstm_clm_srch" name="sale_person" id="sale_person" style="width: 90%">
                                                <option value="">Select Sale Person</option>
                                                @foreach($sale_persons as $sale_person)
                                                    <option
                                                        value="{{$sale_person->user_id}}" {{ $sale_person->user_id == $search_sale_persons ? 'selected="selected"' : '' }}>{{$sale_person->user_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div hidden class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>
                                                Select Date
                                            </label>
                                            <input tabindex="6" type="text" name="date" id="date" class="inputs_up form-control datepicker1" autocomplete="off"
                                                   <?php if(isset($search_date)){?> value="{{$search_date}}" <?php } ?> placeholder="End Date ......"/>
                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-lg-4 text-right">
                                @include('include.clear_search_button')

                                <!-- Call add button component -->
                                    <x-add-button tabindex="9" href="{{ route('receivables_account_registration') }}"/>
                                @include('include/print_button')

                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                            </div>
                        </div><!-- end row -->
                    </form>

                    <form class="hidden" action="{{ route('account_receivable_payable_list') }}" name="form" id="form" method="post">
                        @csrf
                        <fieldset>
                            <legend>Get All Data:</legend>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <button tabindex="-1" type="submit" name="save" id="save" class="save_button form-control m-0 fl_srch_btn">
                                        <i class="fa fa-search"></i> All Data
                                    </button>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div> <!-- right columns ends here -->
                        </fieldset>
                    </form>

                    <form name="edit_receivable_payable" id="edit_receivable_payable" action="{{ route('edit_account_receivable_payable') }}" method="post">
                        @csrf
                        <input tabindex="-1" name="acc_id" id="accounts_id" type="hidden">
                        <input tabindex="-1" name="account_type" id="account_type" type="hidden">
                    </form>

                    <form name="ledger" id="ledger" action="{{ route('account_ledger') }}" method="post" target="_blank">
                        @csrf
                        <input tabindex="-1" name="account_id" id="account_id" type="hidden">
                        <input tabindex="-1" name="account_name" id="account_name" type="hidden">

                    </form>

                    <form name="delete" id="delete" action="{{ route('delete_account') }}" method="post">
                        @csrf
                        <input tabindex="-1" name="account_id" id="del_account_id" type="hidden">
                        <input tabindex="-1" name="parent_account_id" id="del_parent" type="hidden">
                    </form>
                </div>


                <div class="table-responsive" id="printTable">

                    <table class="table table-bordered table-sm" id="fixTable">

                        <thead>
                        <tr>
                            <th scope="col" class="tbl_srl_4">
                                Sr#
                            </th>
                            <th scope="col" class="tbl_srl_4">
                                ID
                            </th>
                            <th scope="col" class="tbl_txt_8">
                                Head
                            </th>
                            <th scope="col" class="tbl_amnt_9">
                                Id
                            </th>
                            <th scope="col" class="tbl_txt_10">
                                Region
                            </th>
                            <th scope="col" class="tbl_txt_10">
                                Area
                            </th>
                            <th scope="col" class="tbl_txt_10">
                                Sector
                            </th>
                            <th scope="col" class="tbl_txt_10">
                                Name
                            </th>
                            <th scope="col" class="tbl_txt_10">
                                Email
                            </th>
                            <th scope="col" class="tbl_txt_8">
                                Created By
                            </th>
                            <th scope="col" class="tbl_txt_10">
                                Sale Person
                            </th>
                            <th scope="col" class="hide_column tbl_amnt_6">
                                Make User/Not
                            </th>
                            {{-- <th scope="col" class="hide_column tbl_srl_6">
                                Enable
                            </th> --}}
                            <th scope="col" class="hide_column tbl_srl_6">
                                Action
                            </th>
                        </tr>
                        </thead>

                        <tbody>
                        @php
                            $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
                            $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
                            $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                            $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
                        @endphp
                        @forelse($datas as $index=> $account)

                            @if($account->account_type==0)

                            @elseif($account->account_type==1)
                                <tr data-id="{{$account->account_id}}" data-account_type="Receivable">

                            @else
                                <tr data-id="{{$account->account_id}}" data-account_type="Payable">
                                    @endif

                                    @php
                                        $rcv_pay = ($account->account_type == 1 || $account->account_type == 0) ? 'receivable' : 'payable';
                                    @endphp

                                    <th scope="row" class="edit {{ $rcv_pay }}">
                                        {{$sr}}
                                    </th>
                                    <th scope="row" class="edit {{ $rcv_pay }}">
                                        {{$account->account_id}}
                                    </th>

                                    <td class="{{ $rcv_pay }}">
                                        <?php if (substr($account->account_uid, 0, 1) == 1) {
                                            echo 'Asset';
                                        } elseif (substr($account->account_uid, 0, 1) == 2) {
                                            echo 'Liability';
                                        } elseif (substr($account->account_uid, 0, 1) == 3) {
                                            echo 'Revenue';
                                        } elseif (substr($account->account_uid, 0, 1) == 4) {
                                            echo 'Expense';
                                        } else {
                                            echo 'Equity';
                                        } ?>
                                    </td>

                                    <td class="{{ $rcv_pay }}">
                                        {{$account->account_uid}}
                                    </td>

                                    <td class=" {{ $rcv_pay }}">
                                        {{$account->reg_title}}
                                    </td>

                                    <td class="{{ $rcv_pay }}">
                                        {{$account->area_title}}
                                    </td>

                                    <td class=" {{ $rcv_pay }}">
                                        {{$account->sec_title}}
                                    </td>

                                    <td>
                                        {{$account->account_name}}
                                    </td>
                                    <td>
                                        {{$account->account_email}}
                                    </td>
                                    @php
                                        $ip_browser_info= ''.$account->account_ip_adrs.','.str_replace(' ','-',$account->account_brwsr_info).'';
                                    @endphp

                                    <td class="usr_prfl" data-usr_prfl="{{ $account->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                        {{ $account->user_name }}
                                    </td>
                                    <td class="edit {{ $rcv_pay }}">
                                        {{--                                        {{$account->ag_title}}--}}
                                        {{$account->sale_person_name}}
                                    </td>
                                    @php
                                        if($account->account_employee_id != 0){
         $employee= \Illuminate\Support\Facades\DB::table('financials_users')->where('user_id',$account->account_employee_id)->first();
    }

                                    @endphp
                                    {{-- <td class="text-center hide_column tbl_amnt_6">
                                        @if($account->account_employee_id != 0)
                                        <label class="switch">
                                            <input type="checkbox" <?php if ($employee->user_login_status == 'ENABLE') {
                                                echo 'checked="true"' . ' ' . 'value=' . $employee->user_login_status;
                                            } else {
                                                echo 'value=DISABLE';
                                            } ?>  class="enable_disable" data-emp_id="{{$employee->user_id}}" data-username="{{$employee->user_username}}" data-email="{{$employee->user_email}}"
                                                   data-group_id="{{$employee->user_account_reporting_group_ids}}" data-user_type="{{$employee->user_level}}" id="flag{{$sr}}">
                                            <span class="slider round"></span>
                                        </label>
                                            @endif --}}
                                    {{-- </td> --}}

                                    <td class="text-center hide_column">
                                        <label class="switch">
                                            <input type="checkbox" <?php if ($account->account_disabled == 0) {
                                                echo 'checked="true"' . ' ' . 'value=' . $account->account_disabled;
                                            } else {
                                                echo 'value=DISABLE';
                                            } ?>  class="enable_disable" data-id="{{$account->account_id}}"
                                                {{ $account->account_disabled == 0 ? 'checked' : '' }}>
                                            <span class="slider round"></span>
                                        </label>
                                    </td>

                                    {{--                            <td><a data-id="{{$account->account_uid}}" data-name="{{$account->account_name}}" class="ledger" style="cursor:pointer; color: #0099ff;">Ledger</a></td>--}}

                                    @if($account->account_type==0)

                                        {{--<td><a  data-id="{{$account->account_id}}" class="edit" style="cursor:pointer;"><i class="fa fa-edit"></i></a></td>--}}
                                    @elseif($account->account_type==1)
                                        {{--                                        <td class="ahide_column"><a data-id="{{$account->account_id}}" data-account_type="Receivable" class="receivable" style="cursor:pointer;"><i class="fa fa-edit"></i></a></td>--}}
                                        <td class="text-center hide_column">
                                            <a data-id="{{$account->account_uid}}" data-parent="{{$account->account_parent_code}}" class="delete">
                                                <i class="fa fa-{{$account->account_delete_status == 1 ? 'undo':'trash'}}"></i>
                                            </a>
                                        </td>
                                    @else
                                        {{--                                        <td class="ahide_column"><a data-id="{{$account->account_id}}" data-account_type="Payable" class="payable" style="cursor:pointer;"><i class="fa fa-edit"></i></a></td>--}}
                                        <td class="text-center hide_column">
                                            <a data-id="{{$account->account_uid}}" data-parent="{{$account->account_parent_code}}" class="delete">
                                                <i class="fa fa-{{$account->account_delete_status == 1 ? 'undo':'trash'}}"></i>
                                            </a>
                                        </td>
                                    @endif
                                </tr>
                                @php
                                    $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                                @endphp
                                @empty
                                    <tr>
                                        <td colspan="11">
                                            <center><h3 style="color:#554F4F">No Account</h3></center>
                                        </td>
                                    </tr>
                                @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <span>Showing {{$datas->firstItem()}} - {{$datas->lastItem()}} of {{$datas->total()}}</span>
                    </div>
                    <div class="col-md-9 text-right">
                <span
                    class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search,  'region'=>$search_region,  'area'=>$search_area,  'sector'=>$search_sector,  'group'=>$search_group,  'sale_person'=>$search_sale_persons, 'date'=>$search_date ])->links() }}</span>
                    </div>
                </div>
            </div> <!-- white column form ends here -->
        </div><!-- col end -->
    </div><!-- row end -->
@endsection
@section('scripts')
    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('account_receivable_payable_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}
    <script>
        $(document).ready(function () {
            $('.enable_disable').change(function () {
                let status = $(this).prop('checked') === true ? 0 : 1;
                let accountId = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('enable_disable_account') }}',
                    data: {'status': status, 'account_id': accountId},
                    success: function (data) {
                        console.log(data.message);
                    }
                });
            });
        });
        jQuery(".enable_disable").change(function () {
            var emp_id = jQuery(this).attr("data-emp_id");
            var username = jQuery(this).attr("data-username");
            var email = jQuery(this).attr("data-email");
            var status;
            var flag_id = "#" + this.id + "";
            if (jQuery(this).prop('checked') == true) {
                status = 'T';
            } else {
                status = 'F';
            }

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "enable_disable_user",
                data: {emp_id: emp_id, status: status, username: username, email: email},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {


                    if (data.trim() == 'no') {

                        jQuery(flag_id).prop('checked', false);
                    }

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });
    </script>

    <script>
        jQuery(".edit").click(function () {

            var account_id = jQuery(this).attr("data-id");

            jQuery("#acc_id").val(account_id);
            jQuery("#edit").submit();
        });

        $('.delete').on('click', function (event) {

            var account_id = jQuery(this).attr("data-id");
            var parent = jQuery(this).attr("data-parent");

            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Yes',
            }).then(function (result) {

                if (result.value) {
                    jQuery("#del_account_id").val(account_id);
                    jQuery("#del_parent").val(parent);
                    jQuery("#delete").submit();
                } else {

                }
            });
        });


        jQuery(".receivable").click(function () {

            var account_id = jQuery(this).parent('tr').attr("data-id");
            var account_type = jQuery(this).parent('tr').attr("data-account_type");

            jQuery("#accounts_id").val(account_id);
            jQuery("#account_type").val(account_type);
            jQuery("#edit_receivable_payable").submit();
        });

        jQuery(".payable").click(function () {

            var account_id = jQuery(this).parent('tr').attr("data-id");
            var account_type = jQuery(this).parent('tr').attr("data-account_type");

            jQuery("#accounts_id").val(account_id);
            jQuery("#account_type").val(account_type);
            jQuery("#edit_receivable_payable").submit();
        });

    </script>

    <script>
        jQuery(".ledger").click(function () {

            var account_id = jQuery(this).attr("data-id");
            var account_name = jQuery(this).attr("data-name");

            jQuery("#account_id").val(account_id);
            jQuery("#account_name").val(account_name);
            jQuery("#ledger").submit();
        });

        // jQuery('#product_code option[value="' + 0 + '"]').prop('selected', true);

        jQuery("#cancel").click(function () {

            $("#region").select2().val(null).trigger("change");
            $("#region > option").removeAttr('selected');

            $("#area").select2().val(null).trigger("change");
            $("#area > option").removeAttr('selected');

            $("#sector").select2().val(null).trigger("change");
            $("#sector > option").removeAttr('selected');

            $("#group").select2().val(null).trigger("change");
            $("#group > option").removeAttr('selected');

            $("#sale_person").select2().val(null).trigger("change");
            $("#sale_person > option").removeAttr('selected');

            $("#search").val('');
        });
    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#region").select2();
            jQuery("#area").select2();
            jQuery("#sector").select2();
            jQuery("#group").select2();
            jQuery("#sale_person").select2();
        });
    </script>

@endsection

