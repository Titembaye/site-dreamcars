@extends('frontend.index')
<link rel="stylesheet" href="{{ asset('frontend/assets/css/scroll-to-top.css') }}">
@section('title')
  DreamCars - contact
@endsection('title')
  @section('content')
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

  <div class="contact-page section">
    <div class="container">
      <div class="row">
        <div class="col-lg-6">
          <div class="section-heading" >
            <h6 class="text-white">| Contactez Nous</h6>
            <h3 class="col-lg-12 text-justify text-white">Notre Agence est à l'écoute de vos préoccupations</h3>
          </div>
          <p class="text-justify">Chez DreamCars, nous nous consacrons à vous offrir une expérience de 
            location de voiture exceptionnelle, que ce soit pour un voyage d'affaires ou des 
            déplacements en ville. Nous sommes là pour répondre à l'ensemble de vos besoins en matière 
            de location de véhicules.
             N'hésitez pas à nous contacter pour toute question ou préoccupation. </p>
          <div class="row">
            <div class="col-lg-12">
              <div class="item phone">
                <i class="fa fa-phone-volume fa-2x" style="margin-right:10px;"></i>
                <i class="fab fa-whatsapp fa-2x" style="margin-right:10px;"></i>
                <h6 style="display: inline-block;" >90693088<br><span>Téléphone</span></h6>
              </div>
            </div>
            <div class="col-lg-12">
              <div class="item email">
                <i class="fa fa-envelope fa-2x" style="margin-right:10px;"></i>
                <h6 style="display: inline-block;">dreamcarstogo@gmail.com<br><span>Adresse Mail</span></h6>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-5 mx-auto">
          <form id="contact-form" action="{{route('messages.store')}}" method="post">
            @csrf
            <div class="row">
              <div class="col-lg-12">
                <fieldset>
                  <label for="noms" style="color:#e42320">Nom et Prenoms</label>
                  <input type="name" name="noms" id="noms" placeholder="Votre Noms..." autocomplete="on" required>
                </fieldset>
              </div>
              <div class="col-lg-12">
                <fieldset>
                  <label for="email" style="color:#e42320">Email Address</label>
                  <input type="text" name="email" id="email" pattern="[^ @]*@[^ @]*" placeholder="Votre adresse..." required="">
                </fieldset>
              </div>
              <div class="col-lg-12">
                <fieldset>
                  <label for="sujet" style="color:#e42320">Sujet</label>
                  <input type="text" name="sujet" id="sujet" placeholder="Sujet..." autocomplete="on" >
                </fieldset>
              </div>
              <div class="col-lg-12">
                <fieldset>
                  <label for="contenu" style="color:#e42320">Message</label>
                  <textarea name="contenu" id="contenu" placeholder="Votre Message"></textarea>
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
      <div class="row">
        <div class="col-lg-10">
            <div id="map">
              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.6655368515817!2d1.1784301099700736!3d6.175511227084818!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x102159c2794656df%3A0x83a1c74acd3a4b7c!2sAgence%20Excelsior!5e0!3m2!1sen!2stg!4v1699445102679!5m2!1sen!2stg" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
      </div>
    </div>
  </div>
  <script src="{{ asset('frontend/assets/js/scroll-to-top.js') }}"></script>
  @endsection