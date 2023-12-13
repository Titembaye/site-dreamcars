<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PatricPoba\MtnMomo\MtnConfig;
use PatricPoba\MtnMomo\MtnCollection;
//use Ibracilinks\OrangeMoney\CinetPay;
use CinetPay\CinetPay;

use App\Models\Payer;
use Cookie;

class PayerController extends Controller
{
    
public function index()
{
    //$url="https://api-checkout.cinetpay.com/v2/payment";
    //return view($url);
    return view('payer.smspayer');
}

    

public function orange(Request $request)
{
  
    $customer_name ="gg";
    $customer_surname = "lll";
    $description ="dgfegtgrth";
    $amount ="100";
    $currency = "XOF";
    
    //transaction id
    $id_transaction = date("YmdHis"); // or $id_transaction = Cinetpay::generateTransId()
    
    //Veuillez entrer votre apiKey
    $apikey = "XXXXXXXXXXXXXXXXXXXXXXXXX";
    //Veuillez entrer votre siteId
    $site_id = "XXXXXXXXXXXXXXXXX";
    
    //notify url
    $notify_url = "http://mondomaine.com/notify/";
    //return url
    $return_url = "http://mondomaine.com/notify/";
    $channels = "ALL";
    
    
    $formData = array(
        "transaction_id"=> $id_transaction,
        "amount"=> $amount,
        "currency"=> $currency,
        "customer_surname"=> $customer_name,
        "customer_name"=> $customer_surname,
        "description"=> $description,
        "notify_url" => $notify_url,
        "return_url" => $return_url,
        "channels" => $channels,
        "metadata" => "Joe", // utiliser cette variable pour recevoir des informations personnalisés.
        "alternative_currency" => "XOF",//Valeur de la transaction dans une devise alternative
        //pour afficher le paiement par carte de credit
        "customer_email" => "down@test.com", //l'email du client
        "customer_phone_number" => "0708876711", //Le numéro de téléphone du client
        "customer_address" => "BP 0024", //l'adresse du client
        "customer_city" => "abidjan", // ville du client
        "customer_country" => "CI",//Le pays du client, la valeur à envoyer est le code ISO du pays (code à deux chiffre) ex : CI, BF, US, CA, FR
        "customer_state" => "CI", //L’état dans de la quel se trouve le client. Cette valeur est obligatoire si le client se trouve au États Unis d’Amérique (US) ou au Canada (CA)
        "customer_zip_code" => "225" //Le code postal du client
    );
    // enregistrer la transaction dans votre base de donnée
    /*  $commande->create(); */
    
    $CinetPay = new CinetPay($site_id, $apikey);
    $result = $CinetPay->generatePaymentUrl($formData);
    $url = $result["data"]["payment_url"];

    return redirect ($url);
}


}
