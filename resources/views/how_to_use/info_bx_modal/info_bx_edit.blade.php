
<form action="{{ route('info_box.update', [$info_bx->ib_id] ) }}" method="post" enctype="multipart/form-data">
    @csrf
    <input name="_method" type="hidden" value="PATCH">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

            <div class="row items" id="items">

                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="row">


                        <div class="form-group col-lg-6 col-md-6 col-sm-12">
                            <input type="hidden" name="info_bx_child_id" id="info_bx_child_id" class="inputs_up form-control" placeholder="info_bx_child_id" autocomplete="off" value="{{ $info_bx->ibc_id }}">

{{--                            <div class="form-group col-lg-12 col-md-12 col-sm-12">--}}
{{--                                <div class="input_bx"><!-- start input box -->--}}
{{--                                    <label class="required">Which URL to show</label>--}}
{{--                                    <input type="text" name="ib_url" id="ib_url" class="inputs_up form-control" placeholder="Whick URL to show data" autocomplete="off" value="{{ $info_bx->ib_url }}">--}}
{{--                                    <span id="demo6" class="validate_sign"> </span>--}}
{{--                                </div><!-- end input box -->--}}
{{--                            </div>--}}

                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label class="required">Video URL</label>
                                    <input type="text" name="ib_vd_url" id="ib_vd_url" class="inputs_up form-control" placeholder="Video URL" autocomplete="off" value="{{ $info_bx->ib_vd_url }}">
                                    <span id="demo6" class="validate_sign"> </span>
                                </div><!-- end input box -->
                            </div>

                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label class="required">Question</label>
                                    <input type="text" name="ibc_ques" id="ibc_ques" class="inputs_up form-control" placeholder="Question" autocomplete="off" value="{{ $info_bx->ibc_ques }}">
                                    <span id="demo6" class="validate_sign"> </span>
                                </div><!-- end input box -->
                            </div>
                        </div>

                        <div class="form-group col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label class="required">Answers</label>
                                    <textarea name="ibc_ans" id="ibc_ans" class="inputs_up remarks form-control" placeholder="Answer">{{ $info_bx->ibc_ans }}</textarea>
                                    <span id="demo7" class="validate_sign"> </span>
                                </div><!-- end input box -->
                            </div>
                        </div>
                    </div>
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
