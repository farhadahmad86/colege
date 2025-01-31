<div class="invoice_col_bx"><!-- invoice column box start -->
    <div class=" invoice_col_ttl">
        <!-- invoice column title start -->
        <a data-container="body" data-toggle="popover"
           data-trigger="hover"
           data-placement="bottom" data-html="true"
           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.invoice.party_reference.description')}}</p>
                                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.invoice.party_reference.benefits')}}</p>">
            <i class="fa fa-info-circle"></i>
        </a>
        Party Reference
    </div><!-- invoice column title end -->
    <div class="invoice_col_input">
        <!-- invoice column input start -->
        <input tabindex="{{$tabindex}}" type="text" name="{{$name}}"
               class="inputs_up form-control" id="{{$id}}"
               placeholder="Party Reference"
               onkeydown="return not_plus_minus(event)">
    </div><!-- invoice column input end -->
</div><!-- invoice column box end -->
