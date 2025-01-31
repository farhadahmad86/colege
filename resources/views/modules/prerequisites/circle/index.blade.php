@extends('extend_index')

@section('content')
{{--    <div class="container">--}}
{{--        <div class="content-justify-center row">--}}
{{--            <div class="col-md-12">--}}

{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        <h3 class="m-0">--}}
{{--                            Circles <small>({{ $circles->total() }})</small>--}}
{{--                            <a href="{{ route('circles.create') }}" class="btn btn-sm btn-primary float-right">Create</a>--}}
{{--                        </h3>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        @include('modules.prerequisites.circle._table')--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@stop--}}



<div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">

    <div class="close_info_bx"><!-- info bx start -->
        <i class="fa fa-expand"></i>
    </div><!-- info bx end -->

    <div class="form_header"><!-- form header start -->
        <div class="clearfix">
            <div class="pull-left">
                <h4 class="text-white get-heading-text file_name">Circles List</h4>
            </div>
            <div class="list_btn list_mul">
                <div class="srch_box_opn_icon">
                    <i class="fa fa-search"></i>
                </div>
            </div><!-- list btn -->
        </div>
    </div><!-- form header close -->


    {{--        <div class="search_form {{ ( !empty($search) || !empty($search_region) ) ? '' : 'search_form_hidden' }}">--}}
    {{--            <div class="row">--}}

    {{--                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">--}}

    {{--                    <form class="prnt_lst_frm" action="{{ route('region_list') }}" name="form1" id="form1"--}}
    {{--                          method="post">--}}
    {{--                        <div class="row">--}}
    {{--                            @csrf--}}
    {{--                            <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">--}}
    {{--                                <div class="input_bx"><!-- start input box -->--}}
    {{--                                    <label>--}}
    {{--                                        All Column Search--}}
    {{--                                    </label>--}}
    {{--                                    <input tabindex="1" autofocus type="search" list="browsers" class="inputs_up form-control" name="search"--}}
    {{--                                           id="search" placeholder="All Data Search"--}}
    {{--                                           value="{{ isset($search) ? $search : '' }}" autocomplete="off">--}}
    {{--                                    <datalist id="browsers">--}}
    {{--                                        --}}{{--                                        @foreach($reg_title as $value)--}}
    {{--                                        --}}{{--                                            <option value="{{$value}}">--}}
    {{--                                        --}}{{--                                        @endforeach--}}
    {{--                                    </datalist>--}}
    {{--                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>--}}
    {{--                                </div>--}}
    {{--                            </div> <!-- left column ends here -->--}}


    {{--                            <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">--}}
    {{--                                <div class="form_controls text-left">--}}

    {{--                                    <button tabindex="-1" type="button" name="cancel" id="cancel" class="cancel_button form-control">--}}
    {{--                                        <i class="fa fa-trash"></i> Clear--}}
    {{--                                    </button>--}}
    {{--                                    <button tabindex="-1" type="submit" name="filter_search" id="filter_search"--}}
    {{--                                            class="save_button form-control" value="">--}}
    {{--                                        <i class="fa fa-search"></i> Search--}}
    {{--                                    </button>--}}

    {{--                                    <a tabindex="-1" class="save_button form-control" href="{{ route('add_region') }}" role="button">--}}
    {{--                                        <l class="fa fa-plus"></l>--}}
    {{--                                        Region--}}
    {{--                                    </a>--}}

    {{--                                    @include('include/print_button')--}}

    {{--                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>--}}

    {{--                                </div>--}}
    {{--                            </div>--}}


    {{--                        </div><!-- end row -->--}}
    {{--                    </form>--}}


    {{--                    <form name="edit" id="edit" action="{{ route('edit_region') }}" method="post">--}}
    {{--                        @csrf--}}
    {{--                        <input name="title" id="title" type="hidden">--}}
    {{--                        <input name="remarks" id="remarks" type="hidden">--}}
    {{--                        <input name="region_id" id="region_id" type="hidden">--}}

    {{--                    </form>--}}

    {{--                    <form name="delete" id="delete" action="{{ route('delete_region') }}" method="post">--}}
    {{--                        @csrf--}}
    {{--                        <input name="reg_id" id="reg_id" type="hidden">--}}
    {{--                    </form>--}}

    {{--                </div>--}}

    {{--            </div>--}}
    {{--        </div>--}}

    {{--        <div class="table-responsive" id="printTable">--}}
    {{--            <table class="table table-sm" id="fixTable">--}}

    {{--                <thead>--}}
    {{--                <tr>--}}
    {{--                    <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_srl_4">--}}
    {{--                        Sr#--}}
    {{--                    </th>--}}
    {{--                    <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_txt_41">--}}
    {{--                        Title--}}
    {{--                    </th>--}}
    {{--                    <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_txt_41">--}}
    {{--                        Remarks--}}
    {{--                    </th>--}}
    {{--                    <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_txt_8">--}}
    {{--                        Created By--}}
    {{--                    </th>--}}
    {{--                    <th tabindex="-1" scope="col" align="center" class="text-center align_center hide_column tbl_srl_6">--}}
    {{--                        Action--}}
    {{--                    </th>--}}
    {{--                </tr>--}}
    {{--                </thead>--}}

    {{--                <tbody>--}}
    {{--                @php--}}
    {{--                    $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';--}}
    {{--                    $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';--}}
    {{--                    $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;--}}
    {{--                    $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;--}}
    {{--                @endphp--}}
    {{--                @forelse($datas as $data)--}}

    {{--                    <tr data-title="{{$data->reg_title}}" data-remarks="{{$data->reg_remarks}}" data-region_id="{{$data->reg_id}}">--}}
    {{--                        <td class="align_center text-center edit tbl_srl_4">--}}
    {{--                            {{$sr}}--}}
    {{--                        </td>--}}
    {{--                        <td class="align_left text-left edit tbl_txt_41">--}}
    {{--                            {{$data->reg_title}}--}}
    {{--                        </td>--}}
    {{--                        <td class="align_left text-left edit tbl_txt_41">--}}
    {{--                            {{$data->reg_remarks }}--}}
    {{--                        </td>--}}

    {{--                        @php--}}
    {{--                            $ip_browser_info= ''.$data->reg_ip_adrs.','.str_replace(' ','-',$data->reg_brwsr_info).'';--}}
    {{--                        @endphp--}}

    {{--                        <td class="align_left text-left usr_prfl tbl_txt_8" data-usr_prfl="{{ $data->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">--}}
    {{--                            {{$data->user_name}}--}}
    {{--                        </td>--}}
    {{--                        --}}{{--                                        <td class="align_center hide_column">--}}
    {{--                        --}}{{--                                            <a class="edit" style="cursor:pointer;">--}}
    {{--                        --}}{{--                                                <i class="fa fa-edit"></i>--}}
    {{--                        --}}{{--                                            </a>--}}
    {{--                        --}}{{--                                        </td>--}}
    {{--                        <td class="align_right text-right hide_column tbl_srl_6">--}}
    {{--                            <a data-region_id="{{$data->reg_id}}" class="delete"  data-toggle="tooltip" data-placement="left"  title="" data-original-title="Are you sure?">--}}
    {{--                                <i class="fa fa-{{$data->reg_delete_status == 1 ? 'undo':'trash'}}"></i>--}}
    {{--                            </a>--}}
    {{--                        </td>--}}
    {{--                    </tr>--}}
    {{--                    @php--}}
    {{--                        $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;--}}
    {{--                    @endphp--}}
    {{--                @empty--}}
    {{--                    <tr>--}}
    {{--                        <td colspan="11">--}}
    {{--                            <center><h3 style="color:#554F4F">No Region</h3></center>--}}
    {{--                        </td>--}}
    {{--                    </tr>--}}
    {{--                @endforelse--}}
    {{--                </tbody>--}}

    {{--            </table>--}}
    @include('modules.prerequisites.circle._table')
    {{--        </div>--}}
    {{--        <span class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search ])->links() }}</span>--}}
</div> <!-- white column form ends here -->

@stop
