@extends('invoice_view.print_index')

@section('print_cntnt')

    @php
        $company_info = Session::get('company_info');
    @endphp


    <div id="" class="table-responsive">

        <table class="table border-0 table-sm p-0 m-0">
            @if($type === 'grid')
                @include('voucher_view._partials.pdf_header', [$pge_title])
            @endif
        </table>


        <table class="table table-bordered table-sm">
            <thead>
            <tr class="headings vi_tbl_hdng">
                <th scope="col" class="text-center tbl_srl_4">
                    Sr.
                </th>
                <th scope="col" class="text-center tbl_amnt_19">
                    Branch Name
                </th>
                <th scope="col" class="text-center tbl_txt_10">
                    Type
                </th>
                <th scope="col" class="text-center tbl_txt_20">
                   City
                </th>
                <th scope="col" class="text-center tbl_amnt_25">
                   Address
                </th>
                <th scope="col" class="text-center tbl_amnt_12">
                    Mobile-1
                </th>
                <th scope="col" class="text-center tbl_amnt_12">
                    Mobile-2
                </th>
            </tr>
            </thead>

            <tbody>
            @php $i = 01;@endphp
            @foreach( $items as $item )
                <tr class="even pointer">
                    <td class="text-center tbl_srl_4">
                        {{ $i }}
                    </td>
                    <td class="text-center tbl_amnt_19">
                        {{ $item->ccb_branch_name }}
                    </td>
                    <td class="align_left text-left tbl_txt_10">
                        {{ $item->ccb_type == 1 ? 'Head Office':'Branch'}}
                    </td>
                    <td class="align_left text-left tbl_txt_20">
                        {{$item->city_name}}
                    </td>
                    <td class="align_left text-left tbl_txt_25">
                        {{$item->ccb_address}}
                    </td>
                    <td class="align_left text-left tbl_txt_12">
                        {{$item->ccb_contact_num1}}
                    </td>
                    <td class="align_left text-left tbl_txt_12">
                        {{$item->ccb_contact_num2}}
                    </td>

                </tr>
                @php $i++;  @endphp
            @endforeach

            </tbody>

        </table>

        <div class="clearfix"></div>
        @if( $type === 'grid')
            <div class="itm_vchr_rmrks">
                <a href="{{ route('courier_items_view_details_pdf_SH',['id'=>$jrnl->cc_id]) }}" class="align_right text-center btn btn-sm btn-info" style="float: left;margin-top: 7px;">
                    Download/Get PDF/Print
                </a>
            </div>
        @endif

    </div>
    <div class="input_bx_ftr"></div>

@endsection
