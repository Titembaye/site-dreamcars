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
          
            <li class="nav-item">
              <a class="nav-link" data-bs-toggle="collapse" href="#advancedUI" role="button" aria-expanded="false" aria-controls="advancedUI">
                <i class="link-icon" data-feather="truck"></i>
                
                <span class="link-title">Gestion des voitures</span>
                <i class="link-arrow" data-feather="chevron-down"></i>
              </a>
              <div class="collapse" id="advancedUI">
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
            <li class="nav-item">
              <a class="nav-link" data-bs-toggle="collapse" href="#advancedUI" role="button" aria-expanded="false" aria-controls="advancedUI">
                <i class="link-icon" data-feather="slack"></i>
                <span class="link-title">Gestion des locations</span>
                <i class="link-arrow" data-feather="chevron-down"></i>
              </a>
              <div class="collapse" id="advancedUI">
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

            <li class="nav-item">
              <a class="nav-link" data-bs-toggle="collapse" href="#advancedUI" role="button" aria-expanded="false" aria-controls="advancedUI">
                <i class="link-icon" data-feather="command"></i>
                <span class="link-title">Gestion des reservations</span>
                <i class="link-arrow" data-feather="chevron-down"></i>
              </a>
              <div class="collapse" id="advancedUI">
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
           
          </li>
          <li class="nav-item nav-category">AGENCE</li>
          
            <li class="nav-item">
              <a class="nav-link" data-bs-toggle="collapse" href="#advancedUI" role="button" aria-expanded="false" aria-controls="advancedUI">
                <i class="link-icon" data-feather="briefcase"></i>
                <span class="link-title">Gestion des Agences</span>
                <i class="link-arrow" data-feather="chevron-down"></i>
              </a>
              <div class="collapse" id="advancedUI">
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
            
            <li class="nav-item">
              <a class="nav-link" data-bs-toggle="collapse" href="#advancedUI" role="button" aria-expanded="false" aria-controls="advancedUI">
                <i class="link-icon" data-feather="anchor"></i>
                <span class="link-title">Gestion des Chauffeurs</span>
                <i class="link-arrow" data-feather="chevron-down"></i>
              </a>
              <div class="collapse" id="advancedUI">
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
          </li>


          
        </ul>
      </div>
    </nav>