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
                        <h4 class="text-white get-heading-text file_name">Student Ledger ({{$student_name}})</h4>
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
                      action="{{ route('student_ledger') }}"
                      name="form1" id="form1" method="post">
                    <div class="row">
                        @csrf
{{--                        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">--}}
{{--                            <div class="input_bx">--}}
{{--                                <input tabindex="1" autofocus type="search" list="browsers"--}}
{{--                                       class="inputs_up form-control" name="search" id="search"--}}
{{--                                       placeholder="All Data Search" value="{{ isset($search) ? $search : '' }}"--}}
{{--                                       autocomplete="off">--}}
{{--                                <datalist id="browsers">--}}
{{--                                    @foreach ($student_title as $value)--}}
{{--                                        <option value="{{ $value }}">--}}
{{--                                    @endforeach--}}
{{--                                </datalist>--}}
{{--                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>--}}
{{--                            </div>--}}
{{--                        </div> <!-- left column ends here -->--}}
                        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="input_bx">
                                <select class="inputs_up form-control" name="student" id="student">
                                    <option value="">Select Student</option>
                                    @foreach($students as $student)
                                        <option value="{{$student->id}}" {{$search_student == $student->id ? 'selected':''}}>({{$student->full_name}}) - ({{$student->registration_no}})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> <!-- left column ends here -->
                        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 text-right form_controls">
                        @include('include.clear_search_button')
                        <!-- Call add button component -->
                            <x-add-button tabindex="9" href="{{ route('add_student') }}" />

                            @include('include/print_button')
                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                        </div>
                    </div><!-- end row -->
                </form>
                <form name="edit" id="edit" action="{{ route('edit_student') }}" method="post">
                    @csrf
                    <input name="title" id="title" type="hidden">
                    <input name="remarks" id="remarks" type="hidden">
                    <input name="student_id" id="student_id" type="hidden">
                </form>
                <form name="delete" id="delete" action="{{ route('delete_student') }}" method="post">
                    @csrf
                    <input name="id" id="id" type="hidden">
                </form>
            </div>

            <div class="table-responsive" id="printTable">
                <table class="table table-bordered table-sm" id="fixTable">

                    <thead>
                    <tr>
                        <th scope="col" class="tbl_srl_4">
                            Sr#
                        </th>
                        <th scope="col" class="tbl_txt_20">
                            Name
                        </th>
                        <th scope="col" class="tbl_txt_10">
                            Date
                        </th>
                        <th scope="col" class="tbl_txt_10">
                            Transaction Type
                        </th>
                        <th scope="col" class="tbl_txt_20">
                            Remarks
                        </th>
                        <th scope="col" class="tbl_txt_12">
                            Dr
                        </th>
                        <th scope="col" class="tbl_txt_12">
                            Cr
                        </th>
                        <th scope="col" class="tbl_txt_12">
                            Balance
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
                            <th>{{$sr}}</th>
                            <td>{{ $data->full_name }}</td>
                            <td>{{ $data->sbal_datetime }}</td>
                            <td> {{$data->sbal_transaction_type}}</td>
                            <td>   {!! str_replace("&oS;",'<br />', $data->sbal_detail_remarks) !!}</td>
                            <td> {{$data->sbal_dr}}</td>
                            <td>{{$data->sbal_cr}}</td>
                            <td>{{$data->sbal_total}}</td>

                        </tr>
                        @php
                            $sr++;
                            !empty($segmentSr) && $countSeg !== '0' ?: $countSeg++;
                        @endphp
                    @empty
                        <tr>
                            <td colspan="11">
                                <center>
                                    <h3 style="color:#554F4F">No Ledger</h3>
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
                        class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'student' => $search_student])->links() }}</span>
                </div>
            </div>
        </div> <!-- white column form ends here -->
    </div><!-- row end -->

@endsection

@section('scripts')


    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('student_ledger') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>
        $(document).ready(function() {
            $('#student').select2();
        });
    </script>

    <script>
        jQuery("#cancel").click(function() {
            $("#student").val('');
        });
    </script>

@endsection
