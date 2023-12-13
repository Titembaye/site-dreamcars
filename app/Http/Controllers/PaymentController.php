<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Reservation;

class PaymentController extends Controller
{
    public function showPaymentPage($reservation_id)
    {
        return view('frontend.payment',['reservation_id' => $reservation_id]);
    }

    
    public function process_payment(Request $request)
    {
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
    
        // Récupérer les détails de la réservation
        $reservation = Reservation::find($request->input('reservation_id'));
    
        // Convertir les chaînes de caractères en objets de date
        $dateDebut = \Carbon\Carbon::parse($reservation->date_debut);
        $dateFin = \Carbon\Carbon::parse($reservation->date_fin);
    
        // Calculer la différence en jours
        $qte = $dateFin->diffInDays($dateDebut);
        $total_price = $qte * $reservation->prix_journalier;
    
        $successUrl = $request->input('success_url');
        $cancelUrl = $request->input('cancel_url');
        // Créer la session de paiement
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price' => 'price_1OEqiBK757ICxpJbNRdCj7N0', // Remplacez par l'ID du prix dans Stripe
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $successUrl,
            'cancel_url' => $cancelUrl,
        ]);
    
        return response()->json(['id' => $session->id]);
    }
    

}

