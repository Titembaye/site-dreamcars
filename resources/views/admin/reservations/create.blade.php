@extends('admin.admin_dashboard')
@section('title')
    DreamCars - Reservations
@endsection('title')
@section('admin')
<div class="row m-5">
    <div class="col-lg-8 mx-auto m-5">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Enregistrement d'une Réservation</h6>

                <form class="forms-sample" method="POST" action="{{ route('reservations.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="voiture_id" class="form-label">Voiture</label>
                        <select name="voiture_id" id="voiture_id" class="js-example-basic-single form-select" data-width="100%">
                            @foreach ($voitures as $voiture)
                                <option value="{{ $voiture->id }}">{{ $voiture->immatriculation }}</option>
                            @endforeach
                        </select>
                        @error('voiture_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="date_debut" class="form-label">Date de début</label>
                        <input type="date" name="date_debut" class="form-control" id="date_debut" autocomplete="off">
                        @error('date_debut')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="date_fin" class="form-label">Date de fin</label>
                        <input type="date" name="date_fin" class="form-control" id="date_fin" autocomplete="off">
                        @error('date_fin')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="montant_reservation" class="form-label">Montant de la réservation</label>
                        <input type="number" name="montant_reservation" class="form-control" id="montant_reservation" autocomplete="off">
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

@if(session('prochaine_disponibilite'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Récupérer la date de disponibilité
            var prochaine_disponibilite = "{{ session('prochaine_disponibilite.date_disponibilite') }}";
            
            // Afficher un popup avec la date de disponibilité
            alert('La voiture sera disponible à partir du ' + prochaine_disponibilite);
        });
    </script>
@endif

@endsection
