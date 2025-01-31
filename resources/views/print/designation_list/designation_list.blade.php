
@extends('print.print_index')

@if( $type !== 'download_excel')
    @section('print_title', $pge_title)
@endif

@section('print_cntnt')

    <table class="table table-bordered table-sm" id="fixTable">

        <thead>
        <tr>
            <th scope="col" class="tbl_srl_4">
                ID
            </th>
            <th scope="col" class="tbl_txt_40">
                Title
            </th>
            <th scope="col" class="tbl_txt_35">
                Remarks
            </th>
            <th scope="col" class="tbl_txt_20">
                Created By
            </th>
        </tr>
        </thead>

        <tbody>
        @php
            $segmentSr = !empty(app('request')->input('segmentSr')) ? app('request')->input('segmentSr') : '';
            $segmentPg = !empty(app('request')->input('page')) ? app('request')->input('page') : '';
            $sr = !empty($segmentSr) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
            $countSeg = !empty($segmentSr) ? $segmentSr : 0;
        @endphp
        @forelse($datas as $data)
            <tr data-title="{{ $data->desig_name }}" data-remarks="{{ $data->desig_remarks }}"
                data-desig_id="{{ $data->desig_id }}">
                <th>
                    {{ $sr }}
                </th>
                <td class="edit ">
                    {{ $data->desig_name }}
                </td>
                <td class="edit ">
                    {{ $data->desig_remarks }}
                </td>

                @php
                    $ip_browser_info = '' . $data->desig_ip_adrs . ',' . str_replace(' ', '-', $data->desig_brwsr_info) . '';
                @endphp

                <td class="usr_prfl " data-usr_prfl="{{ $data->user_id }}"
                    data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                    {{ $data->user_name }}
                </td>
            </tr>
            @php
                $sr++;
                !empty($segmentSr) && $countSeg !== '0' ?: $countSeg++;
            @endphp
        @empty
            <tr>
                <td colspan="11">
                    <center>
                        <h3 style="color:#554F4F">No Designation</h3>
                    </center>
                </td>
            </tr>
        @endforelse
        </tbody>

    </table>

@endsection

