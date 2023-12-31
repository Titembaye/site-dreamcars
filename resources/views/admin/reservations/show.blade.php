@extends('admin.admin_dashboard')
@section('title')
    DreamCars - Reservations
@endsection('title')
@section('admin')
    <div class="row m-5">
        <div class="col-lg-8 mx-auto m-5">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Détails de la réservation</h6>

                    <dl class="row">
                        <dt class="col-sm-4">Nom et prénoms :</dt>
                        <dd class="col-sm-8">{{ $reservation->user->name }}</dd>

                        <dt class="col-sm-4">Téléphone :</dt>
                        <dd class="col-sm-8">{{ $reservation->user->phone }}</dd>

                        <dt class="col-sm-4">Voiture :</dt>
                        <dd class="col-sm-8">{{ $reservation->voiture->immatriculation }} - {{ $reservation->voiture->marque }}</dd>

                        <dt class="col-sm-4">Date de début :</dt>
                        <dd class="col-sm-8">{{ $reservation->date_debut }}</dd>

                        <dt class="col-sm-4">Date de fin :</dt>
                        <dd class="col-sm-8">{{ $reservation->date_fin }}</dd>

                        <dt class="col-sm-4">Montant total :</dt>
                        <dd class="col-sm-8">{{ $reservation->montant_reservation }}</dd>

                        <!-- Ajoutez d'autres champs ici selon vos besoins -->
                        <dt class="col-sm-4">Lieu de départ :</dt>
                        <dd class="col-sm-8">{{ $reservation->lieu_depart }}</dd>

                        <dt class="col-sm-4">Heure de départ :</dt>
                        <dd class="col-sm-8">{{ $reservation->heure_depart }}</dd>

                        <dt class="col-sm-4">Heure de fin :</dt>
                        <dd class="col-sm-8">{{ $reservation->heure_fin }}</dd>

                        <dt class="col-sm-4">Destination :</dt>
                        <dd class="col-sm-8">{{ $reservation->destination }}</dd>

                        <!-- Ajoutez d'autres champs ici selon vos besoins -->
                    </dl>

                    <div class="mt-4">
                        <a href="{{ route('reservations.index') }}" class="btn btn-secondary">Retour</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
