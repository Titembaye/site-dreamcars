<nav class="sidebar">
  <div class="sidebar-header">
      <a href="#" class="sidebar-brand">
          Dream<span>Cars</span>
      </a>
      <div class="sidebar-toggler not-active">
          <span></span>
          <span></span>
          <span></span>
      </div>
  </div>
  <div class="sidebar-body">
      <ul class="nav">

          <li class="nav-item">
              <a href="{{route('admin.dashboard')}}" class="nav-link">
                  <i class="link-icon" data-feather="users"></i>
                  <span class="link-title">UTILISATEURS</span>
              </a>
          </li>

          <li class="nav-item nav-category">RESERVATION</li>

          <li class="nav-item" id="gestionVoitures">
              <a class="nav-link" data-bs-toggle="collapse" href="#gestionVoituresSubMenu" role="button" aria-expanded="false" aria-controls="gestionVoituresSubMenu">
                  <i class="link-icon" data-feather="truck"></i>
                  <span class="link-title">Gestion des voitures</span>
                  <i class="link-arrow" data-feather="chevron-down"></i>
              </a>
              <div class="collapse" id="gestionVoituresSubMenu">
                  <ul class="nav sub-menu">
                      <li class="nav-item">
                          <a href="{{route('voitures.index')}}" class="nav-link">Liste des voitures</a>
                      </li>
                      <li class="nav-item">
                          <a href="{{route('voitures.create')}}" class="nav-link">Ajouter une voiture</a>
                      </li>
                  </ul>
              </div>
          </li>

          <li class="nav-item" id="gestionLocations">
              <a class="nav-link" data-bs-toggle="collapse" href="#gestionLocationsSubMenu" role="button" aria-expanded="false" aria-controls="gestionLocationsSubMenu">
                  <i class="link-icon" data-feather="slack"></i>
                  <span class="link-title">Gestion des locations</span>
                  <i class="link-arrow" data-feather="chevron-down"></i>
              </a>
              <div class="collapse" id="gestionLocationsSubMenu">
                  <ul class="nav sub-menu">
                      <li class="nav-item">
                          <a href="{{route('disponibilites.index')}}" class="nav-link">Disponibilités</a>
                      </li>
                      <li class="nav-item">
                          <a href="{{route('disponibilites.create')}}" class="nav-link">Ajouter une dispo</a>
                      </li>
                  </ul>
              </div>
          </li>

          <li class="nav-item" id="gestionReservations">
              <a class="nav-link" data-bs-toggle="collapse" href="#gestionReservationsSubMenu" role="button" aria-expanded="false" aria-controls="gestionReservationsSubMenu">
                  <i class="link-icon" data-feather="command"></i>
                  <span class="link-title">Gestion des reservations</span>
                  <i class="link-arrow" data-feather="chevron-down"></i>
              </a>
              <div class="collapse" id="gestionReservationsSubMenu">
                  <ul class="nav sub-menu">
                      <li class="nav-item">
                          <a href="{{route('reservations.index')}}" class="nav-link">Reservations</a>
                      </li>
                      <li class="nav-item">
                          <a href="{{route('reservations.create')}}" class="nav-link">Ajouter une reservation</a>
                      </li>
                  </ul>
              </div>
          </li>

          <li class="nav-item nav-category">AGENCE</li>

          <li class="nav-item" id="gestionAgences">
              <a class="nav-link" data-bs-toggle="collapse" href="#gestionAgencesSubMenu" role="button" aria-expanded="false" aria-controls="gestionAgencesSubMenu">
                  <i class="link-icon" data-feather="briefcase"></i>
                  <span class="link-title">Gestion des Agences</span>
                  <i class="link-arrow" data-feather="chevron-down"></i>
              </a>
              <div class="collapse" id="gestionAgencesSubMenu">
                  <ul class="nav sub-menu">
                      <li class="nav-item">
                          <a href="{{route('agences.index')}}" class="nav-link">Liste des agences</a>
                      </li>
                      <li class="nav-item">
                          <a href="{{route('agences.create')}}" class="nav-link">Ajouter une agence</a>
                      </li>
                  </ul>
              </div>
          </li>

          <li class="nav-item" id="gestionChauffeurs">
              <a class="nav-link" data-bs-toggle="collapse" href="#gestionChauffeursSubMenu" role="button" aria-expanded="false" aria-controls="gestionChauffeursSubMenu">
                  <i class="link-icon" data-feather="anchor"></i>
                  <span class="link-title">Gestion des Chauffeurs</span>
                  <i class="link-arrow" data-feather="chevron-down"></i>
              </a>
              <div class="collapse" id="gestionChauffeursSubMenu">
                  <ul class="nav sub-menu">
                      <li class="nav-item">
                          <a href="{{route('chauffeurs.index')}}" class="nav-link">Liste des chauffeurs</a>
                      </li>
                      <li class="nav-item">
                          <a href="{{route('chauffeurs.create')}}" class="nav-link">Ajouter un chauffeur</a>
                      </li>
                  </ul>
              </div>
          </li>
          <li class="nav-item" id="gestionMessages">
            <a class="nav-link" data-bs-toggle="collapse" href="#gestionMessagesSubMenu" role="button" aria-expanded="false" aria-controls="gestionMessagesSubMenu">
                <i class="link-icon" data-feather="mail"></i>
                <span class="link-title">Messages</span>
                <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="gestionMessagesSubMenu">
                <ul class="nav sub-menu">
                    <li class="nav-item">
                        <a href="{{route('messagesList')}}" class="nav-link">Liste des chauffeurs</a>
                    </li>
                </ul>
            </div>
        </li>
      </ul>
  </div>
</nav>

<!-- Ajoutez ce script à la fin de votre fichier Blade -->
<script>
    $(document).ready(function () {
    // Récupérez le chemin actuel de la page
    var currentPath = window.location.pathname;

    // Itérez sur chaque élément de menu et vérifiez s'il correspond à la page active
    $('.nav-link').each(function () {
        var linkPath = $(this).attr('href');

        // Vérifiez si le chemin actuel est égal au lien du menu et s'il ne s'agit pas d'un lien d'ajout
        if (currentPath === linkPath && !linkPath.includes('create')) {
            // Ajoutez la classe "active" à l'élément de menu actuel
            $(this).addClass('active');

            // Affichez le sous-menu s'il y en a un
            $(this).parents('.collapse').addClass('show');

            // Arrêtez la boucle une fois que l'élément de menu actif est trouvé
            return false;
        }
    });

    // Empêchez l'ouverture des autres sous-menus lors du clic sur le bouton "Ajouter"
    $('.nav .nav-link[data-bs-toggle="collapse"]').on('click', function (e) {
        // Si le lien du bouton "Ajouter" contient la chaîne "create", empêchez la propagation de l'événement de clic
        if ($(this).find('a[href*="create"]').length > 0) {
            e.stopPropagation();
        }
    });

    // Gérez l'affichage des sous-menus lors du clic sur un élément de menu avec un sous-menu
    $('.nav .nav-link[data-bs-toggle="collapse"]').on('click', function (e) {
        var isAddLink = $(this).find('a[href*="create"]').length > 0;

        // Si le lien n'est pas un lien "Ajouter", gestion normale de l'affichage des sous-menus
        if (!isAddLink) {
            var collapseElement = $(this).attr('href');
            var isCollapsed = $(collapseElement).hasClass('show');

            // Fermez tous les sous-menus
            $('.collapse').removeClass('show');

            // Si le sous-menu n'était pas déjà ouvert, ouvrez-le
            if (!isCollapsed) {
                $(collapseElement).addClass('show');
            }
        }
    });
});

</script>
