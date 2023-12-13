@extends('admin.admin_dashboard')
@section('title', 'DreamCars - Locations')

@section('admin')
<div class="row m-5">
    <div class="col-lg-8 mx-auto m-5">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Édition de disponibilité de Voiture</h6>

                <form class="forms-sample" method="POST" action="{{ route('disponibilites.update', $disponibilite->id) }}">
                    @csrf
                    @method('PUT') {{-- Utilisez PUT pour mettre à jour --}}

                    <input type="hidden" name="id" value="{{ $disponibilite->id }}">

                    <div class="mb-3">
                        <label for="voiture_id" class="form-label">Voiture</label>
                        <select name="voiture_id" id="voiture_id" class="js-example-basic-single form-select" data-width="100%">
                            @foreach ($voitures as $voiture)
                                <option value="{{ $voiture->id }}" @if($voiture->id == $disponibilite->voiture_id) selected @endif>
                                    {{$voiture->marque}} {{ $voiture->immatriculation }}
                                </option>
                            @endforeach
                        </select>
                        @error('voiture_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="statut" class="form-label">Statut</label>
                        <select name="statut" id="statut" class="js-example-basic-single form-select" data-width="100%">
                            <option value="Disponible" @if($disponibilite->statut == 'Disponible') selected @endif>Disponible</option>
                            <option value="Réservé" @if($disponibilite->statut == 'Réservé') selected @endif>Réservé</option>
                        </select>
                        @error('statut')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="date_disponibilite" class="form-label">Date de disponibilité</label>
                        <input type="date" name="date_disponibilite" class="form-control" id="date_disponibilite" autocomplete="off" placeholder="Date de disponibilité" value="{{ $disponibilite->date_disponibilite }}">
                        @error('date_disponibilite')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary me-2">Mettre à jour</button>
                    <a href="{{route('disponibilites.index')}}" class="btn btn-secondary">Annuler</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
