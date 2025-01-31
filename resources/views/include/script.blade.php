<script src={{ asset('public/_finead/js/app.js') }}></script>

<script>
    jQuery(document).ready(function() {
        var form_heading = '';
        var form_location = '';
        $('.add-prerequisite__action').on('click', function(e) {
            e.preventDefault();
            console.log('$(this):' + $(this), '$(this).data(\'title\'): ' + $(this).data('title'),
                '$(this).data(\'href\'): ' + $(this).data('href'))
            form_heading = $(this).data('title');
            form_location = $(this).data('href');
        });
        $('#add-prerequisite--modal').on('show.bs.modal', function(e) {
            $('#add-prerequisite--modal--label').text(form_heading);

            var iframe = $('#' + $(this).attr('id') + ' iframe');
            iframe.attr("src", form_location);
            iframe.on("load", function() {
                iframe.contents().find("body div.header").remove();
                iframe.contents().find("body div.left-side-bar").remove();
                iframe.contents().find("body .main-container div#ftr").remove();
                iframe.contents().find("body .main-container").css('padding-top', '20px');
                iframe.contents().find("body #main_col .form_manage").css('margin', '0');
            });
        });
        $('#add-prerequisite--modal').on('hide.bs.modal', function(e) {
            var iframe = $('#' + $(this).attr('id') + ' iframe');
            iframe.attr("src", "about:blank");
            iframe = null;

            form_heading = '';
            form_location = '';
        });
    });
    $(document).ready(function() {
        $("#srch_slct").click(function() {
            var get_id = $(this).val();
            $(".frm_hide.show_active").removeClass("show_active");
            $("#" + get_id).addClass("show_active");
        });
        $(".srch_box_opn_icon").click(function() {
            $(".search_form").slideToggle(300);
        });
        // $('.collapse').collapse();

        $(".all_clm_srch").keyup(function() {
            $("#filter_search").val('normal_search');
        });
        $(".cstm_clm_srch").change(function() {
            $("#filter_search").val('filter_search');
        });

        $content_height = $("#main_col").height();
        if ($content_height <= 620) {
            $("#ftr").addClass('fxd_ftr');
        }


    });
</script>

<script src={{ asset('public/vendors/scripts/script.js') }}></script>
<script src={{ asset('public/vendors/scripts/dataTables.min.js') }} type='text/javascript'></script>

<script type="text/javascript">
    $(document).ready(function() {
        // $('.table').DataTable({
        //     "paging": false,
        //     "ordering": true,
        //     "info": false,
        //     "bFilter": false,
        //     "autoWidth": false
        // });
    });
</script>

{{--    user modal script start --}}
<script>
    jQuery(".usr_prfl").click(function() {

        var transcation_id = jQuery(this).attr("data-usr_prfl"),
            user_info = jQuery(this).attr('data-user_info');
        url = '{{ route('profile_activity', ['id' => ':id', 'array' => ':user_info']) }}';
        url = url.replace(':id', transcation_id);
        url = url.replace(':user_info', user_info.split(','));

        $(".usr_mdl_bdy").load(url, function() {
            $('#usrMdl').modal({
                show: true
            });
        });

    });
</script>
{{--    user modal script end --}}
{{-- <!-- user detail Modal add by shahzaib end --> --}}


<script src={{ asset('public/sidebar_js/script.js') }}></script>
<script src={{ asset('public/vendors/scripts/sweetalert2.all.js') }}></script>

<script>
    @if (count($errors) > 0)
        Swal.fire({
            title: "<i>Errors</i>",
            html: "<ul class=\"alert alert-danger\">\n" +
                "        @foreach ($errors->all() as $error)\n" +
                "            <li>\n" +
                "                {{ $error }}\n" +
                "            </li>\n" +
                "            <br>\n" +
                "        @endforeach\n" +
                "    </ul>",
        });
    @endif
</script>

@php
    $company_info = Session::get('company_info');
    if (isset($company_info) || !empty($company_info)) {
        $print_logo = $company_info->ci_logo;
        $print_name = $company_info->ci_name;
        $print_ptcl = $company_info->ci_ptcl_number;
        $print_mobile = $company_info->ci_mobile_numer;
        $print_whatsapp = $company_info->ci_whatsapp_number;
        $print_fax = $company_info->ci_fax_number;
        $print_email = $company_info->ci_email;
        $print_address = $company_info->ci_address;
    } else {
        $print_logo = '';
        $print_name = '';
        $print_ptcl = '';
        $print_mobile = '';
        $print_whatsapp = '';
        $print_fax = '';
        $print_email = '';
        $print_address = '';
    }
@endphp

<script>
    $(document).ready(function() {
        // $("#fixTable").tableHeadFixer();
    });
</script>

<script type="text/javascript">
    jQuery(function() {
        jQuery('.datepicker1').datepicker({
            language: 'en',
            dateFormat: 'dd-M-yyyy',
            autoClose: true,
        });
    });
</script>

<script>
    $('form').submit(function() {

        $(this).find(':submit').attr('disabled', 'disabled');
        // $(this).find(':submit').hide();
    });
</script>

<style>
    input::-webkit-calendar-picker-indicator {
        display: none;
    }
</style>

<script>
    //for sidebar menu search
    $(document).ready(function() {

        $("#sidemenu").on('input', function(event) {
            var val = this.value;
            var url;
            if ($('#searchbar_sidemenu option').filter(function() {

                    if (this.value.toUpperCase() === val.toUpperCase()) {

                        url = $(this).attr('data-url');
                    }
                    return this.value.toUpperCase() === val.toUpperCase();

                }).length) {
                window.location = url;
            }
        });
    });


    // Restricting input to textbox: allowing only numbers
    function allowOnlyNumber(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

    // Restricting input to textbox: allowing only numbers and decimal point
    function allow_only_number_and_decimals(txt, evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode == 46) {
            //Check if the text already contains the . character
            if (txt.value.indexOf('.') === -1) {
                return true;
            } else {
                return false;
            }
        } else {
            if (charCode > 31 &&
                (charCode < 48 || charCode > 57))
                return false;
        }

        // myRegExp = new RegExp(/^-?\d+(?:\.\d{0,3})?$/);
        // if (!myRegExp.test(txt.value)) {
        //     txt.value=txt.value.slice(0,-1);
        //     return false;
        // }

        return true;
    }

    // Restricting input to textbox: allowing only numbers and decimal point  and negative sign
    function allow_positive_negative_with_decimals(txt, evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode == 46) {
            //Check if the text already contains the . character
            if (txt.value.indexOf('.') === -1) {
                return true;
            } else {
                return false;
            }
        } else if (charCode == 45) {

            //Check if the text already contains the - character
            if (txt.value.indexOf('-') === -1) {
                return true;
            } else {
                return false;
            }
        } else {
            if (charCode > 31 &&
                (charCode < 48 || charCode > 57))
                return false;
        }
        return true;
    }

    function validate_positive_negative_with_decimals(value) {

        var regex = /^-?[0-9]+.?[0-9]+$/;
        if (regex.test(value)) {
            return true;
        } else {
            return false;
        }
    }


    function assign_product_parent_value() {
        var parent_code = jQuery("#product_code option:selected").attr('data-parent');

        jQuery('#product').val(parent_code);
    }

    $(document).prop('title', $(".get-heading-text").text());


    // Restricts input for each element in the set of matched elements to the given inputFilter.
    (function($) {
        $.fn.inputFilter = function(inputFilter) {
            return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
                if (inputFilter(this.value)) {
                    this.oldValue = this.value;
                    this.oldSelectionStart = this.selectionStart;
                    this.oldSelectionEnd = this.selectionEnd;
                } else if (this.hasOwnProperty("oldValue")) {
                    this.value = this.oldValue;
                    this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                } else {
                    this.value = "";
                }
            });
        };
    }(jQuery));

    // function inputFilter_test(input, event) {
    $(document).on('keypress keyup keydown', ".percentage_textbox", function() {
        $(this).inputFilter(function(value) {
            return /^-?\d*[.,]?\d*$/.test(value) && (value === "" || parseInt(value) <= 100);
        });
    });
    // }
</script>

<script src="{{ asset('public/vendors/scripts/validation.js') }}" type="text/javascript"></script>
@yield('scripts')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

<script>
    var x = document.getElementById("f1");
    if (x != null && x != "undefined") {
        x.addEventListener("focus", prvntDflt, true);
        x.addEventListener("blur", prvntDflt, true);
    }

    function prvntDflt(e) {
        if (document.forms["f1"]["save"].hasAttribute('disabled')) {
            document.forms["f1"]["save"].removeAttribute('disabled');
        }
        e.preventDefault();
    }
</script>
{{-- <script type="text/javascript" src="{{ asset('public/vendors/scripts/jquery.validate.min.js') }}"></script> --}}
{{-- <script> --}}
{{--    $(document).ready(function () { --}}
{{--        $("#f1").validate({submitHandler: function() { $(".pre-loader").show(); $('#f1').submit();}}); --}}

{{--    }); --}}
{{-- </script> --}}
