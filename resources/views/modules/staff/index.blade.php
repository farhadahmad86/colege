@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="content-justify-center row">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        <h3 class="m-0">
                            Staff <small>({{ $staff->total() }})</small>
                            <a href="{{ route('staff.create') }}" class="btn btn-sm btn-primary float-right">Create</a>
                        </h3>
                    </div>
                    <div class="card-body">
                        @include('modules.staff._table')
                    </div>
                </div>

            </div>
        </div>
    </div>
@stop
