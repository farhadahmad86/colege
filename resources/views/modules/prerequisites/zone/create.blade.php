{{--@extends('layouts.app')--}}

{{--@section('content')--}}
{{--    <div class="container">--}}
{{--        <div class="content-justify-center row">--}}
{{--            <div class="col-md-12">--}}

{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        <h3 class="m-0">--}}
{{--                            Create Zone--}}
{{--                            <a href="{{ route('zones.index') }}" class="btn btn-sm btn-primary float-right">Zones</a>--}}
{{--                        </h3>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}

{{--                        <form action="{{ route('zones.store') }}" method="post">--}}
{{--                            @include('modules.prerequisites.zone._form_fields')--}}

{{--                            <div class="form-row">--}}
{{--                                <div class="form-group col-md-12 text-center">--}}
{{--                                    <button type="submit" class="btn btn-primary">Save Zone</button>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </form>--}}

{{--                    </div>--}}
{{--                </div>--}}

{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@stop--}}

@extends('extend_index')

@section('content')

    <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">

        <div class="close_info_bx"><!-- info bx start -->
            <i class="fa fa-expand"></i>
        </div><!-- info bx end -->

        <div class="form_header"><!-- form header start -->
            <div class="clearfix">
                <div class="pull-left">
                    <h4 tabindex=-1 class="text-white get-heading-text">Create Region</h4>
                </div>
                <div class="list_btn">
                    <a tabindex=-1 class="btn list_link add_more_button" href="{{route('zones.list')}}" role="button">
                        <l class="fa fa-list"></l>
                        view list
                    </a>
                </div><!-- list btn -->
            </div>
        </div><!-- form header close -->


        <form name="f1" class="f1" id="f1"
{{--              action="{{route('zones.store')}}" method="post"--}}
              onsubmit="return checkForm()">
            @include('modules.prerequisites.zone._form_fields')
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group row">
                        <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                            <button tabindex="7" type="reset" name="cancel" id="cancel" class="cancel_button form-control">
                                <i class="fa fa-eraser"></i> Cancel
                            </button>
                            <button tabindex="8" type="button" name="save" onclick="saveFunction();" id="save" class="save_button form-control"
{{--                                    onclick="return form_validation()"--}}
                            >
                                <i class="fa fa-floppy-o"></i> Save
                            </button>
                        </div>
                    </div>

                </div> <!-- left column ends here -->
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    {{--<div class="show_info_div">--}}

                    {{--</div>--}}

                </div> <!-- right columns ends here -->

            </div> <!--  main row ends here -->


        </form>
    </div> <!-- white column form ends here -->


    {{--</div>--}}
    <!-- col end -->
@stop

