@extends('print.college_print_index')

@if ($type !== 'download_excel')
    @section('print_title', $pge_title)
@endif

@section('print_cntnt')
<table class="table table-bordered table-sm" id="fixTable" style="padding-left: 15px; padding-right: 15px; margin-top:25px">
    <thead>
    <tr>
        <th scope="col" class="tbl_srl_4">
            Sr#
        </th>

        <th scope="col" class="tbl_txt_37">
            Reason
        </th>
        <th scope="col" class="tbl_txt_15">
            Created By
        </th>

    </tr>
    </thead>

    <tbody>
    @php
        
        $sr = 1;
    @endphp
    @forelse($datas as $data)
        <tr >
            <th>
                {{$sr}}
            </th>

            <td class="edit ">
                {{ $data->cssr_title }}
            </td>
            <td class="usr_prfl " title="Click To See User Detail">
                {{ $data->user_name }}
            </td>

        </tr>
        @php
            $sr++;
        @endphp
    @empty
        <tr>
            <td colspan="11">
                <center>
                    <h3 style="color:#554F4F">No Reason</h3>
                </center>
            </td>
        </tr>
    @endforelse
    </tbody>

</table>
@endsection
