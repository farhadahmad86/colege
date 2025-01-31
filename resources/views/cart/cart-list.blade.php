@extends('extend_index')

@section('content')
    <link rel="stylesheet" href="{{asset('public/css/toaster.css')}}">
    <div id="snackbar">Some text some message..</div>
    <style>
        .product-thumb .thumb-img {
            width: 50px;
            padding-right: 10px;
        }

        .checkout-table .input-group {
            margin-bottom: 0;
        }
    </style>

    <div class="row">


        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">


                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Card List</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->
                <form method="post" action="{{route('checkout')}}">
                    @csrf
                    <div class="table-responsive checkout-table" id="printTable">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th scope="col" class="tbl_txt_4">#</th>
                                <th scope="col" class="tbl_txt_60">Product</th>
                                <th scope="col" class="tbl_txt_5">UOM</th>
                                <th scope="col" class="tbl_txt_7">Price</th>
                                <th scope="col" class="tbl_txt_15">Quantity</th>
                                <th scope="col" class="tbl_txt_10">Subtotal</th>
                                <th scope="col" class="tbl_txt_4">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $total = 0; $total_qty=0; $sr=0; $grand_total = 0;@endphp
                            {{--                        @if(session('cart'))--}}
                            {{--                            @foreach(session('cart') as $id => $details)--}}
                            @foreach($cart as $details)
                                @php $total += $details->atc_price * $details->atc_qty;
                                 $total_qty = $total_qty + $details->atc_qty ;
                                 $grand_total = 0;
                                 $grand_total +=$total;
                                $sr = $sr +1;
                                @endphp
                                <tr data-id="{{ $details->atc_pro_code }}">

                                    <th scope="row" class="text-center">
                                        {{$sr}}
                                    </th>
                                    <td data-th="Product">
                                        <div class="product-thumb d-flex">
                                            <div class="hidden-xs thumb-img">
                                                <img src="{{ $details->image }}" class="img-responsive rounded"/>
                                            </div>
                                            <div class="product-title my-auto">
                                                <h6 class="nomargin">{{ $details->atc_pro_name }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $details->atc_uom }}</td>
                                    <td data-price="{{ $details->atc_price }}">
                                        {{ $details->atc_price }}
                                    </td>

                                    <td data-th="Quantity">
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <button type="button"
                                                        onclick="decrement({{ $details->atc_pro_code }},{{ $details->atc_price }},{{$details->sale_qty}},{{$details->limited}},{{$details->percentage}})"
                                                        class="quantity-left-minus btn btn-light me-md-2 btn-number" data-type="minus"
                                                        data-field="">
                                                    <i class="fa fa-minus" aria-hidden="true"></i>
                                                </button>
                                            </span>
                                            <input type="text" id="quantity{{ $details->atc_pro_code }}" name="quantity" class="form-control input-number text-center" value="{{ $details->atc_qty }}"
                                                   min="1"
                                                   onfocusout="changeQuantity({{ $details->atc_pro_code }},{{ $details->atc_price }},{{$details->sale_qty}},{{$details->limited}},{{$details->percentage}})">
                                            <span class="input-group-btn">
                                                <button type="button"
                                                        onclick="increment({{ $details->atc_pro_code }},{{ $details->atc_price }},{{$details->sale_qty}},{{$details->limited}},{{$details->percentage}})"
                                                        class="quantity-right-plus btn btn-light btn-number"
                                                        data-type="plus"
                                                        data-field="">
                                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </td>
                                    <td data-th="Subtotal" id="subtotal{{ $details->atc_pro_code }}">
                                        {{ $details->atc_price * $details->atc_qty }}
                                    </td>
                                    <input type="hidden" name="total[]" id="total{{$details->atc_pro_code}}" value="{{ $details->atc_price * $details->atc_qty }}">
                                    <input type="hidden" name="pro_code[]" id="pro_code{{$details->atc_pro_code}}" value="{{ $details->atc_pro_code }}">
                                    <td class="actions hide_column tbl_srl_4  text-center" data-th="">
                                        <a href="{{route('remove_from_cart',['id' => $details->atc_pro_code])}}" title="delete" class="delete" onclick="return confirm('Are you sure you want to delete this ' +
                                         'item')"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th colspan="5" class="text-right">Total</th>
                                <th colspan="2"><input type="hidden" name="total_price" id="total_price" value="{{$grand_total}}"><span id="grand_total">{{$grand_total}}</span></th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-9 col-md-9 col-sm-12">
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 form_controls">

                            <a href="{{ url('/product_cart') }}" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping</a>
                            {{--                                <a href="{{url('/product_cart')}}" class="save_button form-control">--}}
                            {{--                                    Continue To Process--}}
                            {{--                                </a>--}}
                            <button type="submit" name="save" id="save" class="save_button form-control">
                                <i class="fa fa-floppy-o"></i> CheckOut
                            </button>
                        </div>
                    </div>

                </form>

            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

@endsection
@section('scripts')
    <script>
        function grand_total() {
            let grand_total = 0;
            var pro_code;
            $('input[name="pro_code[]"]').each(function (pro_index) {
                pro_code = $(this).val();
                let total_price = jQuery("#total" + pro_code).val();
                grand_total = +total_price + +grand_total;
                console.log(pro_code, ' ', total_price, ' ', grand_total);
                $('#total_price').val(grand_total);
                $('#grand_total').html(grand_total);
            });

        }

        function increment(code, price, sale_qty, status, qty_per) {
            var quantity = parseInt($('#quantity' + code).val());
            let new_qty = quantity + 1;
            if (status == 0) {
                var online_qty = sale_qty * qty_per / 100;
                if (online_qty >= new_qty) {
                    $('#quantity' + code).val(new_qty);
                    $('#subtotal' + code).html(new_qty * price);
                    $('#total' + code).val(new_qty * price);
                    change_qty(code, new_qty)
                } else {
                    $('#quantity' + code).val(online_qty);
                    $('#subtotal' + code).html(online_qty * price);
                    $('#total' + code).html(online_qty * price);
                    change_qty(code, online_qty)
                }
            } else {
                $('#quantity' + code).val(new_qty);
                $('#subtotal' + code).html(new_qty * price);
                $('#total' + code).val(new_qty * price);
                change_qty(code, new_qty)
            }
            grand_total();
        }

        function decrement(code, price, sale_qty, status, qty_per) {
            var quantity = parseInt($('#quantity' + code).val());
            if (quantity > 0) {
                let new_qty = quantity - 1;
                if (status == 0) {
                    var online_qty = sale_qty * qty_per / 100;
                    if (online_qty >= new_qty) {
                        $('#quantity' + code).val(new_qty);
                        $('#subtotal' + code).html(new_qty * price);
                        $('#total' + code).val(new_qty * price);
                        change_qty(code, new_qty)
                    } else {
                        $('#quantity' + code).val(online_qty);
                        $('#subtotal' + code).html(online_qty * price);
                        $('#total' + code).html(online_qty * price);
                        change_qty(code, online_qty)
                    }
                } else {
                    $('#quantity' + code).val(new_qty);
                    $('#subtotal' + code).html(new_qty * price);
                    $('#total' + code).val(new_qty * price);
                    change_qty(code, new_qty)
                }

            }
            grand_total();
        }

        function changeQuantity(code, price, sale_qty, status, qty_per) {
            var new_qty = parseInt($('#quantity' + code).val());

            if (status == 0) {
                var online_qty = sale_qty * qty_per / 100;
                if (online_qty >= new_qty) {
                    $('#subtotal' + code).html(new_qty * price);
                    $('#total' + code).val(new_qty * price);
                    change_qty(code, new_qty)
                } else {
                    $('#quantity' + code).val(online_qty);
                    $('#subtotal' + code).html(online_qty * price);
                    $('#total' + code).html(online_qty * price);
                    change_qty(code, online_qty)
                }
            } else {
                $('#subtotal' + code).html(new_qty * price);
                $('#total' + code).val(new_qty * price);
                change_qty(code, new_qty)
            }


            $('#subtotal' + code).html(new_qty * price);
            $('#total' + code).val(new_qty * price);
            change_qty(code, new_qty);
            grand_total();
        }

        function change_qty(code, qty) {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: '{{ route('update.cart') }}',
                method: "patch",
                data: {code: code, qty: qty},
                cache: false,
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    if (data.response == 'success') {
                        var x = document.getElementById("snackbar");
                        x.className = "show";
                        x.innerHTML = data.success;
                        setTimeout(function () {
                            x.className = x.className.replace("show", "");
                        }, 3000);
                    } else {
                        $('#quantity' + code).val(qty);
                        var x = document.getElementById("snackbar");
                        x.className = "show";
                        x.innerHTML = data.success;
                        setTimeout(function () {
                            x.className = x.className.replace("show", "");
                        }, 3000);
                    }
                    grand_total();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // alert(jqXHR.responseText);
                    // alert(errorThrown);s
                }
            });
        }


    </script>
@stop

