<div class="invoice_col_bx"><!-- invoice column box start -->
    <div class=" invoice_col_ttl">
        <!-- invoice column title start -->
        <a
            data-container="body" data-toggle="popover"
            data-trigger="hover"
            data-placement="bottom" data-html="true"
            data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.invoice.sale_man.description')}}</p>
                                                        <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.invoice.sale_man.benefits')}}</p>
                                                        <h6>Example</h6><p>{{config('fields_info.about_form_fields.invoice.sale_man.example')}}</p>">

            <i class="fa fa-info-circle"></i>
        </a>
        Sale Man
    </div><!-- invoice column title end -->
    <div class="invoice_col_input">
        <!-- invoice column input start -->

            <x-add-refresh-button href="{{ url('add_employee') }}" id="refresh_sale_person"/>

        <select tabindex="3" name="sale_person"
                class="inputs_up form-control js-example-basic-multiple"
                id="sale_person"
                onfocus="this.select2('open')">

            <option value="0">Select Person</option>
            @foreach($sale_persons as $sale_person)
                <option
                    value="{{$sale_person->user_id}}">{{$sale_person->user_name}}</option>
            @endforeach
        </select>
    </div><!-- invoice column input end -->
</div><!-- invoice column box end -->

<script>
    jQuery("#refresh_sale_person").click(function () {
        // alert('warehouse');
        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });

        jQuery.ajax({
            url: "refresh_sale_person",
            data: {},
            type: "POST",
            cache: false,
            dataType: 'json',
            success: function (data) {

                jQuery("#sale_person").html(" ");
                jQuery("#sale_person").append(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // alert(jqXHR.responseText);
                // alert(errorThrown);s
            }
        });
    });
</script>
