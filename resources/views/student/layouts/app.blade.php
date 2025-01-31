<!DOCTYPE html>
<html>
<head>
    @include('master.partials.head')
    @yield('custom_styles')
</head>
<body class="hold-transition skin-blue sidebar-mini">

<div class="wrapper">
@include('master.partials.header')
@include('master.partials.aside')

<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

    @include('master.partials.flashes')

    <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Dashboard <small>{{ $nav }}</small>
                @if($nav != 'dashboard' && $action != 'create' && $action != 'no_add')
                    <a class="btn btn-success" href="{{ route('master.' . $nav . '.create') }}">
                        <i class="fa fa-plus"></i> Add
                    </a>
                @endif
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">

            @yield('content')

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    @include('master.partials.footer')
</div>

@include('master.partials.scripts')

@yield('custom_scripts')

</body>
</html>
