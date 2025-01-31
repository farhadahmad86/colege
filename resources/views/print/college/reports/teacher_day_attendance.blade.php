@extends('print.print_index')

@if( $type !== 'download_excel')
    @section('print_title', $pge_title)
@endif

@section('print_cntnt')

    <div class="row">
        @php
            $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
            $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
            $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
            $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;

        @endphp
        @foreach($datas as $data)
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mb-3">
                <div class="card">
                    <div class="card-header">
                        {{$data->user_name}} <span class="badge badge-light float-right">{{$data->absent != null ? $data->absent : ($data->short_leave != null ? $data->short_leave :
                                    $data->leaves)}}</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

@endsection

