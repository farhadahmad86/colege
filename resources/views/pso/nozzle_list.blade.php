@extends('extend_index')

@section('content')

    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">

                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Nozzle List</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->
{{--                <!-- <div class="search_form  {{ ( !empty($search) || !empty($search_tank) ) ? '' : 'search_form_hidden' }}"> -->--}}

                <div class="search_form">
                    <div class="row">


                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
{{--                            . ((isset($restore_list) && $restore_list == 1) ? '?restore_list=1' : '')--}}
                            <form class="prnt_lst_frm" action="{{ route('nozzle_list')  }}" name="form1" id="form1" method="post">
                                <div class="row">
                                    @csrf

                                    <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>
                                                All Column Search
                                            </label>
                                            <input tabindex="1" autofocus type="search" list="browsers" class="inputs_up form-control all_clm_srch" name="search" id="search" placeholder="Search ..." value="{{ isset($search) ? $search : '' }}" autocomplete="off">
                                            <datalist id="browsers">
                                                @foreach($nozzle_title as $value)
                                                    <option value="{{$value}}">
                                                @endforeach
                                            </datalist>
                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                        </div>
                                    </div> <!-- left column ends here -->

                                    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 srch_brdr_left">
                                        <div class="row">

                                            <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="required">
                                                        Select Tank
                                                    </label>
                                                    <select tabindex="2"class="inputs_up form-control cstm_clm_srch" name="tank" id="tank" style="width: 90%">
                                                        <option value="">Select Tank</option>
                                                        @foreach($tanks as $tank)
                                                            <option value="{{$tank->t_id}}" {{ $tank->t_id == $search_tank ? 'selected="selected"' : '' }}>{{$tank->t_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>


                                            <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 mt-lg-2">
                                                <div class="form_controls text-center text-lg-left">

                                                    <button tabindex="3" type="button" type="button" name="cancel" id="cancel" class="cancel_button form-control">
                                                        <i class="fa fa-trash"></i> Clear
                                                    </button>
                                                    <button tabindex="4" type="submit" name="filter_search" id="filter_search" class="save_button form-control" value="">
                                                        <i class="fa fa-search"></i> Search
                                                    </button>

                                                    <a tabindex="5" class="save_button form-control" href="add_nozzle" role="button">
                                                        <l class="fa fa-plus"></l> Nozzle
                                                    </a>

                                                    @include('include/print_button')

                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>

                                                </div>
                                            </div>

                                        </div>
                                    </div>


                                </div><!-- end row -->
                            </form>

                            <form name="edit" id="edit" action="edit_nozzle" method="post">
                                @csrf
                                <input tabindex="6" name="nozzle_name" id="nozzle_name" type="hidden">
                                <input tabindex="7" name="remarks" id="remarks" type="hidden">
                                <input tabindex="8" name="tank_id" id="tank_id" type="hidden">
                                <input tabindex="9" name="nozzle_id" id="nozzle_id" type="hidden">
                            </form>

{{--                            <form name="delete" id="delete" action="{{ route('delete_nozzle') }}" method="post">--}}
{{--                                @csrf--}}
{{--                                <input name="nozzle_id" id="del_nozzle_id" type="hidden">--}}
{{--                            </form>--}}


                        </div>
                    </div>
                </div>

                <div class="table-responsive" id="printTable">
                    <table class="table table-bordered table-sm" id="fixTable">

                        <thead>
                        <tr>
                            <th scope="col" align="center" class="text-center align_center tbl_srl_4">Sr#</th>
                             <th scope="col" align="center" class="text-center align_center tbl_srl_4">ID</th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_23">Tank Title</th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_23">Nozzle Title</th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_25">Remarks</th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_8">Created By</th>
                        </tr>
                        </thead>

                        <tbody>
                        @php
                            $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
                            $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
                            $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                            $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
                        @endphp
                        @forelse($datas as $nozzle)

                            <tr data-nozzle_id="{{$nozzle->noz_id}}"  data-nozzle_name="{{$nozzle->noz_name}}" data-remarks="{{$nozzle->noz_remarks}}" data-tank_id="{{$nozzle->noz_tank_id}}">

                                <td class="align_center text-center edit tbl_srl_4">{{$sr}}</td>
                                <td class="align_center text-center edit tbl_srl_4">{{$nozzle->t_id}}</td>
                                <td class="align_left text-left edit tbl_txt_23">{{$nozzle->t_name}}</td>
                                <td class="align_left text-left edit tbl_txt_23">{{$nozzle->noz_name}}</td>
                                <td class="align_left text-left edit tbl_txt_25">{{$nozzle->noz_remarks }}</td>


                                @php
                                    $ip_browser_info= ''.$nozzle->noz_ip_adrs.','.str_replace(' ','-',$nozzle->noz_brwsr_info).'';
                                @endphp

                                <td class="align_left text-left usr_prfl tbl_txt_8" data-usr_prfl="{{ $nozzle->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                    {{ $nozzle->user_name }}
                                </td>

                            </tr>
                            @php
                                $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="11">
                                    <center><h3 style="color:#554F4F">No Nozzle</h3></center>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>

                    </table>

                </div>

                <span class="hide_column"> {{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search, 'tank'=>$search_tank ])->links() }}</span>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

@endsection

@section('scripts')



    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('nozzle_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

{{--    <script>--}}

{{--        $(document).ready(function () {--}}
{{--            $('.enable_disable').change(function () {--}}
{{--                let status = $(this).prop('checked') === true ? 0 : 1;--}}
{{--                let nozId = $(this).data('id');--}}
{{--                $.ajax({--}}
{{--                    type: "GET",--}}
{{--                    dataType: "json",--}}
{{--                    url: '{{ route('enable_disable_nozzle}}',--}}
{{--                    data: {'status': status, 'noz_id': nozId},--}}
{{--                    success: function (data) {--}}
{{--                        console.log(data.message);--}}
{{--                    }--}}
{{--                });--}}
{{--            });--}}
{{--        });--}}

{{--        $('.delete').on('click', function (event) {--}}

{{--            var nozzle_id = jQuery(this).attr("data-nozzle_id");--}}

{{--            event.preventDefault();--}}
{{--            Swal.fire({--}}
{{--                title: 'Are you sure?',--}}
{{--                icon: 'warning',--}}
{{--                showCancelButton: true,--}}
{{--                cancelButtonColor: '#d33',--}}
{{--                confirmButtonColor: '#3085d6',--}}
{{--                confirmButtonText: 'Yes',--}}
{{--            }).then(function(result) {--}}

{{--                if (result.value) {--}}
{{--                    jQuery("#del_nozzle_id").val(nozzle_id);--}}
{{--                    jQuery("#delete").submit();--}}
{{--                } else {--}}

{{--                }--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}

    <script>

        jQuery(".edit").click(function () {

            var nozzle_name = jQuery(this).parent('tr').attr("data-nozzle_name");
            var remarks = jQuery(this).parent('tr').attr("data-remarks");
            var tank_id = jQuery(this).parent('tr').attr("data-tank_id");
            var nozzle_id = jQuery(this).parent('tr').attr("data-nozzle_id");

            jQuery("#nozzle_name").val(nozzle_name);
            jQuery("#remarks").val(remarks);
            jQuery("#tank_id").val(tank_id);
            jQuery("#nozzle_id").val(nozzle_id);
            jQuery("#edit").submit();

        });

    </script>

    <script>
        jQuery("#cancel").click(function () {

            $("#tank").select2().val(null).trigger("change");
            $("#tank > option").removeAttr('selected');

            $("#search").val('');
        });
    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#tank").select2();
        });
    </script>

    <style>
        input::-webkit-calendar-picker-indicator {
            display: none;
        }
    </style>

@endsection

