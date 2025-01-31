@extends('print.college_print_index')

@if ($type !== 'download_excel')
    @section('print_title', $pge_title)
@endif

@section('print_cntnt')
<table class="table table-bordered table-sm" id="fixTable">

    <thead>
        <tr>
            <th scope="col" class="tbl_srl_4">
                ID
            </th>
            <th scope="col" class="tbl_txt_37">
                Name
            </th>
            <th scope="col" class="tbl_txt_37">
                Extra Leave
            </th>
            <th scope="col" class="tbl_txt_37">
                Causual Leave
            </th>
            <th scope="col" class="tbl_txt_37">
                Short Leave
            </th>
            <th scope="col" class="tbl_txt_37">
                Half Leave
            </th>
            <th scope="col" class="tbl_txt_37">
                Description
            </th>
            <th scope="col" class="tbl_txt_37">
                Branch
            </th>
        </tr>
    </thead>

    <tbody>
        @php
            $sr = 1;
        @endphp
        @forelse($datas as $data)
            <tr>
                <th scope="row">
                    {{ $sr }}
                </th>
                <td class="edit">
                    {{ $data->hr_plan_name }}
                </td>
                <td class="edit">
                    {{ $data->hr_plan_extra_leave }}
                </td>
                <td class="edit">
                    {{ $data->hr_plan_causual_leave }}
                </td>
                <td class="edit">
                    {{ $data->hr_plan_short_leave }}
                </td>
                <td class="edit">
                    {{ $data->hr_plan_half_leave }}
                </td>
                <td class="edit">
                    {{ $data->hr_plan_description }}
                </td>
                <td class="edit">
                    {{ $data->branch_name }}
                </td>
                <td class="usr_prfl "title="Click To See User Detail">
                    {{ $data->users->user_name }}
                </td>
            </tr>
            @php
                $sr++;
            @endphp
        @empty
            <tr>
                <td colspan="11">
                    <center>
                        <h3 style="color:#554F4F">No Hr Plans</h3>
                    </center>
                </td>
            </tr>
        @endforelse
    </tbody>

</table>
@endsection
