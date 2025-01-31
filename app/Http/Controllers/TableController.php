<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Models\RegionModel;
use App\Models\TableModel;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class TableController extends Controller
{

    public function add_table(Request $request)
    {
        return view('add_table');
    }

    public function submit_table(Request $request)
    {
        $this->table_validation($request);

        $table = new TableModel();

        $table = $this->AssignTableValues($request, $table);

        $table->save();

        $user = Auth::User();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' save Table With Id: ' . $table->tb_id . ' And Name: ' . $table->tb_title);

        return redirect('add_table')->with('success', 'Successfully Saved');
    }

    public function table_validation($request)
    {
        return $this->validate($request, [
            'table_name' => ['required', 'string', 'unique:financials_table,tb_title'],
            'remarks' => ['nullable', 'string'],
        ]);

    }

    protected function AssignTableValues($request, $table)
    {
        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

        $table->tb_title = ucwords($request->table_name);
        $table->tb_remarks = ucfirst($request->remarks);
        $table->tb_createdby = $user->user_id;
        $table->tb_day_end_id = $day_end->de_id;
        $table->tb_day_end_date = $day_end->de_datetime;
        $table->tb_brwsr_info = $brwsr_rslt;
        $table->tb_ip_adrs = $ip_rslt;
        $table->tb_update_datetime = Carbon::now();

        return $table;
    }

    public function table_list(Request $request)
    {

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.table_list.table_list';
        $pge_title = 'Table List';
        $srch_fltr = [];
        array_push($srch_fltr, $search);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $query = DB::table('financials_table')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_table.tb_createdby');

        if (!empty($search)) {
            $query->where('tb_title', 'like', '%' . $search . '%')
                ->orWhere('tb_remarks', 'like', '%' . $search . '%')
                ->orWhere('tb_id', 'like', '%' . $search . '%')
                ->orWhere('user_designation', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%')
                ->orWhere('user_username', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {
//            $pagination_number = 100000000;
            $query->where('tb_createdby', $search_by_user);
        }

        $restore_list = $request->restore_list;
        if ($restore_list == 1) {
            $query->where('tb_delete_status', '=', 1);
        } else {
            $query->where('tb_delete_status', '!=', 1);
        }

        $datas = $query->orderBy('tb_id', 'DESC')
            ->paginate($pagination_number);

        $tb_title = TableModel::orderBy('tb_id', config('global_variables.query_sorting'))->pluck('tb_title')->all();//where('tb_delete_status', '!=', 1)->


        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = [
                'footer-html' => $footer,
                'header-html' => $header,
            ];

            $pdf = PDF::loadView($prnt_page_dir, compact('datas', 'type', 'pge_title'));
            $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }

        } else {
            return view('table_list', compact('datas', 'search', 'tb_title', 'search_by_user', 'restore_list'));
        }
    }

    public function edit_table(Request $request)
    {
        return view('edit_table', compact('request'));
    }

    public function update_table(Request $request)
    {
        $this->validate($request, [
            'table_id' => ['required', 'numeric'],
            'table_name' => ['required', 'string', 'unique:financials_table,tb_title,' . $request->table_id . ',tb_id'],
            'remarks' => ['nullable', 'string'],
        ]);

        $table = TableModel::where('tb_id', $request->table_id)->first();

        $table = $this->AssignTableValues($request, $table);

        if ($table->save()) {

            $user = Auth::User();

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Table With Id: ' . $table->tb_id . ' And Name: ' . $table->tb_title);
            return redirect('table_list')->with('success', 'Successfully Saved');
        } else {
            return redirect('table_list')->with('fail', 'Failed Try Again!');
        }
    }

    public function delete_table(Request $request)
    {
        $user = Auth::User();

        $delete = TableModel::where('tb_id', $request->tb_id)->first();

        if ($delete->tb_delete_status == 1) {
            $delete->tb_delete_status = 0;
        } else {
            $delete->tb_delete_status = 1;
        }

        $delete->tb_deleted_by = $user->user_id;

        if ($delete->save()) {

            if ($delete->tb_delete_status == 0) {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Restore Table With Id: ' . $delete->tb_id . ' And Name: ' . $delete->tb_title);

//                return redirect('table_list')->with('success', 'Successfully Restored');
                return redirect()->back()->with('success', 'Successfully Restored');
            } else {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Delete Table With Id: ' . $delete->tb_id . ' And Name: ' . $delete->tb_title);

//                return redirect('table_list')->with('success', 'Successfully Deleted');
                return redirect()->back()->with('success', 'Successfully Deleted');
            }

        } else {
//            return redirect('table_list')->with('fail', 'Failed Try Again!');
            return redirect()->back()->with('fail', 'Failed Try Again!');
        }
    }

}
