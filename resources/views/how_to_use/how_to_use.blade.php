

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 " id="info_col">

    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-20 form_manage">

                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white">How To Use</h4>
                        </div>
                    </div>
                </div><!-- form header close -->

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                            @php
                                $info_bx_childs = Session::get('info_bx_child');
                                $info_bx = Session::get('info_bx');
                                $x = 1;
                            @endphp
                            @if(isset($info_bx_childs) && !empty($info_bx_childs))
                                @foreach($info_bx_childs as $info_bx_child)
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="heading{{ $x }}bcd">
                                            <h4 class="panel-title">
                                                <a class="@php ($x === 1) ? 'collapsed' : '' @endphp" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $x }}bcd" aria-expanded="@php ($x === 1) ? 'true' : 'false' @endphp" aria-controls="collapse{{ $x }}bcd">
                                                    <b>{{ $x }}:-</b> {{ $info_bx_child->ibc_ques }}?.
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapse{{ $x }}bcd" class="panel-collapse collapse@php ($x === 1) ? 'true' : 'show' @endphp" role="tabpanel" aria-labelledby="heading{{ $x }}bcd">
                                            <div class="panel-body">
                                                <p class="font-12 mb-5">
                                                    {{ $info_bx_child->ibc_ans }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    @php
                                        $x++;
                                    @endphp
                                @endforeach
                            @endif

                            <iframe width="100%" height="" class="mt-20" src="{{ (isset($info_bx) && !empty($info_bx)) ? $info_bx->ib_vd_url : '' }}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

                        </div>

                    </div>
                </div>

            </div>
        </div><!-- col end -->


    </div><!-- row end -->


</div><!-- col end -->
