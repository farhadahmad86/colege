<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('include/head')

</head>

<body>

@include('include/header')
@include('include.sidebar_shahzaib')

<div class="main-container">
    <div class="pd-ltr-20 customscroll-10-p height-100-p xs-pd-20-10">
        @include('inc._messages')


        <div class="row">


            <div class="col-xs-12 col-sm-12 col-md-12 {{ ($win === 'full') ? 'col-lg-12 col-xl-12' : 'col-lg-9 col-xl-9' }} " id="main_col" data-win="{{ ($win === 'full') ? 'min' : 'full' }} ">

                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">



                    <div class="form_header"><!-- form header start -->
                        <div class="clearfix">
                            <div class="pull-left">
                                <h4 class="text-white">Info Box</h4>
                            </div>
                        </div>
                    </div><!-- form header close -->


                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">



                            <a class="add btn btn-info btn-md" data-toggle="modal" data-target="#newAddModal" style="margin-bottom: 15px;">
                                <i class="fa fa-pencil-square-o"></i> Add New
                            </a>

                            <div class="table-responsive" id="printTable">
                                <table class="table table-bordered table-sm" id="fixTable">
                                    <thead>
                                    <tr>
                                        <th scope="col" align="center" class="align_center text-center">Sr#</th>
                                        <th scope="col" align="center">Page Url</th>
                                        <th scope="col" align="center">Question</th>
                                        <th scope="col" align="center" class="align_center hide_column">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $sr=1;
                                    @endphp
                                    @forelse($info_bxs as $info_bx)

                                        <tr>
                                            <td class="align_center text-center">{{$sr}}</td>
                                            <td class="align_left">{{$info_bx->ib_url}}</td>
                                            <td class="align_left">{{$info_bx->ibc_ques }}</td>
                                            <td class="align_center hide_column">
                                                <a data-id="{{$info_bx->ibc_id}}" class="view btn btn-success btn-sm">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a data-id="{{$info_bx->ibc_id}}"  class="edit btn btn-warning btn-sm">
                                                    <i class="fa fa-pencil-square-o"></i>
                                                </a>
                                                <form method="post" enctype="multipart/form-data" action="{{route('info_box.destroy',$info_bx->ibc_id)}}" style="display: inline">
                                                    <input name="_method" type="hidden" value="DELETE" />
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <button type="submit"  class="trash btn btn-danger btn-sm"  onclick="return confirm('Do you want to delete ?');" data-toggle="tooltip" data-placement="left" title="" data-original-title="Are you sure?" ><i class="fa fa-trash-o"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                        @php
                                            $sr++;
                                        @endphp
                                    @empty
                                        <tr>
                                            <td colspan="11">
                                                <center><h3 style="color:#554F4F">No Region</h3></center>
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>

                            </div>



                        </div>
                    </div>


                </div> <!-- white column form ends here -->


            </div><!-- col end -->


            {{-- , ['hw_us' => $hw_us ]--}}


        </div><!-- row end -->



        @include('include/footer')
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="newAddModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-black">Info Box New Record Add</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">

                <form name="f1" class="f1" id="f1" action="{{ route('info_box.store') }}" onsubmit="return validate_form()" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                            <div class="row items" id="items">

                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="row">
                                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label class="required">Which URL to show</label>
                                                <input type="text" name="ib_url" id="ib_url" class="inputs_up form-control" placeholder="Whick URL to show data" autocomplete="off" value="">
                                                <span id="demo6" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>

                                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label class="required">Video URL</label>
                                                <input type="text" name="ib_vd_url" id="ib_vd_url" class="inputs_up form-control" placeholder="Video URL" autocomplete="off" value="">
                                                <span id="demo6" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>

                                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label class="required">Question #: 1</label>
                                                <input type="text" name="ibc_ques[]" id="ibc_ques" class="inputs_up form-control" placeholder="Question" autocomplete="off" value="">
                                                <span id="demo6" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>

                                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label class="required">Answers</label>
                                                <textarea name="ibc_ans[]" id="ibc_ans" class="inputs_up remarks form-control" placeholder="Answer"></textarea>
                                                <span id="demo7" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row" id="">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <div class="input_bx text-center"><!-- start input box -->

                                        <button class="btn btn-primary add_field_button" type="button">
                                            Add More Questions & Answer Fields
                                        </button>

                                    </div><!-- end input box -->
                                </div>
                            </div>


                            <div class="form-group row">
                                <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                                    <button type="button" name="cancel" id="cancel" class="form-control cancel_button" data-dismiss="modal">
                                        <i class="fa fa-times"></i> Cancel
                                    </button>
                                    <button type="submit" name="save" id="save" class="save_button form-control">
                                        <i class="fa fa-floppy-o"></i> Save
                                    </button>
                                </div>
                            </div>

                        </div> <!-- left column ends here -->
                    </div> <!--  main row ends here -->
                </form>

            </div>

        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-black">Info Box Detail</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body show_edt_view">

                <div id="table_body">

                </div>

            </div>

        </div>
    </div>
</div>



<script>

    jQuery(".view").click(function () {
        jQuery(".pre-loader").fadeToggle("medium");
        var id = jQuery(this).attr("data-id");
        $(".show_edt_view").load('{{ url("info_box/") }}'+'/'+id,function () {
            jQuery(".pre-loader").fadeToggle("medium");
            $("#myModal").modal({show:true});
        });

    });

    jQuery(".edit").click(function () {
        jQuery(".pre-loader").fadeToggle("medium");
        var id = jQuery(this).attr("data-id");
        $(".show_edt_view").load('{{ url("info_box/view") }}'+'/'+id,function () {
            jQuery(".pre-loader").fadeToggle("medium");
            $("#myModal").modal({show:true});
        });

    });

</script>

@include('include/script')

</body>
</html>
