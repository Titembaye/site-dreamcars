@extends('layouts.app')

@section('login_content')
    <div class="container justify-content-center">
        <div class="col-lg-12">
        <a href="#" class="noble-ui-logo logo-light d-block mb-2 text-center">Dream<span>Cars</span></a>
        <h5 class="text-white fw-normal mb-4 text-center">Création de compte.</h5>
        <div class="container justify-content-center">
            
            <div class="row justify-content-center shaddow">
                
                <div class="col-lg-6 col-xl-5 pe-0">
                    <img class="text-white" src="{{ asset('frontend/assets/images/register.jpg')}}" style="height:487px" alt="image login">
                </div>
                <div class="col-lg-6 col-xl-5 ps-0">
                    <div class="auth-form-wrapper py-5">

                        <form id="registration-form" class="forms-sample" method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3 from-group row">
                                <label for="name" class="form-label col-lg-4">Noms</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control text-white" id="name" autocomplete="name" name="name" placeholder="Votre Nom">
                                </div>
                            </div>

                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror

                            <div class="mb-3 form-group row">
                                <label for="email" class="form-label col-lg-4">Adresse mail</label>
                                <div class="col-lg-8">
                                    <input type="email" class="form-control text-white" id="email" name="email" placeholder="Votre adresse mail">
                                </div>
                            </div>

                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror

                            <div class="mb-3 form group row">
                                <label for="password" class="form-label col-lg-4">Mot de pass</label>
                                <div class="col-lg-8">
                                    <input type="password" class="form-control text-white" id="password" autocomplete="current-password" name="password" placeholder="Mot de pass">
                                </div>
                            </div>

                            @error('password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror

                            <div class="mb-3 form-group row">
                                <label for="password_confirmation" class="form-label col-lg-4">Confirmation</label>
                                <div class="col-lg-8">
                                    <input type="password" class="form-control text-white" id="password_confirmation" autocomplete="current-password" name="password_confirmation"placeholder="Confirmer votre mot de pass">
                                </div>
                                </div>

                            @error('password_confirmation')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror

                            <div class="mb-3 form-group row" id="phone-field">
                                <label for="phone" class="form-label col-lg-4">Téléphone</label>
                                <div class="col-lg-8">
                                    <input type="tel" class="form-control text-white" id="phone" name="phone" placeholder="Votre numéro de téléphone">
                                </div>
                            </div>
                            @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror

                            <div class="mb-3 form-group row">
                                <label for="photo" class="form-label col-lg-4">CIN/Permis</label>
                                <div class="col-lg-8">
                                    <label for="cin_image" class="custom-file-upload">
                                        <span>Télécharger votre permis </span>
                                    </label>
                                    <input type="file" id="cin_image" name="photo" accept="image/*" style="display:none;">
                                </div>
                            </div>
                            
                            @error('photo')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <div class="d-flex justify-content-center mt-2">
                                <span class="text-white me-1">Déjà inscrit?</span> 
                                <a href="{{ route('login') }}" class="d-block underline-link">Se connecter</a>
                            </div>
                            <button type="submit" id="submit-btn" class="btn text-white mt-2" style="background-color: #284898">S'inscrire</button>
                        </form>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
@endsection
