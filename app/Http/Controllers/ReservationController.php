<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Jobs\SimpleJob;
use App\Models\Reservation;
use App\Models\Voiture;
use App\Models\DisponibiliteVehicule;
use App\Models\User;
use App\Notifications\NewReservation;
use App\Notifications\ReservationDue;
use Illuminate\Support\Facades\Log;


class ReservationController extends Controller
{
    protected $table = 'reservations';
    
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10); 

        $query = $request->input('query');

        if ($query) {
            // If there's a search query, perform the search
            $reservations = Reservation::whereHas('voiture', function ($innerQuery) use ($query) {
                $innerQuery->where('marque', 'like', '%' . $query . '%')
                    ->orWhere('modele', 'like', '%' . $query . '%');
            })
            ->orWhere('date_debut', 'like', '%' . $query . '%')
            ->orWhere('date_fin', 'like', '%' . $query . '%')
            ->paginate($perPage);
        } else {
            $reservations = Reservation::paginate($perPage);
        }

        return view('admin.reservations.index', ['reservations' => $reservations]);
    }


    public function create()
    {
        $voitures=Voiture::all();
        return view('admin.reservations.create', compact('voitures'));
    }

   

    public function store(Request $request)
    {
        $this->validate($request, [
            'voiture_id' => 'required|integer',
            'date_debut' => 'required|date|after_or_equal:today',
            'date_fin' => 'required|date|after:date_debut',
            'montant_reservation' => 'required|numeric',
        ]);
    
        $user_id=Auth::user()->id;
        // Créer une nouvelle instance d'Agence avec les données du formulaire

        $voiture_id=$request->input('voiture_id');
        $dateDebut = Carbon::parse($request->input('date_debut'));
        $dateFin = Carbon::parse($request->input('date_fin'));
    
        // Vérifier si la voiture est disponible pour la période demandée
        $voitureDisponible = $this->checkVoitureAvailability($request->input('voiture_id'), $dateDebut, $dateFin);
    
        if ($voitureDisponible) {
            // Créer et enregistrer la réservation
            $reservation = new Reservation();
            $reservation->user_id = $user_id;
            $reservation->voiture_id = $request->input('voiture_id');
            $reservation->date_debut = $request->input('date_debut');
            $reservation->date_fin = $request->input('date_fin');
            $reservation->montant_reservation = $request->input('montant_reservation');
            $reservation->save();
    
            $notification=array(
                'message'=>'Reservation faite avec succès',
                'alert-type'=>'success'
            );
            // Rediriger vers une page de confirmation ou de liste des agences
            return redirect()->route('reservations.index')->with($notification);
        } else {
            // La voiture n'est pas disponible pour la période demandée
            $prochaine_disponibilite = $this->getProchaineDisponibilite($request->input('voiture_id'));
            $notification=array(
                'message'=>'Reservation faite avec succès',
                'alert-type'=>'error'
            );
            // La voiture n'est pas disponible pour la période demandée, afficher un message d'erreur
            return redirect()->back()
            ->with($notification)
            ->with('prochaine_disponibilite', $prochaine_disponibilite);
        }
    }
    


public function edit($id){
    $voitures=Voiture::all();
    $reservation=Reservation::find($id);
    return view('admin.reservations.edit', compact('reservation','voitures'));
}

public function update(Request $request, $id){
    $this->validate($request, [
        'voiture_id' => 'required|integer',
        'date_debut' => 'required|date',
        'date_fin' => 'required|date',
        'montant_reservation' => 'required|numeric'
    ]);
    $user_id=Auth::user()->id;

    $voiture_id=$request->input('voiture_id');
        $dateDebut = Carbon::parse($request->input('date_debut'));
        $dateFin = Carbon::parse($request->input('date_fin'));


        $voitureDisponible = Voiture::where('id', $request->input('voiture_id'))
        ->whereHas('disponibilite', function ($query) use ($dateDebut, $dateFin) {
            $query->where(function ($subquery) use ($dateDebut, $dateFin) {
                $subquery->whereBetween('date_disponibilite', [$dateDebut, $dateFin]);
               
            })
            ->whereHas('statut', function ($query) {
                $query->where('libelle', 'Disponible');
            });
        })
        ->exists();
    
    if($voitureDisponible){
        $reservation=Reservation::find($id);
        $reservation->user_id = $user_id;
        $reservation->voiture_id = $request->input('voiture_id');
        $reservation->date_debut = $request->input('date_debut');
        $reservation->date_fin = $request->input('date_fin');
        $reservation->montant_reservation = $request->input('montant_reservation');

        // Enregistrer l'agence dans la base de données
        $reservation->save();
        $notification=array(
            'message'=>'Reservation faite avec succès',
            'alert-type'=>'success'
        );
        // Rediriger vers une page de confirmation ou de liste des agences
        return redirect()->route('reservations.index')->with($notification);
    }
    else {
        $prochaine_disponibilite=Voiture::find($request->input('voiture_id'))
        ->disponibilite()
        ->orderBy('date_disponibilite')
        ->first();
        $notification=array(
            'message'=>'Reservation faite avec succès',
            'alert-type'=>'error'
        );
        // La voiture n'est pas disponible pour la période demandée, afficher un message d'erreur
        return redirect()->back()
        ->with($notification)
        ->with('prochaine_disponibilite', $prochaine_disponibilite);
    }
}   

public function show($id){
 
    $reservation = Reservation::with('user','voiture')->findOrFail($id);

    return view('admin.reservations.show', compact('reservation'));
}

public function userReservations()
{
    // Récupérer l'utilisateur connecté
    $utilisateur = Auth::user();

    // Récupérer les réservations de cet utilisateur
    $reservations = Reservation::where('user_id', $utilisateur->id)->get();

    // Passer les réservations à la vue
    return view('admin.reservations.mes_reservations', compact('reservations'));
}


private function checkVoitureAvailability($voitureId)
    {
        return Voiture::where('id', $voitureId)
            ->whereHas('disponibilite', function ($query) {
                $query->where('statut', 'Disponible');
            })
            ->exists();
    }
    
    private function getProchaineDisponibilite($voitureId)
    {
        return Voiture::find($voitureId)
            ->disponibilite()
            ->orderBy('date_disponibilite')
            ->first();
    }


public function reservation_store(Request $request)
{
    $this->validate($request, [
        'voiture_id' => 'required|integer',
        'lieu_depart' => 'required|string|max:100',
        'heure_depart' => 'required|date_format:H:i',
        'date_debut' => 'required|date|after_or_equal:today',
        'date_fin' => 'required|date|after_or_equal:date_debut',
        'heure_fin' => 'required|date_format:H:i',
        'destination' => 'required|string|max:100', 
        'montant_reservation' => 'required|numeric',
        'statut' => 'En attente|string|max:20',
    ]);

    // Calcul de la durée de location en jours
    $dateDebut = Carbon::parse($request->input('date_debut'));
    $dateFin = Carbon::parse($request->input('date_fin'));
    $duree_location = $dateFin->diffInDays($dateDebut);
    if($duree_location<=0){
        $montantTotal = $request->input('montant_reservation');
    }
    
    else{
        // Calcul du montant total
        $montantTotal = $duree_location * $request->input('montant_reservation');
    }
    

    $user = auth()->user();
    $admins = User::where('role', 'admin')->get();
    

    if ($user) {
        $voiture_id = $request->input('voiture_id');
        
        // Vérifier si la voiture est disponible pour la période demandée
        $voitureDisponible = $this->checkVoitureAvailability($voiture_id);
        
        if ($voitureDisponible) {
            // Créer et enregistrer la réservation
            $reservation = new Reservation();
            $reservation->user_id = $user->id;
            $reservation->voiture_id = $voiture_id;
            $reservation->date_debut = $request->input('date_debut');
            $reservation->date_fin = $request->input('date_fin');
            $reservation->montant_reservation = $request->input('montant_reservation');
            $reservation->montant_total = $montantTotal;
            $reservation->lieu_depart = $request->input('lieu_depart');
            $reservation->destination = $request->input('destination');
            $reservation->heure_depart = $request->input('heure_depart');
            $reservation->heure_fin = $request->input('heure_fin');
            $reservation->save();
            
            $heureFinReservation = Carbon::parse($reservation->date_fin . ' ' . $reservation->heure_fin);
            //dd($heureFinReservation);
            $this->updateReservationStatus($reservation, 'En cours');
            $this->updateVoitureAvailability($voiture_id, $heureFinReservation, $request->input('date_fin'));
            foreach ($admins as $admin) {
                $admin->notify(new NewReservation($reservation));
                
                // Utiliser Carbon pour la date de la notification différée
                $admin->notify((new ReservationDue($reservation)));
                //$admin->notify((new ReservationDue($reservation))->later($heureFinReservation));
            }

            $notification = [
                'message' => 'Réservation effectuée avec succès',
                'alert-type' => 'success'
            ];
            return redirect()->route('frontend.reservation_success')->with('reservation', $reservation);
            
        } else {
            // La voiture n'est pas disponible pour la période demandée
            $prochaine_disponibilite = $this->getProchaineDisponibilite($voiture_id);
            $notification = [
                'message' => 'La voiture n\'est pas disponible pour la période demandée.',
                'alert-type' => 'error',
                'prochaine_disponibilite' => $prochaine_disponibilite,
            ];

            return redirect()->route('frontend.reservation_abort', compact('prochaine_disponibilite'))->with('prochaine_disponibilite', $prochaine_disponibilite);

        }
    } else {
        return redirect()->route('login')
            ->with('message', 'Vous devez vous connecter pour effectuer une réservation.')
            ->withInput();
    }
}

protected function updateReservationStatus(Reservation $reservation, $statut)
{
    $reservation->statut = $statut;
    $reservation->save();
}

public function updateVoitureAvailability($voitureId, $heureFinReservation, $dateFinReservation)
{
    $dateFinReservation = Carbon::parse($dateFinReservation);
    $heureFinReservation = Carbon::parse($heureFinReservation);

    // Récupérez l'entrée de disponibilité pour la voiture
    $disponibilite = DisponibiliteVehicule::where('voiture_id', $voitureId)
        ->first();

    // Mettez à jour la disponibilité de la voiture
    if ($disponibilite) {
        $disponibilite->update([
            'statut' => 'Réservé',
            'date_disponibilite' => $dateFinReservation->setTime($heureFinReservation->hour, $heureFinReservation->minute),
        ]);
    }
}

// Exemple dans un contrôleur
public function reserveCar($voitureId)
{
    $car = Voiture::findOrFail($voitureId);
    $car->markAsReserved();

    // Autres logiques de réservation...

    return redirect()->back();
}

public function makeAvailable($voitureId)
{
    $car = Voiture::findOrFail($voitureId);
    $car->markAsAvailable();

    // Autres logiques pour rendre la voiture disponible...

    return redirect()->back();
}





    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();
        $notification=array(
            'message'=>'Reservation supprimée avec succès',
            'alert-type'=>'success'
        );
    
        return redirect()->route('reservations.index')->with('success', $notification );
    }

    

}