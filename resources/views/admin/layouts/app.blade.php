<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>DatNV - @yield('title')</title>
		<!-- Google Font: Source Sans Pro -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="{{asset('admin-assets/css/fontawesome/all.min.css')}}">
		<!-- Theme style -->
        <link rel="stylesheet" href="{{asset('admin-assets/css/adminlte.min.css')}}">
        <link rel="stylesheet" href="{{asset('admin-assets/css/custom.css')}}">
		<meta name="csrf-token" content="{{csrf_token()}}">
		@yield('css')
	</head>
	<body class="hold-transition sidebar-mini">
		<!-- Site wrapper -->
		<div class="wrapper">
			
            @include('admin.layouts.header')
			
            @include('admin.layouts.sidebar')
            
			<div class="content-wrapper">
                @yield('content')
            </div>
			
            @include('admin.layouts.footer')
			
		</div>

		<!-- jQuery -->
        <script src="{{asset('admin-assets/js/jquery.min.js')}}"></script>
		<!-- Bootstrap 4 -->
        <script src="{{asset('admin-assets/js/bootstrap.bundle.min.js')}}"></script>
		<!-- AdminLTE App -->
        <script src="{{asset('admin-assets/js/adminlte.min.js')}}"></script>
		<!-- AdminLTE for demo purposes -->
        <script src="{{asset('admin-assets/js/demo.js')}}"></script>

        <script src="{{asset('admin-assets/js/summernote.min.js')}}"></script>

		<script type="text/javascript">
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			$(document).ready(function(){
				$(".summernote").summernote();
			})
		</script>
		
		@yield('js')
		@stack('customJs')
	</body>
</html>