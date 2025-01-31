<div class="invoice_col_bx"><!-- invoice column box start -->
    <div class="required invoice_col_ttl">
        <!-- invoice column title start -->
        Select Party {{$label_name}}
    </div><!-- invoice column title end -->
    <div class="invoice_col_input"><!-- invoice column input start -->

        <div class="invoice_col_short"><!-- invoice column short start -->
            <a href="{{ url('receivables_account_registration') }}"
               class="col_short_btn btn btn-sm btn-info" target="_blank">
                <l class="fa fa-plus"></l>
            </a>
            <a id="refresh_account_name" class="col_short_btn btn btn-sm btn-info refresh_account_name">
                <l class="fa fa-refresh"></l>
            </a>
        </div><!-- invoice column short end -->
        <select tabindex="2" name="{{$name}}"
                data-rule-required="true" data-msg-required="Please Select Party"
                class="inputs_up form-control js-example-basic-multiple"
                id="{{$id}}">
            <option value="0">Select Party</option>
            @foreach($accounts as $account)
                <option value="{{$account->account_uid}}"
                        {{ $account->account_uid == $select_uid ? 'selected':'' }}
                        data-limit_status="{{$account->account_credit_limit_status}}"
                        data-limit="{{$account->account_credit_limit}}"
                        data-disc_type="{{$account->account_discount_type}}">
                    {{$account->account_name}}</option>
            @endforeach
        </select>
    </div><!-- invoice column input end -->
</div><!-- invoice column box end -->
<script>
    jQuery(".refresh_account_name").click(function () {
        var type = "{!! $class !!}";
        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });

        jQuery.ajax({
            url: "refresh_purchase_account_name",
            data: {type: type},
            type: "POST",
            cache: false,
            dataType: 'json',
            success: function (data) {

                jQuery("#account_name").html(" ");
                jQuery("#account_name").append(data);
                jQuery("#account_code").html(" ");
                jQuery("#account_code").append(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
                alert(errorThrown);
            }
        });
    });
</script>
