<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


use App\Models\Voiture;
use App\Models\DisponibiliteVehicule;
use App\Models\Reservation;
use App\Models\Message;
use App\Models\Mission;

class FrontendController extends Controller
{
    public function accueil()
    {
        // Mettre à jour le statut des voitures réservées dont la date de fin est dépassée
        $this->updateVoituresStatut();

        // Récupérer les voitures disponibles
        $voitures_dispo = Voiture::join('disponibilite_vehicules', 'voitures.id', '=', 'disponibilite_vehicules.voiture_id')
            ->where('disponibilite_vehicules.statut', 'Disponible')
            ->take(4)
            ->get();

        $voitures_reserves = Voiture::join('disponibilite_vehicules', 'voitures.id', '=', 'disponibilite_vehicules.voiture_id')
            ->where('disponibilite_vehicules.statut', 'Réservé')
            ->take(2)
            ->get();

        // Récupérer les voitures disponibles de manière aléatoire
        $voitures_disponibles = Voiture::with('disponibilite')->inRandomOrder()->limit(6)->get();

        $missions = Mission::latest()->take(3)->get();
        $featured_voitures = Voiture::inRandomOrder()->limit(5)->get();
        $data_lux = Voiture::inRandomOrder()->take(6)->get();
        $vehicules_suggeres = Voiture::all();

        return view('frontend.accueil', compact('voitures_disponibles', 'voitures_reserves', 'vehicules_suggeres', 'data_lux', 'featured_voitures', 'missions'));
    }

    protected function updateVoituresStatut()
    {
        // Récupérer les réservations expirées avec un statut particulier (par exemple, 'En cours')
        $reservations_expirees = Reservation::where(function ($query) {
            $query->whereRaw("CONCAT(date_fin, ' ', heure_fin) < NOW()")
                ->where('statut', 'En cours');
        })->get();

        // Mettre à jour le statut des voitures associées à ces réservations
        foreach ($reservations_expirees as $reservation) {
            $voiture_id = $reservation->voiture_id;
            // Mettre à jour le statut de la disponibilité de la voiture à "Disponible"
            $this->updateVoitureAvailability($voiture_id, 'Disponible', $reservation);
        }
    }


    protected function updateVoitureAvailability($voiture_id, $statut, Reservation $reservation)
    {
        DisponibiliteVehicule::updateOrCreate(
            ['voiture_id' => $voiture_id],
            ['statut' => $statut, 'date_disponibilite' => now()]
        );

        // Mettre à jour le statut de la réservation à "Expiré"
        $this->updateReservationStatus($reservation, 'Expiré');
    }

    protected function updateReservationStatus(Reservation $reservation, $statut)
    {
        $reservation->statut = $statut;
        $reservation->save();
    }

    public function all_properties()
    {
        $this->updateVoituresStatut();
        $voitures = Voiture::with('disponibilite')->get();
        $vehicules_suggeres = Voiture::all();
        return view('frontend.all_properties', compact('voitures','vehicules_suggeres'));
    }

    public function dispo_properties()
    {
        $this->updateVoituresStatut();
        $voitures_disponibles = Voiture::with('disponibilite')
        ->whereHas('disponibilite', function ($query) {
            $query->where('statut', 'Disponible');
        })
        ->get();

        $vehicules_suggeres = Voiture::all();
        
        return view('frontend.dispo_properties', compact('vehicules_suggeres', 'voitures_disponibles'));
    }
   




    public function reservation()
    {
        return view('frontend.reservation');
    }

    public function store_reservation()
    {

    }

    public function message_store(Request $request){
        $this->validate($request, [
            'noms'=>'required|string|max:100',
            'email'=>'required|email',
            'sujet'=>'required|string|max:100',
            'contenu'=>'required|string|max:1000',
        ]);
        $message=new Message();
        $message->noms=$request->input('noms');
        $message->email=$request->input('email');
        $message->sujet=$request->input('sujet');
        $message->contenu=$request->input('contenu');

        $message->save();
        return redirect()->back()->with('Succès', "Merci d'avoir contacté DreamCars!");
    }

    public function services(){
        $missions = Mission::latest()->take(3)->get();
        return view('frontend.services', compact('missions'));
    }


    // FrontendController.php

    public function showReservationSuccess()
    {
        // Vous pouvez obtenir la variable $reservation à partir de la session
        $reservation = session('reservation');

        return view('frontend.reservation_success', compact('reservation'));
    }

    public function showReservationAbort()
    {
        // Vous pouvez obtenir la variable $reservation à partir de la session
        $reservation = session('reservation');

        return view('frontend.reservation_abort', compact('reservation'));
    }
    public function details_voiture($voitureId){
        
        $voiture=Voiture::with('images')->find($voitureId);
        return view('frontend.detail-voiture', compact('voiture'));
    }


    // SearchController.php
    public function search(Request $request)
    {
        $results = $this->performSearch($request);

        return redirect()->back()->with('results', $results);
    }


}
