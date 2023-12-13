<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;



use App\Models\Chauffeur;
use App\Models\Agence;

class ChauffeurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $chauffeurs = Chauffeur::paginate(10);
        return view('admin.chauffeurs.index', compact('chauffeurs'));
    }

    /**
     * Show the form for creating a new resource
     */
    public function create()
    {
        $agences=Agence::all();
        return view('admin.chauffeurs.create', compact('agences'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email',
            'agence_id' => 'required|integer',
            'permis_de_conduire' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        

        // Créer une nouvelle instance d'Agence avec les données du formulaire
        $chauffeur = new Chauffeur();

         /** @var UploadFile|null $image*/
         $permis = $request->file('permis_de_conduire');
         if($permis != null && !$permis->getError()){
             $imagePath = $permis->store('permis', 'public');
             $chauffeur->permis_de_conduire = $imagePath;
         } 

        $chauffeur->nom = $request->input('nom');
        $chauffeur->prenom = $request->input('prenom');
        $chauffeur->phone = $request->input('phone');
        $chauffeur->email = $request->input('email');
        $chauffeur->agence_id = $request->input('agence_id');

        // Enregistrer l'agence dans la base de données
        $chauffeur->save();

        // Rediriger vers une page de confirmation ou de liste des agences
        return redirect()->route('chauffeurs.index')->with('success', 'Le chauffeur a été créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $chauffeur=Chauffeur::find($id);
        $missions = $chauffeur->missions()->paginate(10);
        return view('admin.chauffeurs.show', compact('chauffeur','missions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $chauffeur=Chauffeur::find($id);
        $agences=Agence::all();
        return view('admin.chauffeurs.edit', compact('chauffeur','agences'));
    }
        

    public function update(Request $request, $id)
    {
        // Valider les données du formulaire
        $this->validate($request, [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email',
            'agence_id' => 'required|integer',
            'nouveau_permis_de_conduire' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Récupérer le chauffeur par son ID
        $chauffeur = Chauffeur::findOrFail($id);

        // Supprimer l'ancienne image du permis si une nouvelle image est fournie
        if ($request->hasFile('nouveau_permis_de_conduire')) {
            Storage::disk('public')->delete($chauffeur->permis_de_conduire);
        }

        // Mettre à jour les autres champs du chauffeur
        $chauffeur->nom = $request->input('nom');
        $chauffeur->prenom = $request->input('prenom');
        $chauffeur->phone = $request->input('phone');
        $chauffeur->email = $request->input('email');
        $chauffeur->agence_id = $request->input('agence_id');


        // Mettre à jour l'image du permis si une nouvelle image est fournie
        if ($request->hasFile('nouveau_permis_de_conduire')) {
            $nouveauPermis = $request->file('nouveau_permis_de_conduire');
            $nouveauPermisPath = $nouveauPermis->store('permis', 'public');
            $chauffeur->permis_de_conduire = $nouveauPermisPath;
        }

        // Sauvegarder les modifications dans la base de données
        $chauffeur->save();

        // Rediriger avec un message de succès
        return redirect()->route('chauffeurs.index')->with('success', 'Le chauffeur a été mis à jour avec succès.');
    }



    public function destroy($id)
    {
        $chauffeur = Chauffeur::findOrFail($id);
        $chauffeur->delete();
    
        return redirect()->route('chauffeurs.index')->with('success', 'Le chauffeur a été supprimé avec succès.');
    }

}
