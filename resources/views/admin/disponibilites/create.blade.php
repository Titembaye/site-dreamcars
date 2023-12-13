@extends('admin.admin_dashboard')
@section('title')
    DreamCars - Locations
@endsection('title')
@section('admin')
<div class="row m-5">
    <div class="col-lg-8 mx-auto m-5">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Enregistrement d'un Chauffeur</h6>

                <form class="forms-sample" method="POST" action="{{ route('disponibilites.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="voiture_id" class="form-label">Voiture</label>
                        <select name="voiture_id" id="voiture_id" class="js-example-basic-single form-select" data-width="100%">
                            @foreach ($voitures as $voiture)
                                <option value="{{ $voiture->id }}">  {{$voiture->marque}} {{ $voiture->immatriculation }}</option>
                            @endforeach
                        </select>
                        @error('voiture_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="statut" class="form-label">Statut</label>
                        <select name="statut" id="statut" class="js-example-basic-single form-select" data-width="100%">
                            <option value="Disponible">Disponible</option>
                            <option value="Réservé">Réservé</option>
                        </select>
                        @error('statut')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="date_disponibilite" class="form-label">Date de disponibilité</label>
                        <input type="date" name="date_disponibilite" class="form-control" id="date_disponibilite" autocomplete="off" placeholder="Date de disponibilité">
                        @error('date_disponibilite')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                    <a href="{{route('disponibilites.index')}}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
