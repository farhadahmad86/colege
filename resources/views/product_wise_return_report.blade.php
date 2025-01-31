
@extends('extend_index')

@section('content')

    <form name="view" id="view" target="_blank" action="product_wise_purchases_sales_return_report" method="post">
            @csrf
            <input name="pro_id" id="pro_id" type="hidden">
            <input name="type" id="type" type="hidden">

        </form>

    <div class="page-header">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <!-- <div class="title">
                    <h4>Account Registration</h4>
                </div> -->
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Product Wise Return Report</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">

        <div class="clearfix">
            <div class="pull-left">
                <h4 class="text-blue get-heading-text">Product Wise Return Report</h4>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col" style="width:50px; text-align: center !important" align="center">Product #</th>
                    <th scope="col" style="width:80px; text-align: center !important" align="center">Product Name</th>
                    <th scope="col" style="width:80px; text-align: center !important" align="center">Purchase Return Report</th>
                    <th scope="col" style="width:50px; text-align: center !important" align="center">Sales Return Report</th>
                    <th scope="col" style="width:50px; text-align: center !important" align="center">Purchase Sales Return Report</th>

                </tr>
                </thead>


                <tbody>
                @php
                    $sr=1;
                @endphp
                @forelse($products as $product)

                    <tr>
                        <td class="align_center">{{$product->pro_id}}</td>
                        <td class="align_left">{{$product->pro_title}}</td>
                        <td class="align_center"><a data-pro_id="{{$product->pro_id}}" data-type="purchase" class="view" style="cursor:pointer;"><i class="fa fa-eye"></i></a></td>
                        <td class="align_center"><a data-pro_id="{{$product->pro_id}}" data-type="sale" class="view" style="cursor:pointer;"><i class="fa fa-eye"></i></a></td>
                        <td class="align_center"><a data-pro_id="{{$product->pro_id}}" data-type="both" class="view" style="cursor:pointer;"><i class="fa fa-eye"></i></a></td>

                    </tr>
                    @php
                        $sr++;
                    @endphp
                @empty
                    <tr>
                        <td colspan="11">
                            <center><h3 style="color:#554F4F">No Product</h3></center>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div> <!-- white column form ends here -->

@endsection

@section('scripts')

    <script>
        jQuery(".view").click(function () {

            var pro_id = jQuery(this).attr("data-pro_id");
            var type = jQuery(this).attr("data-type");
            jQuery("#pro_id").val(pro_id);
            jQuery("#type").val(type);

            jQuery("#view").submit();
        });
    </script>

@endsection

