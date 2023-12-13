<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    

     // ...
     
     public function store(Request $request): RedirectResponse
     {
         $request->validate([
             'name' => ['required', 'string', 'max:255'],
             'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
             'password' => ['required', 'confirmed', Rules\Password::defaults()],
             'phone' => ['required'],
             'photo' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
         ]);
     
         $user = new User();
         $user->name = $request->name;
         $user->email = $request->email;
         $user->password = Hash::make($request->password);
         $user->phone = $request->phone;
     
         $photo = $request->file('photo');
     
         // Vérifier s'il y a une image valide
         if ($photo && $photo->isValid()) {
             // Supprimer l'ancienne image si elle existe
             if ($user->photo) {
                 Storage::disk('public')->delete($user->photo);
             }
     
             // Stocker la nouvelle image
             $imagePath = $photo->store('pieces', 'public');
             $user->photo = $imagePath;
         }
     
         $user->save();
     
         event(new Registered($user));
     
         Auth::login($user);
     
         return redirect(RouteServiceProvider::HOME)->with('success', 'Inscription réussie !');
     }
}     
