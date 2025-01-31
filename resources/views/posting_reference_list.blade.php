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
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Posting Reference List</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->
                {{--                    <!-- <div class="search_form {{ ( !empty($search) || !empty($search_region) ) ? '' : 'search_form_hidden' }}"> -->--}}
                {{--                    --}}
                <div class="search_form m-0 p-0">
                    <form class="highlight prnt_lst_frm" action="{{ route('posting_reference_list') . ((isset($restore_list) && $restore_list == 1) ? '?restore_list=1' : '') }}" name="form1"
                          id="form1"
                          method="post">
                        <div class="row">
                            @csrf
                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    {{--                                                    <label>--}}
                                    {{--                                                        All Column Search--}}
                                    {{--                                                    </label>--}}
                                    <input tabindex="1" autofocus type="search" list="browsers" class="inputs_up form-control" name="search" id="search" placeholder="All Data Search"
                                           value="{{ isset($search) ? $search : '' }}" autocomplete="off">
                                    <datalist id="browsers">
                                        @foreach($pr_title as $value)
                                            <option value="{{$value}}">
                                        @endforeach
                                    </datalist>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div> <!-- left column ends here -->


                            <div class="col-lg-10 col-md-9 col-sm-12 col-xs-12 form_controls TEXT-RIGHT">
                            @include('include.clear_search_button')
                            <!-- Call add button component -->
                                <x-add-button tabindex="9" href="{{ route('add_posting_reference') }}"/>

                                @include('include/print_button')

                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>

                            </div>


                        </div><!-- end row -->
                    </form>


                    <form name="edit" id="edit" action="{{ route('edit_posting_reference') }}" method="post">
                        @csrf
                        <input name="posting_reference_id" id="posting_reference_id" type="hidden">
                    </form>
                </div>

                <div class="table-responsive" id="printTable">
                    <table class="table table-bordered table-sm" id="fixTable">

                        <thead>
                        <tr>
                            <th scope="col" class="tbl_srl_4">
                                Sr#
                            </th>

                            <th scope="col" class="tbl_txt_37">
                                Title
                            </th>
                            <th scope="col" class="tbl_txt_35">
                                Remarks
                            </th>
                            <th scope="col" class="tbl_txt_8">
                                Created By
                            </th>
                            <th scope="col" class="hide_column tbl_srl_6">
                                Enable
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

                            <tr data-product_id="{{$data->pr_id}}">
                                <th scope="row" class="edit ">
                                    {{$sr}}
                                </th>

                                <td class="edit ">
                                    {{$data->pr_name}}
                                </td>
                                <td class="edit ">
                                    {{$data->pr_remarks }}
                                </td>

                                @php
                                    $ip_browser_info= ''.$data->pr_ip_adrs.','.str_replace(' ','-',$data->pr_brwsr_info).'';
                                @endphp

                                <td class="usr_prfl " data-usr_prfl="{{ $data->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                    {{$data->user_name}}
                                </td>

                                <td class="text-center hide_column ">
                                    <label class="switch">
                                        <input type="checkbox" <?php if ($data->pr_disabled == 0) {
                                            echo 'checked="true"' . ' ' . 'value=' . $data->pr_disabled;
                                        } else {
                                            echo 'value=DISABLE';
                                        } ?>  class="enable_disable" data-id="{{$data->pr_id}}"
                                            {{ $data->pr_disabled == 0 ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>
                            @php
                                $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="11">
                                    <center><h3 style="color:#554F4F">No Project Reference</h3></center>
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
                        <span class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search ])->links() }}</span>
                    </div>
                </div>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

@endsection

@section('scripts')


    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('posting_reference_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>

        $(document).ready(function () {
            $('.enable_disable').change(function () {
                let status = $(this).prop('checked') === true ? 0 : 1;
                let prId = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('enable_disable_project_reference') }}',
                    data: {'status': status, 'pr_id': prId},
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

            // var title = jQuery(this).parent('tr').attr("data-title");
            // var remarks = jQuery(this).parent('tr').attr("data-remarks");
            // var region_id = jQuery(this).parent('tr').attr("data-region_id");
            // jQuery("#title").val(title);
            // jQuery("#remarks").val(remarks);
            // jQuery("#region_id").val(region_id);

            var product_id = jQuery(this).parent('tr').attr("data-product_id");
            jQuery("#posting_reference_id").val(product_id);
            jQuery("#edit").submit();
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
                    jQuery("#reg_id").val(region_id);
                    jQuery("#delete").submit();
                } else {

                }
            });
        });

    </script>


@endsection

