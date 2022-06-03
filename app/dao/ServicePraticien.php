<?php

namespace App\dao;

use App\Exceptions\MonException;
use GuzzleHttp\Promise\Is;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Session;

class ServicePraticien
{
    public function login($login,$pwd) {
        $connected = false;
        try {
            $visiteur = DB::table('visiteur')
                ->select()
                ->where('login_visiteur','=',$login)
                ->first();
            if ($visiteur) {
                if ($visiteur->pwd_visiteur == $pwd) {
                    Session::put('id',$visiteur->id_visiteur);
                    Session::put('type', $visiteur->type_visiteur);
                    if ($visiteur->type_visiteur == 'A'){
                        $connected = "connecte";
                    }
                    if ($visiteur->type_visiteur != 'A'){
                        $connected = "nAdmin";
                    }
                }
                else{
                    $connected = "nMdp";
                }
            }
            else{
                $connected = "nLogin";
            }
        } catch ( QueryException $e){
            throw new \Exception($e->getMessage(), 5);

        }
        return $connected;
    }

    public function logout() {
        Session::put('id',0);
    }

    /* Récupère un praticien avec l'ensemble des informations (Plusieurs lignes si plusieurs activites) */
    public function getAllInfosPratID($idPrat)
    {
        try {
            $mesPrats = DB::table("praticien")
                ->select( "praticien.id_praticien","nom_praticien", "prenom_praticien","adresse_praticien","cp_praticien","ville_praticien", "coef_notoriete","praticien.id_type_praticien","lib_type_praticien","specialite.id_specialite" ,"lib_specialite","inviter.id_activite_compl","id_medicament")
                ->leftJoin("inviter", function($join){
                    $join->on("inviter.id_praticien", "=", "praticien.id_praticien");
                })
                ->leftJoin("activite_compl", function($join){
                    $join->on("activite_compl.id_activite_compl", "=", "inviter.id_activite_compl");
                })
                ->leftJoin("posseder", function($join){
                    $join->on("posseder.id_praticien", "=", "praticien.id_praticien");
                })
                ->leftJoin("specialite", function($join){
                    $join->on("specialite.id_specialite", "=", "posseder.id_specialite");
                })
                ->leftJoin("type_praticien", function($join){
                    $join->on("type_praticien.id_type_praticien", "=", "praticien.id_type_praticien");
                })
                ->leftJoin("stats_prescriptions", function($join){
                    $join->on("stats_prescriptions.id_praticien", "=", "praticien.id_praticien");
                })
                ->where ('praticien.id_praticien',$idPrat)
                ->get();
            return $mesPrats;
        } catch (QueryException $e) {
            throw new \Exception($e->getMessage(), 5);
        }
    }

    /* Récupère tous les praticien avec l'ensembles des informations (Plusieurs lignes si plusieurs activites) */
    public function getAllInfosPrat()
    {
        try {
            $mesPrats = DB::table("praticien")
                ->select( "praticien.id_praticien","nom_praticien", "prenom_praticien", "lib_type_praticien", "lib_specialite","inviter.id_activite_compl")
                ->distinct("praticien.id_praticien")
                    ->leftJoin("inviter", function($join){
                        $join->on("inviter.id_praticien", "=", "praticien.id_praticien");
                    })
                    ->leftJoin("activite_compl", function($join){
                        $join->on("activite_compl.id_activite_compl", "=", "inviter.id_activite_compl");
                    })
                    ->leftJoin("posseder", function($join){
                        $join->on("posseder.id_praticien", "=", "praticien.id_praticien");
                    })
                    ->leftJoin("specialite", function($join){
                        $join->on("specialite.id_specialite", "=", "posseder.id_specialite");
                    })
                    ->leftJoin("type_praticien", function($join){
                        $join->on("type_praticien.id_type_praticien", "=", "praticien.id_type_praticien");
                    })
                    ->leftJoin("stats_prescriptions", function($join){
                        $join->on("stats_prescriptions.id_praticien", "=", "praticien.id_praticien");
                    })
                    ->orderBy('nom_praticien')
                    ->get();
            return $mesPrats;
        } catch (QueryException $e) {
            throw new \Exception($e->getMessage(), 5);
        }
    }

    /* Récupère l'ensemble des spécialités*/
    public function getAllSpe()
    {
        try {
            $mesSpe = DB::table('specialite')
                ->Select()
                ->get();
            return $mesSpe;
        } catch (QueryException $e) {
            throw new \Exception($e->getMessage(), 5);
        }
    }

    /*Vérifie si le praticien existe*/
    public function countPratID()
    {
        try {
            $count = DB::table('praticien')
                ->select('id_praticien')
                ->count('id_praticien');
            return $count;
        } catch (QueryException $e) {
            throw new \Exception($e->getMessage(), 5);
        }
    }

    /* Récupère l'ensemble des types*/
    public function getAllTypes()
    {
        try {
            $mesTypes = DB::table('type_praticien')
                ->Select()
                ->get();
            return $mesTypes;
        } catch (QueryException $e) {
            throw new \Exception($e->getMessage(), 5);
        }
    }

    /*Ajoute le praticien*/
    public function ajoutPrat($nom,$prenom,$adresse,$cp,$ville,$coef,$typePrat,$idSpe,$diplome)
    {
        try {
            $id = DB::table('praticien')
                    ->insertGetId([
                    'id_type_praticien' => $typePrat,'nom_praticien' => $nom,'prenom_praticien' => $prenom,
                    'adresse_praticien' => $adresse,'cp_praticien' => $cp,'ville_praticien' => $ville,
                    'coef_notoriete' => $coef,
                ]);
            $ajout = DB::table('posseder')
                ->insert([
                    'id_specialite' => $idSpe,'id_praticien' => $id,'diplome' => $diplome
                ]);
            return $ajout;
        } catch (QueryException $e) {
            throw new \Exception($e->getMessage(), 5);
        }
    }

    /*Ajoute la spécialisation du praticien*/
    public function ajoutSpePrat($idPrat,$idSpe,$diplome)
    {
        try {
            $ajout = $ajout = DB::table('posseder')
                ->insert([
                    'id_specialite' => $idSpe,'id_praticien' => $idPrat,'diplome' => $diplome
                ]);
            return $ajout;
        } catch (QueryException $e) {
            throw new \Exception($e->getMessage(), 5);
        }
    }

    /*Modifie le praticien*/
    public function modifPrat($idPrat,$adresse,$cp,$ville,$coef,$typePrat,$idSpe)
    {
        try {
            $modif = DB::table('praticien')
                ->where ('praticien.id_praticien',$idPrat)
                ->update ([
                    'adresse_praticien' => $adresse,
                    'cp_praticien' => $cp,
                    'ville_praticien' => $ville,
                    'coef_notoriete' => $coef,
                    'id_type_praticien' => $typePrat,
                ]);
            return $modif;
        } catch (QueryException $e) {
            throw new \Exception($e->getMessage(), 5);
        }
    }

    /*Ajout de la spécialité à un praticien*/
    public function insertPossPrat($idPrat,$idSpe)
    {
        try {
            $modif = DB::table('posseder')
                ->insert ([
                    'id_specialite' => $idSpe,
                    'id_praticien' => $idPrat,
                ]);
            return $modif;
        } catch (QueryException $e) {
            throw new \Exception($e->getMessage(), 5);
        }
    }

    /*Modification de la spécialité du praticien*/
    public function modifPossPrat($idPrat,$idSpe)
    {
        try {
            $modif = DB::table('posseder')
                ->where ('posseder.id_praticien',$idPrat)
                ->update ([
                    'id_specialite' => $idSpe,
                ]);
            return $modif;
        } catch (QueryException $e) {
            throw new \Exception($e->getMessage(), 5);
        }
    }

    /* Supprime le(s) activité(s) */
    public function supprAct($idPrat)
    {
        try {
            DB::table('inviter')->where('id_praticien', '=', $idPrat)->delete();
            $response = array(
                'status_message' => 'Suppression réalisée'
            );
            return $response;
        } catch (QueryException $e) {
            throw new \Exception($e->getMessage(), 5);
        }
    }

    /* Supprime la specialité */
    public function supprSpe($idPrat)
    {
        try {
            DB::table('posseder')->where('id_praticien', '=', $idPrat)->delete();
            $response = array(
                'status_message' => 'Suppression réalisée'
            );
            return $response;
        } catch (QueryException $e) {
            throw new \Exception($e->getMessage(), 5);
        }
    }

    /* Supprime les stats */
    public function supprStat($idPrat)
    {
        try {
            DB::table('stats_prescriptions')->where('id_praticien', '=', $idPrat)->delete();
            $response = array(
                'status_message' => 'Suppression réalisée'
            );
            return $response;
        } catch (QueryException $e) {
            throw new \Exception($e->getMessage(), 5);
        }
    }

    /* Supprime le praticien */
    public function supprPrat($idPrat)
    {
        try {
            DB::table('praticien')->where('id_praticien', '=', $idPrat)->delete();
            $response = array(
                'status_message' => 'Suppression réalisée'
            );
            return $response;
        } catch (QueryException $e) {
            throw new \Exception($e->getMessage(), 5);
        }
    }




}
