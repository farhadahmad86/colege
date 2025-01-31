@extends('extend_index')
@section('content')
    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header">
                <!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="text-white get-heading-text file_name">Year List</h4>
                    </div>
                    <div class="list_btn list_mul">
                        <div class="srch_box_opn_icon">
                            <i class="fa fa-search"></i>
                        </div>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->
<x-year-end-component search="{{$search_year}}"/>
            <div class="table-responsive" id="printTable">
                <table class="table table-bordered table-sm" id="fixTable">

                    <thead>
                    <tr>
                        <th scope="col" class="tbl_srl_4">
                            ID
                        </th>
                        <th scope="col" class="tbl_txt_25">
                            Title
                        </th>
                        <th scope="col" class="tbl_txt_20">
                            Start
                        </th>
                        <th scope="col" class="tbl_txt_25">
                            End
                        </th>
                    </tr>
                    </thead>

                    <tbody>

                    @forelse($datas as $data)
                        <tr>
                            <th scope="row" class="edit ">
                                {{ $data->ye_id }}
                            </th>
                            <td class="edit ">
                                {{ $data->ye_title }}
                            </td>
                            <td class="edit ">
                                {{ $data->ye_from }}
                            </td>
                            <td class="edit ">
                                {{ $data->ye_to }}
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="11">
                                <center>
                                    <h3 style="color:#554F4F">No Year</h3>
                                </center>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>

                </table>

            </div>
        </div> <!-- white column form ends here -->
    </div><!-- row end -->

@endsection

