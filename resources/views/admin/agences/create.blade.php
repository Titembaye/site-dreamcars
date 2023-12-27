@extends('admin.admin_dashboard')
@section('admin')
<div class="row m-5">
<div class="col-lg-8 mx-auto m-5">
<div class="card">
    <div class="card-body">
        <h6 class="card-title">Enregistrement d'une Agence</h6>

        <form class="forms-sample" method="POST" action="{{route('agences.store')}}">
            @csrf
            <div class="mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" name="nom" class="form-control" id="nom" autocomplete="off" placeholder="Nom">
            </div>
            <div class="mb-3">
                <label for="adresse" class="form-label">Adresse</label>
                <input type="text" name="adresse" class="form-control" id="adresse" autocomplete="off" placeholder="adresse">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="Email">
            </div>
            
            <div class="mb-3">
                <label for="phone" class="form-label">Téléphone</label>
                <input type="text" name="phone" class="form-control" id="phone" autocomplete="off" placeholder="Téléphone">
            </div>
            <button type="submit" class="btn btn-primary me-2">Enregistrer</button>
            <a class="btn btn-secondary" href={{route('agences.index')}}>Annuler</a>
        </form>
    </div>
</div>
</div>
</div>
@endsection					