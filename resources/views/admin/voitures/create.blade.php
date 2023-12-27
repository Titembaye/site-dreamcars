@extends('admin.admin_dashboard')
@section('title')
DreamCars - Voitures
@endsection('title')
@section('admin')
<div class="row m-5">
    <div class="col-lg-10 mx-auto m-5">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Enregistrement d'une Voiture</h6>

                <form class="forms-sample" method="POST" action="{{route('voitures.store')}}" enctype="multipart/form-data">
                   @csrf

                   <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label for="immatriculation" class="form-label">Immatriculation</label>
                            <input type="text" name="immatriculation" class="form-control" id="immatriculation" autocomplete="off" placeholder="Immatriculation">
                            @error('immatriculation')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label for="marque" class="form-label">Marque</label>
                            <input type="text" name="marque" class="form-control" id="marque" autocomplete="off" placeholder="Marque">
                            @error('marque')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                   <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label for="modele" class="form-label">Model</label>
                            <input type="text" name="modele" class="form-control" id="modele" autocomplete="off" placeholder="Modèle">
                            @error('modele')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="puissance" class="form-label">Puissance</label>
                            <input type="number" name="puissance" class="form-control" id="puissance" autocomplete="off" placeholder="Puissance">
                            @error('puissance')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                   
                   <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label for="capacite" class="form-label">Capacité</label>
                            <input type="number" name="capacite" class="form-control" id="capacite" autocomplete="off" placeholder="Capacité">
                            @error('capacite')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="annee" class="form-label">Année</label>
                            <input type="text" name="annee" class="form-control" id="annee" placeholder="Année">
                            @error('annee')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                   <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label for="montant_journalier" class="form-label">Montant</label>
                            <input type="decimal" name="montant_journalier" class="form-control" id="montant_journalier" autocomplete="off" placeholder="Montant">
                            @error('montant_journalier')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label for="image" class="form-label">Photo</label>
                            <input class="form-control" name="image" type="file" id="image">
                        </div>
                        @error('image')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                   <div class="row">
                        <div class="col-lg-4 mb-3">
                            <label for="image" class="form-label">Aperçu de l'image</label>
                            <img id="showImage" class="img-fluid" src="" alt="Image Preview">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary me-2">Enregistrer</button>
                    <a href="{{route('voitures.index')}}" class="btn btn-secondary">Annuler</a>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('image').addEventListener('change', function() {
        var showImage = document.getElementById('showImage');
        var imageInput = this;

        if (imageInput.files && imageInput.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                showImage.src = e.target.result;
            }

            reader.readAsDataURL(imageInput.files[0]);
        }
    });
</script>
@endsection					