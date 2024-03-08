<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/dataTables5/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dataTables5/css/dataTables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

    <title>Apps Application Form</title>
</head>

<body>
    @yield('content')

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script> --}}
    @yield('script')

</body>

</html>
