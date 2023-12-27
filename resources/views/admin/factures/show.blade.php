@extends('admin.admin_dashboard')
@section('title')
    DreamCars - Reservations
@endsection('title')
@section('admin')
<div class="row m-5">
    <div class="col-lg-8 mx-auto m-5">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Détails de la reservation</h6>

                <dl class="row">
                    <dt class="col-sm-4">Nom et prenoms:</dt>
                    <dd class="col-sm-8">{{ $facture->reservation->user->name }}</dd>

                    <dt class="col-sm-4">Téléphone:</dt>
                    <dd class="col-sm-8">{{ $facture->date_emission }}</dd>
                    
                    <dt class="col-sm-4">Voiture:</dt>
                    <dd class="col-sm-8">{{ $facture->reservation->montant_total }}</dd>

                    <dt class="col-sm-4">Date de début:</dt>
                    <dd class="col-sm-8">{{ $facture->reservation->voiture->marque }} {{ $facture->reservation->voiture->modèle }} </dd>

                    
                </dl>

                <div class="mt-4">
                    <a href="{{ route('factures.index') }}" class="btn btn-secondary">Retour</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
