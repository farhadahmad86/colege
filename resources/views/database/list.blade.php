@extends('extend_index')

@section('content')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Database List</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->
            <!-- <div class="search_form  {{ ( !empty($search) || !empty($search_client) ) ? '' : '' }}"> -->

                <div class="search_form p-0 m-0">
                    <form class="highlight prnt_lst_frm" action="{{ route('database.index') . ((isset($restore_list) && $restore_list == 1) ? '?restore_list=1' : '') }}" name="form1"
                          id="form1" method="post">
                        <div class="row">
                            @csrf

                            <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        All Column Search
                                    </label>
                                    <input tabindex="1" autofocus type="search" list="browsers" class="inputs_up form-control all_clm_srch" name="search" id="search" placeholder="Search ..."
                                           value="{{ isset($search) ? $search : '' }}" autocomplete="off">
                                    <datalist id="browsers">
                                        @foreach($database_title as $value)
                                            <option value="{{$value}}">
                                        @endforeach
                                    </datalist>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div> <!-- left column ends here -->


                            <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label class="required">
                                        Select Client
                                    </label>
                                    <select tabindex="2" class="inputs_up form-control cstm_clm_srch" name="client" id="client" style="width: 90%">
                                        <option value="">Select Client</option>
                                        @foreach($clients as $client)
                                            <option value="{{$client->account_uid}}" {{ $client->account_uid == $search_client ? 'selected="selected"' : ''
                                                            }}>{{$client->account_name}}</option>
                                        @endforeach
                                    </select>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div>


                            <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12 text-right mt-4">
                            @include('include.clear_search_button')
                            <!-- Call add button component -->
                                <x-add-button tabindex="9" href="{{ route('database_create') }}"/>
                                @include('include/print_button')

                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>

                            </div>
                        </div><!-- end row -->
                    </form>

                    <form name="edit" id="edit" action="{{ route('database.edit') }}" method="post">
                        @csrf
                        <input name="client_title" id="client_title" type="hidden">
                        <input name="db_name" id="db_name" type="hidden">
                        <input name="db_id" id="db_id" type="hidden">
                        <input name="client_id" id="client_id" type="hidden">

                    </form>

                    <form name="delete" id="delete" action="{{ route('database.delete') }}" method="post">
                        @csrf
                        <input name="db_id" id="del_db_id" type="hidden">
                    </form>
                </div>

                <div class="table-responsive" id="printTable">
                    <table class="table table-bordered table-sm" id="fixTable">

                        <thead>
                        <tr>
                            {{--                                    <th scope="col" align="center" class="text-center align_center tbl_srl_4">Sr#</th>--}}
                            <th scope="col" align="center" class="text-center align_center tbl_srl_4">ID</th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_23">Client Title</th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_23">Database Title</th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_8">Created By</th>
                            {{--<th scope="col" style="width:80px; text-align: center !important" align="center">Date/Time</th>--}}
                            <th scope="col" class="text-center align_center hide_column tbl_srl_6">Enable</th>
                            <th scope="col" class="text-center align_center hide_column tbl_srl_6">Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @php
                            $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
                            $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
                            $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                            $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
                        @endphp
                        @forelse($datas as $database)

                            <tr data-client_title="{{$database->account_name}}" data-db_name="{{$database->db_name}}" data-db_id="{{$database->db_id}}"
                                data-client_id="{{$database->db_client_id}}">

                                {{--                                    <td class="align_center text-center edit tbl_srl_4">{{$sr}}</td>--}}
                                <td class="align_center text-center edit tbl_srl_4">{{$database->db_id}}</td>

                                <td class="align_left text-left edit tbl_txt_23">{{$database->account_name}}</td>

                                <td class="align_left text-left edit tbl_txt_23">{{$database->db_name}}</td>

                                @php
                                    $ip_browser_info= ''.$database->db_ip_adrs.','.str_replace(' ','-',$database->db_brwsr_info).'';
                                @endphp

                                <td class="align_left text-left usr_prfl tbl_txt_8" data-usr_prfl="{{ $database->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                    {{ $database->user_name }}
                                </td>

                                <td class="align_right text-right hide_column tbl_amnt_6">
                                    <label class="switch">
                                        <input type="checkbox" <?php if ($database->db_disabled == 0) {
                                            echo 'checked="true"' . ' ' . 'value=' . $database->db_disabled;
                                        } else {
                                            echo 'value=DISABLE';
                                        } ?>  class="enable_disable" data-id="{{$database->db_id}}"
                                            {{ $database->db_disabled == 0 ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </label>
                                </td>

                                <td class="align_center  text-right hide_column tbl_srl_6">
                                    <a data-db_id="{{$database->db_id}}" class="delete" data-toggle="tooltip" data-placement="left" title="" data-original-title="Are you sure?">
                                        <i class="fa fa-{{$database->db_delete_status == 1 ? 'undo':'trash'}}"></i>
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
                                    <center><h3 style="color:#554F4F">No Database</h3></center>
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
                        <span class="hide_column"> {{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search, 'client'=>$search_client ])->links() }}</span>
                    </div>
                </div>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

@endsection

@section('scripts')



    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('area_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>

        $(document).ready(function () {
            $('.enable_disable').change(function () {
                let status = $(this).prop('checked') === true ? 0 : 1;
                let areaId = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('enable_disable_area') }}',
                    data: {'status': status, 'db_id': areaId},
                    success: function (data) {
                        console.log(data.message);
                    }
                });
            });
        });
    </script>

    <script>

        jQuery(".edit").click(function () {

            var client_title = jQuery(this).parent('tr').attr("data-client_title");
            var db_name = jQuery(this).parent('tr').attr("data-db_name");
            var db_id = jQuery(this).parent('tr').attr("data-db_id");
            var client_id = jQuery(this).parent('tr').attr("data-client_id");

            jQuery("#client_title").val(client_title);
            jQuery("#db_name").val(db_name);
            jQuery("#db_id").val(db_id);
            jQuery("#client_id").val(client_id);
            jQuery("#edit").submit();
        });

        $('.delete').on('click', function (event) {

            var db_id = jQuery(this).attr("data-db_id");

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
                    jQuery("#del_db_id").val(db_id);
                    jQuery("#delete").submit();
                } else {

                }
            });
        });




        {{--$(function() {--}}
        {{--var availableTutorials  =  JSON.parse('{!! json_encode($db_name) !!}');--}}
        {{--$( "#search" ).autocomplete({--}}
        {{--source: availableTutorials,--}}
        {{--});--}}
        {{--});--}}

    </script>

    <script>
        jQuery("#cancel").click(function () {

            $("#client").select2().val(null).trigger("change");
            $("#client > option").removeAttr('selected');

            $("#search").val('');
        });
    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#client").select2();
        });
    </script>

    <style>
        input::-webkit-calendar-picker-indicator {
            display: none;
        }
    </style>

@endsection

