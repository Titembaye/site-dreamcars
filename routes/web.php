<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChauffeurController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PayerController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\AgenceController;


use App\Models\Reservation;


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

//Admin group middleware
Route::middleware(['auth','role:admin'])->group(function(){
    Route::get('/admin/dashboard', [AdminController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/admin/logout', [AdminController::class, 'adminLogout'])->name('admin.logout');
    Route::get('/admin/profile', [AdminController::class, 'adminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminController::class, 'adminProfileStore'])->name('admin.profile.store');
    Route::get('/admin/change/password', [AdminController::class, 'adminChangePassword'])->name('admin.change.password');
    Route::post('/admin/update/password', [AdminController::class, 'adminUpdatePassword'])->name('admin.update.password');

    Route::get('/reservations/mesreservations', [App\Http\Controllers\ReservationController::class, 'userReservations'])->name('user_reservations');


    Route::get('/voitures/image_create',[App\Http\Controllers\VoitureController::class, 'createimage'])->name('voitures.createimage');
    Route::post('/voitures/image_store',[App\Http\Controllers\VoitureController::class, 'imagestore'])->name('voitures.imagestore');
    Route::get('/voitures/{id}/editimage', [App\Http\Controllers\VoitureController::class, 'editimage'])->name('voitures.editimage');
    Route::put('/voitures/{id}/imageupdate', [App\Http\Controllers\VoitureController::class, 'imageupdate'])->name('voitures.imageupdate');

    Route::get('/voitures/search', [App\Http\Controllers\VoitureController::class, 'index'])->name('voitures.search');
    
    //Routes pour gestion des utilisateurs
    Route::get('/admin/login', [AdminController::class, 'adminLogin'])->name('admin.login');
    Route::get('/users', [AdminController::class, 'index'])->name('users.index');
    Route::get('/users/create', [AdminController::class, 'create_user'])->name('users.create');
    Route::get('/users/{user}', [AdminController::class, 'show'])->name('users.show'); // Afficher les détails d'un utilisateur
    Route::get('/users/{user}/edit', [AdminController::class, 'edit'])->name('users.edit'); // Modifier un utilisateur
    Route::delete('/users/{user}', [AdminController::class, 'destroy'])->name('users.destroy'); // Supprimer un utilisateur
    Route::post('/users', [AdminController::class, 'store'])->name('users.store');
    Route::put('/users/{user}', [AdminController::class, 'update'])->name('users.update');

    //routes pour AgenceController
    Route::get('agences', 'App\Http\Controllers\AgenceController@index')->name('agences.index');
    Route::get('agences/{agence}', 'App\Http\Controllers\AgenceController@show')->name('agences.show');
    Route::get('agences/create', 'App\Http\Controllers\AgenceController@create')->name('agences.create');
    Route::post('agences', 'App\Http\Controllers\AgenceController@store')->name('agences.store');
    Route::get('agences/{agence}/edit', 'App\Http\Controllers\AgenceController@edit')->name('agences.edit');
    Route::put('agences/{agence}', 'App\Http\Controllers\AgenceController@update')->name('agences.update');
    Route::delete('agences/{agence}', 'App\Http\Controllers\AgenceController@destroy')->name('agences.destroy');
    Route::get('messagesList', 'App\Http\Controllers\AgenceController@messageList')->name('messagesList');
    Route::get('messages/{message}', 'App\Http\Controllers\AgenceController@messageShow')->name('messages.show');
    Route::delete('messages/{message}', 'App\Http\Controllers\AgenceController@destroyMessage')->name('messages.destroy');


    Route::resource('chauffeurs', 'App\Http\Controllers\ChauffeurController');

    //Route::resource('agences', 'App\Http\Controllers\AgenceController');
    Route::resource('disponibilites', 'App\Http\Controllers\DisponibiliteVoitureController');
    Route::resource('missions', 'App\Http\Controllers\MissionController');
    Route::resource('voitures', 'App\Http\Controllers\VoitureController');
    Route::resource('factures', 'App\Http\Controllers\FactureController')->parameters([
        'factures' => 'facture', // utilisé 'facture' au lieu de 'facture_id'
    ])->where([
        'facture' => '[A-Za-z0-9]+', // contrainte pour accepter uniquement les caractères alphanumériques
    ]);
    Route::get('/generer-facture', [App\Http\Controllers\FactureController::class, 'genererFacture']);
    Route::get('/search-reservations', 'App\Http\Controllers\FactureController@searchReservations')->name('search.reservations');

});





//Route::resource('chauffeurs', 'App\Http\Controllers\ChauffeurController');

//Route::resource('agences', 'App\Http\Controllers\AgenceController');
//Route::resource('disponibilites', 'App\Http\Controllers\DisponibiliteVoitureController');
//Route::resource('missions', 'App\Http\Controllers\MissionController');
//Route::resource('voitures', 'App\Http\Controllers\VoitureController');
//Route::resource('factures', 'App\Http\Controllers\FactureController')->parameters([
//    'factures' => 'facture', // utilisé 'facture' au lieu de 'facture_id'
//])->where([
//    'facture' => '[A-Za-z0-9]+', // contrainte pour accepter uniquement les caractères alphanumériques
//]);
//Route::get('/generer-facture', [App\Http\Controllers\FactureController::class, 'genererFacture']);
//Route::get('/search-reservations', 'App\Http\Controllers\FactureController@searchReservations')->name('search.reservations');



Route::middleware(['auth'])->group(function(){
    Route::resource('reservations', 'App\Http\Controllers\ReservationController');
    Route::post('/reservations/store_reseravation', [App\Http\Controllers\ReservationController::class, 'reservation_store'])->name('reservations.reservation_store');
    
});




Route::get('/', [FrontendController::class,'accueil'])->name('accueil');
Route::get('/all-properties', [FrontendController::class,'all_properties'])->name('all_properties');
Route::get('/details/{voitureId}', [FrontendController::class,'details_voiture'])->name('voiture.details');
Route::get('/search', [FrontendController::class,'search'])->name('search.index');
Route::get('/properties', [FrontendController::class,'all_properties'])->name('properties');
Route::get('/dispo-properties', [FrontendController::class,'dispo_properties'])->name('dispo_properties');
Route::get('/messages/create', [FrontendController::class,'message_create'])->name('messages.create');
Route::post('/messages', [FrontendController::class,'message_store'])->name('messages.store');
Route::get('/services', [FrontendController::class, 'services'])->name('services');

Route::get('/create-payment/{reservation_id}', [PaymentController::class, 'showPaymentPage'])->name('frontend.payment');
Route::get('/payment-success', [PaymentController::class, 'payment_success'])->name('frontend.payment_success');
Route::post('/create-checkout-session', [PaymentController::class, 'createCheckoutSession']);
Route::post('/process-checkout-session', [PaymentController::class, 'process_payment'])->name('process_payment');


Route::get('/services-details', function() {
    return view('frontend.detail_service');
})->name('detail-service');

Route::get('/contact', function() {
    return view('frontend.contact');
})->name('contact');

Route::get('/reservation-success', [FrontendController::class, 'showReservationSuccess'])->name('frontend.reservation_success');
Route::get('/reservation-abort', [FrontendController::class, 'showReservationAbort'])->name('frontend.reservation_abort');
Route::get('/factures/{facture}/pdf', 'App\Http\Controllers\FactureController@generatePDF')->name('factures.pdf');




//Route::get('/create_facture', [FactureController::class, 'create'])->name('factures.create');
//Route::post('/facture_store', [FactureController::class, 'store'])->name('factures.store');

// paiement routes

//Route::get('/paiement', [PayerController::class,'index'])->name('paiement');
//Route::post('/orange', [PayerController::class,'orange'])->name('store_paiement');
//Route::post('/retour-paiement', 'CinetPayController@handlePaymentCallback');

Route::get('/paiement', [\App\Http\Controllers\CinetPayController::class, 'index']);
Route::post('/paiement', [\App\Http\Controllers\CinetPayController::class, 'Payment']);
Route::match(['get','post'],'/notify_url', [\App\Http\Controllers\CinetPayController::class, 'notify_url'])->name('notify_url');
Route::match(['get','post'],'/return_url', [\App\Http\Controllers\CinetPayController::class, 'return_url'])->name('return_url');
