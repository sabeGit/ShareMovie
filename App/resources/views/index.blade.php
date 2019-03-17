<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="{{ asset('js/app.js', $is_production) }}" defer></script>
    <script src="{{ asset('js/bootstrap-toggle.min.js', $is_production) }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" >

    <!-- Styles -->
    <link href="{{ asset('css/app.css', $is_production) }}" rel="stylesheet">
    <link href="{{ asset('/css/bootstrap-toggle.min.css', $is_production) }}" rel="stylesheet">
</head>
<body>
    <div id="app"></div>

</body>
</html>
