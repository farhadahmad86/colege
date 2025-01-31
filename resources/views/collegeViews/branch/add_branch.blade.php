@extends('extend_index')

@section('content')
    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header">
                <!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 tabindex="-1" class="text-white get-heading-text">Create Branch</h4>
                    </div>
                    <div class="list_btn">
                        <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('branch_list') }}"
                           role="button">
                            <l class="fa fa-list"></l>
                            view list
                        </a>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->
            <form name="f1" class="f1" id="f1" action="{{ route('store_branch') }}" method="post"
                  onsubmit="return checkForm()">
                @csrf

                <div class="row">
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Branch No
                            </label>
                            <input tabindex="1" type="text" name="branch_no" id="branch_no"
                                   class="inputs_up form-control" placeholder="Branch No" autofocus data-rule-required="true"
                                   value="B{{ $branch_no }}" readonly/>
                            <span id="demo1" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Branch Name
                            </label>
                            <input tabindex="1" type="text" name="branch_name" id="branch_name"
                                   class="inputs_up form-control" placeholder="Branch Name" autofocus data-rule-required="true"
                                   data-msg-required="Please Enter Region Title" autocomplete="off"
                                   value="{{ old('branch_name') }}"/>
                            <span id="demo1" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>

                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Contact
                            </label>
                            <input tabindex="2" type="text" name="contact" id="contact"
                                   class="inputs_up form-control" placeholder="Contact" autofocus data-rule-required="true"
                                   data-msg-required="Please Enter Contact" autocomplete="off" value="{{ old('contact') }}"/>
                            <span id="demo1" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label>
                                Contact 2
                            </label>
                            <input tabindex="3" type="text" name="contact2" id="contact2"
                                   class="inputs_up form-control" placeholder="Contact2"
                                   value="{{ old('contact2') }}"/>
                        </div><!-- end input box -->
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Address
                            </label>
                            <textarea class="inputs_up form-control" name="address" id="address" rows="3" data-rule-required="true" data-msg-required="Please Enter Address">{{old('address')
                            }}</textarea>
                            <span id="demo1" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-12 col-md-12 col-sm-12 text-right">
                        <button tabindex="1" type="reset" name="cancel" id="cancel"
                                class="cancel_button btn btn-sm btn-secondary">
                            <i class="fa fa-eraser"></i> Cancel
                        </button>
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
                    let branch_name = document.getElementById("branch_name"),
                        contact = document.getElementById("contact"),
                        address = document.getElementById("address"),
                        validateInputIdArray = [
                            branch_name.id,
                            contact.id,
                            address.id,
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
                $(window).keydown(function (event) {
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
                var base = '{{ route('branch_list') }}',
                    url;

                @include('include.print_script_sh')
            </script>
            {{--    add code by shahzaib end --}}

            <script>
                $(document).ready(function () {
                    $('.enable_disable').change(function () {
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
                            success: function (data) {
                                console.log(data.message);
                            }
                        });
                    });
                });
            </script>

            <script>
                jQuery("#cancel").click(function () {

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

                jQuery(".edit").click(function () {

                    var title = jQuery(this).parent('tr').attr("data-title");
                    var remarks = jQuery(this).parent('tr').attr("data-remarks");
                    var region_id = jQuery(this).parent('tr').attr("data-region_id");
                    jQuery("#title").val(title);
                    jQuery("#branch_id").val(branch_id);
                    jQuery("#edit").submit();
                });

                $('.delete').on('click', function (event) {

                    var region_id = jQuery(this).attr("data-region_id");

                    event.preventDefault();
                    Swal.fire({
                        title: 'Are you sure?',
                        icon: 'warning',
                        showCancelButton: true,
                        cancelButtonColor: '#d33',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Yes',
                    }).then(function (result) {

                        if (result.value) {
                            jQuery("#branch_id").val(branch_id);
                            jQuery("#delete").submit();
                        } else {

                        }
                    });
                });
            </script>
@endsection
