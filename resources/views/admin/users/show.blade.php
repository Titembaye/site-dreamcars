@extends('admin.admin_dashboard')
@section('title')
    DreamCars - Utilisateurs
@endsection('title')
@section('admin')
<div class="row m-5">
    <div class="col-lg-7 mx-auto m-5">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Détails du Client</h6>

                <dl class="row">
                    <dt class="col-sm-4">Nom:</dt>
                    <dd class="col-sm-8">{{ $user->name }}</dd>

                    <dt class="col-sm-4">Prénom:</dt>
                    <dd class="col-sm-8">{{ $user->username }}</dd>

                    <dt class="col-sm-4">Email:</dt>
                    <dd class="col-sm-8">{{ $user->email }}</dd>

                    <dt class="col-sm-4">Téléphone:</dt>
                    <dd class="col-sm-8">{{ $user->phone }}</dd>
                </dl>

                <div class="mt-4">
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">Retour</a>
                </div>
            </div>

        </div>
    </div>
    <div class="col-md-5 grid-margin stretch-card mt-5">
        <div class="card">
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4">Pièce d'identité:</dt>
                    <dd class="col-sm-8">
                        <img class="img-fluid" src="{{ asset('storage/' . $user->photo) }}" alt="Pièce d'identité">
                    </dd>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection