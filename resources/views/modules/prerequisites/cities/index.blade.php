{{--@extends('layouts.app')--}}
@extends('extend_index')

@section('content')
    {{--    <div class="container">--}}
    {{--        <div class="content-justify-center row">--}}
    {{--            <div class="col-md-12">--}}

    {{--                <div class="card">--}}
    {{--                    <div class="card-header">--}}
    {{--                        <h3 class="m-0">--}}
    {{--                            Companies <small>({{ $companies->total() }})</small>--}}
    {{--                            <a href="{{ route('companies.create') }}" class="btn btn-sm btn-primary float-right">Create</a>--}}
    {{--                        </h3>--}}
    {{--                    </div>--}}
    {{--                    <div class="card-body">--}}
    {{--                        @include('modules.prerequisites.company._table')--}}
    {{--                    </div>--}}
    {{--                </div>--}}

    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}

    <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">


        <div class="form_header"><!-- form header start -->
            <div class="clearfix">
                <div class="pull-left">
                    <h4 class="text-white get-heading-text file_name">City List</h4>
                </div>
                <div class="list_btn list_mul">
                    <div class="srch_box_opn_icon">
                        <i class="fa fa-search"></i>
                    </div>
                </div><!-- list btn -->
            </div>
        </div><!-- form header close -->

        @include('modules.prerequisites.cities._table')

    </div> <!-- white column form ends here -->
@stop
