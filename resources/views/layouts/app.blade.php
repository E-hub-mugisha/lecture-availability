<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/datatables/datatables.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <!-- font -->
    <link href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}" rel="stylesheet">

</head>

<body>
    <div id="app">
        @include('includes.navbar')


        <main class="py-4">
            @yield('content')
        </main>

        @include('includes.footer')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('assets/dist/js/bootstrap.bundle.min.js') }}"></script>

    <!-- fonts icon -->
    <script src="{{ asset('assets/plugins/fontawesome/js/all.min.js') }}"></script>

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#dataTables').DataTable();
        });
    </script>

</body>

</html>