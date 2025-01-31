@extends('extend_index')
    @section('content')
    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header"><!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="text-white get-heading-text file_name">City List</h4>
                    </div>
                    <div class="list_btn list_mul">
                        <div class="srch_box_opn_icon">
                            <i class="fa fa-search"></i>
                        </div>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->
            <!-- <div class="search_form  {{ ( !empty($search) || !empty($search_province) ) ? '' : 'search_form_hidden' }}"> -->
            <div class="search_form m-0 p-0">
                <form class="highlight prnt_lst_frm" action="{{ route('city_list') . ((isset($restore_list) && $restore_list == 1) ? '?restore_list=1' : '') }}" name="form1" id="form1" method="post">
                    <div class="row">
                        @csrf
                        <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                            <div class="input_bx"><!-- start input box -->
                                <label>All Column Search</label>
                                <input tabindex="1" autofocus type="search" list="browsers" class="inputs_up form-control all_clm_srch" name="search" id="search" placeholder="Search ..." value="{{ isset($search) ? $search : '' }}" autocomplete="off">
                                <datalist id="browsers">
                                @foreach($city_title as $value)
                                <option value="{{$value}}">
                                @endforeach
                                </datalist>
                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                            </div>
                        </div> <!-- left column ends here -->
                        <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                            <div class="input_bx"><!-- start input box -->
                                <label class="required">Select Province</label>
                                <select tabindex="2" class="inputs_up form-control cstm_clm_srch" name="province" id="province" style="width: 90%">
                                    <option value="">Select Province</option>
                                    <option value="Azad Kashmir" {{ "Azad Kashmir" == $search_province ? 'selected="selected"' : ''}} >Azad Kashmir</option>
                                    <option value="Balochistan" {{ "Balochistan" == $search_province ? 'selected="selected"' : ''}}>Balochistan</option>
                                    <option value="Federally Administered Tribal Areas" {{ "Federally Administered Tribal Areas" == $search_province ? 'selected="selected"' : ''}}>Federally Administered Tribal Areas</option>
                                    <option value="Gilgit Baltistan" {{ "Gilgit Baltistan" == $search_province ? 'selected="selected"' : ''}}>Gilgit Baltistan</option>
                                    <option value="Khyber Pakhtunkhwa" {{ "Khyber Pakhtunkhwa" == $search_province ? 'selected="selected"' : ''}}>Khyber Pakhtunkhwa</option>
                                    <option value="Punjab" {{ "Punjab" == $search_province ? 'selected="selected"' : ''}}>Punjab</option>
                                    <option value="Sindh" {{ "Sindh" == $search_province ? 'selected="selected"' : ''}}>Sindh</option>
                                </select>
                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                            </div>
                        </div>
                        <div class="form-group col-lg-8 col-md-6 col-sm-12 col-xs-12 mt-4 text-right">
                                @include('include.clear_search_button')
                                <!-- Call add button component -->
                                    <x-add-button tabindex="9" href="{{ route('add_city') }}"/>
                            @include('include/print_button')
                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                        </div>
                    </div>
                </form>
                <form name="edit" id="edit" action="{{ route('edit_city') }}" method="post">
                    @csrf
                    <input name="province" id="province" type="hidden">
                    <input name="city_name" id="city_name" type="hidden">
                    {{--                                <input name="remarks" id="remarks" type="hidden">--}}
                    <input name="city_id" id="city_id" type="hidden">
                    <input name="province_id" id="province_id" type="hidden">
                </form>
                <form name="delete" id="delete" action="{{ route('delete_city') }}" method="post">
                    @csrf
                    <input name="city_id" id="del_city_id" type="hidden">
                </form>
            </div>
            <div class="table-responsive" id="printTable">
                <table class="table table-bordered table-sm" id="fixTable">
                    <thead>
                        <tr>
                            <th scope="col" class="tbl_srl_5">Sr#</th>
                            <th scope="col" class="tbl_srl_5">ID</th>
                            <th scope="col" class="tbl_txt_40">Province</th>
                            <th scope="col" class="tbl_txt_50">City Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
                        $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
                        $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                        $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
                        @endphp
                        @forelse($datas as $city)
                        <tr data-province="{{$city->city_prov}}" data-city_name="{{$city->city_name}}" data-city_id="{{$city->city_id}}" data-province_id="{{$city->city_prov}}">
                            <th scope="ROW" class="edit ">{{$sr}}</tH>
                            <td class="edit ">{{$city->city_id}}</td>
                            <td class="edit">{{$city->city_prov}}</td>
                            <td class="edit">{{$city->city_name}}</td>
                        </tr>
                        @php
                        $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                        @endphp
                        @empty
                        <tr>
                            <td colspan="11">
                            <center><h3 style="color:#554F4F">No City</h3></center>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-lg-12 text-right">
                    <span class="hide_column"> {{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search, 'province'=>$search_province ])->links() }}</span>
                </div>
            </div>
        </div> <!-- white column form ends here -->
    </div><!-- row end -->
    @endsection
@section('scripts')
    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('city_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}
    <script>
        $(document).ready(function () {
        });
    </script>
    <script>
        jQuery(".edit").click(function () {
            var province = jQuery(this).parent('tr').attr("data-province");
            var city_name = jQuery(this).parent('tr').attr("data-city_name");
            var remarks = jQuery(this).parent('tr').attr("data-remarks");
            var city_id = jQuery(this).parent('tr').attr("data-city_id");
            var province_id = jQuery(this).parent('tr').attr("data-province_id");
            jQuery("#province").val(province);
            jQuery("#city_name").val(city_name);
            jQuery("#remarks").val(remarks);
            jQuery("#city_id").val(city_id);
            jQuery("#province_id").val(province_id);
            jQuery("#edit").submit();
        });
        $('.delete').on('click', function (event) {
            var city_id = jQuery(this).attr("data-city_id");
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
                    jQuery("#del_city_id").val(city_id);
                    jQuery("#delete").submit();
                } else {

                }
            });
        });
        {{--$(function() {--}}
        {{--var availableTutorials  =  JSON.parse('{!! json_encode($city_name) !!}');--}}
        {{--$( "#search" ).autocomplete({--}}
        {{--source: availableTutorials,--}}
        {{--});--}}
        {{--});--}}
    </script>
    <script>
        jQuery("#cancel").click(function () {
            $("#province").select2().val(null).trigger("change");
            $("#province > option").removeAttr('selected');
            $("#search").val('');
        });
    </script>
    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#province").select2();
        });
    </script>
    <style>
        input::-webkit-calendar-picker-indicator {
            display: none;
        }
    </style>
@endsection

