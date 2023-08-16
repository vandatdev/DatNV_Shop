<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="{{asset('front-assets/css/slick.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('front-assets/css/slick-theme.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('front-assets/css/style.css')}}">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;500&family=Raleway:ital,wght@0,400;0,600;0,800;1,200&family=Roboto+Condensed:wght@400;700&family=Roboto:wght@300;400;700;900&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{csrf_token()}}">
    @yield('css')
    <title>@yield('title')</title>
</head>
<body data-instant-intensity="mousedown">
    @include('front.layouts.header')

    <main>
        @yield('content')
    </main>
    
    @include('front.layouts.footer')

    <script src="{{asset('front-assets/js/jquery-3.6.0.min.js')}}"></script>
    <script src="{{asset('front-assets/js/bootstrap.bundle.5.1.3.min.js')}}"></script>
    <script src="{{asset('front-assets/js/instantpages.5.1.0.min.js')}}"></script>
    <script src="{{asset('front-assets/js/lazyload.17.6.0.min.js')}}"></script>
    <script src="{{asset('front-assets/js/slick.min.js')}}"></script>
    <script src="{{asset('front-assets/js/custom.js')}}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    @yield('js')
</body>
</html>