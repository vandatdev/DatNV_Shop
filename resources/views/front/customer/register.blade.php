@extends('front.layouts.app')

@section('title')
    Register
@endsection

@section('content')
    
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="{{route('home')}}">Home</a></li>
                <li class="breadcrumb-item">Register</li>
            </ol>
        </div>
    </div>
</section>

<section class=" section-10">
    <div class="container">
        <div class="login-form">    
            <form action="" method="post">
                @csrf
                <h4 class="modal-title">Register Now</h4>
                <div class="form-group">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Name" id="name" name="name" value="{{old('name')}}">
                    @error('name')
                        <p class="invalid-feedback">{{$message}}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <input type="text" class="form-control @error('email') is-invalid @enderror" placeholder="Email" id="email" name="email" value="{{old('email')}}">
                    @error('email')
                        <p class="invalid-feedback">{{$message}}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" placeholder="Phone" id="phone" name="phone" value="{{old('phone')}}">
                    @error('phone')
                        <p class="invalid-feedback">{{$message}}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" id="password" name="password">
                    @error('password')
                        <p class="invalid-feedback">{{$message}}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Confirm Password" id="password_confirmation" name="password_confirmation">
                    @error('password_confirmation')
                        <p class="invalid-feedback">{{$message}}</p>
                    @enderror
                </div>

                <div class="form-group small">
                    <a href="#" class="forgot-link">Forgot Password?</a>
                </div> 

                <button type="submit" class="btn btn-dark btn-block btn-lg" value="Register">Register</button>
            </form>			
            <div class="text-center small">Already have an account? <a href="{{route('user.login')}}">Login Now</a></div>
        </div>
    </div>
</section>

@endsection