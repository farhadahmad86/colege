@extends('extend_index')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Super Admin Registration</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Forms</li>
        </ol>
        <div class="card mb-4">
            <div class="card-body">
                <form method="post" action="{{ route('super_admin.store') }}" class="login-form"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <div class="row mb-3">
                            <label for="college" class="col-md-4 col-form-label text-md-end">{{ __('College') }}</label>
                            <div class="col-md-6">
                                <select id="college" type="text"
                                    class="form-control @error('college') is-invalid @enderror" name="college">
                                    <option value="">Select College</option>
                                    @foreach ($colleges as $college)
                                        <option value="{{ $college->clg_id }}"
                                            {{ $college->clg_id == old('college') ? 'selected' : '' }}>
                                            {{ $college->clg_name }}</option>
                                    @endforeach
                                </select>
                                @error('college')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="label-form" for="fullname">Full Name</label>
                            <div class=" mb-3">
                                <input id="fullname" type="text"
                                    class="form-control @error('fullname') is-invalid @enderror" name="fullname"
                                    value="{{ old('fullname') }}" autocomplete="off" placeholder="fullname" />
                                @error('fullname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="label-form" for="username">User Name</label>
                            <div class=" mb-3">
                                <input id="username" type="text"
                                    class="form-control @error('username') is-invalid @enderror" name="username"
                                    value="{{ old('username') }}" autocomplete="off" placeholder="Username" />
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="email">Email</label>
                            <input id="email" type="text" class="form-control  @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm"
                                class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="contact">Contact</label>
                            <input id="contact" type="text" class="form-control @error('contact') is-invalid @enderror"
                                name="contact" value="{{ old('contact') }}">
                            @error('contact')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="contact">CNIC</label>
                            <input id="contact" type="text" class="form-control @error('cnic') is-invalid @enderror"
                                name="cnic" value="{{ old('cnic') }}">
                            @error('cnic')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="logo">Address</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" id="address" rows="5" name="address"> {{ old('address') }} </textarea>
                            {{-- <textarea id="description" type="text" class="form-control "  value="{{ old('description') }}"> --}}
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror


                        </div>

                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                            <button type="submit" class="btn btn-primary" onsubmit="save()">
                                {{ __('Save') }}
                            </button>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
