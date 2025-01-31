@extends('extend_index')

@section('content')
    <div class="row">


        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">

                <div class="form_header">
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Select Module to Restore</h4>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-4 col-md-6 col-sm-12" style="margin: -5px auto 10px">
                        <div class="input_bx">
                            <label>Modules</label>
                            <select name="all_listings" class="inputs_up form-control" id="all_listings" autofocus>
                                <option >Select Module</option>
                                <option data-href="{{ route( 'region_list'                          ).'?restore_list=1' }}">Region</option>
                                <option data-href="{{ route( 'area_list'                            ).'?restore_list=1' }}">Area</option>
                                <option data-href="{{ route( 'sector_list'                          ).'?restore_list=1' }}">Sector</option>
                                <option data-href="{{ route( 'account_receivable_payable_list'      ).'?restore_list=1' }}">Client</option>
                                <option data-href="{{ route( 'account_receivable_payable_list'      ).'?restore_list=1' }}">Supplier</option>
                                <option data-href="{{ route( 'bank_account_list'                    ).'?restore_list=1' }}">Bank Account</option>
                                <option data-href="{{ route( 'salary_account_list'                  ).'?restore_list=1' }}">Salary Account</option>
                                <option data-href="{{ route( 'expense_account_list'                 ).'?restore_list=1' }}">Expense Account</option>
                                <option data-href="{{ route( 'second_level_chart_of_account_list'   ).'?restore_list=1' }}">Group Account</option>
                                <option data-href="{{ route( 'third_level_chart_of_account_list'    ).'?restore_list=1' }}">Parent Account</option>
                                <option data-href="{{ route( 'account_group_list'                   ).'?restore_list=1' }}">Reporting Group</option>
                                <option data-href="{{ route( 'account_list'                         ).'?restore_list=1' }}">Entry Account</option>
                                <option data-href="{{ route( 'credit_card_machine_list'             ).'?restore_list=1' }}">Credit Card Machine</option>
                                <option data-href="{{ route( 'warehouse_list'                       ).'?restore_list=1' }}">Warehouse</option>
                                <option data-href="{{ route( 'employee_list'                        ).'?restore_list=1' }}">Employee</option>
                                <option data-href="{{ route( 'main_unit_list'                       ).'?restore_list=1' }}">Main Unit</option>
                                <option data-href="{{ route( 'unit_list'                            ).'?restore_list=1' }}">Unit</option>
                                <option data-href="{{ route( 'group_list'                           ).'?restore_list=1' }}">Group</option>
                                <option data-href="{{ route( 'category_list'                        ).'?restore_list=1' }}">Category</option>
                                <option data-href="{{ route( 'product_list'                         ).'?restore_list=1' }}">Product</option>
                                <option data-href="{{ route( 'services_list'                        ).'?restore_list=1' }}">Service</option>
                                <option data-href="{{ route( 'product_clubbing_list'                ).'?restore_list=1' }}">Product Clubbing</option>
                                <option data-href="{{ route( 'product_packages_list'                ).'?restore_list=1' }}">Product Package</option>
                                <option data-href="{{ route( 'product_recipe_list'                  ).'?restore_list=1' }}">Product Recipe</option>
                                <option data-href="{{ route( 'product_group_list'                   ).'?restore_list=1' }}">Product Group</option>
                                <option data-href="{{ route( 'town_list'                            ).'?restore_list=1' }}">Town</option>
                                <option data-href="{{ route( 'modular_group_list'                   ).'?restore_list=1' }}">Modular Group</option>
                                <option data-href="{{ route( 'brand_list'                           ).'?restore_list=1' }}">Brand</option>

                                {{--@foreach ($listRoutes as $listRoute)
                                    <option data-href="{{ route( $listRoute->mcd_web_route ).'?restore_list=1' }}">{{ $listRoute->mcd_title }}</option>
                                @endforeach--}}

                            </select>
                        </div>
                    </div>
                </div>

                <div class="row" style="height: 450px">
                    <iframe id="all_listings__frame" src='about:blank' width="100%" height="100%" style="border:none;"></iframe>
                </div>

            </div>


        </div>

    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        jQuery(document).ready(function () {
            jQuery("#all_listings").select2();
        });

        $('#all_listings').on('change', function (e) {
            e.preventDefault();

            // $('.form_header').remove();

            var form_location = $(this).find("option:selected").data('href');

            var iframe = $('#all_listings__frame');
            iframe.attr("src", form_location);
            iframe.on("load", function() {
                iframe.contents().find("body div.header").remove();
                iframe.contents().find("body div.left-side-bar").remove();
                iframe.contents().find("body .main-container div#ftr").remove();
                iframe.contents().find("body .main-container").css('padding-top', '20px');
                iframe.contents().find("body #main_col .form_manage").css('margin', '0');

                iframe.parent()[0].style.height = ( iframe.contents().find("body #app").height() + 240 ) + 'px';

                // var x = document.getElementById("all_listings__frame");
                // var y = (x.contentWindow || x.contentDocument);
                // if (y.document)y = y.document;
                // y.body.style.backgroundColor = "red";
                // iframe.parent().style.height = iframe.contentWindow.document.body.scrollHeight; + 'px';

            });
        });
    </script>
@endsection


