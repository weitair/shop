<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>微态尔商城</title>
        <link rel="stylesheet" href="{{ asset('assets/install/css/elementui.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/install/css/style.css') }}">
        <script src="{{ asset('assets/install/js/jquery.js') }}"></script>
        <script src="{{ asset('assets/install/js/vue.js') }}"></script>
        <script src="{{ asset('assets/install/js/elementui.js') }}"></script>
        <script src="{{ asset('assets/install/js/axios.js') }}"></script>
    </head>
    <body>
        <header class="el-header">
            <div class="container-logo">
                <img src="{{ asset('assets/install/images/logo.png') }}"
                     class="container-logoimage">
                <h1 class="container-logoname">微态尔商城</h1>
            </div>
        </header>
        @yield('content')
    </body>
</html>
