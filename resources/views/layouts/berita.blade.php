<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>@yield('title') | {{ trans('pagination.title') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    @extends('layouts.favicon')
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('berita/vendor/nucleo/css/nucleo.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('berita/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}"
          type="text/css">
    <!-- Argon CSS -->
    <link rel="stylesheet" href="{{ asset('berita/css/argon.css') }}" type="text/css">
</head>

<body class="bg-gradient-secondary">
@yield('content')
<!-- Footer -->
<footer class="py-5" id="footer-main">
    <div class="container">
        <div class="row align-items-center">
            <div class="col">
                <div class="copyright text-center text-muted">
                    &copy2022 <a class="font-weight-bold ml-1">IAIN PALANGKA RAYA</a>
                </div>


            </div>
        </div>
        <div class="row align-items-center">
            <div class="col">
            </div>
        </div>

    </div>
</footer>
<!-- Argon Scripts -->
<!-- Core -->
<script src="{{ asset('berita/vendor/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('berita/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('berita/vendor/js-cookie/js.cookie.js') }}"></script>
<script src="{{ asset('berita/vendor/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
<script src="{{ asset('berita/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') }}"></script>
<!-- Argon JS -->
<script src="{{ asset('berita/js/argon.js') }}"></script>
</body>

</html>
