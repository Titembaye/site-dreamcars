@extends('layouts.app')
@section('login_content')

<div class="container">
    <a href="#" class="noble-ui-logo logo-light d-block mb-2 text-center">Dream<span>Cars</span></a>
        <h5 class="text-white fw-normal mb-4 text-center">
            Demander un nouveau mot de pass
        </h5>
    <div class="container justify-content-center">
                
        <div class="row justify-content-center shaddow">
            
            <div class="col-lg-6 col-xl-5 ps-0">
                <div class="auth-form-wrapper py-5">
                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <!-- Email Address -->
                        <div>
                            <label class="text-white me-1" for="email"> Email: </label>
                            <input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <div>
                                <button type="submit" class="btn btn-icon-text mb-2 mb-md-0 text-white" style="background-color: #284898">Envoyer</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
