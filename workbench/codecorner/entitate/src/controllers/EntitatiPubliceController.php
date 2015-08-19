<?php namespace Codecorner\Entitate\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class EntitatiPubliceController extends \BaseController
{
    public function getEntitatiPublice() {
        $entitati = DB::select("SELECT
            ent.id,
            ent.denumire,
            ent.cif,
            ent.adresa,
            ent.cod_postal,
            ent.telefon,
            ent.fax,
            ent.id_organizatie,
            ent.id_tip_entitate,
            judet.denumire AS judet, 
            loc.denumire AS localitate,
            te.denumire AS tip_entitate
            FROM entitate ent
            LEFT OUTER JOIN judet ON ent.id_judet = judet.id_judet AND judet.logical_delete = 0
            LEFT OUTER JOIN localitate loc ON ent.id_localitate = loc.id_localitate AND loc.logical_delete = 0
            INNER JOIN tip_entitate te ON te.id = ent.id_tip_entitate AND te.logical_delete = 0
            WHERE ent.logical_delete = 0
            AND ent.id_tip_entitate = 3
            -- AND ent.id_organizatie IS null
            ORDER BY te.id, ent.denumire");        
        return View::make('entitate::entitati_publice.list')->with('entitati', $entitati);
    }
    public function getAddEntitate() {
        $tip_entitati = DB::select("SELECT id, denumire FROM tip_entitate WHERE logical_delete = 0");
        return View::make('entitate::entitati_publice.add')->with('tip_entitati', $tip_entitati);
    }
    public function postAddEntitate() {
        //Debugbar::info("TI=" . Input::get('tip_entitate'));
        $rules = array('denumire' => 'required');
        $errors = array('required' => 'Campul este obligatoriu.');
        
        $validator = Validator::make(Input::all(), $rules, $errors);
        if ($validator->fails()) {
            return Redirect::back()->with('message', 'Eroare validare formular!')->withErrors($validator)->withInput();
        } 
        else {
            try {
                $id = DB::table('entitate')
                ->insertGetId(array(
                    'denumire' => Input::get('denumire'), 
                    'cif' => Input::get('cif'), 
                    'id_tara' => intval(Input::get('tara')), 
                    'id_regiune' => intval(Input::get('regiune')), 
                    'id_judet' => intval(Input::get('judet')), 
                    'id_localitate' => intval(Input::get('localitate')), 
                    'adresa' => Input::get('adresa'), 
                    'cod_postal' => Input::get('cod_postal'), 
                    'telefon' => Input::get('telefon'), 
                    'fax' => Input::get('fax'), 
                    'id_organizatie' => null, 
                    'id_tip_entitate' => 3));
            }
            catch(Exception $e) {
                return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
            }
            return Redirect::route('entitati_publice_list');
        }
    }

    public function getEditEntitate($id) {        
        $entitate = DB::select("SELECT
            ent.id,
            ent.denumire,
            ent.cif,
            ent.norc,
            ent.adresa,
            ent.cod_postal,
            ent.telefon,
            ent.fax,
            ent.id_tara,
            ent.id_regiune,
            ent.id_judet,
            ent.id_localitate,
            ent.id_tip_entitate,
            ent.servicii,
            ent.lucrari,
            ent.furnizare,
            tara.denumire AS tara,
            regiune.denumire AS regiune,
            judet.denumire AS judet,
            loc.denumire AS localitate
            FROM entitate ent
            LEFT OUTER JOIN tara ON ent.id_tara = tara.id_tara AND tara.logical_delete = 0
            LEFT OUTER JOIN regiune ON ent.id_regiune = regiune.id_regiune AND regiune.logical_delete = 0
            LEFT OUTER JOIN judet ON ent.id_judet = judet.id_judet AND judet.logical_delete = 0
            LEFT OUTER JOIN localitate loc ON ent.id_localitate = loc.id_localitate AND loc.logical_delete = 0
                WHERE ent.logical_delete = 0                  
                AND ent.id = :id", array('id' => $id));
        
        return View::make('entitate::entitati_publice.edit')->with('entitate', $entitate[0]);
    }
    public function postEditEntitate($id) {
        $rules = array('denumire' => 'required');
        $errors = array('required' => 'Campul este obligatoriu.');
        
        $validator = Validator::make(Input::all(), $rules, $errors);
        if ($validator->fails()) {
            return Redirect::back()->with('message', 'Eroare validare formular!')->withErrors($validator)->withInput();
        }
        try {
            //Debugbar::info('CP=' . Input::get('cod_postal'));
            DB::table('entitate')
                ->where('id', $id)
                ->update(array(
                    'denumire' => Input::get('denumire'), 
                    'cif' => Input::get('cif'), 
                    'id_tara' => intval(Input::get('tara')), 
                    'id_regiune' => intval(Input::get('regiune')), 
                    'id_judet' => intval(Input::get('judet')), 
                    'id_localitate' => intval(Input::get('localitate')), 
                    'adresa' => Input::get('adresa'), 
                    'cod_postal' => Input::get('cod_postal'), 
                    'telefon' => Input::get('telefon'), 
                    'fax' => Input::get('fax'), 
                    'id_tip_entitate' => 3));
        }
        catch(Exception $e) {
            return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
        }
        return Redirect::back()->with('message', 'Salvare realizata cu succes!')->withInput();
    }

    public function postDeleteEntitate() {
        if (Request::ajax()) {
            if (Session::token() === Input::get('_token')) {
                $id = Input::get('id');
                DB::table('entitate')->where('id', $id)->update(array('logical_delete' => 1));
                return $id;
            }
        }
    }
}
