@extends('frontend.index')
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/scroll-to-top.css') }}">
@section('title', $voiture->marque . ' ' . $voiture->modele)

@section('content')
  <div class="container">
    <div class="row mt-5">
      <div class="col-md-12">
        <div class="row mt-5">
            <div class="col-md-4 mx-auto">
              <a href="{{route('voiture.details' , ['voitureId' => $voiture->id])}}"> <img src="{{ asset('storage/' . $voiture->image) }}" class="d-block w-100" alt="Image"></a>
              
              </div>
              <div class="col-md-4 mx-auto">
                  <div class="car-details">
                  <h3 class="text-white" style="color:#284898">{{ $voiture->marque }} {{ $voiture->modele }}</h3> <br><br>
                  <p>{{ $voiture->description }}</p>
                  <ul>
                      <li class="text-white">Année de fabrication: {{ $voiture->annee }}</li>
                      <hr>
                      <li class="text-white">Capacité: {{ $voiture->capacite }} places</li>
                      <hr>
                      <li class="text-white">Puissance: {{ $voiture->puissance }} CV</li>
                      <hr>
                      <li class="text-white">Prix journalier: {{ $voiture->montant_journalier }} FCFA</li>
                      <br>
                  </ul>
                  @if(auth()->check())
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reservationModal{{$voiture->id}}">Réserver</button>
                  @else
                    <a href="{{ route('login') }}" class="btn btn-primary">Connectez-vous pour réserver</a>
                  @endif
                  </div>
              </div>
          </div>


          <div class="modal fade" id="reservationModal{{$voiture->id}}" tabindex="-1" aria-labelledby="reservationModalLabel{{$voiture->id}}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="reservationModalLabel">Formulaire de Réservation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Formulaire de réservation -->
                        <form method="POST" action="{{ route('reservations.reservation_store') }}">
                          @csrf
                          <!-- Champs cachés pour vehicule_id et user_id -->
                          <input type="hidden" name="voiture_id" value="{{ $voiture->id }}">
                          <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                          <input type="hidden" name="montant_reservation" value="{{ $voiture->montant_journalier }}">
                          
                          <!-- Champs de date de début et de fin -->
                          <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label for="date_debut" class="form-label">Date de début</label>
                                <input type="date" class="form-control" id="date_debut" name="date_debut" required>
                            </div>
                            <div class="col-lg-6 mb-3">
                              <label for="date_fin" class="form-label">Date de fin</label>
                              <input type="date" class="form-control" id="date_fin" name="date_fin" required>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-lg-6 mb-3">
                              <label for="heure_depart" class="form-label">Heure de depart</label>
                              <input type="time" class="form-control" id="heure_depart" name="heure_depart" required>
                            </div>
                          
                            <div class="col-lg-6 mb-3">
                              <label for="heure_fin" class="form-label">Date de fin</label>
                              <input type="time" class="form-control" id="heure_fin" name="heure_fin" required>
                            </div>
                          </div>
                          <div class="row">
                            <div class=" col-lg-6 mb-3">
                              <label for="lieu_depart" class="form-label">Lieu d'embarquement</label>
                              <input type="text" class="form-control" id="lieu_depart" name="lieu_depart" required>
                            </div>
                            <div class="col-lg-6 mb-3">
                              <label for="destination" class="form-label">Destination</label>
                              <input type="text" class="form-control" id="destination" name="destination" required>
                            </div>
                          </div>
                          <!-- Autres champs ou actions nécessaires -->
                          
                          <!-- Bouton de soumission -->
                          <div class="mb-3">
                              <button type="submit" class="btn btn-primary">Réserver</button>
                          </div>
                      </form>
                    </div>
                </div>
            </div>
          </div>


        <!-- Afficher les images en haut -->
        <div id="carImagesCarousel" class="carousel slide mt-4" data-bs-ride="carousel">
          <div class="carousel-inner">
            @foreach ($voiture->images->chunk(3) as $key => $chunk)
              <div class="carousel-item @if($key === 0) active @endif">
                <div class="row">
                  @foreach ($chunk as $image)
                    <div class="col-md-4">
                      <a href="{{route('voiture.details' , ['voitureId' => $voiture->id])}}"> <img src="{{ asset('storage/' . $image->image_path) }}" class="d-block w-100" alt="Image"> </a>
                    </div>
                  @endforeach
                </div>
              </div>
            @endforeach
          </div>
          <button class="carousel-control-prev d-none" type="button" data-bs-target="#carImagesCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next d-none" type="button" data-bs-target="#carImagesCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
      </div>
    </div>
  </div>
  <script src="{{ asset('frontend/assets/js/scroll-to-top.js') }}"></script>
@endsection
