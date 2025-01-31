@extends('extend_index')

@section('content')

    <div class="row">
            <div class="container-fluid search-filter form-group form_manage" id="">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Child Account List</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

                {{--                    <div class="search_form {{ ( !empty($search) || !empty($search_first_level_account) || !empty($search_second_level_account) ) ? '' : 'search_form_hidden' }}"><!-- search form start -->--}}

                <div class="search_form m-0 p-0"><!-- search form start -->
                    <form class="highlight prnt_lst_frm" action="{{ route('third_level_chart_of_account_list') . ((isset($restore_list) && $restore_list == 1) ? '?restore_list=1' : '') }}"
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
                                        @foreach($account_titles as $value)
                                            <option value="{{$value}}">
                                        @endforeach
                                    </datalist>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div> <!-- left column ends here -->
                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        Select Control Account
                                    </label>
                                    <select tabindex="2" class="inputs_up form-control cstm_clm_srch" name="first_level" id="first_level">
                                        <option value="">Select Control Account</option>
                                        @foreach($first_level_accounts as $first_level_account)
                                            <option
                                                value="{{$first_level_account->coa_code}}" {{ $first_level_account->coa_code == $search_first_level_account ? 'selected="selected"' : '' }}>{{$first_level_account->coa_head_name}}</option>
                                        @endforeach
                                    </select>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div>
                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        Select Parent Account
                                    </label>
                                    <select class="inputs_up form-control cstm_clm_srch" name="second_level" id="second_level">
                                        <option tabindex="3" value="">Select Parent Account</option>
                                        @foreach($second_level_accounts as $second_level_account)
                                            <option
                                                value="{{$second_level_account->coa_code}}" {{ $second_level_account->coa_code == $search_second_level_account ? 'selected="selected"' : '' }}>{{$second_level_account->coa_head_name}}</option>
                                        @endforeach
                                    </select>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 mt-4 text-right form_controls">
                            @include('include.clear_search_button')
                            <!-- Call add button component -->
                                <x-add-button tabindex="9" href="{{ route('add_third_level_chart_of_account') }}"/>
                                @include('include/print_button')
                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                            </div>
                        </div>
                    </form>
                    <form name="edit" id="edit" action="{{ route('edit_third_level_chart_of_account') }}" method="post">
                        @csrf
                        <input tabindex="-1" name="account_id" id="account_id" type="hidden">
                    </form>
                    <form name="delete" id="delete" action="{{ route('delete_third_level_chart_of_account') }}" method="post">
                        @csrf
                        <input tabindex="-1" name="account_code" id="del_account_code" type="hidden">
                        <input tabindex="-1" name="account_id" id="del_account_id" type="hidden">
                    </form>
                </div><!-- search form end -->
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
                            <th scope="col" class="tbl_amnt_10">
                                Code
                            </th>
                            <th scope="col" class="tbl_txt_10">
                                Control Account
                            </th>
                            <th scope="col" class="tbl_txt_10">
                                Parent Account
                            </th>
                            <th scope="col" class="tbl_txt_20">
                                Child Account
                            </th>
                            <th scope="col" class="tbl_txt_30">
                                Remarks
                            </th>
                            <th scope="col" class="tbl_srl_6 hide_column">
                                Enable
                            </th>
                            <th scope="col" class="tbl_srl_6 hide_column">
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
                        @forelse($datas as $data)

                            <tr data-account_id="{{$data->coa_id}}">
                                <th scope="row" class="edit ">
                                {{$sr}}
                                </td>
                                <td class="edit ">
                                    {{$data->coa_id}}
                                </td>
                                <td class="edit ">
                                    {{$data->coa_code}}
                                </td>
                                <td class="edit ">
                                    <?php if (substr($data->coa_code, 0, 1) == 1) {
                                        echo 'Asset';
                                    } elseif (substr($data->coa_code, 0, 1) == 2) {
                                        echo 'Liability';
                                    } elseif (substr($data->coa_code, 0, 1) == 3) {
                                        echo 'Revenue';
                                    } elseif (substr($data->coa_code, 0, 1) == 4) {
                                        echo 'Expense';
                                    } else {
                                        echo 'Equity';
                                    } ?>
                                </td>
                                <td class="edit ">
                                    {{$data->first_level_name}}
                                </td>
                                <td class="edit ">
                                    {{$data->second_level_name }}
                                </td>
                                <td class="edit ">
                                    {{$data->coa_remarks }}
                                </td>

                                {{--    add code by mustafa start --}}
                                <td class="hide_column text-center">
                                    <label class="switch">
                                        <input type="checkbox" <?php if ($data->coa_disabled == 0) {
                                            echo 'checked="true"' . ' ' . 'value=' . $data->coa_disabled;
                                        } else {
                                            echo 'value=DISABLE';
                                        } ?>  class="enable_disable" data-id="{{$data->coa_id}}"
                                            {{ $data->coa_disabled == 0 ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                {{--    add code by mustafa end --}}

                                <td class="hide_column  text-center">
                                    <a data-account_code="{{$data->coa_code}}" data-account_id="{{$data->coa_id}}" class="delete" data-toggle="tooltip" data-placement="left" title=""
                                       data-original-title="Are you sure?">
                                        <i class="fa fa-{{$data->coa_delete_status == 1 ? 'undo':'trash'}}"></i>
                                    </a>
                                </td>

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
                        <span class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search, 'first_level'=>$search_first_level_account, 'second_level'=>$search_second_level_account ])->links() }} </span>
                    </div>
                </div>
            </div> <!-- white column form ends here -->
   </div><!-- row end -->

@endsection

@section('scripts')



    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('third_level_chart_of_account_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}


    {{--    add code by mustafa start --}}
    <script>

        $(document).ready(function () {
            $('.enable_disable').change(function () {
                let status = $(this).prop('checked') === true ? 0 : 1;
                let coaId = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('enable_disable_account_heads') }}',
                    data: {'status': status, 'coa_id': coaId},
                    success: function (data) {
                        console.log(data.message);
                    }
                });
            });
        });
    </script>
    {{--    add code by mustafa end --}}

    <script>

        jQuery(".edit").click(function () {

            var account_id = jQuery(this).parent('tr').attr("data-account_id");

            jQuery("#account_id").val(account_id);
            jQuery("#edit").submit();
        });

        $('.delete').on('click', function (event) {

            var account_code = jQuery(this).attr("data-account_code");
            var account_id = jQuery(this).attr("data-account_id");

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
                    jQuery("#del_account_code").val(account_code);
                    jQuery("#del_account_id").val(account_id);
                    jQuery("#delete").submit();
                } else {

                }
            });
        });

    </script>

    <script>
        jQuery("#cancel").click(function () {

            $("#first_level").select2().val(null).trigger("change");
            $("#first_level > option").removeAttr('selected');

            $("#second_level").select2().val(null).trigger("change");
            $("#second_level > option").removeAttr('selected');

            $("#search").val('');
        });
    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#first_level").select2();
            jQuery("#second_level").select2();
        });
    </script>

@endsection

