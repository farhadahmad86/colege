
@extends('extend_index')

@section('content')

    <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">
                    <div class="form_header"><!-- form header start -->
                        <div class="clearfix">
                            <div class="pull-left">
                                <h4 class="text-white get-heading-text">Database Backup (Description)</h4>
                            </div>
                            <div class="list_btn">
                                <a class="btn list_link add_more_button" href="{{ route('db_backup_list') }}" role="button">
                                    <l class="fa fa-list"></l> view list
                                </a>
                            </div><!-- list btn -->
                        </div>
                    </div><!-- form header close -->


                    <div class="row">
                        <div class="col-md-12">
                            <div class="tile">
{{--                                <ul>--}}
{{--                                    <li>Built with Bootstrap 4, SASS and PUG.js</li>--}}
{{--                                    <li>Fully responsive and modular code</li>--}}
{{--                                    <li>Seven pages including login, user profile and print friendly invoice page</li>--}}
{{--                                    <li>Smart integration of forgot password on login page</li>--}}
{{--                                    <li>Chart.js integration to display responsive charts</li>--}}
{{--                                    <li>Widgets to effectively display statistics</li>--}}
{{--                                    <li>Data tables with sort, search and paginate functionality</li>--}}
{{--                                    <li>Custom form elements like toggle buttons, auto-complete, tags and date-picker</li>--}}
{{--                                    <li>A inbuilt toast library for providing meaningful response messages to user's actions--}}
{{--                                    </li>--}}
{{--                                </ul>--}}
{{--                                <p>Vali is a free and responsive admin theme built with Bootstrap 4, SASS and PUG.js. It's fully--}}
{{--                                    customizable and modular.</p>--}}
{{--                                <p>Vali is is light-weight, expendable and good looking theme. The theme has all the features--}}
{{--                                    required--}}
{{--                                    in a dashboard theme but this features are built like plug and play module. Take a look at--}}
{{--                                    the <a--}}
{{--                                    >documentation</a> about--}}
{{--                                    customizing the theme colors and functionality.</p>--}}
                                <p class="mt-4 mb-4">
                                    <a href="{{ route('submit_db_backup') }}" class="btn btn-danger mr-2 mb-2">Database Backup</a>
                                </p>
                            </div>
                        </div>
                    </div>

                </div> <!-- white column form ends here -->


            </div><!-- col end -->


        </div><!-- row end -->

@endsection


