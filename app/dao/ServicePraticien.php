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

    public function getAllPraticiensWPosseder()
    {
        try {
            $mesPrats = DB::table('praticien')
                ->Select()
                ->join('type_praticien', 'praticien.id_type_praticien', '=', 'type_praticien.id_type_praticien')
                ->join('posseder', 'praticien.id_praticien', '=', 'posseder.id_praticien')
                ->join('specialite', 'posseder.id_specialite', '=', 'specialite.id_specialite')
                ->get();
            return $mesPrats;
        } catch (QueryException $e) {
            throw new \Exception($e->getMessage(), 5);
        }
    }

    public function getAllPraticiens()
    {
        try {
            $mesPrats = DB::table('praticien')
                ->Select()
                ->join('type_praticien', 'praticien.id_type_praticien', '=', 'type_praticien.id_type_praticien')
                ->join('posseder', 'praticien.id_praticien', '=', 'posseder.id_praticien')
                ->join('specialite', 'posseder.id_specialite', '=', 'specialite.id_specialite')
                ->get();
            return $mesPrats;
        } catch (QueryException $e) {
            throw new \Exception($e->getMessage(), 5);
        }
    }

    public function getAllPraticiensNotIN()
    {
        try {
            $mesPrats = DB::table('praticien')
                ->Select()
                ->leftJoin('posseder', 'praticien.id_praticien', '=', 'posseder.id_praticien')
                ->leftJoin('type_praticien', 'praticien.id_type_praticien', '=', 'type_praticien.id_type_praticien')
                ->whereNull('posseder.id_praticien')
                ->get();
            return $mesPrats;
        } catch (QueryException $e) {
            throw new \Exception($e->getMessage(), 5);
        }
    }

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

    public function countPratID()
    {
        try {
            $count = DB::table('praticien')
                ->select('id_praticien')
                ->max('id_praticien');
            return $count;
        } catch (QueryException $e) {
            throw new \Exception($e->getMessage(), 5);
        }
    }

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

    public function ajoutPrat($idPratAfter,$nom,$prenom,$adresse,$cp,$ville,$coef,$typePrat,$idSpe,$diplome)
    {
        try {
            $ajout = DB::table('praticien')
                ->insert([
                    'id_praticien' => $idPratAfter ,'id_type_praticien' => $typePrat,'nom_praticien' => $nom,'prenom_praticien' => $prenom,
                    'adresse_praticien' => $adresse,'cp_praticien' => $cp,'ville_praticien' => $ville,
                    'coef_notoriete' => $coef,
                ]);
            $ajout = DB::table('posseder')
                ->insert([
                    'id_specialite' => $idSpe,'id_praticien' => $idPratAfter,'diplome' => $diplome
                ]);
            return $ajout;
        } catch (QueryException $e) {
            throw new \Exception($e->getMessage(), 5);
        }
    }
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


    public function supprPrat($id)
    {
        try {
            DB::table('posseder')->where('id_praticien', '=', $id)->delete();
            DB::table('praticien')->where('id_praticien', '=', $id)->delete();
            $response = array(
                'status_message' => 'Suppression réalisée'
            );
            return $response;
        } catch (QueryException $e) {
            throw new \Exception($e->getMessage(), 5);
        }
    }

    public function getPratByID($id)
    {
        try {
            $monPrat = DB::table('praticien')
                ->Select()
                ->join('type_praticien', 'praticien.id_type_praticien', '=', 'type_praticien.id_type_praticien')
                ->join('posseder', 'praticien.id_praticien', '=', 'posseder.id_praticien')
                ->join('specialite', 'posseder.id_specialite', '=', 'specialite.id_specialite')
                ->where('praticien.id_praticien', '=', $id)
                ->get();
            return $monPrat;
        } catch (QueryException $e) {
            throw new \Exception($e->getMessage(), 5);
        }
    }


}
