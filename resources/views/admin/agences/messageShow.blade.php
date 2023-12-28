@extends('admin.admin_dashboard')
@section('title')
    DreamCars - Missions
@endsection('title')
@section('admin')
<div class="row mt-5">
    <div class="col-lg-8 mx-auto mt-5">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Détails du message</h6>

                <div class="container">
                    <div class="row ">
                        <div class="col-lg-12 d-flex justify-content-between">
                            <div class="col-lg-6">Nom et Prénoms:</div>
                            <div class="col-lg-6">Email</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 d-flex justify-content-between">
                            <div class="col-lg-6">{{ $message->noms }}</div>
                            <div class="col-lg-6">{{ $message->email }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mt-5 mb-5">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-body">

                <div class="container">
                    <div class="row ">
                        <div class="col-lg-12 d-flex justify-content-between">
                            <div class="col-lg-3">Date:</div>
                            <div class="col-lg-9">{{ $message->created_at->format('Y-m-d') }}</div>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-lg-12 d-flex justify-content-between">
                            <div class="col-lg-3">Sujet:</div>
                            <div class="col-lg-9">{{ $message->sujet }}</div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-12 d-flex justify-content-between">
                            <div class="col-lg-12">{{ $message->contenu }}</div>
                        </div>
                    </div>
                    
                </div>
                
                <div class="mt-4">
                    <a href="{{ route('messagesList') }}" class="btn btn-secondary">Retour</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
