@extends('frontend.index')
  <link rel="stylesheet" href="{{ asset('frontend/assets/css/scroll-to-top.css') }}">
@section('title')
  DreamCars - acceuil
@endsection('title')
@section('content')
<div class="main-banner">
  <div class="owl-carousel owl-banner" data-autoplay="true" data-autoplay-timeout="2000">
      <div class="item item-1">
          <div class="header-text">
              <h3>Trouvez votre voiture de Luxe</h3>
          </div>
      </div>
      <div class="item item-2">
          <div class="header-text">
              <h3>Deplacez vous<br>avec style</h3>
          </div>
      </div>
      <div class="item item-3">
          <div class="header-text">
              <h3>Reserver Maintenant<br>la voiture de votre rêve</h3>
          </div>
      </div>
  </div>
</div>

  <div class="properties section" style="margin-top:30px">
    <div class="container">
      <div class="row" style="margin-bottom:0px;">
        <div class="col-lg-6 offset-lg-3">
          <div class="section-heading text-center">
            <h4 class="animated-title">Nous vous offrons les véhicules dont vous avez besoin</h4>
          </div>
        </div>
      </div>
      <div class="row">
        <div id="carrouselVoitures" class="carousel slide d-none d-md-block" data-bs-ride="carousel">
          <div class="carousel-inner">
            @foreach($voitures_disponibles->chunk(3) as $key => $chunk)
            <div class="carousel-item @if($key === 0) active @endif">
              <div class="row">
                @foreach($chunk as $voiture)
                <div class="col-lg-4 col-md-6">
                  <div class="item">
                    <a href="{{route('voiture.details' , ['voitureId' => $voiture->id])}}"> <img src="{{ asset('storage/' . $voiture->image) }}" alt=""></a>
                    <span class="category">{{$voiture->marque}}</span>
                    <h6>{{$voiture->montant_journalier}}FCFA/jour</h6>
                    <h4><a href="#">{{$voiture->marque}} - {{$voiture->modele}}</a></h4>
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
          <button class="carousel-control-prev d-none" type="button" data-bs-target="#carrouselVoitures" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next d-none" type="button" data-bs-target="#carrouselVoitures" data-bs-slide="next">
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
                      <span><strong>Statut:</strong> {{ $voiture->statut }}</span>
                      <!-- Ajoutez d'autres caractéristiques selon vos besoins -->
                    </div>
                  </div>
                </div>
              </div>
              <div class="row mt-5">
                <div class="col-lg-10 mx-auto">
                  <a style="color: #e42320; margin-bottom:20px; text-align:center;">Découvrez plus de voitures ...</a>
                  <div class="row">
                    @foreach($vehicules_suggeres as $vehiculeSuggere)
                      <div class="col-md-6 mb-3">
                        <div class="card">
                          <img src="{{ asset('storage/' . $vehiculeSuggere->image) }}" class="card-img-top" alt="Véhicule suggéré">
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
                            <label for="heure_fin" class="form-label text-white">Heure de fin</label>
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
  <div class="text-center mt-3 mb-3">
    <a href="{{ route('properties') }}" class="btn" style="background-color:#284898; color: fff">Découvrez plus de voitures ...</a>
  </div>

  <!-- Modal for Details -->
  <div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="detailsModalLabel">Détails</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Replace this with your detailed information -->
          <p>Details go here...</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
          <!-- You can add more buttons here if needed -->
        </div>
      </div>
    </div>
  </div>

 

  <div class="featured section pb-3" style="margin-top:10px"> 
    <div class="container" style="margin-top:0px">
      <div id="carrouselFeatured" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach($featured_voitures->chunk(1) as $key => $chunk)
              <div class="carousel-item @if($key === 0) active @endif">
                  @foreach($chunk as $voiture)
                    <div class="row" style="margin-top:0px">
                      <div class="col-lg-7">
                        <div class="d-block" style="max-width: 100%;">
                          <a href="{{ route('voiture.details', ['voitureId' => $voiture->id]) }}">
                            <img src="{{ asset('storage/' . $voiture->image) }}" alt="{{ $voiture->marque }}">
                          </a>                        
                        </div>
                      </div>
                      <div class="col-lg-5" style="background-color: #fff">
                          <div class="info-table">
                              <ul>
                                  <li>
                                      <!-- Icône et informations spécifiques à chaque voiture -->
                                      <i class="fas fa-money-check dollar fa-2x" style="margin-right: 30px;"></i>
                                      <h4 style="display: inline-block;">{{ $voiture->montant_journalier }} FCFA/J</span></h4>
                                  </li>
                                  <li>
                                    <!-- Icône spécifique à chaque voiture -->
                                    <i class="fas fa-bolt fa-2x" style="margin-right: 30px;"></i>
                                    <h4 style="display: inline-block;">{{ $voiture->marque }}</h4>
                                </li>
                                <li>
                                  <!-- Icône et informations spécifiques à chaque voiture -->
                                  
                                  <i class="fas fa-wheelchair fa-2x" style="margin-right: 30px;"></i>
                                  <h4 style="display: inline-block;">{{ $voiture->capacite }} Places </span></h4>
                                </li>  
                              </ul>
                          </div>
                      </div>
                    </div>
                  @endforeach
              </div>
            @endforeach
        </div>
        <button class="carousel-control-prev d-none" type="button" data-bs-target="#carrouselFeatured" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next d-none" type="button" data-bs-target="#carrouselFeatured" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
      </div>
    </div>
  </div>

  
  <div class="procedure pt-40 mt-5">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 offset-lg-3">
          <div class="section-heading text-center">
            <h6><br></h6>
            <h4 class="animated-title">Reservez facilement votre voiture en trois etapes ...</h4>
          </div>
        </div>
      </div>
      <div class="row ">
        <div class="col-lg-4 text-center">
          <div class="service-1">
            <div class="service-1-contents">
              <h6 style="color: #e42320; margin-bottom:5px">Connectez-vous !</h6>
            </div>
            <span class="service-1-icon">
              <span class="icon-circle">
                <i class="fas fa-right-to-bracket fa-2x icon-white"></i>
              </span>
            </span>
            
          </div>
        </div>
        <div class="col-lg-4 text-center">
          <div class="service-1">
            <div class="service-1-contents">
              <h6 style="color: #e42320; margin-bottom:5px">Trouvez la voiture de votre choix !</h6>
            </div>
            <span class="service-1-icon">
              <span class="icon-circle">
                <i class="fas fa-magnifying-glass fa-2x icon-white"></i> 
              </span>
            </span>
          </div>
        </div>
        <div class="col-lg-4 text-center">
          <div class="service-1">
            <div class="service-1-contents">
              <h6 style="color: #e42320; margin-bottom:5px">Remplissez et validez le formulaire !</h6> 
            </div> 
            <span class="service-1-icon">
              <span class="icon-circle">
                <i class="fas fa-pen fa-2x icon-white"></i>
              </span> 
            </span> 
            
          </div> 
        </div>
      </div> 
    </div>
  </div>

  <div class="section best-deal">
    <div class="container" style="margin-bottom: 0px;">
        <div class="row" style="margin-bottom: 0px;">
            <div class="col-lg-4">
                <div class="section-heading">
                    <h4 class="animated-title" >Trouvez votre voiture de luxe</h4>
                </div>
            </div>
            <div class="col-lg-12" style="margin-bottom: 0px;">
                <div id="luxuryCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($data_lux->chunk(2) as $key => $chunk)
                          <div class="carousel-item @if($key === 0) active @endif">
                              <div class="row">
                                  @foreach($chunk as $item)
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-lg-5" style="height: 60px;">
                                                <div class="info-table" style="border-radius: 20px; height: 300px; width: 100%;">
                                                    <ul>
                                                        <li style="margin-bottom: 0px; padding-bottom: 0px; border-bottom: 1px solid #284898;">Capacité: <span style="font-size: 15px; color:#e42320;">{{$item->capacite}} Places</span></li>
                                                        <li style="margin-bottom: 0px; padding-bottom: 0px; border-bottom: 1px solid #284898;">Puissance: <span style="font-size: 15px; color:#e42320;">{{$item->puissance}} CVE</span></li>
                                                        <li style="margin-bottom: 0px; padding-bottom: 0px; border-bottom: 1px solid #284898;">Prix: <span style="font-size: 15px; color:#e42320;">{{$item->montant_journalier}}/J</span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-lg-7">
                                                <div class="info-table" style="padding:0; border-radius:20px;">
                                                  <a href="{{route('voiture.details', ['voitureId' => $voiture->id])}}"> <img src="{{ asset('storage/' . $item->image) }}" class="img-fluid" alt=""> </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                  @endforeach
                              </div>
                          </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev d-none" type="button" data-bs-target="#luxuryCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next d-none" type="button" data-bs-target="#luxuryCarousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
  </div>

  <div class="video section mt-10">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 offset-lg-3">
          <div class="section-heading text-center">
            <h6>| Laissez vous guider</h6>
            <h2 class="animated-title" style="color:#fff">par notre expertise</h2>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6 text-center">
          <div class="service-1">
            <span class="service-1-icon">
              <span class="icon-circle">
                <a href="{{route('services')}}">
                  <i class="fas fa-car fa-3x icon-white"></i>
              </a>
              </span>
            </span>
            <div class="service-1-contents">
              <a class="text-white" href="{{route('services')}}">Location des voitures</a>
            </div>
          </div>
        </div>
        <div class="col-lg-6 text-center">
          <div class="service-1">
            <span class="service-1-icon">
              <span class="icon-circle">
                <a href="{{route('services')}}">
                  <i class="fas fa-map-location-dot fa-3x icon-white"></i>
                  </a> 
              </span>
            </span>
            <div class="service-1-contents">
              <a href="{{route('services')}}" class="text-white">Vente et installation des trackers GPS</a>
            </div>
          </div>
        </div>
        
      </div> 
    </div>
  </div>

  <div class="video-content" style="margin-top: 20px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="video-frame text-center">
                    <video width="800" height="500" controls class="img-fluid" >
                        <source src="{{ asset('frontend/assets/images/video.mp4') }}" type="video/mp4">
                        Video
                    </video>
                    <p class="text-white">Bienvenue sur DreamCars - Découvrez l'expérience ultime de conduite avec nos voitures de luxe.</p>
                </div>
            </div>
        </div>
    </div>
  </div>


  <div class="container-fluid project py-5 my-5">
    <div class="container py-5">
        <div class="text-center mx-auto pb-5 wow fadeIn animate__animated animate__fadeInDown" data-wow-delay=".3s" style="max-width: 600px;">
            <h5 class="text-primary">Nos Références</h5>
            <h1 class="animated-title">Nos dernières missions</h1>
        </div>
        <div class="row g-5">
            @foreach($missions as $mission)
                <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay=".3s">
                    <div class="mission-item">
                        <div>
                            <p>{{ $mission['description'] }}</p>
                            <div class="mission-content">
                                <a href="#" class="text-center">
                                    <h4 >{{ $mission['titre'] }}</h4>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
  </div>
</div>
  

  <div class="contact section">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 offset-lg-4">
          <div class="section-heading text-center">
            <h6>| Contactez Nous</h6>
            <h2 class="animated-title">Notre Agence est à l'écoute de vos besoins</h2>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="contact-content">
    <div class="container">
      <div class="row">
        <div class="col-lg-7" class="container-fluid">
          <div id="map" class="container-fluid">
            <iframe
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.6655368515817!2d1.1784301099700736!3d6.175511227084818!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x102159c2794656df%3A0x83a1c74acd3a4b7c!2sAgence%20Excelsior!5e0!3m2!1sen!2stg!4v1699445102679!5m2!1sen!2stg"
              width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
          <div class="row">
            <div class="col-lg-7">
              <div class="item phone">
                <i class="fa fa-phone-volume fa-2x" style="margin-right:10px;"></i>
                <i class="fab fa-whatsapp fa-2x" style="margin-right:10px;"></i>
                <h6 style="display: inline-block;" >90693088<br><span>Téléphone</span></h6>
              </div>
            </div>
            <div class="col-lg-8 ps-0 mt-4">
              <div class="item email">
                <i class="fa fa-envelope fa-2x" style="margin-right:10px;"></i>
                <h6 style="display: inline-block;">dreamcarstogo@gmail.com<br><span>Adresse Mail</span></h6>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-5">
          <form id="contact-form" action="{{route('messages.store')}}" method="POST">
            @csrf
            <div class="row">
              <div class="col-lg-12">
                <fieldset>
                  <label for="noms" style="color: #e42320">Nom et Prenoms</label>
                  <input type="text" name="noms" id="noms" placeholder="Votre Nom..." autocomplete="on" required>
                </fieldset>
              </div>
              <div class="col-lg-12">
                <fieldset>
                  <label for="email" style="color: #e42320">Adresse mail</label>
                  <input type="text" name="email" id="email" pattern="[^ @]*@[^ @]*" placeholder="Votre adresse..."
                    required="">
                </fieldset>
              </div>
              <div class="col-lg-12">
                <fieldset>
                  <label for="sujet" style="color: #e42320">Sujet</label>
                  <input type="text" name="sujet" id="sujet" placeholder="Sujet..." autocomplete="on">
                </fieldset>
              </div>
              <div class="col-lg-12">
                <fieldset>
                  <label for="contenu" style="color: #e42320">Message</label>
                  <textarea name="contenu" id="contenu" placeholder="Votre message"></textarea>
                </fieldset>
              </div>
              <div class="col-lg-12">
                <fieldset>
                  <button type="submit" id="form-submit" class="orange-button">Envoyer</button>
                </fieldset>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    @foreach($voitures_disponibles as $voiture)
      var myModal{{ $voiture->id }} = new bootstrap.Modal(document.getElementById('detailsModal{{$voiture->id}}'))
    @endforeach

  </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
<script>
  new WOW().init(); // Initialiser wow.js
</script>




<script src="{{ asset('frontend/assets/js/scroll-to-top.js') }}"></script>
@endsection
