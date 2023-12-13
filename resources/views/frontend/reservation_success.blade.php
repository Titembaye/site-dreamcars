@extends('frontend.index')
<link rel="stylesheet" href="{{ asset('frontend/assets/css/scroll-to-top.css') }}">
@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="alert alert-success" role="alert">
                <h3 class="alert-heading">Réservation effectuée avec succès!</h3>
                <p style="color:#e42320">Merci d'avoir choisi notre service de location de voitures. Voici les détails de votre réservation :</p>
                
                <!-- Afficher les détails de la réservation dans deux colonnes -->
                <div class="row">
                    <div class="col-md-6">
                        <ul>
                            <li>Date de début: {{$reservation->date_debut}}</li>
                            <li>Date de fin: {{$reservation->date_fin}}</li>
                            <li>Lieu d'embarquement: {{$reservation->lieu_depart}}</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul>
                            <li>Voiture réservée: {{$reservation->voiture->marque}}-{{$reservation->voiture->modele}}</li>
                            <li>Montant total: {{$reservation->montant_total}}</li>
                        </ul>
                    </div>
                </div>

                <hr>
                
                <p class="mb-0" style="color: #e42320">Nous vous contactons sous peu pour confirmation. N'hésitez pas à nous contacter pour toute question.</p>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('frontend/assets/js/scroll-to-top.js') }}"></script>
@endsection
