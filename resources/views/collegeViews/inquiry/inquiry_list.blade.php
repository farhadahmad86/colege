@extends('extend_index')
@section('content')
@section('styles_get')
    <style>
        .action_td .dropdown .dropdown-toggle::after {
            content: unset !important;
        }
    </style>
@stop

<div class="row">
    <div class="container-fluid search-filter form-group form_manage">
        <div class="form_header">
            <!-- form header start -->
            <div class="clearfix">
                <div class="pull-left">
                    <h4 class="text-white get-heading-text file_name">Inquiry List</h4>
                </div>
                <div class="list_btn list_mul">
                    <div class="srch_box_opn_icon">
                        <i class="fa fa-search"></i>
                    </div>
                </div><!-- list btn -->
            </div>
        </div><!-- form header close -->
        <div class="search_form m-0 p-0">
            <form class="highlight prnt_lst_frm" action="{{ route('inquiry_list') }}" name="form1" id="form1"
                method="post">
                <div class="row">
                    @csrf
                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <label>
                                All Data Search
                            </label>
                            <input tabindex="1" autofocus type="search" list="browsers"
                                class="inputs_up form-control" name="search" id="search"
                                placeholder="Search by Name" value="{{ isset($search) ? $search : '' }}"
                                autocomplete="off">
                            <datalist id="browsers">
                                @foreach ($inq_title as $value)
                                    <option value="{{ $value }}">
                                @endforeach
                            </datalist>
                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                        </div>
                    </div> <!-- left column ends here -->
                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <label>
                                Student
                            </label>
                            <select tabindex="1" autofocus name="search_status" class="form-control required"
                                    id="search_status"
                                    autofocus data-rule-required="true" data-msg-required="Please Enter Degree"
                                    >
                                <option value="" >Select Student Type</option>
                                <option value="inquiry" {{ $search_status === 'inquiry' ? 'selected' : '' }}>Inquiry</option>
                                <option value="summercamp" {{ $search_status === 'summercamp' ? 'selected' : '' }}>SummerCamp</option>
                                <option value="prospectus" {{ $search_status === 'prospectus' ? 'selected' : '' }}>Prospectus</option>
                                <option value="confirm_admission" {{ $search_status === 'confirm_admission' ? 'selected' : '' }}>Confirm Admission</option>
                                <span id="demo1" class="validate_sign"> </span>
                            </select>
                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                        </div>
                    </div> <!-- left column ends here -->
                    <x-year-end-component search="{{$search_year}}"/>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right form_controls mt-2">
                        @include('include.clear_search_button')
                        <!-- Call add button component -->
                        <x-add-button tabindex="9" href="{{ route('add_inquiry') }}" />

                        @include('include/print_button')
                        <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                    </div>
                </div><!-- end row -->
            </form>
            <form name="edit" id="edit" action="{{ route('edit_inquiry') }}" method="post">
                @csrf

                <input name="title" id="title" type="hidden">
                <input name="inq_father_name" id="inq_father_name" type="hidden">
                <input name="inq_contact" id="inq_contact" type="hidden">
                <input name="inq_inquire_date" id="inq_inquire_date" type="hidden">
                <input name="inq_cnic" id="inq_cnic" type="hidden">
                <input name="inq_parent_contact" id="inq_parent_contact" type="hidden">
                <input name="inq_marks_10th" id="inq_marks_10th" type="hidden">
                <input name="f_marks" id="f_marks" type="hidden">
                <input name="inq_address" id="inq_address" type="hidden">
                <input name="gender" id="gender" type="hidden">
                <input name="gender" id="gender" type="hidden">
                <input name="inq_id" id="inq_id" type="hidden">
            </form>
        </div>

        <div class="table-responsive" id="printTable">
            <table class="table table-bordered table-sm" id="fixTable">

                <thead>
                    <tr>
                        <th scope="col" class="tbl_srl_2">
                            Sr
                        </th>
                        <th scope="col" class="tbl_txt_12">
                            Name
                        </th>  <th scope="col" class="tbl_txt_8">
                            Program
                        </th>
                        <th scope="col" class="tbl_txt_6">
                            Father Name
                        </th>

                        <th scope="col" class="tbl_txt_6">
                            Contact
                        </th>
                        <th scope="col" class=" tbl_txt_6">
                            Father Contact
                        </th>

                        <th scope="col" class=" tbl_txt_4">
                            10th Marks
                        </th>
                        <th scope="col" class=" tbl_txt_20">
                            Address
                        </th>
                        <th scope="col" class=" tbl_txt_6">
                           Inquiry Status
                        </th>
                        <th scope="col" class="tbl_txt_4">
                            Inquire Date
                        </th>
                        <th scope="col" class=" tbl_txt_6">
                            Branch
                        </th>
                        <th scope="col" class=" tbl_txt_6">
                            Created By
                        </th>
                        <th scope="col" class=" tbl_txt_6">
                            Inq To Std
                        </th>
                        {{-- <th scope="col" class="hide_column tbl_txt_6">
                            Action
                        </th> --}}
                    </tr>
                </thead>

                <tbody>
                    @php
                        $segmentSr = !empty(app('request')->input('segmentSr')) ? app('request')->input('segmentSr') : '';
                        $segmentPg = !empty(app('request')->input('page')) ? app('request')->input('page') : '';
                        $sr = !empty($segmentSr) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                        $countSeg = !empty($segmentSr) ? $segmentSr : 0;
                    @endphp
                    @forelse($datas as $data)
                        <tr  data-title="{{ $data->inq_full_name }}" data-inq_id="{{ $data->inq_id }}"
                            data-father_name="{{ $data->inq_father_name }}"
                            data-inq_contact="{{ $data->inq_contact }}"
                            data-inq_inquire_date="{{ $data->inq_inquire_date }}"
                             data-gender="{{$data->inq_gender}}"
                            data-inq_cnic="{{ $data->inq_cnic }}"
                            data-inq_parent_contact="{{ $data->inq_parent_contact }}"
                            data-branch_name="{{ $data->branch_name }}"
                            data-inq_marks_10th="{{ $data->inq_marks_10th }}"
                            data-inq_address="{{ $data->inq_address }}">
                            <td scope="row">
                                {{ $sr }}
                            </td>
                            <td class="edit ">
                                {{ $data->inq_full_name }}
                            </td>
                            <td class="edit ">
                                {{ $data->program_name }}
                            </td>
                            <td class="edit ">
                                {{ $data->inq_father_name }}
                            </td>

                            <td class="edit ">
                                {{ $data->inq_contact }}
                            </td>
                            <td class="edit ">
                                {{ $data->inq_parent_contact }}
                            </td>

                            <td class="edit ">
                                {{ $data->inq_marks_10th }}
                            </td>
                            <td class="edit ">
                                {{ $data->inq_address }}
                            </td>
                            <td class="edit ">
                                @foreach (explode(',', $data->inq_status) as $status)
                                    {{ htmlspecialchars($status) }}
                                @endforeach
                            </td>
                            <td class="edit ">
                                {{ $data->inq_inquire_date }}
                            </td>
                            <td class="edit ">
                                {{ $data->branch_name }}
                            </td>
                            <td class="edit ">
                                {{ $data->created_by }}
                            </td>
                            <td class="text-center hide_column ">
                                <a href="{{ route('inquiry_to_student', $data->inq_id) }}" data-toggle="tooltip"
                                    data-placement="left" title="" data-original-title="Are you sure?">
                                    <i class="fa fa-edit">Inquir</i>
                                </a>
                            </td>
                            {{-- <td class="text-center hide_column ">
                                <a data-region_id="{{ $data->inq_id }}" class="delete" data-toggle="tooltip"
                                    data-placement="left" title="" data-original-title="Are you sure?">
                                    <i class="fa fa-{{ $data->inq_delete_status == 1 ? 'undo' : 'trash' }}"></i>
                                </a>
                            </td> --}}
                        </tr>
                        @php
                            $sr++;
                            !empty($segmentSr) && $countSeg !== '0' ?: $countSeg++;
                        @endphp
                    @empty
                        <tr>
                            <td colspan="13">
                                <center>
                                    <h3 style="color:#554F4F">No Inquiry</h3>
                                </center>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

        </div>
        <div class="row">
            <div class="col-md-3">
                <span>Showing {{ $datas->firstItem() }} - {{ $datas->lastItem() }} of {{ $datas->total() }}</span>
            </div>
            <div class="col-md-9 text-right">
                    <span
                        class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search' => $search])->links() }}</span>
            </div>
        </div>
    </div> <!-- white column form ends here -->
</div><!-- row end -->

@endsection
@section('scripts')


{{--    add code by shahzaib start --}}
<script type="text/javascript">
    var base = '{{ route('inquiry_list') }}',
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
                    'reg_id': regId
                },
                success: function(data) {
                    console.log(data.message);
                }
            });
        });
    });
</script>
<script>
    jQuery(".edit").click(function() {

        var title = jQuery(this).parent('tr').attr("data-title");
        var inq_id = jQuery(this).parent('tr').attr("data-inq_id");
        var inq_father_name = jQuery(this).parent('tr').attr("data-father_name");
        var inq_contact = jQuery(this).parent('tr').attr("data-inq_contact");
        var inq_inquire_date = jQuery(this).parent('tr').attr("data-inq_inquire_date");
        var inq_cnic = jQuery(this).parent('tr').attr("data-inq_cnic");
        var inq_parent_contact = jQuery(this).parent('tr').attr("data-inq_parent_contact");
        var branch_name = jQuery(this).parent('tr').attr("data-branch_name");
        var inq_marks_10th = jQuery(this).parent('tr').attr("data-inq_marks_10th");
        var inq_address = jQuery(this).parent('tr').attr("data-inq_address");
        var gender = jQuery(this).parent('tr').attr("data-gender");

        jQuery("#title").val(title);
        jQuery("#inq_id").val(inq_id);
        jQuery("#inq_father_name").val(inq_father_name);
        jQuery("#inq_contact").val(inq_contact);
        jQuery("#inq_inquire_date").val(inq_inquire_date);
        jQuery("#inq_cnic").val(inq_cnic);
        jQuery("#inq_parent_contact").val(inq_parent_contact);
        jQuery("#branch_name").val(branch_name);
        jQuery("#inq_marks_10th").val(inq_marks_10th);
        jQuery("#inq_address").val(inq_address);
        jQuery("#gender").val(gender);
        jQuery("#edit").submit();
    });

</script>
<script>
    jQuery("#cancel").click(function() {
        $("#search").val('');
    });
    jQuery('#search_status').select2();
</script>

@endsection
