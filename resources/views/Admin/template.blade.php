<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="description" content="Wallpaper">
    <meta name="author" content="mj">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <link rel="icon" href="{{ asset ('assets/img/brand/favicon.ico') }}" type="image/x-icon" />
    <!-- Title -->
    <title>Wallpaper | Admin</title>
    <!---Fontawesome css-->
    <link href="{{ asset ('assets/plugins/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <!---Ionicons css-->
    <link href="{{ asset ('assets/plugins/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    <!---Typicons css-->
    <link href="{{ asset ('assets/plugins/typicons.font/typicons.css') }}" rel="stylesheet">
    <!---Feather css-->
    <link href="{{ asset ('assets/plugins/feather/feather.css') }}" rel="stylesheet">
    <!---Falg-icons css-->
    <link href="{{ asset ('assets/plugins/flag-icon-css/css/flag-icon.min.css') }}" rel="stylesheet">
    <!---Style css-->
    <link href="{{ asset ('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset ('assets/css/custom-style.css') }}" rel="stylesheet">
    <link href="{{ asset ('assets/css/skins.css') }}" rel="stylesheet">
    <link href="{{ asset ('assets/css/dark-style.css') }}" rel="stylesheet">
    <link href="{{ asset ('assets/css/custom-dark-style.css') }}" rel="stylesheet">
    <!---Select2 css-->
    <link href="{{ asset ('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!--Mutipleselect css-->
    <link rel="stylesheet" href="{{ asset ('assets/plugins/multipleselect/multiple-select.css') }}">
    <!---Sidebar css-->
    <link href="{{ asset ('assets/plugins/sidebar/sidebar.css') }}" rel="stylesheet">
    <!---Jquery.mCustomScrollbar css-->
    <link href="{{ asset ('assets/plugins/jquery.mCustomScrollbar/jquery.mCustomScrollbar.css') }}" rel="stylesheet">
    <!---Sidemenu css-->
    <link href="{{ asset ('assets/plugins/sidemenu/sidemenu.css') }}" rel="stylesheet">
    <!-- Data Table -->

    <!-- cloudflare dropify -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<style>
    body {
        font-size: .9rem;
        background: #eff1f9;
    }

    .form-control:focus {
        border-color: #99a6b7;
        box-shadow: 0 0 0 0.0rem;
    }

    .btn:focus {
        box-shadow: 0 0 0 0.0rem;
    }

    .error_text {
        font-size: 13px;
    }

    div.dataTables_wrapper div.dataTables_length select {
        width: auto;
        display: inline-block;
        padding: 8px 10px;
        display: inline-block;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }
</style>

<body>
    <!-- Loader -->
    <div id="global-loader">
        <img src="{{ asset ('assets/img/loader.svg') }}" class="loader-img" alt="Loader">
    </div>
    <!-- End Loader -->
    <!-- Page -->
    <div class="page">
        <!-- Sidemenu -->
        @include('Admin.blocks.sidemenu')
        <!-- End Sidemenu -->
        <!-- Main Content-->
        <div class="main-content side-content pt-0">
            <!-- Main Header-->
            @include('Admin.blocks.header')
            <!-- End Main Header-->
            <div class="container-fluid">
                @yield('main-section')
            </div>
        </div>
        <!-- End Main Content-->
        <!-- Main Footer-->
        @include('Admin.blocks.footer')
        <!--End Footer-->
    </div>
    <!-- End Page -->
    <!-- Back-to-top -->
    <a href="#top" id="back-to-top"><i class="fe fe-arrow-up"></i></a>
    <!-- Jquery js-->
    @include('Admin.blocks.scripts')
    @yield('scripts')
</body>

</html>