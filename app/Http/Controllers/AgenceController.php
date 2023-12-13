<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\Agence;

class AgenceController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10); // Nombre d'éléments par page, 10 par défaut

        // Récupérez les données paginées à partir du modèle Agence
        $agences = Agence::paginate($perPage);

        return view('admin.agences.index', ['agences' => $agences]);
    }

    public function create()
    {
        return view('admin.agences.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nom' => 'required|string|max:255',
            'adresse' => 'required|string',
            'phone' => 'required|string|max:20',
            'email' => 'required|email',
        ]);

        // Créer une nouvelle instance d'Agence avec les données du formulaire
        $agence = new Agence();
        $agence->nom = $request->input('nom');
        $agence->adresse = $request->input('adresse');
        $agence->phone = $request->input('phone');
        $agence->email = $request->input('email');
        $notification=array(
            'message'=>'Agence ajouté avec succès',
            'alert-type'=>'success'
        );
        // Enregistrer l'agence dans la base de données
        $agence->save();

        // Rediriger vers une page de confirmation ou de liste des agences
        return redirect()->route('agences.index')->with($notification);
    }

    public function show(Agence $agence)
    {
        return view('admin.agences.show', compact('agence'));
    }

    public function edit(Agence $agence)
    {
        return view('admin.agences.edit', compact('agence'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'adresse' => 'required|string',
            'phone' => 'required|string|max:20',
            'email' => 'required|email',
        ]);

        $agence=Agence::find($id);

        $agence->nom = $request->input('nom');
        $agence->adresse = $request->input('adresse');
        $agence->phone = $request->input('phone');
        $agence->email = $request->input('email');
        $notification=array(
            'message'=>'Agence mis à jour avec succès',
            'alert-type'=>'success'
        );
        $agence->save();
        return redirect()->route('agences.index')->with($notification);
    }

    public function destroy($id)
    {
        $agence = Agence::findOrFail($id);
        $agence->delete();
        $notification=array(
            'message'=>'Agence mis à jour avec succès',
            'alert-type'=>'success'
        );
    
        return redirect()->route('agences.index')->with('success', $notification );
    }
}
