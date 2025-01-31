
@extends('extend_index')

@section('content')

    <div class="row">


        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">


            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">



                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Edit Database</h4>
                        </div>
                    </div>
                </div><!-- form header close -->

                <form name="f1" class="f1" id="f1" action="{{route('database.update')}}" onsubmit="return checkForm()" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="row">

                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

                                    <div class="row">
                                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label class="required">

                                                    Client Title
                                                </label>
                                                <select name="client_name" class="inputs_up form-control" id="client_name" autofocus data-rule-required="true" data-msg-required="Please Enter Client
                                                Title"
                                                        autofocus style="width: 100%">
                                                    <option value="">Select Client</option>
                                                    @foreach($clients as $client)
                                                        <option value="{{$client->account_uid}}" {{ $client->account_uid == $request->client_id ? 'selected="selected"' : ''
                                                        }}>{{$client->account_name}}</option>
                                                    @endforeach
                                                </select>
                                                <span id="demo1" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>

                                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label class="required">

                                                    Database Title
                                                </label>
                                                <input type="text" name="database_name" id="database_name" class="inputs_up form-control"
                                                       data-rule-required="true" data-msg-required="Please Enter Database Title"
                                                       placeholder="Database Title" value="{{$request->db_name}}" autocomplete="off">
                                                <span id="demo2" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>
                                    </div>

                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="row">

                                        <input value="{{$request->db_id}}" type="hidden" name="db_id">
                                    </div>
                                </div>

                            </div>

                            <div class="form-group row">
                                <div class="col-lg-6 col-md-12 col-sm-12 form_controls">
                                    <button type="button" name="cancel" id="cancel" class="cancel_button form-control">
                                        <i class="fa fa-eraser"></i> Cancel
                                    </button>
                                    <button type="submit" name="save" id="save" class="save_button form-control"
                                    >
                                        <i class="fa fa-floppy-o"></i> Save
                                    </button>
                                </div>
                            </div>

                        </div> <!-- left column ends here -->

                    </div> <!--  main row ends here -->


                </form>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let client_name = document.getElementById("client_name"),
                database_name = document.getElementById("database_name"),
                validateInputIdArray = [
                    client_name.id,
                    database_name.id,
                ];
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
    {{-- end of required input validation --}}
    <script type="text/javascript">

        function validate_form()
        {
            var region_name  = document.getElementById("region_name").value;
            var area_name  = document.getElementById("area_name").value;
            var remarks  = document.getElementById("remarks").value;

            var flag_submit = true;
            var focus_once = 0;

            if(region_name.trim() == "")
            {
                document.getElementById("demo1").innerHTML = "Required";
                if (focus_once == 0) { jQuery("#region_name").focus(); focus_once = 1;}
                flag_submit = false;
            }else{
                document.getElementById("demo1").innerHTML = "";
            }

            if(area_name.trim() == "")
            {
                document.getElementById("demo2").innerHTML = "Required";
                if (focus_once == 0) { jQuery("#area_name").focus(); focus_once = 1;}
                flag_submit = false;
            }else{
                document.getElementById("demo2").innerHTML = "";
            }

            // if(remarks.trim() == "")
            // {
            //     document.getElementById("demo3").innerHTML = "Required";
            //     if (focus_once == 0) { jQuery("#remarks").focus(); focus_once = 1;}
            //     flag_submit = false;
            // }else{
            //     document.getElementById("demo3").innerHTML = "";
            // }


            return flag_submit;
        }
    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#client_name").select2();

        });
    </script>

@endsection

