@extends('extend_index')

@section('content')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 tabindex="-1" class="text-white get-heading-text">Create Product Details</h4>
                        </div>
                        <div class="list_btn">
                            <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('product_details_list') }}" role="button">
                                <i class="fa fa-list"></i> view list
                            </a>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

                <form name="f1" class="f1" id="f1" action="{{ route('submit_product_details') }}" onsubmit="return checkForm()" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                    <div class="row">

                                        <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label class="required">
                                                    Product Code
                                                    <a tabindex="-1" href="{{ route('add_product') }}" class="add_btn" target="_blank" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                        <l class="fa fa-plus"></l>
                                                    </a>
                                                    <a tabindex="-1" class="add_btn" id="refresh_product_code" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                        <l class="fa fa-refresh"></l>
                                                    </a>
                                                </label>
                                                <select tabindex="1" autofocus name="product_code" class="inputs_up form-control" id="product_code"  data-rule-required="true" data-msg-required="Please Enter Product Code" >
                                                    <option value="">Code</option>
                                                    @foreach ($products as $product)
                                                        <option value='{{ $product->pro_p_code }}'>{{ $product->pro_p_code }}</option>
                                                    @endforeach

                                                </select>
                                                <span id="demo1" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>

                                        <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label class="required">
                                                    Product Name
                                                    <a tabindex="-1" href="{{ route('add_product') }}" class="add_btn" target="_blank" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                        <l class="fa fa-plus"></l>
                                                    </a>
                                                    <a tabindex="-1" class="add_btn" id="refresh_product_name" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                        <l class="fa fa-refresh"></l>
                                                    </a>
                                                </label>
                                                <select tabindex="2" name="product_name" class="inputs_up form-control" id="product_name"  data-rule-required="true" data-msg-required="Please Enter Product Name" >
                                                    <option value="">Product</option>
                                                    @foreach ($products as $product)
                                                        <option value='{{ $product->pro_title }}' data-product-code="{{ $product->pro_p_code }}">{{ $product->pro_title }}</option>
                                                    @endforeach
                                                </select>
                                                <span id="demo1" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>

                                        <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label >
                                                    Publisher Title
                                                    <a tabindex="-1" href="{{ route('add_publisher') }}" class="add_btn" target="_blank" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                        <l class="fa fa-plus"></l>
                                                    </a>
                                                    <a tabindex="-1" class="add_btn" id="refresh_publisher" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                        <l class="fa fa-refresh"></l>
                                                    </a>
                                                </label>
                                                <select tabindex="3" name="publisher_name" class="inputs_up form-control" id="publisher_name" autofocus>
                                                    <option value="">Select Publisher</option>
                                                    @foreach($publishers as $publisher)
                                                        <option value="{{$publisher->pub_id}}">{{$publisher->pub_title}}</option>
                                                    @endforeach

                                                </select>
                                                <span id="demo1" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>

                                        <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label >
                                                    Topic Title
                                                    <a tabindex="-1" href="{{ route('add_topic') }}" class="add_btn" target="_blank" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                        <l class="fa fa-plus"></l>
                                                    </a>
                                                    <a tabindex="-1" class="add_btn" id="refresh_topic" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                        <l class="fa fa-refresh"></l>
                                                    </a>
                                                </label>
                                                <select tabindex="4" name="topic_name" class="inputs_up form-control" id="topic_name" autofocus>
                                                    <option value="">Select Topic</option>
                                                    @foreach($topics as $topic)
                                                        <option value="{{$topic->top_id}}">{{$topic->top_title}}</option>
                                                    @endforeach

                                                </select>
                                                <span id="demo1" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>

                                        <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label >Class Title
                                                    <a tabindex="-1" href="{{ route('add_class') }}" class="add_btn" target="_blank" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                        <l class="fa fa-plus"></l>
                                                    </a>
                                                    <a tabindex="-1" class="add_btn" id="refresh_class" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                        <l class="fa fa-refresh"></l>
                                                    </a>
                                                </label>
                                                <select tabindex="5" name="class_name" class="inputs_up form-control" id="class_name" autofocus>
                                                    <option value="">Select Class</option>
                                                    @foreach($classes as $class)
                                                        <option value="{{$class->cla_id}}" >{{$class->cla_title}}</option>
                                                    @endforeach

                                                </select>
                                                <span id="demo1" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>

                                        <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label >Currency Title
                                                    <a tabindex="-1" href="{{ route('add_currency') }}" class="add_btn" target="_blank" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                        <l class="fa fa-plus"></l>
                                                    </a>
                                                    <a tabindex="-1" class="add_btn" id="refresh_currency" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                        <l class="fa fa-refresh"></l>
                                                    </a>
                                                </label>
                                                <select tabindex="6" name="currency_name" class="inputs_up form-control" id="currency_name" autofocus>
                                                    <option value="">Select Currency</option>
                                                    @foreach($currencies as $currency)
                                                        <option value="{{$currency->cur_id}}" >{{$currency->cur_title}}</option>
                                                    @endforeach

                                                </select>
                                                <span id="demo1" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>

                                        <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label >Language Title
                                                    <a tabindex="-1" href="{{ route('add_language') }}" class="add_btn" target="_blank" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                        <l class="fa fa-plus"></l>
                                                    </a>
                                                    <a tabindex="-1" class="add_btn" id="refresh_language" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                        <l class="fa fa-refresh"></l>
                                                    </a>
                                                </label>
                                                <select tabindex="7" name="language_name" class="inputs_up form-control" id="language_name" autofocus>
                                                    <option value="">Select Language</option>
                                                    @foreach($languages as $language)
                                                        <option value="{{$language->lan_id}}" >{{$language->lan_title}}</option>
                                                    @endforeach

                                                </select>
                                                <span id="demo1" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>

                                        <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label >ImPrint Title
                                                    <a tabindex="-1" href="{{ route('add_imPrint') }}" class="add_btn" target="_blank" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                        <l class="fa fa-plus"></l>
                                                    </a>
                                                    <a tabindex="-1" class="add_btn" id="refresh_imprint" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                        <l class="fa fa-refresh"></l>
                                                    </a>
                                                </label>
                                                <select tabindex="8" name="imprint_name" class="inputs_up form-control" id="imprint_name" autofocus>
                                                    <option value="">Select ImPrint</option>
                                                    @foreach($imprints as $imprint)
                                                        <option value="{{$imprint->imp_id}}" >{{$imprint->imp_title}}</option>
                                                    @endforeach

                                                </select>
                                                <span id="demo1" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>

                                        <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label >Illustrated Title
                                                    <a tabindex="-1" href="{{ route('add_illustrated') }}" class="add_btn" target="_blank" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                        <l class="fa fa-plus"></l>
                                                    </a>
                                                    <a tabindex="-1" class="add_btn" id="refresh_illustrated" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                        <l class="fa fa-refresh"></l>
                                                    </a>
                                                </label>
                                                <select tabindex="9" name="illustrated_name" class="inputs_up form-control" id="illustrated_name" autofocus>
                                                    <option value="">Select Illustrated</option>
                                                    @foreach($illustrateds as $illustrated)
                                                        <option value="{{$illustrated->ill_id}}" >{{$illustrated->ill_title}}</option>
                                                    @endforeach

                                                </select>
                                                <span id="demo1" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>

                                        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label>Author
                                                    <a tabindex="-1" href="{{ route('add_author') }}" class="add_btn" target="_blank" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                        <l class="fa fa-plus"></l>
                                                    </a>
                                                    <a tabindex="-1" class="add_btn" id="refresh_author" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                        <l class="fa fa-refresh"></l>
                                                    </a>
                                                </label>
                                                <select tabindex="10" name="author[]" class="inputs_up form-control" id="author" multiple>
                                                    @foreach($authors as $author)
                                                        <option
                                                            value="{{$author->aut_id}}">{{$author->aut_title}}</option>
                                                    @endforeach
                                                </select>
                                                <span id="product_reporting_group_error_msg" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>

                                        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label>Genre
                                                    <a tabindex="-1" href="{{ route('add_genre') }}" class="add_btn" target="_blank" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                        <l class="fa fa-plus"></l>
                                                    </a>
                                                    <a tabindex="-1" class="add_btn" id="refresh_genre" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                        <l class="fa fa-refresh"></l>
                                                    </a>
                                                </label>
                                                <select tabindex="11" name="genre[]" class="inputs_up form-control" id="genre" multiple>
                                                    @foreach($genres as $genre)
                                                        <option
                                                            value="{{$genre->gen_id}}">{{$genre->gen_title}}</option>
                                                    @endforeach
                                                </select>
                                                <span id="product_reporting_group_error_msg" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>

                                        <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label class="">
                                                    Remarks
                                                </label>
                                                <input tabindex="12" name="remarks" id="remarks" class="inputs_up form-control" placeholder="Remarks">
                                                <span id="demo4" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                                    <button tabindex="13" type="reset" name="cancel" id="cancel" class="cancel_button form-control">
                                        <i class="fa fa-eraser"></i> Cancel
                                    </button>
                                    <button tabindex="14" type="submit" name="save" id="save" class="save_button form-control"
                                    >
                                        <i class="fa fa-floppy-o"></i> Save
                                    </button>
                                </div>
                            </div>
                        </div> <!-- left column ends here -->
                    </div> <!--  main row ends here -->
                </form>
            </div> <!-- white column form ends here -->
        </div><!-- col end -->
    </div><!-- row end -->

@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let product_code = document.getElementById("product_code"),
            product_name = document.getElementById("product_name"),
            validateInputIdArray = [
                product_code.id,
                product_name.id,
            ];
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
    {{-- end of required input validation --}}
    <script>

        $(window).keydown(function (event) {
            if (event.keyCode == 13) {
            event.preventDefault();
            return false;
            }
        });

        jQuery("#refresh_product_code").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "refresh_products_code",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#product_code").html(" ");
                    jQuery("#product_code").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });

        jQuery("#refresh_product_code").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "refresh_products_name",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#product_name").html(" ");
                    jQuery("#product_name").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });

        jQuery("#refresh_product_name").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "refresh_products_code",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#product_code").html(" ");
                    jQuery("#product_code").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });

        jQuery("#refresh_product_name").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "refresh_products_name",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#product_name").html(" ");
                    jQuery("#product_name").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });

        jQuery("#refresh_publisher").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "refresh_publisher",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#publisher_name").html(" ");
                    jQuery("#publisher_name").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });


        jQuery("#refresh_topic").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "refresh_topic",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#topic_name").html(" ");
                    jQuery("#topic_name").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });

        jQuery("#refresh_class").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "refresh_class",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#class_name").html(" ");
                    jQuery("#class_name").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });

        jQuery("#refresh_currency").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "refresh_currency",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#currency_name").html(" ");
                    jQuery("#currency_name").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });

        jQuery("#refresh_language").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "refresh_language",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#language_name").html(" ");
                    jQuery("#language_name").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });

        jQuery("#refresh_imprint").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "refresh_imprint",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#imprint_name").html(" ");
                    jQuery("#imprint_name").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });

        jQuery("#refresh_illustrated").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "refresh_illustrated",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#illustrated_name").html(" ");
                    jQuery("#illustrated_name").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });

        jQuery("#refresh_author").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "refresh_author",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#author").html(" ");
                    jQuery("#author").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });

        jQuery("#refresh_genre").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "refresh_genre",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#genre").html(" ");
                    jQuery("#genre").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });

    </script>

    <script>

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


    </script>


    <script>

        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#product_code").select2();
            jQuery("#product_name").select2();

            jQuery("#publisher_name").select2();
            jQuery("#topic_name").select2();
            jQuery("#class_name").select2();
            jQuery("#currency_name").select2();
            jQuery("#language_name").select2();
            jQuery("#imprint_name").select2();
            jQuery("#illustrated_name").select2();
            jQuery("#author").select2();
            jQuery("#genre").select2();

        });
    </script>

@endsection


