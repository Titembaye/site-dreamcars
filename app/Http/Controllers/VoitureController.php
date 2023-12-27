<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; 

use App\Models\Voiture;
use App\Models\Image;

class VoitureController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10); // Nombre d'éléments par page, 10 par défaut

        // Check if a search query is present in the request
        $query = $request->input('query');

        if ($query) {
            // If there's a search query, perform the search
            $voitures = Voiture::where('immatriculation', 'like', '%' . $query . '%')
                ->orWhere('marque', 'like', '%' . $query . '%')
                ->orWhere('modele', 'like', '%' . $query . '%')
                ->paginate($perPage);
        } else {
            // If no search query, retrieve all voitures paginated
            $voitures = Voiture::paginate($perPage);
        }

        return view('admin.voitures.index', compact('voitures'));
    }


    public function create()
    {
        return view('admin.voitures.create');
    }

    public function store(Request $request)
    {
       $this->validate($request, [
            'immatriculation' => 'required|string',
            'marque' => 'required|string|max:255',
            'modele' => 'required|string',
            'puissance' => 'required|integer',
            'capacite' => 'required|integer',
            'annee' => 'required|string|max:20',
            'montant_journalier' => 'required|numeric:2',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $voiture = new Voiture();
        
        /** @var UploadFile|null $image*/
        $image = $request->file('image');
        if($image != null && !$image->getError()){
            $imagePath = $image->store('voitures', 'public');
            $voiture->image = $imagePath;
        }
        
        $voiture->immatriculation = $request->input('immatriculation');
        $voiture->marque = $request->input('marque');
        $voiture->modele = $request->input('modele');
        $voiture->puissance = $request->input('puissance');
        $voiture->capacite = $request->input('capacite');
        $voiture->annee = $request->input('annee');
        $voiture->montant_journalier = $request->input('montant_journalier');

        $notification=array(
            'message'=>'Voiture ajouté avec succès, complétez ses images',
            'alert-type'=>'success'
        );
        // Enregistrer l'agence dans la base de données 
        $voiture->save();

        // Rediriger vers une page de confirmation ou de liste des agences
        return redirect()->route('voitures.createimage')->with($notification);
    }

    public function show(Voiture $voiture)
    {
        $voiture->count_reservation=$voiture->count_voiture_reservation();
        return view('admin.voitures.show', compact('voiture'));
    }

    public function edit($id)
    {
        $voiture = Voiture::find($id);
        $ancienneImageURL = asset('storage/'.$voiture->image);
        return view('admin.voitures.edit', compact('voiture','ancienneImageURL'));
    }

    

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'immatriculation' => 'required|string',
            'marque' => 'required|string|max:255',
            'modele' => 'required|string',
            'puissance' => 'required|integer',
            'capacite' => 'required|integer',
            'annee' => 'required|string|max:20',
            'montant_journalier' => 'required|numeric:2',
        ]);

        $voiture = Voiture::find($id);


        if (!$voiture) {
            // Gérer le cas où la voiture n'est pas trouvée
            return redirect()->back()->with('error', 'Voiture non trouvée.');
        }


        if ($request->hasFile('image')) {
            // Un nouveau fichier image a été téléchargé
            $this->validate($request, [
                'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
    
            // Supprimer l'ancienne image s'il en existe une
            if ($voiture->image) {
                Storage::disk('public')->delete($voiture->image);
            }
    
            // Stocker le nouveau fichier image
            $newImage = $request->file('image');
            $newImagePath = $newImage->store('voitures', 'public');
            $voiture->image = $newImagePath;
        }

        // Mis à jour des autres propriétés de la voiture
        $voiture->immatriculation = $request->input('immatriculation');
        $voiture->marque = $request->input('marque');
        $voiture->modele = $request->input('modele');
        $voiture->puissance = $request->input('puissance');
        $voiture->capacite = $request->input('capacite');
        $voiture->annee = $request->input('annee');
        $voiture->montant_journalier = $request->input('montant_journalier');

        // Enregistrez la mise à jour de la voiture dans la base de données
        $voiture->save();
        $notification=array(
            'message'=>'Voiture ajouté avec succès',
            'alert-type'=>'success'
        );
        // Rediriger vers une page de confirmation ou de liste des voitures
        return redirect()->route('voitures.index')->with($notification);
    }



    public function createimage(){
        $voitures=Voiture::all();
        return view('admin.voitures.image_create', compact('voitures'));
    }


    public function imagestore(Request $request)
    {
    $this->validate($request, [
        'voiture_id' => 'required|integer',
        'images.*'   => 'image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    $voiture_id = $request->input('voiture_id');

    foreach ($request->file('images') as $image) {
        $voiture_image = new Image();

        // Enregistrez l'image
        $imagePath = $image->store('voitures', 'public');
        $voiture_image->image_path = $imagePath;

        // Associez l'image à la voiture
        $voiture_image->voiture_id = $voiture_id;

        // Enregistrez l'image dans la base de données
        $voiture_image->save();
    }

    // Rediriger vers une page de confirmation ou de liste des voitures
    return redirect()->route('voitures.index')->with('success', 'Les images ont été téléchargées avec succès.');
    }

    public function editimage($id)
{
    $image = Image::findOrFail($id);
    $voitures = Voiture::all();

    return view('admin.voitures.image_edit', compact('image', 'voitures'));
}

public function imageupdate(Request $request, $id)
{
    $this->validate($request, [
        'voiture_id' => 'required|integer',
        'images.*'   => 'image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    $voiture_id = $request->input('voiture_id');
    $image = Image::findOrFail($id);

    // Supprimer l'ancienne image du stockage
    Storage::disk('public')->delete($image->image_path);

    foreach ($request->file('images') as $newImage) {
        // Enregistrez la nouvelle image
        $newImagePath = $newImage->store('voitures', 'public');

        // Mettez à jour le chemin de l'image dans la base de données
        $image->image_path = $newImagePath;
    }

    // Mettez à jour l'association avec la voiture
    $image->voiture_id = $voiture_id;

    // Enregistrez les modifications dans la base de données
    $image->save();

    // Rediriger vers une page de confirmation ou de liste des voitures
    return redirect()->route('voitures.index')->with('success', 'L\'image a été mise à jour avec succès.');
}



    public function destroy($id)
    {
        $voiture = Voiture::findOrFail($id);
        $voiture->delete();
    
        return redirect()->route('voitures.index')->with('success', 'Le chauffeur a été supprimé avec succès.');
    }

    public function count_voiture_reservation(User $voiture){
        $user_reservation=Reservation::where('voiture_id',$user->id)->count();
        return $voiture_reservation;
    }

    // Dans le contrôleur
    public function searche(Request $request)
    {
        $query = $request->input('query');

        // Recherchez uniquement dans les voitures
        $voitures_search = Voiture::where('immatriculation', 'like', '%' . $query . '%')
            ->orWhere('marque', 'like', '%' . $query . '%')
            ->orWhere('modele', 'like', '%' . $query . '%')
            ->get();

        return view('admin.users.index', compact('voitures'));
    }

    public function search(Request $request): JsonResponse
    {
        $query = $request->input('query');

        // Perform your search here
        $voitures = Voiture::where('immatriculation', 'like', '%' . $query . '%')
            ->orWhere('marque', 'like', '%' . $query . '%')
            ->orWhere('modele', 'like', '%' . $query . '%')
            ->get();

        return response()->json(['voitures' => $voitures]);
    }


}