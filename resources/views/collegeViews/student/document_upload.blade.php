@extends('extend_index')
@section('content')
    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header">
                <!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 tabindex="-1" class="text-white get-heading-text">Document Upload</h4>
                    </div>
                    <div class="list_btn">
                        <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('document_list') }}"
                           role="button">
                            <l class="fa fa-list"></l>
                            view list
                        </a>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->
            <form name="f1" class="f1" id="f1" action="{{ route('store_document_upload') }}" method="post"
                  onsubmit="return checkForm() " enctype="multipart/form-data">
                @csrf
                <div class="row">


                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">Uplaod Form PDF</label>
                            <input tabindex="23" type="file" name="file" id="file"
                                   data-rule-required="true" data-msg-required="Please Enter Pdf File"
                                   value="{{ old('file') }}" class="inputs_up form-control" placeholder="Demand"
                            >
                            <div id="message"  style="display: none;" ></div>
                        </div><!-- end input box -->
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Student</label>
                            <select tabindex="8" name="std_id" class="inputs_up form-control"
                                    data-rule-required="true" data-msg-required="Please Select Student" id="std_id">
                                <option value="">Select Student</option>
                                @foreach ($students as $student)
                                    <option value="{{ $student->id }}">
                                        {{ $student->full_name }}</option>
                                @endforeach
                            </select>
                            <span id="role_error_msg" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Remarks
                            </label>
                            <textarea tabindex="24" name="remarks" id="remarks" class="remarks inputs_up form-control"
                                      placeholder="Remarks"
                                      data-rule-required="true" data-msg-required="Please Enter Remarks"
                                      style="height: 107px;">{{ old('remarks') }}</textarea>
                            <span id="demo1" class="validate_sign" style="float: right !important">
                            </span>
                        </div>
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
    </div>
@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let   doc_file = document.getElementById("file"),
             std_id = document.getElementById("std_id");
            validateInputIdArray = [
                doc_file.id,
                std_id.id,
            ];
            var check = validateInventoryInputs(validateInputIdArray);
            console.log(check);
            if(check == true)
            {
                var fileInput = document.getElementById('file');
                var filePath = fileInput.value;

                // Check if any file is selected.
                if (fileInput.files.length > 0) {
                    var file = fileInput.files[0];

                    // Check the file type
                    if (file.type !== "application/pdf") {
                        document.getElementById('message').style = 'display';
                        document.getElementById('message').textContent = 'Attached Only Pdf file';
                        document.getElementById('message').style.color = 'red';
                        return false;
                        // Stop the form from submitting
                    }else if(file.size > 300 * 1024)
                    {
                        document.getElementById('message').style = 'display';
                        document.getElementById('message').textContent = 'File Must be less than or equal to 300kb';
                        document.getElementById('message').style.color = 'red';
                        return false;
                    }
                }
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
    <script type="text/javascript">
        jQuery('#std_id').select2();
    </script>
    {{--    add code by shahzaib end --}}
@endsection

