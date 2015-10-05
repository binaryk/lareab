<?php namespace Codecorner\Entitate\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class PersonalEntitateController extends \BaseController
{   
    public function getPersonalEntitate($id_entitate, $entitate) {
        $personal_all = array();
        $personal_entitate = array();
  
        $sql = "SELECT
            pe.id,
            p.id AS id_personal,
            p.nume,
            p.cnp     
            FROM personal_entitate pe
            INNER JOIN personal p ON p.id = pe.id_personal AND p.logical_delete = 0
            WHERE pe.logical_delete = 0
            AND pe.id_entitate = :id_entitate";
        $personal_entitate = DB::select($sql, array('id_entitate' => $id_entitate));               

        $sql = "SELECT
            p.id,
            p.nume,
            p.cnp     
            FROM personal p
            WHERE p.logical_delete = 0
            AND p.id NOT IN (SELECT id_personal FROM personal_entitate WHERE logical_delete = 0 AND id_entitate = :id_entitate)";
        $personal_all = DB::select($sql, array('id_entitate' => $id_entitate));               
        
        return View::make("entitate::personal.asociaza_entitate", compact('personal_all', 'personal_entitate', 'id_entitate', 'entitate'));
    }

    public function getPersonalOrganizatie() {
        $personal = array();
        $sql = "SELECT 
            p.id,
            p.nume,
            p.cnp,
            p.telefon_1,
            p.telefon_2,
            p.mail_1,
            p.mail_2,
            (SELECT group_concat(ent.denumire) 
                FROM entitate ent
                INNER JOIN personal_entitate pe ON pe.id_entitate = ent.id AND pe.logical_delete = 0
                WHERE ent.logical_delete = 0
                AND pe.id_personal = p.id) AS entitati
            FROM personal p
            WHERE p.logical_delete = 0";
            //dd($sql);
        if (\Entrust::can('administrare_platforma'))
        {
            $personal = DB::select($sql);
        }
        else 
        {
            $sql .= " AND p.id_organizatie = :id_organizatie";
            $personal = DB::select($sql, array('id_organizatie' => isset(self::organizatie()[0])?self::organizatie()[0]->id_organizatie:-1));
            //dd($sql);
        }            
        return View::make('entitate::personal.list')->with('personal', $personal);
    }   
    
    public function getAddPersoanaOrganizatie() { 
        //$utilizatori_app = DB::select("SELECT email, full_name FROM users WHERE confirmed = 1 AND id_org = :id_organizatie", array('id_organizatie' => isset(self::organizatie()[0])?self::organizatie()[0]->id_organizatie:-1)); 
        $utilizatori_app = DB::table('users')
                ->where('confirmed', 1)
                ->where('id_org', isset(self::organizatie()[0])?self::organizatie()[0]->id_organizatie:-1)
                ->lists(DB::raw("concat(full_name, ',  ' , email)", 'id'));
        $ocupatii_class = new OcupatiiController;
        $ocupatii = $ocupatii_class->getOcupatiiOrganizatie(true);   
        return View::make('entitate::personal.add')
            ->with('ocupatii', $ocupatii)
            ->with('utilizatori_app', $utilizatori_app);
    }
      
    public function postAddPersoana() {
        $rules = array('nume' => 'required', 'cnp' => 'required');
        $errors = array('required' => 'Campul este obligatoriu.');
        
        $validator = Validator::make(Input::all(), $rules, $errors);
        if ($validator->fails()) {
            return Redirect::back()->with('message', 'Eroare validare formular!')->withErrors($validator)->withInput()->with($errors);
        } 
        else {
            try {
                DB::table('personal')
                    ->insertGetId(array(
                        'nume' => Input::get('nume'), 
                        'cnp' => Input::get('cnp'),
                        'telefon_1' => Input::get('telefon_1'),
                        'telefon_2' => Input::get('telefon_2'),
                        'mail_1' => Input::get('mail_1'),
                        'mail_2' => Input::get('mail_2'),
                        'id_ocupatie' => intval(Input::get('ocupatie'))));
            }
            catch(Exception $e) {
                return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
            }
            return Redirect::back()->with('message', 'Salvare realizata cu succes!')->withInput();
        }
    }
    
    public function getEditPersoana($id_persoana) {
        $ocupatii_class = new OcupatiiController;
        $ocupatii = $ocupatii_class->getOcupatiiOrganizatie(true);   
        $persoana = DB::select("SELECT 
            p.nume,
            p.cnp,
            p.telefon_1,
            p.telefon_2,
            p.mail_1,
            p.mail_2,
            o.id AS id_ocupatie
            FROM personal p
            LEFT OUTER JOIN ocupatie o ON o.id = p.id_ocupatie AND o.logical_delete = 0
            WHERE p.logical_delete = 0
            AND p.id = :id_persoana", array('id_persoana' => $id_persoana));
        return View::make('entitate::personal.edit')
            ->with('persoana', $persoana[0])
            ->with('ocupatii', $ocupatii);
    }
    
      public function postEditPersoana($id_persoana) {
        $rules = array('nume' => 'required');
        $errors = array('required' => 'Campul este obligatoriu.');
        
        $validator = Validator::make(Input::all(), $rules, $errors);
        if ($validator->fails()) {
            return Redirect::back()->with('message', 'Eroare validare formular!')->withErrors($validator)->withInput()->with($errors);
        } 
        else {
            try {
                DB::table('personal')
                    ->where('id', $id_persoana)
                    ->update(array(
                        'nume' => Input::get('nume'), 
                        'cnp' => Input::get('cnp'),
                        'telefon_1' => Input::get('telefon_1'),
                        'telefon_2' => Input::get('telefon_2'),
                        'mail_1' => Input::get('mail_1'),
                        'mail_2' => Input::get('mail_2'),
                        'id_ocupatie' => intval(Input::get('ocupatie'))));
            }
            catch(Exception $e) {
                return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
            }
            return Redirect::back()->with('message', 'Salvare realizata cu succes!')->withInput();
        }
    }  
    
    public function postDeletePersoana() {
        if (Request::ajax()) {
            if (Session::token() === Input::get('_token')) {
                $id = Input::get('id');
                DB::table('personal')->where('id', $id)->update(array('logical_delete' => 1));
                return $id;
            }
        }
    }
    public function postDezasociazaPersonal() {
        if (Request::ajax()) {
            if (Session::token() === Input::get('_token')) {
                $id = Input::get('id');
                DB::table('personal_entitate')
                    ->where('id', $id)
                    ->update(array('logical_delete' => 1));
                return $id;
            }
        }
    }
    public function postAsociazaPersonal() {
        if (Request::ajax()) {
            if (Session::token() === Input::get('_token')) {
                $id = Input::get('id');
                DB::table('personal_entitate')
                    ->insertGetId(array(
                        'id_entitate' => Input::get('id_entitate'), 
                        'id_personal' => $id));
                return $id;
            }
        }
    }    
}
