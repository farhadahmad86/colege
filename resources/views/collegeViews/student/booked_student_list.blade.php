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
                        <h4 class="text-white get-heading-text file_name">Booked Student List</h4>
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
                      action="{{ route('student_register_list')}}" name="form1" id="form1" method="post">
                    <div class="row">
                        @csrf
                        <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                            <div class="input_bx">
                                <input tabindex="1" autofocus type="search" list="browsers"
                                       class="inputs_up form-control" name="search" id="search"
                                       placeholder="All Data Search" value="{{ isset($search) ? $search : '' }}"
                                       autocomplete="off">
                                <datalist id="browsers">
                                    @foreach ($student_title as $value)
                                        <option value="{{ $value }}">
                                    @endforeach
                                </datalist>
                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                            </div>
                        </div> <!-- left column ends here -->
                        <div class="col-lg-10 col-md-9 col-sm-12 col-xs-12 text-right form_controls">
                        @include('include.clear_search_button')
                        <!-- Call add button component -->
                            <x-add-button tabindex="9" href="{{ route('add_student') }}"/>

                            @include('include/print_button')
                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                        </div>
                    </div><!-- end row -->
                </form>

                <form name="edit" id="edit" action="{{ route('create_installments') }}" method="post">
                    @csrf
                    <input name="title" id="title" type="hidden">
                    <input name="remarks" id="remarks" type="hidden">
                    <input name="student_id" id="student_id" type="hidden">
                </form>
            </div>

            <div class="table-responsive" id="printTable">
                <table class="table table-bordered table-sm" id="fixTable">

                    <thead>
                    <tr>
                        <th scope="col" class="tbl_srl_2">
                            Sr#
                        </th>
                        <th scope="col" class="tbl_txt_20">
                            Name
                        </th>
                        <th scope="col" class="tbl_txt_5">
                            Reg #
                        </th>
                        <th scope="col" class="tbl_txt_12">
                            Class
                        </th>
                        <th scope="col" class="tbl_txt_6">
                            Father Name
                        </th>
                        <th scope="col" class="tbl_txt_6">
                            Admission Date
                        </th>
                        <th scope="col" class="tbl_txt_6">
                            Branch
                        </th>
                        <th scope="col" class="tbl_txt_6">
                            Package Amount
                        </th>
                        <th scope="col" class="tbl_txt_6">
                            Discount
                        </th>
                        <th scope="col" class="tbl_txt_6">
                            Receivable
                        </th>
                        <th scope="col" class="tbl_txt_6">
                            Created By
                        </th>
                        <th scope="col" class="hide_column tbl_srl_6">
                            Package
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
                        <tr data-title="{{ $data->full_name }}" data-student_id="{{ $data->id }}">
                            <th class="">
                                {{$sr}}
                            </th>
                            <td class="">
                                <img src="{{$data->profile_pic}}" width="40px" class="rounded-circle" alt="..."> {{ $data->full_name }} {{$data->id}}
                            </td>
                            <td class="">
                                {{ $data->registration_no }}
                            </td>
                            <td class=""> {{$data->class_name}}</td>
                            <td class="">{{$data->father_name}}</td>
                            <td class="">{{$data->admission_date}}</td>

                            <td class="">{{$data->branch_name}}</td>
                            <td class="">
                                {{$data->package !=  ''?   number_format($data->package) : 0}}
                            </td>
                            <td class="">
                                {{$data->discount !=  ''?  number_format($data->discount) : 0}}
                            </td>
                            <td class="">
                                {{number_format($data->package -  $data->discount)}}
                            </td>

                            @php
                                $ip_browser_info = '' . $data->ip_adrs . ',' . str_replace(' ', '-', $data->brwsr_info) . '';
                            @endphp

                            <td class="usr_prfl " data-usr_prfl="{{ $data->user_id }}"
                                data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                {{ $data->user_name }}
                            </td>

                            <td class="text-center hide_column edit">
                                <a data-student_id="{{ $data->id }}" data-toggle="tooltip"
                                   data-placement="left" title="" data-original-title="Are you sure want to make package?">
                                    <button class="btn btn-sm btn-primary">Package</button>
                                </a>

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
                                    <h3 style="color:#554F4F">No Student</h3>
                                </center>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>

                </table>

            </div>
            <div class="row">
                <div class="col-md-3">
                    <span>Showing {{ $datas->firstItem() }} - {{ $datas->lastItem() }} of {{ $datas->total() }}</span>
                </div>
                <div class="col-md-9 text-right">
                    <span
                        class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search' => $search])->links() }}</span>
                </div>
            </div>
        </div> <!-- white column form ends here -->
    </div><!-- row end -->

@endsection

@section('scripts')


    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('student_register_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}


    <script>
        jQuery("#cancel").click(function () {
            $("#search").val('');
        });
    </script>

    <script>
        jQuery(".edit").click(function () {

            var title = jQuery(this).parent('tr').attr("data-title");
            var remarks = jQuery(this).parent('tr').attr("data-remarks");
            var student_id = jQuery(this).parent('tr').attr("data-student_id");
            jQuery("#title").val(title);
            jQuery("#remarks").val(remarks);
            jQuery("#student_id").val(student_id);
            jQuery("#edit").submit();
        });

        $('.delete').on('click', function (event) {

            var student_id = jQuery(this).attr("data-student_id");

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
                    jQuery("#id").val(student_id);
                    jQuery("#delete").submit();
                } else {

                }
            });
        });
    </script>


@endsection
