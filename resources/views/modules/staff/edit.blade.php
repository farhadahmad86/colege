@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="content-justify-center row">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        <h3 class="m-0">
                            Edit Staff
                            <a href="{{ route('staff.create') }}" class="btn btn-sm btn-primary mx-2 float-right">Create</a>
                            <a href="{{ route('staff.index') }}" class="btn btn-sm btn-primary float-right">Staff</a>
                        </h3>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('staff.update', $staff) }}" method="post">
                            @include('modules.staff._form_fields')
                            @method('put')

                            <div class="form-row">
                                <div class="form-group col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary">Update Staff</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
@stop
