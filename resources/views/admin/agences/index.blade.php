@extends('admin.admin_dashboard')
@section('admin')

<div class="row m-5">
    <div class="col-md-12 grid-margin stretch-card mt-5">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Liste des agences</h6>
                <div class="row justify-content between">
                    <div class="col-md-8">
                        <a class="btn btn-primary btn-sm" href="{{route('agences.create')}}">Ajouter</a>
                    </div>
                    
                    <div class="col-md-4 text-right" style="text-align: right;">
                        <form action="{{ route('agences.index') }}" method="GET" class="search-form">
                            <div class="input-group">
                                <input type="text" class="form-control" name="query" placeholder="Rechercher...">
                                <button type="submit" class="btn btn-primary btn-sm">Rechercher</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="dataTableExample" class="table">
                        <thead>
                            <tr>
                            <th>Nom</th>
                            <th>Adresse</th>
                            <th>Téléphone</th>
                            <th>Email</th>
                            <th>Action</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @foreach($agences as $agence)
                            <tr>
                                <td>{{$agence->nom}}</td>
                                <td>{{$agence->adresse}}</td>
                                <td>{{$agence->phone}}</td>
                                <td>{{$agence->email}}</td>
                                <!-- ... Autre contenu de la vue ... -->
                                <td class="d-flex">
                                    <a href="{{ route('agences.show', $agence->id) }}" class="btn btn-primary btn-circle ">
                                        <i class="mdi mdi-eye"></i>
                                    </a>
                                    <a href="{{ route('agences.edit', $agence->id) }}" class="btn btn-success btn-circle btn-sm">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-circle btn-sm delete-agence-btn" data-agence-id="{{ $agence->id }}" data-bs-toggle="modal" data-bs-target="#deleteModal">
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
                                                    Êtes-vous sûr de vouloir supprimer cette Agence? ?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                    <!-- Formulaire de suppression -->
                                                    <form id="deleteAgenceForm" action="{{ route('agences.destroy', $agence->id) }}" method="POST">
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
                                Affichage de {{ $agences->firstItem() }} à {{ $agences->lastItem() }} des {{ $agences->total() }} entrées
                            </div>

                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <div class="dataTables_paginate paging_simple_numbers" id="dataTableExample_paginate">
                                <ul class="pagination">
                                    @if ($agences->onFirstPage())
                                        <li class="paginate_button page-item previous disabled" id="dataTableExample_previous">
                                            <span class="page-link">Previous</span>
                                        </li>
                                    @else
                                        <li class="paginate_button page-item previous" id="dataTableExample_previous">
                                            <a href="{{ $agences->previousPageUrl() }}" aria-controls="dataTableExample" tabindex="0" class="page-link">Previous</a>
                                        </li>
                                    @endif

                                    @foreach ($agences->getUrlRange(1, $agences->lastPage()) as $page => $url)
                                        <li class="paginate_button page-item {{ $page == $agences->currentPage() ? 'active' : '' }}">
                                            <a href="{{ $url }}" aria-controls="dataTableExample" tabindex="0" class="page-link">{{ $page }}</a>
                                        </li>
                                    @endforeach

                                    @if ($agences->hasMorePages())
                                        <li class="paginate_button page-item next" id="dataTableExample_next">
                                            <a href="{{ $agences->nextPageUrl() }}" aria-controls="dataTableExample" tabindex="0" class="page-link">Next</a>
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
        $('.delete-agence-btn').on('click', function () {
            var agenceId = $(this).data('agence-id');
            // Mettre à jour l'action du formulaire avec l'ID de la facture à supprimer
            $('#deleteAgenceForm').attr('action', '{{ route('agences.destroy', '') }}/' + agenceId);
        });
    });
</script>
@endsection