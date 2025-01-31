@extends('extend_index')

@section('content')
    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header">
                <!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 tabindex="-1" class="text-white get-heading-text">Bank Integration</h4>
                    </div>
{{--                    <div class="list_btn">--}}
{{--                        <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('program_list') }}"--}}
{{--                           role="button">--}}
{{--                            <l class="fa fa-list"></l>--}}
{{--                            view list--}}
{{--                        </a>--}}
{{--                    </div><!-- list btn -->--}}
                </div>
            </div><!-- form header close -->
            <div class="row">
                <div class="col-sm-12 col-md-4 col-lg-8">
                    <b>Account Name:</b>
                    <div>{{$integrate_account->bi_account_no}}--{{$integrate_account->account_name}} <button class="btn btn-primary"><i
                                class="fa fa-edit" onclick="showForm()"></i></button></div>
                </div>
                <div class="col-sm-12 col-md-4 col-lg-4">
                    <b>Update
                        By:</b>
                    <div>{{ $integrate_account->updated_by_user_name }}</div>
                </div>
            </div>

            <div class="modal fade" id="IntegrationModel" tabindex="-1" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <form name="f1" class="f1" id="f1" action="{{ route('update_bank_integration') }}"
                                  method="post"
                                  onsubmit="return checkForm()">
                                @csrf
                                <input name="bi_account_no" value="{{$integrate_account->bi_account_no}}"
                                       type="hidden"/>
                                <div class="form-group">
                                    <label for="account_no" class="col-form-label">Account Name:</label>
                                    <select tabindex="1" autofocus name="account_no" class="form-control required"
                                            id="account_no"
                                            autofocus data-rule-required="true"
                                            data-msg-required="Please Select Account">
                                        <option value="" selected disabled>Select Account</option>
                                        @foreach ($bankAccounts as $bankAccount)
                                            <option value="{{ $bankAccount->account_uid }}"
                                                {{ $bankAccount->account_uid == $integrate_account->bi_account_no ? 'selected' : '' }}>
                                                {{ $bankAccount->account_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 text-right">
                                        <button tabindex="1" type="submit" name="save" id="save"
                                                class="save_button btn btn-sm btn-success">
                                            <i class="fa fa-floppy-o"></i> Update
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- left column ends here -->
    </div> <!-- right columns ends here -->
    {{--    Modal Start--}}

    {{--    Modal End--}}
@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let account_no = document.getElementById("account_no"),
                validateInputIdArray = [
                    account_no.id,
                ];
            let check = validateInventoryInputs(validateInputIdArray);
            if (check == true) {
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
        $(document).ready(function () {
            $('#account_no').select2();
        });

        function showForm(event) {
            var myModal = new bootstrap.Modal(document.getElementById('IntegrationModel'), {
                keyboard: false
            });
            myModal.show();
        }

        // function getIntegration(account_id) {
        //     let exam_name = $(`#exam_name${std_id}`).val();
        //     jQuery(".pre-loader").fadeToggle("medium");
        //     jQuery.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        //         }
        //     });
        //
        //     jQuery.ajax({
        //         url: "get_result",
        //         data: {
        //             exam_id: exam_id,
        //             std_id: std_id,
        //             class_id: class_id,
        //             group_id: group_id,
        //             section_id: section_id
        //         },
        //         type: "GET",
        //         cache: false,
        //         dataType: 'json',
        //         success: function (data) {
        //             console.log(data, exam_name);
        //             let total = 0;
        //             let obtain = 0;
        //             var result = `<div class="card-header bg-info">
        //                 <strong>${exam_name}</strong>
        //                 </div>
        //                 <div class="card-header">
        //                 <strong> Subjects <span class="float-right">Marks</span></strong>
        //             </div>
        //             <ul class="list-group list-group-flush">`;
        //
        //
        //             $.each(data, function (index, value) {
        //                 obtain = +obtain + +value.obtain_marks;
        //                 total = +total + value.total_marks;
        //                 result += `<li class="list-group-item">${value.subject_name} <span class="float-right">${value.obtain_marks}/${value.total_marks}</span></li>`
        //
        //             });
        //             result += `</ul>
        //             <div class="card-header bg-info">
        //                 <strong> Obtain Marks <span class="float-right">${obtain}</span></strong>
        //             </div>
        //             <div class="card-header bg-info">
        //                 <strong> Total Marks <span class="float-right">${total}</span></strong>
        //             </div>
        //             <div class="card-header bg-info">
        //                 <strong> Percentage <span class="float-right">${((obtain / total) * 100).toFixed(2)}%</span></strong>
        //             </div>`;
        //             $('#result').html('');
        //             $('#result').html(result);
        //             jQuery(".pre-loader").fadeToggle("medium");
        //         }
        //     });
        //
        //
        // }
    </script>
@endsection
