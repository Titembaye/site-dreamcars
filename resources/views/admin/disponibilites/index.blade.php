@extends('admin.admin_dashboard')
@section('title')
    DreamCars - Locations
@endsection('title')
@section('admin')
<div class="row m-5">
    <div class="col-md-12 grid-margin stretch-card mt-5">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Disponibilités des voitures</h6>
                <div class="row justify-content between">
                    <div class="col-md-8">
                        <a class="btn btn-primary btn-sm" href="{{route('disponibilites.create')}}">Ajouter</a>
                    </div>
                    
                    <div class="col-md-4 text-right" style="text-align: right;">
                        <form action="{{ route('disponibilites.index') }}" method="GET" class="search-form">
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
                            <th>Voiture</th>
                            <th class="text-center">Statut</th>
                            <th class="text-center">Date de disponibilité</th>
                            <th >Action</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @foreach($disponibilites as $disponibilite)
                            <tr>
                                <td>{{$disponibilite->voiture->immatriculation}}</td>
                                <td class="text-center">{{$disponibilite->statut}}</td>
                                <td class="text-center">{{$disponibilite->date_disponibilite}}</td>
                                
                                <td class="d-flex">
                                    <a href="{{ route('disponibilites.show', $disponibilite->id) }}" class="btn btn-primary btn-circle ">
                                        <i class="mdi mdi-eye"></i>
                                    </a>
                                    <a href="{{ route('disponibilites.edit', $disponibilite->id) }}" class="btn btn-success btn-circle btn-sm">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>
                                    <!-- Bouton de suppression avec modèle de confirmation -->
                                    <button type="button" class="btn btn-danger btn-circle btn-sm delete-facture-btn" data-disponibilite-id="{{ $disponibilite->id }}" data-bs-toggle="modal" data-bs-target="#deleteModal">
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
                                                    Êtes-vous sûr de vouloir supprimer cette cette disponibilité ?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                    <!-- Formulaire de suppression -->
                                                    <form id="deleteDisponibiliteForm" action="{{ route('disponibilites.destroy', $disponibilite->id) }}" method="POST">
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
                    <div class="row justify-content-between mt-3">
                        <div class="col-sm-12 col-md-5">
                            <div class="dataTables_info" id="dataTableExample_info" role="status" aria-live="polite">
                                <div class="dataTables_info" id="dataTableExample_info" role="status" aria-live="polite">
                                    Affichage de {{ $disponibilites->firstItem() }} à {{ $disponibilites->lastItem() }} des {{ $disponibilites->total() }} entrées
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <div class="dataTables_paginate paging_simple_numbers" id="dataTableExample_paginate">
                                <ul class="pagination">
                                    @if ($disponibilites->onFirstPage())
                                        <li class="paginate_button page-item previous disabled" id="dataTableExample_previous">
                                            <span class="page-link">Previous</span>
                                        </li>
                                    @else
                                        <li class="paginate_button page-item previous" id="dataTableExample_previous">
                                            <a href="{{ $disponibilites->previousPageUrl() }}" aria-controls="dataTableExample" tabindex="0" class="page-link">Previous</a>
                                        </li>
                                    @endif

                                    @foreach ($disponibilites->getUrlRange(1, $disponibilites->lastPage()) as $page => $url)
                                        <li class="paginate_button page-item {{ $page == $disponibilites->currentPage() ? 'active' : '' }}">
                                            <a href="{{ $url }}" aria-controls="dataTableExample" tabindex="0" class="page-link">{{ $page }}</a>
                                        </li>
                                    @endforeach

                                    @if ($disponibilites->hasMorePages())
                                        <li class="paginate_button page-item next" id="dataTableExample_next">
                                            <a href="{{ $disponibilites->nextPageUrl() }}" aria-controls="dataTableExample" tabindex="0" class="page-link">Next</a>
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
    document.addEventListener('DOMContentLoaded', function () {
        // Gérer la soumission du formulaire de suppression lorsque le modèle est confirmé
        $('.delete-disponibilite-btn').on('click', function () {
            var disponibiliteId = $(this).data('disponibilite-id');
            // Mettre à jour l'action du formulaire avec l'ID de la facture à supprimer
            $('#deleteDisponibiliteForm').attr('action', '{{ route('disponibilites.destroy', '') }}/' + disponibiliteId);
        });
    });
</script>
@endsection