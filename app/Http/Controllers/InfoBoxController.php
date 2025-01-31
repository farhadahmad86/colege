<?php

namespace App\Http\Controllers;

use App\InfoBox;
use App\InfoBoxChild;
use App\Models\CompanyInfoModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class InfoBoxController extends Controller
{


    public function win_view(Request $request){
//        dd($request->win, $request->id);
        $win = $request->win;
        $cmpny = CompanyInfoModel::find($request->id);
        if($request->has('win')){
            $cmpny->info_bx = $win;
        }
        $cmpny->update();

        $info_up = CompanyInfoModel::where('ci_id',$request->id)->pluck('info_bx');
        Session::flash("success","For Permanent view please logout you");
        return response()->json(['info_up'=>$info_up]);
    }

    public function info_box_view($id){
        $info_bx = DB::table('financials_info_bx_child')
            ->leftJoin('financials_info_bx', 'financials_info_bx_child.ib_id','financials_info_bx.ib_id')
            ->select('financials_info_bx.*','financials_info_bx_child.*')
            ->where('financials_info_bx_child.ibc_id',$id)
            ->first();
        return view('how_to_use.info_bx_modal.info_bx_edit',compact('info_bx'));
    }

    public function index()
    {
        //
        $info_bxs = DB::table('financials_info_bx_child')
            ->leftJoin('financials_info_bx', 'financials_info_bx_child.ib_id','financials_info_bx.ib_id')
            ->select('financials_info_bx.*','financials_info_bx_child.ibc_ques','financials_info_bx_child.ibc_id')
            ->get();
        return view('how_to_use.info_box',compact('info_bxs'));
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //

        $rules = [
            'ib_url'    =>  'required|unique:financials_info_bx',
            'ibc_ques'     =>  'required',
            'ibc_ans'       =>  'required',
        ];

        $messages = [
            'ib_url.required'    =>  'Please Select Last Parameter of URL',
            'ib_url.unique'    =>  'URL all ready exists. Try an-other URL',
            'ibc_ques.required'     =>  'Please enter Question!.',
            'ibc_ans.required'       =>  'Please enter Answer',
        ];


        $this->validate($request, $rules, $messages);

        $info_bx = new InfoBox();

        if( $request->has('ib_url') ){
            $info_bx->ib_url = $request->input('ib_url');
        }

        if( $request->has('ib_vd_url') ){
            $info_bx->ib_vd_url = $request->input('ib_vd_url');
        }


        $info_bx->save();
//        dd($request->all());


        if( $request->has('ibc_ques') ){
            $product = array(
                'ibc_ques' => $request->get('ibc_ques'),
                'ibc_ans' => $request->get('ibc_ans'),
            );
            $x = 0;
            foreach( $request->get('ibc_ques') as $item ){
                $info_bx_child = new InfoBoxChild();
                $info_bx_child->ib_id = $info_bx->ib_id;
                $info_bx_child->ibc_ques = $product['ibc_ques'][$x];
                $info_bx_child->ibc_ans = $product['ibc_ans'][$x];
                $info_bx_child->save();
                $x++;
            }
        }


        Session::flash("success","Information Successfully Saved!.");
        return redirect('/info_box');

    }


    public function show($id)
    {
        $info_bx = DB::table('financials_info_bx_child')
            ->leftJoin('financials_info_bx', 'financials_info_bx_child.ib_id','financials_info_bx.ib_id')
            ->select('financials_info_bx.*','financials_info_bx_child.*')
            ->where('financials_info_bx_child.ibc_id',$id)
            ->first();
        return view('how_to_use.info_bx_modal.info_bx_view',compact('info_bx'));
    }


    public function edit($id)
    {
        //
//        $info_bx = DB::table('financials_info_bx_child')
//            ->leftJoin('financials_info_bx', 'financials_info_bx_child.ib_id','financials_info_bx.ib_id')
//            ->select('financials_info_bx.*','financials_info_bx_child.*')
//            ->where('financials_info_bx_child.ibc_id',$id)
//            ->first();
//        return view('how_to_use.info_bx_modal.info_bx_edit',compact('info_bx'));
    }


    public function update(Request $request, $id)
    {
        //

        $rules = [
            'ibc_ques'     =>  'required',
            'ibc_ans'       =>  'required',
        ];

        $messages = [
            'ibc_ques.required'     =>  'Please enter Question!.',
            'ibc_ans.required'       =>  'Please enter Answer',
        ];



        $this->validate($request, $rules, $messages);

        $info_bx = InfoBox::find($id);

        if( $request->has('ib_vd_url') ){
            $info_bx->ib_vd_url = $request->input('ib_vd_url');
        }

        if($info_bx->update()) {

            $info_bx_child = InfoBoxChild::find($request->input('info_bx_child_id'));

            if ($request->has('ibc_ques')) {
                $info_bx_child->ibc_ques = $request->input('ibc_ques');
            }

            if ($request->has('ibc_ques')) {
                $info_bx_child->ibc_ans = $request->input('ibc_ans');
            }
            $info_bx_child->update();
        }


        Session::flash("success","Information Successfully Saved!.");
        return redirect('/info_box');
    }


    public function destroy($id)
    {
        //
        InfoBoxChild::find($id)->delete();
        Session::flash("success","Information Successfully Deleted!.");
        return redirect('/info_box');

    }
}
