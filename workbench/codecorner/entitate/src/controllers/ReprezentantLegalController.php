<?php namespace Codecorner\Entitate\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class ReprezentantLegalController extends \BaseController
{
    public function getReprezentantiEntitate($id_entitate, $entitate) {
        $reprezentanti_all = array();
        $reprezentanti_entitate = array();

        $sql = "SELECT
            rle.id,
            rl.id AS id_reprezentant,
            rl.nume,
            rl.cnp     
            FROM reprezentant_legal_entitate rle
            INNER JOIN reprezentant_legal rl ON rl.id = rle.id_reprezentant_legal AND rl.logical_delete = 0
            WHERE rle.logical_delete = 0
            AND rle.id_entitate = :id_entitate";
        $reprezentanti_entitate = DB::select($sql, array('id_entitate' => $id_entitate));               

        $sql = "SELECT
            rl.id,
            rl.nume,
            rl.cnp     
            FROM reprezentant_legal rl
            WHERE rl.logical_delete = 0
            AND rl.id NOT IN (SELECT id_reprezentant_legal FROM reprezentant_legal_entitate WHERE logical_delete = 0 AND id_entitate = :id_entitate)";
        $reprezentanti_all = DB::select($sql, array('id_entitate' => $id_entitate));               
        
        return View::make("entitate::reprezentant_legal.asociaza_entitate", compact('reprezentanti_all', 'reprezentanti_entitate', 'id_entitate', 'entitate'));
    }
    
    public function getReprezentantiOrganizatie() {
        $reprezentanti = array();
        $sql = "SELECT 
            rl.id,
            rl.nume,
            rl.cnp
            FROM reprezentant_legal rl
            WHERE rl.logical_delete = 0";
        if (\Entrust::can('administrare_platforma'))
        {
            $reprezentanti = DB::select($sql);
        }
        else 
        {
            $sql .= " AND id_organizatie = :id_organizatie";
            $reprezentanti = DB::select($sql, array('id_organizatie' => isset(self::organizatie()[0])?self::organizatie()[0]->id_organizatie:-1));
        }            
        return View::make('entitate::reprezentant_legal.list')->with('reprezentanti', $reprezentanti);
    }   
    
    public function getAddReprezentantOrganizatie() {        
        return View::make('entitate::reprezentant_legal.add');
    }
    
    public function getAddReprezentantEntitate($id_entitate, $denumire) {
        return View::make('entitate::reprezentant_legal.add')->with('id_entitate', $id_entitate)->with('denumire', $denumire);
    }
    
    public function postAddReprezentant() {
        $rules = array('nume' => 'required', 'cnp' => 'required');
        $errors = array('required' => 'Campul este obligatoriu.');
        
        $validator = Validator::make(Input::all(), $rules, $errors);
        if ($validator->fails()) {
            return Redirect::back()->with('message', 'Eroare validare formular!')->withErrors($validator)->withInput()->with($errors);
        } 
        else {
            try {
                DB::table('reprezentant_legal')
                    ->insertGetId(array(
                        'nume' => Input::get('nume'), 
                        'cnp' => Input::get('cnp'),
                        'id_organizatie' => isset(self::organizatie()[0])?self::organizatie()[0]->id_organizatie:-1));
            }
            catch(Exception $e) {
                return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
            }
            return Redirect::back()->with('message', 'Salvare realizata cu succes!')->withInput();
        }
    }
    
    public function getEditReprezentant($id_reprezentant) {
        $reprezentant = DB::select("SELECT 
            id,
            nume,
            cnp
            FROM reprezentant_legal                       
            WHERE logical_delete = 0
            AND id = :id_reprezentant", array('id_reprezentant' => $id_reprezentant));
        return View::make('entitate::reprezentant_legal.edit')->with('reprezentant', $reprezentant[0]);
    }
    
    public function postEditReprezentant($id_reprezentant) 
    {
        $rules = array('nume' => 'required', 'cnp' => 'required');
        $errors = array('required' => 'Campul este obligatoriu.');
        
        $validator = Validator::make(Input::all(), $rules, $errors);
        if ($validator->fails()) {
            return Redirect::back()->with('message', 'Eroare validare formular!')->withErrors($validator)->withInput();
        }
        try {
            DB::table('reprezentant_legal')
                ->where('id', $id_reprezentant)
                ->update(array('nume' => Input::get('nume'), 'cnp' => Input::get('cnp')));
        }
        catch(Exception $e) {
            return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
        }
        return Redirect::back()->with('message', 'Salvare realizata cu succes!')->withInput();
    }
    
    public function postDeleteReprezentant() {
        if (Request::ajax()) {
            if (Session::token() === Input::get('_token')) {
                $id = Input::get('id');
                DB::table('reprezentant_legal')->where('id', $id)->update(array('logical_delete' => 1));
                return $id;
            }
        }
    }

    public function postDezasociazaReprezentant() {
        if (Request::ajax()) {
            if (Session::token() === Input::get('_token')) {
                $id = Input::get('id');
                DB::table('reprezentant_legal_entitate')
                    ->where('id', $id)
                    ->update(array('logical_delete' => 1));
                return $id;
            }
        }
    }
    public function postAsociazaReprezentant() {
        if (Request::ajax()) {
            if (Session::token() === Input::get('_token')) {
                $id = Input::get('id');
                DB::table('reprezentant_legal_entitate')
                    ->insertGetId(array(
                        'id_entitate' => Input::get('id_entitate'), 
                        'id_reprezentant_legal' => $id));
                return $id;
            }
        }
    }
}
