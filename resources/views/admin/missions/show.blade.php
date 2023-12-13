@extends('admin.admin_dashboard')
@section('title')
    DreamCars - Missions
@endsection('title')
@section('admin')
<div class="row m-5">
    <div class="col-lg-8 mx-auto m-5">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Détails de la mission</h6>

                <dl class="row">
                    <dt class="col-sm-4">Titre:</dt>
                    <dd class="col-sm-8">{{ $mission->titre }}</dd>

                    <dt class="col-sm-4">Description:</dt>
                    <dd class="col-sm-8">{{ $mission->description }}</dd>

                    <dt class="col-sm-4">Date de debut:</dt>
                    <dd class="col-sm-8">{{ $mission->date_debut }}</dd>

                    <dt class="col-sm-4">Date de fin:</dt>
                    <dd class="col-sm-8">{{ $mission->date_fin }}</dd>

                    <dt class="col-sm-4">Chauffeurs:</dt>
                    <dd class="col-sm-8">
                        @foreach($mission->chauffeurs as $chauffeur)
                            {{ $chauffeur->prenom }} {{ $chauffeur->nom }}<br>
                        @endforeach
                    </dd>

                    <dt class="col-sm-4">Voitures:</dt>
                    <dd class="col-sm-8">
                        @foreach($mission->voitures as $voiture)
                            {{ $voiture->marque }}-{{ $voiture->immatriculation }}<br>
                        @endforeach
                    </dd>
                </dl>

                <div class="mt-4">
                    <a href="{{ route('missions.index') }}" class="btn btn-secondary">Retour</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
