<!DOCTYPE html>
<html>
<!-- Header -->
<head>
    <meta charset="UTF-8">
    <title>
        @yield('title')
    </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- CSS --}}
    <link href="{{ mix("css/app.css") }}" rel="stylesheet" type="text/css"/>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<div class="wrapper">
    {{-- Page content --}}
    @yield('content')
</div>
{{-- JS --}}
<script src="{{ mix ("js/app.js") }}" type="text/javascript"></script>
</body>
</html>
