
@extends('extend_index')

@section('content')

    <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">
                    <div class="form_header"><!-- form header start -->
                        <div class="clearfix">
                            <div class="pull-left">
                                <h4 class="text-white get-heading-text file_name">Inventory List</h4>
                            </div>
                        </div>
                    </div><!-- form header close -->

                    <div class="table-responsive" id="printTable">
                        <table class="table table-bordered table-sm" id="fixTable">
                            <thead>
                                <tr>
                                    <th scope="col" align="center">Sr#</th>
                                    <th scope="col" align="center">Batch#</th>
                                    <th scope="col" align="center">Code</th>
                                    <th scope="col" align="center">Name</th>
                                    <th scope="col" align="center">Stock</th>
                                    <th scope="col" align="center">Item Type</th>
                                    <th scope="col" align="center">Location</th>
                                    <th scope="col" align="center">Curr-Qty-Store/Warehouse</th>
                                    <th scope="col" align="center">Curr-Qty-Inventory</th>
                                    <th scope="col" align="center">User</th>
                                    <th scope="col" align="center">Date/Time</th>
{{--                                    <th scope="col" align="center" class="align_center hide_column">Action</th>--}}
                                </tr>
                            </thead>


                            <tbody>
                            @php
                                $sr=1;
                            @endphp
                            @forelse($products as $product)

                                <tr>
                                    <td class="align_left edit">{{$sr}}</td>
                                    <td class="align_left edit">{{$product->new_batch_id}}</td>
                                    <td class="align_left edit">{{$product->new_pro_code}}</td>
                                    <td class="align_left edit">{{$product->new_pro_name }}</td>
                                    <td class="align_left edit">{{$product->new_stock }}</td>
                                    <td class="align_left edit">{{$product->new_insert_type ==0 ? 'Old Items':'New Purchase Items' }}</td>
                                    <td class="align_left edit">{{$product->new_warehouse_name }}</td>
                                    <td class="align_left edit">{{$product->new_curr_qty_warehouse }}</td>
                                    <td class="align_left edit">{{$product->new_total_inventory }}</td>
                                    <td class="align_left edit">{{$product->new_user_name }}</td>
                                    <td class="align_left edit">{{$product->new_date_time }}</td>

                                </tr>
                                @php
                                    $sr++;
                                @endphp
                            @empty
                                <tr>
                                    <td colspan="11">
                                        <center><h3 style="color:#554F4F">No Data</h3></center>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div> <!-- white column form ends here -->



            </div><!-- col end -->


        </div><!-- row end -->

@endsection

@section('scripts')

    <script type="text/javascript">

        function validate_form()
        {
            var search  = document.getElementById("search").value;

            var flag_submit = true;

            if(search.trim() == "")
            {
                document.getElementById("demo1").innerHTML = "Required";
                jQuery("#search").focus();
                flag_submit = false;
            }else{
                document.getElementById("demo1").innerHTML = "";
            }

            return flag_submit;
        }
    </script>

@endsection

