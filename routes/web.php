<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/formLogin', [\App\Http\Controllers\PraticienController::class, 'getLogin']);
Route::post('/login', [\App\Http\Controllers\PraticienController::class, 'signIn']);
Route::get('/getLogout', [\App\Http\Controllers\PraticienController::class, 'signOut']);


    Route::group(['prefixe' => 'praticien','middleware' => 'connect'], function() {
        /*--------------------------------------Récupération des données-----------------------------------------------*/

        /* Récupère tous les praticien avec l'ensemble des informations (Plusieurs lignes si plusieurs activites) */
        Route::get('/listePraticiens', [\App\Http\Controllers\PraticienController::class, 'listePraticiens']);

        /* Récupère l'ensemble des types et des spécialités*/
        Route::get('/ajoutPrat', [\App\Http\Controllers\PraticienController::class, 'listeTypes_et_Spe']);

        /* Récupère l'ensemble des types et des spécialités et l'ensemble des informations du praticien*/
        Route::get('/modifPrat/{id}', [\App\Http\Controllers\PraticienController::class, 'pratParID']);

        /*--------------------------------------Utilisation des données-----------------------------------------------*/

        /*Ajoute le praticien*/
        Route::post('/ajoutPratFin', [\App\Http\Controllers\PraticienController::class, 'AjoutPrat']);

        /*Supprime le praticien*/
        Route::get('/supprPrat/{idPrat}', [\App\Http\Controllers\PraticienController::class, 'supprPrat']);

        /*Modifie le praticien*/
        Route::post('/modifPratFin', [\App\Http\Controllers\PraticienController::class, 'modifPrat']);
    });

    Route::group(['prefixe' => 'act','middleware' => 'connect'], function() {

        /*--------------------------------------Récupération des données-----------------------------------------------*/

        /* Récupère les activités disponible, les activités du praticien, le nombre d'activité et les informations du praticien */
        Route::get('/infosAct/{id}', [\App\Http\Controllers\ActiviteController::class, 'listeActivites']);

        /* Récupère les activités disponible, les activités du praticien  et les informations du praticien */
        Route::get('/ajoutAct/{id}', [\App\Http\Controllers\ActiviteController::class, 'goAjoutAct']);

        /* Récupère les activités disponible, les activités du praticien  et les informations du praticien */
        Route::get('/modifAct/{idAct}/{idPrat}/{spe}', [\App\Http\Controllers\ActiviteController::class, 'goModifAct']);
        /*--------------------------------------Utilisation des données-----------------------------------------------*/

        /* Ajoute l'activite d'un praticien */
        Route::post('/ajoutFin', [\App\Http\Controllers\ActiviteController::class, 'AjoutActPourPrat']);

        /* Supprime l'activite d'un praticien */
        Route::get('/supprAct/{idAct}/{idPrat}', [\App\Http\Controllers\ActiviteController::class, 'supprActForPrat']);

        /* Modifie l'activite d'un praticien */
        Route::post('/modifFin', [\App\Http\Controllers\ActiviteController::class, 'modifActPourPrat']);
    });

