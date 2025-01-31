@extends('invoice_view.print_index')

@section('print_cntnt')

    @php
        $company_info = Session::get('company_info');
    @endphp


    <div id="" class="table-responsive">

        <table class="tabletable-bordered table-sm p-0 m-0" id="">
            @if($type === 'grid')
                @include('invoice_view._partials.pdf_header', [$invoice_nbr, $invoice_date, $pge_title])
            @endif
            <tr class="bg-transparent">
                <td colspan="3" class="p-0 border-0">
                    <p class="invoice_para pt-0 mt-0 mb-0">
                        <b> Remarks: </b>
                        {{ $jrnl->pc_remarks }}
                    </p>
                </td>
            </tr>
        </table>

        <table class="table table-bordered table-sm" id="">
            <thead>
            <tr class="headings vi_tbl_hdng">
                <th scope="col"  class="text-center  tbl_srl_4">
                    Sr.
                </th>
                <th scope="col"  class="text-center  tbl_amnt_10">
                    Code
                </th>
                <th scope="col"  class="text-center  tbl_txt_20">
                    Product Name
                </th>
                <th scope="col"  class="text-center  tbl_txt_15">
                    Remarks
                </th>
                <th scope="col"  class="text-center  tbl_txt_10">
                    Warehouse
                </th>
                <th scope="col"  class="text-center  tbl_txt_8">
                    Qty
                </th>
                <th scope="col"  class="text-center  tbl_txt_10">
                    Rate
                </th>
                <th scope="col"  class="text-center  tbl_txt_8">
                    Pack Qty
                </th>
                <th scope="col"  class="text-center  tbl_txt_8">
                    Loose Qty
                </th>
                <th scope="col"  class="text-center  tbl_txt_10">
                    Amount
                </th>
            </tr>
            </thead>

            <tbody>
            @php $i = 1; $grand_total = $ttl_dr = $ttl_cr = $adv_amnt = $adv_amnt_deduct = $ttl_paid = 0; $vchr_id = ''; $ttl_pack=0; $ttl_loose=0; @endphp
            @foreach( $items as $item )
                @php
                    $vchr_id = $item->pci_pc_id;
                    $grand_total = +$item->pci_amount + +$grand_total;

                 $db_qty=$item->pci_qty;
                 $scale_size=$item->pci_scale_size;
                 $pack_qty = floor($db_qty/$scale_size);
                 $loose_qty = fmod($db_qty, $scale_size);
                 $ttl_pack=$ttl_pack + $pack_qty;
                 $ttl_loose=$ttl_loose + $loose_qty;
                @endphp
                <tr class="even pointer">
                    <td class=" text-center tbl_srl_4">
                        {{ $i }}
                    </td>
                    <td  class=" text-center tbl_amnt_10">
                        {{ $item->pci_product_code }}
                    </td>
                    <td class="align_left text-left tbl_txt_20">
                        {{ $item->pci_product_name }}
                    </td>
                    <td class="align_left text-left tbl_txt_15">
                        {!! $item->pci_remarks !!}
                    </td>
                    <td class="align_left text-left tbl_txt_10">
                        {!! $item->pci_warehouse_name !!}
                    </td>
                    <td class="align_left text-left tbl_txt_8">
                        {!! $item->pci_qty !!}
                    </td>
                    <td class="align_left text-left tbl_txt_10">
                        {!! $item->pci_rate !!}
                    </td>
                    <td class="align_left text-left tbl_txt_8">
                        {!! $pack_qty !!}
                    </td>
                    <td class="align_left text-left tbl_txt_8">
                        {!! $loose_qty !!}
                    </td>
                    <td class="align_left text-left tbl_txt_10">
                        {!! $item->pci_amount !!}
                    </td>
                </tr>
            @endforeach
            <tr class="border-0">
                <th colspan="9" align="right" class="border-0 pt-0 text-right align_right">
                    Grand Total:
                </th>
                <td class="text-right align_right border-left-0 border-right-0 border-top-2 border-bottom-3" align="right">
                    {{ number_format($grand_total,2) }}
                </td>
            </tr>

            </tbody>


            <tfoot>
            <tr>
                <td colspan="10" class="border-0 p-0">
                    <div class="wrds_con">
                        <div class="wrds_bx">
                        <span class="wrds_hdng">
                            In Words
                        </span>
                            {{ $nbrOfWrds }} only
                        </div>
                        <div class="wrds_bx wrds_bx_two">
                        <span class="wrds_hdng">
                            Receipient Sign.
                        </span>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="6" class="border-0 p-0">
                    <div class="sign_con">

                        <div class="sign_bx">
                        <span class="sign_itm">
                            Prepared By
                        </span>
                        </div>

                        <div class="sign_bx">
                        <span class="sign_itm">
                            Checked By
                        </span>
                        </div>

                        <div class="sign_bx">
                        <span class="sign_itm">
                            Accounts Manager
                        </span>
                        </div>

                        <div class="sign_bx">
                        <span class="sign_itm">
                            Chief Executive
                        </span>
                        </div>

                    </div>
                </td>
            </tr>
            </tfoot>

        </table>

        <div class="clearfix"></div>
        @if( $type === 'grid')
            <div class="itm_vchr_rmrks">

                <a href="{{ route('claim_stock_issue_to_party_items_view_details_pdf_SH',['id'=>$jrnl->pc_id]) }}" class="align_right text-center btn btn-sm btn-info" style="float: left;margin-top: 7px;">
                    Download/Get PDF/Print
                </a>
            </div>
        @endif

    </div>
    <div class="input_bx_ftr"></div>

@endsection
