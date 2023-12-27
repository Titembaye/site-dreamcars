<?php

// app/Http/Controllers/FactureController.php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Facture;

use Illuminate\Http\Request;
use PDF;
use Illuminate\Support\Facades\Storage;
class FactureController extends Controller
{
    public function index()
    {
        //trier les factures par ordre décroissant de date de création
        $factures = Facture::latest()->paginate(10);
        return view('admin.factures.index', compact('factures'));
    }

    public function show($id){
        $facture=Facture::find($id);
        return view('admin.factures.show',compact('facture'));
    }

    public function create(){
        $reservations=Reservation::all();
        //dd($reservations);
        return view('admin.factures.create', compact('reservations'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'reservation_id' => 'required|string',
            'date_emission' => 'required|date',
            // Ajoutez d'autres règles de validation au besoin
        ]);
    
        // Créer la facture
        $facture = new Facture();
        $facture->reservation_id = $request->input('reservation_id');
        $facture->date_emission = $request->input('date_emission');

        $notification=array(
            'message'=>'Facture ajouté avec succès',
            'alert-type'=>'success'
        );

        $facture->save();
    
        // Utilisez le numéro de la facture comme nom du fichier
        $pdfFileName = 'FACTURE N°' . $facture->facture_id . '.pdf';
    
        $reservation = Reservation::find($facture->reservation_id);
    
        $pdf = PDF::loadView('admin.factures.facture', compact('reservation', 'facture'));
    
        // Stockez le fichier PDF dans le dossier 'factures' avec le nom de fichier généré
        Storage::put('factures/' . $pdfFileName, $pdf->output());
    
        return redirect()->route('factures.index')
            ->with($notification);
    }



    public function generatePDF(Facture $facture)
    {
        // Logique pour générer le PDF
        // Vous pouvez utiliser des bibliothèques comme DOMPDF ou TCPDF
        $reservation=$facture->reservation;
        // Exemple avec DOMPDF
        $pdf = \PDF::loadView('admin.factures.facture', compact('facture','reservation'));

        // Retourne la réponse PDF
        return $pdf->stream('facture.pdf');
    }

    // app/Http/Controllers/FactureController.php

    public function searchReservations(Request $request)
    {
        $query = $request->input('query');

        $reservations = Reservation::where('nom', 'LIKE', "%$query%")
            ->orWhere('autre_attribut', 'LIKE', "%$query%")
            ->get();

        return response()->json($reservations);
    }

    // app/Http/Controllers/FactureController.php

    // ... (votre code existant)

    public function edit($facture_id)
    {
        $facture = Facture::find($facture_id);
        $reservations = Reservation::all();
        return view('admin.factures.edit', compact('facture', 'reservations'));
    }

    // app/Http/Controllers/FactureController.php



    public function update(Request $request, $id)
    {
        $request->validate([
            'reservation_id' => 'required|string',
            'date_emission' => 'required|date_format:Y-m-d',
            // Ajoutez d'autres règles de validation au besoin
        ]);

        // Récupère la facture existante
        $facture = Facture::find($id);

        // Supprime le PDF associé à la facture existante
        $pdfFileName = 'FACTURE N°' . $facture->facture_id . '.pdf';
        Storage::delete('factures/' . $pdfFileName);

        // Met à jour les informations de la facture
        $facture->reservation_id = $request->input('reservation_id');
        $facture->date_emission = $request->input('date_emission');
        $facture->save();

        // Génère un nouveau PDF avec les informations mises à jour
        $newPdfFileName = 'FACTURE N°' . $facture->facture_id . '.pdf';
        $reservation = Reservation::find($facture->reservation_id);
        $newPdf = PDF::loadView('admin.factures.facture', compact('reservation', 'facture'));
        Storage::put('factures/' . $newPdfFileName, $newPdf->output());

        return redirect()->route('factures.index')
            ->with('success', 'Facture mise à jour avec succès.');
    }


    public function destroy($facture)
    {
        // Recherchez la facture avec la clé primaire personnalisée
        $facture = Facture::where('facture_id', $facture)->first();

        // Vérifiez si la facture existe
        if ($facture) {
            // Supprimez la facture
            $facture->delete();

            // Supprimez le PDF associé (à implémenter selon votre logique)
            // Storage::delete('factures/' . 'FACTURE N°' . $facture->facture_id . '.pdf');

            return redirect()->route('factures.index')
                ->with('success', 'Facture supprimée avec succès.');
        } else {
            return redirect()->route('factures.index')
                ->with('error', 'Facture non trouvée.');
        }
    }

    
}
