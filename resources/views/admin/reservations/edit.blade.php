@extends('admin.admin_dashboard')
@section('title')
    DreamCars - Reservations
@endsection('title')
@section('admin')
<div class="row m-5">
    <div class="col-lg-8 mx-auto m-5">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Modification d'une Réservation</h6>
                
                <form class="forms-sample" method="POST" action="{{ route('reservations.update', $reservation->id) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $reservation->id }}">
                    <div class="mb-3">
                        <label for="voiture_id" class="form-label">Voiture</label>
                        <select name="voiture_id" id="voiture_id" class="js-example-basic-single form-select" data-width="100%">
                            @foreach ($voitures as $voiture)
                                <option value="{{ $voiture->id }}" @if($voiture->id == $reservation->voiture_id) selected @endif >
                                    {{ $voiture->immatriculation }}
                                </option>
                            @endforeach
                        </select>
                        @error('voiture_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="date_debut" class="form-label">Date de début</label>
                        <input type="date" name="date_debut" class="form-control" id="date_debut" autocomplete="off" value="{{ $reservation->date_debut }}">
                        @error('date_debut')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="date_fin" class="form-label">Date de fin</label>
                        <input type="date" name="date_fin" class="form-control" id="date_fin" autocomplete="off" value="{{ $reservation->date_fin }}">
                        @error('date_fin')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="montant_reservation" class="form-label">Montant de la réservation</label>
                        <input type="number" name="montant_reservation" class="form-control" id="montant_reservation" autocomplete="off" value="{{ $reservation->montant_reservation }}">
                        @error('montant_reservation')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                   

                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                    <a href="{{ route('reservations.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection
