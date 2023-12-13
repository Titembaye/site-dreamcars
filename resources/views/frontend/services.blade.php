@extends('frontend.index')
<link rel="stylesheet" href="{{ asset('frontend/assets/css/scroll-to-top.css') }}">
@section('title')
  DreamCars - services
@endsection('title')
@section('content')
<style>

li {
   
    margin-bottom: 10px;
    position: relative;
    padding-left: 20px;
}


.service-text{
    margin: 20px
}

.service-content{
    
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    text-align: justify;
    transition: transform 0.3s ease-in-out;
    
  }

.service-content:hover{
    transform: scale(1.07);
    background-color: #e42320;
  }

  .service-content:hover ul li, .service-content:hover h4, .service-content:hover ul .icon-hover{
    color: #fff;
  }

</style>


<!-- Votre contenu HTML ici -->

<div class="page-heading header-text">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <span class="breadcrumb"></span>
          <h4><br></h4>
        </div>
      </div>
    </div>
  </div>



  <div class="service-container container">
    <div class="row service">
      <div class="col-lg-5">
        <img src="{{asset('frontend/assets/images/service_1.jpg')}}" alt="Service 1 Image">
      </div>
      <div class=" col-lg-6 service-text mx-auto">
        <h3 class="text-title">véhicules de remplacement</h3> <br>
        <p class="text-justify">Profitez de notre offre exclusive conçue spécialement pour les compagnies 
          d'assurances. Bénéficiez de notre service d'assistance dédié et assurez-vous 
          une mise à disposition rapide de véhicules de remplacement pour vos clients.</p>

                <h4 class="rotate-title">Procédure et Conditions</h4>
                <ul style="list-style: none; padding: 0; margin:10px">
                    <li style="padding-left: 10px; color:#fff"> <i class="fas fa-check-circle" style="color: #e42320;"></i> Facturation basé sur les tarifs de la compagnie d'assurance concernée.</li>
                    <li style="padding-left: 10px;color:#fff"> <i class="fas fa-book" style="color: #e42320;"></i> Location sans chauffeur.</li>
                    <li style="padding-left: 10px;color:#fff"> <i class="fas fa-clock" style="color: #e42320;"></i>  Paiement après prestation.</li>
                    <li style="padding-left: 10px;color:#fff"> <i class="fas fa-file-contract" style="color: #e42320;"></i>  Contrat à faire au nom de la compagnie d'assurance.</li>
                </ul>
            </div>
        </div>
      </div>
      <div class="row service">
          <div class="col-lg-6 service-text mx-auto">
              <h2 class="mb-4 text-title" style="color: #e42320;">Location Classique</h2>
              <p>Optez-vous pour des missions ponctuelles? Préférez-vous une location horaire ou 
                journalière? Découvrez notre service de location classique qui met à votre disposition une variété de véhicules.
                Profitez d'une flexibilité totale en termes de durée et d'itinéraire selon vos préférences.</p>
              <div class="row main-service mt-3" id="location">
                  <div class="col-md-6 mb-4">
                      <div class="card bg-light border-0 shadow-sm service-card">
                        <div class="service-content p-3">
                          <h4>Missions ponctuelles</h4>
                          <ul>
                              <li><i class="fas fa-star icon-hover" style="color: #284898;"></i> Prestation VIP</li>
                              <li><i class="fas fa-check-circle icon-hover" style="color: #284898;"></i> Services tout inclus</li>
                              <li><i class="fas fa-clock icon-hover" style="color: #284898;"></i> Durée Maxi de prestation 3H</li>
                              <li><i class="fas fa-dollar-sign icon-hover" style="color: #284898;"></i> Coût et distance totale variables</li>
                              <li><i class="fas fa-clock icon-hover" style="color: #284898;"></i> Disponible 24H/24 avec réservation 12 H à l'avance</li>
                          </ul>
                      </div>                    
                    </div>
                  </div>
                  <div class="col-md-6 mb-4">
                      <div class="card bg-light border-0 shadow-sm service-card">
                          <div class="service-content p-3">
                              <h4>Taxi heure</h4>
                              <ul>
                                <li><i class="fas fa-clock icon-hover" style="color: #284898;"></i> La 1ère  heure à 4900F.</li>
                                <li><i class="fas fa-car icon-hover" style="color: #284898;"></i> Véhicule utilisé : Mini SUV, Berline, Compacte. </li>
                                <li><i class="fas fa-map-marker-alt icon-hover" style="color: #284898;"></i> Course se déroulant exclusivement dans la ville de Lomé. </li>
                                <li><i class="fas fa-clock icon-hover" style="color: #284898;"></i> Disponible 24H/24. </li>
                            </ul>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6 mb-4">
                      <div class="card bg-light border-0 shadow-sm service-card">
                          <div class="service-content p-3">
                              <h4>Location journalière</h4>
                              <ul>
                                <li> <i class="fas fa-clock icon hover" style="color: #284898;"></i> Location à la journée</li>
                                <li> <i class="fas fa-car-alt icon-hover" style="color: #284898;"></i> La location concerne toutes les voitures de la flotte </li>
                                <li> <i class="fas fa-dollar-sign icon-hover" style="color: #284898;"></i> Les tarifs sont variables </li>
                                <li> <i class="fas fa-clock icon-hover" style="color: #284898;"></i>  Réservation 24H à l'avance </li>
                              </ul>
                          </div>
                      </div>
                  </div>
                  
              </div>
          </div>
          <div class="col-lg-4 mx-auto pt-4 pt-lg-0 d-flex align-items-center">
              <img src="{{asset('frontend/assets/images/service_2.jpg')}}" alt="Service 2 Image" class="img-fluid">
          </div>
      </div>
      <div class="container-fluid gps-section py-2 my-1">
        <div class="container py-5">
            <div class="text-center mx-auto pb-5 wow fadeIn animate__animated animate__fadeInDown" data-wow-delay=".3s" style="max-width: 600px;">
                <h5 class="text-primary text-title"> Services GPS</h5>
            </div>
            <div class="row g-5">
                <div class="col-md-6 col-lg-6 wow fadeIn" data-wow-delay=".3s">
                    <div class="gps-item">
                        <div>
                            <p>Optimisez la gestion de votre flotte avec nos traceurs GPS de pointe. Nous proposons l'installation professionnelle de ces dispositifs pour vous assurer une traçabilité efficace de vos véhicules.</p>
                            <p>Que ce soit pour renforcer la sécurité de votre flotte ou améliorer l'efficacité opérationnelle, nos solutions GPS sur mesure répondent à vos besoins spécifiques.</p>
                        </div>
                        <div class="text-center">
                            <img src="{{asset('frontend/assets/images/gps_1.jpg')}}" alt="Installation GPS" class="img-fluid">
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 wow fadeIn" data-wow-delay=".3s">
                    <div class="gps-item">
                        <div>
                            <p>En plus de nos services d'installation, nous proposons également une gamme variée de traceurs GPS de haute qualité à la vente. Choisissez parmi notre sélection pour équiper vos véhicules avec des dispositifs fiables et performants.</p>
                            <p>Nos experts sont à votre disposition pour vous conseiller sur le choix du traceur GPS le mieux adapté à vos besoins spécifiques.</p>
                        </div>
                        <div class="text-center">
                            <img src="{{asset('frontend/assets/images/gps_2.jpg')}}" alt="Vente de Traceurs GPS" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
  
  

  <!-- Project Start -->
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
<!-- Project  End -->

  
  
  <script>
     document.addEventListener("DOMContentLoaded", function() {
      document.getElementById("locationBtn").click();
    });  
    

    function showServices(serviceId) {
      // Masquer tous les sous-services
      document.querySelectorAll('.service').forEach(function (subService) {
        subService.style.display = 'none';
      });
  
      // Afficher les sous-services correspondants au service sélectionné
      document.getElementById(serviceId).querySelectorAll('.service').forEach(function (subService) {
        subService.style.display = 'flex';
      });
      if (window.innerWidth <= 768) {
    document.getElementById('location').style.display = 'flex';
    document.getElementById('gps').style.display = 'flex';
  }
    }
  </script>

  <script src="{{ asset('frontend/assets/js/scroll-to-top.js') }}"></script>
@endsection
