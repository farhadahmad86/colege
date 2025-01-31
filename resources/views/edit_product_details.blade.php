
@extends('extend_index')

@section('content')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Edit Product Details</h4>
                        </div>
                    </div>
                </div><!-- form header close -->

                <form name="f1" class="f1" id="f1" action="{{ route('update_product_details') }}" onsubmit="return checkForm()" method="post">
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
                                                </label>
                                                {{--                                                {{ $class->cla_id == old('class_name') ? 'selected="selected"' : '' }}--}}
                                                <select name="product_code" class="inputs_up form-control" id="product_code"  data-rule-required="true" data-msg-required="Please Enter Product Code" >
                                                    <option value="">Code</option>
                                                    @foreach($products as $product)
                                                        <option value="{{$product->pro_p_code}}"  {{ $product->pro_p_code == $request->code_id ? 'selected="selected"' : '' }}>{{$product->pro_p_code}}</option>
                                                    @endforeach
                                                </select>
                                                <span id="demo1" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>

                                        <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label class="required">
                                                    Product Name
                                                </label>
                                                <select name="product_name" class="inputs_up form-control" id="product_name"  data-rule-required="true" data-msg-required="Please Enter Product Name" >
                                                    <option value="">Product</option>
                                                    @foreach($products as $product)
                                                        <option value="{{$product->pro_title}}" data-product-code="{{ $product->pro_p_code }}" {{ $product->pro_title == $request->product_title ? 'selected="selected"' : '' }}>{{$product->pro_title}}</option>
                                                    @endforeach
                                                </select>
                                                <span id="demo1" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>

                                        <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label >
                                                    Publisher Title
                                                </label>
                                                <select name="publisher_name" class="inputs_up form-control" id="publisher_name" autofocus>
                                                    <option value="">Select Publisher</option>
                                                    @foreach($publishers as $publisher)
                                                        <option value="{{$publisher->pub_id}}"  {{ $publisher->pub_id == $request->publisher_id ? 'selected="selected"' : '' }}>{{$publisher->pub_title}}</option>
                                                    @endforeach

                                                </select>
                                                <span id="demo1" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>

                                        <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label >
                                                    Topic Title {{$request->topic_id}}
                                                </label>
                                                <select name="topic_name" class="inputs_up form-control" id="topic_name" autofocus>
                                                    <option value="">Select Topic</option>
                                                    @foreach($topics as $topic)
                                                        <option value="{{$topic->top_id}}"  {{ $topic->top_id == $request->topic_id ? 'selected="selected"' : '' }}>{{$topic->top_title}}</option>
                                                    @endforeach

                                                </select>
                                                <span id="demo1" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>

                                        <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label >Class Title
                                                </label>
                                                <select name="class_name" class="inputs_up form-control" id="class_name" autofocus>
                                                    <option value="">Select Class</option>
                                                    @foreach($classes as $class)
                                                        <option value="{{$class->cla_id}}" {{ $class->cla_id == $request->class_id ? 'selected="selected"' : '' }}>{{$class->cla_title}}</option>
                                                    @endforeach

                                                </select>
                                                <span id="demo1" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>

                                        <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label >Currency Title
                                                </label>
                                                <select name="currency_name" class="inputs_up form-control" id="currency_name" autofocus>
                                                    <option value="">Select Currency</option>
                                                    @foreach($currencies as $currency)
                                                        <option value="{{$currency->cur_id}}"  {{ $currency->cur_id == $request->currency_id ? 'selected="selected"' : '' }} >{{$currency->cur_title}}</option>
                                                    @endforeach

                                                </select>
                                                <span id="demo1" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>

                                        <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label >Language Title
                                                </label>
                                                <select name="language_name" class="inputs_up form-control" id="language_name" autofocus>
                                                    <option value="">Select Language</option>
                                                    @foreach($languages as $language)
                                                        <option value="{{$language->lan_id}}"  {{ $language->lan_id == $request->language_id ? 'selected="selected"' : '' }}>{{$language->lan_title}}</option>
                                                    @endforeach

                                                </select>
                                                <span id="demo1" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>

                                        <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label >ImPrint Title
                                                </label>
                                                <select name="imprint_name" class="inputs_up form-control" id="imprint_name" autofocus>
                                                    <option value="">Select ImPrint</option>
                                                    @foreach($imprints as $imprint)
                                                        <option value="{{$imprint->imp_id}}"   {{ $imprint->imp_id == $request->imprint_id ? 'selected="selected"' : '' }}>{{$imprint->imp_title}}</option>
                                                    @endforeach

                                                </select>
                                                <span id="demo1" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>

                                        <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label >Illustrated Title
                                                </label>
                                                <select name="illustrated_name" class="inputs_up form-control" id="illustrated_name" autofocus>
                                                    <option value="">Select Illustrated</option>
                                                    @foreach($illustrateds as $illustrated)
                                                        <option value="{{$illustrated->ill_id}}"  {{ $illustrated->ill_id == $request->illustrated_id ? 'selected="selected"' : '' }} >{{$illustrated->ill_title}}</option>
                                                    @endforeach

                                                </select>
                                                <span id="demo1" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>

                                        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label>Author
                                                </label>
                                                <select name="author[]" class="inputs_up form-control" id="author" multiple>
                                                    @php
                                                        $author_ids = explode(',', $request->author_title);
                                                    @endphp
                                                    @foreach($authors as $author)
                                                        <option
                                                            value="{{$author->aut_id}}"  {{ in_array($author->aut_id, $author_ids) ? 'selected="selected"' : '' }}>{{$author->aut_title}}</option>
                                                    @endforeach
                                                </select>
                                                <span id="product_reporting_group_error_msg" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>

                                        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label>Genre
                                                </label>
                                                <select name="genre[]" class="inputs_up form-control" id="genre" multiple>
                                                    @php
                                                        $genre_ids = explode(',', $request->genre_title);
                                                    @endphp
                                                    @foreach($genres as $genre)
                                                        <option
                                                            value="{{$genre->gen_id}}" {{ in_array($genre->gen_id, $genre_ids) ? 'selected="selected"' : '' }}>{{$genre->gen_title}}</option>
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
                                                <input name="remarks" id="remarks" class="inputs_up form-control" value="{{$request->remarks}}" placeholder="Remarks">
                                                <span id="demo4" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>

                                        <input  type="hidden" name="pd_id" id="pd_id" class="inputs_up form-control" value="{{$request->pd_id}}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                                    <button type="button" name="cancel" id="cancel" class="cancel_button form-control">
                                        <i class="fa fa-eraser"></i> Cancel
                                    </button>
                                    <button type="submit" name="save" id="save" class="save_button form-control"
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

    <script type="text/javascript">

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

