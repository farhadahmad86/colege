@extends('extend_index')
@section('styles_get')
    <style>
        .action_td .dropdown .dropdown-toggle::after {
            content: unset !important;
        }
    </style>
@stop
@section('content')

    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header">
                <!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">

                        <h4 class="text-white get-heading-text file_name">Class Section List</h4>
                    </div>
                    <div class="list_btn list_mul">
                        <div class="srch_box_opn_icon">
                            <i class="fa fa-search"></i>
                        </div>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->
            <div class="search_form m-0 p-0">
                <form class="highlight prnt_lst_frm" action="" name="form1" id="form1" method="post">
                    <div class="row">
                        @csrf
                        {{-- <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                            <div class="input_bx">
                                <input tabindex="1" autofocus type="search" list="browsers"
                                    class="inputs_up form-control" name="search" id="search"
                                    placeholder="All Data Search" value="{{ isset($search) ? $search : '' }}"
                                    autocomplete="off" hidden>
                                <datalist id="browsers">
                                    @foreach ($section_title as $value)
                                        <option value="{{ $value }}">
                                    @endforeach
                                </datalist>
                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                            </div>
                        </div> <!-- left column ends here --> --}}
                        <div class="col-lg-12 col-md-9 col-sm-12 col-xs-12 text-right form_controls">
                            {{-- @include('include.clear_search_button') --}}
                            <!-- Call add button component -->
                            <x-add-button tabindex="9" href="{{ route('add_section', $class_id) }}" />
                            {{-- @include('include/print_button') --}}
                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                        </div>
                    </div><!-- end row -->
                </form>
                <form name="edit" id="edit" action="{{ route('edit_class_section') }}" method="post">
                    @csrf
                    {{-- <input name="title" id="title" type="hidden"> --}}
                    <input name="section_id" id="section_id" type="hidden">
                    <input name="class_id" id="class_id" type="hidden">
                    <input name="cs_id" id="cs_id" type="hidden">
                    <input name="incharge_id" id="user_id" type="hidden">
                </form>
                {{-- <form name="delete" id="delete" action="{{ route('delete_section') }}" method="post">
                    @csrf
                    <input name="section_id" id="section_id" type="hidden">
                </form> --}}

            </div>

            <div class="table-responsive" id="printTable">
                <table class="table table-bordered table-sm" id="fixTable">

                    <thead>
                        <tr>
                            <th scope="col" class="tbl_srl_4">
                                ID
                            </th>
                            <th scope="col" class="tbl_txt_25">
                                Class Name
                            </th>
                            <th scope="col" class="tbl_txt_6">
                                Section
                            </th>
                            <th scope="col" class="tbl_txt_6">
                                Strength
                            </th>
                            <th scope="col" class="tbl_txt_6">
                                Incharge
                            </th>
                            <th scope="col" class="tbl_txt_6">
                                Branch
                            </th>
                            <th scope="col" class="tbl_txt_6">
                                Created By
                            </th>
                            {{-- <th scope="col" class="hide_column tbl_srl_6">
                                Enable
                            </th> --}}
                            {{-- <th scope="col" class="hide_column tbl_srl_6">
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
                            <tr data-section_id="{{ $data->section_id }}" data-class_id="{{ $data->class_id }}"
                                data-user_id="{{ $data->user_id }}" data-cs_id="{{ $data->cs_id }}">
                                <th scope="row">
                                    {{ $sr }}
                                </th>
                                <td class="edit">
                                    {{ $data->class_name }}
                                </td>
                                <td class="edit">
                                    {{ $data->cs_name }}
                                </td>
                                <td class="edit">
                                    @inject('strength', 'App\Models\College\Student')
                                    {{ $strength->where('class_id', $data->class_id)->where('section_id', $data->cs_id)->where('branch_id', session('branch_id'))->count() }}
                                    
                                </td>
                                <td class="edit">
                                    {{ $data->user_name }}
                                </td>
                                <td class="edit">
                                    {{ $data->branch_name }}
                                </td>
                                @php
                                    $ip_browser_info = '' . $data->section_ip_adrs . ',' . str_replace(' ', '-', $data->section_brwsr_info) . '';
                                @endphp
                                <td class="usr_prfl " data-usr_prfl="{{ $user->user_id }}"
                                    data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                    {{ $user->user_name }}
                                </td>
                                {{-- <td class="text-center hide_column ">
                                    <label class="switch">
                                        <input type="checkbox"
                                            data-id="{{ $data->section_id }}"

                                            {{ $data->section_disable_enable == 1 ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </label>
                                </td> --}}

                                {{-- <td class="text-center hide_column "> --}}
                                {{-- <a data-section_id="{{ $data->section_id }}" class="delete" data-toggle="tooltip"
                                        data-placement="left" title="" data-original-title="Are you sure?">
                                        <i class="fa fa-{{ $data->section_delete_status == 1 ? 'undo' : 'trash' }}"></i>
                                    </a> --}}

                                {{-- </td> --}}
                            </tr>
                            @php
                                $sr++;
                                !empty($segmentSr) && $countSeg !== '0' ?: $countSeg++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="11">
                                    <center>
                                        <h3 style="color:#554F4F">No section</h3>
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

    <script>
        $(document).ready(function() {
            $('.enable_disable').change(function() {
                let status = $(this).prop('checked') === true ? 1 : 0;
                let section_id = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    route: '{{ route('enable_disable_section') }}',
                    data: {
                        'status': status,
                        'section_id': section_id
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
            $("#search").val('');
        });
    </script>

    <script>
        jQuery(".edit").click(function() {


            var cs_id = jQuery(this).parent('tr').attr("data-cs_id");
            var section_id = jQuery(this).parent('tr').attr("data-section_id");
            var class_id = jQuery(this).parent('tr').attr("data-class_id");
            var user_id = jQuery(this).parent('tr').attr("data-user_id");

            jQuery("#cs_id").val(cs_id);
            jQuery("#class_id").val(class_id);
            jQuery("#section_id").val(section_id);
            jQuery("#user_id").val(user_id);
            jQuery("#edit").submit();
        });
        jQuery(".add_section").click(function() {

            var class_id = jQuery(this).attr("data-class_id");
            var section_id = jQuery(this).attr("data-section_id");
            jQuery("#class_id").val(class_id);
            // jQuery("#section_id").val(section_id);
            jQuery("#clg_group").submit();
        });

        $('.delete').on('click', function(event) {

            var section_id = jQuery(this).attr("data-section_id");

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
                    jQuery("#section_id").val(section_id);
                    jQuery("#delete").submit();
                } else {

                }
            });
        });
    </script>


@endsection
