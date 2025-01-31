<?php

namespace App\Http\Controllers\College;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Controller;
use App\Models\College\AnnouncementModel;
use App\Models\College\Classes;
use App\Models\College\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class AnnouncementController extends Controller
{

    public function create()
    {
        $user = Auth::user();
        $classes = Classes::where('class_clg_id', $user->user_clg_id)->get();
        return view('collegeViews/announcement/announcement', compact('classes'));
    }

    public function store_announcement(Request $request)

    {
        $server_key =env('FIREBASE_SERVER_KEY');
        $title = $request->announcement_title;
        $description = $request->announcement_description;
        $branch_id = Session::get('branch_id');
        $class_id = $request->class_id;
        $user = Auth::user();
        $ann = new AnnouncementModel();
        $ann->an_clg_id = $user->user_clg_id;
        $ann->an_branch_id = $branch_id;
        $ann->an_title = $title;
        $ann->an_description = $description;
        $ann->an_class_id = $class_id;
//        $ann->an_section_id = $request->section_id;
        $ann->an_created_by = $user->user_id;
        $ann->an_browser_info = $this->getBrwsrInfo();
        $ann->an_ip_address = $this->getIp();
        $ann->an_created_at = Carbon::now();
        $ann->an_year_id = $this->getYearEndId();
        $ann->save();
        $students = Student::where('device_id', '!=', null)->where('branch_id', $branch_id)->where('class_id', $class_id)->pluck('device_id');
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://fcm.googleapis.com/fcm/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
    "registration_ids":' . json_encode($students) . ',
    "notification":{
"body":"' . $description . '",
"title":"' . $title . '",
"name":"Announcement",
"da":"this is console data",
"clickUrl":"https://google.com"
    }

}',
            CURLOPT_HTTPHEADER => array(
                'Authorization: key='.$server_key.'',
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);

        return redirect()->back()->with('success', 'Saved Successfully');
    }

    public function announcement_list(Request $request)
    {
        $user = Auth::user();
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->year;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.college.information_pdf.class_list';
        $pge_title = 'Announcement List';
        $srch_fltr = [];
        array_push($srch_fltr, $search,$search_year);

        $pagination_number = (empty($ar)) ? 30 : 100000000;
        // $query = Classes::with('users')->where('class_clg_id', $user->user_clg_id)->toSql();
        $query = DB::table('announcement')
            ->where('an_clg_id', $user->user_clg_id)
            ->where('an_branch_id', Session::get('branch_id'))
            ->leftJoin('classes', 'classes.class_id', '=', 'announcement.an_class_id')
            ->leftJoin('financials_users as user', 'user.user_id', '=', 'announcement.an_created_by')
            ->leftJoin('branches', 'branches.branch_id', '=', 'announcement.an_branch_id');
        if (!empty($search)) {
            $query->where('an_title', 'like', '%' . $search . '%');
        }
        if (!empty($search_year)) {
            $query->where('an_year_id', '=', $search_year);
        } else {
            $search_year = $this->getYearEndId();
            $query->where('an_year_id', '=', $search_year);
        }
        $datas = $query->select('announcement.*', 'classes.class_id', 'classes.class_name', 'user.user_id', 'user.user_name', 'branches.branch_name')->orderBy('an_id', 'ASC')
            ->paginate($pagination_number);
        $announcement_title = AnnouncementModel::where('an_clg_id', $user->user_clg_id)->where('an_branch_id', Session::get('branch_id'))->pluck('an_title');
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
            return view('collegeViews/announcement/announcement_list', compact('datas', 'search','search_year', 'announcement_title'));
        }
    }
//    static public function notify()
//    {
//        $url = "";
//        $server_key = "";
//
//        $dataArr = [
//            "click_action" => "FLUTTER_NOTIFICATION_CLICK",
//            "status" => "daone",
//        ];
//        $data = [
//            "registration_ids" => [$device_key],
//            "notification" => [
//                "title" => $title,
//                "body" => $body,
//                "sound" => "default",
//            ],
//            "data" => $dataArr,
//            "priority" => "high",
//        ];
//        $encodeddata = json_decode($data);
//        $header = [
//            "Authorization:key=" . $server_key,
//            "Content-Type: application/json"
//        ];
//        $crl = curl_init();
//        curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, false);
//
//        curl_setopt($crl, CURLOPT_URL, $URL);
//        curl_setopt($crl, CURLOPT_HTTPHEADER, $headr);
//
//        curl_setopt($crl, CURLOPT_POST, true);
//        curl_setopt($crl, CURLOPT_POSTFIELDS, $post_data);
//        curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
//
//        $rest = curl_exec($crl);
//
//        if ($rest === false) {
//            // throw new Exception('Curl error: ' . curl_error($crl));
//            //print_r('Curl error: ' . curl_error($crl));
//            $result_noti = 0;
//        } else {
//
//            $result_noti = 1;
//        }
//
//        //curl_close($crl);
//        //print_r($result_noti);die;
//        return $result_noti;
//
//
//    }
}
