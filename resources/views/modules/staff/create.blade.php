@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="content-justify-center row">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        <h3 class="m-0">
                            Create Staff
                            <a href="{{ route('staff.index') }}" class="btn btn-sm btn-primary float-right">Staff</a>
                        </h3>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('staff.store') }}" method="post">
                            @include('modules.staff._form_fields')

                            <div class="form-row">
                                <div class="form-group col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary">Save Staff</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
@stop
