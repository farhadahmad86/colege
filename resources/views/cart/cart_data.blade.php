@foreach($datas as $product)
    @if($product->pro_stock_status == 1)
        <div class="col-lg-2 mb-3">
            <div class="card" >
                <div class="img-box" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <img class="img-thumbnail view" data-name="{{$product->pro_title}}" data-image="{{$product->pro_image}}" data-code="{{$product->pro_p_code}}"
                         data-description="{{$product->pro_remarks}}" data-UOM="{{$product->unit_title}}" src="{{ $product->pro_image }}" alt="...">
                </div>
                <div class="card-body">
                    <h6 class="card-title" data-toggle="tooltip" data-placement="top" title="{{ $product->pro_title }}">{{ $product->pro_title }}</h6>
                    <p class="view" data-name="{{$product->pro_title}}" data-code="{{$product->pro_p_code}}" data-image="{{$product->pro_image}}"
                       data-description="{{$product->pro_remarks}}" data-UOM="{{$product->unit_title}}">{{ $product->pro_remarks }}</p>
                    <p>Price: <strong>{{ $product->pro_sale_price }}</strong> </p>
                    <p>Quantity: <strong>Unlimited</strong></p>
                    <button onclick="add_to_card({{ $product->pro_p_code }})" class="btn btn-primary btn-add-to-cart">Add to Cart</button>
                </div>
            </div>
        </div>
    @endif
    @if($product->pro_stock_status == 0)
        @php
            $online_qty=0;
            $online_qty = $product->pro_qty_for_sale * $product->pro_hold_qty_per / 100;
        @endphp
        @if($online_qty > 0)
            <div class="col-lg-2 mb-3">
                <div class="card" >
                    <div class="img-box" >
                        <img src="{{ $product->pro_image }}" class="img-thumbnail view" data-name="{{$product->pro_title}}" data-code="{{$product->pro_p_code}}" data-image="{{$product->pro_image}}"
                             data-description="{{$product->pro_remarks}}" data-UOM="{{$product->unit_title}}" alt="...">
                    </div>
                    <div class="card-body">
                        <h6 class="card-title" data-toggle="tooltip" data-placement="top" title="{{ $product->pro_title }}">{{ $product->pro_title }}</h6>
                        <p class="view" data-name="{{$product->pro_title}}" data-code="{{$product->pro_p_code}}" data-image="{{$product->pro_image}}"
                           data-description="{{$product->pro_remarks}}" data-UOM="{{$product->unit_title}}">{{ $product->pro_remarks }}</p>
                        <p>Price: <strong>{{ $product->pro_sale_price }}</strong> </p>
                        <p>Quantity: <strong>{{ $online_qty }}</strong></p>
                        <button type="button" class="btn btn-primary btn-add-to-cart"onclick="add_to_card({{ $product->pro_p_code }})" >Add to cart</button>

                    </div>
                </div>
            </div>
        @endif
    @endif
@endforeach
