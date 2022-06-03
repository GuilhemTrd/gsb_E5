<?php

namespace App\dao;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class ServiceActivite
{
    /* Récupère l'ensemble des activités*/
    public function getAllActivite(){
        try{
            $mesActs = DB::table('activite_compl')
                ->Select()
                ->get();
            return $mesActs;
        } catch (QueryException $e){
            throw new \Exception($e->getMessage(),5);
        }
    }

    /* Récupère l'ensemble des activités d'un praticien*/
    public function getActsByID($id){
        try{
            $mesActs = DB::table('inviter')
                ->Select()
                ->join('activite_compl', 'inviter.id_activite_compl', '=', 'activite_compl.id_activite_compl')
                ->join('praticien', 'inviter.id_praticien', '=', 'praticien.id_praticien')
                ->where('inviter.id_praticien', '=', $id)
                ->get();
            return $mesActs;
        } catch (QueryException $e){
            throw new \Exception($e->getMessage(),5);
        }
    }

    /* Compte le nombre d'activités d'un praticien*/
    public function countActForID($id){
        try{
            $mesActs = DB::table('inviter')
                ->Select()
                ->where('inviter.id_praticien', '=', $id)
                ->count();
            return $mesActs;
        } catch (QueryException $e){
            throw new \Exception($e->getMessage(),5);
        }
    }

    /* Ajoute une activité à un informaticien */
    public function addActForPrat($idAct,$idPrat,$spe)
    {
        try {
            $ajout = DB::table('inviter')
                ->insert([
                    'id_activite_compl' => $idAct ,'id_praticien' => $idPrat,'specialiste' => $spe
                ]);
            return $ajout;
        } catch (QueryException $e) {
            throw new \Exception($e->getMessage(), 5);
        }
    }

    /*Supprime l'activite d'un praticien*/
    public function supprActPrat($idAct,$idPrat)
    {
        try {
            DB::table('inviter')->where('id_praticien', '=', $idPrat)->where('id_activite_compl', '=', $idAct)->delete();
            $response = array(
                'status_message' => 'Suppression réalisée'
            );
            return $response;
        } catch (QueryException $e) {
            throw new \Exception($e->getMessage(), 5);
        }
    }

    /* Modifie l'activité d'un praticien */
    public function modifAct($oldIdAct,$oldIdPrat,$idAct,$idPrat,$spe)
    {
        try {
            DB::table('inviter')
                ->where('id_praticien', '=', $oldIdPrat)
                ->where('id_activite_compl', '=', $oldIdAct)
                ->update([
                    'id_activite_compl' => $idAct , 'specialiste' =>$spe
                ]);
            $response = array(
                'status_message' => 'Modification réalisée'
            );
            return $response;
        } catch (QueryException $e) {
            throw new \Exception($e->getMessage(), 5);
        }
    }
}
