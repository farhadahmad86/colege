@extends('extend_index')

@section('content')
    <style>
        .custom-checkbox {
            float: unset;
        }

        table {
            width: 100%
        }

        table tbody tr td {
            padding-left: 5px;
            width: 15%;
        }

        table tbody tr td:first-child {
            width: 70%;
        }

        table tbody tr td:last-child {
            width: 15%;
        }

        /*table tbody tr.important { border-left: 2px solid red; border-right: 1px solid red; }*/
        /*table tbody tr:nth-child(6) { border-top: 1px solid red; }*/
        /*table tbody tr.important:last-child { border-bottom: 1px solid red; }*/


    </style>
    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">

            <div class="form_header">
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="text-white get-heading-text">Year End</h4>
                    </div>
                </div>
            </div>
            <form name="f1" class="f1" id="f1" onsubmit="return checkForm()"
                  action="{{ route('year_end.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="input_bx"><!-- start input box -->
                                <label class="required">
                                    Title
                                </label>
                                <input tabindex="1" type="text" name="title" id="title" class="inputs_up form-control"
                                       autocomplete="off" placeholder="2023-2024" data-rule-required="true"
                                       data-msg-required="Please Enter Title"/>
                            </div>
                        </div>
                        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="input_bx"><!-- start input box -->
                                <label class="required">
                                    Start Date
                                </label>
                                <input tabindex="2" type="text" name="from" id="from"
                                       class="inputs_up form-control datepicker1" autocomplete="off"
                                       placeholder="Start Date ......" data-rule-required="true"
                                       data-msg-required="Please Enter Start Date"/>
                            </div>
                        </div>
                        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="input_bx"><!-- start input box -->
                                <label class="required">
                                    End Date
                                </label>
                                <input tabindex="3" type="text" name="to" id="to"
                                       class="inputs_up form-control datepicker1"
                                       autocomplete="off" placeholder="To Date ......" data-rule-required="true"
                                       data-msg-required="Please Enter End Date"/>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 form_controls text-right mt-4">
                            <button type="reset" name="cancel" id="cancel"
                                    class="cancel_button btn btn-sm btn-secondary">
                                <i class="fa fa-eraser"></i> Cancel
                            </button>
                            <button type="submit" name="save" id="save" class="save_button btn btn-sm btn-success">
                                <i class="fa fa-floppy-o"></i> Save
                            </button>
                        </div>
                    </div>


                </form>

        </div>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        function checkForm() {
            let title = document.getElementById("title"),
                from = document.getElementById("from"),
                to = document.getElementById("to"),
                validateInputIdArray = [
                    title.id,
                    from.id,
                    to.id,
                ];
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
@endsection


