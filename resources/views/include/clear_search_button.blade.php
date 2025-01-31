<button tabindex="6" type="submit" name="filter_search"
        id="filter_search" class="save_button btn btn-sm" value="">
    <i class="fa fa-search"></i>
</button>
<button tabindex="5" type="button" name="cancel"
        id="cancel" class="cancel_button btn btn-sm">
    <i class="fa fa-trash"></i>
</button>
<script>
    $('#filter_search').click(function (){
        jQuery(".pre-loader").fadeToggle("medium");
    })
</script>
