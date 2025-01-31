
@extends('extend_index')

@section('content')

    <div class="row">

        @php
            $company_info = Session::get('company_info');
            if(isset($company_info) || !empty($company_info)){
                $win = $company_info->info_bx;
            }else{
                $win = '';
            }

        @endphp
        <div class="col-xs-12 col-sm-12 col-md-12 {{ ($win === 'full') ? 'col-lg-12 col-xl-12' : 'col-lg-9 col-xl-9' }} " id="main_col" data-win="{{ ($win === 'full') ? 'min' : 'full' }} " data-win-time="0">

            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">

                <div class="close_info_bx"><!-- info bx start -->
                    <i class="fa fa-expand"></i>
                </div><!-- info bx end -->

                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Project List</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

                <!-- <div class="search_form {{ ( !empty($search) || !empty($search_to) || !empty($search_from) ) ? '' : 'search_form_hidden' }}"> -->
             

                <div class="">
                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                            <form class="prnt_lst_frm" action="{{ route('project_creation_list') }}" name="form1" id="form1" method="post">
                                @csrf
                                <div class="row">

                                    <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>
                                                All Column Search
                                            </label>
                                            <input type="search" class="inputs_up form-control" name="search" id="search" placeholder="Search ..." value="{{ isset($search) ? $search : '' }}" autocomplete="off">
                                            <datalist id="browsers">
                                                @foreach($project_title as $value)
                                                    <option value="{{$value}}">
                                                @endforeach
                                            </datalist>
                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                        </div>
                                    </div> <!-- left column ends here -->

                                    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 srch_brdr_left">

                                        <div class="row">
                                            <div class="form-group col-lg-2 col-md-6 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Party
                                                    </label>
                                                    <select class="inputs_up form-control cstm_clm_srch" name="party" id="party" style="width: 90%">
                                                        <option value="">Select Party</option>
                                                        @foreach($accounts as $account)
                                                            <option value="{{$account->account_uid}}" {{ $account->account_uid == $search_party ? 'selected="selected"' : '' }}>{{$account->account_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>

                                            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 mt-lg-2">
                                                <div class="form_controls text-center text-lg-left">

                                                    <button type="button" type="button" name="cancel" id="cancel" class="cancel_button form-control">
                                                        <i class="fa fa-trash"></i> Clear
                                                    </button>
                                                    <button type="submit" name="filter_search" id="filter_search" class="save_button form-control" value="">
                                                        <i class="fa fa-search"></i> Search
                                                    </button>

                                                    <a class="save_button form-control" href="{{ route('add_project_creation') }}" role="button">
                                                        <i class="fa fa-plus"></i> Project
                                                    </a>
{{--                                                    <a class="save_button form-control" href="{{ route('journal_voucher_bank') }}" role="button">--}}
{{--                                                        <i class="fa fa-plus"></i> Bank Journal Voucher--}}
{{--                                                    </a>--}}

                                                    @include('include/print_button')

                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

{{--                            <form name="edit" id="edit" action="{{ route('edit_account') }}" method="post">--}}
{{--                                @csrf--}}
{{--                                <input name="account_id" id="account_id" type="hidden">--}}
{{--                            </form>--}}

                            <form name="delete" id="delete" action="{{ route('delete_project_creation') }}" method="post">
                                @csrf
                                <input name="project_id" id="del_project_id" type="hidden">
                            </form>
                        </div>

                    </div>
                </div><!-- search form end -->



                <div class="table-responsive" id="printTable">
                    <table class="table table-sm" id="fixTable">

                        <thead>
                        <tr>
                            <th scope="col" align="center" class="text-center align_center tbl_srl_4">
                                Sr#
                            </th>
                            <th scope="col" align="center" class="align_center text-center tbl_amnt_16">
                                Project Name
                            </th>
                            <th scope="col" align="center" class="align_center text-center tbl_amnt_15">
                                Party
                            </th>
                            <th scope="col" align="center" class="align_center text-center tbl_txt_15">
                                Party Reference
                            </th>
{{--                            <th scope="col" align="center" class="align_center text-center tbl_txt_15">--}}
{{--                              Remarks--}}
{{--                            </th>--}}
                            <th scope="col" align="center" class="align_center text-center tbl_amnt_10">
                                Total Expanse Budget
                            </th>
                            <th scope="col" align="center" class="align_center text-center tbl_amnt_10">
                                Total Material Budget
                            </th>

                            <th scope="col" align="center" class="align_center text-center tbl_amnt_10">
                                Grand Total
                            </th>

                            <th scope="col" align="center" class="text-center align_center tbl_txt_8">
                                Created By
                            </th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_6">
                                Enable
                            </th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_6">
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
                            $dr_pg = $cr_pg = 0;
                        @endphp
                        @forelse($datas as $project)


                            <tr >
                                <td class="align_center text-center edit tbl_srl_4">
                                    {{$sr}}
                                </td>
                                <td class="view align_center text-center tbl_amnt_16" data-toggle="tooltip" data-placement="top" title="" data-original-title="View Project Items" data-ids="{{$project->pc_id}}">
                                    {{$project->pc_name}}
                                </td>

                                <td class="align_center text-center tbl_amnt_15">
                                {{ $project->account_name}}
                                </td>
                                <td class="align_center text-center tbl_amnt_15">
                                {{ $project->pc_party_reference}}
                                </td>

                                {{--                                    <td class="align_left">{{$project->jv_remarks}}</td>--}}
{{--                                <td class="align_left text-left tbl_txt_15">--}}
{{--                                    {{ $project->pc_remarks }}--}}
{{--                                </td>--}}

                                <td class="viewExp align_right text-right tbl_amnt_10" data-toggle="tooltip" data-placement="top" title="" data-original-title="View Project Expense Budget" data-ids="{{$project->pc_id}}">
                                    {{$project->pc_eb_total_price}}
                                </td>
                                <td class="viewMaterial align_right text-right tbl_amnt_10" data-toggle="tooltip" data-placement="top" title="" data-original-title="View Project Material Budget" data-ids="{{$project->pc_id}}">
                                    {{$project->pc_mb_total_price}}
                                </td>
                                <td class="align_right text-right tbl_amnt_10">
                                    {{$project->pc_po_grand_total}}
                                </td>

                                @php
                                    $ip_browser_info= ''.$project->pc_ip_adrs.','.str_replace(' ','-',$project->pc_brwsr_info).'';
                                @endphp

                                <td class="align_left text-left usr_prfl tbl_txt_8" data-usr_prfl="{{ $project->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                    {{$project->user_name}}
                                </td>

                                <td class="align_right text-right hide_column tbl_amnt_6">
                                    <label class="switch">
                                        <input type="checkbox" <?php if ($project->pc_disabled == 0) {
                                            echo 'checked="true"' . ' ' . 'value=' . $project->pc_disabled;
                                        } else {
                                            echo 'value=DISABLE';
                                        } ?>  class="enable_disable" data-id="{{$project->pc_id}}"
                                            {{ $project->pc_disabled == 0 ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </label>
                                </td>

                                <td class="align_center  text-right hide_column tbl_srl_6">
                                    <a data-project_id="{{$project->pc_id}}" class="delete" data-toggle="tooltip" data-placement="left" title="" data-original-title="Are you sure?">
                                        <i class="fa fa-{{$project->pc_delete_status == 1 ? 'undo':'trash'}}"></i>
                                        {{--                                            <i class="fa fa-trash"></i>--}}
                                    </a>
                                </td>

                            </tr>
                            @php
                                $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="11">
                                    <center><h3 style="color:#554F4F">No Project</h3></center>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>

{{--                        <tfoot>--}}
{{--                        <tr class="border-0">--}}
{{--                            <th colspan="4" align="right" class="border-0 text-right align_right pt-0">--}}
{{--                                Page Total:--}}
{{--                            </th>--}}
{{--                            <td class="text-right border-left-0" align="right" style="border-right: 0px solid transparent;">--}}
{{--                                {{ number_format($dr_pg,2) }}--}}
{{--                            </td>--}}
{{--                            <td class="text-right border-left-0" align="right" style="border-right: 0px solid transparent;">--}}
{{--                                {{ number_format($cr_pg,2) }}--}}
{{--                            </td>--}}
{{--                        </tr>--}}
{{--                        <tr class="border-0">--}}
{{--                            <th colspan="4" align="right" class="border-0 text-right align_right pt-0">--}}
{{--                                Grand Total:--}}
{{--                            </th>--}}
{{--                            <td class="text-right border-left-0" align="right" style="border-top: 1px solid #000;border-bottom: 3px double #000;border-right: 0px solid transparent;">--}}
{{--                                {{ number_format($ttl_dr,2) }}--}}
{{--                            </td>--}}
{{--                            <td class="text-right border-left-0" align="right" style="border-top: 1px solid #000;border-bottom: 3px double #000;border-right: 0px solid transparent;">--}}
{{--                                {{ number_format($ttl_cr,2) }}--}}
{{--                            </td>--}}
{{--                        </tr>--}}
{{--                        </tfoot>--}}

                    </table>
                </div>
                <span class="hide_column">  {{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search, 'party'=>$search_party])->links() }}</span>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content base_clr">
                <div class="modal-header">
                    <h4 class="modal-title text-black">Project Detail</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="itm_vchr form_manage">
                        <div class="form_header">
                            <h4 class="text-white file_name">
                                <span class="db sml_txt"> Product #: </span>
                            </h4>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col" align="center" class="wdth_5">Account No.</th>
                                    <th scope="col" align="center" class="wdth_2">Account Name</th>
                                    <th scope="col" align="center" class="wdth_5 text-right">Dr.</th>
                                    <th scope="col" align="center" class="wdth_5 text-right">Cr.</th>
                                </tr>
                                </thead>
                                <tbody id="table_body">
                                </tbody>
                                <tfoot id="table_foot">
                                </tfoot>
                            </table>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form_controls">
                            <button type="button" class="btn btn-default form-control cancel_button" data-dismiss="modal">
                                <i class="fa fa-times"></i> Cancel
                            </button>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <!-- Expense Modal -->
    <div class="modal fade" id="myExpModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content base_clr">
                <div class="modal-header">
                    <h4 class="modal-title text-black">Expense Budget Detail</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="itm_vchr form_manage">
                        <div class="form_header">
                            <h4 class="text-white file_name">
                                <span class="db sml_txt"> Product #: </span>
                            </h4>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col" align="center" class="wdth_5">Account No.</th>
                                    <th scope="col" align="center" class="wdth_2">Account Name</th>
                                    <th scope="col" align="center" class="wdth_5 text-right">Dr.</th>
                                    <th scope="col" align="center" class="wdth_5 text-right">Cr.</th>
                                </tr>
                                </thead>
                                <tbody id="table_body">
                                </tbody>
                                <tfoot id="table_foot">
                                </tfoot>
                            </table>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form_controls">
                            <button type="button" class="btn btn-default form-control cancel_button" data-dismiss="modal">
                                <i class="fa fa-times"></i> Cancel
                            </button>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <!-- Material Modal -->
    <div class="modal fade" id="myModalMaterial" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content base_clr">
                <div class="modal-header">
                    <h4 class="modal-title text-black">Material Budget Detail</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="itm_vchr form_manage">
                        <div class="form_header">
                            <h4 class="text-white file_name">
                                <span class="db sml_txt"> Product #: </span>
                            </h4>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col" align="center" class="wdth_5">Account No.</th>
                                    <th scope="col" align="center" class="wdth_2">Account Name</th>
                                    <th scope="col" align="center" class="wdth_5 text-right">Dr.</th>
                                    <th scope="col" align="center" class="wdth_5 text-right">Cr.</th>
                                </tr>
                                </thead>
                                <tbody id="table_body">
                                </tbody>
                                <tfoot id="table_foot">
                                </tfoot>
                            </table>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form_controls">
                            <button type="button" class="btn btn-default form-control cancel_button" data-dismiss="modal">
                                <i class="fa fa-times"></i> Cancel
                            </button>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection

@section('scripts')

    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('journal_voucher_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}
    <script>

        $(document).ready(function () {
            $("#party").select2();
            $('.enable_disable').change(function () {
                let status = $(this).prop('checked') === true ? 0 : 1;
                let pcId = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('enable_disable_project') }}',
                    data: {'status': status, 'pc_id': pcId},
                    success: function (data) {
                        console.log(data.message);
                    }
                });
            });
        });
    </script>
    <script>
        // jQuery("#invoice_no").blur(function () {

        jQuery(".view").click(function () {

            jQuery("#table_body").html("");

            var id = jQuery(this).attr("data-ids");

            $(".modal-body").load('{{ url("project_items_view_details/view/") }}/'+id,function () {
                $("#myModal").modal({show:true});
            });

        });

        jQuery(".viewExp").click(function () {

            jQuery("#table_body").html("");

            var id = jQuery(this).attr("data-ids");

            $(".modal-body").load('{{ url("expense_items_view_details/view/") }}/'+id,function () {
                $("#myExpModal").modal({show:true});
            });

        });

        jQuery(".viewMaterial").click(function () {

            jQuery("#table_body").html("");

            var id = jQuery(this).attr("data-ids");

            $(".modal-body").load('{{ url("material_items_view_details/view/") }}/'+id,function () {
                $("#myModalMaterial").modal({show:true});
            });

        });
    </script>

    <script>
        jQuery(".edit").click(function () {

            var account_id = jQuery(this).attr("data-id");

            jQuery("#account_id").val(account_id);
            jQuery("#edit").submit();
        });

        $('.delete').on('click', function (event) {

            var project_id = jQuery(this).attr("data-project_id");

            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Yes',
            }).then(function(result) {

                if (result.value) {
                    jQuery("#del_project_id").val(project_id);
                    jQuery("#delete").submit();
                } else {

                }
            });
        });

    </script>

    <script>
        jQuery("#cancel").click(function () {

            $("#search").val('');
            $("#party").select2().val(null).trigger("change");
            $("#party > option").removeAttr('selected');

        });
    </script>

@endsection

