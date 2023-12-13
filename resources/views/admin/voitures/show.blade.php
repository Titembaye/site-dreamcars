@extends('admin.admin_dashboard')
@section('title')
    DreamCars - Voitures
@endsection('title')
@section('admin')
<div class="row m-5">
    <div class="col-lg-12 mx-auto m-5">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Détails de la voiture</h6>
                <div class="row">
                <div class="col-lg-6">
                    <dl class="row">
                        <dt class="col-sm-4">Immatriculation:</dt>
                        <dd class="col-sm-8">{{ $voiture->immatriculation }}</dd>

                        <dt class="col-sm-4">Marque:</dt>
                        <dd class="col-sm-8">{{ $voiture->marque }}</dd>

                        <dt class="col-sm-4">Modèle:</dt>
                        <dd class="col-sm-8">{{ $voiture->modele }}</dd>

                    </dl>
                </div>
                <div class="col-lg-6">
                    <dl class="row">
                        <dt class="col-sm-4">Capacité:</dt>
                        <dd class="col-sm-8">{{ $voiture->capacite }}</dd>

                        <dt class="col-sm-4">Année:</dt>
                        <dd class="col-sm-8">{{ $voiture->annee }}</dd>

                        <dt class="col-sm-4">Prix journalier:</dt>
                        <dd class="col-sm-8">{{ $voiture->montant_journalier }}</dd>
                    </dl>
                </div>
                <dl>
                    <dt class="col-sm-4">Nombre réservation:</dt>
                    <dd class="col-sm-8">{{ $voiture->reservation_count }}</dd>
                </dl>
                <div class="row">
                    <div class="d-flex justify-content-between">
                        <div class="mt-4">
                            <a href="{{ route('voitures.index') }}" class="btn btn-secondary">Retour</a>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('voitures.editimage', ['id' => $voiture->id]) }}" class="btn btn-warning">Modifier les images</a>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <div class="col-lg-12 mx-auto m-5">
        <div class="card">
            <div class="card-body">
                <dl class="row">
                    <dd class="col-sm-4">
                        <img class="img-fluid" src="{{ asset('storage/' . $voiture->image) }}" alt="Image de la voiture">
                    </dd>
                    @foreach($voiture->images as $image)
                        <dd class="col-sm-4">
                            <img class="img-fluid" src="{{ asset('storage/' . $image->image_path) }}" alt="Image de la voiture">
                        </dd>
                    @endforeach
                </dl>
            </div>
        </div>
    </div>
</div>
  
@endsection('admin')
