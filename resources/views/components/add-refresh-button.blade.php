<div class="invoice_col_short"><!-- invoice column short start -->
    <a href="{{$href}}"
       class="col_short_btn btn btn-sm btn-info add"
       target="_blank" data-container="body"
       data-toggle="popover"
       data-trigger="hover"
       data-placement="bottom" data-html="true"
       data-content="{{config('fields_info.about_form_fields.add.description')}}" style="padding: 0px">
        <l class="fa fa-plus"></l>
    </a>
    <a id="{{$id}}" class="col_short_btn btn btn-sm btn-info refresh"
       data-container="body" data-toggle="popover"
       data-trigger="hover" data-placement="bottom"
       data-html="true"
       data-content="{{config('fields_info.about_form_fields.refresh.description')}}" style="padding: 0px">
        <l class="fa fa-refresh"></l>
    </a>
</div><!-- invoice column short end -->

