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

                <form class="forms-sample" method="POST" action="{{ route('factures.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="reservation_id" class="form-label">Réservation</label>
                        <select name="reservation_id" id="reservation_id" class="js-example-basic-single form-select" data-width="100%">
                            @foreach ($reservations as $reservation)
                                <option value="{{ $reservation->reservation_id }}">  {{ $reservation->reservation_id }}</option>
                            @endforeach
                        </select>
                        @error('reservation_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="date_emission" class="form-label">Date</label>
                        <input type="date" name="date_emission" class="form-control" id="date_emission" autocomplete="off">
                        @error('date_emission')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    

                    <div class="mb-3">
                        <label for="montant" class="form-label">Montant</label>
                        <input type="number" name="montant" class="form-control" id="montant" autocomplete="off">
                        @error('montant')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                   

                    <button type="submit" class="btn btn-primary me-2">Enregistrer</button>
                    <a href="{{ route('reservations.index') }}" class="btn btn-secondary">Annuler</a>
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
