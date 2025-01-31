 <!-- BasicPackage Page Info -->
 <meta charset="utf-8">
 <title>Financtics</title>
 <meta name="csrf-token" content="{{ csrf_token() }}">
 <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
 <!-- Site favicon -->
 <link rel="shortcut icon" href={{ asset('public/vendors/images/favicon.png') }}>

 <!-- Mobile Specific Metas -->
 {{--	<meta name="viewport" content="width=device-width, initial-scale=0, maximum-scale=0"> --}}
 <meta name="viewport" content="width=device-width, initial-scale=1.0">

 <link rel="stylesheet" href={{ asset('public/vendors/styles/style.css') }}>
 <link rel="stylesheet" href={{ asset('public/css/media.css') }}>
 <link rel="stylesheet" href="{{ asset('public/vendors/styles/font-awesome/css/font-awesome.min.css') }}">
 <script src="{{ asset('public/vendors/scripts/jquery.min.2.2.1.js') }}"></script>
 <script src="{{ asset('public/vendors/scripts/jquery.min3.3.1.js') }}"></script>
 <script type="text/javascript" src="{{ asset('public/vendors/scripts/jquery-1.3.2.js') }}"></script>

 <script type="text/javascript" src="{{ asset('public/vendors/scripts/jquery.shortcuts.min.js') }}"></script>
 @yield('shortcut_script')
 <script src={{ asset('public/js/select2/dist/js/select2.min.js') }} type='text/javascript'></script>
 <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

 <!-- CSS -->
 <link href={{ asset('public/js/select2/dist/css/select2.min.css') }} rel='stylesheet' type='text/css'>
 <link rel="stylesheet" href={{ asset('public/vendors/styles/sweetalert2.css') }} />
 <link rel="stylesheet" href={{ asset('public/vendors/styles/style-main.css') }}>
 <link rel="stylesheet" href={{ asset('public/vendors/styles/table_styles.css') }}>
 <link href="{{ asset('public/vendors/styles/profile_style.css') }}" rel="stylesheet" type="text/css" media="all" />
 <link rel="stylesheet" href="{{ asset('public/vendors/styles/profile_font-awesome.min.css') }}" />


 <!-- Google Font -->
 {{-- <link href="https://fonts.googleapis.com/css?family=Work+Sans:300,400,500,600,700" rel="stylesheet"> --}}
 {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" /> --}}
 {{-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"> --}}
 {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> --}}
 {{-- <link rel="stylesheet" href={{asset("public/vendors/styles/dataTables.min.css")}} /> --}}
 {{-- <script src = "https://code.jquery.com/jquery-1.10.2.js"></script> --}}
 {{-- <script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script> --}}
 {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script> --}}
 <style>
     .switch {
         position: relative;
         display: inline-block;
         width: 49px;
         height: 22px;
     }

     .switch input {
         opacity: 0;
         width: 0;
         height: 0;
     }

     .slider {
         position: absolute;
         cursor: pointer;
         top: 0;
         left: 0;
         right: 0;
         bottom: 0;
         background-color: #ccc;
         -webkit-transition: .4s;
         transition: .4s;
     }

     .slider:before {
         position: absolute;
         content: "";
         height: 15px;
         width: 15px;
         left: 4px;
         bottom: 4px;
         background-color: white;
         -webkit-transition: .4s;
         transition: .4s;
     }

     input:checked+.slider {
         background-color: #2a88ad;
     }

     input:focus+.slider {
         box-shadow: 0 0 1px #2196F3;
     }

     input:checked+.slider:before {
         -webkit-transform: translateX(26px);
         -ms-transform: translateX(26px);
         transform: translateX(26px);
     }

     /* Rounded sliders */
     .slider.round {
         border-radius: 34px;
     }

     .slider.round:before {
         border-radius: 50%;
     }
 </style>
 @yield('styles_get')
