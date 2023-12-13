@extends('frontend.index')
<link rel="stylesheet" href="{{ asset('frontend/assets/css/scroll-to-top.css') }}">
@section('content')
<div class="container mt-5 col-lg-6 mx-auto">
    <div class="alert alert-danger" role="alert">
        <h3 class="alert-heading">Voiture non disponible pour la période demandée!</h2>
        <p class="text-white">Malheureusement, la voiture que vous avez sélectionnée n'est pas disponible pour la période que vous avez demandée.</p>

        <!-- Afficher la prochaine disponibilité -->
        <p>La prochaine disponibilité pour cette voiture est prévue pour le .</p>

        <hr>

        <p class="mb-0">N'hésitez pas à ajuster vos dates de réservation ou à choisir une autre voiture parmi notre flotte.</p>
    </div>
</div>
<script src="{{ asset('frontend/assets/js/scroll-to-top.js') }}"></script>
@endsection
