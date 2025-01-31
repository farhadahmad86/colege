@extends('extend_index')

@section('content')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Permission n Role List</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->


            <!-- <div class="search_form {{ ( !empty($search) ) ? '' : 'search_form_hidden' }}"> -->

                <div class="search_form m-0 p-0">
                    <form class="highlight prnt_lst_frm" action="{{ route('role_permission_list') }}" name="form1" id="form1"
                          method="post">
                        @csrf
                        <div class="row">
                            <div class="form-group col-lg-2 col-md-9 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        All Column Search
                                    </label>
                                    <input tabindex="1" autofocus type="search" list="browsers" class="inputs_up form-control" name="search" id="search" placeholder="Search ..."
                                           value="{{ isset($search) ? $search : '' }}" autocomplete="off">
                                    <datalist id="browsers">
                                        @foreach($group_title as $value)
                                            <option value="{{$value}}">
                                        @endforeach
                                    </datalist>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div> <!-- left column ends here -->
                            <div class="col-lg-10 col-md-12 col-sm-12 col-xs-12 mt-4 form_controls text-right">
                            @include('include.clear_search_button')
                            <!-- Call add button component -->
                                <x-add-button tabindex="9" href="{{ route('add_role_permission') }}"/>

                                @include('include/print_button')

                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                            </div>


                        </div>
                    </form>

                    <form name="edit" id="edit" action="{{ route('edit_role_permission') }}" method="post">
                        @csrf
                        <input tabindex="-1" name="group_id" id="group_id" type="hidden">
                    </form>

                    <form name="delete" id="delete" action="{{ route('delete_role_permission') }}" method="post">
                        @csrf
                        <input name="group_id" id="del_group_id" type="hidden">
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
                            <th scope="col" class="tbl_txt_30">
                                Name
                            </th>
                            <th scope="col" class="tbl_txt_35">
                                Remarks
                            </th>
                            <th scope="col" class="tbl_txt_15">
                                Created By
                            </th>
                            <th scope="col" class="tbl_srl_6 hide_column">
                                Enable
                            </th>
                            <th scope="col" class="tbl_srl_4 hide_column">
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
                        @forelse($datas as $group)

                            <tr data-group_id="{{$group->id}}">

                                <th scope="row" class="edit ">
                                    {{$sr}}
                                </th>
                                <td class="edit ">
                                    {{$group->id}}
                                </td>
                                <td class="edit">
                                    {{$group->name}}
                                </td>
                                <td class="edit">
{{--                                    {{$group->remarks}}--}}
                                </td>

                                @php
                                    $ip_browser_info= ''.$group->ip_adrs.','.str_replace(' ','-',$group->brwsr_info).'';
                                @endphp

                                <td class="usr_prfl " data-usr_prfl="{{ $group->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                    {{$group->user_name}}
                                </td>


                                {{--    add code by mustafa start --}}
                                <td class="text-center hide_column ">
                                    <label class="switch">
                                        <input type="checkbox" <?php if ($group->disabled == 0) {
                                            echo 'checked="true"' . ' ' . 'value=' . $group->disabled;
                                        } else {
                                            echo 'value=DISABLE';
                                        } ?>  class="enable_disable" data-id="{{$group->id}}"
                                            {{ $group->disabled == 0 ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                {{--    add code by mustafa end --}}


                                <td class="text-center hide_column">
                                    <a data-group_id="{{$group->id}}" class="delete" style="cursor:pointer;" data-toggle="tooltip" data-placement="left" title=""
                                       data-original-title="Are you sure?">
                                        <i class="fa fa-{{$group->delete_status
 == 1 ? 'undo':'trash'}}"></i>
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
        var base = '{{ route('role_permission_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    {{--    add code by mustafa start --}}
    <script>

        $(document).ready(function () {
            $('.enable_disable').change(function () {
                let status = $(this).prop('checked') === true ? 0 : 1;
                let mgId = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('enable_disable_role_permission') }}',
                    data: {'status': status, 'id': mgId},
                    success: function (data) {
                        console.log(data.message);
                    }
                });
            });
        });
    </script>
    {{--    add code by mustafa end --}}


    <script>
        jQuery("#cancel").click(function () {

            $("#search").val('');

        });
    </script>

    <script>

        jQuery(".edit").click(function () {

            var group_id = jQuery(this).parent('tr').attr("data-group_id");

            jQuery("#group_id").val(group_id);
            jQuery("#edit").submit();
        });

        $('.delete').on('click', function (event) {

            var group_id = jQuery(this).attr("data-group_id");

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
                    jQuery("#del_group_id").val(group_id);
                    jQuery("#delete").submit();
                } else {

                }
            });
        });

    </script>

@endsection

