@extends('admin.admin_dashboard')
@section('admin')

<div class="row m-5">
    <div class="col-md-12 grid-margin stretch-card mt-5">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Liste des agences</h6>
                <div class="row justify-content between">
                    <div class="col-sm-12 col-md-6 justify-content-end" >
                        <div class="dataTables_length" id="dataTableExample_length">
                            <label style="display:flex">Affiché 
                                <select name="dataTableExample_length" aria-controls="dataTableExample" class="form-select form-select-sm">
                                    <option value="10">10</option>
                                    <option value="30">30</option>
                                    <option value="50">50</option>
                                    <option value="-1">All</option>
                                </select> 
                                entrées
                            </label>
                        </div>
                    </div>
                
                    <div class="col-sm-12 col-md-6 text-right">
                        <div id="dataTableExample_filter" class="dataTables_filter">
                            <label>
                                <input type="search" class="form-control" placeholder="Search" aria-controls="dataTableExample">
                            </label>
                        </div>
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
                                    <form action="{{ route('agences.destroy', $agence->id) }} " method="POST">
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
                    <div class="row">
                        <div class="col-sm-12 col-md-5">
                            <div class="dataTables_info" id="dataTableExample_info" role="status" aria-live="polite">
                            <div class="dataTables_info" id="dataTableExample_info" role="status" aria-live="polite">
                                Affichage de {{ $agences->firstItem() }} à {{ $agences->lastItem() }} des {{ $agences->total() }} entrées
                            </div>

                            </div>
                        </div>
                        <div class="col-sm-12 col-md-7">
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
    
@endsection