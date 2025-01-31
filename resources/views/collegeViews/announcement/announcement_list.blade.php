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
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header">
                <!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="text-white get-heading-text file_name">Announcement List</h4>
                    </div>
                    <div class="list_btn list_mul">
                        <div class="srch_box_opn_icon">
                            <i class="fa fa-search"></i>
                        </div>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->
            <div class="search_form m-0 p-0">
                <form class="highlight prnt_lst_frm"
                      action="{{ route('announcement_list') }}"
                      name="form1" id="form1" method="post">
                    <div class="row">
                        @csrf
                        <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                            <div class="input_bx">
                                <label>
                                    All Data Search
                                </label>
                                <input tabindex="1" autofocus type="search" list="browsers"
                                       class="inputs_up form-control" name="search" id="search"
                                       placeholder="Search By Title" value="{{ isset($search) ? $search : '' }}"
                                       autocomplete="off">
                                <datalist id="browsers">
                                    @foreach ($announcement_title as $value)
                                        <option value="{{ $value }}">
                                    @endforeach
                                </datalist>
                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                            </div>
                        </div> <!-- left column ends here -->
                        <x-year-end-component search="{{$search_year}}"/>
                        <div class="col-lg-10 col-md-6 col-sm-12 col-xs-12 text-right form_controls">
                            @include('include.clear_search_button')
                            <!-- Call add button component -->
                            <x-add-button tabindex="9" href="{{ route('announcement') }}"/>

{{--                            @include('include/print_button')--}}
                        </div>
                    </div><!-- end row -->
                </form>
                {{--                <form name="edit" id="edit" action="{{ route('edit_component') }}" method="post">--}}
                {{--                    @csrf--}}
                {{--                    <input name="an_id" id="sfc_id" type="hidden">--}}
                {{--                    <input name="sfc_name" id="sfc_name" type="hidden">--}}
                {{--                    <input name="sfc_amount" id="sfc_amount" type="hidden">--}}
                {{--                    <input name="cr_acc_id" id="cr_acc_id" type="hidden">--}}
                {{--                    <input name="dr_acc_id" id="dr_acc_id" type="hidden">--}}
                {{--                </form>--}}
                {{--                <form name="delete" id="delete" action="{{ route('delete_college_groups') }}" method="post">--}}
                {{--                    @csrf--}}
                {{--                    <input name="group_id" id="group_id" type="hidden">--}}
                {{--                </form>--}}
            </div>

            <div class="table-responsive" id="printTable">
                <table class="table table-bordered table-sm" id="fixTable">

                    <thead>
                    <tr>
                        <th scope="col" class="tbl_srl_2">
                            Sr
                        </th>
                        <th scope="col" class="tbl_txt_24">
                            Announcement Title
                        </th>
                        <th scope="col" class="tbl_txt_24">
                            Announcement Description
                        </th>
                        <th scope="col" class="tbl_txt_22">
                            Class
                        </th>
{{--                        <th scope="col" class="tbl_txt_6">--}}
{{--                            Sections--}}
{{--                        </th>--}}
                        <th scope="col" class="tbl_txt_12">
                            Branch
                        </th>
                        <th scope="col" class="tbl_txt_10">
                            Created By
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                    @php
                        $segmentSr = !empty(app('request')->input('segmentSr')) ? app('request')->input('segmentSr') : '';
                        $segmentPg = !empty(app('request')->input('page')) ? app('request')->input('page') : '';
                        $sr = !empty($segmentSr) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                        $countSeg = !empty($segmentSr) ? $segmentSr : 0;
                    @endphp
                    @forelse($datas as $data)
                        <tr>
                            <th scope="row">
                                {{ $sr }}
                            </th>
                            {{-- <th scope="row" class="edit ">
                                {{ $data->group_id }}
                            </th> --}}
                            <td class="edit ">
                                {{ $data->an_title }}
                            </td>
                            <td class="edit ">
                                {{ $data->an_description }}
                            </td>
                            <td class="edit ">
                                {{ $data->class_name }}
                            </td>
{{--                            <td>--}}
{{--                                {{ $data->cs_name }}--}}
{{--                            </td>--}}
                            <td>
                                {{ $data->branch_name }}
                            </td>

                            <td class="usr_prfl">
                                {{ $data->user_name }}
                            </td>
                        </tr>
                        @php
                            $sr++;
                            !empty($segmentSr) && $countSeg !== '0' ?: $countSeg++;
                        @endphp
                    @empty
                        <tr>
                            <td colspan="11">
                                <center>
                                    <h3 style="color:#554F4F">No Announcement</h3>
                                </center>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div> <!-- white column form ends here -->
    </div><!-- row end -->

@endsection

@section('scripts')
    <script>
        jQuery("#cancel").click(function () {
            $("#search").val('');
        });
    </script>
@endsection
