<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\Agence;
use App\Models\Message;

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
            'message'=>'Agence supprimé avec succès',
            'alert-type'=>'success'
        );
    
        return redirect()->route('agences.index')->with('success', $notification );
    }

    public function messageList(){
        $messages = Message::latest()->paginate(10);
        return view('admin.agences.messagesList', compact('messages'));
    }
    
    public function messageShow($id){
        $message = Message::find($id);
        return view('admin.agences.messageShow', compact('message'));
    }

    // AgenceController.php

    public function destroyMessage($id)
    {
        // Logique pour supprimer le message avec l'ID donné
        $message = Message::find($id);

        if (!$message) {
            // Gérer le cas où le message n'est pas trouvé
            return redirect()->route('messages.index')->with('error', 'Message not found');
        }

        $message->delete();

        $notification=array(
            'message'=>'Message supprimé avec succès',
            'alert-type'=>'success'
        );
        // Rediriger avec un message de succès
        return redirect()->route('messages.index')->with($notification);
    }

}
