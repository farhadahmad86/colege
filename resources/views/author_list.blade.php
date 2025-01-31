
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
                            <h4 class="text-white get-heading-text file_name">Author List</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i tabindex="-1" class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->
                <!-- <div class="search_form {{ ( !empty($search) || !empty($search_author) ) ? '' : 'search_form_hidden' }}"> -->

                <div class="search_form m-0 p-0">
                            <form class="highlight prnt_lst_frm" action="{{ route('author_list') . ((isset($restore_list) && $restore_list == 1) ? '?restore_list=1' : '') }}" name="form1" id="form1" method="post">
                                <div class="row">
                                    @csrf
                                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->

                                            <input tabindex="1" autofocus type="search" list="browsers" class="inputs_up form-control" name="search" id="search" placeholder="All Data Search" value="{{ isset($search) ? $search : '' }}" autocomplete="off">
                                            <datalist id="browsers">
                                                @foreach($aut_title as $value)
                                                    <option value="{{$value}}">
                                                @endforeach
                                            </datalist>
                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                        </div>
                                    </div> <!-- left column ends here -->


                                    <div class="col-lg-10 col-md-9 col-sm-12 col-xs-12 form_controls text-right mt-4">
                                            <button tabindex="2" type="button" name="cancel" id="cancel" class="cancel_button form-control">
                                                <i class="fa fa-trash"></i> Clear
                                            </button>
                                            <button tabindex="3" type="submit" name="filter_search" id="filter_search" class="save_button form-control" value="">
                                                <i class="fa fa-search"></i> Search
                                            </button>

                                            <a tabindex="4" class="save_button form-control" href="{{ route('add_author') }}" role="button">
                                                <l class="fa fa-plus"></l> Author
                                            </a>

                                            @include('include/print_button')

                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                        </div>


                                </div><!-- end row -->
                            </form>


                            <form name="edit" id="edit" action="{{ route('edit_author') }}" method="post">
                                @csrf
                                <input tabindex="5" name="name" id="name" type="hidden">
                                <input tabindex="6" name="remarks" id="remarks" type="hidden">
                                <input tabindex="7" name="author_id" id="author_id" type="hidden">

                            </form>

                            <form name="delete" id="delete" action="{{ route('delete_author') }}" method="post">
                                @csrf
                                <input tabindex="8" name="aut_id" id="aut_id" type="hidden">
                            </form>
                    </div>

                <div class="table-responsive" id="printTable">
                    <table class="table table-sm" id="fixTable">

                        <thead>
                        <tr>
                            <th tabindex="-1" scope="col" class="tbl_srl_4">
                                Sr#
                            </th>
                            <th tabindex="-1" scope="col" class="tbl_srl_4">
                                ID
                            </th>
                            <th tabindex="-1" scope="col" class="tbl_txt_37">
                                Title
                            </th>
                            <th tabindex="-1" scope="col" class="tbl_txt_35">
                                Remarks
                            </th>
                            <th tabindex="-1" scope="col" class="tbl_txt_8">
                                Created By
                            </th>
                            <th tabindex="-1" scope="col" class="hide_column tbl_srl_6">
                                Enable
                            </th>
                            <th tabindex="-1" scope="col" class="hide_column tbl_srl_6">
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

                            <tr data-title="{{$data->aut_title}}" data-remarks="{{$data->aut_remarks}}" data-author_id="{{$data->aut_id}}">
                                <td class="edit ">
                                    {{$sr}}
                                </td>
                                <td class="edit ">
                                    {{$data->aut_id}}
                                </td>
                                <td class="edit ">
                                    {{$data->aut_title}}
                                </td>
                                <td class="edit ">
                                    {{$data->aut_remarks }}
                                </td>

                                @php
                                    $ip_browser_info= ''.$data->aut_ip_adrs.','.str_replace(' ','-',$data->aut_brwsr_info).'';
                                @endphp

                                <td class="usr_prfl " data-usr_prfl="{{ $data->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                    {{$data->user_name}}
                                </td>

                                <td class="hide_column text-center">
                                    <label class="switch">
                                        <input type="checkbox" <?php if ($data->aut_disabled == 0) {
                                            echo 'checked="true"' . ' ' . 'value=' . $data->aut_disabled;
                                        } else {
                                            echo 'value=DISABLE';
                                        } ?>  class="enable_disable" data-id="{{$data->aut_id}}"
                                            {{ $data->aut_disabled == 0 ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </label>
                                </td>

                                <td class="hide_column text-center">
                                    <a data-author_id="{{$data->aut_id}}" class="delete"  data-toggle="tooltip" data-placement="left"  title="" data-original-title="Are you sure?">
                                        <i class="fa fa-{{$data->aut_delete_status == 1 ? 'undo':'trash'}}"></i>
                                    </a>
                                </td>

                            </tr>
                            @php
                                $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="11">
                                    <center><h3 style="color:#554F4F">No Author</h3></center>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>

                    </table>

                </div>
                <span class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search ])->links() }}</span>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

@endsection

@section('scripts')


    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('author_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>

        $(document).ready(function () {
            $('.enable_disable').change(function () {
                let status = $(this).prop('checked') === true ? 0 : 1;
                let pubId = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('enable_disable_author') }}',
                    data: {'status': status, 'aut_id': pubId},
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

        // $('#print').click(function () {
        //     var printContents = document.getElementById('printTable').innerHTML;
        //     $('[name="content"]').val(printContents);
        //
        //     $(this).submit();
        // });

        jQuery(".edit").click(function () {

            var title = jQuery(this).parent('tr').attr("data-title");
            var remarks = jQuery(this).parent('tr').attr("data-remarks");
            var author_id = jQuery(this).parent('tr').attr("data-author_id");

            jQuery("#name").val(title);
            jQuery("#remarks").val(remarks);
            jQuery("#author_id").val(author_id);
            jQuery("#edit").submit();
        });

        $('.delete').on('click', function (event) {

            var author_id = jQuery(this).attr("data-author_id");

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
                    jQuery("#aut_id").val(author_id);
                    jQuery("#delete").submit();
                } else {

                }
            });
        });

    </script>


@endsection

