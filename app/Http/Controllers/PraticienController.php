<?php

namespace App\Http\Controllers;
use App\dao\ServicePraticien;
use Request;
use Session;

use Illuminate\Routing\Controller as BaseController;

class PraticienController
{
    public function getLogin() {
        try {
            $erreur = "";
            return view ('vues/formLogin',compact('erreur'));
        } catch (MonException $e) {
            $erreur = $e->getMessage();
            return view('vues/formLogin', compact('erreur'));
        } catch (Exception $e){
            $erreur = $e->getMessage();
            return view('vues/formLogin', compact('erreur'));
        }
    }

    public function signIn() {
        try {
            $login = Request::input('login');
            $pwd = Request::input('pwd');
            $unPrat = new ServicePraticien();
            $connected = $unPrat->login($login, $pwd);
            if ($connected == 'connecte'){
                return view ('home');
            }
            if ($connected == 'nLogin'){
                $erreur = "Login inconnu.";
                return view('vues/formLogin',compact('erreur'));
            }
            if ($connected == 'nMdp'){
                $erreur = "Mot de passe inconnu.";
                return view('vues/formLogin',compact('erreur'));
            }
            if ($connected == 'nAdmin'){
                $erreur = "Vous n'êtes pas administrateur.";
                return view('vues/formLogin',compact('erreur'));
            }
        } catch (MonException $e){
            $erreur = $e->getMessage();
            return view('vues/formLogin', compact('erreur'));
        } catch (Exception $e) {
            $erreur =$e->getMessage();
            return view('vues/formLogin',compact('erreur'));
        }
    }

    public function signOut () {
        $unPrat = new ServicePraticien();
        $unPrat->logout();
        return view('home');
    }

    public function listePraticiens(){
        try{
            $unPrat = new ServicePraticien();
            $mesPratsPoss = $unPrat->getAllPraticiensWPosseder();
            $unPrat = new ServicePraticien();
            $mesPrats = $unPrat->getAllPraticiensNotIN();
            return view('vues/listePraticiens',compact('mesPrats','mesPratsPoss'));
        } catch (MonException $e){
            $monErreur = $e->getMessage();
            return view('vues/pageErreur', compact('monErreur'));
        } catch (\Exception $ex){
            $monErreur = $ex->getMessage();
            return view('vues/pageErreur', compact('monErreur'));
        }
    }

    public function listeTypes_et_Spe(){
        try{
            $unType = new ServicePraticien();
            $mesTypes = $unType->getAllTypes();
            $mesSpe = $unType->getAllSpe();
            $count = $unType->countPratID();
            return view('vues/formAjoutPrat',compact('mesTypes','mesSpe','count'));
        } catch (MonException $e){
            $monErreur = $e->getMessage();
            return view('vues/pageErreur', compact('monErreur'));
        } catch (\Exception $ex){
            $monErreur = $ex->getMessage();
            return view('vues/pageErreur', compact('monErreur'));
        }
    }

    public function ajoutPrat(){
        try {
            $nom = Request::input('nom');
            $prenom = Request::input('prenom');
            $adresse = Request::input('adresse');
            $cp = Request::input('cp');
            $ville = Request::input('ville');
            $coef = Request::input('coef');
            $typePrat = Request::input('typePrat');
            $idSpe = Request::input('spe');
            $diplome = Request::input('diplome');
            $idPratBefore = Request::input('count');
            $idPratAfter = $idPratBefore + 1;
            $unAjoutPratOne = new ServicePraticien();
            $unAjoutPratOne->ajoutPrat($idPratAfter,$nom,$prenom,$adresse,$cp,$ville,$coef,$typePrat,$idSpe,$diplome);
            $unPrat = new ServicePraticien();
            $mesPratsPoss = $unPrat->getAllPraticiensWPosseder();
            $unPrat = new ServicePraticien();
            $mesPrats = $unPrat->getAllPraticiensNotIN();
            return view('vues/listePraticiens',compact('mesPrats','mesPratsPoss'));
        } catch (MonException $e){
            $monErreur = $e->getMessage();
            return view('vues/pageErreur',compact('monErreur'));
        } catch (\Exception $e){
            $monErreur = $e->getMessage();
            return view('vues/pageErreur',compact('monErreur'));
        }
    }
    public function modifPrat(){
        try {
            $adresse = Request::input('adresse');
            $cp = Request::input('cp');
            $ville = Request::input('ville');
            $coef = Request::input('coef');
            $typePrat = Request::input('typePrat');
            $idSpe = Request::input('spe');
            $idPrat = Request::input('id');
            $unAjoutPratOne = new ServicePraticien();
            $unAjoutPratOne->modifPrat($idPrat,$adresse,$cp,$ville,$coef,$typePrat,$idSpe);
            $unPrat = new ServicePraticien();
            $mesPratsPoss = $unPrat->getAllPraticiensWPosseder();
            $unPrat = new ServicePraticien();
            $mesPrats = $unPrat->getAllPraticiensNotIN();
            return view('vues/listePraticiens',compact('mesPrats','mesPratsPoss'));
        } catch (MonException $e){
            $monErreur = $e->getMessage();
            return view('vues/pageErreur',compact('monErreur'));
        } catch (\Exception $e){
            $monErreur = $e->getMessage();
            return view('vues/pageErreur',compact('monErreur'));
        }
    }

    public function supprPrat($id){
        try{
            $uneSuppr = new ServicePraticien();
            $supprimer = $uneSuppr->supprPrat($id);
            $unPrat = new ServicePraticien();
            $mesPrats = $unPrat->getAllPraticiens();
            $unPrat = new ServicePraticien();
            $mesPratsPoss = $unPrat->getAllPraticiensWPosseder();
            return view('vues/listePraticiens',compact('supprimer','mesPrats','mesPratsPoss'));
        } catch (MonException $e){
            $monErreur = $e->getMessage();
            return view('vues/pageErreur', compact('monErreur'));
        } catch (\Exception $ex){
            $monErreur = $ex->getMessage();
            return view('vues/pageErreur', compact('monErreur'));
        }
    }
    public function pratParID($id){
        try{
            $unPrat = new ServicePraticien();
            $prat = $unPrat->getPratByID($id);
            $id = new ServicePraticien();
            $count = $id->countPratID();
            $unType = new ServicePraticien();
            $mesTypes = $unType->getAllTypes();
            $mesSpe = $unType->getAllSpe();
            return view('vues/formModifPrat',compact('prat','count','mesTypes','mesSpe'));
        } catch (MonException $e){
            $monErreur = $e->getMessage();
            return view('vues/pageErreur', compact('monErreur'));
        } catch (\Exception $ex){
            $monErreur = $ex->getMessage();
            return view('vues/pageErreur', compact('monErreur'));
        }
    }
}
