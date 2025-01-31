<div class="invoice_col_bx">
    <!-- invoice column box start -->
    @php
    $account_show='';
    if($name == 'account_name'){
    $account_show= 'account_name';
    }elseif($name=='account_code'){
    $account_show = 'account_uid';
    }else{
    $account_show= 'account_name';
    }

    @endphp
    <div class="invoice_col_ttl required">
        <!-- invoice column title start -->
        <a tabindex="-1" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.cash_voucher.cash_receipt_voucher.account_title.description')}}</p>">
            <i class="fa fa-info-circle"></i>
        </a>
        {{$title}}
    </div><!-- invoice column title end -->
    <div class="invoice_col_input refresh-addition">
        <!-- invoice column input start -->

        <div class="invoice_col_short">
            <!-- invoice column short start -->
            <a href="{{ route($href) }}" target="_blank" class="col_short_btn col_short_btn btn btn-sm btn-info add" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true"
               data-content="{{config('fields_info.about_form_fields.add.description')}}">
                <i class="fa fa-plus"></i>
            </a>
            <a id="refresh_account_name" class="col_short_btn col_short_btn btn btn-sm btn-info refresh" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true"
               data-content="{{config('fields_info.about_form_fields.refresh.description')}}" onclick="refresh_account('{{$id}}','{{$title}}','{{$array_index}}','{{$class}}')">
                <i class="fa fa-refresh"></i>
            </a>
        </div><!-- invoice column short end -->
        <select tabindex="{{$tabindex}}" name="{{$name}}" class="inputs_up form-control {{$class}}" id="{{$id}}" data-rule-required="true" data-msg-required="Please Enter {{$title}}">
            <option value="0">Select {{$title}}</option>
            @foreach($accounts as $account)
            <option value="{{$account->account_uid}}">{{$account->account_uid}} - {{$account->$account_show}}</option>
            @endforeach
        </select>
    </div><!-- invoice column input end -->
</div><!-- invoice column box end -->

<script>
    // var id = "{!! $id !!}";
    // jQuery("#" + id).select2();

    function refresh_account(id, title, array_index, type) {


        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });

        jQuery.ajax({
            url: "refresh_accounts"
            , data: {
                type: type
                , title: title
                , array_index: array_index
            }
            , type: "GET"
            , cache: false
            , dataType: 'json'
            , success: function(data) {
                console.log(data);
                var option = "<option value='' disabled selected>Select " + title + "</option>";
                var code_option = "<option value='' disabled selected>Select Account Code</option>";

                $.each(data, function(index, value) {
                    option += "<option value='" + value.account_uid + "'>" +value.account_uid + ' - ' + value.account_name + "</option>";
                });
                $.each(data, function(index, value) {
                    code_option += "<option value='" + value.account_uid + "'>" + value.account_uid + "</option>";
                });

                if (id == 'account_code' || id == 'account_name') {
                    jQuery("#account_code").html(" ");
                    jQuery("#account_code").append(code_option);
                    jQuery("#account_name").html(" ");
                    jQuery("#account_name").append(option);
                } else {
                    jQuery("#" + id).html(" ");
                    jQuery("#" + id).append(option);
                }


            }
            , error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
                alert(errorThrown);
            }
        });
    }

</script>
