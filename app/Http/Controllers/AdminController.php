<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Voiture;
use App\Models\Chauffeur;
use App\Models\Reservation;
use Carbon\Carbon; 

use Illuminate\Http\RedirectResponse;

class AdminController extends Controller
{
    public function adminDashboard(Request $request){
        
        $perPage = $request->input('perPage', 10);

        $query = $request->input('query');

        if ($query) {
            // If there's a search query, perform the search
            $users = User::where('name', 'like', '%' . $query . '%')
                ->orWhere('username', 'like', '%' . $query . '%')
                ->orWhere('email', 'like', '%' . $query . '%')
                ->orWhere('phone', 'like', '%' . $query . '%')
                ->paginate($perPage);
        } else {
            
            $users = User::paginate($perPage);
        }

        return view('admin.index', compact('users'));
    }

    private function calculateDaylyClients($startDate)
    {
        // Votre logique pour obtenir le nombre de clients par jour pour les 30 derniers jours
        $data = [];
        for ($i = 0; $i < 30; $i++) {
            $date = $startDate->copy()->addDays($i);
            $clients = User::count();

            // Exemple: remplacer cette partie par votre propre logique
            $data[] = [
                'date' => $date->toDateString(),
                'clients' => $clients,
            ];
        }

        return collect($data);
    }


    public function AdminLogout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    } //endMethod

    public function AdminLogin(Request $request){
        return view('admin.admin_login');
    }//endMethod

    public function adminProfile(){
        $id=Auth::user()->id;
        $profileData=User::find($id);
        return view('admin.admin_profile_view', compact('profileData'));
    }//endMethod

    public function adminProfileStore(Request $request){


        $request->validate([
            'username' => 'required|string',
            'name' => 'required|string',
            'email' => 'required|email',
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $id = Auth::user()->id;
        $data = User::find($id);
    
        $data->username = $request->username;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->adress = $request->address;
        //$uploadPath = base_path('public/upload/admin_images');

        if ($request->file('photo')) {
            $file = $request->file('photo');
            @unlink(public_path('upload/admin_images/' . $data->photo));
            $filename = date('YmHi') . $file->getClientOriginalName();
            if ($file->move(public_path('upload/admin_images'), $filename)) {
                $data['photo'] = $filename;
            } else {
                // Gérer l'erreur de téléchargement
                dd('Erreur lors du téléchargement du fichier.');
            }
            //$data->photo = $filename;
        }
    
        $data->save();
    
        $notification = array(
            'message' => 'Profile modifié avec succès',
            'alert-type' => 'success'
        );
    
        return redirect()->back()->with($notification);
    }
    

    
    public function adminChangePassword(){
        $id=Auth::user()->id;
        $profileData=User::find($id);
        return view('admin.admin_change_password', compact('profileData'));
    }//endMethod


    public function adminUpdatePassword(Request $request){

        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        if(!Hash::check($request->old_password, auth::user()->password)){
            $notification=array(
                'message'=>'Mot de pass incorrect',
                'alert-type'=>'error'
            );
            return back()->with($notification);
        }

        User::whereId(auth()->user()->id)->update([
            'password'=> Hash::make($request->new_password)
        ]);

        $notification=array(
            'message'=>'Mot de pass modifié avec succès',
            'alert-type'=>'success'
        );
        return redirect()->back()->with($notification);
    }//endMethod


    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);

        $query = $request->input('query');

        if ($query) {
            // If there's a search query, perform the search
            $users = User::where('name', 'like', '%' . $query . '%')
                ->orWhere('username', 'like', '%' . $query . '%')
                ->orWhere('email', 'like', '%' . $query . '%')
                ->orWhere('phone', 'like', '%' . $query . '%')
                ->paginate($perPage);
        } else {
            
            $users = User::paginate($perPage);
        }

        return view('admin.users.index', compact('users'));
    }


    public function show(User $user){
        
        $user->reservation_count = $user->count_user_reservation();
        return view('admin.users.show', compact('user'));
    }

    public function create_user()
    {
        // Afficher le formulaire de création
        return view('admin.users.create');
    }



    public function edit($id)
    {
        $user=User::find($id);
        return view('admin.users.edit', compact('user'));
    }


    public function update(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['required'],
            'role' => ['required', 'string', 'max:25'],
            'adress' => ['required', 'string', 'max:255'],
            'photo' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $user->name = $request->name;
        $user->username = $request->username;
        $user->role=$request->role;
        $user->email = $request->email;
        $user->adress=$request->adress;
        $user->phone = $request->phone;

        $photo = $request->file('photo');

        // Vérifier s'il y a une nouvelle image
        if ($photo && !$photo->hasError()) {
            // Valider et stocker la nouvelle image
            $request->validate([
                'photo' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            ]);

            // Supprimer l'ancienne image si elle existe
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }

            // Stocker la nouvelle image
            $imagePath = $photo->store('pieces', 'public');
            $user->photo = $imagePath;
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'Profil mis à jour avec succès');
    }



    public function count_user_reservation(User $user){
        $user_reservation=Reservation::where('user_id',$user->id)->count();
        return $user_reservation;
    }


    // Dans le contrôleur
    public function search(Request $request)
    {
        $query = $request->input('query');

        // Recherchez dans les utilisateurs, les voitures, les factures, etc.
        $users = User::where('name', 'like', '%' . $query . '%')->get();
        $voitures = Car::where('immatriculation', 'like', '%' . $query . '%')->get();
        $chauffeurs = Chauffeur::where('nom', 'like', '%' . $query . '%')
                            ->orWhere('prenom', 'like', '%' . $query . '%')
                            ->get();

        // Vous pouvez ajouter d'autres modèles ici en fonction de vos besoins

        return view('dashboard', compact('users', 'voitures', 'chauffeurs'));
    }

    public function destroy($id)
    {
        $agence = User::findOrFail($id);
        $agence->delete();
        $notification=array(
            'message'=>"L'utilsateur a été supprimé avec succès",
            'alert-type'=>'success'
        );
    
        return redirect()->route('users.index')->with('success', $notification );
    }
    
}
