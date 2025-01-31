@extends('extend_index')
@section('content')
    <link rel="stylesheet" href="{{asset('public/css/toaster.css')}}">
    <div id="snackbar">Some text some message..</div>
    <style>
        .modal-content .close {
            text-align: right;
            position: absolute;
            top: 0px;
            right: 10px;
            z-index: 1;
        }

        .modal-content .left-col {
            padding-left: 3%;
        }

        .modal-content .left-col p {
            margin-bottom: 10px;
        }

        .product-list .cart-blade {

        }

        .product-list .cart-blade .card .card-body {
            padding: 0.8rem !important;
        }

        .product-list .cart-blade .card .card-body h6 {
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .product-list .cart-blade .card .card-body .card-title, .product-list .cart-blade .card .card-body p {
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 1; /* number of lines to show */
            line-clamp: 1;
            -webkit-box-orient: vertical;
            margin-bottom: 5px !important;
        }

        .product-list .cart-blade .card .card-body p {
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        .product-list .cart-blade .card .img-box .img-thumbnail {
            height: 160px;
            max-height: 160px;
            width: 100%;
        }

        .product-list .cart-blade .card .card-body .btn-add-to-cart {
            margin: 0 auto;
            display: block;
        }

        .cart-blade .btn-primary {
            background: rgba(48, 90, 114, 1);
        }

        .cart-blade .btn-primary:hover {
            background: rgba(48, 122, 165, 1);
            border-color: rgba(48, 90, 114, 1);
            color: #fff;
        }
    </style>
    <div class="row product-list">
        <div class="col-lg-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Product Card</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

                <div class="search_form">
                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">


                            <form class="prnt_lst_frm" action="{{ route('product_cart') }}" name="form1" id="form1" method="post">
                                @csrf
                                <div class="row">

                                    <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>
                                                All Column Search
                                            </label>
                                            <input tabindex="1" autofocus type="search" list="browsers" class="inputs_up form-control all_clm_srch" name="search" id="search" placeholder="Search ..."
                                                   value="{{ isset($search) ? $search : '' }}" autocomplete="off">
                                            <datalist id="browsers">
                                                @foreach($product as $value)
                                                    <option value="{{$value}}">
                                                @endforeach
                                            </datalist>
                                        </div>
                                    </div> <!-- left column ends here -->

                                    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 srch_brdr_left">
                                        <div class="row">

                                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Group
                                                    </label>
                                                    <select tabindex="4" class="inputs_up form-control cstm_clm_srch" name="group" id="group">
                                                        <option value="">Select Group</option>
                                                        @foreach($groups as $group)
                                                            <option value="{{$group->grp_id}}" {{ $group->grp_id == $search_group ? 'selected="selected"' : '' }}>{{$group->grp_title}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Category
                                                    </label>
                                                    <select tabindex="5" class="inputs_up form-control cstm_clm_srch" name="category" id="category">
                                                        <option value="">Select Category</option>
                                                        @foreach($categories as $category)
                                                            <option
                                                                value="{{$category->cat_id}}" {{ $category->cat_id == $search_category ? 'selected="selected"' : '' }}>{{$category->cat_title}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label>
                                                        Brand
                                                    </label>
                                                    <select tabindex="6" class="inputs_up form-control cstm_clm_srch" name="product_group" id="product_group">
                                                        <option value="">Select Brand</option>
                                                        @foreach($brands as $brand)
                                                            <option
                                                                value="{{$brand->br_id}}" {{ $brand->br_id == $search_brand ? 'selected="selected"' : ''
                                                                }}>{{$brand->br_title}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form_controls text-center">


                                            <button tabindex="7" type="button" type="button" name="cancel" id="cancel" class="cancel_button form-control">
                                                <i class="fa fa-trash"></i> Clear
                                            </button>
                                            <button tabindex="8" type="submit" name="filter_search" id="filter_search" class="save_button form-control" value="">
                                                <i class="fa fa-search"></i> Search
                                            </button>

                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>

                                        </div>
                                    </div>

                                </div>
                            </form>

                        </div>

                    </div>
                </div><!-- search form end -->
                <div class="row cart-blade" id="product-data">
                    @include('cart.cart_data')
                </div>

            </div> <!-- white column form ends here -->


        </div><!-- col end -->
        <div class="ajax-load text-center" style="display: none">
            <p><img src="{{asset('loader_image/Spinner-2.gif')}}" alt="">Loading More Product</p>
        </div>

    </div><!-- row end -->

    <!-- Large modal -->

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content base_clr">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="modal-body">
                    <div id="table_body"></div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#group").select2();
            jQuery("#category").select2();
            jQuery("#brand").select2();

        });
        const add_to_card = (id) => {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "add-to-cart/" + id,
                // data: {id:id},
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function (data) {
                    var size = Object.keys(data.cart).length;
                    $('.cart_no').html(size);
                    let total_amount = 0;
                    let htmlData = '';
                    $.each(data.cart, function (index, value) {
                        total_amount = +total_amount + +(value.atc_qty * value.atc_price);
                        htmlData += `<div class="row cart-detail">
                                        <div class="col-lg-4 col-sm-4 col-4 cart-detail-img">
                                            <img src="${value.atc_image}"/>
                                        </div>
                                        <div class="col-lg-8 col-sm-8 col-8 cart-detail-product">
                                            <p>${value.atc_pro_name}</p>
                                            <span class="price text-info"> RS-${value.atc_price}</span> <span class="count"> Quantity:${value.atc_qty}</span>
                                        </div>
                                    </div>
    `;

                        // note.insertAdjacentHTML('afterbegin',htmlData);
                    });

                    $('.operation').html(htmlData);
                    $('#total').html('RS-' + total_amount);

                    var x = document.getElementById("snackbar");
                    x.className = "show";
                    x.innerHTML = data.success;
                    setTimeout(function () {
                        x.className = x.className.replace("show", "");
                    }, 3000);

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // alert(jqXHR.responseText);
                    // alert(errorThrown);s
                }
            });
        }
    </script>

    <script>
        jQuery("#cancel").click(function () {

            $("#main_unit").select2().val(null).trigger("change");
            $("#main_unit > option").removeAttr('selected');

            $("#unit").select2().val(null).trigger("change");
            $("#unit > option").removeAttr('selected');

            $("#group").select2().val(null).trigger("change");
            $("#group > option").removeAttr('selected');

            $("#category").select2().val(null).trigger("change");
            $("#category > option").removeAttr('selected');

            $("#product_group").select2().val(null).trigger("change");
            $("#product_group > option").removeAttr('selected');

            $("#search").val('');
        });
        jQuery(".view").click(function () {

            // jQuery("#table_body").html("");

            var code = jQuery(this).attr("data-code");
            var name = jQuery(this).attr("data-name");
            var image = jQuery(this).attr("data-image");
            var description = jQuery(this).attr("data-description");
            var UOM = jQuery(this).attr("data-UOM");

            let contentHtml = `<div class="row">
                <div class="col-sm-12 col-md-6">
                    <img src="${image}" class="card-img-top rounded img-thumbnail" alt="...">
                </div>
                <div class="col-sm-12 col-md-6 left-col">
                    <p>Code : ${code}</p>
                    <p>Name : ${name}</p>
                    <p>Description : ${description}</p>
                    <p>UOM : ${UOM}</p>
                </div>
            </div>`;
            // let img= `<img src="${image}" class="card-img-top rounded img-thumbnail" alt="...">`;
            jQuery("#table_body").html(contentHtml);

            $('#myModal').modal({show: true});


        });
    </script>

    {{--    infinite scrol script start--}}
    <script>
        function loadMoreData(page) {
            var search = $('#search').val();
            $.ajax({
                url: '?page=' + page,
                type: 'get',
                data: {search: search},
                beforeSend: function () {
                    $('.ajax-load').show();
                }
            })
                .done(function (data) {
                    if (data.html == " ") {
                        $('.ajax-load').html("No more records found");
                        return;
                    }
                    $('.ajax-load').hide();
                    $('#product-data').append(data.html);
                })
                .fail(function (jqXHR, ajaxOption, thrownError) {
                    alert("server not responding...");
                })
        }

        var page = 1;
        $(window).scroll(function () {
            if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
                page++;
                loadMoreData(page)
            }
        })
    </script>
    {{--    infinite scrol script end--}}
@endsection
