<div>
    <div class="invoice_col_ttl required">
        Branch
    </div><!-- invoice column title end -->
    <div class="invoice_col_input">
        <!-- invoice column input start -->
        <div class="invoice_col_short">
            <!-- invoice column short start -->
        </div><!-- invoice column short end -->
        <select name="branch" class="inputs_up form-control" id="branch" data-rule-required="true" data-msg-required="Please Enter Branch">
            <option value="0">Select Branch</option>
            @foreach($branches as $branch)
                <option value="{{$branch->branch_id}}">{{$branch->branch_name}}</option>
            @endforeach
        </select>
    </div><!-- invoice column input end -->
</div>
<script>

    $(document).ready(function () {
        $('#branch').select2();
    })

</script>
