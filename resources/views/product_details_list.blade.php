
@extends('extend_index')

@section('content')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 tabindex="-1" class="text-white get-heading-text file_name">Product Detail List</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i tabindex="-1" class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->


{{--                <!-- <div class="search_form  {{ ( !empty($search) || !empty($search_product_code) || !empty($search_product_name) || !empty($search_publisher) || !empty($search_topic) || !empty($search_class) || !empty($search_currency) || !empty($search_language) || !empty($search_imprint) || !empty($search_illustrated) || !empty($search_author) || !empty($search_genre) ) ? '' : 'search_form_hidden' }}"> -->--}}


                <div class="search_form">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <form class="prnt_lst_frm" action="{{ route('product_details_list') . ((isset($restore_list) && $restore_list == 1) ? '?restore_list=1' : '') }}" name="form1" id="form1" method="post">
                                @csrf
                                <div class="row">

                                    <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>
                                                All Column Search
                                            </label>
                                            <input tabindex="1" autofocus type="search" list="browsers" class="inputs_up form-control all_clm_srch" name="search" id="search" placeholder="Search ..." value="{{ isset($search) ? $search : '' }}" autocomplete="off">
                                            <datalist id="browsers">
                                                @foreach($pd_title as $value)
                                                    <option value="{{$value}}">
                                                @endforeach
                                            </datalist>
                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                        </div>
                                    </div> <!-- left column ends here -->

                                    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 srch_brdr_left">
                                        <div class="row">

                                            <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Select Code
                                                    </label>
                                                    <select tabindex="2" class="inputs_up form-control cstm_clm_srch" name="product_code" id="product_code">
                                                        <option value="">Select Code</option>
                                                        @foreach ($products as $product)
                                                            <option value='{{ $product->pro_p_code }}'>{{ $product->pro_p_code }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Select Product Name
                                                    </label>
                                                    <select tabindex="3" class="inputs_up form-control cstm_clm_srch" name="product_name" id="product_name">
                                                        <option value="">Select Product Name</option>
                                                        @foreach ($products as $product)
                                                            <option value='{{ $product->pro_title }}' data-product-code="{{ $product->pro_p_code }}">{{ $product->pro_title }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Select Publisher
                                                    </label>
                                                    <select tabindex="4" class="inputs_up form-control cstm_clm_srch" name="publisher" id="publisher">
                                                        <option value="">Select Publisher</option>
                                                        @foreach($publishers as $publisher)
                                                            <option value="{{$publisher->pub_id}}" {{ $publisher->pub_id == $search_publisher ? 'selected="selected"' : '' }}>{{$publisher->pub_title}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Select Topic
                                                    </label>
                                                    <select tabindex="5" class="inputs_up form-control cstm_clm_srch" name="topic" id="topic">
                                                        <option value="">Select Topic</option>
                                                        @foreach($topics as $topic)
                                                            <option value="{{$topic->top_id}}" {{ $topic->top_id == $search_topic ? 'selected="selected"' : '' }}>{{$topic->top_title}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Select Class
                                                    </label>
                                                    <select tabindex="6" class="inputs_up form-control cstm_clm_srch" name="class" id="class">
                                                        <option value="">Select Class</option>
                                                        @foreach($classes as $class)
                                                            <option value="{{$class->cla_id}}" {{ $class->cla_id == $search_class ? 'selected="selected"' : '' }}>{{$class->cla_title}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Select Currency
                                                    </label>
                                                    <select tabindex="7" class="inputs_up form-control cstm_clm_srch" name="currency" id="currency">
                                                        <option value="">Select Currency</option>
                                                        @foreach($currencies as $currency)
                                                            <option value="{{$currency->cur_id}}" {{ $currency->cur_id == $search_currency ? 'selected="selected"' : '' }}>{{$currency->cur_title}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>
                                            <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Select Language
                                                    </label>
                                                    <select tabindex="8" class="inputs_up form-control cstm_clm_srch" name="language" id="language">
                                                        <option value="">Select Language</option>
                                                        @foreach($languages as $language)
                                                            <option value="{{$language->lan_id}}" {{ $language->lan_id == $search_language ? 'selected="selected"' : '' }}>{{$language->lan_title}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>
                                            <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Select ImPrint
                                                    </label>
                                                    <select tabindex="9" class="inputs_up form-control cstm_clm_srch" name="imprint" id="imprint">
                                                        <option value="">Select ImPrint</option>
                                                        @foreach($imprints as $imprint)
                                                            <option value="{{$imprint->imp_id}}" {{ $imprint->imp_id == $search_imprint ? 'selected="selected"' : '' }}>{{$imprint->imp_title}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>
                                            <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Select Illustrated
                                                    </label>
                                                    <select tabindex="10" class="inputs_up form-control cstm_clm_srch" name="illustrated" id="illustrated">
                                                        <option value="">Select Illustrated</option>
                                                        @foreach($illustrateds as $illustrated)
                                                            <option value="{{$illustrated->ill_id}}" {{ $illustrated->ill_id == $search_illustrated ? 'selected="selected"' : '' }}>{{$illustrated->ill_title}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>
                                            <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Select Author
                                                    </label>
                                                    <select tabindex="11" class="inputs_up form-control cstm_clm_srch" name="author" id="author">
                                                        <option value="">Select Author</option>
                                                        @foreach($authors as $author)
                                                            <option value="{{$author->aut_id}}" {{ $author->aut_id == $search_author ? 'selected="selected"' : '' }}>{{$author->aut_title}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>
                                            <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Select Genre
                                                    </label>
                                                    <select tabindex="12" class="inputs_up form-control cstm_clm_srch" name="genre" id="genre">
                                                        <option value="">Select Genre</option>
                                                        @foreach($genres as $genre)
                                                            <option value="{{$genre->gen_id}}" {{ $genre->gen_id == $search_genre ? 'selected="selected"' : '' }}>{{$genre->gen_title}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 mt-lg-2">
                                                <div class="form_controls text-center text-lg-left">

                                                    <button tabindex="13" type="button" type="button" name="cancel" id="cancel" class="cancel_button form-control">
                                                        <i class="fa fa-trash"></i> Clear
                                                    </button>
                                                    <button tabindex="14" type="submit" name="filter_search" id="filter_search" class="save_button form-control" value="">
                                                        <i class="fa fa-search"></i> Search
                                                    </button>

                                                    <a tabindex="15" class="save_button form-control" href="{{ route('add_product_details') }}" role="button">
                                                        <l class="fa fa-plus"></l> Product Details
                                                    </a>

                                                    @include('include/print_button')

                                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>

                                                </div>
                                            </div>

                                        </div><!-- end row -->
                                    </div>
                                </div><!-- end row -->
                            </form>



                            <form name="edit" id="edit" action="{{ route('edit_product_details') }}" method="post">
                                @csrf
                                <input name="pd_id" id="pd_id" type="hidden">
                                <input name="code_id" id="code_id" type="hidden">
                                <input name="product_title" id="product_title" type="hidden">
                                <input name="publisher_title" id="publisher_title" type="hidden">
                                <input name="topic_title" id="topic_title" type="hidden">
                                <input name="class_title" id="class_title" type="hidden">
                                <input name="currency_title" id="currency_title" type="hidden">
                                <input name="language_title" id="language_title" type="hidden">
                                <input name="imprint_title" id="imprint_title" type="hidden">
                                <input name="illustrated_title" id="illustrated_title" type="hidden">
                                <input name="author_title" id="author_title" type="hidden">
                                <input name="genre_title" id="genre_title" type="hidden">
                                <input name="remarks" id="remarks" type="hidden">
                                <input name="product_id" id="product_id" type="hidden">
                                <input name="publisher_id" id="publisher_id" type="hidden">
                                <input name="topic_id" id="topic_id" type="hidden">
                                <input name="class_id" id="class_id" type="hidden">
                                <input name="currency_id" id="currency_id" type="hidden">
                                <input name="language_id" id="language_id" type="hidden">
                                <input name="imprint_id" id="imprint_id" type="hidden">
                                <input name="illustrated_id" id="illustrated_id" type="hidden">
                                <input name="author_id" id="author_id" type="hidden">
                                <input name="genre_id" id="genre_id" type="hidden">

                            </form>

                            <form name="delete" id="delete" action="{{ route('delete_product_details') }}" method="post">
                                @csrf
                                <input name="product_id" id="del_product_id" type="hidden">

                            </form>



                        </div>
                    </div>
                </div><!-- search form end -->



                <div class="table-responsive" id="printTable">
                    <table class="table table-bordered table-sm" id="fixTable">

                        <thead>
                        <tr>
                            <th scope="col" align="center" class="text-center align_center tbl_srl_2">Sr#</th>
                           <th scope="col" align="center" class="text-center align_center tbl_srl_2">ID</th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_7">product Code</th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_7">product Name</th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_7">Publisher Title</th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_7">Topic Title</th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_8">Class Title</th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_8">Currency Title</th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_8">Language Title</th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_6">ImPrint Title</th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_6">Illustrated Title</th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_8">Author Title</th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_8">Genre Title</th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_4">Remarks</th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_4">Created By</th>
                            <th scope="col" align="center" class="text-center align_center tbl_srl_4 hide_column">Enable</th>
                            <th scope="col" align="center" class="text-center align_center tbl_srl_2 hide_column">Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @php
                            $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
                            $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
                            $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                            $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
                        @endphp
                        @forelse($datas as $product_detail)

                            <tr
                                data-pd_id="{{$product_detail->pd_id}}" data-code_id="{{$product_detail->pd_pro_code}}" data-product_title="{{$product_detail->pd_pro_name}}" data-publisher_title="{{$product_detail->pd_publisher}}"
                                data-topic_title="{{$product_detail->pd_topic}}" data-class_title="{{$product_detail->pd_class}}" data-currency_title="{{$product_detail->pd_currency}}"
                                data-language_title="{{$product_detail->pd_language}}" data-imprint_title="{{$product_detail->pd_imprint}}" data-illustrated_title="{{$product_detail->pd_illustrated}}"
                                data-author_title="{{$product_detail->pd_author_ids}}" data-genre_title="{{$product_detail->pd_genre_ids}}" data-remarks="{{$product_detail->pd_remarks}}"
                                data-publisher_id="{{$product_detail->pub_id}}" data-product_id="{{$product_detail->pro_id}}" data-topic_id="{{$product_detail->top_id}}" data-class_id="{{$product_detail->cla_id}}"
                                data-currency_id="{{$product_detail->cur_id}}" data-language_id="{{$product_detail->lan_id}}" data-imprint_id="{{$product_detail->imp_id}}"
                                data-illustrated_id="{{$product_detail->ill_id}}" data-author_id="{{$product_detail->aut_id}}" data-genre_id="{{$product_detail->gen_id}}">

                                <td class="text-center align_center edit tbl_srl_2">
                                    {{$sr}}
                                </td>
                                <td class="text-center align_center edit tbl_srl_2">
                                    {{$product_detail->pd_id}}
                                </td>
                                <td class="align_left text-left edit tbl_txt_7">
                                    {{$product_detail->pd_pro_code}}
                                </td>
                                <td class="align_left text-left edit tbl_txt_7">
                                    {{$product_detail->pd_pro_name}}
                                </td>
                                <td class="align_left text-left edit tbl_txt_7">
                                    {{$product_detail->pub_title}}
                                </td>
                                <td class="align_left text-left edit tbl_txt_7">
                                    {{$product_detail->top_title}}
                                </td>
                                <td class="align_left text-left edit tbl_txt_8">
                                    {{$product_detail->cla_title}}
                                </td>
                                <td class="align_left text-left edit tbl_txt_8">
                                    {{$product_detail->cur_title}}
                                </td>
                                <td class="align_left text-left edit tbl_txt_8">
                                    {{$product_detail->lan_title}}
                                </td>
                                <td class="align_left text-left edit tbl_txt_8">
                                    {{$product_detail->imp_title}}
                                </td>
                                <td class="align_left text-left edit tbl_txt_8">
                                    {{$product_detail->ill_title}}
                                </td>
                                <td class="align_left text-left edit tbl_txt_8">
                                    {{implode(',', $authors_ids[$product_detail->pd_id] )}}

                                </td>
                                <td class="align_left text-left edit tbl_txt_8">
{{--                                    @foreach($genres_ids[$product_detail->pd_id] as $genre)--}}
                                        {{implode(',', $genres_ids[$product_detail->pd_id] )}}
{{--                                    @endforeach--}}
{{--                                    {{$product_detail->gen_title}}--}}
                                </td>
                                <td class="align_left text-left edit tbl_txt_4">
                                    {{$product_detail->pd_remarks}}
                                </td>
                                @php
                                    $ip_browser_info= ''.$product_detail->pd_ip_adrs.','.str_replace(' ','-',$product_detail->pd_brwsr_info).'';
                                @endphp

                                <td class="align_left text-left usr_prfl tbl_txt_4" data-usr_prfl="{{ $product_detail->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                    {{ $product_detail->user_name }}
                                </td>

                                <td class="align_right text-right hide_column tbl_amnt_4">
                                    <label class="switch">
                                        <input type="checkbox" <?php if ($product_detail->pd_disabled == 0) {
                                            echo 'checked="true"' . ' ' . 'value=' . $product_detail->pd_disabled;
                                        } else {
                                            echo 'value=DISABLE';
                                        } ?>  class="enable_disable" data-id="{{$product_detail->pd_id}}"
                                            {{ $product_detail->pd_disabled == 0 ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </label>
                                </td>

                                <td class="align_right text-right hide_column tbl_amnt_2">
                                    <a data-product_id="{{$product_detail->pd_id}}" class="delete"  data-toggle="tooltip" data-placement="left"  title="" data-original-title="Are you sure?">
                                        <i class="fa fa-{{$product_detail->pd_delete_status == 1 ? 'undo':'trash'}}"></i>
                                    </a>
                                </td>


                            </tr>
                            @php
                                $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="15">
                                    <center><h3 style="color:#554F4F">No Product Detail</h3></center>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>

                    </table>

                </div>
                <span class="hide_column"> {{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search, 'product_code'=>$search_product_code, 'product_name'=>$search_product_name, 'publisher'=>$search_publisher, 'topic'=>$search_topic, 'class'=>$search_class, 'currency'=>$search_currency, 'language'=>$search_language, 'imprint'=>$search_imprint, 'illustrated'=>$search_illustrated, 'author'=>$search_author, 'genre'=>$search_genre ])->links() }}</span>
            </div> <!-- white column form ends here -->



        </div><!-- col end -->


    </div><!-- row end -->

@endsection

@section('scripts')


    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('product_details_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}
    <script>

        $(document).ready(function () {
            $('.enable_disable').change(function () {
                let status = $(this).prop('checked') === true ? 0 : 1;
                let pdId = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('enable_disable_product_detail') }}',
                    data: {'status': status, 'pd_id': pdId},
                    success: function (data) {
                        console.log(data.message);
                    }
                });
            });
        });
    </script>

    <script>
        jQuery(".edit").click(function () {

            var pd_id = jQuery(this).parent('tr').attr("data-pd_id");
            var code_id = jQuery(this).parent('tr').attr("data-code_id");
            var product_title = jQuery(this).parent('tr').attr("data-product_title");
            var publisher_title = jQuery(this).parent('tr').attr("data-publisher_title");
            var topic_title = jQuery(this).parent('tr').attr("data-topic_title");
            var class_title = jQuery(this).parent('tr').attr("data-class_title");
            var currency_title = jQuery(this).parent('tr').attr("data-currency_title");
            var language_title = jQuery(this).parent('tr').attr("data-language_title");
            var imprint_title = jQuery(this).parent('tr').attr("data-imprint_title");
            var illustrated_title = jQuery(this).parent('tr').attr("data-illustrated_title");
            var author_title = jQuery(this).parent('tr').attr("data-author_title");
            var genre_title = jQuery(this).parent('tr').attr("data-genre_title");
            var remarks = jQuery(this).parent('tr').attr("data-remarks");
            var publisher_id = jQuery(this).parent('tr').attr("data-publisher_id");
            var product_id = jQuery(this).parent('tr').attr("data-product_id");
            var topic_id = jQuery(this).parent('tr').attr("data-topic_id");
            var class_id = jQuery(this).parent('tr').attr("data-class_id");
            var currency_id = jQuery(this).parent('tr').attr("data-currency_id");
            var language_id = jQuery(this).parent('tr').attr("data-language_id");
            var imprint_id = jQuery(this).parent('tr').attr("data-imprint_id");
            var illustrated_id = jQuery(this).parent('tr').attr("data-illustrated_id");
            var author_id = jQuery(this).parent('tr').attr("data-author_id");
            var genre_id = jQuery(this).parent('tr').attr("data-genre_id");

            jQuery("#pd_id").val(pd_id);
            jQuery("#code_id").val(code_id);
            jQuery("#product_title").val(product_title);
            jQuery("#publisher_title").val(publisher_title);
            jQuery("#topic_title").val(topic_title);
            jQuery("#class_title").val(class_title);
            jQuery("#currency_title").val(currency_title);
            jQuery("#language_title").val(language_title);
            jQuery("#imprint_title").val(imprint_title);
            jQuery("#illustrated_title").val(illustrated_title);
            jQuery("#author_title").val(author_title);
            jQuery("#genre_title").val(genre_title);
            jQuery("#remarks").val(remarks);
            jQuery("#publisher_id").val(publisher_id);
            jQuery("#product_id").val(product_id);
            jQuery("#topic_id").val(topic_id);
            jQuery("#class_id").val(class_id);
            jQuery("#currency_id").val(currency_id);
            jQuery("#language_id").val(language_id);
            jQuery("#imprint_id").val(imprint_id);
            jQuery("#illustrated_id").val(illustrated_id);
            jQuery("#author_id").val(author_id);
            jQuery("#genre_id").val(genre_id);
            jQuery("#edit").submit();
        });

        $('.delete').on('click', function (event) {

            var product_id = jQuery(this).attr("data-product_id");

            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Yes',
            }).then(function(result) {

                if (result.value) {
                    jQuery("#del_product_id").val(product_id);
                    jQuery("#delete").submit();
                } else {

                }
            });
        });

    </script>

    <script>
        jQuery("#cancel").click(function () {

            $("#product_name").select2().val(null).trigger("change");
            $("#product_name > option").removeAttr('selected');

            $("#product_code").select2().val(null).trigger("change");
            $("#product_code > option").removeAttr('selected');

            $("#search").val('');
        });
    </script>

    <script>
        jQuery(document).ready(function () {

            jQuery("#product_code").change(function () {
                var product_code = jQuery('option:selected', this).val();

                jQuery("#product_name").select2("destroy");
                jQuery('#product_name option[data-product-code="' + product_code + '"]').prop('selected', true);
                jQuery("#product_name").select2();
            });
            jQuery("#product_name").change(function () {
                var product_code = $(this).select2().find(":selected").data("product-code"); /* backup code: $('option:selected', this).attr('data-product-code') */

                jQuery("#product_code").select2("destroy");
                jQuery('#product_code option[value="' + product_code + '"]').prop('selected', true);
                jQuery("#product_code").select2();
            });

            // Initialize select2
            jQuery("#product_name").select2();
            jQuery("#product_code").select2();

            jQuery("#publisher").select2();
            jQuery("#topic").select2();
            jQuery("#class").select2();
            jQuery("#currency").select2();
            jQuery("#language").select2();
            jQuery("#imprint").select2();
            jQuery("#illustrated").select2();
            jQuery("#author").select2();
            jQuery("#genre").select2();
        });
    </script>

@endsection

