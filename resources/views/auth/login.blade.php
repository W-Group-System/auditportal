@extends('layouts.app')

@section('content')
<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100">
            <form method="POST" action="{{ route('login') }}"  class="login100-form validate-form">
                @csrf
             
                <span class="login100-form-title p-b-43">
                    {{ config('app.name', 'Laravel') }}
                </span>
                <span class="login100-form-title p-b-43">
                    <h6>Login to continue</h6>
                </span>
                
                @if($errors->any())
                <div class="form-group alert alert-danger alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <strong>{{$errors->first()}}</strong>
                </div>
            @endif
                <div class="wrap-input100 " >
                    <input  type="email" class="input100" name="email" value="" required >
                    <span class="focus-input100"></span>
                    <span class="label-input100">Email</span>
                </div>
                
                
                <div class="wrap-input100 validate-input" data-validate="Password is required">
                    <input  id="password" type="password" class="input100" name="password" required>
                    <span class="focus-input100"></span>
                    <span class="label-input100">Password</span>
                </div>

                <div class="container-login100-form-btn">
                    <button class="login100-form-btn" type='submit'>
                        Login
                    </button>
                </div>
                <div class="flex-sb-m w-full p-t-3 p-b-32">

                    <div>
                        <a href="{{ route('password.request') }}" class="txt1">
                            Forgot Password?
                        </a>
                    </div>
                </div>
        

                
                
            </form>

            <div class="login100-more" style="background-image: url('login_design/images/WGROUP.png');">
            </div>
        </div>
    </div>
</div>

@endsection
