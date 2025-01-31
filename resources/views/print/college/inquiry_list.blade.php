
@extends('print.print_index')

@if( $type !== 'download_excel')
    @section('print_title', $pge_title)
@endif

@section('print_cntnt')

    <table class="table border-0 table-sm">
        <thead>
        <tr>
            <th scope="col" class="tbl_srl_2">
                Sr
            </th>
            <th scope="col" class="tbl_txt_12">
                Name
            </th>  <th scope="col" class="tbl_txt_8">
                Program
            </th>
            <th scope="col" class="tbl_txt_6">
                Father Name
            </th>

            <th scope="col" class="tbl_txt_6">
                Contact
            </th>
            <th scope="col" class=" tbl_tx_8">
                CNIC
            </th>
            <th scope="col" class=" tbl_txt_6">
                Father Contact
            </th>

            <th scope="col" class=" tbl_txt_4">
                10th Marks
            </th>
            <th scope="col" class=" tbl_txt_20">
                Address
            </th>
            <th scope="col" class=" tbl_txt_6">
                Inquiry Status
            </th>
            <th scope="col" class="tbl_txt_4">
                Inquire Date
            </th>
            <th scope="col" class=" tbl_txt_6">
                Branch
            </th>
            <th scope="col" class=" tbl_txt_6">
                Created By
            </th>

        </tr>
        </thead>
        <tbody>
        @php
            $sr=1;
        @endphp
        @forelse($datas as $data)

            <tr>
                <td class="edit ">
                    {{ $sr }}
                </td>
                <td class="edit ">
                    {{ $data->inq_full_name }}
                </td>
                <td class="edit ">
                    {{ $data->program_name }}
                </td>
                <td class="edit ">
                    {{ $data->inq_father_name }}
                </td>

                <td class="edit ">
                    {{ $data->inq_contact }}
                </td>
                <td class="edit ">
                    {{ $data->inq_cnic }}
                </td>
                <td class="edit ">
                    {{ $data->inq_parent_contact }}
                </td>

                <td class="edit ">
                    {{ $data->inq_marks_10th }}
                </td>
                <td class="edit ">
                    {{ $data->inq_address }}
                </td>
                <td class="edit ">
                    @foreach (explode(',', $data->inq_status) as $status)
                        {{ htmlspecialchars($status) }}
                    @endforeach
                </td>
                <td class="edit ">
                    {{ $data->inq_inquire_date }}
                </td>
                <td class="edit ">
                    {{ $data->branch_name }}
                </td>
                <td class="edit ">
                    {{ $data->created_by }}
                </td>
            </tr>
            @php
                $sr++;
            @endphp
        @empty
            <tr>
                <td colspan="11">
                    <center><h3 style="color:#554F4F">No Inquiry</h3></center>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

@endsection

