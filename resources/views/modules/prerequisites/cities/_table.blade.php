<div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">

    {{--        <div class="close_info_bx"><!-- info bx start -->--}}
    {{--            <i class="fa fa-expand"></i>--}}
    {{--        </div><!-- info bx end -->--}}

    {{--        <div class="form_header"><!-- form header start -->--}}
    {{--            <div class="clearfix">--}}
    {{--                <div class="pull-left">--}}
    {{--                    <h4 class="text-white get-heading-text file_name">Company List</h4>--}}
    {{--                </div>--}}
    {{--                <div class="list_btn list_mul">--}}
    {{--                    <div class="srch_box_opn_icon">--}}
    {{--                        <i class="fa fa-search"></i>--}}
    {{--                    </div>--}}
    {{--                </div><!-- list btn -->--}}
    {{--            </div>--}}
    {{--        </div><!-- form header close -->--}}
{{--    <div class="search_form {{ ( !empty($search) || !empty($search_region) ) ? '' : 'search_form_hidden' }}">--}}

    <div class="search_form">
        <div class="row">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                <form class="prnt_lst_frm" action="{{ route('region_list') }}" name="form1" id="form1" method="post">
                    <div class="row">
                        @csrf
                        <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                            <div class="input_bx"><!-- start input box -->
                                <label>
                                    All Column Search
                                </label>
                                <input tabindex="1" autofocus type="search" list="browsers" class="inputs_up form-control" name="search"
                                       id="search" placeholder="All Data Search"
                                       value="{{ isset($search) ? $search : '' }}" autocomplete="off">
                                <datalist id="browsers">
                                    {{--                                        @foreach($reg_title as $value)--}}
                                    {{--                                            <option value="{{$value}}">--}}
                                    {{--                                        @endforeach--}}
                                </datalist>
                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                            </div>
                        </div> <!-- left column ends here -->


                        {{--                            <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">--}}
                        {{--                                <div class="form_controls text-left">--}}

                        {{--                                    <button tabindex="-1" type="button" name="cancel" id="cancel" class="cancel_button form-control">--}}
                        {{--                                        <i class="fa fa-trash"></i> Clear--}}
                        {{--                                    </button>--}}
                        {{--                                    <button tabindex="-1" type="submit" name="filter_search" id="filter_search" class="save_button form-control" value="">--}}
                        {{--                                        <i class="fa fa-search"></i> Search--}}
                        {{--                                    </button>--}}

                        {{--                                    <a tabindex="-1" class="save_button form-control" href="{{ route('add_region') }}" role="button">--}}
                        {{--                                        <l class="fa fa-plus"></l> Region--}}
                        {{--                                    </a>--}}

                        {{--                                    @include('include/print_button')--}}

                        {{--                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>--}}

                        {{--                                </div>--}}
                        {{--                            </div>--}}


                    </div><!-- end row -->
                </form>


                <form name="edit" id="edit" action="{{ route('edit_region') }}" method="post">
                    @csrf
                    <input tabindex="-1" name="title" id="title" type="hidden">
                    <input tabindex="-1" name="remarks" id="remarks" type="hidden">
                    <input tabindex="-1" name="region_id" id="region_id" type="hidden">

                </form>

                <form name="delete" id="delete" action="{{ route('delete_region') }}" method="post">
                    @csrf
                    <input name="reg_id" id="reg_id" type="hidden">
                </form>

            </div>

        </div>
    </div>

    <div class="table-responsive" id="printTable">
        <table class="table table-sm" id="fixTable">

            <thead>
            <tr>
                <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_srl_4">
                    Sr#
                </th>
                <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_txt_41">
                    Title
                </th>
                <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_srl_6">
                    Status
                </th>
                <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_txt_35">
                    Remarks
                </th>
                <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_txt_8">
                    Created By
                </th>
                <th tabindex="-1" scope="col" align="center" class="text-center align_center hide_column tbl_srl_6">
                    Action
                </th>
            </tr>
            </thead>

            <tbody>
            {{--                @php--}}
            {{--                    $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';--}}
            {{--                    $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';--}}
            {{--                    $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;--}}
            {{--                    $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;--}}
            {{--                @endphp--}}
            @forelse($cityCrud as $index => $data)

                <tr data-title="{{$data->name}}" data-remarks="{{$data->remarks}}"
                    data-company_id="{{$data->id}}">
                    <td class="align_center text-center edit tbl_srl_4">
                        {{--                            {{$sr}}--}}
                        {{$index + 1}}
                    </td>
                    <td class="align_left text-left edit tbl_txt_41">
                        {{$data->name}}
                    </td>
                    <td class="align_left text-left edit tbl_srl_6">
                        {{$data->status}}
                    </td>
                    <td class="align_left text-left edit tbl_txt_35">
                        {{$data->remarks }}
                    </td>

                    @php
                        $ip_browser_info= ''.$data->reg_ip_adrs.','.str_replace(' ','-',$data->reg_brwsr_info).'';
                    @endphp

                    {{--                    <td class="align_left text-left usr_prfl tbl_txt_8" data-usr_prfl="{{ $data->created_by }}"--}}
                    {{--                        data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">--}}
                    {{--                    {{$data->user_name}}--}}
                    {{--                    </td>--}}
                    <td>{{ $data->createdBy->user_name }}</td>
                    {{--                    <td class="align_center hide_column">--}}
                    {{--                        <a class="edit" style="cursor:pointer;">--}}
                    {{--                            <i class="fa fa-edit"></i>--}}
                    {{--                        </a>--}}
                    {{--                    </td>--}}
                    {{--                    <td class="align_right text-right hide_column tbl_srl_6">--}}
                    {{--                        <a data-company_id="{{$data->id}}" class="delete" data-toggle="tooltip" data-placement="left"--}}
                    {{--                           title="" data-original-title="Are you sure?">--}}
                    {{--                            <i class="fa fa-{{$data->reg_delete_status == 1 ? 'undo':'trash'}}"></i>--}}
                    {{--                        </a>--}}
                    {{--                    </td>--}}

                    <td>
                        <a href="{{ route('city.edit', ['crudCity' => $data]) }}" class="btn btn-sm btn-warning d-inline"><i
                                class="fa fa-edit"></i></a>
                        <form action="{{ route('city.destroy', $data) }}" method="post" class="d-inline">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-sm btn-danger d-inline"><i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                {{--                    @php--}}
                {{--                        $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;--}}
                {{--                    @endphp--}}
            @empty
                <tr>
                    <td colspan="11">
                        <center><h3 style="color:#554F4F">No City</h3></center>
                    </td>
                </tr>
            @endforelse
            </tbody>

        </table>


    </div>
    {{--        <span class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search ])->links() }}</span>--}}
</div> <!-- white column form ends here -->
