<nav class="navbar">
				<a href="#" class="sidebar-toggler">
					<i data-feather="menu"></i>
				</a>
				<div class="navbar-content">
					<form class="search-form" id="real-time-search-form">
						<div class="input-group">
              <div class="input-group-text">
                <i data-feather="search"></i>
              </div>
							<input type="text" class="form-control" id="navbarForm" placeholder="Rechercher...">
						</div>
					</form>
        

					<ul class="navbar-nav">
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="appsDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i data-feather="grid"></i>
							</a>
							<div class="dropdown-menu p-0" aria-labelledby="appsDropdown">
               
                <div class="row g-0 p-1">
                  <div class="col-3 text-center">
                    <a href="{{route('reservations.index')}}" class="dropdown-item d-flex flex-column align-items-center justify-content-center wd-70 ht-70"><i data-feather="command" class="icon-lg mb-1"></i><p class="tx-12">Reservations</p></a>
                  </div>
                  <div class="col-3 text-center">
                    <a href="{{route('missions.index')}}" class="dropdown-item d-flex flex-column align-items-center justify-content-center wd-70 ht-70"><i data-feather="speaker" class="icon-lg mb-1"></i><p class="tx-12">Missions</p></a>
                  </div>
                  <div class="col-3 text-center">
                    <a href="{{route('disponibilites.index')}}" class="dropdown-item d-flex flex-column align-items-center justify-content-center wd-70 ht-70"><i data-feather="slack" class="icon-lg mb-1"></i><p class="tx-12">Disponibilités</p></a>
                  </div>
                </div>
								
							</div>
						</li>
						
            @php
              $id=Auth::user()->id;
              $profileData=App\Models\User::find($id);
            @endphp
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<img class="wd-30 ht-30 rounded-circle" src="{{(!empty($profileData->photo)) ? url('upload/admin_images/'.$profileData->photo) : url('upload/no_image.jpg') }}" alt="profile">
							</a>
							<div class="dropdown-menu p-0" aria-labelledby="profileDropdown">
								<div class="d-flex flex-column align-items-center border-bottom px-5 py-3">
									<div class="mb-3">
										<img class="wd-80 ht-80 rounded-circle" src="{{(!empty($profileData->photo)) ? url('upload/admin_images/'.$profileData->photo) : url('upload/no_image.jpg') }}" alt="">
									</div>
									<div class="text-center">
										<p class="tx-16 fw-bolder">{{$profileData->name}}</p>
										<p class="tx-12 text-muted">{{$profileData->email}}</p>
									</div>
								</div>
                <ul class="list-unstyled p-1">
                  <li class="dropdown-item py-2">
                    <a href="{{route('admin.profile')}}" class="text-body ms-0">
                      <i class="me-2 icon-md" data-feather="user"></i>
                      <span>Profile</span>
                    </a>
                  </li>
                  <li class="dropdown-item py-2">
                    <a href="{{route('admin.change.password')}}" class="text-body ms-0">
                      <i class="me-2 icon-md" data-feather="edit"></i>
                      <span>Modifier le mot de pass</span>
                    </a>
                  </li>
                  <li class="dropdown-item py-2">
                    <a href="javascript:;" class="text-body ms-0">
                      <i class="me-2 icon-md" data-feather="repeat"></i>
                      <span>Switch User</span>
                    </a>
                  </li>
                  <li class="dropdown-item py-2">
                    <a href="{{route('admin.logout')}}" class="text-body ms-0">
                      <i class="me-2 icon-md" data-feather="log-out"></i>
                      <span>Log Out</span>
                    </a>
                  </li>
                </ul>
            </div>
        </li>
    </ul>
</div>
</nav>

<!-- Assurez-vous d'inclure jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- Votre script JavaScript -->
<script>
    $(document).ready(function () {
        // Écoutez les changements dans le champ de recherche
        $('#navbarForm').on('input', function () {
            // Récupérez la valeur du champ de recherche
            var query = $(this).val();

            // Effectuez une requête Ajax pour récupérer les résultats de la recherche
            $.ajax({
                type: 'GET',
                url: '/dashboard/recherche', // Remplacez par l'URL de votre route de recherche
                data: {query: query},
                success: function (data) {
                    // Mettez à jour l'affichage des résultats (à adapter selon vos besoins)
                    console.log(data);
                },
                error: function (error) {
                    console.error('Erreur lors de la recherche :', error);
                }
            });
        });
    });
</script>
