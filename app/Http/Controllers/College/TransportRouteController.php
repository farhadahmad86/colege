<?php

namespace App\Http\Controllers\College;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Controller;
use App\Models\College\TransportRouteModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use DB;
use PDF;

class TransportRouteController extends Controller
{
    public function add_route()
    {
        return view('collegeViews.Transport.transport');
    }

    public function submit_route(Request $request)
    {
        $user = Auth::user();
        DB::transaction(function () use ($request, $user) {
            $brwsr_rslt = $this->getBrwsrInfo();
            $clientIP = $this->getIp();

            $validate = $request->validate([
                'route_title' => ['required', 'string'],
                'route_name' => ['required', 'string'],
                'single_route_amount' => ['required', 'integer'],
                'double_route_amount' => ['required', 'integer'],
            ]);

            $routes = new TransportRouteModel();
            $routes->tr_title = $request->route_title;
            $routes->tr_name = $request->route_name;
            $routes->tr_branch_id = Session::get('branch_id');
            $routes->tr_clg_id = $user->user_clg_id;
            $routes->tr_single_route_amount = $request->single_route_amount;
            $routes->tr_double_route_amount = $request->double_route_amount;
            $routes->tr_vendor_charge = $request->vendor_charge;
            $routes->tr_created_by = $user->user_id;
            $routes->tr_remarks = $request->remarks;
            $routes->tr_year_id = $this->getYearEndId();
            $routes->tr_created_at = Carbon::now();
            $routes->save();
        });
        return redirect()->back()->with('success', 'Save Successfully!');

    }

    public function route_list(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->year;
        $prnt_page_dir = 'print/college/Transport/prnt_transport_list';
        $pge_title = 'Bus Route List';
        $srch_fltr = [];
        array_push($srch_fltr, $search,$search_year);
        $pagination_number = (empty($ar)) ? 100000000 : 100000000;
        // $query = Classes::with('users')->where('class_clg_id', $user->user_clg_id)->toSql();
        $query = DB::table('transport')
            ->where('tr_branch_id', Session::get('branch_id'))
            ->leftJoin('branches', 'branches.branch_id', '=', 'transport.tr_branch_id')
            ->leftJoin('financials_users', 'financials_users.user_id', '=', 'transport.tr_created_by');
        if (!empty($search)) {
            $query->where('tr_name', 'like', '%' . $search . '%')
                ->orWhere('tr_id', 'like', '%' . $search . '%')
                ->orWhere('tr_title', 'like', '%' . $search . '%')
                ->orWhere('tr_single_route_amount', 'like', '%' . $search . '%')
                ->orWhere('tr_vendor_charge', 'like', '%' . $search . '%')
                ->orWhere('tr_remarks', 'like', '%' . $search . '%')
                ->orWhere('tr_double_route_amount', 'like', '%' . $search . '%');
        }

        if (!empty($search_year)) {
            $query->where('tr_year_id', '=', $search_year);
        } else {
            $search_year = $this->getYearEndId();
            $query->where('tr_year_id', '=', $search_year);
        }

        $datas = $query->select('transport.*', 'financials_users.user_name', 'branches.branch_name')->orderBy('tr_id', 'DESC')
            ->paginate($pagination_number);
        //where('class_delete_status', '!=', 1)->
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
            return view('collegeViews.Transport.tranport_list', compact('datas','search_year','search', 'user'));
        }
    }

    public function edit_route(Request $request)
    {

        $user = Auth::user();
        $route = TransportRouteModel::where('tr_id', $request->tr_id)->first();

        return view('collegeViews/Transport/edit_transport', compact('request', 'route'));
    }

    public function update_route(Request $request)
    {

        $user = Auth::user();
        $route = TransportRouteModel::where('tr_id', $request->tr_id)->first();
        $route->tr_title = $request->route_title;
        $route->tr_name = $request->route_name;
        $route->tr_branch_id = Session::get('branch_id');
        $route->tr_clg_id = $user->user_clg_id;
        $route->tr_single_route_amount = $request->single_route_amount;
        $route->tr_double_route_amount = $request->double_route_amount;
        $route->tr_vendor_charge = $request->vendor_charge;
        $route->tr_created_by = $user->user_id;
        $route->tr_remarks = $request->remarks;
        $route->save();
        return redirect()->route('route_list')->with('success', 'Updated Successfully');
    }

}
