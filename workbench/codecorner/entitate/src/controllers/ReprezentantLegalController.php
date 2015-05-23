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
        $reprezentanti = DB::select("SELECT 
            repleg_entitate.id_repleg_entitate,
            repleg_entitate.nume,
            repleg_entitate.cnp,
            entitate.denumire AS entitate
            FROM repleg_entitate
            LEFT OUTER JOIN entitate 
                ON entitate.id_entitate = repleg_entitate.id_entitate 
                AND entitate.logical_delete = 0                       
            WHERE repleg_entitate.logical_delete = 0
            AND repleg_entitate.id_entitate = :id_entitate", array('id_entitate' => $id_entitate));
        return View::make('entitate::reprezentant_legal.list')
			->with('reprezentanti', $reprezentanti)
			->with('entitate', $entitate)
			->with('id_entitate', $id_entitate);
    }
    
    public function getReprezentantiOrganizatie() {
        $reprezentanti = DB::select("SELECT 
            repleg_entitate.id_repleg_entitate,
            repleg_entitate.nume,
            repleg_entitate.cnp,
            entitate.denumire AS entitate
            FROM repleg_entitate                       
            INNER JOIN entitate 
                ON entitate.id_entitate = repleg_entitate.id_entitate 
                AND entitate.logical_delete = 0
                AND entitate.id_organizatie = :id_organizatie
            WHERE repleg_entitate.logical_delete = 0", array('id_organizatie' => $this->date_organizatie[0]->id_organizatie));
        return View::make('entitate::reprezentant_legal.list')->with('reprezentanti', $reprezentanti);
    }
    
    public function getAddReprezentantOrganizatie() {
        $entitati = DB::table('entitate')->where('logical_delete', 0)->where('id_organizatie', $this->date_organizatie[0]->id_organizatie)->select('*')->orderBy('Denumire')->get();
        return View::make('entitate::reprezentant_legal.add')->with('entitati', $entitati);
    }
    
    public function getAddReprezentantEntitate($id_entitate, $denumire) {
        return View::make('entitate::reprezentant_legal.add')->with('id_entitate', $id_entitate)->with('denumire', $denumire);
    }
    
    public function postAddReprezentant() {
        $rules = array('nume' => 'required', 'cnp' => 'required', 'entitate' => 'required|integer|min:1');
        $errors = array('required' => 'Campul este obligatoriu.', 'min' => 'Selectioneaza o entitate.');
        
        $validator = Validator::make(Input::all(), $rules, $errors);
        if ($validator->fails()) {
            return Redirect::back()->with('message', 'Eroare validare formular!')->withErrors($validator)->withInput()->with($errors);
        } 
        else {
            try {
                DB::table('repleg_entitate')->insertGetId(array('Nume' => Input::get('nume'), 'CNP' => Input::get('cnp'), 'id_entitate' => Input::get('entitate')));
            }
            catch(Exception $e) {
                return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
            }
            return Redirect::back()->with('message', 'Salvare realizata cu succes!')->withInput();
        }
    }
    
    public function getEditReprezentant($id_reprezentant) {
        $reprezentant = DB::select("SELECT 
            id_repleg_entitate,
            nume,
            cnp
            FROM repleg_entitate                       
            WHERE logical_delete = 0
            AND id_repleg_entitate = :id_reprezentant", array('id_reprezentant' => $id_reprezentant));
        return View::make('entitate::reprezentant_legal.edit')->with('reprezentant', $reprezentant[0]);
    }
    
    public function postEditReprezentant($id_reprezentant) {
        $rules = array('nume' => 'required', 'cnp' => 'required');
        $errors = array('required' => 'Campul este obligatoriu.');
        
        $validator = Validator::make(Input::all(), $rules, $errors);
        if ($validator->fails()) {
            return Redirect::back()->with('message', 'Eroare validare formular!')->withErrors($validator)->withInput();
        }
        try {
            DB::table('repleg_entitate')->where('id_repleg_entitate', $id_reprezentant)->update(array('Nume' => Input::get('nume'), 'CNP' => Input::get('cnp')));
        }
        catch(Exception $e) {
            return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
        }
        return Redirect::back()->with('message', 'Salvare realizata cu succes!')->withInput();
    }
    
    public function postDeleteReprezentant() {
        if (Request::ajax()) {
            if (Session::token() === Input::get('_token')) {
                $id = Input::get('id_repleg_entitate');
                DB::table('repleg_entitate')->where('id_repleg_entitate', $id)->update(array('logical_delete' => 1));
                return $id;
            }
        }
    }
}
