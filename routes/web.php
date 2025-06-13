<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ChequeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EntrepriseController;
use App\Http\Controllers\EspaceClientController;
use App\Http\Controllers\TaxeEntrepriseController;
use App\Http\Controllers\PaiementInitialController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



/// la route des pages d'accueil

Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('acceuil');
    Route::get('/connexion', 'login')->name('pageConnexion');

    Route::post('/traiementConnexion', 'connexionAdministrateur')->name('connexion.Utilisateur');
    Route::get('/inscriptioninstallation', 'inscription')->name('inscriptionVitrine');

    Route::post('/traitementInscription', 'storeInscription')->name('inscriptionVitrine.store');
    Route::get('/pageSuccessInscription/{codeInscription}', 'pageresultatsInscription')->name('inscriptionVitrine.success');
    Route::get('/creattionAcces/{codeInscription}', 'validationAcces')->name('accessCreat');

    Route::post('/traitementAccesEntreprise', 'traitAcceEntreprise')->name('traitAccesEntreprise');
    // Route::get('/home', 'index')->name('home');

    //retour paiement
    Route::get('/retourPaiementResultat/{codePaiement}','retourPaiement');
    Route::get('/voirRecuPaiement/{codePaiement}','recuPaiement')->name('recuPay');
});

// route des paiements
Route::controller(PaiementInitialController::class)->group(function () {
    Route::post('passagesurlehub','paiementHub')->name('paiementHub');
});


Route::middleware('auth')->group(function () {
    // les routes du dashboard administrateur et super-administrateur
    Route::middleware('verifierRoleUtilisateur:super-administrateur,administrateur')->group(function () {
        Route::controller(DashboardController::class)->group(function () {
            Route::get('/dashboard', 'index')->name('dashboard');
            Route::get('/inscription', 'listeInscription')->name('inscription');
        });

        Route::controller(EntrepriseController::class)->group(function () {
            Route::get('/entreprises', 'index')->name('entreprises.index');
            Route::get('/entreprises/import', 'import')->name('entreprises.import');
            Route::post('/entreprises/impoter/traitement','traitementImportationExcel')->name('entreprises.traitementImportationExcel');
            // Route::get('/entreprises/create', 'create')->name('entreprises.create');
            // Route::post('/entreprises', 'store')->name('entreprises.store');
            // Route::get('/entreprises/{entreprise}', 'show')->name('entreprises.show');
            // Route::get('/entreprises/{entreprise}/edit', 'edit')->name('entreprises.edit');
            // Route::put('/entreprises/{entreprise}', 'update')->name('entreprises.update');
            // Route::delete('/entreprises/{entreprise}', 'destroy')->name('entreprises.destroy');
        });

        Route::controller(TaxeEntrepriseController::class)->group(function () {
            Route::get('/entreprises/taxes/{id}', 'listeTaxeEntreprise')->name('entreprises.taxes.index');
            // Route::get('/entreprises/{id}/taxes/create', 'create')->name('entreprises.taxes.create');
            // Route::post('/entreprises/{id}/taxes', 'store')->name('entreprises.taxes.store');
            // Route::get('/entreprises/taxes/{taxeEntreprise}', 'show')->name('entreprises.taxes.show');
            // Route::get('/entreprises/taxes/{taxeEntreprise}/edit', 'edit')->name('entreprises.taxes.edit');
            // Route::put('/entreprises/taxes/{taxeEntreprise}', 'update')->name('entreprises.taxes.update');
            // Route::delete('/entreprises/taxes/{taxeEntreprise}', 'destroy')->name('entreprises.taxes.destroy');
        });

        Route::controller(PaiementInitialController::class)->group(function () {
            Route::get('/entreprises/paiements', 'index')->name('entreprises.paiements.index');
            // Route::get('/entreprises/paiements/{id}', 'show')->name('entreprises.paiements.show');
            // Route::post('/entreprises/paiements/traitement', 'traitementPaiement')->name('entreprises.paiements.traitement');
        });

        Route::controller(ChequeController::class)->group(function(){
            Route::get('/listedescheques','index')->name('listCheques');
            Route::get('/detailCheques/{id}','show')->name('detail.cheques');
            Route::post('/validationdeCheque/{id}','confirmeCheque')->name('validcheque');
            Route::post('/refuserCheques/{id}','refuseCheque')->name('refusCheque');
        });
    });

    // les routes de l'espace client7
    Route::middleware('verifierRoleUtilisateur:entreprise')->group(function () {
        Route::controller(EspaceClientController::class)->group(function () {
            Route::get('/espace-client', 'index')->name('espaceClient.index');
            Route::post('/espace-client/cheques', 'pageEnregistCheque')->name('espaceClient.cheques');
            Route::post('EnregistreCheque', 'chequEnregistre')->name('espaceClient.cheques.enregistre');
            Route::get('/pageSuccesCheque/{id}','succesEnregiCheque')->name('succesCheque');


            Route::get('/listesdePaiementEffectuel/{id}', 'mesrecus')->name('espaceClient.mesrecus');
            // Route::get('/espace-client/entreprise', 'entreprise')->name('espaceClient.entreprise');
            // Route::get('/espace-client/taxes', 'taxes')->name('espaceClient.taxes');
            // Route::get('/espace-client/factures', 'factures')->name('espaceClient.factures');
        });
    });

    
});

require __DIR__.'/auth.php';
