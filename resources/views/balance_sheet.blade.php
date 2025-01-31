
@extends('extend_index')

@section('content')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">
                    <div class="form_header"><!-- form header start -->
                        <div class="clearfix">
                            <div class="pull-left">
                                <h4 class="text-white get-heading-text">Balance Sheet</h4>
                            </div>
                            <div class="list_btn list_mul">
                                <div class="srch_box_opn_icon">
                                    <i class="fa fa-search"></i>
                                </div>
                            </div><!-- list btn -->
                        </div>
                    </div><!-- form header close -->



                    <div class="search_form hidden">
                        <div class="row">

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form_controls text-center text-lg-right">

                                            @include('include/print_button')

                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div><!-- search form end -->



                    <div class="table-responsive">
                        <table class="table table-sm">

                            <thead>
                            <tr>
                                <th scope="col" align="center" class="align_center text-center tbl_txt_70">
                                    Narration
                                </th>
                                <th scope="col" align="center" class="align_center text-center tbl_amnt_15">
                                    Cr.
                                </th>
                                <th scope="col" align="center" class="align_center text-center tbl_amnt_15">
                                    Dr.
                                </th>
                            </tr>
                            </thead>

                            <tbody>

                            @if((isset($assets_items) && !empty($assets_items))  && (isset($liabilities_items) && !empty($liabilities_items))  && (isset($equities_items) && !empty($equities_items)))

                            <tr>
                                <th class="align_left text-left" colspan="3">
                                    Assets
                                </th>
                            </tr>

                            @forelse($assets_items as $assets_item)
                                <tr>
                                    <td class="align_left text-left tbl_txt_70">
                                        {{$assets_item->bsi_title}}
                                    </td>
                                    <td class="align_right text-right tbl_amnt_15"></td>
                                    <td class="align_right text-right tbl_amnt_15">
                                        {{number_format($assets_item->bsi_amount,2)}}
                                    </td>
                                </tr>
                            @empty
                            @endforelse

                            <tr>
                                <th class="align_left text-left" colspan="2">
                                    Total Assets
                                </th>
                                <th class="align_right text-right tbl_amnt_15">
                                    {{ number_format($balance_sheet-> bs_total_assets,2)}}
                                </th>
                            </tr>


                            <tr>
                                <th class="align_left text-left" colspan="3">Liabilities</th>
                            </tr>

                            @forelse($liabilities_items as $liabilities_item)
                                <tr>
                                    <td class="align_left text-left tbl_txt_70">
                                        {{$liabilities_item->bsi_title}}
                                    </td>
                                    <td class="align_right text-right tbl_amnt_15">
                                        {{number_format($liabilities_item->bsi_amount,2)}}
                                    </td>
                                    <td class="align_right text-right tbl_amnt_15"></td>
                                </tr>
                            @empty
                            @endforelse

                            <tr>
                                <th class="align_left text-left tbl_txt_70" colspan="2">Total Liabilities</th>
                                <th class="align_right text-right tbl_amnt_15">
                                    {{ number_format($balance_sheet-> bs_total_liabilities,2)}}
                                </th>
                            </tr>


                            <tr>
                                <th class="align_left text-left" colspan="3">Equity</th>
                            </tr>

                            @forelse($equities_items as $equities_item)
                                <tr>
                                    <td class="align_left text-left tbl_txt_70">
                                        {{$equities_item->bsi_title}}
                                    </td>
                                    <td class="align_right text-right tbl_amnt_15">
                                        {{number_format($equities_item->bsi_amount,2)}}
                                    </td>
                                    <td class="align_right text-right tbl_amnt_15"></td>
                                </tr>
                            @empty
                            @endforelse
                            <tr>
                                <th class="align_left text-left" colspan="2">Total Equity</th>
                                <th class="align_right text-right tbl_amnt_15">
                                    {{ number_format($balance_sheet-> bs_total_equity,2)}}
                                </th>
                            </tr>

                            <tr>
                                <th class="align_left text-left" colspan="2">Total Liability And Equity</th>
                                <th class="align_right text-right tbl_amnt_15">
                                    {{ number_format($balance_sheet-> bs_liabilities_and_equity,2)}}
                                </th>
                            </tr>


                            @endif

                            </tbody>

                        </table>


                    </div>
                </div> <!-- white column form ends here -->


            </div><!-- col end -->


        </div><!-- row end -->

@endsection

@section('scripts')

    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('balance_sheet') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

@endsection

