<div class="input_bx">
    <!-- start input box -->
    <label>
        Class
    </label>
    <select tabindex="4" name="{{$name}}"
            class="inputs_up form-control" id="{{$id}}" data-rule-required="true"
            data-msg-required="Please Enter Class">
        <option value="">Select Class</option>
        @foreach ($classes as $class)
            <option value="{{ $class->class_id }}"
                {{ $class->class_id == $search_class ? 'selected="selected"' : '' }}>
                {{ $class->class_name }}</option>
        @endforeach
    </select>
</div>
<script>
    jQuery(document).ready(function() {
        var id = "{!! $id !!}";
        jQuery("#" + id).select2();

        $("#" + id).change(function() {
            var class_id = $(this).children('option:selected').val();
            $.ajax({
                url: '/get_groups',
                type: 'get',
                datatype: 'text',
                data: {
                    'class_id': class_id
                },
                success: function(data) {
                    console.log(data);
                    var groups = '<option selected disabled >Choose Groups</option>';
                    var sections = '<option selected disabled >Choose Section</option>';

                    $.each(data.groups, function(index, items) {
                        groups +=
                            `<option value="${items.ng_id}"> ${items.ng_name} </option>`;
                    });
                    $.each(data.section, function(index, items) {
                        sections +=
                            `<option value="${items.cs_id}"> ${items.cs_name} </option>`;
                    });
                    $('#group').html(groups);
                    $('#section').html(sections);
                }
            })
        });
    });



</script>
