@extends('extend_index')

@section('content')

    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 tabindex="-1" class="text-white get-heading-text">Create Database</h4>
                        </div>
                        <div class="list_btn">
                            <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('database.index') }}" role="button">
                                <i class="fa fa-list"></i> view list
                            </a>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

                <form name="f1" class="f1" id="f1" onsubmit="return checkForm()" action="{{ route('database_store') }}" method="post">
                    @csrf
                    <div class="col-lg-6 col-md-8 col-sm-12 mx-auto">
                    <div class="row">
                        <div class="form-group col-lg-6 col-md-6 col-sm-12">
                            <div class="input_bx"><!-- start input box -->
                                <label class="required">
                                    Client Title
                                    {{-- <a href="{{ route('add_region') }}" role="button" class="add_btn" TARGET="_blank" data-container="body" data-toggle="popover" data-trigger="hover"--}}
                                    {{--    data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">--}}
                                    {{--     <i class="fa fa-plus"></i>--}}
                                    {{-- </a>--}}
                                    {{-- <a class="add_btn" id="refresh_region" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true"--}}
                                    {{--    data-content="{{config('fields_info.about_form_fields.refresh.description')}}">--}}
                                    {{--     <i class="fa fa-refresh"></i>--}}
                                    {{-- </a>--}}

                                </label>
                                <select tabindex="1" autofocus name="client_id" class="inputs_up form-control required" id="client_id" autofocus data-rule-required="true"
                                        data-msg-required="Please Enter Client Title">
                                    <option value="">Select Client</option>

                                    @foreach($clients as $client)
                                        <option value="{{$client->account_uid}}">{{$client->account_name}}</option>
                                    @endforeach

                                </select>
                                <span id="demo1" class="validate_sign"> </span>
                            </div><!-- end input box -->

                        </div>

                        <div class="form-group col-lg-6 col-md-6 col-sm-12">
                            <div class="input_bx"><!-- start input box -->
                                <label class="required">
                                    Database Title</label>
                                <input tabindex="2" type="text" name="database_name" id="database_name" class="inputs_up form-control" placeholder="Database Title" autocomplete="off"
                                        value="{{ old('database_name') }}" data-rule-required="true" data-msg-required="Please Enter Database Title">
                                <span id="demo2" class="validate_sign"> </span>
                            </div><!-- end input box -->
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                            <button tabindex="4" type="reset" name="cancel" id="cancel" class="cancel_button btn btn-sm btn-secondary">
                                <i class="fa fa-eraser"></i> Cancel
                            </button>
                            <button tabindex="5" type="submit" name="save" id="save" class="save_button btn btn-sm btn-success">
                                <i class="fa fa-floppy-o"></i> Save
                            </button>
                        </div>
                    </div>
                    </div>
                </form>
            </div> <!-- white column form ends here -->
    </div><!-- row end -->

@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let client_id = document.getElementById("client_id"),
                database_name = document.getElementById("database_name");
            validateInputIdArray = [
                client_id.id,
                database_name.id,
            ];
            return validateInventoryInputs(validateInputIdArray);

        }
    </script>
    {{-- end of required input validation --}}
    <script>
        // $("#save").click(function () {
        //     checkForm();
        // });
    </script>
    <script>
        $(window).keydown(function (event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });

        $(function () {
            $('[data-toggle="popover"]').popover()
        });
    </script>


    <script type="text/javascript">
        $('#client_id').select2();

    </script>
@endsection


