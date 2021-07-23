<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/css-admin/adminlte.min.css') }}">
</head>
<body>


    @yield('content')

    <script>

  window.addEventListener("load", window.print());
    </script>
</body>
</html>
