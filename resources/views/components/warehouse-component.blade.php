<div class="invoice_col_bx">
    <!-- invoice column box start -->
    <div class="required invoice_col_ttl">
        <!-- invoice column title start -->
        <a data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.general_registration.warehouse.warehouse_title.description') }}</p>
                                                <h6>Benefits</h6><p>{{ config('fields_info.about_form_fields.general_registration.warehouse.warehouse_title.benefits') }}</p>
                                                <h6>Example</h6><p>{{ config('fields_info.about_form_fields.general_registration.warehouse.warehouse_title.example') }}</p>">
            <i class="fa fa-info-circle"></i>
        </a>

        {{ $title }}
    </div><!-- invoice column title end -->
    <div class="invoice_col_input refresh-addition">
        <!-- invoice column input start -->

        <div class="invoice_col_short">
            <!-- invoice column short start -->
            <a href="{{ url('add_warehouse') }}" class="col_short_btn btn btn-sm btn-info add" target="_blank" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true"
               data-content="{{ config('fields_info.about_form_fields.add.description') }}">
                <l class="fa fa-plus"></l>
            </a>
            <a id="refresh_warehouse" class="col_short_btn btn btn-sm btn-info refresh {{ $class }}" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true"
               data-content="{{ config('fields_info.about_form_fields.refresh.description') }}" onclick="refresh_warehouse('{{ $id }}')">
                <l class="fa fa-refresh"></l>
            </a>
        </div><!-- invoice column short end -->
        <select tabindex="{{ $tabindex }}" name="{{ $name }}" class="inputs_up form-control js-example-basic-multiple" id="{{ $id }}">
            @foreach ($warehouses as $warehouse)
            <option value="{{ $warehouse->wh_id }}" {{ $warehouse->wh_id == 1 ? 'selected' : '' }}>
                {{ $warehouse->wh_title }}</option>
            @endforeach
        </select>
    </div><!-- invoice column input end -->
</div><!-- invoice column box end -->

<script>
    jQuery(document).ready(function() {
        var id = "{!! $id !!}";
        jQuery("#" + id).select2();
    });
    var cls = "{!! $class !!}";

    // jQuery(".refresh_warehouse").click(function() {
function refresh_warehouse(id){

        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });

        jQuery.ajax({
            url: "refresh_warehouse"
            , data: {}
            , type: "POST"
            , cache: false
            , dataType: 'json'
            , success: function(data) {

                jQuery("#" + id).html(" ");
                jQuery("#" + id).append(data);
            }
            , error: function(jqXHR, textStatus, errorThrown) {
                // alert(jqXHR.responseText);
                // alert(errorThrown);s
            }
        });
    }
    // });

</script>
