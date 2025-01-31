
@extends('print.print_index')

@if( $type !== 'download_excel')
    @section('print_title', $pge_title)
@endif

@section('print_cntnt')

    <table id="content" class="table border-0 table-sm">
        <thead>
        <tr>
            <th scope="col" align="center" class="text-center align_center tbl_srl_6">
                Sr #
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_amnt_10">
                Code
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_10">
                Control Account
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_10">
                Group Account
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_29">
                Parent Account
            </th>
            <th scope="col" align="center" class="text-center align_center tbl_txt_29">
                Remarks
            </th>
        </tr>
        </thead>
        <tbody>
        @php
            $sr=1;
        @endphp
        @forelse($datas as $data)

            <tr data-account_id="{{$data->coa_id}}">
                <td class="text-center align_center edit tbl_srl_6">
                    {{$sr}}
                </td>
                <td class="text-center align_center edit tbl_amnt_10">
                    {{$data->coa_code}}
                </td>
                <td class="text-center align_center edit tbl_txt_10">
                    <?php if(substr($data->coa_code,0,1)==1){ echo 'Asset'; }elseif (substr($data->coa_code,0,1)==2){ echo 'Liability'; }elseif (substr($data->coa_code,0,1)==3){ echo 'Revenue'; }elseif (substr($data->coa_code,0,1)==4){ echo 'Expense'; }else{ echo 'Equity'; } ?>
                </td>
                <td class="text-center align_center edit tbl_txt_10">
                    {{$data->first_level_name}}
                </td>
                <td class="align_left text-left edit tbl_txt_29">
                    {{$data->second_level_name }}
                </td>
                <td class="align_left text-left edit tbl_txt_29">
                    {{$data->coa_remarks }}
                </td>

            </tr>
            @php
                $sr++;
            @endphp
        @empty
            <tr>
                <td colspan="11">
                    <center><h3 style="color:#554F4F">No Account</h3></center>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

@endsection

