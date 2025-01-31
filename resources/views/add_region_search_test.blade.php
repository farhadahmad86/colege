@extends('extend_index')

@section('content')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/inputpicker/jquery.inputpicker.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/plugins/custom-search/custom-search.css') }}">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">
                <div class="form_header">
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Create Region</h4>
                        </div>
                        <div class="list_btn">
                            <a class="btn list_link add_more_button" href="{{route('region_list')}}" role="button">
                                <l class="fa fa-list"></l>
                                view list
                            </a>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="row">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <div class="input_bx">
                                    <label class="required">Region Title</label>
                                    <div class="ps__search">
                                        <input type="text" name="region_name" id="region_name" class="inputs_up form-control ps__search__input" placeholder="Region Title"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    {{--<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>--}}
    <script>
        $(document).ready(function () {
            $('.search__table').DataTable().destroy();
        });
    </script>

    {{--<script type="text/javascript" charset="utf8" src="{{ asset('public/inputpicker/jquery.inputpicker.js') }}"></script>
    <script type="text/javascript">
        $(function () {
            --}}{{--data: [--}}{{--
            --}}{{--@foreach($products as $product)--}}{{--
            --}}{{--    {--}}{{--
            --}}{{--        pro_p_code: "{{ $product->pro_p_code }}", pro_title: "{{ $product->pro_title }}", clubbing: "{{ $product->pro_clubbing_codes }}", code: "{{ $product->pro_code }}", id: {{$product->pro_id}}--}}{{--
            --}}{{--    },--}}{{--
            --}}{{--@endforeach--}}{{--
            --}}{{--],--}}{{--

            $('#region_name').inputpicker({
                data: @json($products),
                fields: [
                    {name: 'pro_p_code', text: 'Parent Code'},
                    {name: 'pro_title', text: 'Title'},
                    {name: 'pro_clubbing_codes', text: 'Clubbing'},
                    {name: 'pro_code', text: 'Product Code'},
                ],
                fieldText: 'pro_title',
                fieldValue: 'pro_p_code',
                headShow: true,
                filterOpen: true,
                autoOpen: false,
                tabToSelect: true,
                selectMode: 'active',
            });

            $('#region_name').on('change', function () {
                var object = $(this).inputpicker('element');
                console.log(object, object.pro_id);
            });

            // $('#region_name').change(function (input) {
            //     $('#inputpicker-1').val('');
            // });
        });
    </script>--}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-throttle-debounce/1.1/jquery.ba-throttle-debounce.min.js" integrity="sha512-JZSo0h5TONFYmyLMqp8k4oPhuo6yNk9mHM+FY50aBjpypfofqtEWsAgRDQm94ImLCzSaHeqNvYuD9382CEn2zw==" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/fuse.js@6.4.1"></script>
    <script>
        var PRODUCTS_COLUMNS_NAMES = [
            'pro_p_code',
            'pro_title',
            'pro_code',
            'pro_clubbing_codes',
        ];
        var GET_PRODUCTS_ROUTE = '{{ route('ajax_get_json_products') }}';
    </script>
    <script src="{{ asset('public/plugins/custom-search/custom-search_2.js') }}"></script>

@endsection


{{--
        document.body.onkeydown = function(e){
        document.body.onkeydown = function(e){
            //Prevent page scrolling on keypress
            e.preventDefault();
            //Clear out old row's color
            rows[selectedRow].style.backgroundColor = "#FFFFFF";
            //Calculate new row
            if(e.keyCode === 38){
                selectedRow--;
            } else if(e.keyCode === 40){
                selectedRow++;
            }
            if(selectedRow >= rows.length){
                selectedRow = 0;
            } else if(selectedRow < 0){
                selectedRow = rows.length-1;
            }
            //Set new row's color
            rows[selectedRow].style.backgroundColor = "#8888FF";
        };
--}}


{{--$(function () {
$('#region_name').inputpicker({
data: [
{ pro_p_code: "000005360352", pro_title: "Pro 1", clubbing: "456987654321,451305468101654,498401654601,46846501658406513,6984616846,6384616,16846168543,354616843210,16843120354631,06854321351431", code: "536035", id: 1 },
{ pro_p_code: "000003947234", pro_title: "Pro 2", clubbing: "", code: "394723", id: 2 },
{ pro_p_code: "000008303097", pro_title: "Pro 3", clubbing: "", code: "830309", id: 3 },
{ pro_p_code: "000002493992", pro_title: "Pro 4", clubbing: "", code: "249399", id: 4 },
{ pro_p_code: "000007465925", pro_title: "Pro 5", clubbing: "", code: "746592", id: 5 },
{ pro_p_code: "142345489079", pro_title: "Product 7", clubbing: "", code: "142345489079", id: 8 },
{ pro_p_code: "161097983666", pro_title: "Product Check Allow Decimal", clubbing: "", code: "", id: 6 },
{ pro_p_code: "252470496924", pro_title: "Product One", clubbing: "", code: "", id: 7 },
{ pro_p_code: "890955370842", pro_title: "Product Two", clubbing: "", code: "", id: 9 },
],
fields: [
{name: 'pro_p_code', text: 'Parent Code'},
{name: 'pro_title', text: 'Title'},
{name: 'clubbing', text: 'Clubbing'},
{name: 'code', text: 'Product Code'},
],
fieldText: 'pro_title',
fieldValue: 'pro_p_code',--}}


