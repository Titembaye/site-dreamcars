@extends('admin.admin_dashboard')
@section('title')
    DreamCars - Voitures
@endsection('title')
@section('admin')
<div class="row m-5">
    <div class="col-md-12 grid-margin stretch-card mt-5">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Liste des voitures</h6>
                <div class="row justify-content-between mb-3">
    
                    <div class="col-md-4">
                        <a class="btn btn-primary btn-sm" href="{{route('voitures.create')}}">Ajouter</a>
                    </div>
                    
                    <div class="col-md-4 text-right" style="text-align: right;">
                        <form action="{{ route('voitures.index') }}" method="GET" class="search-form">
                            <div class="input-group">
                                <div class="input-group-text">
                                    <i data-feather="search"></i>
                                </div>
                                <input type="text" class="form-control" name="query" placeholder="Rechercher...">
                                <button type="submit" class="btn btn-primary">Rechercher</button>
                            </div>
                        </form>
                    </div>
                    

                    
                </div>
                <div class="table-responsive" style="margin-top: 20px">
                    <table id="dataTableExample" class="table">
                        <thead>
                            <tr>
                            <th>Immatriculation</th>
                            <th>Marque</th>
                            <th>Modèle</th>
                            <th>Année</th>
                            <th>Action</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @foreach($voitures as $voiture)
                            <tr>
                                <td>{{$voiture->immatriculation}}</td>
                                <td>{{$voiture->marque}}</td>
                                <td>{{$voiture->modele}}</td>
                                <td>{{$voiture->annee}}</td>
                                <!-- ... Autre contenu de la vue ... -->
                                <td class="d-flex">
                                    <a href="{{ route('voitures.show', $voiture->id) }}" class="btn btn-primary btn-circle ">
                                        <i class="mdi mdi-eye"></i>
                                    </a>
                                    <a href="{{ route('voitures.edit', $voiture->id) }}" class="btn btn-success btn-circle btn-sm">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>
                                    <form action="{{ route('voitures.destroy', $voiture->id) }} " method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-circle btn-sm">
                                            
                                        <i class="mdi mdi-delete"></i>
                                                                        
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach 
                        </tbody>
                    </table>
                    <div class="row justify-content-between mt-3">
                        <div class="col-sm-12 col-md-5">
                            <div class="dataTables_info" id="dataTableExample_info" role="status" aria-live="polite">
                            <div class="dataTables_info" id="dataTableExample_info" role="status" aria-live="polite">
                                Affichage de {{ $voitures->firstItem() }} à {{ $voitures->lastItem() }} des {{ $voitures->total() }} entrées
                            </div>

                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                        <div class="dataTables_paginate paging_simple_numbers" id="dataTableExample_paginate">
                                <ul class="pagination">
                                    @if ($voitures->onFirstPage())
                                        <li class="paginate_button page-item previous disabled" id="dataTableExample_previous">
                                            <span class="page-link">Previous</span>
                                        </li>
                                    @else
                                        <li class="paginate_button page-item previous" id="dataTableExample_previous">
                                            <a href="{{ $voitures->previousPageUrl() }}" aria-controls="dataTableExample" tabindex="0" class="page-link">Previous</a>
                                        </li>
                                    @endif

                                    @foreach ($voitures->getUrlRange(1, $voitures->lastPage()) as $page => $url)
                                        <li class="paginate_button page-item {{ $page == $voitures->currentPage() ? 'active' : '' }}">
                                            <a href="{{ $url }}" aria-controls="dataTableExample" tabindex="0" class="page-link">{{ $page }}</a>
                                        </li>
                                    @endforeach

                                    @if ($voitures->hasMorePages())
                                        <li class="paginate_button page-item next" id="dataTableExample_next">
                                            <a href="{{ $voitures->nextPageUrl() }}" aria-controls="dataTableExample" tabindex="0" class="page-link">Next</a>
                                        </li>
                                    @else
                                        <li class="paginate_button page-item next disabled" id="dataTableExample_next">
                                            <span class="page-link">Next</span>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    // JavaScript pour sélectionner automatiquement la valeur de la liste déroulante
    document.addEventListener('DOMContentLoaded', function () {
        var entriesPerPageSelect = document.getElementById('entriesPerPage');
        
        // Écouteur d'événements pour détecter le changement de la pagination
        entriesPerPageSelect.addEventListener('change', function() {
            // Mettez à jour la valeur du nombre d'entrées par page dans le cookie ou le stockage local
        });

        // Récupérer la valeur du nombre d'entrées par page dans le cookie ou le stockage local
        var entriesPerPageValue = localStorage.getItem('entriesPerPage') || 10;

        // Sélectionner la valeur dans la liste déroulante
        entriesPerPageSelect.value = entriesPerPageValue;
    });
</script>
<!-- resources/views/admin/voitures/index.blade.php -->
<!-- resources/views/admin/voitures/index.blade.php -->
<script>
    $(document).ready(function () {
        // Listen for changes in the search input
        $('#navbarForm').on('input', function () {
            // Get the search query
            var query = $(this).val();

            // Perform an AJAX request to the search route
            $.ajax({
                type: 'GET',
                url: '{{ route('voitures.search') }}',
                data: {query: query},
                success: function (data) {
                    // Update the display with the search results
                    console.log(data.voitures);

                    // Render the search results in the view
                    renderSearchResults(data.voitures);
                },
                error: function (error) {
                    console.error('Error during search:', error);
                }
            });
        });

        // Function to render search results in the view
        function renderSearchResults(voitures) {
            // Assuming you have a container to display search results with ID 'searchResults'
            var resultsContainer = $('#searchResults');

            // Clear previous search results
            resultsContainer.empty();

            // Append each result to the container
            voitures.forEach(function (voiture) {
                // Customize this part based on your data structure
                var resultItem = '<div>' + voiture.immatriculation + ' - ' + voiture.marque + '</div>';
                resultsContainer.append(resultItem);
            });
        }
    });
</script>

 
@endsection