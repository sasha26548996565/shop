<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ __('main.online_shop') }}: @yield('title')</title>

    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <script src="{{ asset('/js/jquery.min.js') }}"></script>
    <script src="{{ asset('/js/bootstrap.min.js') }}"></script>
    <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/starter-template.css') }}" rel="stylesheet">
</head>

<body>
    @include('includes.header')

    <div class="container">
        <div class="starter-template">
            @if (session()->has('success'))
                <p class="alert alert-success">{{ session()->get('success') }}</p>
            @elseif (session()->has('warning'))
                <p class="alert alert-warning">{{ session()->get('warning') }}</p>
            @elseif (session()->has('error'))
                <p class="alert alert-danger">{{ session()->get('error') }}</p>
            @endif

            @yield('content')
        </div>
    </div>

    @include('includes.footer')
</body>

</html>
