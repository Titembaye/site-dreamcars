@extends('frontend.properties')
@section('property_content')

<div class="properties section" style="margin-top:30px">
    <div class="container">
      
      <div class="row">
        <div id="carrouselVoitures" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-inner">
            @foreach($voitures_disponibles->chunk(6) as $key => $chunk)
            <div class="carousel-item @if($key === 0) active @endif">
              <div class="row">
                @foreach($chunk as $voiture)
                <div class="col-lg-4 col-md-6">
                  <div class="item">
                    <a href="{{route('voiture.details' , ['voitureId' => $voiture->id])}}"><img src="{{ asset('storage/' . $voiture->image) }}" alt=""></a>
                    <span class="category">{{$voiture->marque}}</span>
                    <h6>{{$voiture->montant_journalier}}FCFA/jour</h6>
                    <h4><a href="property-details.html">{{$voiture->marque}} / {{$voiture->modele}}</a></h4>
                    <ul>
                      <li>Capacité: <span>{{$voiture->capacite }} Places</span></li>
                      <li>Puissance: <span>{{$voiture->puissance}} CVE</span></li>
                      <span style="color: #e42320">
                        @if($voiture->disponibilite)
                            {{ $voiture->disponibilite->statut }}
                          @endif
                      </span>
                    </ul>
                    <div class="d-flex justify-content-between align-items-center">
                      <div class="main-button">
                        @auth
                          <button style="background-color:#284898" type="button" class="btn text-white" 
                          data-bs-toggle="modal" data-bs-target="#reservationModal{{$voiture->id}}">
                            Réserver
                          </button>
                          @else
                          <a style="background-color:#284898" type="button" class="btn text-white" 
                            href="{{route('login')}}">
                            Réserver
                          </a>
                        @endauth
                     </div>
                     
                      <div>
                        <button style="background-color:#e42320" type="button" class="btn text-white" data-bs-toggle="modal"
                          data-bs-target="#detailsModal{{$voiture->id}}">
                          Voir
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                @endforeach
              </div>
            </div>
            @endforeach
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#carrouselVoitures" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carrouselVoitures" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
      </div>

      <!-- Modals pour les détails des véhicules -->
      @foreach($voitures_disponibles as $voiture)
      <div class="modal fade" id="detailsModal{{$voiture->id}}" tabindex="-1"
        aria-labelledby="detailsModalLabel{{$voiture->id}}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="detailsModalLabel{{$voiture->id}}">Détails du Véhicule</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-lg-10 mx-auto">
                  <img src="{{ asset('storage/' . $voiture->image) }}" class="img-fluid" alt="Véhicule principal">
                  <div class="row mt-3">
                    @foreach($voiture->images as $image)
                    <div class="col-4">
                      <img src="{{ asset('storage/' . $image->image_path) }}" class="img-fluid"
                        alt="Image supplémentaire">
                    </div>
                    @endforeach
                  </div>
                  <div class="mt-3">
                    <div class="caracteristiques">
                      <span><strong>Montant Journalier:</strong> {{ $voiture->montant_journalier }} FCFA |</span>
                      <span><strong>Capacité:</strong> {{ $voiture->capacite }} Places |</span>
                      <span><strong>Puissance:</strong> {{ $voiture->puissance }} CVE |</span>
                      <span><strong>Marque:</strong> {{ $voiture->marque }} |</span>
                      <span><strong>Modèle:</strong> {{ $voiture->modele }}|</span>
                      <span><strong>Année:</strong> {{ $voiture->annee }} |</span>
                      <span><strong>Statut:</strong>{{$voiture->statut}}</span>
                      <!-- Ajoutez d'autres caractéristiques selon vos besoins -->
                    </div>
                  </div>
                </div>
              </div>
              <div class="row mt-5">
                <div class="col-lg-10 mx-auto">
                  <h5 style="color: #e42320; margin-bottom:20px; text-align:center;">Découvrez plus de voitures ...</h5>
                  <div class="row">
                    @foreach($voitures_disponibles as $vehiculeSuggere)
                      <div class="col-md-6 mb-3">
                        <div class="card">
                          <a href="{{route('voiture.details' , ['voitureId' => $voiture->id])}}"> <img src="{{ asset('storage/' . $vehiculeSuggere->image) }}" class="card-img-top" alt="Véhicule suggéré"> </a>
                          <div class="card-body">
                            <h6 class="card-title">{{ $vehiculeSuggere->marque }} - {{ $vehiculeSuggere->modele }}</h6>
                            <div class="row">
                              <div class="d-flex justify-content-between">
                                  <p class="card-text">{{ $vehiculeSuggere->montant_journalier }} FCFA/jour</p>
                                  <span style="color: #e42320">
                                      @if($vehiculeSuggere->disponibilite)
                                          {{ $vehiculeSuggere->disponibilite->statut }}
                                      @endif
                                  </span>
                              </div>
                            </div>                          
                            <button style="background-color:#e42320" type="button" class="btn text-white" data-bs-toggle="modal" data-bs-target="#detailsModal{{ $vehiculeSuggere->id }}">
                              Voir
                            </button>
                          </div>
                        </div>
                      </div>
                    @endforeach

                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="reservationModal{{$voiture->id}}" tabindex="-1" aria-labelledby="reservationModalLabel{{$voiture->id}}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-white" id="reservationModalLabel">Formulaire de Réservation</h5>
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
                            <label for="date_debut" class="form-label text-white">Date de début</label>
                            <input type="date" class="form-control text-white" id="date_debut" name="date_debut" required>
                        </div>
                        <div class="col-lg-6 mb-3">
                          <label for="date_fin" class="form-label text-white">Date de fin</label>
                          <input type="date" class="form-control text-white" id="date_fin" name="date_fin" required>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-6 mb-3">
                          <label for="heure_depart" class="form-label text-white">Heure de depart</label>
                          <input type="time" class="form-control text-white" id="heure_depart" name="heure_depart" required>
                        </div>
                      
                        <div class="col-lg-6 mb-3">
                          <label for="heure_fin" class="form-label text-white">Date de fin</label>
                          <input type="time" class="form-control text-white" id="heure_fin" name="heure_fin" required>
                        </div>
                      </div>
                      <div class="row">
                        <div class=" col-lg-6 mb-3">
                          <label for="lieu_depart" class="form-label text-white">Lieu d'embarquement</label>
                          <input type="text" class="form-control text-white" id="lieu_depart" name="lieu_depart" required>
                        </div>
                        <div class="col-lg-6 mb-3">
                          <label for="destination" class="form-label text-white">Destination</label>
                          <input type="text" class="form-control text-white" id="destination" name="destination" required>
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
      @endforeach
    </div>
  </div>

  @endsection