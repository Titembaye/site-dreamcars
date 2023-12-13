@extends('admin.admin_dashboard')
@section('title')
    DreamCars - Missions
@endsection('title')
@section('admin')

<div class="row m-5">
    <div class="col-md-12 grid-margin stretch-card mt-5">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Liste des Missions</h6>
                <div class="row justify-content between">
                    <div class="col-md-6">
                        <a class="btn btn-primary btn-sm" href="{{route('missions.create')}}">Ajouter</a>
                    </div>
                    
                    <div class="col-md-6 text-right" style="text-align: right;">
                        <div id="dataTableExample_filter" class="dataTables_filter">
                            <label>
                                <input type="search" class="form-control" placeholder="Search" aria-controls="dataTableExample">
                            </label>
                        </div>
                    </div>
                </div>
                <div class="table-responsive" style="margin-top: 20px">
                    <table id="dataTableExample" class="table">
                        <thead>
                            <tr>
                            <th>Mission</th>
                            <th>Date de debut</th>
                            <th>Date de fin</th>
                            <th>Action</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @foreach($missions as $mission)
                            <tr>
                                <td>{{$mission->titre}}</td>
                                <td>{{$mission->date_debut}}</td>
                                <td>{{$mission->date_fin}}</td>
                                <!-- ... Autre contenu de la vue ... -->
                                <td class="d-flex">
                                    <a href="{{ route('missions.show', $mission->id) }}" class="btn btn-primary btn-circle ">
                                        <i class="mdi mdi-eye"></i>
                                    </a>
                                    <a href="{{ route('missions.edit', $mission->id) }}" class="btn btn-success btn-circle btn-sm">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>
                                    <form action="{{ route('missions.destroy', $mission->id) }} " method="POST">
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
                                Affichage de {{ $missions->firstItem() }} à {{ $missions->lastItem() }} des {{ $missions->total() }} entrées
                            </div>

                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="dataTables_paginate paging_simple_numbers" id="dataTableExample_paginate">
                                <ul class="pagination">
                                    @if ($missions->onFirstPage())
                                        <li class="paginate_button page-item previous disabled" id="dataTableExample_previous">
                                            <span class="page-link">Previous</span>
                                        </li>
                                    @else
                                        <li class="paginate_button page-item previous" id="dataTableExample_previous">
                                            <a href="{{ $missions->previousPageUrl() }}" aria-controls="dataTableExample" tabindex="0" class="page-link">Previous</a>
                                        </li>
                                    @endif

                                    @foreach ($missions->getUrlRange(1, $missions->lastPage()) as $page => $url)
                                        <li class="paginate_button page-item {{ $page == $missions->currentPage() ? 'active' : '' }}">
                                            <a href="{{ $url }}" aria-controls="dataTableExample" tabindex="0" class="page-link">{{ $page }}</a>
                                        </li>
                                    @endforeach

                                    @if ($missions->hasMorePages())
                                        <li class="paginate_button page-item next" id="dataTableExample_next">
                                            <a href="{{ $missions->nextPageUrl() }}" aria-controls="dataTableExample" tabindex="0" class="page-link">Next</a>
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