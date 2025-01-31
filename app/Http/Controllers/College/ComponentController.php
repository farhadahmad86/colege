<?php

namespace App\Http\Controllers\College;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DayEndController;
use App\Models\AccountRegisterationModel;
use App\Models\College\ComponentModel;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class ComponentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $array = null, $str = null)
    {

        $user = Auth::user();
        $accounts = AccountRegisterationModel::where('account_clg_id', $user->user_clg_id)->get();
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_cr_account = (!isset($request->cr_account) && empty($request->cr_account)) ? ((!empty($ar) && isset($ar[2])) ? $ar[2]->{'value'} : '') : $request->cr_account;
        $search_dr_account = (!isset($request->dr_account) && empty($request->dr_account)) ? ((!empty($ar) && isset($ar[2])) ? $ar[2]->{'value'} : '') : $request->dr_account;

        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.college.information_pdf.component_list';
        $pge_title = 'Components List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_cr_account, $search_dr_account);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $query = ComponentModel::where('sfc_clg_id', $user->user_clg_id)
            ->leftJoin('financials_accounts as dr_account', 'dr_account.account_uid', '=', 'student_fee_components.sfc_dr_account')
            ->leftJoin('financials_accounts as cr_account', 'cr_account.account_uid', '=', 'student_fee_components.sfc_cr_account')
            ->where('dr_account.account_clg_id', $user->user_clg_id)
            ->where('cr_account.account_clg_id', $user->user_clg_id)
            ->leftJoin('financials_users as users', 'users.user_id', '=', 'student_fee_components.sfc_created_by')
            ->leftJoin('branches', 'branches.branch_id', '=', 'student_fee_components.sfc_branch_id');

        if (!empty($search)) {
            $query->where('sfc_name', 'like', '%' . $search . '%')
                ->orWhere('sfc_id', 'like', '%' . $search . '%')
                ->orWhere('sfc_amount', 'like', '%' . $search . '%');
        }

        if (!empty($search_cr_account)) {

            $query->where('sfc_cr_account', $search_cr_account);
        }
        if (!empty($search_dr_account)) {

            $query->where('sfc_dr_account', $search_dr_account);
        }
        if (!empty($search_by_user)) {

            $query->where('sfc_created_by', $search_by_user);
        }

        $datas = $query->select('student_fee_components.*', 'cr_account.account_name as cr_acc_name', 'cr_account.account_uid as cr_acc_id', 'dr_account.account_name as dr_acc_name', 'dr_account.account_uid as dr_acc_id', 'users.user_name', 'users.user_id', 'branches.branch_name')
            ->orderBy('sfc_id', 'DESC')
            ->paginate($pagination_number);
        // ->get();

        $component_title = ComponentModel::where('sfc_clg_id', $user->user_clg_id)->orderBy('sfc_id', config('global_variables.query_sorting'))->pluck('sfc_name')->all(); //where('group_delete_status', '!=', 1)->


        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = stream_context_create([
                'ssl' => [
                    'verify_peer' => FALSE,
                    'verify_peer_name' => FALSE,
                    'allow_self_signed' => TRUE,
                ]
            ]);
            $optionss = [
                'footer-html' => $footer,
                'header-html' => $header,
                'margin-top' => 24,
            ];
            $pdf = PDF::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);
            $pdf->getDomPDF()->setHttpContext($options, $optionss);
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
            return view('collegeViews.fee_component.component_list', compact('datas', 'accounts', 'search', 'search_cr_account', 'search_dr_account', 'component_title', 'search_by_user'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $dr_accounts = AccountRegisterationModel::where('account_clg_id', $user->user_clg_id)->where('account_uid', 'Like', '11020%')->get();
        $cr_accounts = AccountRegisterationModel::where('account_clg_id', $user->user_clg_id)->where('account_uid', 'Like', '31011%')->get();

        return view('collegeViews.fee_component.create_component', compact('dr_accounts', 'cr_accounts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        DB::transaction(function () use ($request, $user, $day_end) {
            $this->validate($request, [
                'component_name' => ['required', 'string', 'unique:student_fee_components,sfc_name,null,null,sfc_clg_id,' . $user->user_clg_id],
                'amount' => ['required'],
                'cr_account' => ['required'],
                'dr_account' => ['required'],
            ]);

            $component = new ComponentModel();

            $component = $this->AssignComponentValue($component, $request, $day_end);

            $component->save();
        });

        return redirect()->back()->with('success', 'Successfully Saved');
    }


    function AssignComponentValue($component, $request, $day_end)
    {
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

        $user = Auth::user();
        $component->sfc_name = $request->component_name;
        $component->sfc_amount = $request->amount;
        $component->sfc_dr_account = $request->dr_account;
        $component->sfc_cr_account = $request->cr_account;
        $component->sfc_created_by = $user->user_id;
        $component->sfc_clg_id = $user->user_clg_id;
        $component->sfc_branch_id = Session::get('branch_id');
        $component->sfc_ip_adrs = $ip_rslt;
        $component->sfc_brwsr_info = $brwsr_rslt;
        $component->sfc_datetime = Carbon::now()->toDateTimeString();
        $component->sfc_day_end_id = $day_end->de_id;
        $component->sfc_day_end_date = $day_end->de_datetime;
        $component->sfc_year_id = $this->getYearEndId();

        return $component;
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $user = Auth::user();
        $dr_accounts = AccountRegisterationModel::where('account_clg_id', $user->user_clg_id)->where('account_uid', 'Like', '11020%')->get();
        $cr_accounts = AccountRegisterationModel::where('account_clg_id', $user->user_clg_id)->where('account_uid', 'Like', '31011%')->get();
        return view('collegeViews.fee_component.edit_component', compact('request', 'dr_accounts', 'cr_accounts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // dd($request->all());
        $user = Auth::user();
        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        DB::transaction(function () use ($request, $user, $day_end) {
            $this->validate($request, [
                // 'component_name' => ['required', 'string', 'unique:student_fee_components,sfc_name,null,null,sfc_clg_id,' . $user->user_clg_id],
                'amount' => ['required'],
                'cr_account' => ['required'],
                'dr_account' => ['required'],
            ]);

            $component = ComponentModel::where('sfc_id', $request->sfc_id)->first();

            $component = $this->AssignComponentValue($component, $request, $day_end);

            $component->save();
        });

        return redirect()->back()->with('success', 'Successfully Saved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
