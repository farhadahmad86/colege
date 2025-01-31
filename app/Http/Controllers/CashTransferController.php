<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Imports\ExcelDataImport;
use App\Models\CashTransferModel;
use App\Models\EmployeeModel;
use App\User;
use PDF;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class CashTransferController extends ExcelForm\CashTransferForm\CashTransferController
{
    public function cash_transfer()
    {
        $user = Auth::User();

        $query = User::where('user_clg_id',$user->user_clg_id);

        if ($user->user_role_id != config('global_variables.teller_account_id')) {
            $query->where('user_role_id', config('global_variables.teller_account_id'));
        }

        $tellers = $query->where('user_delete_status', '!=', 1)
            ->where('user_id', '!=', $user->user_id)
            ->get();

        return view('cash_transfer', compact('tellers'));
    }

    public function submit_cash_transfer_excel(Request $request)
    {

        $rules = [
            'add_cash_transfer_excel' => 'required|mimes:xlsx,xls,csv|max:5000',
        ];

        $messages = [
            'add_cash_transfer_excel.max' => "Your File size too long.",
            'add_cash_transfer_excel.required' => "Please select your Cash Transfer Excel Sheet.",
        ];

        $validator = $this->validate($request, $rules, $messages);

        if ($request->hasFile('add_cash_transfer_excel')) {

//            dd($request->add_employee_excel);
//            $dateTime = date('Ymd_His');
//            $file = $request->file('add_employee_excel');
//            $fileName = $dateTime . '-' . $file->getClientOriginalName();
//            $savePath = public_path('/uploads/'.config('global_variables.excel_storage_folder_name'));
//            $file->move($savePath, $fileName);
//            $data = Excel::load($path)->get();



            $path = $request->file('add_cash_transfer_excel');
            $data = Excel::toArray(new ExcelDataImport, $path);

            $excelData = json_decode (json_encode ($data), FALSE);

                foreach ($excelData as $rows) {
                    foreach ($rows as $row) {
                        $rowData = (array) $row;
                        $request->merge($rowData);
                        $this->excel_cash_transfer_validation($request);

                        $rollBack = self::excel_form_cash_transfer($row);

                        if ($rollBack) {
                            DB::rollBack();
                            return redirect()->back()->with('fail', 'Failed Try Again');
                        }
                        else {
                            DB::commit();
                        }
                    }
                }


            return redirect()->back()->with(['success' => 'File Uploaded successfully.']);
        } else {
            return redirect()->back()->with(['errors' => $validator]);
        }

    }

    public function submit_cash_transfer(Request $request)
    {
        return self::simple_form_cash_transfer($request);
    }


    // update code by shahzaib start
    public function pending_cash_transfer_list(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $route = "pending_cash_transfer_list";
        $title = 'Pending Cash Transfer List';


        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.pending_cash_transfer_list.pending_cash_transfer_list';
        $pge_title = 'Pending Cash Transfer List';
        $srch_fltr = [];
        array_push($srch_fltr, $search);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $query = DB::table('financials_cash_transfer')
            ->join('financials_users as sendBy', 'sendBy.user_id', '=', 'financials_cash_transfer.ct_send_by')
            ->join('financials_users as receiveBy', 'receiveBy.user_id', '=', 'financials_cash_transfer.ct_receive_by')
        ->where('ct_clg_id',$user->user_clg_id);
////                ->where('emp_role_id', config('global_variables.teller_account_id'))
///
///
        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->orWhere('ct_remarks', 'like', '%' . $search . '%')
                    ->orWhere('ct_send_datetime', 'like', '%' . $search . '%')
                    ->orWhere('ct_amount', 'like', '%' . $search . '%')
                    ->orWhere('sendBy.user_name', 'like', '%' . $search . '%')
                    ->orWhere('sendBy.user_designation', 'like', '%' . $search . '%')
                    ->orWhere('sendBy.user_name', 'like', '%' . $search . '%')
                    ->orWhere('sendBy.user_username', 'like', '%' . $search . '%')
                    ->orWhere('receiveBy.user_name', 'like', '%' . $search . '%')
                    ->orWhere('receiveBy.user_designation', 'like', '%' . $search . '%')
                    ->orWhere('receiveBy.user_name', 'like', '%' . $search . '%')
                    ->orWhere('receiveBy.user_username', 'like', '%' . $search . '%');
            });
        }

        if (!empty($search_by_user)) {
            $query->where('ct_send_by', $search_by_user);
        }


        $datas = $query->where('ct_status', 'PENDING')
            ->select('financials_cash_transfer.*', 'sendBy.user_name as SndByUsrName', 'sendBy.user_id as SndById', 'receiveBy.user_name as RcdByUsrName', 'receiveBy.user_id as RcdById')
            ->where('ct_send_by', $user->user_id)
            ->orderBy('ct_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);


        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = stream_context_create([
                'ssl'=>[
                    'verify_peer'=>FALSE,
                    'verify_peer_name'=>FALSE,
                    'allow_self_signed'=>TRUE,
                ]
            ]);
            $optionss =[
                'footer-html' => $footer,
                'header-html' => $header,
            ];
            $pdf = PDF::setOptions(['isHTML5ParserEnabled'=>true, 'isRemoteEnabled'=>true]);
            $pdf->getDomPDF()->setHttpContext($options,$optionss);
            $pdf->loadView($prnt_page_dir, compact('datas', 'type', 'pge_title'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }

        } else {
            return view('pending_cash_transfer_list', compact('datas', 'route', 'title', 'search_by_user', 'search'));
        }

    }
    // update code by shahzaib end


    // update code by shahzaib start
    public function approve_cash_transfer_list(Request $request, $array = null, $str = null)
    {
        $route = "approve_cash_transfer_list";
        $title = 'Approve Cash Transfer List';
        $user = Auth::user();


        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.pending_cash_transfer_list.pending_cash_transfer_list';
        $pge_title = 'Approve Cash Transfer List';
        $srch_fltr = [];
        array_push($srch_fltr, $search);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $query = DB::table('financials_cash_transfer')
//            ->join('financials_users', 'financials_users.user_id', '=', 'financials_cash_transfer.ct_receive_by');
            ->join('financials_users as sendBy', 'sendBy.user_id', '=', 'financials_cash_transfer.ct_send_by')
            ->join('financials_users as receiveBy', 'receiveBy.user_id', '=', 'financials_cash_transfer.ct_receive_by')
            ->where('ct_clg_id',$user->user_clg_id);
////                ->where('emp_role_id', config('global_variables.teller_account_id'))


        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->orWhere('ct_remarks', 'like', '%' . $search . '%')
                    ->orWhere('ct_send_datetime', 'like', '%' . $search . '%')
                    ->orWhere('ct_amount', 'like', '%' . $search . '%')
                    ->orWhere('sendBy.user_name', 'like', '%' . $search . '%')
                    ->orWhere('sendBy.user_designation', 'like', '%' . $search . '%')
                    ->orWhere('sendBy.user_name', 'like', '%' . $search . '%')
                    ->orWhere('sendBy.user_username', 'like', '%' . $search . '%')
                    ->orWhere('receiveBy.user_name', 'like', '%' . $search . '%')
                    ->orWhere('receiveBy.user_designation', 'like', '%' . $search . '%')
                    ->orWhere('receiveBy.user_name', 'like', '%' . $search . '%')
                    ->orWhere('receiveBy.user_username', 'like', '%' . $search . '%');
            });
        }

        if (!empty($search_by_user)) {
            $query->where('ct_send_by', $search_by_user);
        }

        $datas = $query->where('ct_status', 'RECEIVED')
            ->select('financials_cash_transfer.*', 'sendBy.user_name as SndByUsrName', 'sendBy.user_id as SndById', 'receiveBy.user_name as RcdByUsrName', 'receiveBy.user_id as RcdById')
            ->where('ct_send_by', $user->user_id)
            ->orderBy('ct_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);


        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = stream_context_create([
                'ssl'=>[
                    'verify_peer'=>FALSE,
                    'verify_peer_name'=>FALSE,
                    'allow_self_signed'=>TRUE,
                ]
            ]);
            $optionss =[
                'footer-html' => $footer,
                'header-html' => $header,
            ];
            $pdf = PDF::setOptions(['isHTML5ParserEnabled'=>true, 'isRemoteEnabled'=>true]);
            $pdf->getDomPDF()->setHttpContext($options,$optionss);
            $pdf->loadView($prnt_page_dir, compact('datas', 'type', 'pge_title'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }

        } else {
            return view('pending_cash_transfer_list', compact('datas', 'route', 'title', 'search_by_user', 'search'));
        }


    }
    // update code by shahzaib end


    // update code by shahzaib start
    public function reject_cash_transfer_list(Request $request, $array = null, $str = null)
    {
        $route = "reject_cash_transfer_list";
        $title = 'Reject Cash Transfer List';

        $user = Auth::user();


        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.reject_cash_transfer_list.reject_cash_transfer_list';
        $pge_title = 'Reject Cash Transfer List';
        $srch_fltr = [];
        array_push($srch_fltr, $search);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $query = DB::table('financials_cash_transfer')
            ->join('financials_users as sendBy', 'sendBy.user_id', '=', 'financials_cash_transfer.ct_send_by')
            ->join('financials_users as receiveBy', 'receiveBy.user_id', '=', 'financials_cash_transfer.ct_receive_by')
            ->where('ct_clg_id',$user->user_clg_id);
//            ->join('financials_users', 'financials_users.user_id', '=', 'financials_cash_transfer.ct_receive_by');
////                ->where('emp_role_id', config('global_variables.teller_account_id'))

        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->orWhere('ct_remarks', 'like', '%' . $search . '%')
                    ->orWhere('ct_send_datetime', 'like', '%' . $search . '%')
                    ->orWhere('ct_amount', 'like', '%' . $search . '%')
                    ->orWhere('sendBy.user_name', 'like', '%' . $search . '%')
                    ->orWhere('sendBy.user_designation', 'like', '%' . $search . '%')
                    ->orWhere('sendBy.user_name', 'like', '%' . $search . '%')
                    ->orWhere('sendBy.user_username', 'like', '%' . $search . '%')
                    ->orWhere('receiveBy.user_name', 'like', '%' . $search . '%')
                    ->orWhere('receiveBy.user_designation', 'like', '%' . $search . '%')
                    ->orWhere('receiveBy.user_name', 'like', '%' . $search . '%')
                    ->orWhere('receiveBy.user_username', 'like', '%' . $search . '%');
            });
        }

        if (!empty($search_by_user)) {
            $query->where('ct_send_by', $search_by_user);
        }

        $datas = $query->where('ct_status', 'REJECTED')
            ->select('financials_cash_transfer.*', 'sendBy.user_name as SndByUsrName', 'sendBy.user_id as SndById', 'receiveBy.user_name as RcdByUsrName', 'receiveBy.user_id as RcdById')
            ->where('ct_send_by', $user->user_id)
            ->orderBy('ct_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);


        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = stream_context_create([
                'ssl'=>[
                    'verify_peer'=>FALSE,
                    'verify_peer_name'=>FALSE,
                    'allow_self_signed'=>TRUE,
                ]
            ]);
            $optionss =[
                'footer-html' => $footer,
                'header-html' => $header,
            ];
            $pdf = PDF::setOptions(['isHTML5ParserEnabled'=>true, 'isRemoteEnabled'=>true]);
            $pdf->getDomPDF()->setHttpContext($options,$optionss);
            $pdf->loadView($prnt_page_dir, compact('datas', 'type', 'pge_title'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }

        } else {
            return view('pending_cash_transfer_list', compact('datas', 'route', 'title', 'search_by_user', 'search'));
        }
    }
    // update code by shahzaib end


}
