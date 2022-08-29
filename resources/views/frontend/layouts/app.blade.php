<!DOCTYPE html>
<html lang="en">

@include('frontend.layouts.head')

<body>
    @include('frontend.layouts.header')

    <main id="main">
        @yield('content')
    </main>
    
    @include('frontend.layouts.footer')
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="{{asset('backend/assets/vendors/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{asset('frontend/assets/vendor/aos/aos.js')}}"></script>
    <script src="{{asset('frontend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('frontend/assets/vendor/glightbox/js/glightbox.min.js')}}"></script>
    <script src="{{asset('frontend/assets/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
    <script src="{{asset('frontend/assets/vendor/swiper/swiper-bundle.min.js')}}"></script>
    <script src="{{asset('frontend/assets/vendor/php-email-form/validate.js')}}"></script>
    <!-- Template Main JS File -->
    <script src="{{asset('frontend/assets/js/main.js')}}"></script>
    @stack('scripts')
</body>

</html>
