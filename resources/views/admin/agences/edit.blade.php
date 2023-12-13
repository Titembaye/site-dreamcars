@extends('admin.admin_dashboard')
@section('admin')
<div class="row m-5">
    <div class="col-lg-8 mx-auto m-5">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Modification d'une Agence</h6>

                <form class="forms-sample" method="POST" action="{{route('agences.update', $agence->id)}}">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="id" value="{{ $agence->id }}">
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" name="nom" class="form-control" id="nom" autocomplete="off" placeholder="Nom" value="{{$agence->nom}}">
                    </div>
                    <div class="mb-3">
                        <label for="adresse" class="form-label">Adresse</label>
                        <input type="text" name="adresse" class="form-control" id="adresse" autocomplete="off" placeholder="adresse" value="{{$agence->adresse}}">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Email" value="{{$agence->email}}">
                    </div>
                    
                    <div class="mb-3">
                        <label for="phone" class="form-label">Téléphone</label>
                        <input type="text" name="phone" class="form-control" id="phone" autocomplete="off" placeholder="Téléphone" value="{{$agence->phone}}">
                    </div>
                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                    <button class="btn btn-secondary">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection					