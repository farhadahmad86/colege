@extends('extend_index')
@section('styles_get')
    <style>
        .action_td .dropdown .dropdown-toggle::after {
            content: unset !important;
        }
    </style>
@stop
@section('content')

    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header">
                <!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="text-white get-heading-text file_name">Component List</h4>
                    </div>
                    <div class="list_btn list_mul">
                        <div class="srch_box_opn_icon">
                            <i class="fa fa-search"></i>
                        </div>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->
            {{--                    <!-- <div class="search_form {{ ( !empty($search) || !empty($search_region) ) ? '' : 'search_form_hidden' }}"> --> --}}
            {{--                    --}}
            <div class="search_form m-0 p-0">
                <form class="highlight prnt_lst_frm"
                      action="{{ route('component_list') }}"
                      name="form1" id="form1" method="post">
                    <div class="row">
                        @csrf
                        <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                            <div class="input_bx">
                                <label>
                                    All Data Search
                                </label>
                                <input tabindex="1" autofocus type="search" list="browsers"
                                       class="inputs_up form-control" name="search" id="search"
                                       placeholder="All Data Search" value="{{ isset($search) ? $search : '' }}"
                                       autocomplete="off">
                                <datalist id="browsers">
                                    @foreach ($component_title as $value)
                                        <option value="{{ $value }}">
                                    @endforeach
                                </datalist>
                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                            </div>
                        </div> <!-- left column ends here -->
                        <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                            <div class="input_bx">
                                <label>
                                    Credit Account
                                </label>
                                <select tabindex=42 autofocus name="cr_account" class="form-control"
                                        data-rule-required="true"
                                        data-msg-required="Please Enter Cr Account" id="cr_account">
                                    <option value="" disabled selected>Select Cr Account</option>
                                    @foreach ($accounts as $account)
                                        <option value="{{ $account->account_uid }}"
                                            {{ $account->account_uid == $search_cr_account ? 'selected' : '' }}>
                                            {{ $account->account_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                            </div>
                        </div> <!-- left column ends here -->
                        <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                            <div class="input_bx">
                                <label>
                                    Debit Account
                                </label>
                                <select tabindex=42 autofocus name="dr_account" class="form-control"
                                        data-rule-required="true"
                                        data-msg-required="Please Enter Dr Account" id="dr_account">
                                    <option value="" disabled selected>Select Dr Account</option>
                                    @foreach ($accounts as $account)
                                        <option value="{{ $account->account_uid }}"
                                            {{ $account->account_uid == $search_dr_account ? 'selected' : '' }}>
                                            {{ $account->account_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div> <!-- left column ends here -->

                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 text-right form_controls mt-2">
                            @include('include.clear_search_button')
                            <!-- Call add button component -->
                            <x-add-button tabindex="9" href="{{ route('create_component') }}"/>

                            @include('include/print_button')
                        </div>
                    </div><!-- end row -->
                </form>
                <form name="edit" id="edit" action="{{ route('edit_component') }}" method="post">
                    @csrf
                    <input name="sfc_id" id="sfc_id" type="hidden">
                    <input name="sfc_name" id="sfc_name" type="hidden">
                    <input name="sfc_amount" id="sfc_amount" type="hidden">
                    <input name="cr_acc_id" id="cr_acc_id" type="hidden">
                    <input name="dr_acc_id" id="dr_acc_id" type="hidden">
                </form>
                <form name="delete" id="delete" action="{{ route('delete_college_groups') }}" method="post">
                    @csrf
                    <input name="group_id" id="group_id" type="hidden">
                </form>
            </div>

            <div class="table-responsive" id="printTable">
                <table class="table table-bordered table-sm" id="fixTable">

                    <thead>
                    <tr>
                        <th scope="col" class="tbl_srl_4">
                            Sr
                        </th>
                        <th scope="col" class="tbl_txt_25">
                            Component Name
                        </th>
                        <th scope="col" class="tbl_txt_25">
                            Amount
                        </th>
                        <th scope="col" class="tbl_txt_25">
                            Dr. Account
                        </th>
                        <th scope="col" class="tbl_txt_26">
                            Cr. Account
                        </th>
                        <th scope="col" class="tbl_txt_26">
                            Branch
                        </th>

                        <th scope="col" class="tbl_txt_8">
                            Created By
                        </th>
                        <th scope="col" class="hide_column tbl_srl_6">
                            Enable
                        </th>
                        {{-- <th scope="col" class="hide_column tbl_srl_6">
                            Action
                        </th> --}}
                    </tr>
                    </thead>

                    <tbody>
                    @php
                        $segmentSr = !empty(app('request')->input('segmentSr')) ? app('request')->input('segmentSr') : '';
                        $segmentPg = !empty(app('request')->input('page')) ? app('request')->input('page') : '';
                        $sr = !empty($segmentSr) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                        $countSeg = !empty($segmentSr) ? $segmentSr : 0;
                        use App\Models\College\Subject;
                    @endphp
                    @forelse($datas as $data)
                        <tr data-sfc_name="{{ $data->sfc_name }}" data-sfc_amount="{{ $data->sfc_amount }}"
                            data-sfc_id="{{ $data->sfc_id }}" data-cr_acc_id="{{ $data->cr_acc_id }}"
                            data-dr_acc_id="{{ $data->dr_acc_id }}">
                            <th scope="row">
                                {{ $sr }}
                            </th>
                            {{-- <th scope="row" class="edit ">
                                {{ $data->group_id }}
                            </th> --}}
                            <td class="edit ">
                                {{ $data->sfc_name }}
                            </td>
                            <td class="edit ">
                                {{ $data->sfc_amount }}
                            </td>
                            <td class="edit ">
                                {{ $data->dr_acc_name }}
                            </td>
                            <td>
                                {{ $data->cr_acc_name }}
                            </td>
                            <td>
                                {{ $data->branch_name }}
                            </td>

                            <td class="usr_prfl">
                                {{ $data->user_name }}
                            </td>
                            <td class="text-center hide_column ">
                                <label class="switch">
                                    <input type="checkbox" <?php if ($data->sfc_disable_enable == 1) {
                                        echo 'checked="true"' . ' ' . 'value=' . $data->sfc_disable_enable;
                                    } else {
                                        echo 'value=DISABLE';
                                    } ?> class="enable_disable"
                                           data-id="{{ $data->sfc_id }}"
                                        {{ $data->sfc_disable_enable == 1 ? 'checked' : '' }}>
                                    <span class="slider round"></span>
                                </label>
                            </td>
                        </tr>
                        @php
                            $sr++;
                            !empty($segmentSr) && $countSeg !== '0' ?: $countSeg++;
                        @endphp
                    @empty
                        <tr>
                            <td colspan="11">
                                <center>
                                    <h3 style="color:#554F4F">No Component</h3>
                                </center>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <span>Showing {{ $datas->firstItem() }} - {{ $datas->lastItem() }} of {{ $datas->total() }}</span>
                </div>
                <div class="col-md-9 text-right">
                    <span
                        class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search' => $search, 'cr_account' => $search_cr_account, 'dr_account' => $search_dr_account])->links()
                        }}</span>
                </div>
            </div>
        </div> <!-- white column form ends here -->
    </div><!-- row end -->

@endsection

@section('scripts')

    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('component_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>
        $(document).ready(function () {
            $('#dr_account').select2();
            $('#cr_account').select2();


            $('.enable_disable').change(function () {
                let status = $(this).prop('checked') === true ? 1 : 0;
                let group_id = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('enable_disable_clg_group') }}',
                    data: {
                        'status': status,
                        'group_id': group_id
                    },
                    success: function (data) {
                        console.log(data.message);
                    }
                });
            });
        });
    </script>

    <script>
        jQuery("#cancel").click(function () {
            $("#search").val('');
        });
    </script>

    <script>
        jQuery(".edit").click(function () {

            // var remarks = jQuery(this).parent('tr').attr("data-remarks");
            var sfc_id = jQuery(this).parent('tr').attr("data-sfc_id");
            var sfc_name = jQuery(this).parent('tr').attr("data-sfc_name");
            var sfc_amount = jQuery(this).parent('tr').attr("data-sfc_amount");
            var cr_acc_id = jQuery(this).parent('tr').attr("data-cr_acc_id");
            var dr_acc_id = jQuery(this).parent('tr').attr("data-dr_acc_id");

            jQuery("#sfc_id").val(sfc_id);
            // jQuery("#remarks").val(remarks);
            jQuery("#sfc_name").val(sfc_name);
            jQuery("#sfc_amount").val(sfc_amount);
            jQuery("#cr_acc_id").val(cr_acc_id);
            jQuery("#dr_acc_id").val(dr_acc_id);
            jQuery("#edit").submit();
        });

        $('.delete').on('click', function (event) {

            var sfc_id = jQuery(this).attr("data-sfc_id");

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
                    jQuery("#sfc_id").val(sfc_id);
                    jQuery("#delete").submit();
                } else {

                }
            });
        });
    </script>

@endsection
