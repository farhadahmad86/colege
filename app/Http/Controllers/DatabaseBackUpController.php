<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Models\DatabaseBackUpModel;
//use Artisan;
use App\User;
use Auth;
use Illuminate\Support\Facades\Config;
use PDF;
use Carbon\Carbon;
use Cornford\Backup\Facades\Backup;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Kreait\Firebase\Factory;
use Maatwebsite\Excel\Facades\Excel;
use Storage;

class DatabaseBackUpController extends Controller
{
    public function db_backup()
    {
        return view('db_backup');
    }

    public function submit_db_backup()
    {
        $file_name = 'backup-file-' . Carbon::now()->toDateTimeString() . '.sql';

        $file_name = preg_replace('/\s+/', '-', $file_name);

        // to send our own file name
//        Artisan::call('db:backup',['filename'=>'absefghijk']);

//        try {
//            Artisan::call('db:backup',['filename'=>$file_name]);
//            Artisan::call('backup:mysql-dump');


            Artisan::call('backup:run', ['filename' => 'storage/dumps/' . $file_name]);


            $firebase_path = $this->store_at_firebase($file_name, 'images/');

            $user = Auth::User();

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Database Backup');

            return redirect()->back()->with('success', 'Backup is created Successfully');
//        } catch (\Exception $e) {
//            return redirect()->back()->with('fail', 'Something went wrong while creating Backup');
//        }

    }


    // update code by shahzaib start
    public function db_backup_list(Request $request, $array = null, $str = null)
    {

        $ar = json_decode($request->array);
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->from;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.db_backup_list.db_backup_list';
        $pge_title = 'Database BackUp List';
        $srch_fltr = [];
        array_push($srch_fltr, $search_to, $search_from);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));



        $query = DB::table('financials_database_backup')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_database_backup.dbb_created_by');


        if ((!empty($search_to)) && (!empty($search_from))) {
            $query->whereBetween('dbb_created_at', [$start, $end]);
        }

        elseif (!empty($search_to)) {
            $query->where('dbb_created_at', $start);
        }

        elseif (!empty($search_from)) {
            $query->where('dbb_created_at', $end);
        }




        $datas = $query->orderBy('dbb_created_at', 'DESC')->paginate($pagination_number);


        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title','srch_fltr'))->render();
            $options = [
                'footer-html' => $footer,
                'header-html' => $header,
            ];

            $pdf = PDF::loadView($prnt_page_dir, compact('datas', 'type', 'pge_title'));
            $pdf->setOptions($options);


            if( $type === 'pdf') {
                return $pdf->stream($pge_title.'_x.pdf');
            }
            else if( $type === 'download_pdf') {
                return $pdf->download($pge_title.'_x.pdf');
            }
            else if( $type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title.'_x.xlsx');
            }

        }
        else {
            return view('db_backup_list', compact('datas', 'search_from', 'search_to'));
        }

    }
    // update code by shahzaib end


    public function restore_db_backup(Request $request)
    {
//        Artisan::call("db:restore", ["dump" => $request->sql_file]);

//        Artisan::call('db:backup', array($request->sql_file));

//        dd('db:restore', array($request->sql_file));

        try {
//            Artisan::call("db:restore", ["dump" => '20191014172841.sql']);
            Artisan::call("db:restore", ["dump" => $request->sql_file]);

            return redirect()->back()->with('success', 'Backup is restore Successfully');
        } catch (\Exception $e) {

            return redirect()->back()->with('fail', 'Something went wrong while restoring Backup');
        }
    }


    public function auto_submit_db_backup()
    {
//        try {
            $file_name = 'backup-file-' . Carbon::now()->toDateTimeString() . '.sql';

//            $file_name = preg_replace('/\s+/', '-', $file_name);
//            $new = Config::set('database.connections.mysql.database', $database_name);
        $abc = Artisan::call('backup:run', ['filename' => 'storage/dumps/' . $file_name]);
//            $abc = Artisan::call('db:backup', ['filename' => 'storage/dumps/' . $file_name]);
dd($abc);
            $firebase_path = $this->store_at_firebase($file_name, 'images/');

//            Artisan::call('db:backup');
            return response()->json('ok');
//        } catch (\Exception $e) {
//            return response()->json('no');
//        }

    }



    public function download_db_file(Request $request)
    {
        return response()->download(storage_path("dumps/{$request->file_name}"));
    }


    public function store_at_firebase($file_name, $path)
    {
        $storage = (new Factory())->createStorage();
//        $storageClient = $storage->getStorageClient();
        $bucket = $storage->getBucket();

//            $file = storage_path("dumps/{$file_name}")->get();
        $file = File::get(storage_path('dumps/' . $file_name));

        $result = $bucket->upload($file, ['name' => $path . $file_name]);

        $time = Carbon::now()->addYear(140101);
        $url = $result->signedUrl($time);

        return $url;
    }
}
