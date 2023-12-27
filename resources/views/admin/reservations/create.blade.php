@extends('admin.admin_dashboard')

@section('title')
    DreamCars - Reservations
@endsection

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
                            <select name="voiture_id" id="voiture_id" class="js-example-basic-single form-select"
                                data-width="100%">
                                @foreach ($voitures as $voiture)
                                    <option value="{{ $voiture->id }}">{{ $voiture->immatriculation }}</option>
                                @endforeach
                            </select>
                            @error('voiture_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="date_debut" class="form-label">Date de début</label>
                                    <input type="date" name="date_debut" class="form-control" id="date_debut"
                                        autocomplete="off">
                                    @error('date_debut')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="heure_depart" class="form-label">Date de début</label>
                                    <input type="time" name="heure_depart" class="form-control" id="heure_depart"
                                        autocomplete="off">
                                    @error('heure_depart')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="date_fin" class="form-label">Date de fin</label>
                                    <input type="date" name="date_fin" class="form-control" id="date_fin"
                                        autocomplete="off">
                                    @error('date_fin')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="heure_fin" class="form-label">Date de début</label>
                                    <input type="time" name="heure_fin" class="form-control" id="heure_fin"
                                        autocomplete="off">
                                    @error('heure_fin')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="lieu_depart" class="form-label">Lieu de depart</label>
                            <input type="text" name="lieu_depart" class="form-control" id="lieu_depart"
                                autocomplete="off">
                            @error('lieu_depart')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="destination" class="form-label">Destination</label>
                            <input type="text" name="destination" class="form-control" id="destination"
                                autocomplete="off">
                            @error('destination')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary me-2">Enregister</button>
                        <a href="{{ route('reservations.index') }}" class="btn btn-secondary">Annuler</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if (session('prochaine_disponibilite'))
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
