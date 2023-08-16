<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>DatNV Shop - AdminPanel</title>
		<!-- Google Font: Source Sans Pro -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="{{asset('admin-assets/css/fontawesome/all.min.css')}}">
		<!-- Theme style -->
        <link rel="stylesheet" href="{{asset('admin-assets/css/adminlte.min.css')}}">
        <link rel="stylesheet" href="{{asset('admin-assets/css/custom.css')}}">
	</head>
	<body class="hold-transition login-page">
		
		<div class="login-box">
			<!-- /.login-logo -->
			<div class="card card-outline card-primary">
			  	<div class="card-header text-center">
					<a href="#" class="h3">AdminPanel</a>
			  	</div>
			  	<div class="card-body">
					<p class="login-box-msg">Sign in to start your session</p>

					@if (session('msg'))
						<x-alert type="{{session('type')}}" content="{{session('msg')}}"/>
					@endif

					<form action="{{route('admin.login')}}" method="post">
                        @csrf
				  		<div class="input-group mb-3">
							<input type="text" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{old('email')}}">
							<div class="input-group-append">
					  			<div class="input-group-text">
									<span class="fas fa-envelope"></span>
					  			</div>
							</div>
                            @error('email')
                                <p class="invalid-feedback">{{$message}}</p>
                            @enderror
				  		</div>
				  		<div class="input-group mb-3">
							<input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password">
							<div class="input-group-append">
					  			<div class="input-group-text">
									<span class="fas fa-lock"></span>
					  			</div>
							</div>
                            @error('password')
                                <p class="invalid-feedback">{{$message}}</p>
                            @enderror
				  		</div>
				  		<div class="row">
							<!-- <div class="col-8">
					  			<div class="icheck-primary">
									<input type="checkbox" id="remember">
									<label for="remember">
						  				Remember Me
									</label>
					  			</div>
							</div> -->
							<!-- /.col -->
							<div class="col-4 m-auto">
					  			<button type="submit" class="btn btn-primary btn-block">Login</button>
							</div>
							<!-- /.col -->
				  		</div>
					</form>
		  			<p class="mb-1 mt-3">
				  		<a href="forgot-password.html">I forgot my password</a>
					</p>					
			  	</div>
			  	<!-- /.card-body -->
			</div>
			<!-- /.card -->
		</div>
		<!-- ./wrapper -->
		<!-- jQuery -->
		<script src="{{asset('admin-assets/js/jquery.min.js')}}"></script>
		<!-- Bootstrap 4 -->
        <script src="{{asset('admin-assets/js/bootstrap.bundle.min.js')}}"></script>
		<!-- AdminLTE App -->
        <script src="{{asset('admin-assets/js/adminlte.min.js')}}"></script>
		<!-- AdminLTE for demo purposes -->
		{{-- <script src="{{asset('admin-assets/js/demo.js')}}"></script> --}}
	</body>
</html>