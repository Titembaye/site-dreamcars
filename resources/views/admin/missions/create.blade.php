@extends('admin.admin_dashboard')
@section('title')
    DreamCars - Missions
@endsection('title')
@section('admin')
<!-- Plugin css for this page -->
<link rel="stylesheet" href="{{asset('backends/assets/vendors/select2/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('backends/assets/vendors/jquery-tags-input/jquery.tagsinput.min.css')}}">
<link rel="stylesheet" href="{{asset('backends/assets/vendors/dropzone/dropzone.min.css')}}">
<link rel="stylesheet" href="{{asset('backends/assets/vendors/dropify/dist/dropify.min.css')}}">
<link rel="stylesheet" href="{{asset('backends/assets/vendors/pickr/themes/classic.min.css')}}">
<link rel="stylesheet" href="{{asset('backends/assets/vendors/font-awesome/css/font-awesome.min.css')}}">
<link rel="stylesheet" href="{{asset('backends/assets/vendors/flatpickr/flatpickr.min.css')}}">
<!-- End plugin css for this page -->
<div class="row m-5">
    <div class="col-lg-8 mx-auto m-5">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Enregistrement d'une Réservation</h6>

                    <form method="POST" action="{{ route('missions.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="titre" class="form-label">Titre</label>
                            <input type="text" class="form-control" id="titre" name="titre" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="date_debut" class="form-label">Date de Début</label>
                            <input type="date" class="form-control" id="date_debut" name="date_debut" required>
                        </div>

                        <div class="mb-3">
                            <label for="date_fin" class="form-label">Date de Fin</label>
                            <input type="date" class="form-control" id="date_fin" name="date_fin" required>
                        </div>

                        <div class="mb-3">
                            <label for="voitures" class="form-label">Sélectionnez les Voitures</label>
                            <select class="form-control" id="voitures" name="voitures[]" multiple required>
                                @foreach($voitures as $voiture)
                                    <option value="{{ $voiture->id }}">{{ $voiture->immatriculation }}- {{ $voiture->marque }}</option>
                                @endforeach
                            </select>
                        </div>

                        
                        <div class="mb-3">
                            <label class="form-label">Sélectionnez les Chauffeurs</label>
                            <select class="js-example-basic-multiple form-select" multiple="multiple" data-width="100%" id="chauffeurs" name="chauffeurs[]">
                                @foreach($chauffeurs as $chauffeur)
                                    <option value="{{ $chauffeur->id }}">{{ $chauffeur->prenom }} {{ $chauffeur->nom }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Créer la Mission</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('backends/assets/vendors/jquery-validation/jquery.validate.min.js')}}"></script>
	<script src="{{asset('backends/assets/vendors/bootstrap-maxlength/bootstrap-maxlength.min.js')}}"></script>
	<script src="{{asset('backends/assets/vendors/inputmask/jquery.inputmask.min.js')}}"></script>
	<script src="{{asset('backends/assets/vendors/select2/select2.min.js')}}"></script>
	<script src="{{asset('backends/assets/vendors/typeahead.js/typeahead.bundle.min.js')}}"></script>
	<script src="{{asset('backends/assets/vendors/jquery-tags-input/jquery.tagsinput.min.js')}}"></script>
	<script src="{{asset('backends/assets/vendors/dropzone/dropzone.min.js')}}"></script>
	<script src="{{asset('backends/assets/vendors/dropify/dist/dropify.min.js')}}"></script>
	<script src="{{asset('backends/assets/vendors/pickr/pickr.min.js')}}"></script>
	<script src="{{asset('backends/assets/vendors/moment/moment.min.js')}}"></script>
	<script src="{{asset('backends/assets/vendors/flatpickr/flatpickr.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('#chauffeurs').select2({
                placeholder: "Sélectionnez les chauffeurs",
                tags: true,
                tokenSeparators: [',', ' '],
                allowClear: true,
            });
        });
    </script>
@endsection
