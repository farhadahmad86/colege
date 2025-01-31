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
                    <h4 class="text-white get-heading-text file_name">Session List</h4>
                </div>
                <div class="list_btn list_mul">
                    <div class="srch_box_opn_icon">
                        <i class="fa fa-search"></i>
                    </div>
                </div><!-- list btn -->
            </div>
        </div><!-- form header close -->
        <div class="search_form m-0 p-0">
            <form class="highlight prnt_lst_frm" action="{{ route('session_list') }}" name="form1" id="form1"
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
                                placeholder="All Data Search" value="{{ isset($search) ? $search : '' }}"
                                autocomplete="off">
                            <datalist id="browsers">
                                @foreach ($session_title as $value)
                                    <option value="{{ $value }}">
                                @endforeach
                            </datalist>
                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                        </div>
                    </div> <!-- left column ends here -->
                        <x-year-end-component search="{{$search_year}}"/>
                    <div class="col-lg-8 col-md-7 col-sm-12 col-xs-12 text-right form_controls">
                        @include('include.clear_search_button')
                        <!-- Call add button component -->
                        <x-add-button tabindex="9" href="{{ route('add_session') }}" />
                        @include('include/print_button')
                        <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                    </div>
                </div><!-- end row -->
            </form>
            <form name="edit" id="edit" action="{{ route('edit_session') }}" method="post">
                @csrf
                <input name="title" id="title" type="hidden">
                <input name="session_id" id="session_id" type="hidden">
                <input name="start_date" id="start_date" type="hidden">
                <input name="end_date" id="end_date" type="hidden">
            </form>
            {{-- <form name="delete" id="delete" action="{{ route('delete_semester') }}" method="post"> --}}
            @csrf
            <input name="reg_id" id="reg_id" type="hidden">
            </form>
        </div>
        <div class="table-responsive" id="printTable">
            <table class="table table-bordered table-sm" id="fixTable">
                <thead>
                    <tr>
                        <th scope="col" class="tbl_srl_10">
                            ID
                        </th>
                        <th scope="col" class="tbl_txt_40">
                            Session Name
                        </th>
                        <th scope="col" class="tbl_txt_40">
                            Branch
                        </th>
                        <th scope="col" class="tbl_txt_40">
                            Created By
                        </th>
                        <th scope="col" class="hide_column tbl_srl_16">
                            Enable
                        </th>
                        {{-- <th scope="col" class="hide_column tbl_srl_16">
                            Action
                        </th> --}}
                    </tr>
                </thead>
                <tbody>
                    @forelse($datas as $data)
                        <tr data-title="{{ $data->session_name }}" data-session_id="{{ $data->session_id }}"
                            data-title="{{ $data->session_name }}">
                            {{--                                        <td class="edit "> --}}
                            {{--                                            {{$sr}} --}}
                            {{--                                        </td> --}}
                            <th scope="row" class="edit ">
                                {{ $data->session_id }}
                            </th>
                            <td class="edit ">
                                {{ $data->session_name }}
                            </td>
                            <td class="edit ">
                                {{ $data->branch_name }}
                            </td>
                            <td class="edit ">
                                {{ $data->users->user_name }}
                            </td>
                            <td class="text-center hide_column ">
                                <label class="switch">
                                    <input type="checkbox" <?php if ($data->session_disable_enable == 1) {
                                        echo 'checked="true"' . ' ' . 'value=' . $data->session_disable_enable;
                                    } else {
                                        echo 'value=DISABLE';
                                    } ?> class="enable_disable"
                                        data-id="{{ $data->session_id }}"
                                        {{ $data->session_disable_enable == 1 ? 'checked' : '' }}>
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            {{-- @php
                                $ip_browser_info= ''.$data->session_ip_adrs.','.str_replace(' ','-',$data->session_brwsr_info).'';
                            @endphp --}}

                            {{-- <td class="usr_prfl " data-usr_prfl="{{ $data->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                {{$data->user_name}}
                            </td> --}}
                            {{--                                        <td class="hide_column"> --}}
                            {{--                                            <a class="edit" style="cursor:pointer;"> --}}
                            {{--                                                <i class="fa fa-edit"></i> --}}
                            {{--                                            </a> --}}
                            {{--                                        </td> --}}
                            {{-- <td class="text-center hide_column ">
                                <a data-region_id="{{ $data->session_id }}" class="delete" data-toggle="tooltip"
                                    data-placement="left" title="" data-original-title="Are you sure?">
                                    <i class="fa fa-{{ $data->session_delete_status == 1 ? 'undo' : 'trash' }}"></i>
                                </a>
                            </td> --}}
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11">
                                <center>
                                    <h3 style="color:#554F4F">No Session</h3>
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
            {{-- <div class="col-md-9 text-right">
                    <span class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search ])->links() }}</span>
                </div> --}}
        </div>
    </div> <!-- white column form ends here -->
</div><!-- row end -->

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
            let status = $(this).prop('checked') === true ? 1 : 0;
            let session_id = $(this).data('id');
            $.ajax({
                type: "GET",
                dataType: "json",
                url: '{{ route('enable_disable_session') }}',
                data: {
                    'status': status,
                    'session_id': session_id
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
        // var remarks = jQuery(this).parent('tr').attr("data-remarks");
        var session_id = jQuery(this).parent('tr').attr("data-session_id");
        var start_date = jQuery(this).parent('tr').attr("data-start_date");
        var end_date = jQuery(this).parent('tr').attr("data-end_date");
        // var createdby = jQuery(this).parent('tr').attr("data-createdby");

        jQuery("#title").val(title);
        // jQuery("#remarks").val(remarks);
        jQuery("#session_id").val(session_id);
        jQuery("#start_date").val(start_date);
        jQuery("#end_date").val(end_date);
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
                jQuery("#reg_id").val(session_id);
                jQuery("#delete").submit();
            } else {

            }
        });
    });
</script>


@endsection
