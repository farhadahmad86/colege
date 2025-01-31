@extends('extend_index')

@section('content')

    <div class="row">
        <div class="container-fluid search-filter form-group form_manage" id="">
            <div class="form_header"><!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="text-white get-heading-text file_name">Trade Product Package List</h4>
                    </div>
                    <div class="list_btn list_mul">
                        <div class="srch_box_opn_icon">
                            <i class="fa fa-search"></i>
                        </div>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->
        <!-- <div class="search_form {{ ( !empty($search) || !empty($search_product) || !empty($search_to) || !empty($search_from) ) ? '' : 'search_form_hidden' }}"> -->

            <div class="search_form m-0 p-0">
                <form class="highlight prnt_lst_frm" action="{{ route('trade_product_packages_list') . ((isset($restore_list) && $restore_list == 1) ? '?restore_list=1' : '') }}" name="form1"
                      id="form1" method="post">
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
                                    @foreach($packages_name as $value)
                                        <option value="{{$value}}">
                                    @endforeach
                                </datalist>
                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                            </div>
                        </div> <!-- left column ends here -->

                        <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                            <div class="input_bx"><!-- start input box -->
                                <label>
                                    Select Package
                                </label>
                                <select tabindex="2" class="inputs_up form-control" name="product_code" id="product_code">
                                    <option value="">Select Package Name</option>
                                    @foreach($packages_name as $value)
                                        <option value="{{$value}}" {{$value == $search_product ? 'selected' : ''}}>
                                            {{$value}}
                                        </option>
                                    @endforeach
                                </select>
                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                            </div>
                        </div>

                        <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                            <div class="input_bx"><!-- start input box -->
                                <label>
                                    Start Date
                                </label>
                                <input tabindex="3" type="text" name="to" id="to" class="inputs_up form-control datepicker1" autocomplete="off"
                                       <?php if(isset($search_to)){?> value="{{$search_to}}" <?php } ?> placeholder="Start Date ......"/>
                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                            </div>
                        </div>

                        <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                            <div class="input_bx"><!-- start input box -->
                                <label>
                                    End Date
                                </label>
                                <input tabindex="4" type="text" name="from" id="from" class="inputs_up form-control datepicker1" autocomplete="off"
                                       <?php if(isset($search_from)){?> value="{{$search_from}}" <?php } ?> placeholder="End Date ......"/>
                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 form_controls text-right mt-4">
                        @include('include.clear_search_button')
                        <!-- Call add button component -->
                            <x-add-button tabindex="9" href="{{ route('trade_product_packages') }}"/>
                            @include('include/print_button')
                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                        </div>


                    </div>
                </form>


                <form name="edit" id="edit" action="{{ route('edit_trade_product_packages') }}" method="post">
                    @csrf
                    <input tabindex="-1" name="package_id" id="package_id" type="hidden">
                </form>

                <form name="delete" id="delete" action="{{ route('delete_trade_product_packages') }}" method="post">
                    @csrf
                    <input tabindex="-1" name="del_package_id" id="del_package_id" type="hidden">
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
                        <th scope="col" class="tbl_amnt_8">
                            Date
                        </th>
                        <th scope="col" class="tbl_txt_16">
                            Package Name
                        </th>
                        <th scope="col" class="tbl_txt_27">
                            Remarks
                        </th>
                        <th scope="col" class="tbl_amnt_8">
                            Total Items
                        </th>
                        <th scope="col" class="tbl_amnt_15">
                            Total Price
                        </th>
                        <th scope="col" class="tbl_txt_8">
                            Created By
                        </th>
                        <th scope="col" class="hide_column tbl_srl_4">
                            Enable
                        </th>
                        <th scope="col" class="hide_column tbl_srl_4">
                            Delete
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
                    @forelse($datas as $package)

                        <tr data-package_id="{{$package->pp_id}}">
                            <td class="edit tbl_srl_4">
                                {{$sr}}
                            </td>
                            <td class="edit tbl_srl_4">
                                {{$package->pp_id}}
                            </td>
                            <td class="tbl_amnt_8">
                                {{date('d-M-y', strtotime(str_replace('/', '-', $package->pp_datetime)))}}
                            </td>
                            <td class="edit tbl_txt_16">
                                {{$package->pp_name}}
                            </td>
                            <td class="edit tbl_txt_27">
                                {{$package->pp_remarks}}
                            </td>
                            <td class="edit tbl_amnt_8">
                                {{$package->pp_total_items}}
                            </td>
                            <td class="text-right edit tbl_amnt_15">
                                {{number_format($package->pp_total_price,2)}}
                            </td>

                            @php
                                $ip_browser_info= ''.$package->pp_ip_adrs.','.str_replace(' ','-',$package->pp_brwsr_info).'';
                            @endphp

                            <td class="usr_prfl tbl_txt_8" data-usr_prfl="{{ $package->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                {{ $package->user_name }}
                            </td>


                            {{--    add code by mustafa start --}}
                            <td class="text-right hide_column tbl_amnt_6">
                                <label class="switch">
                                    <input type="checkbox" <?php if ($package->pp_disabled == 0) {
                                        echo 'checked="true"' . ' ' . 'value=' . $package->pp_disabled;
                                    } else {
                                        echo 'value=DISABLE';
                                    } ?>  class="enable_disable" data-id="{{$package->pp_id}}"
                                        {{ $package->pp_disabled == 0 ? 'checked' : '' }}>
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            {{--    add code by mustafa end --}}


                            <td class="hide_column tbl_srl_4">
                                <a data-package_id="{{$package->pp_id}}" class="delete" data-toggle="tooltip" data-placement="left" title=""
                                   data-original-title="Are you sure?">
                                    <i class="fa fa-{{$package->pp_delete_status == 1 ? 'undo':'trash'}}"></i>
                                </a>
                            </td>


                        </tr>
                        @php
                            $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
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
            <div class="row">
                <div class="col-md-3">
                    <span>Showing {{$datas->firstItem()}} - {{$datas->lastItem()}} of {{$datas->total()}}</span>
                </div>
                <div class="col-md-9 text-right">
                    <span
                        class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search, 'product_code'=>$search_product, 'to'=>$search_to, 'from'=>$search_from ])->links() }}</span>
                </div>
            </div>
        </div> <!-- white column form ends here -->
    </div><!-- row end -->

@endsection

@section('scripts')

    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('trade_product_packages_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    {{--    add code by mustafa start --}}
    <script>

        $(document).ready(function () {
            $('.enable_disable').change(function () {
                let status = $(this).prop('checked') === true ? 0 : 1;
                let ppId = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('enable_disable_product_package') }}',
                    data: {'status': status, 'pp_id': ppId},
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
            var package_id = jQuery(this).parent('tr').attr("data-package_id");

            jQuery("#package_id").val(package_id);
            jQuery("#edit").submit();
        });

        $('.delete').on('click', function (event) {

            var package_id = jQuery(this).attr("data-package_id");

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
                    jQuery("#del_package_id").val(package_id);
                    jQuery("#delete").submit();
                } else {

                }
            });
        });


    </script>

    <script>
        jQuery("#cancel").click(function () {

            $("#to").val('');
            $("#from").val('');

            $("#product_code").select2().val(null).trigger("change");
            $("#product_code > option").removeAttr('selected');

            $("#search").val('');
        });
    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#product_code").select2();

        });
    </script>

@endsection

