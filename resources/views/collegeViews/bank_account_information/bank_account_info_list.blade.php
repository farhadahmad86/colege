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
                        <h4 class="text-white get-heading-text file_name">Branch Information List</h4>
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
                <form class="highlight prnt_lst_frm" action="{{ route('bank_account_info_list') }}" name="form1"
                    id="form1" method="post">
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
                                    @foreach ($branch_information_title as $value)
                                        <option value="{{ $value }}">
                                    @endforeach
                                </datalist>
                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                            </div>
                        </div> <!-- left column ends here -->
                            <x-year-end-component search="{{$search_year}}"/>
                        <div class="col-lg-8 col-md-7 col-sm-12 col-xs-12 text-right form_controls mt-3">
                            @include('include.clear_search_button')
                            <!-- Call add button component -->
                            <x-add-button tabindex="9" href="{{ route('add_bank_account_info') }}" />

                            @include('include/print_button')
                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                        </div>
                    </div><!-- end row -->
                </form>
                <form name="edit" id="edit" action="{{ route('edit_bank_account_info') }}" method="post">
                    @csrf
                    <input name="bi_id" id="bi_id" type="hidden">
                    <input name="bank_name" id="bank_name" type="hidden">
                    <input name="account_title" id="account_title" type="hidden">
                    <input name="account_no" id="account_no" type="hidden">
                    <input name="branch_code" id="branch_code" type="hidden">
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
                                Bank Name
                            </th>
                            <th scope="col" class="tbl_txt_25">
                                Branch Code
                            </th>
                            <th scope="col" class="tbl_txt_25">
                                Account Title
                            </th>
                            <th scope="col" class="tbl_txt_26">
                                Account#
                            </th>

                            <th scope="col" class="tbl_txt_8">
                                Created By
                            </th>
                            {{-- <th scope="col" class="hide_column tbl_srl_6">
                                Enable
                            </th> --}}
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
                            <tr data-bank_name="{{ $data->bi_bank_name }}"
                                data-account_title="{{ $data->bi_account_title }}"
                                data-account_no="{{ $data->bi_account_no }}"
                                data-branch_code="{{ $data->bi_branch_code }}" data-bi_id="{{ $data->bi_id }}">
                                <th scope="row">
                                    {{ $sr }}
                                </th>
                                {{-- <th scope="row" class="edit ">
                                    {{ $data->group_id }}
                                </th> --}}
                                <td class="edit ">
                                    {{ $data->bi_bank_name }}
                                </td>
                                <td class="edit ">
                                    {{ $data->bi_branch_code }}
                                </td>
                                <td class="edit ">
                                    {{ $data->bi_account_title }}
                                </td>
                                <td>
                                    {{ $data->bi_account_no }}
                                </td>

                                <td class="usr_prfl">
                                    {{ $user->user_name }}
                                </td>
                                {{-- <td class="text-center hide_column ">
                                    <label class="switch">
                                        <input type="checkbox" <?php if ($data->bi_disable_enable == 1) {
                                            echo 'checked="true"' . ' ' . 'value=' . $data->bi_disable_enable;
                                        } else {
                                            echo 'value=DISABLE';
                                        } ?> class="enable_disable"
                                            data-id="{{ $data->bi_id }}"
                                            {{ $data->bi_disable_enable == 1 ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </label>
                                </td> --}}
                            </tr>
                            @php
                                $sr++;
                                !empty($segmentSr) && $countSeg !== '0' ?: $countSeg++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="11">
                                    <center>
                                        <h3 style="color:#554F4F">No Bank Info</h3>
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
                        class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search' => $search])->links() }}</span>
                </div>
            </div>
        </div> <!-- white column form ends here -->
    </div><!-- row end -->

@endsection

@section('scripts')


    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('enable_disable_bank_info') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>
        $(document).ready(function() {
            $('#dr_account').select2();
            $('#cr_account').select2();


            $('.enable_disable').change(function() {
                let status = $(this).prop('checked') === true ? 1 : 0;
                let bi_id = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('enable_disable_bank_info') }}',
                    data: {
                        'status': status,
                        'bi_id':bi_id
                    },
                    success: function(data) {
                        console.log(data.message);
                    }
                });
            });
        });
    </script>

    <script>
        jQuery("#cancel").click(function() {
            $("#search").val('');
        });
    </script>

    <script>
        jQuery(".edit").click(function() {

            // var remarks = jQuery(this).parent('tr').attr("data-remarks");
            var bank_name = jQuery(this).parent('tr').attr("data-bank_name");
            var account_title = jQuery(this).parent('tr').attr("data-account_title");
            var branch_code = jQuery(this).parent('tr').attr("data-branch_code");
            var account_no = jQuery(this).parent('tr').attr("data-account_no");
            var bi_id = jQuery(this).parent('tr').attr("data-bi_id");

            jQuery("#bi_id").val(bi_id);
            // jQuery("#remarks").val(remarks);
            jQuery("#bank_name").val(bank_name);
            jQuery("#account_title").val(account_title);
            jQuery("#branch_code").val(branch_code);
            jQuery("#account_no").val(account_no);
            jQuery("#edit").submit();
        });

        $('.delete').on('click', function(event) {

            var sfc_id = jQuery(this).attr("data-sfc_id");

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
                    jQuery("#sfc_id").val(sfc_id);
                    jQuery("#delete").submit();
                } else {

                }
            });
        });
    </script>


@endsection
