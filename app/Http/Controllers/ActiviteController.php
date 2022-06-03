<?php

namespace App\Http\Controllers;

use App\dao\ServiceActivite;
use App\dao\ServicePraticien;
use Request;
use Session;

class ActiviteController
{
    /* Récupère les activités disponible, les activités du praticien, le nombre d'activité et les informations du praticien */
    public function listeActivites($id){
        try{
            $uneAct = new ServiceActivite();
            $mesActs = $uneAct->getAllActivite(); /* Récupère l'ensemble des activités*/
            $lesActsPrat = $uneAct->getActsByID($id); /* Récupère l'ensemble des activités d'un praticien*/
            $nbAct = $uneAct->countActForID($id); /* Compte le nombre d'activités d'un praticien*/
            $unPrat = new ServicePraticien();
            $unPrat = $unPrat->getAllInfosPratID($id); /* Récupère un praticien avec l'ensemble de informations (Plusieurs lignes si plusieurs activites) */
            return view('vues/infosActivites',compact('mesActs','lesActsPrat','unPrat','nbAct'));
        } catch (MonException $e){
            $monErreur = $e->getMessage();
            return view('vues/pageErreur', compact('monErreur'));
        } catch (\Exception $ex){
            $monErreur = $ex->getMessage();
            return view('vues/pageErreur', compact('monErreur'));
        }
    }

    /* Permet d'aller sur la page pour ajouter une activité */
    public function goAjoutAct($id){
        try{
            $uneActParPrat = new ServiceActivite();
            $lesActsPrat = $uneActParPrat->getActsByID($id); /* Récupère l'ensemble des activités d'un praticien*/
            $mesActs = $uneActParPrat->getAllActivite(); /* Récupère l'ensemble des activités*/
            $unPrat = new ServicePraticien();
            $unPrat = $unPrat->getAllInfosPratID($id); /* Récupère un praticien avec l'ensemble de informations (Plusieurs lignes si plusieurs activites) */
            return view('vues/formAjoutAct',compact('mesActs','lesActsPrat','unPrat'));
        } catch (MonException $e){
            $monErreur = $e->getMessage();
            return view('vues/pageErreur', compact('monErreur'));
        } catch (\Exception $ex){
            $monErreur = $ex->getMessage();
            return view('vues/pageErreur', compact('monErreur'));
        }
    }

    /* Ajoute l'activite d'un praticien */
    public function AjoutActPourPrat(){
        try{
            $idPrat = Request::input('idPrat');
            $idAct = Request::input('idAct');
            $spe = Request::input('spe');
            $unAjout = new ServiceActivite();
            $monAjout = $unAjout->addActForPrat($idAct,$idPrat,$spe);   /* Ajoute l'activite d'un praticien */
            $mesActs = $unAjout->getAllActivite();                      /* Récupère l'ensemble des activités*/
            $lesActsPrat = $unAjout->getActsByID($idPrat);              /* Récupère l'ensemble des activités d'un praticien*/
            $nbAct = $unAjout->countActForID($idPrat);                  /* Compte le nombre d'activités d'un praticien*/
            $unPrat = new ServicePraticien();
            $unPrat = $unPrat->getAllInfosPratID($idPrat);              /* Récupère un praticien avec l'ensemble de informations (Plusieurs lignes si plusieurs activites) */
            return view('vues/infosActivites',compact('mesActs','lesActsPrat','unPrat','nbAct'));
        } catch (MonException $e){
            $monErreur = $e->getMessage();
            return view('vues/pageErreur', compact('monErreur'));
        } catch (\Exception $ex){
            $monErreur = $ex->getMessage();
            return view('vues/pageErreur', compact('monErreur'));
        }
    }

    /*Supprime l'activite d'un praticien*/
    public function supprActForPrat($idAct,$idPrat){
        try{
            $uneSuppr = new ServiceActivite();
            $maSuppr = $uneSuppr->supprActPrat($idAct,$idPrat); /* Supprime l'activite d'un praticien */
            $mesActs = $uneSuppr->getAllActivite();             /* Récupère l'ensemble des activités */
            $lesActsPrat = $uneSuppr->getActsByID($idPrat);     /* Récupère l'ensemble des activités d'un praticien */
            $nbAct = $uneSuppr->countActForID($idPrat);         /* Compte le nombre d'activités d'un praticien */
            $unPrat = new ServicePraticien();
            $unPrat = $unPrat->getAllInfosPratID($idPrat); /* Récupère un praticien avec l'ensemble de informations (Plusieurs lignes si plusieurs activites) */
            return view('vues/infosActivites',compact('mesActs','lesActsPrat','unPrat','nbAct'));
        } catch (MonException $e){
            $monErreur = $e->getMessage();
            return view('vues/pageErreur', compact('monErreur'));
        } catch (\Exception $ex){
            $monErreur = $ex->getMessage();
            return view('vues/pageErreur', compact('monErreur'));
        }
    }

    /* Permet d'aller sur la page modifier une activité */
    public function goModifAct($idAct,$idPrat,$spe){
        try{

            $uneActParPrat = new ServiceActivite();
            $lesActsPrat = $uneActParPrat->getActsByID($idPrat);    /* Récupère l'ensemble des activités d'un praticien */
            $mesActs = $uneActParPrat->getAllActivite();            /* Récupère l'ensemble des activités */
            $unPrat = new ServicePraticien();
            $unPrat = $unPrat->getAllInfosPratID($idPrat);          /* Récupère un praticien avec l'ensemble de informations (Plusieurs lignes si plusieurs activites) */
            return view('vues/formModifAct',compact('mesActs','idAct','idPrat','spe','lesActsPrat','unPrat'));
        } catch (MonException $e){
            $monErreur = $e->getMessage();
            return view('vues/pageErreur', compact('monErreur'));
        } catch (\Exception $ex){
            $monErreur = $ex->getMessage();
            return view('vues/pageErreur', compact('monErreur'));
        }
    }

    /* Modifie l'activite d'un praticien */
    public function modifActPourPrat(){
        try{
            $idPrat = Request::input('idPrat');
            $idAct = Request::input('idAct');
            $spe = Request::input('spe');
            $oldIdPrat = Request::input('oldIdPrat');
            $oldIdAct = Request::input('oldIdAct');
            $uneSuppr = new ServiceActivite();
            $maModif = $uneSuppr->modifAct($oldIdPrat,$oldIdAct,$idAct,$idPrat,$spe);     /* Modifie l'activite d'un praticien */
            $mesActs = $uneSuppr->getAllActivite();                                       /* Récupère l'ensemble des activités */
            $lesActsPrat = $uneSuppr->getActsByID($idPrat);                               /* Récupère l'ensemble des activités d'un praticien */
            $nbAct = $uneSuppr->countActForID($idPrat);                                   /* Compte le nombre d'activités d'un praticien */
            $unPrat = new ServicePraticien();
            $unPrat = $unPrat->getAllInfosPratID($idPrat);      /* Récupère un praticien avec l'ensemble de informations (Plusieurs lignes si plusieurs activites) */
            return view('vues/infosActivites',compact('mesActs','lesActsPrat','unPrat','nbAct'));
        } catch (MonException $e){
            $monErreur = $e->getMessage();
            return view('vues/pageErreur', compact('monErreur'));
        } catch (\Exception $ex){
            $monErreur = $ex->getMessage();
            return view('vues/pageErreur', compact('monErreur'));
        }
    }
}
