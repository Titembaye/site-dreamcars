<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Mission;
use App\Models\Voiture;
use App\Models\Chauffeur;

class MissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $missions=Mission::paginate(10);
        return view('admin.missions.index', compact('missions'));
    }

    /**
     * Show the form for creating a new resource.
     */

     public function create()
     {
         $voitures = Voiture::all();
         $chauffeurs = Chauffeur::all();
     
         return view('admin.missions.create', compact('voitures', 'chauffeurs'));
     }
     

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required',
            'description' => 'required',
            'date_debut' => 'required',
            'date_fin' => 'required',
            'voitures' => 'required|array',
            'chauffeurs' => 'required|array',
        ]);
        $notification=array(
            'message'=>'La mission ajouté avec succès',
            'alert-type'=>'success'
        );
        $mission = Mission::create($request->except('voitures', 'chauffeurs'));

        $voitures = Voiture::find($request->input('voitures'));
        $chauffeurs = Chauffeur::find($request->input('chauffeurs'));

        $mission->voitures()->attach($voitures);
        $mission->chauffeurs()->attach($chauffeurs);

        return redirect()->route('missions.index')->with($notification);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $mission = Mission::with('chauffeurs', 'voitures')->findOrFail($id);
        return view('admin.missions.show', compact('mission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
