@extends('admin.admin_dashboard')
@section('title')
    DreamCars - Chauffeurs
@endsection('title')
@section('admin')
<div class="row m-5">
    <div class="col-md-12 grid-margin stretch-card mt-5">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Liste des chauffeurs</h6>
                <div class="row justify-content between">
                    <div class="col-md-8">
                        <a class="btn btn-primary btn-sm" href="{{route('chauffeurs.create')}}">Ajouter</a>
                    </div>
                    
                    <div class="col-md-4 text-right" style="text-align: right;">
                        <form action="{{ route('chauffeurs.index') }}" method="GET" class="search-form">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" value="{{ $search }}" placeholder="Rechercher...">
                                <button type="submit" class="btn btn-primary btn-sm">Rechercher</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="table-responsive" style="margin-top: 20px">
                    <table id="dataTableExample" class="table">
                        <thead>
                            <tr>
                            <th>Nom</th>
                            <th>Prenom</th>
                            <th>Téléphone</th>
                            <th>Agence</th>
                            <th>Action</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @foreach($chauffeurs as $chauffeur)
                            <tr>
                                <td>{{$chauffeur->nom}}</td>
                                <td>{{$chauffeur->prenom}}</td>
                                <td>{{$chauffeur->phone}}</td>
                                <td>{{$chauffeur->agence->nom}}</td>
                                <!-- ... Autre contenu de la vue ... -->
                                <td class="d-flex">
                                    <a href="{{ route('chauffeurs.show', $chauffeur->id) }}" class="btn btn-primary btn-circle ">
                                        <i class="mdi mdi-eye"></i>
                                    </a>
                                    <a href="{{ route('chauffeurs.edit', $chauffeur->id) }}" class="btn btn-success btn-circle btn-sm">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-circle btn-sm delete-chauffeur-btn" data-chauffeur-id="{{ $chauffeur->id }}" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                        <i class="mdi mdi-delete"></i>
                                    </button>
                                
                                    <!-- Modèle de confirmation de suppression -->
                                    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel">Confirmation de suppression</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Êtes-vous sûr de vouloir supprimer ce chauffeur? ?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                    <!-- Formulaire de suppression -->
                                                    <form id="deleteChauffeurForm" action="{{ route('chauffeurs.destroy', $chauffeur->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Supprimer</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach 
                        </tbody>
                    </table>
                    <div class="row justify-content-between " style="margin-top: 10px">
                        <div class="col-sm-12 col-md-5">
                            <div class="dataTables_info" id="dataTableExample_info" role="status" aria-live="polite">
                                {{ $chauffeurs->firstItem() }} to {{ $chauffeurs->lastItem() }} of {{ $chauffeurs->total() }} entries
                                {{ $chauffeurs->render() }}
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <div class="dataTables_paginate paging_simple_numbers" id="dataTableExample_paginate">
                                <ul class="pagination">
                                    @if ($chauffeurs->onFirstPage())
                                        <li class="paginate_button page-item previous disabled" id="dataTableExample_previous">
                                            <span class="page-link">Previous</span>
                                        </li>
                                    @else
                                        <li class="paginate_button page-item previous" id="dataTableExample_previous">
                                            <a href="{{ $chauffeurs->previousPageUrl() }}" aria-controls="dataTableExample" tabindex="0" class="page-link">Previous</a>
                                        </li>
                                    @endif

                                    @foreach ($chauffeurs->getUrlRange(1, $chauffeurs->lastPage()) as $page => $url)
                                        <li class="paginate_button page-item {{ $page == $chauffeurs->currentPage() ? 'active' : '' }}">
                                            <a href="{{ $url }}" aria-controls="dataTableExample" tabindex="0" class="page-link">{{ $page }}</a>
                                        </li>
                                    @endforeach

                                    @if ($chauffeurs->hasMorePages())
                                        <li class="paginate_button page-item next" id="dataTableExample_next">
                                            <a href="{{ $chauffeurs->nextPageUrl() }}" aria-controls="dataTableExample" tabindex="0" class="page-link">Next</a>
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Gérer la soumission du formulaire de suppression lorsque le modèle est confirmé
        $('.delete-chauffeur-btn').on('click', function () {
            var chauffeurId = $(this).data('chauffeur-id');
            // Mettre à jour l'action du formulaire avec l'ID de la facture à supprimer
            $('#deleteChauffeurForm').attr('action', '{{ route('chauffeurs.destroy', '') }}/' + chauffeurId);
        });
    });
</script>
@endsection
