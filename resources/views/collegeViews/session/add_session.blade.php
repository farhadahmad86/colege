@extends('extend_index')

@section('script')
    <script></script>
@section('content')
    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header">
                <!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 tabindex="-1" class="text-white get-heading-text">Create Session</h4>
                    </div>
                    <div class="list_btn">
                        <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('session_list') }}"
                            role="button">
                            <l class="fa fa-list"></l>
                            view list
                        </a>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->


            <form name="f1" class="f1" id="f1" action="{{ route('store_session') }}" method="post"
                onsubmit="return checkForm()">
                @csrf

                <div class="row">
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Session Name
                            </label>
                            <input tabindex="1" type="text" name="session_name" id="session_name"
                                class="inputs_up form-control" placeholder="Session Name" autofocus
                                data-rule-required="true" data-msg-required="Please Enter Session Name" autocomplete="off"
                                value="{{ old('session_name') }}" />
                            <span id="demo1" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-12 col-md-12 col-sm-12 text-right">
                        <button tabindex="1" type="submit" name="save" id="save"
                            class="save_button btn btn-sm btn-success">
                            <i class="fa fa-floppy-o"></i> Save
                        </button>
                    </div>
                </div>
            </form>
        </div>
    @endsection

    @section('scripts')
        {{--    required input validation --}}
        <script type="text/javascript">
            function checkForm() {
                let session_name = document.getElementById("session_name"),
                    // start_date = document.getElementById("start_date"),
                    // end_date = document.getElementById("end_date"),
                    validateInputIdArray = [
                        session_name.id,
                        // start_date.id,
                        // end_date.id,
                    ];
                let check = validateInventoryInputs(validateInputIdArray);
                if(check == true){
                    jQuery(".pre-loader").fadeToggle("medium");
                }
                return validateInventoryInputs(validateInputIdArray);
            }
        </script>
        {{-- end of required input validation --}}
        <script type="text/javascript">
            $(window).keydown(function(event) {
                if (event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });
        </script>
    @endsection
    @section('scripts')
        {{--    add code by shahzaib start --}}
        <script type="text/javascript">
            var base = '{{ route('session_list') }}',
                url;

            @include('include.print_script_sh')
        </script>
        {{--    add code by shahzaib end --}}

        <script>
            $(document).ready(function() {
                $('.enable_disable').change(function() {
                    let status = $(this).prop('checked') === true ? 0 : 1;
                    let regId = $(this).data('id');
                    $.ajax({
                        type: "GET",
                        dataType: "json",
                        url: '{{ route('enable_disable_region') }}',
                        data: {
                            'status': status,
                            'branch_id': regId
                        },
                        success: function(data) {
                            console.log(data.message);
                        }
                    });
                });
            });
        </script>

        <script>
            jQuery("#cancel").click(function() {

                // $("#region").select2().val(null).trigger("change");
                // $("#region > option").removeAttr('selected');

                $("#search").val('');
            });
        </script>

        <script>
            // $('#print').click(function () {
            //     var printContents = document.getElementById('printTable').innerHTML;
            //     $('[name="content"]').val(printContents);
            //
            //     $(this).submit();
            // });

            jQuery(".edit").click(function() {

                var title = jQuery(this).parent('tr').attr("data-title");
                var remarks = jQuery(this).parent('tr').attr("data-remarks");
                var region_id = jQuery(this).parent('tr').attr("data-region_id");

                jQuery("#title").val(title);
                // jQuery("#remarks").val(remarks);
                jQuery("#branch_id").val(session_id);
                jQuery("#edit").submit();
            });

            $('.delete').on('click', function(event) {

                var region_id = jQuery(this).attr("data-region_id");

                event.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonColor: '#d33',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Yes',
                }).then(function(result) {

                    if (result.value) {
                        jQuery("#branch_id").val(branch_id);
                        jQuery("#delete").submit();
                    } else {

                    }
                });
            });
        </script>
    @endsection
