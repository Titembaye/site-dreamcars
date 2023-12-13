@extends('frontend.index')
<link rel="stylesheet" href="{{ asset('frontend/assets/css/scroll-to-top.css') }}">
@section('title')
  DreamCars - Voitures
@endsection('title')
@section('content')
  <div class="page-heading header-text">
    <div class="container">
      <div class="row">
        <div class="col-lg-12" style="width: 0px;">
          <span class="breadcrumb" style="width: 0px;"></span>
          <h3> <br> </h3>
        </div>
      </div>
    </div>
  </div>

  <div class="section properties">
    <div class="container">
      <ul class="properties-filter">
        <li></li>
        <li>
          <a class="{{ request()->routeIs('all_properties', 'properties') ? 'active' : '' }}" href="{{route('all_properties')}}">Toutes nos voitures</a>
        </li>
        <li>
            <a class="{{ request()->routeIs('dispo_properties') ? 'active' : '' }}" href="{{route('dispo_properties')}}">Disponibles</a>
        </li>
      </ul>
      @yield('property_content')
</div>
</div>



<script>
  document.addEventListener("DOMContentLoaded", function () {
    // Sélectionnez tous les boutons de filtre
    const filterButtons = document.querySelectorAll('.filter-btn');

    // Attachez un gestionnaire d'événements à chaque bouton de filtre
    filterButtons.forEach(function(button) {
      button.addEventListener('click', function() {
        // Récupérez la classe de filtre à partir de l'attribut data-filter
        const filterClass = button.getAttribute('data-filter');

        // Masquer toutes les sections de voitures
        document.querySelectorAll('.voiture-section').forEach(function (section) {
          section.style.display = 'none';
        });

        // Afficher la section de voiture correspondant à la classe de filtre
        document.querySelectorAll('.' + filterClass).forEach(function (section) {
          section.style.display = 'flex';
        });

        // Mettez à jour la classe active pour les boutons de filtre
        filterButtons.forEach(function(btn) {
          btn.classList.remove('is_active');
        });
        button.classList.add('is_active');
      });
    });
  });
</script>
<script src="{{ asset('frontend/assets/js/scroll-to-top.js') }}"></script>
@endsection  