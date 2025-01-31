@extends('extend_index')

@section('content')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Category List</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

                {{--                    <div class="search_form {{ ( !empty($search) || !empty($search_group)  ) ? '' : 'search_form_hidden' }}">--}}
                <div class="search_form m-0 p-0">
                    <form class="highlight prnt_lst_frm" action="{{ route('category_list') . ((isset($restore_list) && $restore_list == 1) ? '?restore_list=1' : '') }}" name="form1" id="form1"
                          method="post">
                        @csrf
                        <div class="row">

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        All Column Search
                                    </label>
                                    <input tabindex="1" autfocus type="search" list="browsers" class="inputs_up form-control all_clm_srch" name="search" id="search" placeholder="Search ..."
                                           value="{{ isset($search) ? $search : '' }}" autocomplete="off">
                                    <datalist id="browsers">
                                        @foreach($category as $value)
                                            <option value="{{$value}}">
                                        @endforeach
                                    </datalist>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div> <!-- left column ends here -->


                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        Select Group
                                    </label>
                                    <select tabindex="2" class="inputs_up form-control cstm_clm_srch" name="group" id="group">
                                        <option value="">Select Group</option>
                                        @foreach($groups as $group)
                                            <option value="{{$group->grp_id}}" {{ $group->grp_id == $search_group ? 'selected="selected"' : '' }}>{{$group->grp_title}}</option>
                                        @endforeach
                                    </select>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div>

                            <div class="form-group col-lg-8 col-md-6 col-sm-12 col-xs-12 form_controls text-right mt-4">
                            @include('include.clear_search_button')
                            <!-- Call add button component -->
                                <x-add-button tabindex="9" href="{{ route('add_category') }}"/>
                                @include('include/print_button')
                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                            </div>
                        </div>
                    </form>


                    <form name="edit" id="edit" action="{{ route('edit_category') }}" method="post">
                        @csrf
                        <input tabindex="6" name="category_id" id="category_id" type="hidden">
                    </form>

                    <form name="delete" id="delete" action="{{ route('delete_category') }}" method="post">
                        @csrf
                        <input tabindex="7" name="category_id" id="del_category_id" type="hidden">
                    </form>
                </div><!-- search form end -->


                <div class="table-responsive" id="printTable">
                    <table class="table table-bordered table-sm" id="fixTable">

                        <thead>
                        <tr>
                            <th tabindex="-1" scope="col" class="tbl_srl_4">
                                ID
                            </th>
                            <th scope="col" class="tbl_txt_25">
                                Product Group Title
                            </th>
                            <th scope="col" class="tbl_txt_25">
                                Product Category Title
                            </th>
                            <th scope="col" class="tbl_txt_26">
                                Remarks
                            </th>
                            <th scope="col" class="tbl_txt_8">
                                Created By
                            </th>
                            <th scope="col" class="hide_column tbl_srl_6">
                                Enable/Disable
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
                        @forelse($datas as $category)

                            <tr data-category_id="{{$category->cat_id}}">

                                <th scope="row" class="edit ">
                                    {{$category->cat_id}}
                                </th>
                                <td class="edit ">
                                    {{$category->grp_title}}
                                </td>
                                <td class="edit ">
                                    {{$category->cat_title}}
                                </td>
                                <td class="edit ">
                                    {{$category->cat_remarks}}
                                </td>

                                @php
                                    $ip_browser_info= ''.$category->cat_ip_adrs.','.str_replace(' ','-',$category->cat_brwsr_info).'';
                                @endphp

                                <td class="usr_prfl" data-usr_prfl="{{ $category->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                    {{ $category->user_name }}
                                </td>


                                {{--    add code by mustafa start --}}
                                <td class="text-center hide_column ">
                                    <label class="switch">
                                        <input type="checkbox" <?php if ($category->cat_disabled == 0) {
                                            echo 'checked="true"' . ' ' . 'value=' . $category->cat_disabled;
                                        } else {
                                            echo 'value=DISABLE';
                                        } ?>  class="enable_disable" data-id="{{$category->cat_id}}"
                                            {{ $category->cat_disabled == 0 ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                {{--    add code by mustafa end --}}


                                <td class="text-center hide_column ">
                                    <a data-category_id="{{$category->cat_id}}" class="delete" data-toggle="tooltip" data-placement="left" title="" data-original-title="Are you sure?">
                                        <i class="fa fa-{{$category->cat_delete_status == 1 ? 'undo':'trash'}}"></i>
                                    </a>
                                </td>

                            </tr>
                            @php
                                $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="11">
                                    <center><h3 style="color:#554F4F">No Group</h3></center>
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
                        <span class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search , 'group'=>$search_group ])->links() }}</span>
                    </div>
                </div>
            </div> <!-- white column form ends here -->

        </div><!-- col end -->


    </div><!-- row end -->

@endsection

@section('scripts')


    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('category_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}


    {{--    add code by mustafa start --}}
    <script>

        $(document).ready(function () {
            $('.enable_disable').change(function () {
                let status = $(this).prop('checked') === true ? 0 : 1;
                let catId = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('enable_disable_category') }}',
                    data: {'status': status, 'cat_id': catId},
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

            var category_id = jQuery(this).parent('tr').attr("data-category_id");

            jQuery("#category_id").val(category_id);
            jQuery("#edit").submit();
        });

        $('.delete').on('click', function (event) {

            var category_id = jQuery(this).attr("data-category_id");

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
                    jQuery("#del_category_id").val(category_id);
                    jQuery("#delete").submit();
                } else {

                }
            });
        });

    </script>

    <script>
        jQuery("#cancel").click(function () {

            $("#group").select2().val(null).trigger("change");
            $("#group > option").removeAttr('selected');

            $("#search").val('');
        });
    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#group").select2();
        });
    </script>

@endsection

