@extends('extend_index')

@section('content')
    <div class="row">
        <div class="container-fluid search-filter form-group form_manage" id="">
            <div class="form_header"><!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="text-white get-heading-text file_name">Cash Book (Date: {{$start}} - {{$end}})</h4>
                    </div>
                    <div class="list_btn list_mul">
                        <div class="srch_box_opn_icon">
                            <i class="fa fa-search"></i>
                        </div>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->
            <div class="search_form m-0 p-0">

                <form class="highlight prnt_lst_frm" action="{{ route('cashbook') }}" name="form1" id="form1" method="post" class="accountLedger w-80p d-inline" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="start form-group col-lg-2 col-md-12 col-sm-12 col-xs-12">
                            <div class="input_bx"><!-- start input box -->
                                <label class="required">To :</label>
                                <input type="text" name="to" id="to" class="inputs_up form-control date-picker" <?php if(isset($search_to)){?> value="{{$search_to}}"
                                       <?php } ?> placeholder="Start From..."/>
                                <span id="demo1" class="validate_sign"> </span>
                            </div><!-- end input box -->
                        </div>

                        <div class="end form-group col-lg-2 col-md-12 col-sm-12 col-xs-12">
                            <div class="input_bx"><!-- start input box -->
                                <label class="required">From :</label>
                                <input type="text" name="from" id="from" class="inputs_up form-control date-picker" <?php if(isset($search_from)){?> value="{{$search_from}}"
                                       <?php } ?> placeholder="End From..."/>
                                <span id="demo2" class="validate_sign"> </span>
                            </div><!-- end input box -->
                        </div>
                        <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                            <div class="form_controls text-center text-lg-right">
                                @include('include.clear_search_button')

                                @include('include/print_button')

                            </div>
                        </div>

                    </div><!-- end row -->
                </form>

            </div>


            <div class="table-responsive" id="printTable">
                <table class="table table-bordered table-sm">

                    <thead>
                    <tr>
                        <th scope="col" class="tbl_srl_4">
                            Sr#
                        </th>
                        <th scope="col" class="tbl_amnt_6">
                            Date
                        </th>
                        <th scope="col" class="tbl_amnt_6">
                            Voucher No.
                        </th>
                        <th scope="col" class="tbl_txt_25">
                            Account
                        </th>
                        <th scope="col" class="tbl_txt_29">
                            Description
                        </th>
                        <th scope="col" class="tbl_amnt_10">
                            Inward
                        </th>
                        <th scope="col" class="tbl_amnt_10">
                            Outward
                        </th>
                        <th scope="col" class="tbl_amnt_10">
                            Balance
                        </th>
                    </tr>
                    </thead>

                    <tbody>

                    <tr>
                        <td scope="col"></td>
                        <td scope="col"></td>
                        <td scope="col"></td>
                        <td>OPENING BALANCE</td>
                        <td></td>
                        <td class="align_right text-right "></td>
                        <td class="align_right text-right "></td>
                        <td class="align_right text-right">{{$opening_balance !=0 ? number_format($opening_balance,2):''}}</td>
                    </tr>

                    @php
                        $sr = 1;
                        $totalInwards = 0;
                        $totalOutwards = 0;
                    @endphp
                    @forelse($datas as $result)
                        @php
                            $dateTime = new DateTime($result->date_time);
                            $time = $dateTime->format('h:i:s A');
                            $totalInwards += $result->debit;
                            $totalOutwards += $result->credit;
                        @endphp

                        <tr>
                            <th scope="row">
                                {{$sr}}
                            </th>
                            <td nowrap="">
                                {{$result->date_time}}
                            </td>
                            <td>
                                <a class="view" data-transcation_id="{{$result->voucher_code}}" data-toggle="modal" data-target="#myModal">
                                    {{$result->voucher_code}}
                                </a>
                            </td>
                            <td>
                                {{$result->name}}
                            </td>
                            <td>
                                {{$result->remarks}}
                            </td>
                            <td class="align_right text-right">
                                {{$result->debit !=0 ? number_format($result->debit,2):'0'}}
                            </td>
                            <td class="align_right text-right">
                                {{$result->credit !=0 ? number_format($result->credit,2):'0'}}
                            </td>
                            <td class="align_right text-right">
                                {{$result->balance !=0 ? number_format($result->balance,2):'0'}}
                            </td>
                        </tr>
                        @php
                            $sr++;
                        @endphp
                    @empty
                        <tr>
                            <td colspan="11">
                                <center><h3 style="color:#554F4F">No Ledger</h3></center>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>

                    <tfoot>
                    <tr>
                        <th class="align_right text-right border-0" colspan="5">
                            Per Page Total:-
                        </th>
                        <td class="align_right text-right tbl_amnt_10 border-0">
                            {{number_format($totalInwards,2)}}
                        </td>
                        <td class="align_right text-right tbl_amnt_10 border-0">
                            {{number_format($totalOutwards,2)}}
                        </td>
                        <td class="align_right text-right tbl_amnt_10 border-0">
                            {{number_format($totalInwards - $totalOutwards,2)}}
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div> <!-- white column form ends here -->
    </div><!-- row end -->

    <!-- Modal -->
    <div class="modal fade" id="purchase_modal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="width: 1250px; margin-left: -220px;">
                <div class="modal-header">
                    <h4 class="modal-title text-blue">Items Detail</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th scope="col" style="width:50px; text-align: center !important" align="center">Pro #</th>
                                <th scope="col" style="width:80px; text-align: center !important" align="center">Pro-Name
                                </th>
                                <th scope="col" style="width:50px; text-align: center !important" align="center">Qty</th>
                                <th scope="col" style="width:80px; text-align: center !important" align="center">Rate</th>
                                <th scope="col" style="width:80px; text-align: center !important" align="center">Discount
                                </th>
                                <th scope="col" style="width:80px; text-align: center !important" align="center">Sale Tax
                                </th>
                                <th scope="col" style="width:80px; text-align: center !important" align="center">Amount</th>
                                <th scope="col" style="width:80px; text-align: center !important" align="center">G.Rate</th>
                                <th scope="col" style="width:80px; text-align: center !important" align="center">Expense per
                                    Pro.
                                </th>
                                <th scope="col" style="width:80px; text-align: center !important" align="center">Net Rate
                                </th>
                                <th scope="col" style="width:80px; text-align: center !important" align="center">Remarks
                                </th>
                            </tr>
                            </thead>
                            <tbody id="table_body1">

                            </tbody>
                        </table>

                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-lg-2 col-md-2 col-sm-2">
                    </div>
                    <div class="col-lg-6 col-md-6"></div>
                    <div class="col-lg-2 col-md-2 col-sm-2">
                        <button type="button" class="btn btn-default form-control cancel_button" data-dismiss="modal">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content base_clr">
                <div class="modal-header">
                    <h4 class="modal-title text-blue table-header">Items Detail</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive table-values">
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="col-lg-2 col-md-2 col-sm-2">
                    </div>
                    <div class="col-lg-6 col-md-6"></div>
                    <div class="col-lg-2 col-md-2 col-sm-2">
                        <button type="button" class="btn btn-default form-control cancel_button" data-dismiss="modal">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('cashbook') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>
        jQuery(".view").click(function () {

            var transcation_id = jQuery(this).attr("data-transcation_id");

            jQuery(".table-header").html("");
            jQuery(".table-values").html("");

            $(".modal-body").load('{{ url('/transaction_view_details_SH/') }}/' + transcation_id, function () {
                $('#myModal').modal({show: true});
            });

            // jQuery.ajaxSetup({
            //     headers: {
            //         'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            //     }
            // });
            //
            // jQuery.ajax({
            //     url: "transaction_view_details",
            //     data: {trans_id: transcation_id},
            //     type: "POST",
            //     cache: false,
            //     dataType: 'json',
            //     success: function (data) {
            //
            //         jQuery(".table-values").append(data[0]);
            //         jQuery(".table-header").append(data[1]);
            //     },
            //     error: function (jqXHR, textStatus, errorThrown) {
            //         // alert(jqXHR.responseText);
            //         // alert(errorThrown);
            //     }
            // });
        });

    </script>

    <script>
        $(document).on("click", ".purchase", function () {
            $('#myModal').modal('hide');

            jQuery("#table_body1").html("");

            var id = jQuery(this).attr("data-id");

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "purchase_items_view_details",
                data: {id: id},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    $.each(data, function (index, value) {

                        jQuery("#table_body1").append('<tr><td class="align_center">' + value['pii_product_code'] + '</td><td class="align_left">' + value['pii_product_name'] + '</td><td class="align_right">' + value['pii_qty'] + '</td><td class="align_right">' + value['pii_rate'] + '</td><td class="align_right">' + value['pii_discount'] + '</td><td class="align_right">' + value['pii_saletax'] + '</td><td class="align_right">' + value['pii_amount'] + '</td><td class="align_right">' + value['pii_gross_rate'] + '</td><td class="align_right">' + value['pii_expense'] + '</td><td class="align_right">' + value['pii_net_rate'] + '</td><td class="align_left">' + value['pii_remarks'] + '</td></tr>');

                    });
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // alert(jqXHR.responseText);
                    // alert(errorThrown);
                }
            });
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>

    <script type="text/javascript">
        jQuery(function () {
            jQuery('.datepicker1').datepicker({
                language: 'en', dateFormat: 'dd-M-yyyy'
            });
        });


        // var doc = new jsPDF();
        // var specialElementHandlers = {
        //     '#editor': function (element, renderer) {
        //         return true;
        //     }
        // };
        //
        // $('#pdfTable').click(function () {
        //     doc.fromHTML($('#printTable').html(), 15, 15, {
        //         'width': 500,
        //         'elementHandlers': specialElementHandlers
        //     });
        //     doc.save('sample-file.pdf');
        // });

    </script>
    <script>
        jQuery("#cancel").click(function () {
            $("#to").val('');
            $("#from").val('');
        });
    </script>
@endsection

