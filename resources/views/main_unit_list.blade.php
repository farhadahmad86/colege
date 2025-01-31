@extends('extend_index')

@section('content')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Main Unit List</h4>
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
                    <form class="highlight prnt_lst_frm" action="{{ route('main_unit_list') . ((isset($restore_list) && $restore_list == 1) ? '?restore_list=1' : '') }}" name="form1" id="form1"
                          method="post">
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
                                        @foreach($main_unit as $value)
                                            <option value="{{$value}}">
                                        @endforeach
                                    </datalist>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div> <!-- left column ends here -->

                            <div class="col-lg-10 col-md-9 col-sm-12 col-xs-12 mt-4 form_controls text-right">
                            @include('include.clear_search_button')
                            <!-- Call add button component -->
                                <x-add-button tabindex="9" href="{{ route('add_main_unit') }}"/>
                                @include('include/print_button')
                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                            </div>

                        </div>
                    </form>


                    <form name="edit" id="edit" action="{{ route('edit_main_unit') }}" method="post">
                        @csrf
                        <input tabindex="-1" name="title" id="title" type="hidden">
                        <input tabindex="-1" name="remarks" id="remarks" type="hidden">
                        <input name="unit_id" id="unit_id" type="hidden">

                    </form>

                    <form name="delete" id="delete" action="{{ route('delete_main_unit') }}" method="post">
                        @csrf
                        <input name="main_unit_id" id="del_main_unit_id" type="hidden">

                    </form>
                </div><!-- search form end -->


                <div class="table-responsive" id="printTable">
                    <table class="table table-bordered table-sm" id="fixTable">

                        <thead>
                        <tr>
                            <th scope="col" class="tbl_srl_4">
                                ID
                            </th>
                            <th scope="col" class="tbl_txt_37">
                                Title
                            </th>
                            <th scope="col" class="tbl_txt_35">
                                Remarks
                            </th>
                            <th scope="col" class="text-center align_center tbl_txt_8">
                                Created By
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
                        @forelse($datas as $main_unit)

                            <tr data-title="{{$main_unit->mu_title}}" data-remarks="{{$main_unit->mu_remarks}}" data-unit_id="{{$main_unit->mu_id}}">

                                <th scope="ROW" class="edit tbl_srl_4">
                                    {{$main_unit->mu_id}}
                                </tH>
                                <td class="edit ">
                                    {{$main_unit->mu_title}}
                                </td>
                                <td class="edit ">
                                    {{$main_unit->mu_remarks }}
                                </td>

                                @php
                                    $ip_browser_info= ''.$main_unit->mu_ip_adrs.','.str_replace(' ','-',$main_unit->mu_brwsr_info).'';
                                @endphp

                                <td class="usr_prfl" data-usr_prfl="{{ $main_unit->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                    {{ $main_unit->user_name }}
                                </td>


                                {{--    add code by mustafa start --}}
                                <td class="text-center hide_column ">
                                    <label class="switch">
                                        <input tabindex="-1" type="checkbox" <?php if ($main_unit->mu_disabled == 0) {
                                            echo 'checked="true"' . ' ' . 'value=' . $main_unit->mu_disabled;
                                        } else {
                                            echo 'value=DISABLE';
                                        } ?>  class="enable_disable" data-id="{{$main_unit->mu_id}}"
                                            {{ $main_unit->mu_disabled == 0 ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                {{--    add code by mustafa end --}}


                                <td class="text-center hide_column ">
                                    <a data-main_unit_id="{{$main_unit->mu_id}}" class="delete" data-toggle="tooltip" data-placement="left" title="" data-original-title="Are you sure?">
                                        <i class="fa fa-{{$main_unit->mu_delete_status == 1 ? 'undo':'trash'}}"></i>
                                    </a>
                                </td>

                            </tr>
                            @php
                                $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="11">
                                    <center><h3 style="color:#554F4F">No Unit</h3></center>
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



    <script type="text/javascript">

        function validate_form() {
            var search = document.getElementById("search").value;

            var flag_submit = true;

            if (search.trim() == "") {
                document.getElementById("demo1").innerHTML = "Required";
                jQuery("#search").focus();
                flag_submit = false;
            } else {
                document.getElementById("demo1").innerHTML = "";
            }

            return flag_submit;
        }
    </script>

    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('main_unit_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}


    {{--    add code by mustafa start --}}
    <script>

        $(document).ready(function () {
            $('.enable_disable').change(function () {
                let status = $(this).prop('checked') === true ? 0 : 1;
                let muId = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('enable_disable_main_unit') }}',
                    data: {'status': status, 'mu_id': muId},
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

            var title = jQuery(this).parent('tr').attr("data-title");
            var remarks = jQuery(this).parent('tr').attr("data-remarks");
            var unit_id = jQuery(this).parent('tr').attr("data-unit_id");

            jQuery("#title").val(title);
            jQuery("#remarks").val(remarks);
            jQuery("#unit_id").val(unit_id);
            jQuery("#edit").submit();
        });

        $('.delete').on('click', function (event) {

            var main_unit_id = jQuery(this).attr("data-main_unit_id");

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
                    jQuery("#del_main_unit_id").val(main_unit_id);
                    jQuery("#delete").submit();
                } else {

                }
            });
        });

    </script>

@endsection

