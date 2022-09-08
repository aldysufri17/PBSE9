<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
        <title> @yield('title')</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- General CSS Files -->
        <link rel="stylesheet" href="{{ asset('backend/assets/vendors/bootstrap/dist/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendors/font-awesome/css/fontawesome.min.css') }}">

        @stack('styles')

        <!-- Template CSS -->
        <link rel="stylesheet" href="{{ asset('backend/assets/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/css/components.css')}}">

        <!-- Own CSS -->
        <link rel="stylesheet" href="{{ asset('backend/assets/css/loading.css')}}">

    </head>

    <body style="overflow: scroll">
        <div id="app">
            <div class="main-wrapper">
                <div class="navbar-bg"></div>
                {{-- Topbar --}}
                <nav class="navbar navbar-expand-lg main-navbar">
                    @include('backend.layouts.topnav')
                </nav>

                {{-- Sidebar --}}
                <div class="main-sidebar">
                    @include('backend.layouts.sidenav')
                </div>

                <!-- Main Content -->
                <div class="main-content">

                    <div id="loading">
                        <img id="loading-image" src="{{ asset('backend/assets/spinner.gif') }}" alt="Loading..." />
                    </div>

                    @yield('content')
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <!-- General JS Scripts -->
        <script src="{{ asset('backend/assets/vendors/jquery/dist/jquery.min.js') }}"></script>
        <script src="{{ mix('js/app.js') }}"></script>
        <script src="{{ asset('backend/assets/vendors/bootstrap/dist/js/popper.min.js') }}"></script>
        <script src="{{ asset('backend/assets/vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('backend/assets/vendors/jquery.nicescroll/jquery.nicescroll.min.js') }}"></script>
        <script src="{{ asset('backend/assets/js/stisla.js') }}"></script>
        <script src="{{ asset('backend/assets/vendors/moment.min.js') }}"></script>

        <!-- Template JS File -->
        <script src="{{ asset('backend/assets/js/scripts.js') }}"></script>
        <script src="{{ asset('backend/assets/js/custom.js') }}"></script>

        <script>
            $(window).load(function() {
                $('#loading').hide();
            });
        </script>

        @stack('scripts')

    </body>
</html>
