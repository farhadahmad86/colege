@extends('extend_index')

@section('content')

    <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">



        <div class="form_header"><!-- form header start -->
            <div class="clearfix">
                <div class="pull-left">
                    <h4 class="text-white get-heading-text">Create City</h4>
                </div>
                <div class="list_btn">
                    <a tabindex="-1" class="btn list_link add_more_button" href="{{route('city.index')}}" role="button">
                        <l class="fa fa-list"></l>
                        view list
                    </a>
                </div><!-- list btn -->
            </div>
        </div><!-- form header close -->

        <form name="f1" class="f1" id="f1" action="{{route('city.store')}}" method="post"
              onsubmit="return checkForm()">
            @include('modules.prerequisites.cities._form_fields')
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group row">
                        <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                            <button tabindex="-1" type="reset" name="cancel" id="cancel" class="cancel_button form-control">
                                <i class="fa fa-eraser"></i> Cancel
                            </button>
                            <button type="submit" name="save" id="save" class="save_button form-control"
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
