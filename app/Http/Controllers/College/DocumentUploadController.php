<?php

namespace App\Http\Controllers\College;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SaveImageController;
use App\Models\College\DocumentUploadModel;
use App\Models\College\Student;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;


class DocumentUploadController extends Controller
{
    public function document_uplaod()
    {

        $students = Student::where('branch_id', Session::get('branch_id'))->get();
        return view('collegeViews/student/document_upload', compact('students'));
    }

    public function store_document_upload(Request $request)
    {

        $brwsr_rslt = $this->getBrwsrInfo();
        $clientIP = $this->getIp();
        $uniqueId = Utility::uniqidReal() . mt_rand();
        $user = Auth::user();
        $document = new DocumentUploadModel();
        $document->d_std_id = $request->std_id;
        $document->d_clg_id = $user->user_clg_id;
        $document->d_branch_id = Session::get('branch_id');
        $document->d_created_by = $user->user_id;
        $document->d_remarks = $request->remarks;
        $document->d_browser_info = $brwsr_rslt;
        $document->d_ip_address = $clientIP;
        $document->d_year_id = $this->getYearEndId();
        $common_path = config('global_variables.common_path');
        $document_pdf_path = config('global_variables.document_pdf_path');
        $save_pdf = new SaveImageController();
        $student = Student::where('id', $request->std_id)->pluck('full_name');
        $fileNameToStorePath = $save_pdf->SavePdf($request, 'file', $document_pdf_path . '_' . $user->user_clg_id . '_' . Session::get('branch_id'), $request->std_id . $uniqueId . $student);
        if (!empty($request->file)) {
            $document->d_file = $common_path . $fileNameToStorePath;
        }
        $document->save();
        return redirect()->back()->with('success', 'Successfully saved');

    }

   public  function document_list(Request $request, $array = null, $str = null)
   {
       $ar = json_decode($request->array);
       $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
       $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->year;
       $query = DB::table('documents')
           ->where('d_branch_id', Session::get('branch_id'))
       ->leftJoin('students','students.id','=','documents.d_std_id')
       ->leftJoin('financials_users as user','user.user_id','=','documents.d_created_by');
       if (!empty($search)) {
           $query->where('students.full_name', $search);
       }
       if (!empty($search_year)) {
           $query->where('d_year_id', '=', $search_year);
       } else {
           $search_year = $this->getYearEndId();
           $query->where('d_year_id', '=', $search_year);
       }
       $documents = $query->get();
       return view('collegeViews/student/document_upload_list',compact('documents','search','search_year'));
   }

}
