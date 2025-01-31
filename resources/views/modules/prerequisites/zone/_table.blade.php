{{--<div class="table-responsive">--}}
{{--    <table class="table table-sm table-striped table-hover">--}}
{{--        <thead>--}}
{{--        <tr>--}}
{{--            <th>#</th>--}}
{{--            <th>Name</th>--}}
{{--            <th>Region</th>--}}
{{--            <th>Company</th>--}}
{{--            <th>Status</th>--}}
{{--            <th>Actions</th>--}}
{{--        </tr>--}}
{{--        </thead>--}}
{{--        <tbody>--}}
{{--        @forelse ($zones as $index => $zone)--}}
{{--            <tr>--}}
{{--                <th>{{ $index + 1 }}</th>--}}
{{--                <td>{{ $zone->name }}</td>--}}
{{--                <td>{{ $zone->region->name }}</td>--}}
{{--                <td>{{ $zone->company->name }}</td>--}}
{{--                <td>{{ $zone->status }}</td>--}}
{{--                <td>--}}
{{--                    <a href="{{ route('zones.edit', $zone) }}" class="btn btn-sm btn-warning d-inline"><i class="fa fa-edit"></i></a>--}}
{{--                    <form action="{{ route('zones.destroy', $zone) }}" method="post" class="d-inline">--}}
{{--                        @csrf--}}
{{--                        @method('delete')--}}
{{--                        <button type="submit" class="btn btn-sm btn-danger d-inline"><i class="fa fa-trash"></i></button>--}}
{{--                    </form>--}}
{{--                </td>--}}
{{--            </tr>--}}
{{--        @empty--}}
{{--            <tr>--}}
{{--                <th colspan="6" class="text-danger text-center font-weight-bold">No Zone Available</th>--}}
{{--            </tr>--}}
{{--        @endforelse--}}
{{--        </tbody>--}}
{{--    </table>--}}
{{--    <div class="text-center">--}}
{{--        {{ $zones->links() }}--}}
{{--    </div>--}}
{{--</div>--}}


{{--<div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">--}}

{{--    <div class="search_form {{ ( !empty($search) || !empty($search_region) ) ? '' : 'search_form_hidden' }}">--}}
{{--        <div class="row">--}}

{{--            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">--}}

{{--                <form class="prnt_lst_frm" action="{{ route('region_list') }}" name="form1" id="form1" method="post">--}}
{{--                    <div class="row">--}}
{{--                        @csrf--}}
{{--                        <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">--}}
{{--                            <div class="input_bx"><!-- start input box -->--}}
{{--                                <label>--}}
{{--                                    All Column Search--}}
{{--                                </label>--}}
{{--                                <input type="search" list="browsers" class="inputs_up form-control" name="search"--}}
{{--                                       id="search" placeholder="All Data Search"--}}
{{--                                       value="{{ isset($search) ? $search : '' }}" autocomplete="off">--}}
{{--                                <datalist id="browsers">--}}

{{--                                </datalist>--}}
{{--                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>--}}
{{--                            </div>--}}
{{--                        </div> <!-- left column ends here -->--}}


{{--                    </div><!-- end row -->--}}
{{--                </form>--}}


{{--                <form name="edit" id="edit" action="{{ route('edit_region') }}" method="post">--}}
{{--                    @csrf--}}
{{--                    <input name="title" id="title" type="hidden">--}}
{{--                    <input name="remarks" id="remarks" type="hidden">--}}
{{--                    <input name="region_id" id="region_id" type="hidden">--}}

{{--                </form>--}}

{{--                <form name="delete" id="delete" action="{{ route('delete_region') }}" method="post">--}}
{{--                    @csrf--}}
{{--                    <input name="reg_id" id="reg_id" type="hidden">--}}
{{--                </form>--}}

{{--            </div>--}}

{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="table-responsive" id="printTable">--}}
{{--        <table class="table table-sm" id="fixTable">--}}

{{--            <thead>--}}
{{--            <tr>--}}
{{--                <th scope="col" align="center" class="text-center align_center tbl_srl_4">--}}
{{--                    Sr#--}}
{{--                </th>--}}
{{--                <th scope="col" align="center" class="text-center align_center tbl_txt_25">--}}
{{--                    Title--}}
{{--                </th>--}}
{{--                <th scope="col" align="center" class="text-center align_center tbl_txt_25">--}}
{{--                    Company Name--}}
{{--                </th>--}}
{{--                <th scope="col" align="center" class="text-center align_center tbl_txt_25">--}}
{{--                    Region Name--}}
{{--                </th>--}}
{{--                <th scope="col" align="center" class="text-center align_center tbl_srl_6">--}}
{{--                    Status--}}
{{--                </th>--}}

{{--                <th scope="col" align="center" class="text-center align_center tbl_txt_8">--}}
{{--                    Created By--}}
{{--                </th>--}}
{{--                <th scope="col" align="center" class="text-center align_center hide_column tbl_srl_6">--}}
{{--                    Action--}}
{{--                </th>--}}
{{--            </tr>--}}
{{--            </thead>--}}

{{--            <tbody>--}}

{{--            @forelse($zones as $index => $data)--}}

{{--                <tr data-title="{{$data->name}}" data-remarks="{{$data->remarks}}"--}}
{{--                    data-company_id="{{$data->id}}">--}}
{{--                    <td class="align_center text-center edit tbl_srl_4">--}}
{{--                        --}}{{--                            {{$sr}}--}}
{{--                        {{$index + 1}}--}}
{{--                    </td>--}}
{{--                    <td class="align_left text-left edit tbl_txt_25">--}}
{{--                        {{$data->name}}--}}
{{--                    </td>--}}
{{--                    <td class="align_left text-left edit tbl_txt_25">--}}
{{--                        {{$data->region->name }}--}}
{{--                    </td>--}}
{{--                    <td class="align_left text-left edit tbl_txt_25">--}}
{{--                        {{$data->company->account_name }}--}}
{{--                    </td>--}}
{{--                    <td class="align_left text-left edit tbl_srl_6">--}}
{{--                        {{$data->status}}--}}
{{--                    </td>--}}


{{--                    @php--}}
{{--                        $ip_browser_info= ''.$data->reg_ip_adrs.','.str_replace(' ','-',$data->reg_brwsr_info).'';--}}
{{--                    @endphp--}}


{{--                    <td class="align_center tbl_txt_8">{{ $data->createdBy->user_name }}</td>--}}

{{--                    <td>--}}
{{--                        <a href="{{ route('zones.edit', $data) }}" class="btn btn-sm btn-warning d-inline"><i--}}
{{--                                class="fa fa-edit"></i></a>--}}
{{--                        <form action="{{ route('zones.destroy', $data) }}" method="post" class="d-inline">--}}
{{--                            @csrf--}}
{{--                            @method('delete')--}}
{{--                            <button type="submit" class="btn btn-sm btn-danger d-inline"><i class="fa fa-trash"></i>--}}
{{--                            </button>--}}
{{--                        </form>--}}
{{--                    </td>--}}
{{--                </tr>--}}

{{--            @empty--}}
{{--                <tr>--}}
{{--                    <td colspan="11">--}}
{{--                        <center><h3 style="color:#554F4F">No Region</h3></center>--}}
{{--                    </td>--}}
{{--                </tr>--}}
{{--            @endforelse--}}
{{--            </tbody>--}}

{{--        </table>--}}

{{--    </div>--}}
{{--   --}}
{{--</div> <!-- white column form ends here -->--}}



