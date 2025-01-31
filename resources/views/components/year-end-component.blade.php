<div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
    <div class="input_bx"><!-- start input box -->
        <label>
            Select Financial Year
        </label>
        <select tabindex="2" class="inputs_up form-control cstm_clm_srch" name="year" id="year" style="width: 90%">
            <option value="">Select Year</option>
            @foreach($years as $year)
                <option value="{{$year->ye_id}}" {{ $year->ye_id == $search ? 'selected="selected"' : '' }}>{{$year->ye_title}}</option>
            @endforeach
        </select>
    </div>
</div>
