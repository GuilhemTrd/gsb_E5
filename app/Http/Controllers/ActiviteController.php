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
            $lesActsPrat = $uneAct->getActsByID($id);
            $nbAct = $uneAct->countActForID($id);
            $unPrat = $uneAct->getActsByID($id);
            $unPrat = new ServicePraticien();
            $unPrat = $unPrat->getAllInfosPratID($id);
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
            $mesActs = $uneActParPrat->getAllActivite();
            $unPrat = new ServicePraticien();
            $unPrat = $unPrat->getAllInfosPratID($id);
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
            $unAjout = new ServiceActivite();
            $mesActs = $unAjout->getAllActivite();
            $monAjout = $unAjout->addActForPrat($idAct,$idPrat,$spe);
            $lesActsPrat = $unAjout->getActsByID($idPrat);
            $nbAct = $unAjout->countActForID($idPrat);
            $unPrat = new ServicePraticien();
            $unPrat = $unPrat->getAllInfosPratID($idPrat);
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
            $mesActs = $uneSuppr->getAllActivite();
            $lesActsPrat = $uneSuppr->getActsByID($idPrat);
            $nbAct = $uneSuppr->countActForID($idPrat);
            $unPrat = new ServicePraticien();
            $unPrat = $unPrat->getAllInfosPratID($idPrat);
            return view('vues/infosActivites',compact('mesActs','lesActsPrat','unPrat','nbAct'));
        } catch (MonException $e){
            $monErreur = $e->getMessage();
            return view('vues/pageErreur', compact('monErreur'));
        } catch (\Exception $ex){
            $monErreur = $ex->getMessage();
            return view('vues/pageErreur', compact('monErreur'));
        }
    }

    public function goModifActWInfos($idAct,$idPrat,$spe){
        try{

            $uneActParPrat = new ServiceActivite();
            $lesActsPrat = $uneActParPrat->getActsByID($idPrat);
            $mesActs = $uneActParPrat->getAllActivite();
            $unPrat = new ServicePraticien();
            $unPrat = $unPrat->getAllInfosPratID($idPrat);
            return view('vues/formModifAct',compact('mesActs','idAct','idPrat','spe','lesActsPrat','unPrat'));
        } catch (MonException $e){
            $monErreur = $e->getMessage();
            return view('vues/pageErreur', compact('monErreur'));
        } catch (\Exception $ex){
            $monErreur = $ex->getMessage();
            return view('vues/pageErreur', compact('monErreur'));
        }
    }

    public function modifActPourPrat(){
        try{
            $idPrat = Request::input('idPrat');
            $idAct = Request::input('idAct');
            $spe = Request::input('spe');
            $oldIdPrat = Request::input('oldIdPrat');
            $oldIdAct = Request::input('oldIdAct');
            $uneSuppr = new ServiceActivite();
            $maModif = $uneSuppr->modifAct($oldIdPrat,$oldIdAct,$idAct,$idPrat,$spe);
            $mesActs = $uneSuppr->getAllActivite();
            $lesActsPrat = $uneSuppr->getActsByID($idPrat);
            $nbAct = $uneSuppr->countActForID($idPrat);
            $unPrat = new ServicePraticien();
            $unPrat = $unPrat->getAllInfosPratID($idPrat);
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
