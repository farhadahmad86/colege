@extends('print.print_index')

@if( $type !== 'download_excel')
    @section('print_title', $pge_title)
@endif

@section('print_cntnt')

    <table class="table table-bordered table-sm" id="fixTable">

        <thead>
        <tr>
            <th scope="col" class="tbl_srl_4">
                Sr
            </th>
            <th scope="col" class="tbl_txt_20">
                Class Name
            </th>
            <th scope="col" class="tbl_txt_10">
                Group
            </th>
            <th scope="col" class="tbl_txt_15">
                Subject
            </th>
            <th scope="col" class="tbl_txt_25">
                Title
            </th>
            <th scope="col" class="tbl_txt_18">
                Link
            </th>

            <th scope="col" class="tbl_txt_8">
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
            <tr data-class_id="{{ $data->lec_class_id }}" data-group_id="{{ $data->lec_group_id }}" data-lec_id="{{ $data->lec_id }}"
                data-subject_id="{{ $data->lec_subject_id }}"
                data-title="{{ $data->lec_title }}"
                data-link="{{ $data->lec_link }}">
                <th scope="row">
                    {{ $sr }}
                </th>
                <td class="edit ">
                    {{ $data->class_name }}
                </td>
                <td class="edit ">
                    {{ $data->ng_name }}
                </td>
                <td class="edit ">
                    {{ $data->subject_name }}
                </td>
                <td>
                    {{ $data->lec_title }}
                </td>
                <td>
                    <a href="{{ $data->lec_link }}" class="btn btn-sm btn-primary" target="_blank">Link</a>
                </td>

                <td class="usr_prfl">
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
                        <h3 style="color:#554F4F">No Lecture Upload</h3>
                    </center>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

@endsection

