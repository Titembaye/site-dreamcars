<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Jobs\SimpleJob;
use App\Models\Reservation;
use App\Models\Facture;
use App\Models\Voiture;
use App\Models\DisponibiliteVehicule;
use App\Models\User;
use App\Notifications\NewReservation;
use App\Notifications\ReservationDue;
use Illuminate\Support\Facades\Log;
use PDF;

class ReservationController extends Controller
{
    protected $table = 'reservations';
    
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10); 
        $query = $request->input('query');

        $reservations = Reservation::query();

        if ($query) {
            // Si une requête de recherche est présente, effectuer la recherche
            $reservations->whereHas('voiture', function ($innerQuery) use ($query) {
                $innerQuery->where('marque', 'like', '%' . $query . '%')
                    ->orWhere('modele', 'like', '%' . $query . '%');
            })
            ->orWhere('date_debut', 'like', '%' . $query . '%')
            ->orWhere('date_fin', 'like', '%' . $query . '%');
        }

        // Tri par ordre décroissant de la date de création
        $reservations->orderBy('created_at', 'desc');

        $reservations = $reservations->paginate($perPage);

        return view('admin.reservations.index', ['reservations' => $reservations]);
    }



    public function create()
    {
        $voitures=Voiture::all();
        return view('admin.reservations.create', compact('voitures'));
    }

   

    public function store(Request $request){
        $this->validate($request, [
            'voiture_id' => 'required|integer',
            'lieu_depart' => 'required|string|max:100',
            'heure_depart' => 'required|date_format:H:i',
            'date_debut' => 'required|date|after_or_equal:today',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'heure_fin' => 'required|date_format:H:i',
            'destination' => 'required|string|max:100', 
        
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
            $voiture = Voiture::find($voiture_id);
            
            // Vérifier si la voiture est disponible pour la période demandée
            $voitureDisponible = $this->checkVoitureAvailability($voiture_id);
            
            if ($voitureDisponible) {
                // Créer et enregistrer la réservation
                $reservation = new Reservation();
                $reservation->user_id = $user->id;
                $reservation->reservation_id = Reservation::generateReservationId();
                $reservation->voiture_id = $voiture_id;
                $reservation->date_debut = $request->input('date_debut');
                $reservation->date_fin = $request->input('date_fin');
                $reservation->montant_reservation = $voiture->montant_journalier;
                $reservation->montant_total = $montantTotal;
                $reservation->lieu_depart = $request->input('lieu_depart');
                $reservation->destination = $request->input('destination');
                $reservation->heure_depart = $request->input('heure_depart');
                $reservation->heure_fin = $request->input('heure_fin');
                $reservation->save();
                
                $heureFinReservation = Carbon::parse($reservation->date_fin . ' ' . $reservation->heure_fin);
                //changer le statut de la reservation pour dire qu'elle est en cours
                $this->updateReservationStatus($reservation, 'En cours');
                //Mettre le statut de la voiture à Réservé
                $this->updateVoitureAvailability($voiture_id, $heureFinReservation, $request->input('date_fin'));
                
                //Créer la facture correspondante
                $facture=new Facture();
                $facture->date_emission=now();
                $facture->facture_id = Facture::generateFactureId();
                $facture->reservation_id=$reservation->reservation_id;
                $facture->save();
                
                // Générer la facture
                $pdf = PDF::loadView('admin.factures.facture', compact('reservation', 'facture', 'duree_location'));
                
                // Sauvegarder le PDF ou le retourner en réponse HTTP
                $pdf->save(storage_path('app/factures/'.$reservation->id.'.pdf'));
                
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
                return redirect()->route('reservations.index')->with('reservation', $reservation, 'notification');
                
            } else {
                // La voiture n'est pas disponible pour la période demandée
                $prochaine_disponibilite = $this->getProchaineDisponibilite($voiture_id);
                $notification = [
                    'message' => 'La voiture n\'est pas disponible pour la période demandée.',
                    'alert-type' => 'error',
                    'prochaine_disponibilite' => $prochaine_disponibilite,
                ];
    
                return redirect()->back()->with('prochaine_disponibilite', $prochaine_disponibilite);
    
            }
        } else {
            return redirect()->route('login')
                ->with('message', 'Vous devez vous connecter pour effectuer une réservation.')
                ->withInput();
        }
    }
    


    public function edit($id){
        $voitures = Voiture::all();
        $reservation = Reservation::find($id);
    
        return view('admin.reservations.edit', compact('reservation', 'voitures'));
    }
    
    public function update(Request $request, $id){
        $this->validate($request, [
            'voiture_id' => 'required|integer',
            'lieu_depart' => 'required|string|max:100',
            'heure_depart' => 'required|date_format:H:i',
            'date_debut' => 'required|date|after_or_equal:today',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'heure_fin' => 'required|date_format:H:i',
            'destination' => 'required|string|max:100',
        ]);
    
        // Fetch the existing reservation
        $reservation = Reservation::find($id);
    
        // Validate and update reservation details
        $reservation->voiture_id = $request->input('voiture_id');
        $reservation->lieu_depart = $request->input('lieu_depart');
        $reservation->heure_depart = $request->input('heure_depart');
        $reservation->date_debut = $request->input('date_debut');
        $reservation->date_fin = $request->input('date_fin');
        $reservation->heure_fin = $request->input('heure_fin');
        $reservation->destination = $request->input('destination');
    
        // Calculate duration and total amount
        $dateDebut = Carbon::parse($reservation->date_debut);
        $dateFin = Carbon::parse($reservation->date_fin);
        $duree_location = $dateFin->diffInDays($dateDebut);
    
        if ($duree_location <= 0) {
            $montantTotal = $request->input('montant_reservation');
        } else {
            $montantTotal = $duree_location * $request->input('montant_reservation');
        }
    
        // Update reservation details
        $voiture=Voiture::find($reservation->voiture_id);
        $reservation->montant_reservation = $voiture->montant_journalier;
        $reservation->montant_total = $montantTotal;
        
        // Save the updated reservation
        $reservation->save();
    
        // Other logic such as generating invoice, notifications, etc.
    
        $notification = [
            'message' => 'Réservation mise à jour avec succès',
            'alert-type' => 'success'
        ];
    
        return redirect()->route('reservations.index')->with($notification);
    }
      

    public function show($id){
    
        $reservation = Reservation::with('user','voiture')->findOrFail($id);

        return view('admin.reservations.show', compact('reservation'));
    }

    public function userReservations(){
        // Récupérer l'utilisateur connecté
        $utilisateur = Auth::user();

        // Récupérer les réservations de cet utilisateur
        $reservations = Reservation::where('user_id', $utilisateur->id)->get();

        // Passer les réservations à la vue
        return view('admin.reservations.mes_reservations', compact('reservations'));
    }


    private function checkVoitureAvailability($voitureId){
        return Voiture::where('id', $voitureId)
            ->whereHas('disponibilite', function ($query) {
                $query->where('statut', 'Disponible');
            })
            ->exists();
    }
    
    private function getProchaineDisponibilite($voitureId){
        return Voiture::find($voitureId)
            ->disponibilite()
            ->orderBy('date_disponibilite')
            ->first();
    }


public function reservation_store(Request $request){
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
            $reservation->reservation_id = Reservation::generateReservationId();

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
            
            $facture=new Facture();
            $facture->date_emission=now();
            $facture->facture_id = Facture::generateFactureId();
            $facture->reservation_id=$reservation->reservation_id;
            $facture->save();
            
            // Générer la facture
            $pdf = PDF::loadView('admin.factures.facture', compact('reservation','facture', 'duree_location'));
            
            // Sauvegarder le PDF ou le retourner en réponse HTTP
            $pdf->save(storage_path('app/factures/'.$reservation->id.'.pdf'));
            
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

protected function updateReservationStatus(Reservation $reservation, $statut){
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
    $voiture_id = $reservation->voiture_id;

    // Récupérer la disponibilité associée à la réservation
    $disponibilite = DisponibiliteVehicule::where('voiture_id', $voiture_id)->first();

    if ($disponibilite) {
        // Mettre à jour le statut de disponibilité à "Disponible"
        $disponibilite->update(['statut' => 'Disponible']);
    }

    // Supprimer la réservation
    $reservation->delete();

    $notification = [
        'message' => 'Réservation supprimée avec succès',
        'alert-type' => 'success'
    ];

    return redirect()->route('reservations.index')->with('success', $notification);
}

}