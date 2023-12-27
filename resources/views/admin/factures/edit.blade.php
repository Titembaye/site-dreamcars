@extends('admin.admin_dashboard')

@section('title')
    DreamCars - Modification d'une Facture
@endsection

@section('admin')
<div class="row m-5">
    <div class="col-lg-8 mx-auto m-5">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Modification d'une Facture</h6>

                <form class="forms-sample" method="POST" action="{{ route('factures.update', $facture->facture_id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="reservation_id" class="form-label">Réservation:</label>
                        <input type="text" id="reservation_id" name="reservation_id" class="js-example-basic-single form-select" data-width="100%" placeholder="Rechercher une réservation" value="{{ $facture->reservation_id }}">
                        <div id="reservation-results"></div>
                        @error('reservation_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="date_emission" class="form-label">Date</label>
                        <input type="date" name="date_emission" class="form-control" id="date_emission" autocomplete="off" value="{{ $facture->date_emission }}">
                        @error('date_emission')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Ajoutez d'autres champs de formulaire au besoin -->

                    <button type="submit" class="btn btn-primary me-2">Enregistrer les modifications</button>
                    <a href="{{ route('factures.index') }}" class="btn btn-secondary">Annuler</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    
</script>

@endsection
