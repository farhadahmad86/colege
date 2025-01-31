<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Models\AreaModel;
use App\Models\AuthorModel;
use App\Models\ClassModel;
use App\Models\CurrencyModel;
use App\Models\GenreModel;
use App\Models\IllustratedModel;
use App\Models\ImPrintModel;
use App\Models\LanguageModel;
use App\Models\ProductDetailsModel;
use App\Models\ProductModel;
use App\Models\PublisherModel;
use App\Models\RegionModel;
use App\Models\SectorModel;
use App\Models\TopicModel;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ProductDetailsController extends Controller
{
    public function add_product_details()
    {
        $products = ProductModel::orderBy('pro_title', 'ASC')->get();
        $publishers = PublisherModel::where('pub_delete_status', '!=', 1)->where('pub_disabled', '!=', 1)->orderBy('pub_title', 'ASC')->get();
        $topics = TopicModel::where('top_delete_status', '!=', 1)->where('top_disabled', '!=', 1)->orderBy('top_title', 'ASC')->get();
        $classes = ClassModel::where('cla_delete_status', '!=', 1)->where('cla_disabled', '!=', 1)->orderBy('cla_title', 'ASC')->get();
        $currencies = CurrencyModel::where('cur_delete_status', '!=', 1)->where('cur_disabled', '!=', 1)->orderBy('cur_title', 'ASC')->get();
        $languages = LanguageModel::where('lan_delete_status', '!=', 1)->where('lan_disabled', '!=', 1)->orderBy('lan_title', 'ASC')->get();
        $imprints = ImPrintModel::where('imp_delete_status', '!=', 1)->where('imp_disabled', '!=', 1)->orderBy('imp_title', 'ASC')->get();
        $illustrateds = IllustratedModel::where('ill_delete_status', '!=', 1)->where('ill_disabled', '!=', 1)->orderBy('ill_title', 'ASC')->get();
        $authors = AuthorModel::where('aut_delete_status', '!=', 1)->where('aut_disabled', '!=', 1)->orderBy('aut_title', 'ASC')->get();
        $genres = GenreModel::where('gen_delete_status', '!=', 1)->where('gen_disabled', '!=', 1)->orderBy('gen_title', 'ASC')->get();

        return view('add_product_details', compact('products', 'publishers', 'topics', 'classes', 'currencies', 'languages', 'imprints', 'illustrateds', 'authors', 'genres'));
    }


    public function submit_product_details(Request $request)
    {
        $this->product_details_validation($request);

        $product_details = new ProductDetailsModel();

        $product_details = $this->AssignProductDetailsValues($request, $product_details);
        $product_details->save();

        $user = Auth::User();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create ProductDetail With Id: ' . $product_details->pd_id . ' Code: ' . $product_details->pd_pro_code . ' And Name: ' . $product_details->pd_pro_name);

        // WizardController::updateWizardInfo(['product_details'], ['town']);

        return redirect('add_product_details')->with('success', 'Successfully Saved');
    }

    public function product_details_validation($request)
    {
        return $this->validate($request, [
            'product_code' => ['required', 'numeric'],
            'product_name' => ['required'],
            'remarks' => ['nullable', 'string'],
        ]);

    }

    protected function AssignProductDetailsValues($request, $product_details)
    {
        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $product_details->pd_pro_code = $request->product_code;
        $product_details->pd_pro_name = $request->product_name;
        $product_details->pd_publisher = $request->publisher_name;
        $product_details->pd_author_ids = empty($request->author) ? '' : implode(',', $request->author);
        $product_details->pd_topic = $request->topic_name;
        $product_details->pd_class = $request->class_name;
        $product_details->pd_currency = $request->currency_name;
        $product_details->pd_language = $request->language_name;
        $product_details->pd_imprint = $request->imprint_name;
        $product_details->pd_illustrated = $request->illustrated_name;
        $product_details->pd_genre_ids = empty($request->genre) ? '' : implode(',', $request->genre);
        $product_details->pd_remarks = ucfirst($request->remarks);
        $product_details->pd_createdby = $user->user_id;
        $product_details->pd_day_end_id = $day_end->de_id;
        $product_details->pd_day_end_date = $day_end->de_datetime;

        // coding from shahzaib start
        $tbl_var_name = 'product_details';
        $prfx = 'pd';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now();
        // coding from shahzaib end


        return $product_details;
    }


    // update code by shahzaib start
    public function product_details_list(Request $request, $array = null, $str = null)
    {
        $products = ProductModel::orderby('pro_title', 'ASC')->get();
        $publishers = PublisherModel::orderBy('pub_title', 'ASC')->get();
        $topics = TopicModel::orderBy('top_title', 'ASC')->get();
        $classes = ClassModel::orderBy('cla_title', 'ASC')->get();
        $currencies = CurrencyModel::orderBy('cur_title', 'ASC')->get();
        $languages = LanguageModel::orderBy('lan_title', 'ASC')->get();
        $imprints = ImPrintModel::orderBy('imp_title', 'ASC')->get();
        $illustrateds = IllustratedModel::orderBy('ill_title', 'ASC')->get();
        $authors = AuthorModel::orderBy('aut_title', 'ASC')->get();
        $genres = GenreModel::orderBy('gen_title', 'ASC')->get();


        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_product_code = (!isset($request->product_code) && empty($request->product_code)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->product_code;
        $search_product_name = (!isset($request->product_name) && empty($request->product_name)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->product_name;
        $search_publisher = (!isset($request->publisher) && empty($request->publisher)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->publisher;
        $search_topic = (!isset($request->topic) && empty($request->topic)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->topic;
        $search_class = (!isset($request->class) && empty($request->class)) ? ((!empty($ar)) ? $ar[6]->{'value'} : '') : $request->class;
        $search_currency = (!isset($request->currency) && empty($request->currency)) ? ((!empty($ar)) ? $ar[7]->{'value'} : '') : $request->currency;
        $search_language = (!isset($request->language) && empty($request->language)) ? ((!empty($ar)) ? $ar[8]->{'value'} : '') : $request->language;
        $search_imprint = (!isset($request->imprint) && empty($request->imprint)) ? ((!empty($ar)) ? $ar[9]->{'value'} : '') : $request->imprint;
        $search_illustrated = (!isset($request->illustrated) && empty($request->illustrated)) ? ((!empty($ar)) ? $ar[10]->{'value'} : '') : $request->illustrated;
        $search_author = (!isset($request->author) && empty($request->author)) ? ((!empty($ar)) ? $ar[11]->{'value'} : '') : $request->author;
        $search_genre = (!isset($request->genre) && empty($request->genre)) ? ((!empty($ar)) ? $ar[12]->{'value'} : '') : $request->genre;
        $search_by_user = $request->search_by_user;

        $prnt_page_dir = 'print.product_details_list.product_details_list';
        $pge_title = 'Product Detail List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_product_code, $search_product_name, $search_publisher, $search_topic, $search_class, $search_currency, $search_language, $search_imprint, $search_illustrated, $search_author, $search_genre, $search_by_user);


        $pagination_number = (empty($ar)) ? 30 : 100000000;

        $query = DB::table('financials_product_detail')
            ->leftJoin('financials_products', 'financials_products.pro_id', '=', 'financials_product_detail.pd_pro_code')
            ->leftJoin('financials_publisher', 'financials_publisher.pub_id', '=', 'financials_product_detail.pd_publisher')
            ->leftJoin('financials_topic', 'financials_topic.top_id', '=', 'financials_product_detail.pd_topic')
            ->leftJoin('financials_class', 'financials_class.cla_id', '=', 'financials_product_detail.pd_class')
            ->leftJoin('financials_currency', 'financials_currency.cur_id', '=', 'financials_product_detail.pd_currency')
            ->leftJoin('financials_language', 'financials_language.lan_id', '=', 'financials_product_detail.pd_language')
            ->leftJoin('financials_imprint', 'financials_imprint.imp_id', '=', 'financials_product_detail.pd_imprint')
            ->leftJoin('financials_illustrated', 'financials_illustrated.ill_id', '=', 'financials_product_detail.pd_illustrated')
            ->leftJoin('financials_author', 'financials_author.aut_id', '=', 'financials_product_detail.pd_author_ids')
            ->leftJoin('financials_genre', 'financials_genre.gen_id', '=', 'financials_product_detail.pd_genre_ids')
            ->leftJoin('financials_users', 'financials_users.user_id', '=', 'financials_product_detail.pd_createdby');


        if (!empty($search)) {
            $pagination_number = 1000000;
            $query->orWhere('pro_title', 'like', '%' . $search . '%')
                ->orWhere('pub_title', 'like', '%' . $search . '%')
                ->orWhere('top_id', 'like', '%' . $search . '%')
                ->orWhere('cla_title', 'like', '%' . $search . '%')
                ->orWhere('cur_title', 'like', '%' . $search . '%')
                ->orWhere('lan_title', 'like', '%' . $search . '%')
                ->orWhere('imp_title', 'like', '%' . $search . '%')
                ->orWhere('ill_title', 'like', '%' . $search . '%')
                ->orWhere('aut_title', 'like', '%' . $search . '%')
                ->orWhere('gen_title', 'like', '%' . $search . '%')
                ->orWhere('pd_remarks', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%');
        }

        if (!empty($search_product_code)) {
            $pagination_number = 1000000;
            $query->orWhere('pro_id', $search_product_code);
        }

        if (!empty($search_product_name)) {
            $pagination_number = 1000000;
            $query->where('pro_id', $search_product_name);
        }
        if (!empty($search_publisher)) {
            $pagination_number = 1000000;
            $query->where('pub_id', $search_publisher);
        }

        if (!empty($search_topic)) {
            $pagination_number = 1000000;
            $query->where('top_id', $search_topic);
        }

        if (!empty($search_currency)) {
            $pagination_number = 1000000;
            $query->where('cur_id', $search_currency);
        }

        if (!empty($search_class)) {
            $pagination_number = 1000000;
            $query->where('cla_id', $search_class);
        }

        if (!empty($search_language)) {
            $pagination_number = 1000000;
            $query->where('lan_id', $search_language);
        }

        if (!empty($search_imprint)) {
            $pagination_number = 1000000;
            $query->where('imp_id', $search_imprint);
        }

        if (!empty($search_illustrated)) {
            $pagination_number = 1000000;
            $query->where('ill_id', $search_illustrated);
        }

        if (!empty($search_author)) {
            $pagination_number = 1000000;
            $query->where('aut_id', $search_author);
        }

        if (!empty($search_genre)) {
            $pagination_number = 1000000;
            $query->where('gen_id', $search_genre);
        }

        if (!empty($search_by_user)) {
            $pagination_number = 1000000;
            $query->where('pd_createdby', '=', $search_by_user);
        }

        $restore_list = $request->restore_list;
        if ($restore_list == 1)
        {
            $query->where('pd_delete_status', '=', 1);
        } else {
            $query->where('pd_delete_status', '!=', 1);
        }


        $datas = $query
//            ->where('pd_delete_status', '!=', 1)
            ->select('financials_product_detail.*', 'financials_products.pro_id' ,'financials_products.pro_p_code', 'financials_products.pro_title', 'financials_publisher.pub_id', 'financials_publisher.pub_title',
                'financials_topic.top_id','financials_topic.top_title', 'financials_class.cla_id', 'financials_class.cla_title', 'financials_currency.cur_id', 'financials_currency.cur_title',
                'financials_language.lan_id','financials_language.lan_title', 'financials_imprint.imp_id', 'financials_imprint.imp_title', 'financials_illustrated.ill_id', 'financials_illustrated.ill_title',
                'financials_author.aut_id','financials_author.aut_title', 'financials_genre.gen_id', 'financials_genre.gen_title', 'financials_users.user_id', 'financials_users.user_name')
            ->orderBy('pd_id', config('global_variables.query_sorting'))//->get();
            ->paginate($pagination_number);
//        dd($datas);//->pd_author_ids);

        $authors_ids = [];
        foreach ($datas as $member) {
            $ab = explode(",", $member->pd_author_ids);
            $authors_ids[$member->pd_id] = AuthorModel::whereIn('aut_id', $ab)->pluck('aut_title')->all();

        }

        $genres_ids = [];
        foreach ($datas as $member) {
            $ab = explode(",", $member->pd_genre_ids);
            $genres_ids[$member->pd_id] = GenreModel::whereIn('gen_id', $ab)->pluck('gen_title')->all();

        }


        $pd_title = ProductDetailsModel::orderBy('pd_id', 'ASC')->pluck('pd_id')->all();

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
//            dd($datas, $authors_ids, $genres_ids);
            return view('product_details_list', compact('datas', 'authors_ids', 'genres_ids', 'search', 'pd_title', 'publishers', 'products', 'topics', 'classes', 'currencies', 'languages', 'classes', 'illustrateds', 'imprints', 'authors', 'genres', 'search_product_code', 'search_product_name', 'search_publisher', 'search_topic', 'search_class', 'search_currency', 'search_language', 'search_imprint', 'search_illustrated', 'search_author', 'search_genre', 'search_by_user', 'restore_list'));
        }

    }
//
    // update code by shahzaib end


    public function edit_product_details(Request $request)
    {
        $product_detail = ProductDetailsModel::where('pd_id', '=', $request->pd_id)->first();
        $products = ProductModel::where('pro_delete_status', '!=', 1)->where('pro_disabled', '!=', 1)->orderBy('pro_title', 'ASC')->get();
        $publishers = PublisherModel::where('pub_delete_status', '!=', 1)->where('pub_disabled', '!=', 1)->orderBy('pub_title', 'ASC')->get();
        $topics = TopicModel::where('top_delete_status', '!=', 1)->where('top_disabled', '!=', 1)->orderBy('top_title', 'ASC')->get();
        $classes = ClassModel::where('cla_delete_status', '!=', 1)->where('cla_disabled', '!=', 1)->orderBy('cla_title', 'ASC')->get();
        $currencies = CurrencyModel::where('cur_delete_status', '!=', 1)->where('cur_disabled', '!=', 1)->orderBy('cur_title', 'ASC')->get();
        $languages = LanguageModel::where('lan_delete_status', '!=', 1)->where('lan_disabled', '!=', 1)->orderBy('lan_title', 'ASC')->get();
        $imprints = ImPrintModel::where('imp_delete_status', '!=', 1)->where('imp_disabled', '!=', 1)->orderBy('imp_title', 'ASC')->get();
        $illustrateds = IllustratedModel::where('ill_delete_status', '!=', 1)->where('ill_disabled', '!=', 1)->orderBy('ill_title', 'ASC')->get();
        $authors = AuthorModel::where('aut_delete_status', '!=', 1)->where('aut_disabled', '!=', 1)->orderBy('aut_title', 'ASC')->get();
        $genres = GenreModel::where('gen_delete_status', '!=', 1)->where('gen_disabled', '!=', 1)->orderBy('gen_title', 'ASC')->get();

        return view('edit_product_details', compact('request', 'product_detail', 'products', 'publishers', 'topics', 'classes', 'currencies', 'languages', 'imprints', 'illustrateds', 'authors', 'genres'));
    }

    public function update_product_details(Request $request)
    {
        $this->validate($request, [
            'product_code' => ['required', 'numeric'],
            'product_name' => ['required'],
            'remarks' => ['nullable', 'string'],
        ]);

        $product = ProductDetailsModel::where('pd_id', $request->pd_id)->first();

        $product_details = $this->AssignProductDetailsValues($request, $product);

        if ($product_details->save()) {

            $user = Auth::User();

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Product Details With Id: ' . $product->pd_id);

            return redirect('product_details_list')->with('success', 'Successfully Saved');
        } else {
            return redirect('product_details_list')->with('fail', 'Failed Try Again!');
        }
    }
    public function delete_product_details (Request $request)
    {

        $user = Auth::User();

        $delete = ProductDetailsModel::where('pd_id', $request->product_id)->first();

        if ($delete->pd_delete_status == 1) {
            $delete->pd_delete_status = 0;
        } else {
            $delete->pd_delete_status = 1;
        }

        $delete->pd_deleted_by = $user->user_id;

        if ($delete->save()) {

            if ($delete->pd_delete_status == 0) {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Restore Product Details With Id: ' . $delete->pd_id);

//                return redirect('region_list')->with('success', 'Successfully Restored');
                return redirect()->back()->with('success', 'Successfully Restored');
            } else {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Delete Product Details With Id: ' . $delete->pd_id );

//                return redirect('region_list')->with('success', 'Successfully Deleted');
                return redirect()->back()->with('success', 'Successfully Deleted');
            }

        } else {
//            return redirect('region_list')->with('fail', 'Failed Try Again!');
            return redirect()->back()->with('fail', 'Failed Try Again!');
        }
    }
}
