<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\DisponibiliteVehicule; // Assurez-vous d'importer le modèle approprié
use App\Models\Voiture;
use App\Models\StatutVoiture;



class DisponibiliteVoitureController extends Controller
{
    // Afficher la liste des disponibilités de voitures
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10); // Nombre d'éléments par page, 10 par défaut

        // Récupérez les données paginées à partir du modèle Agence
        $disponibilites = DisponibiliteVehicule::paginate($perPage);

        return view('admin.disponibilites.index', ['disponibilites' => $disponibilites]);
    }

    // Afficher le formulaire de création de disponibilité de voiture
    public function create()
    {
        $voitures=Voiture::all();
        return view('admin.disponibilites.create', compact('voitures'));
    }

    // Enregistrer une nouvelle disponibilité de voiture
    public function store(Request $request)
{
    $validator = $request->validate([
        'voiture_id' => 'required|integer',
        'date_disponibilite' => 'required|date',
        'statut' => 'required|string',
    ]);

   
    $disponibilite = new DisponibiliteVehicule();
    $disponibilite->voiture_id = $request->input('voiture_id');
    $disponibilite->statut = $request->input('statut');
    $disponibilite->date_disponibilite = $request->input('date_disponibilite');

    $disponibilite->save();
    return redirect()->route('disponibilites.index')->with('success', 'Disponibilité de voiture créée avec succès.');
}


    // Afficher le formulaire de modification de disponibilité de voiture
    public function edit($id)
    {
        $voitures=Voiture::all();
        $disponibilite = DisponibiliteVehicule::find($id);
        return view('admin.disponibilites.edit', compact('disponibilite','voitures'));
    }

    // Mettre à jour la disponibilité de voiture existante
    public function update(Request $request, $id)
    {
        $request->validate([
            'voiture_id' => 'required|integer',
            'date_disponibilite' => 'required|date',
            'statut' => 'required|string',
            
        ]);

        $disponibilite = DisponibiliteVehicule::find($id);
        $disponibilite->voiture_id = $request->input('voiture_id');
        $disponibilite->statut = $request->input('statut');
        $disponibilite->date_disponibilite = $request->input('date_disponibilite');

        $disponibilite->save();
        return redirect()->route('disponibilites.index')->with('success', 'Disponibilité de voiture mise à jour avec succès.');
    }

    
    public function destroy($id)
    {
        $disponibites = DisponibiliteVehicule::findOrFail($id);
        $disponibites->delete();
        $notification=array(
            'message'=>'Opération éffectué avec succès',
            'alert-type'=>'success'
        );
    
        return redirect()->route('disponibites.index')->with('success', $notification );
    }
}

