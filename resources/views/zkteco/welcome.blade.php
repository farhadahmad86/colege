@extends('extend_index')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="container-fluid search-filter form-group form_manage">
                <div class="form_header">
                    <!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 tabindex="-1" class="text-white get-heading-text">ZKTeco Machine</h4>
                        </div>

                    </div>
                </div><!-- form header close -->
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <form name="f1" class="f1" id="f1" onsubmit="return checkForm()"
                              action="{{ route('machine.devicesetip') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="row">
                                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                    <div class="input_bx">
                                                        <!-- start input box -->
                                                        <label class="required">
                                                            IP Address
                                                        </label>
                                                        <input tabindex="2" type="text" name="deviceip"
                                                               id="deviceip" class="inputs_up form-control"
                                                               placeholder="Ip Address" autocomplete="off"
                                                               value="{{ old('deviceip') }}" data-rule-required="true"
                                                               data-msg-required="Please Enter Ip Address">
                                                    </div>
                                                    <!-- end input box -->
                                                </div>
                                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                    <div class="input_bx">
                                                        <!-- start input box -->
                                                        <label class="required">
                                                            Port</label>
                                                        <input tabindex="2" type="text" name="port"
                                                               id="port" class="inputs_up form-control"
                                                               placeholder="Port" autocomplete="off"
                                                               value="{{ old('port') }}" data-rule-required="true"
                                                               data-msg-required="Please Enter Port">
                                                    </div><!-- end input box -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                                            <button tabindex="4" type="reset" name="cancel" id="cancel"
                                                    class="cancel_button btn btn-sm btn-secondary">
                                                <i class="fa fa-eraser"></i> Cancel
                                            </button>
                                            <button tabindex="5" type="button" name="save" id="save"
                                                    class="save_button btn btn-sm btn-success">
                                                <i class="fa fa-floppy-o"></i> Save
                                            </button>
                                        </div>
                                    </div>
                                </div> <!-- left column ends here -->
                            </div> <!--  main row ends here -->
                        </form>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <table class="table table-bordered table-sm">
                            <thead class="items-center">
                            <tr>
                                <th style="width: 10%">Sr#</th>
                                <th style="width: 50%">Ip</th>
                                <th style="width: 40%">Port</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($devices as $item)
                                <tr>
                                    <th>{{$item->id}}</th>
                                    <td>{{$item->ip_address}}</td>
                                    <td>{{$item->port}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="ml-12">
                    <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                        <a href="{{ route('machine.testsound') }}" class="btn btn-success btn-sm" style="margin: 5px">Test device sound</a>

                        <a href="{{ route('machine.deviceinformation') }}" class="btn btn-success btn-sm" style="margin: 5px">Device information</a>

                        <a href="{{ route('machine.devicedata') }}" class="btn btn-success btn-sm" style="margin: 5px">Device data</a>

                        <a href="{{ route('machine.devicedata.clear.attendance') }}" class="btn btn-success btn-sm" style="margin: 5px">Clear attendance</a>

                        <a href="{{ route('machine.devicerestart') }}" class="btn btn-success btn-sm" style="margin: 5px">Restart device</a>

                        <a href="{{ route('machine.deviceshutdown') }}" class="btn btn-success btn-sm" style="margin: 5px">Shutdown device</a>

                        <a href="{{ route('machine.deviceadduser') }}" class="btn btn-success btn-sm" style="margin: 5px">Add user to device</a>
                        <a href="{{ route('get_User_Attendance') }}"
                           class="btn btn-success btn-sm" style="margin: 5px">Add
                            Store User Attendance Local Database</a>

                    </div>
                </div>
            </div>
        </div> <!-- white column form ends here -->
    </div><!-- col end -->

    {{--    <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">--}}
    {{--        <div class="grid grid-cols-1 md:grid-cols-2">--}}
    {{--            <div class="p-6">--}}
    {{--                <div class="flex items-center">--}}
    {{--                    <div class="ml-4 text-lg leading-7 font-semibold"><a href="#" class=" text-gray-900 dark:text-white">--}}
    {{--                            Laravel Zkteco <b>( iclock9000-G )</b>--}}
    {{--                        </a></div>--}}
    {{--                </div>--}}
    {{--                <br/>--}}
    {{--                <div class="ml-12">--}}
    {{--                    --}}
    {{--                    <form action="{{ route('machine.devicesetip') }}" method="post">--}}
    {{--                        @csrf--}}
    {{--                        <div class="row">--}}
    {{--                            <div class="mb-3">--}}
    {{--                                <label for="deviceip" class="form-label">IP address</label>--}}
    {{--                                <input type="text" name="deviceip" class="form-control" required/>--}}
    {{--                            </div>--}}
    {{--                            <div class="mb-3">--}}
    {{--                                <label for="port" class="form-label">Port</label>--}}
    {{--                                <input type="text" name="port" class="form-control" required/>--}}
    {{--                            </div>--}}

    {{--                        </div>--}}
    {{--                        <div class="row">--}}
    {{--                            <div class="col-3 mt-3">--}}
    {{--                                <button class="btn btn-success" style="width: 100%">Set IP</button>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                    </form>--}}
    {{--                </div>--}}
    {{--            </div>--}}

    {{--            <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-t-0 md:border-l">--}}
    {{--                <div class="flex items-center">--}}

    {{--                    <div class="ml-4 text-lg leading-7 font-semibold">About devices {{$not_found}} {{$not_found_ip}} these port device not found</div>--}}
    {{--                </div>--}}

    {{--                <div class="ml-12">--}}
    {{--                    <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">--}}
    {{--                        <table style="width: 100%">--}}
    {{--                            <thead class="items-center">--}}
    {{--                            <tr>--}}
    {{--                                <th style="width: 10%">Sr#</th>--}}
    {{--                                <th style="width: 50%">Ip</th>--}}
    {{--                                <th style="width: 40%">Port</th>--}}
    {{--                            </tr>--}}
    {{--                            </thead>--}}
    {{--                            <tbody>--}}
    {{--                            @foreach($devices as $item)--}}
    {{--                                <tr>--}}
    {{--                                    <td>{{$item->id}}</td>--}}
    {{--                                    <td>{{$item->ip_address}}</td>--}}
    {{--                                    <td>{{$item->port}}</td>--}}
    {{--                                </tr>--}}
    {{--                            @endforeach--}}
    {{--                            </tbody>--}}
    {{--                        </table>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--                <hr/>--}}

{{--                    <div class="ml-12">--}}
{{--                        <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">--}}
{{--                            <a href="{{ route('machine.testsound') }}" class="btn btn-success btn-sm" style="margin: 5px">Test device sound</a>--}}

{{--                            <a href="{{ route('machine.deviceinformation') }}" class="btn btn-success btn-sm" style="margin: 5px">Device information</a>--}}

{{--                            <a href="{{ route('machine.devicedata') }}" class="btn btn-success btn-sm" style="margin: 5px">Device data</a>--}}

{{--                            <a href="{{ route('machine.devicedata.clear.attendance') }}" class="btn btn-success btn-sm" style="margin: 5px">Clear attendance</a>--}}

{{--                            <a href="{{ route('machine.devicerestart') }}" class="btn btn-success btn-sm" style="margin: 5px">Restart device</a>--}}

{{--                            <a href="{{ route('machine.deviceshutdown') }}" class="btn btn-success btn-sm" style="margin: 5px">Shutdown device</a>--}}

{{--                            <a href="{{ route('machine.deviceadduser') }}" class="btn btn-success btn-sm" style="margin: 5px">Add user to device</a>--}}
{{--                            <a href="{{ route('get_User_Attendance') }}"--}}
{{--                               class="btn btn-success btn-sm" style="margin: 5px">Add--}}
{{--                                Store User Attendance Local Database</a>--}}

{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

    {{--        </div>--}}
    {{--    </div>--}}

@endsection
