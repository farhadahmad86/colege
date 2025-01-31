<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Models\GenreModel;
use App\Models\LanguageModel;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Maatwebsite\Excel\Facades\Excel;

class GenreController extends Controller
{
    public function add_genre()
    {
//        $this->enter_log('add_region');
        return view('add_genre');
    }

    public function submit_genre(Request $request)
    {
        $this->genre_validation($request);

        $genre = new GenreModel();

        $genre = $this->AssignGenreValues($request, $genre);

        $genre->save();

        $user = Auth::User();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Genre With Id: ' . $genre->gen_id . ' And Name: ' . $genre->gen_title);

        // WizardController::updateWizardInfo(['region'], ['area']);

        return redirect('add_genre')->with('success', 'Successfully Saved');
    }

    public function genre_validation($request)
    {
        return $this->validate($request, [
            'name' => ['required', 'string', 'unique:financials_genre,gen_title'],
            'remarks' => ['nullable', 'string'],
        ]);

    }

    protected function AssignGenreValues($request, $genre)
    {
        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $genre->gen_title = ucwords($request->name);
        $genre->gen_remarks = ucfirst($request->remarks);
        $genre->gen_createdby = $user->user_id;
        $genre->gen_day_end_id = $day_end->de_id;
        $genre->gen_day_end_date = $day_end->de_datetime;

        // coding from shahzaib start

        $tbl_var_name = 'genre';
        $prfx = 'gen';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now();
        // coding from shahzaib end

        return $genre;
    }


    public function genre_list(Request $request, $array = null, $str = null)
    {
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.genre_list.genre_list';
        $pge_title = 'Class List';
        $srch_fltr = [];
        array_push($srch_fltr, $search);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $query = DB::table('financials_genre')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_genre.gen_createdby');

        if (!empty($search)) {
            $query->where('gen_title', 'like', '%' . $search . '%')
                ->orWhere('gen_remarks', 'like', '%' . $search . '%')
                ->orWhere('gen_id', 'like', '%' . $search . '%')
                ->orWhere('user_designation', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%')
                ->orWhere('user_username', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {
//            $pagination_number = 100000000;
            $query->where('gen_createdby', $search_by_user);
        }

        $restore_list = $request->restore_list;
        if ($restore_list == 1)
        {
            $query->where('gen_delete_status', '=', 1);
        } else {
            $query->where('gen_delete_status', '!=', 1);
        }

        $datas = $query->orderBy('gen_id', 'DESC')
            ->paginate($pagination_number);

        $gen_title = GenreModel::orderBy('gen_id', config('global_variables.query_sorting'))->pluck('gen_title')->all();//where('gen_delete_status', '!=', 1)->


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
            return view('genre_list', compact('datas', 'search', 'gen_title', 'search_by_user', 'restore_list'));
        }

    }

//    // update code by shahzaib end
//
//
    public function edit_genre(Request $request)
    {
        return view('edit_genre', compact('request'));
    }

    public function update_genre(Request $request)
    {
        $this->validate($request, [
            'gen_id' => ['required', 'numeric'],
            'name' => ['required', 'string', 'unique:financials_genre,gen_title,' . $request->gen_id . ',gen_id'],
            'remarks' => ['nullable', 'string'],
        ]);

        $genre = GenreModel::where('gen_id', $request->gen_id)->first();
        $genre = $this->AssignGenreValues($request, $genre);

        if ($genre->save()) {
            $user = Auth::User();

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Genre With Id: ' . $genre->gen_id . ' And Name: ' . $genre->gen_title);
            return redirect('genre_list')->with('success', 'Successfully Saved');
        } else {
            return redirect('genre_list')->with('fail', 'Failed Try Again!');
        }
    }

    public function delete_genre (Request $request)
    {

        $user = Auth::User();

        $delete = GenreModel::where('gen_id', $request->gen_id)->first();

        if ($delete->gen_delete_status == 1) {
            $delete->gen_delete_status = 0;
        } else {
            $delete->gen_delete_status = 1;
        }

        $delete->gen_deleted_by = $user->user_id;

        if ($delete->save()) {

            if ($delete->gen_delete_status == 0) {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Restore Genre With Id: ' . $delete->gen_id . ' And Name: ' . $delete->gen_title);

//                return redirect('region_list')->with('success', 'Successfully Restored');
                return redirect()->back()->with('success', 'Successfully Restored');
            } else {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Delete Genre With Id: ' . $delete->gen_id . ' And Name: ' . $delete->gen_title);

//                return redirect('region_list')->with('success', 'Successfully Deleted');
                return redirect()->back()->with('success', 'Successfully Deleted');
            }

        } else {
//            return redirect('region_list')->with('fail', 'Failed Try Again!');
            return redirect()->back()->with('fail', 'Failed Try Again!');
        }
    }
}
