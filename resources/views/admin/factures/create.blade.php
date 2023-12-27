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
                        <label for="reservation_id" class="form-label">Réservation:</label>
                        <input type="text" id="reservation_id" name="reservation_id" class="js-example-basic-single form-select" data-width="100%" placeholder="Rechercher une réservation">
                        <div id="reservation-results"></div>
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

                    <button type="submit" class="btn btn-primary me-2">Enregistrer</button>
                    <a href="{{ route('reservations.index') }}" class="btn btn-secondary">Annuler</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#reservation_id').on('input', function () {
            var query = $(this).val();

            $.ajax({
                url: '{{ route('search.reservations') }}',
                method: 'GET',
                data: {query: query},
                success: function (data) {
                    // Afficher les résultats de la recherche dans une liste
                    var results = $('#reservation-results');
                    results.empty();

                    // Vérifiez si des résultats sont renvoyés
                    if (data.length > 0) {
                        $.each(data, function (index, reservation) {
                            results.append('<div data-reservation-id="' + reservation.reservation_id + '">' + reservation.date_debut + '</div>');
                        });
                    } else {
                        results.append('<div>Aucune réservation trouvée</div>');
                    }
                }
            });
        });

        // Logique de sélection de la réservation
        $('#reservation-results').on('click', 'div', function () {
            var selectedReservationId = $(this).data('reservation-id');
            var selectedReservationDate = $(this).text();

            $('#reservation_id').val(selectedReservationId);
            $('#reservation-results').empty();

            // Facultatif : Afficher la date de début de la réservation sélectionnée à des fins de clarté
            console.log('Date de début de la réservation sélectionnée:', selectedReservationDate);
        });
    });
</script>



@endsection
