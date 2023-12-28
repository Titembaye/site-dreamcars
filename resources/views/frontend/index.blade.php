<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <title>@yield('title')</title>
    <link rel="shortcut icon" href="{{asset('frontend/assets/images/logo.png')}}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v6.0.0-beta1/css/all.min.css" integrity="..." crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>

  
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <!-- Bootstrap core CSS -->
    <link href="{{asset('frontend/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">


    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="{{asset('frontend/assets/css/fontawesome.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/assets/css/templatemo-villa-agency.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/assets/css/owl.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/assets/css/animate.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/assets/css/style.css')}}">
    <link rel="stylesheet"href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>

    <style>
      /* Réduire la taille des boutons "Prev" et "Next" du carrousel */
      .carousel-control-prev,
      .carousel-control-next {
        font-size: 1rem; /* Taille du texte */
        width: 30px; /* Largeur du bouton */
        height: 30px; /* Hauteur du bouton */
        line-height: 30px; /* Hauteur de la ligne de texte */
      }
    </style>
    

  </head>

  <body>

      <!-- ***** Preloader Start ***** -->
    @include('frontend.body.header')
      <!-- ***** Header Area End ***** -->

    @yield('content')

      <button id="btnScrollToTop" class="btn-scroll-to-top">↑</button>
      @include('frontend.body.footer')
     
      <!-- Scripts -->
      <!-- Bootstrap core JavaScript -->
      <script src="{{asset('frontend/vendor/jquery/jquery.min.js')}}"></script>
      <script src="{{asset('frontend/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
      <script src="{{asset('frontend/assets/js/isotope.min.js')}}"></script>
      <script src="{{asset('frontend/assets/js/owl-carousel.js')}}"></script>
      <script src="{{asset('frontend/assets/js/counter.js')}}"></script>
      <script src="{{asset('frontend/assets/js/custom.js')}}"></script>
     

      <script>
        // Sélectionnez les éléments du carrousel
        const carouselItems = document.querySelectorAll('.owl-banner .item');
        let currentIndex = 0;

        // Fonction pour afficher l'image suivante
        function nextSlide() {
          carouselItems[currentIndex].style.display = 'none';
          currentIndex = (currentIndex + 1) % carouselItems.length;
          carouselItems[currentIndex].style.display = 'block';
        }

        // Préchargez les images avant de commencer le carrousel automatique
        function preloadImages() {
          const imagesToPreload = [];
          carouselItems.forEach((item, index) => {
            const img = new Image();
            img.src = carouselItems[index].querySelector('img').src;
            img.onload = () => {
              imagesToPreload.push(img);
              if (imagesToPreload.length === carouselItems.length) {
                // Toutes les images sont préchargées, commencez le carrousel
                setInterval(nextSlide, 3000); // Change l'image toutes les 3 secondes (ajustez selon vos besoins)
              }
            };
          });
        }

        // Appelez la fonction pour précharger les images
        preloadImages();
    </script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    var successToast = new bootstrap.Toast(document.getElementById('success-toast'));

    // Show the toast
    if (successToast) {
      successToast.show();

      // Hide the toast after 3 seconds
      setTimeout(function () {
        successToast.hide();
      }, 3000);
    }
  });
</script>



<script>
  document.addEventListener('DOMContentLoaded', function () {
    var myCarousel = new bootstrap.Carousel(document.getElementById('carrouselVoitures'));
  });
</script>



<!-- Add this just before the closing </body> tag -->
      <script src="https://cdn.jsdelivr.net/npm/owl.carousel@2.3.4/dist/owl.carousel.min.js"></script>
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
   

    <script>
      $(document).ready(function(){
      $(".owl-carousel").owlCarousel({
        items: 1,
        loop: true,
        autoplay: true,
        autoplayTimeout: 2000, // ou toute autre valeur en millisecondes
        autoplayHoverPause: true // arrête le défilement automatique au survol
        // d'autres options...
      });
    });
    
    </script>

    <!-- Ajoutez cela à votre fichier blade principal, par exemple, resources/views/layouts/index.blade.php -->
  <script>
    // Supposons que vous utilisez jQuery pour simplifier le code
    $(document).ready(function() {
        $('#search-form').submit(function(event) {
            event.preventDefault();

            // Récupérez les valeurs des filtres
            var query = $('input[name="query"]').val();
            var brand = $('select[name="brand"]').val();
            var model = $('select[name="model"]').val();
            var power = $('select[name="power"]').val();

            // Utilisez ces valeurs pour effectuer une requête AJAX
            $.ajax({
                url: '{{ route("search.index") }}',
                type: 'GET',
                data: {
                    query: query,
                    brand: brand,
                    model: model,
                    power: power
                },
                success: function(response) {
                    // Mettez à jour la section des résultats avec la nouvelle réponse
                    $('.search-results').html(response);
                },
                error: function(error) {
                    console.error('Une erreur s\'est produite lors de la recherche.', error);
                }
            });
        });
    });
  </script>

  </body>
</html>