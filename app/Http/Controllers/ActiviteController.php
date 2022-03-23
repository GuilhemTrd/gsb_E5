<?php

namespace App\Http\Controllers;

use App\dao\ServiceActivite;
use App\dao\ServicePraticien;
use Request;
use Session;

class ActiviteController
{
    public function listeActivites($id){
        try{
            $uneAct = new ServiceActivite();
            $mesActs = $uneAct->getAllActivite();
            $uneActParPrat = new ServiceActivite();
            $lesActsPrat = $uneActParPrat->getActsByID($id);
            $unPrat = new ServicePraticien();
            $unPrat = $unPrat->getPratByID($id);
            $count = new ServiceActivite();
            $nbAct = $count->countActForID($id);
            return view('vues/infosActivites',compact('mesActs','lesActsPrat','unPrat','nbAct'));
        } catch (MonException $e){
            $monErreur = $e->getMessage();
            return view('vues/pageErreur', compact('monErreur'));
        } catch (\Exception $ex){
            $monErreur = $ex->getMessage();
            return view('vues/pageErreur', compact('monErreur'));
        }
    }

    public function goAjoutAct($id){
        try{
            $uneActParPrat = new ServiceActivite();
            $lesActsPrat = $uneActParPrat->getActsByID($id);
            $uneAct = new ServiceActivite();
            $mesActs = $uneAct->getAllActivite();
            $actAlready = new ServiceActivite();
            $unPrat = new ServicePraticien();
            $unPrat = $unPrat->getPratByID($id);
            return view('vues/formAjoutAct',compact('mesActs','lesActsPrat','unPrat'));
        } catch (MonException $e){
            $monErreur = $e->getMessage();
            return view('vues/pageErreur', compact('monErreur'));
        } catch (\Exception $ex){
            $monErreur = $ex->getMessage();
            return view('vues/pageErreur', compact('monErreur'));
        }
    }

    public function AjoutActPourPrat(){
        try{
            $idPrat = Request::input('idPrat');
            $idAct = Request::input('idAct');
            $spe = Request::input('spe');
            $uneAct = new ServiceActivite();
            $mesActs = $uneAct->getAllActivite();
            $unAjout= new ServiceActivite();
            $monAjout = $unAjout->addActForPrat($idAct,$idPrat,$spe);
            $uneActParPrat = new ServiceActivite();
            $lesActsPrat = $uneActParPrat->getActsByID($idPrat);
            $unPrat = new ServicePraticien();
            $unPrat = $unPrat->getPratByID($idPrat);
            $count = new ServiceActivite();
            $nbAct = $count->countActForID($idPrat);

            return view('vues/infosActivites',compact('mesActs','lesActsPrat','unPrat','nbAct'));
        } catch (MonException $e){
            $monErreur = $e->getMessage();
            return view('vues/pageErreur', compact('monErreur'));
        } catch (\Exception $ex){
            $monErreur = $ex->getMessage();
            return view('vues/pageErreur', compact('monErreur'));
        }
    }
    public function supprActForPrat($idAct,$idPrat){
    try{
        $uneSuppr = new ServiceActivite();
        $maSuppr = $uneSuppr->supprActPrat($idAct,$idPrat);
        $uneAct = new ServiceActivite();
        $mesActs = $uneAct->getAllActivite();
        $uneActParPrat = new ServiceActivite();
        $lesActsPrat = $uneActParPrat->getActsByID($idPrat);
        $unPrat = new ServicePraticien();
        $unPrat = $unPrat->getPratByID($idPrat);
        $count = new ServiceActivite();
        $nbAct = $count->countActForID($idPrat);

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
