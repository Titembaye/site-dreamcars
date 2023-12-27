@extends('admin.admin_dashboard')
@section('title')
    DreamCars - Chauffeurs
@endsection('title')
@section('admin')
<div class="row m-5">
    <div class="col-lg-8 mx-auto m-5">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Enregistrement d'un Chauffeur</h6>

                <form class="forms-sample" method="POST" action="{{route('chauffeurs.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" name="nom" class="form-control" id="nom" autocomplete="off" placeholder="Nom">
                        @error('nom')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="prenom" class="form-label">Prenom</label>
                        <input type="text" name="prenom" class="form-control" id="prenom" autocomplete="off" placeholder="Prenom">
                        @error('prenom')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Email">
                        @error('email')
                            <div class="text-danger">{{ $message }} </div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="phone" class="form-label">Téléphone</label>
                        <input type="text" name="phone" class="form-control" id="phone" autocomplete="off" placeholder="Téléphone">
                        @error('phone')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                  
                    <div class="mb-3">
                        <label for="agence_id" class="form-label">Agence</label>
                        <select name="agence_id" id="agence_id" id="agence_id" class="js-example-basic-single form-select" data-width="100%">
                            @foreach ($agences as $agence)
                                <option value="{{ $agence->id }}">{{ $agence->nom }}</option>
                            @endforeach
                        </select>
                        @error('agence_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-lg-6 mb-3">
                        <label for="permis_de_conduire" class="form-label">Permis de conduire</label>
                        <input class="form-control" name="permis_de_conduire" type="file" id="image">
                    </div>
                    @error('permis_de_conduire')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                
               
                    <div class="col-lg-4 mb-3">
                        <label for="image" class="form-label">Aperçu de l'image</label>
                        <img id="showImage" class="img-fluid" src="" alt="Image Preview">
                    </div>

                    <button type="submit" class="btn btn-primary me-2">Enregistrer</button>
                    <a href="{{route('chauffeurs.index')}}" class="btn btn-secondary">Annuler</a>
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