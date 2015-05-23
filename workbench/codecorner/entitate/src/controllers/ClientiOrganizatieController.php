<?php namespace Codecorner\Entitate\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class ClientiOrganizatieController extends \BaseController
{
    public function getClienti() {
        $clienti = DB::select("SELECT
            ent.id_entitate,
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
            INNER JOIN tip_entitate te ON te.id_tip_entitate = ent.id_tip_entitate AND te.logical_delete = 0
            WHERE ent.logical_delete = 0
            AND ent.gestionata_org = false
            AND ent.id_organizatie = :id_organizatie
            ORDER BY te.id_tip_entitate, ent.denumire", array('id_organizatie' => $this->date_organizatie[0]->id_organizatie));        
        return View::make('entitate::clienti_organizatie.list')->with('clienti', $clienti);
    }
    public function getAddclient() {
        $tip_entitati = DB::select("SELECT id_tip_entitate, denumire FROM tip_entitate WHERE logical_delete = 0");
        return View::make('entitate::clienti_organizatie.add')->with('tip_entitati', $tip_entitati);
    }
    public function postAddClient() {
        //Debugbar::info("TI=" . Input::get('tip_entitate'));
        $rules = array('denumire' => 'required');
        $errors = array('required' => 'Campul este obligatoriu.');
        
        $validator = Validator::make(Input::all(), $rules, $errors);
        if ($validator->fails()) {
            return Redirect::back()->with('message', 'Eroare validare formular!')->withErrors($validator)->withInput();
        } 
        else {
            try {
                DB::table('entitate')
                ->insertGetId(array(
                    'denumire' => Input::get('denumire'), 
                    'cif' => Input::get('cif'), 
                    'norc' => Input::get('num_ord_rc'), 
                    'id_tara' => Input::get('tara'), 
                    'id_regiune' => Input::get('regiune'), 
                    'id_judet' => Input::get('judet'), 
                    'id_localitate' => Input::get('localitate'), 
                    'adresa' => Input::get('adresa'), 
                    'cod_postal' => Input::get('cod_postal'), 
                    'telefon' => Input::get('telefon'), 
                    'fax' => Input::get('fax'), 
                    'servicii' => (Input::get('servicii') === null) ? false : true, 
                    'lucrari' => (Input::get('lucrari') === null) ? false : true, 
                    'furnizare' => (Input::get('furnizare') === null) ? false : true, 
                    'gestionata_org' => false, 
                    'id_organizatie' => $this->date_organizatie[0]->id_organizatie, 
                    'id_tip_entitate' => 1));
            }
            catch(Exception $e) {
                return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
            }
            return Redirect::route('clienti_organizatie_list');
        }
    }
    
    public function getEditClient($id) {
        $tip_entitati = DB::select("SELECT id_tip_entitate, denumire FROM tip_entitate WHERE logical_delete = 0");
        $client = DB::select("SELECT
            ent.id_entitate,
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
                AND ent.id_entitate = :id", array('id' => $id));
        
        return View::make('entitate::clienti_organizatie.edit')->with('client', $client[0])->with('tip_entitati', $tip_entitati);
    }
    
    public function postEditClient($id_entitate) {
        $rules = array('denumire' => 'required');
        $errors = array('required' => 'Campul este obligatoriu.');
        
        $validator = Validator::make(Input::all(), $rules, $errors);
        if ($validator->fails()) {
            return Redirect::back()->with('message', 'Eroare validare formular!')->withErrors($validator)->withInput();
        }
        try {
            //Debugbar::info('CP=' . Input::get('cod_postal'));
            DB::table('entitate')
                ->where('id_entitate', $id_entitate)
                ->update(array(
                    'denumire' => Input::get('denumire'), 
                    'cif' => Input::get('cif'), 
                    'norc' => Input::get('num_ord_rc'), 
                    'id_tara' => Input::get('tara'), 
                    'id_regiune' => Input::get('regiune'), 
                    'id_judet' => Input::get('judet'), 
                    'id_localitate' => Input::get('localitate'), 
                    'adresa' => Input::get('adresa'), 
                    'cod_postal' => Input::get('cod_postal'), 
                    'telefon' => Input::get('telefon'), 
                    'fax' => Input::get('fax'), 
                    'servicii' => (Input::get('servicii') === '1') ? true : false, 
                    'lucrari' => (Input::get('lucrari') === '1') ? true : false, 
                    'furnizare' => (Input::get('furnizare') === '1') ? true : false, 
                    'gestionata_org' => false, 
                    'id_organizatie' => $this->date_organizatie[0]->id_organizatie));
        }
        catch(Exception $e) {
            return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
        }
        return Redirect::back()->with('message', 'Salvare realizata cu succes!')->withInput();
    }
    public function postDeleteClient() {
        if (Request::ajax()) {
            if (Session::token() === Input::get('_token')) {
                $id = Input::get('id_entitate');
                DB::table('entitate')->where('id_entitate', $id)->update(array('logical_delete' => 1));
                return $id;
            }
        }
    }
}
