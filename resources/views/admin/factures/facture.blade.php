<?php
    include app_path('Helpers/functions.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture</title>
    <!-- Ajouter ces lignes pour inclure Bootstrap via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="row align-items">
        <div class="col-lg-12 d-flex justify-content-between">
                <div class="col-lg-4 float-start">
                    <img src="{{ public_path('logo2.png') }}" alt="Logo" height="50px">
                </div>
                <div class="col-lg-4 d-none">Texte vide</div>
                <div class="col-lg-4 float-end">
                    <span>Lomé, {{ now()->isoFormat('D MMMM YYYY', 'Do MMMM YYYY') }}</span> <br><br>
                    <span>DOIT</span><br>
                    <h1>{{ $reservation->user->name }}</h1> <br>
                    <span class="text-decoration-underline">LOME-TOGO</span>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-80" style="margin-top: 200px;">
        <h3 class="text-decoration-underline">{{$facture->nom}}</h3> <br>
        <p class="display-4"><span class="text-decoration-underline">Objet:</span>
            Location du véhicule {{$reservation->voiture->marque}} {{$reservation->voiture->modele}}
            {{$reservation->voiture->immatriculation}}  <br>
        </p>

        <table class="table table-lg table-bordered">
            <thead style="background-color:#A4A9AC;">
              <tr>
                <th scope="col" class="align-middle" style="height: 50px">N°</th>
                <th scope="col" class="align-middle" style="height: 50px">Désignation</th>
                <th scope="col" class="align-middle" style="height: 50px">Période</th>
                <th scope="col" class="align-middle" style="height: 50px">Prix unitaire (FCFA)</th>
                <th scope="col" class="align-middle" style="height: 50px">Quantité (Jours)</th>
                <th scope="col" class="align-middle" style="height: 50px">Montant (FCFA)</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>{{$facture->nom}}</td>
                <td>
                    {{$reservation->voiture->marque}} {{$reservation->voiture->modele}}
                    {{$reservation->voiture->immatriculation}}
                </td>
                <td>Du {{$reservation->date_debut}} au {{$reservation->date_fin}}</td>
                <td>{{$reservation->montant_reservation}}</td>
                <td>
                    @php
                    $dateDebut = new DateTime($reservation->date_debut);
                    $dateFin = new DateTime($reservation->date_fin);
                    $difference = $dateFin->diff($dateDebut)->days;
                    @endphp
                    {{ $difference }}
                </td>
                <td>{{$reservation->montant_total}}</td>
              </tr>
              <tr>
                <td></td>
                <td>
                    
                </td>
                <td></td>
                <td colspan=2>

                </td>
                
                <td>{{$reservation->montant_total}}</td>
              </tr>
            </tbody>
          </table>
            
        </table>
        <br><br>
        <div class="row">
            <p>
                Arrêté la présente facture à la somme de <span style="font-weight:bold;"> {{ convertirEnLettres($reservation->montant_total) }} ({{ number_format($reservation->montant_total, 0, ',', ' ') }}) Francs CFA</span>  
                
            </p>            
            <p>Facture payable dès réception.</p> <br> <br> <br>
        </div>
        <div class="row">
            <div class="col-lg-12 d-flex justify-content-between">
                <div class="col-lg-9 d-none">
                    <p>Text vide</p>
                </div>
                <div class="col-lg-3 float-end">
                    <h5 display=6 class="float-end"> Le Gérant</h5>
                </div>
            </div>
        </div>
        
    </div>

</body>
</html>
