
    <div class="invoice_col_bx"><!-- invoice column box start -->
        <div class="required invoice_col_ttl"><!-- invoice column title start -->

            Posting Reference

        </div><!-- invoice column title end -->
        <div class="invoice_col_input refresh-addition"><!-- invoice column input start -->
            <x-add-refresh-button href="{{ route('add_posting_reference') }}" id="refresh_posting_reference"/>
{{--            <div class="invoice_col_short">--}}
{{--                <!-- invoice column short start -->--}}
{{--                <a href="{{ url('add_posting_reference') }}"--}}
{{--                   class="col_short_btn add"--}}
{{--                   target="_blank" data-container="body"--}}
{{--                   data-toggle="popover"--}}
{{--                   data-trigger="hover"--}}
{{--                   data-placement="bottom" data-html="true"--}}
{{--                   data-content="{{config('fields_info.about_form_fields.add.description')}}">--}}
{{--                    <l class="fa fa-plus"></l>--}}
{{--                </a>--}}
{{--                <a id="refresh_posting_reference" class="col_short_btn refresh"--}}
{{--                   data-container="body" data-toggle="popover"--}}
{{--                   data-trigger="hover" data-placement="bottom"--}}
{{--                   data-html="true"--}}
{{--                   data-content="{{config('fields_info.about_form_fields.refresh.description')}}">--}}
{{--                    <l class="fa fa-refresh"></l>--}}
{{--                </a>--}}
{{--            </div><!-- invoice column short end -->--}}
            <select tabindex="{{$tabindex}}" autofocus name="posting_reference" class="inputs_up form-control js-example-basic-multiple"
                    data-rule-required="true" data-msg-required="Please Choose Posting Reference"
                    id="posting_reference">
                <option value="0">Select Posting Reference</option>
                @foreach($posting_references as $posting_reference)
                    <option value="{{$posting_reference->pr_id}}" {{ $posting_reference->pr_id == 1 ? 'selected':'' }}>{{$posting_reference->pr_name}}</option>
                @endforeach
            </select>
        </div><!-- invoice column input end -->
    </div><!-- invoice column box end -->


    <script>
        jQuery("#refresh_posting_reference").click(function () {
            // alert('warehouse');
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "refresh_posting_reference",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#posting_reference").html(" ");
                    jQuery("#posting_reference").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // alert(jqXHR.responseText);
                    // alert(errorThrown);s
                }
            });
        });
    </script>
