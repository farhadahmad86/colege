<div>
    <div class="invoice_col_bx">
        <div class=" invoice_col_ttl">
            <label class="form-check-label" for="post">
                Voucher
            </label>
        </div>
        <div class="custom-control custom-radio ml-2">
            <input class="form-check-input" type="radio" name="status" value="post" id="post"
                {{ $value == 'park' ? 'disabled' : '' }}>
            <label class="form-check-label" for="religion1">
                Post
            </label>
        </div>


        <div class="custom-control custom-radio">
            <input class="form-check-input " type="radio" name="status" value="park" id="park"
                {{ $value == 'park' ? 'checked' : '' }}>
            <label class="form-check-label" for="park">
                Park
            </label>
        </div>
    </div>
    <span class="text-danger" id="error_status" style="font-size: 12px;font-weight: bold;"></span>
</div>
