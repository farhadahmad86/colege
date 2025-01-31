<?php

namespace App\Http\Controllers\Database;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DayEndController;
use App\Models\AccountRegisterationModel;
use App\Models\DatabaseModal;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class DatabaseController extends Controller
{
    public function create()
    {
        $clients_id = DatabaseModal::pluck('db_client_id');
        $clients = AccountRegisterationModel::whereNotIn('account_uid', $clients_id)->where('account_parent_code', 11013)->select('account_uid', 'account_name')->get();
        return view('database/create', compact('clients'));
    }

    public function store(Request $request)
    {

        $this->db_validation($request);
        $database = new DatabaseModal();
        $database = $this->AssignDatabaseValues($request, $database);
        $database->save();
        return redirect()->back()->with('success', 'Successfully Saved!');
    }

    public function db_validation($request)
    {
        return $this->validate($request, [
            'client_id' => ['required', 'numeric'],
            'database_name' => ['required', 'string', 'unique:financials_database,db_name'],

        ]);
    }

    protected function AssignDatabaseValues($request, $database)
    {
        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $database->db_client_id = $request->client_id;
        $database->db_name = $request->database_name;
        $database->db_created_by = $user->user_id;
        $database->db_day_end_id = $day_end->de_id;
        $database->db_day_end_date = $day_end->de_datetime;

        // coding from shahzaib start
        $tbl_var_name = 'database';
        $prfx = 'db';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now()->toDateTimeString();
        // coding from shahzaib end


        return $database;
    }


    // update code by shahzaib start
    public function index(Request $request, $array = null, $str = null)
    {
//        $databases = DatabaseModal::leftJoin()->select('financials_accounts.account_name', 'financials_accounts.*')->get();
//        return view('database/list', compact('databases'));

        $clients = AccountRegisterationModel::where('account_parent_code', 11013)->select('account_uid', 'account_name')->orderby('account_name', 'ASC')->get();

//        $search = (isset($request->search) && $request->filter_search === "normal_search") ? $request->search : '';
//        $search_region = (isset($request->region) && $request->filter_search === "filter_search") ? $request->region : '';

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_client = (!isset($request->client) && empty($request->client)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->client;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';

        $prnt_page_dir = 'print.area_list.area_list';
        $pge_title = 'Database List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_client, $search_by_user);


        $pagination_number = (empty($ar) || !empty($ar)) ? 30 : 100000000;

        $query = DB::table('financials_database')
            ->join('financials_accounts', 'financials_accounts.account_uid', '=', 'financials_database.db_client_id')
            ->leftJoin('financials_users', 'financials_users.user_id', '=', 'financials_database.db_created_by');


        if (!empty($search)) {

            $pagination_number = 1000000;
            $query->orWhere('db_id', 'like', '%' . $search . '%')
                ->orWhere('db_title', 'like', '%' . $search . '%')
                ->orWhere('db_remarks', 'like', '%' . $search . '%')
                ->orWhere('account_name', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%');
        }

        if (!empty($search_client)) {
            $pagination_number = 1000000;
            $query->where('db_client_id', '=', $search_client);
        }

        if (!empty($search_by_user)) {
            $pagination_number = 1000000;
            $query->where('db_created_by', '=', $search_by_user);
        }

        $restore_list = $request->restore_list;
        if ($restore_list == 1) {
            $query->where('db_delete_status', '=', 1);
        } else {
            $query->where('db_delete_status', '!=', 1);
        }

        $datas = $query
//            ->where('area_delete_status', '!=', 1)
            ->orderBy('db_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);


        $database_title = DatabaseModal::
        where('db_delete_status', '!=', 1)->
        orderBy('db_name', 'ASC')->pluck('db_name')->all();


        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = [
                'footer-html' => $footer,
                'header-html' => $header,
            ];

            $pdf = PDF::loadView($prnt_page_dir, compact('datas', 'type', 'srch_fltr', 'pge_title'));
            $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }

        } else {
            return view('database/list', compact('datas', 'search', 'database_title', 'clients', 'search_client', 'restore_list'));
        }

    }

    // update code by shahzaib end


    public function edit(Request $request)
    {
        $clients = AccountRegisterationModel::where('account_parent_code', 11013)->select('account_uid', 'account_name')->get();

        return view('database.edit', compact('request', 'clients'));
    }

    public function update(Request $request)
    {

        $this->validate($request, [
            'client_name' => ['required', 'numeric'],
            'db_id' => ['required', 'numeric'],
            'database_name' => ['required', 'string', 'unique:financials_database,db_name,' . $request->db_id . ',db_id,db_client_id,' . $request->client_name],
        ]);

        $database = DatabaseModal::where('db_id', $request->db_id)->first();

        $database->db_client_id = $request->client_name;
        $database->db_name = $request->database_name;

        if ($database->save()) {

            $user = Auth::User();

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Area With Id: ' . $database->db_id . ' And Name: ' . $database->db_name);

            return redirect()->route('database.index')->with('success', 'Successfully Saved');
        } else {
            return redirect()->route('database.index')->with('fail', 'Failed Try Again!');
        }
    }

    public function delete(Request $request)
    {
        $user = Auth::User();
        $delete = DatabaseModal::where('db_id', $request->db_id)->first();


        if ($delete->db_delete_status == 1) {
            $delete->db_delete_status = 0;
        } else {
            $delete->db_delete_status = 1;
        }

        $delete->db_deleted_by = $user->user_id;

        if ($delete->save()) {

            if ($delete->db_delete_status == 0) {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Restore Area With Id: ' . $delete->db_id . ' And Name: ' . $delete->db_name);

//                return redirect('db_list')->with('success', 'Successfully Restored');
                return redirect()->back()->with('success', 'Successfully Restored');
            } else {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Delete Area With Id: ' . $delete->db_id . ' And Name: ' . $delete->db_name);

//                return redirect('area_list')->with('success', 'Successfully Deleted');
                return redirect()->back()->with('success', 'Successfully Deleted');
            }

//            return redirect('area_list')->with('success', 'Successfully Saved');
            return redirect()->back()->with('success', 'Successfully Saved');
        } else {
//            return redirect('area_list')->with('fail', 'Failed Try Again!');
            return redirect()->back()->with('fail', 'Failed Try Again!');
        }

    }
}
