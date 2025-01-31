<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Models\AuthorModel;
use App\Models\PublisherModel;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Maatwebsite\Excel\Facades\Excel;

class AuthorController extends Controller
{
    public function add_author()
    {
        return view('add_author');
    }

    public function submit_author(Request $request)
    {
        $this->author_validation($request);

        $author = new AuthorModel();

        $author = $this->AssignAuthorValues($request, $author);

        $author->save();

        $user = Auth::User();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Author With Id: ' . $author->aut_id . ' And Name: ' . $author->aut_title);

        // WizardController::updateWizardInfo(['region'], ['area']);

        return redirect('add_author')->with('success', 'Successfully Saved');
    }

    public function author_validation($request)
    {
        return $this->validate($request, [
            'name' => ['required', 'string', 'unique:financials_author,aut_title'],
            'remarks' => ['nullable', 'string'],
        ]);

    }

    protected function AssignAuthorValues($request, $author)
    {
        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $author->aut_title = ucwords($request->name);
        $author->aut_remarks = ucfirst($request->remarks);
        $author->aut_createdby = $user->user_id;
        $author->aut_day_end_id = $day_end->de_id;
        $author->aut_day_end_date = $day_end->de_datetime;

        // coding from shahzaib start

        $tbl_var_name = 'author';
        $prfx = 'aut';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now();
        // coding from shahzaib end

        return $author;
    }


    public function author_list(Request $request, $array = null, $str = null)
    {
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.author_list.author_list';
        $pge_title = 'Author List';
        $srch_fltr = [];
        array_push($srch_fltr, $search);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $query = DB::table('financials_author')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_author.aut_createdby');

        if (!empty($search)) {
            $query->where('aut_title', 'like', '%' . $search . '%')
                ->orWhere('aut_remarks', 'like', '%' . $search . '%')
                ->orWhere('aut_id', 'like', '%' . $search . '%')
                ->orWhere('user_designation', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%')
                ->orWhere('user_username', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {
//            $pagination_number = 100000000;
            $query->where('aut_createdby', $search_by_user);
        }

        $restore_list = $request->restore_list;
        if ($restore_list == 1)
        {
            $query->where('aut_delete_status', '=', 1);
        } else {
            $query->where('aut_delete_status', '!=', 1);
        }

        $datas = $query->orderBy('aut_id', 'DESC')
            ->paginate($pagination_number);

        $aut_title = AuthorModel::orderBy('aut_id', config('global_variables.query_sorting'))->pluck('aut_title')->all();//where('aut_delete_status', '!=', 1)->


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
            return view('author_list', compact('datas', 'search', 'aut_title', 'search_by_user', 'restore_list'));
        }

    }

//    // update code by shahzaib end
//
//
    public function edit_author(Request $request)
    {
        return view('edit_author', compact('request'));
    }

    public function update_author(Request $request)
    {
        $this->validate($request, [
            'aut_id' => ['required', 'numeric'],
            'name' => ['required', 'string', 'unique:financials_author,aut_title,' . $request->aut_id . ',aut_id'],
            'remarks' => ['nullable', 'string'],
        ]);

        $author = AuthorModel::where('aut_id', $request->aut_id)->first();
        $author = $this->AssignAuthorValues($request, $author);

        if ($author->save()) {
            $user = Auth::User();

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Author With Id: ' . $author->aut_id . ' And Name: ' . $author->aut_title);
            return redirect('author_list')->with('success', 'Successfully Saved');
        } else {
            return redirect('author_list')->with('fail', 'Failed Try Again!');
        }
    }

    public function delete_author (Request $request)
    {

        $user = Auth::User();

        $delete = AuthorModel::where('aut_id', $request->aut_id)->first();

        if ($delete->aut_delete_status == 1) {
            $delete->aut_delete_status = 0;
        } else {
            $delete->aut_delete_status = 1;
        }

        $delete->aut_deleted_by = $user->user_id;

        if ($delete->save()) {

            if ($delete->aut_delete_status == 0) {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Restore Author With Id: ' . $delete->aut_id . ' And Name: ' . $delete->aut_title);

//                return redirect('region_list')->with('success', 'Successfully Restored');
                return redirect()->back()->with('success', 'Successfully Restored');
            } else {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Delete Author With Id: ' . $delete->aut_id . ' And Name: ' . $delete->aut_title);

//                return redirect('region_list')->with('success', 'Successfully Deleted');
                return redirect()->back()->with('success', 'Successfully Deleted');
            }

        } else {
//            return redirect('region_list')->with('fail', 'Failed Try Again!');
            return redirect()->back()->with('fail', 'Failed Try Again!');
        }
    }
}
