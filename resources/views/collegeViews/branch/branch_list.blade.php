@extends('extend_index')
@section('content')
@section('styles_get')
    <style>
        .action_td .dropdown .dropdown-toggle::after {
            content: unset !important;
        }
    </style>
@stop

<div class="row">
    <div class="container-fluid search-filter form-group form_manage">
        <div class="form_header">
            <!-- form header start -->
            <div class="clearfix">
                <div class="pull-left">
                    <h4 class="text-white get-heading-text file_name">Branch List</h4>
                </div>
                <div class="list_btn list_mul">
                    <div class="srch_box_opn_icon">
                        <i class="fa fa-search"></i>
                    </div>
                </div><!-- list btn -->
            </div>
        </div><!-- form header close -->
        <div class="search_form m-0 p-0">
            <form class="highlight prnt_lst_frm" action="{{ route('branch_list') }}" name="form1" id="form1"
                  method="post">
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
                                @foreach ($branch_title as $value)
                                    <option value="{{ $value }}">
                                @endforeach
                            </datalist>
                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                        </div>
                    </div>
                        <x-year-end-component search="{{$search_year}}"/> <!-- left column ends here -->
                    <div class="col-lg-8 col-md-9 col-sm-12 col-xs-12 text-right form_controls">
                    @include('include.clear_search_button')
                    <!-- Call add button component -->
                        <x-add-button tabindex="9" href="{{ route('add_branch') }}"/>

                        @include('include/print_button')
                        <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                    </div>
                </div><!-- end row -->
            </form>
            <form name="edit" id="edit" action="{{ route('edit_branch') }}" method="post">
                @csrf
                <input name="title" id="title" type="hidden">
                <input name="branch_id" id="branch_id" type="hidden">
                <input name="contact" id="contact" type="hidden">
                <input name="contact2" id="contact2" type="hidden">
                <input name="address" id="address" type="hidden">
            </form>
            <form name="delete" id="delete" action="{{ route('delete_semester') }}" method="post">
                @csrf
                <input name="reg_id" id="reg_id" type="hidden">
            </form>
        </div>

        <div class="table-responsive" id="printTable">
            <table class="table table-bordered table-sm" id="fixTable">

                <thead>
                <tr>
                    <th scope="col" class="tbl_srl_4">
                        Sr#
                    </th>
                    <th scope="col" class="tbl_txt_25">
                        Branch Name
                    </th>
                    <th scope="col" class="tbl_txt_5">
                        Branch #
                    </th>
                    <th scope="col" class="tbl_txt_15">
                        Contact
                    </th>
                    <th scope="col" class="tbl_txt_15">
                        Contact2
                    </th>
                    <th scope="col" class="tbl_txt_25">
                        Address
                    </th>
                    <th scope="col" class="tbl_txt_5">
                        Branch
                    </th>
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
                @forelse($datas as $data)
                    <tr data-title="{{ $data->branch_name }}" data-branch_id="{{ $data->branch_id }}" data-contact="{{ $data->branch_contact }}" data-contact2="{{ $data->branch_contact2 }}"
                        data-address="{{ $data->branch_address }}">
                        <th>
                            {{$sr}}
                        </th>
                        <td class="edit ">
                            {{ $data->branch_name }}
                        </td>
                        <td class="edit text-center">
                            {{$data->branch_no }}
                        </td>
                        <td class="edit ">
                            {{ $data->branch_contact }}
                        </td>
                        <td class="edit ">
                            {{ $data->branch_contact2 }}
                        </td>
                        <td class="edit ">
                            {{ $data->branch_address }}
                        </td>
                        <td class="edit ">
                            {{$data->branch_type}}
                        </td>
                        <td class="text-center hide_column ">
                            <a data-region_id="{{ $data->branch_id }}" class="delete" data-toggle="tooltip"
                               data-placement="left" title="" data-original-title="Are you sure?">
                                <i class="fa fa-{{ $data->branch_delete_status == 1 ? 'undo' : 'trash' }}"></i>
                            </a>
                        </td>
                    </tr>
                    @php
                        $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                    @endphp
                @empty
                    <tr>
                        <td colspan="11">
                            <center>
                                <h3 style="color:#554F4F">No Branch</h3>
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
        </div>
    </div> <!-- white column form ends here -->
</div><!-- row end -->

@endsection
@section('scripts')


    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('branch_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>
        $(document).ready(function () {
            $('.enable_disable').change(function () {
                let status = $(this).prop('checked') === true ? 0 : 1;
                let regId = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('enable_disable_region') }}',
                    data: {
                        'status': status,
                        'reg_id': regId
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

            // $("#region").select2().val(null).trigger("change");
            // $("#region > option").removeAttr('selected');

            $("#search").val('');
        });
    </script>

    <script>
        // $('#print').click(function () {
        //     var printContents = document.getElementById('printTable').innerHTML;
        //     $('[name="content"]').val(printContents);
        //
        //     $(this).submit();
        // });

        jQuery(".edit").click(function () {

            var branch_title = jQuery(this).parent('tr').attr("data-title");
            var branch_id = jQuery(this).parent('tr').attr("data-branch_id");
            var contact = jQuery(this).parent('tr').attr("data-contact");
            var contact2 = jQuery(this).parent('tr').attr("data-contact2");
            var address = jQuery(this).parent('tr').attr("data-address");
            jQuery("#title").val(branch_title);
            jQuery("#branch_id").val(branch_id);
            jQuery("#contact").val(contact);
            jQuery("#contact2").val(contact2);
            jQuery("#address").val(address);
            jQuery("#edit").submit();
        });

        $('.delete').on('click', function (event) {

            var region_id = jQuery(this).attr("data-region_id");

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
                    jQuery("#reg_id").val(branch_id);
                    jQuery("#delete").submit();
                } else {

                }
            });
        });
    </script>


@endsection
