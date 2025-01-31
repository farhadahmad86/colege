@extends('extend_index')

@section('content')
    <style>
    </style>
    <div class="row">


        <div
            class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">


            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">

                {{----}}

                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">System Date</h4>
                        </div>
                    </div>
                </div><!-- form header close -->

                <div id="system_date" class="systm_cnfg_lst_dscrption" style="display: block"><!-- system config list description start -->
                    <h6>
                        System Date
                    </h6>
                    <p>
                        Select what is the first date of your system. You cannot change system date after opening trial is processed.
                    </p>
                    @if( isset($systm_config) && !empty($systm_config->sc_first_date) )
                        <p>
                            You selected/choosed  {{ date('d-M-y', strtotime($systm_config->sc_first_date)) }} date.
                        </p>
                    @endif

                    <div class="systm_cnfg_lst_dscrption_frm">
                        <form action="{{ route('system_config_update_date') }}" method="POST">

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <div class="input_bx"><!-- start input box -->
                                    <label for="first_date" class="required">
                                        System Date Select
                                    </label>
                                    <input type="text" name="sc_first_date" id="first_date" class="inputs_up form-control date-picker" placeholder="System Date Select" autocomplete="off" value="{{ isset($system_config) && !empty($system_config->sc_first_date) ? date('d-M-y', strtotime($system_config->sc_first_date)) : '' }}">
                                    <span id="demo2" class="validate_sign"> </span>
                                </div><!-- end input box -->
                            </div>
                            <div class="form-group text-right">
                                <button type="submit" name="save" class="save_button form-control">
                                    <i class="fa fa-floppy-o"></i> Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

@endsection

@section('scripts')

    <script type="text/javascript">

        $(window).keydown(function (event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });

    </script>

@endsection


