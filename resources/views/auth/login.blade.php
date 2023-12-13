@extends('layouts.app')
@section('login_content')
    
    <div class="container justify-content-center">
        <a href="#" class="noble-ui-logo logo-light d-block mb-2 text-center">Dream<span>Cars</span></a>
        <h5 class="fw-normal mb-4 text-white text-center">Connectez-vous et faites vos réservations.</h5>
        <div class="container justify-content-center">
            <div class="row justify-content-center shaddow">
                <div class="col-lg-6 col-xl-4 pe-0">
                    <img class="text-white" style="height: 315px" src="{{ asset('frontend/assets/images/login.jpg')}}" alt="image login">
                </div>
                <div class="col-lg-6 col-xl-4 ps-0">
                    <div class="auth-form-wrapper py-5">
                        <form class="forms-sample" method="post" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-3">
                                <input type="text" name="login" class="form-control form-control-custom text-white" id="login" placeholder="Email">
                            </div>
                            @error('login')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <div class="mb-3">
                                <input type="password" name="password" class="form-control text-white" id="password" autocomplete="current-password" placeholder="Password">
                            </div>
                            @error('password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <div>
                                <button type="submit" class="btn text-white btn-icon-text mb-2 mb-md-0" style="background-color: #284898">Login</button>
                            </div>
                            <div class="d-flex mt-2 justify-content-center">
                                <span class="text-white me-1">Pas inscris?</span>
                                <a href="{{ route('register') }}" class="d-block underline-link">Créer un compte.</a>
                            </div>
                            
                            <a href="{{route('password.request')}}" class="d-block mt-3 underline-link">Mot de pass oublié</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
                            