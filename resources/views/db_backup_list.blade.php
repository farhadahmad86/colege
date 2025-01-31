
@extends('extend_index')

@section('content')

    <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">
                    <div class="form_header"><!-- form header start -->
                        <div class="clearfix">
                            <div class="pull-left">
                                <h4 class="text-white get-heading-text file_name">Database BackUp List</h4>
                            </div>
                            <div class="list_btn list_mul">
                                <div class="srch_box_opn_icon">
                                    <i class="fa fa-search"></i>
                                </div>
                            </div><!-- list btn -->
                        </div>
                    </div><!-- form header close -->

                    <div class="search_form {{ ( !empty($search_to) || !empty($search_from) ) ? '' : 'search_form_hidden' }}">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <form class="prnt_lst_frm" action="{{ route('db_backup_list') }}" name="form1" id="form1" method="post">
                                    <div class="row">
                                        @csrf

                                        <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label>
                                                    Start Date
                                                </label>
                                                <input type="text" name="to" id="to" class="inputs_up form-control datepicker1" autocomplete="off" <?php if(isset($search_to)){?> value="{{$search_to}}" <?php } ?> placeholder="Start Date ......" />
                                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label>
                                                    End Date
                                                </label>
                                                <input type="text" name="from" id="from" class="inputs_up form-control datepicker1" autocomplete="off" <?php if(isset($search_from)){?> value="{{$search_from}}" <?php } ?> placeholder="End Date ......" />
                                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 mt-lg-2">
                                            <div class="form_controls text-center text-lg-left">


                                                <button type="button" name="cancel" id="cancel" class="cancel_button form-control">
                                                    <i class="fa fa-trash"></i> Clear
                                                </button>
                                                <button type="submit" name="filter_search" id="filter_search" class="save_button form-control" value="">
                                                    <i class="fa fa-search"></i> Search
                                                </button>

                                                <a class="save_button form-control" href="{{route('db_backup')}}" role="button">
                                                    <l class="fa fa-plus"></l> Database BackUp
                                                </a>

                                                @include('include/print_button')

                                            </div>
                                        </div>

                                    </div><!-- end row -->
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive" id="printTable">
                        <table class="table table-sm" id="fixTable">
                            <thead>
                                <tr>
                                    <th scope="col" align="center" class="text-center align_center tbl_srl_4">
                                        Sr#
                                    </th>
                                    <th scope="col" align="center" class="text-center align_center tbl_txt_84">
                                        Date/Time
                                    </th>
                                    <th scope="col" align="center" class="text-center align_center tbl_txt_8">
                                        Created By
                                    </th>
                                    <th scope="col" align="center" class="align_right text-right tbl_amnt_4 hide_column">
                                        Download
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
                                @forelse($datas as $list)

                                    <tr>
                                        <td class="align_center text-center tbl_srl_4">
                                            {{$sr}}
                                        </td>
                                        <td class="align_left text-left tbl_txt_84">
                                            {{date('d-M-y', strtotime(str_replace('/', '-', $list->dbb_created_at)))}}
                                        </td>

                                        @php
                                            $ip_browser_info= ''.$list->dbb_ip_adrs.','.str_replace(' ','-',$list->dbb_brwsr_info).'';
                                        @endphp

                                        <td class="align_left text-left usr_prfl tbl_txt_8" data-usr_prfl="{{ $list->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                            {{$list->user_name}}
                                        </td>
                                        <td class="align_right text-right tbl_amnt_4 hide_column">
                                            <form action="{{ route('download_db_file') }}" method="post">
                                                @csrf

                                                <input type="hidden" name="file_name" value="{{$list->dbb_file_name}}">

                                            <button type="submit" style="border: 0px; background: transparent;">
                                                <i class="fa fa-download"></i>
                                            </button>

                                            </form>
                                        </td>

                                    </tr>
                                    @php
                                        $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                                    @endphp
                                @empty
                                    <tr>
                                        <td colspan="11">
                                            <center><h3 style="color:#554F4F">No List</h3></center>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>
                    <span class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg])->links() }}</span>
                </div> <!-- white column form ends here -->


            </div><!-- col end -->


        </div><!-- row end -->

@endsection

@section('scripts')

    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('db_backup_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>
        jQuery("#cancel").click(function () {

            $("#to").val('');
            $("#from").val('');

        });
    </script>

    <script>
        jQuery(".restore").click(function () {

            var sql_file = jQuery(this).attr("data-sql_file");

            jQuery("#sql_file").val(sql_file);
            jQuery("#restore").submit();
        });

    </script>

@endsection

