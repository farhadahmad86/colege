
@extends('extend_index')

@section('content')

    <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">
                    <div class="form_header"><!-- form header start -->
                        <div class="clearfix">
                            <div class="pull-left">
                                <h4 class="text-white get-heading-text">Fixed Accounts</h4>
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
                                </div><!-- end row -->
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive" id="printTable">
                        <table class="table table-bordered fixed_header table-sm" id="fixTable">

                            <thead>
                                <tr>
                                    <th scope="col" align="center" class="text-center align_center tbl_srl_4">
                                        Sr#
                                    </th>
                                    <th scope="col" align="center" class="align_center text-center tbl_amnt_25">Account ID</th>
                                    <th scope="col" align="center" class="align_center text-center tbl_txt_71">Account Title</th>
                                </tr>
                            </thead>

                            <tbody>
                            @php
                                $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
                                $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
                                $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                                $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
                            @endphp
                            @foreach($datas as $account)

                                <tr>

                                    <td class="align_center text-center edit tbl_srl_4">
                                        {{$sr}}
                                    </td>
                                    <form name="f1" class="f1" id="f1" action="" onsubmit="return form_validation()" method="post">

                                        <td class="align_center edit text-center tbl_amnt_25">

                                            <input type="text" class="form-control text-center" autocomplete="off" value="{{$account->account_uid}}" readonly style="background-color: transparent;border: 0px solid transparent"/>
                                            <span id="demo1" class="validate_sign"> </span>
                                        </td>
                                        <td class="align_left edit text-left tbl_txt_71">
                                            <input type="text" name="name" class="form-control" placeholder="Account Title" value="{{$account->account_name}}" autofocus autocomplete="off" readonly  style="background-color: transparent;border: 0px solid transparent"/>
                                            <span id="demo2" class="validate_sign"> </span>
                                        </td>

                                    </form>

                                </tr>


                                <input type="hidden" name="id" class="form-control" value="{{$account->account_id}}" autocomplete="off"/>

                                <input type="hidden" name="head_code" class="form-control" value="{{$account->account_parent_code}}" autocomplete="off"/>
                                @php
                                    $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                                @endphp
                            @endforeach
                            </tbody>

                        </table>

                    </div>

                </div> <!-- white column form ends here -->


            </div><!-- col end -->


        </div><!-- row end -->

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-blue">Default Accounts Name</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>110101 : Cash In Hand</p>
                    <p>110121 : Stock In Hand</p>
                    <p>310101 : Sales Revenue</p>
                    <p>310111 : Sales Return & Allowances</p>
                    <p>311121 : Services A/C</p>
                    <p>414101 : Purchase Return & Allowances</p>
                    <p>510101 : Capital A/C</p>
                </div>

                <div class="modal-footer">

                    <div class="col-lg-2 col-md-2 col-sm-2">
                        <button type="button" class="btn btn-default form-control cancel_button" data-dismiss="modal">Cancel</button>
                    </div>
                    <div class="col-lg-6 col-md-6"></div>
                    <div class="col-lg-2 col-md-2 col-sm-2">
                        <button type="button" class="btn btn-default confirm form-control save_button">Confirm</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('default_account_list_view') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>

        jQuery(".confirm").on("click", function () {
            jQuery("#f2").submit();
        });

    </script>

@endsection

