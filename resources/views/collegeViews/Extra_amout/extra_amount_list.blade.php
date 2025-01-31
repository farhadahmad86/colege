@extends('extend_index')
@section('styles_get')
    <style>
        .action_td .dropdown .dropdown-toggle::after {
            content: unset !important;
        }
    </style>
@stop
@section('content')

{{-- farhad  --}}

    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header">
                <!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="text-white get-heading-text file_name">Extra Lecture Amount</h4>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->
            {{--                    <!-- <div class="search_form {{ ( !empty($search) || !empty($search_region) ) ? '' : 'search_form_hidden' }}"> --> --}}
            {{--                    --}}
            <div class="search_form m-0 p-0">
                <form name="edit" id="edit" action="{{ route('edit_extra_amount') }}" method="post">
                    @csrf
                    <input name="title" id="title" type="hidden">
                    <input name="rc_id" id="rc_id" type="hidden">
                </form>
                <form name="delete" id="delete" action="{{ route('delete_college_groups') }}" method="post">
                    @csrf
                    <input name="group_id" id="group_id" type="hidden">
                </form>
            </div>

            <div class="table-responsive" id="printTable">
                <table class="table table-bordered table-sm" id="fixTable">

                    <thead>
                        <tr>
                            <th scope="col" class="tbl_srl_4">
                                Sr
                            </th>
                            <th scope="col" class="tbl_srl_4">
                                Amount
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @php
                            $sr = 1;
                        @endphp
                        @if ($datas)
                            {{-- @foreach($datas as $data) --}}
                                <tr data-title="{{ $datas->rc_extra_lecture_amount }}" data-rc_id="{{ $datas->rc_id }}">
                                    <th scope="row">
                                        {{ $sr }}
                                    </th>
                                    <th scope="row" class="edit">
                                        {{ $datas->rc_extra_lecture_amount }}
                                    </th>
                                </tr>
                                @php
                                    $sr++;
                                @endphp
                            {{-- @endforeach --}}
                        @else
                            <tr>
                                <td colspan="2">No data available</td>
                            </tr>
                        @endif
                    </tbody>

                </table>

            </div>
        </div> <!-- white column form ends here -->
    </div><!-- row end -->

@endsection

@section('scripts')


    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('college_group_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>
        jQuery(".edit").click(function() {

            var title = jQuery(this).parent('tr').attr("data-title");
            var rc_id = jQuery(this).parent('tr').attr("data-rc_id");

            jQuery("#title").val(title);
            jQuery("#rc_id").val(rc_id);
            jQuery("#edit").submit();
        });

        $('.delete').on('click', function(event) {

            var group_id = jQuery(this).attr("data-group_id");

            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Yes',
            }).then(function(result) {

                if (result.value) {
                    jQuery("#group_id").val(group_id);
                    jQuery("#delete").submit();
                } else {

                }
            });
        });
    </script>


@endsection
