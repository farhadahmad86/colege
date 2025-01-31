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
                        <h4 class="text-white get-heading-text">User Expiry</h4>
                    </div>
                </div>
            </div>

            <form name="f1" class="f1" id="f1" action="{{ route('update_user_expiry') }}" method="post">
                @csrf
                <div class="row">
                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx"><!-- start input box -->
                            <label>
                                Expiry Date
                            </label>
                            <input tabindex="5" type="text" name="expiry_date" id="expiry_date" class="inputs_up form-control datepicker1" autocomplete="off" value="{{ $expiry_date != '' ? $expiry_date : '' }}"
                                    placeholder="expiry Date ......"/>
                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                        </div>
                    </div>
                    <div class="col-lg-10 col-md-9 col-sm-12 form_controls text-right mt-4">
                        <button type="reset" name="cancel" id="cancel" class="cancel_button btn btn-sm btn-secondary">
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


    </script>
@endsection


