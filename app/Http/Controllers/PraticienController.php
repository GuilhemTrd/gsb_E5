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

    /* Récupère tous les praticien avec l'ensembles des informations (Plusieurs lignes si plusieurs activites) */
    public function listePraticiens(){
        try{
            $unPrat = new ServicePraticien();
            $allInfos = $unPrat->getAllInfosPrat();
            return view('vues/listePraticiens',compact('allInfos'));
        } catch (MonException $e){
            $monErreur = $e->getMessage();
            return view('vues/pageErreur', compact('monErreur'));
        } catch (\Exception $ex){
            $monErreur = $ex->getMessage();
            return view('vues/pageErreur', compact('monErreur'));
        }
    }

    /* Récupère l'ensemble des types et des spécialités*/
    public function listeTypes_et_Spe(){
        try{
            $unType = new ServicePraticien();
            $mesTypes = $unType->getAllTypes();     /* Récupère l'ensemble des types*/
            $mesSpe = $unType->getAllSpe();    /* Récupère l'ensemble des spécialités*/
            $count = $unType->countPratID();    /* Vérifie l'existence*/
            return view('vues/formAjoutPrat',compact('mesTypes','mesSpe','count'));
        } catch (MonException $e){
            $monErreur = $e->getMessage();
            return view('vues/pageErreur', compact('monErreur'));
        } catch (\Exception $ex){
            $monErreur = $ex->getMessage();
            return view('vues/pageErreur', compact('monErreur'));
        }
    }

    /*Ajoute le praticien*/
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
            $unAjoutPratOne = new ServicePraticien();
            $unAjoutPratOne->ajoutPrat($nom,$prenom,$adresse,$cp,$ville,$coef,$typePrat,$idSpe,$diplome);
            return redirect('/listePraticiens');
        } catch (MonException $e){
            $monErreur = $e->getMessage();
            return view('vues/pageErreur',compact('monErreur'));
        } catch (\Exception $e){
            $monErreur = $e->getMessage();
            return view('vues/pageErreur',compact('monErreur'));
        }
    }

    /*Modifie le praticien*/
    public function modifPrat(){
        try {
            $adresse = Request::input('adresse');
            $cp = Request::input('cp');
            $ville = Request::input('ville');
            $coef = Request::input('coef');
            $typePrat = Request::input('typePrat');
            $idSpe = Request::input('spe');
            $idPrat = Request::input('id');

            $uneModifPrat = new ServicePraticien();
            $uneModifPrat->modifPrat($idPrat,$adresse,$cp,$ville,$coef,$typePrat,$idSpe);
            if ($idSpe != null){
                $modif = $uneModifPrat->getAllInfosPratID($idPrat);  /* Récupère un praticien avec l'ensemble des informations (Plusieurs lignes si plusieurs activites) */
                if ($modif[0]->lib_specialite == null){              /*Si le praticien n'a pas de spécialité*/
                    $uneModifPrat->insertPossPrat($idPrat,$idSpe);      /*Alors on insert la possesion de la spécialité*/
                }
                if ($modif[0]->lib_specialite != null){              /*Si le praticien a une spécialité*/
                    $uneModifPrat->modifPossPrat($idPrat,$idSpe);       /*Alors on modifie la possesion de la spécialité*/
                }
            }
            return redirect('/listePraticiens');
        } catch (MonException $e){
            $monErreur = $e->getMessage();
            return view('vues/pageErreur',compact('monErreur'));
        } catch (\Exception $e){
            $monErreur = $e->getMessage();
            return view('vues/pageErreur',compact('monErreur'));
        }
    }

    /*Supprime le praticien*/
    public function supprPrat($idPrat){
        try{
            $uneSuppr = new ServicePraticien();
            $allInfos = $uneSuppr->getAllInfosPratID($idPrat);   /* Récupère un praticien avec l'ensemble de informations (Plusieurs lignes si plusieurs activites) */
            foreach ($allInfos as $unPrat){
                $uneSpe = $unPrat->lib_specialite;
                $uneAct = $unPrat->id_activite_compl;
                $uneStat = $unPrat->id_medicament;
                break;
            }
            if($uneSpe != null)
            {
                $supprimer = $uneSuppr->supprSpe($idPrat); /* Supprime la specialité si elle existe */
            }
            if($uneAct != null)
            {
                $supprimer = $uneSuppr->supprAct($idPrat);  /* Supprime le(s) activité(s) si elle(s) existe(nt) */
            }
            if($uneStat != null)
            {
                $supprimer = $uneSuppr->supprStat($idPrat); /* Supprime les stats si elles existent */
            }
            $supprimer = $uneSuppr->supprPrat($idPrat);/* Supprime le praticien */
            return redirect('/listePraticiens');
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
            $prat = $unPrat->getAllInfosPratId($id);
            $mesTypes = $unPrat->getAllTypes();
            $mesSpe = $unPrat->getAllSpe();
            return view('vues/formModifPrat',compact('prat','mesTypes','mesSpe'));
        } catch (MonException $e){
            $monErreur = $e->getMessage();
            return view('vues/pageErreur', compact('monErreur'));
        } catch (\Exception $ex){
            $monErreur = $ex->getMessage();
            return view('vues/pageErreur', compact('monErreur'));
        }
    }
}
