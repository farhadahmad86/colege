@extends('extend_index')
@section('content')
    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header">
                <!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="text-white get-heading-text file_name">Class Dashboard</h4>
                    </div>
                    <div class="list_btn list_mul">
                        <div class="srch_box_opn_icon">
                            <i class="fa fa-search"></i>
                        </div>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->
            <div class="search_form m-0 p-0">
                <form class="highlight prnt_lst_frm" action="{{ route('class_dashboard') }}" name="form1" id="form1"
                      method="post">
                    <div class="row">
                        @csrf

                        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="input_bx">
                                <select class="inputs_up form-control" name="class_id" id="class_id">
                                    <option value="">Select Class</option>
                                    @foreach ($classes as $class)
                                        <option value="{{ $class->class_id }}"
                                            {{ $search_class == $class->class_id ? 'selected' : '' }}>{{ $class->class_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div> <!-- left column ends here -->
                        <div class="col-lg-9 col-md-6 col-sm-12 col-xs-12 text-right form_controls">
                        @include('include.clear_search_button')
                        <!-- Call add button component -->
                            <x-add-button tabindex="9" href="{{ route('add_class') }}"/>

                            @include('include/print_button')
                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                        </div>
                    </div><!-- end row -->
                </form>

            </div>


            <div class="row">
                @foreach ($datas as $class)
                    <div class="form-group col-lg-3 col-sm-6 col-xs-12">
                        <div class="card class-dash-card border-left">
                            <div class="card-body">
                                <h6 class="card-title">{{ $class->class_name }}</h6>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <a href="{{ url('/class_section_list', $class->class_id) }}">
                                            <div class="one-third">
                                                <h6 class="edit" data-class_id="{{ $class->class_id }}">Sections</h6>
                                                <div class="stat">
                                                    @inject('section', 'App\Models\College\Section')
                                                    @php
                                                        $sections = $section->where('section_class_id', $class->class_id)->where('section_branch_id', session('branch_id'))->count();
                                                    @endphp
                                                    <span class="text-center">{{ $sections }}</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-lg-6">
                                        <a href="#">
                                            <div class="one-third no-border">
                                                <h6 class="stat-value">Students</h6>
                                                <div class="stat">
                                                    @inject('student', 'App\Models\College\Student')
                                                    <span class="text-center">{{ $student->where('class_id', $class->class_id)->where('branch_id', session('branch_id'))->count() }}</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>


            <div class="row">
                <div class="col-md-3">
                    <span>Showing {{ $datas->firstItem() }} - {{ $datas->lastItem() }} of {{ $datas->total() }}</span>
                </div>
                <div class="col-md-9 text-right">
                    <span class="hide_column">{{ $datas->appends(['class' => $search_class])->links() }}</span>
                </div>
            </div>
        </div> <!-- white column form ends here -->
    </div><!-- row end -->
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            $('#class_id').select2();
        });
    </script>
    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        $('#class_id').select2();
        var base = '{{ route('class_dashboard') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}


    <script>
        jQuery("#cancel").click(function () {
            $("#class_id").select2().val(null).trigger("change");
            $("#class_id > option").removeAttr('selected');
        });
    </script>
@endsection
