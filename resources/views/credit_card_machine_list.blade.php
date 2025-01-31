@extends('extend_index')
@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Credit Card Machine List</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->
                {{--                <div class="search_form {{ ( !empty($search) ) ? '' : 'search_form_hidden' }}">--}}
                <div class="search_form m-0 p-0">
                    <form class="highlight prnt_lst_frm" action="{{ route('credit_card_machine_list') . ((isset($restore_list) && $restore_list == 1) ? '?restore_list=1' : '') }}" name="form1"
                          id="form1" method="post">
                        @csrf
                        <div class="row">

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        All Column Search
                                    </label>
                                    <input tabindex="1" autofocus type="search" list="browsers" class="inputs_up form-control all_clm_srch" name="search" id="search" placeholder="Search ..."
                                           value="{{ isset($search) ? $search : '' }}" autocomplete="off">
                                    <datalist id="browsers">
                                        @foreach($ccm_title as $value)
                                            <option value="{{$value}}">
                                        @endforeach
                                    </datalist>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div> <!-- left column ends here -->

                            <div class="col-lg-10 col-md-9 col-sm-12 col-xs-12 mt-4 text-right form_controls">
                            @include('include.clear_search_button')
                            <!-- Call add button component -->
                                <x-add-button tabindex="9" href="{{ route('add_credit_card_machine') }}"/>
                                @include('include/print_button')

                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                            </div>

                        </div>
                    </form>


                    <form name="edit" id="edit" action="{{ route('edit_credit_card_machine') }}" method="post">
                        @csrf
                        <input tabindex="-1" name="id" id="id" type="hidden">
                    </form>

                    <form name="delete" id="delete" action="{{ route('delete_credit_card_machine') }}" method="post">
                        @csrf
                        <input name="machine_id" id="del_machine_id" type="hidden">
                    </form>
                </div>


                <div class="table-responsive" id="printTable">
                    <table class="table table-bordered table-sm" id="fixTable">

                        <thead>
                        <tr>
                            <th scope="col" class="tbl_srl_4">
                                R.Code
                            </th>
                            <th scope="col" class="tbl_srl_4">
                                ID
                            </th>
                            <th scope="col" class="tbl_txt_19">
                                Machine Title
                            </th>
                            <th scope="col" class="tbl_amnt_11">
                                Merchant Code
                            </th>
                            <th scope="col" class="tbl_txt_10">
                                Bank
                            </th>
                            <th scope="col" class="tbl_amnt_6">
                                Percentage
                            </th>
                            <th scope="col" class="tbl_txt_25">
                                Remarks
                            </th>
                            <th scope="col" class="tbl_txt_8">
                                Created By
                            </th>
                            <th scope="col" class="hide_column tbl_srl_6">
                                Enable
                            </th>
                            <th scope="col" class="hide_column tbl_srl_6">
                                Action
                            </th>
                        </tr>
                        </thead>

                        <tbody>
                        @php
                            $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
                            $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
                            $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                            $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
                        @endphp
                        @forelse($datas as $credit_card_machine)

                            <tr data-id="{{$credit_card_machine->ccm_id}}">

                                <th scope="row" class="edit ">
                                    {{$sr}}
                                </th>
                                <td class="edit ">
                                    {{$credit_card_machine->ccm_id}}
                                </td>
                                <td class="edit ">
                                    {{$credit_card_machine->ccm_title}}
                                </td>
                                <td class="edit ">
                                    {{$credit_card_machine->ccm_merchant_id}}
                                </td>
                                <td class="edit ">
                                    {{$credit_card_machine->account_name}}
                                </td>
                                <td class="edit ">
                                    {{$credit_card_machine->ccm_percentage}}
                                </td>
                                <td class="edit ">
                                    {{$credit_card_machine->ccm_remarks }}
                                </td>
                                @php
                                    $ip_browser_info= ''.$credit_card_machine->ccm_ip_adrs.','.str_replace(' ','-',$credit_card_machine->ccm_brwsr_info).'';
                                @endphp

                                <td class="usr_prfl" data-usr_prfl="{{ $credit_card_machine->user_id }}" data-user_info="{!! $ip_browser_info !!}"
                                    title="Click To See User Detail">
                                    {{ $credit_card_machine->user_name }}
                                </td>


                                {{--    add code by mustafa start --}}
                                <td class="text-center hide_column ">
                                    <label class="switch">
                                        <input type="checkbox" <?php if ($credit_card_machine->ccm_disabled == 0) {
                                            echo 'checked="true"' . ' ' . 'value=' . $credit_card_machine->ccm_disabled;
                                        } else {
                                            echo 'value=DISABLE';
                                        } ?>  class="enable_disable" data-id="{{$credit_card_machine->ccm_id}}"
                                            {{ $credit_card_machine->ccm_disabled == 0 ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                {{--    add code by mustafa end --}}


                                <td class="text-center hide_column ">
                                    <a data-id="{{$credit_card_machine->ccm_id}}" class="delete">
                                        <i class="fa fa-{{$credit_card_machine->ccm_delete_status == 1 ? 'undo':'trash'}}"></i>
                                    </a>
                                </td>

                            </tr>
                            @php
                                $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="11">
                                    <center><h3 style="color:#554F4F">No Entry</h3></center>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>

                    </table>

                </div>
                <div class="row">
                    <div class="col-md-3">
                        <span>Showing {{$datas->firstItem()}} - {{$datas->lastItem()}} of {{$datas->total()}}</span>
                    </div>
                    <div class="col-md-9 text-right">
                        <span class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search ])->links() }}</span>
                    </div>
                </div>
            </div> <!-- white column form ends here -->
        </div>
    </div>

@endsection

@section('scripts')



    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('credit_card_machine_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}


    {{--    add code by mustafa start --}}
    <script>

        $(document).ready(function () {
            $('.enable_disable').change(function () {
                let status = $(this).prop('checked') === true ? 0 : 1;
                let ccmId = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('enable_disable_credit_card_machine') }}',
                    data: {'status': status, 'ccm_id': ccmId},
                    success: function (data) {
                        console.log(data.message);
                    }
                });
            });
        });
    </script>
    {{--    add code by mustafa end --}}


    <script>
        jQuery("#cancel").click(function () {

            $("#search").val('');

            $("#bank_search").select2().val(null).trigger("change");
            $("#bank_search > option").removeAttr('selected');
        });
    </script>

    <script>

        jQuery(".edit").click(function () {

            var id = jQuery(this).parent('tr').attr("data-id");

            jQuery("#id").val(id);

            jQuery("#edit").submit();
        });

        $('.delete').on('click', function (event) {

            var id = jQuery(this).attr("data-id");

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
                    jQuery("#del_machine_id").val(id);
                    jQuery("#delete").submit();
                } else {

                }
            });
        });


        jQuery("#bank_search").select2();
    </script>

@endsection

