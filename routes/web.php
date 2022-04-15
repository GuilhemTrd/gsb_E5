<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/formLogin', [\App\Http\Controllers\PraticienController::class, 'getLogin']);
Route::post('/login', [\App\Http\Controllers\PraticienController::class, 'signIn']);
Route::get('/getLogout', [\App\Http\Controllers\PraticienController::class, 'signOut']);


    Route::group(['prefixe' => 'praticien','middleware' => 'connect'], function() {
        Route::get('/listePraticiens', [\App\Http\Controllers\PraticienController::class, 'listePraticiens']);
        Route::get('/ajoutPrat', [\App\Http\Controllers\PraticienController::class, 'listeTypes_et_Spe']);
        Route::post('/ajoutPratFin', [\App\Http\Controllers\PraticienController::class, 'AjoutPrat']);
        Route::get('/supprPrat/{idPrat}', [\App\Http\Controllers\PraticienController::class, 'supprPrat']);
        Route::get('/modifPrat/{id}', [\App\Http\Controllers\PraticienController::class, 'pratParID']);
        Route::post('/modifPratFin', [\App\Http\Controllers\PraticienController::class, 'modifPrat']);
    });

    Route::group(['prefixe' => 'act','middleware' => 'connect'], function() {
        Route::get('/infosAct/{id}', [\App\Http\Controllers\ActiviteController::class, 'listeActivites']);
        Route::get('/ajoutAct/{id}', [\App\Http\Controllers\ActiviteController::class, 'goAjoutAct']);
        Route::post('/ajoutFin', [\App\Http\Controllers\ActiviteController::class, 'AjoutActPourPrat']);
        Route::get('/supprAct/{idAct}/{idPrat}', [\App\Http\Controllers\ActiviteController::class, 'supprActForPrat']);
        Route::get('/modifAct/{idAct}/{idPrat}/{spe}', [\App\Http\Controllers\ActiviteController::class, 'goModifActWInfos']);
        Route::post('/modifFin', [\App\Http\Controllers\ActiviteController::class, 'modifActPourPrat']);
    });

