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
    public function getPersonal($id_entitate, $entitate) {
        $personal = DB::select("SELECT 
            id_personal_entitate,
            nume
            FROM personal_entitate
            WHERE logical_delete = 0
            AND id_entitate = :id_entitate", array('id_entitate' => $id_entitate));
        return View::make('entitate::personal_entitate.list')
            ->with('personal', $personal)
            ->with('entitate', $entitate)
            ->with('id_entitate', $id_entitate);
    }
    
    public function getAddPersoana($id_entitate) {   
        return View::make('entitate::personal_entitate.add');
    }
      
    public function postAddPersoana($id_entitate) {
        $rules = array('nume' => 'required');
        $errors = array('required' => 'Campul este obligatoriu.');
        
        $validator = Validator::make(Input::all(), $rules, $errors);
        if ($validator->fails()) {
            return Redirect::back()->with('message', 'Eroare validare formular!')->withErrors($validator)->withInput()->with($errors);
        } 
        else {
            try {
                DB::table('personal_entitate')
                    ->insertGetId(array('Nume' => Input::get('nume'), 'IdEntitate' => $id_entitate));
            }
            catch(Exception $e) {
                return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
            }
            return Redirect::back()->with('message', 'Salvare realizata cu succes!')->withInput();
        }
    }
    
    public function getEditPersoana($id_persoana) {
        $persoana = DB::select("SELECT 
            nume
            FROM personal_entitate
            WHERE logical_delete = 0
            AND id_personal_entitate = :id_persoana", array('id_persoana' => $id_persoana));
        return View::make('entitate::personal_entitate.edit')->with('persoana', $persoana[0]);
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
                DB::table('personal_entitate')
                    ->where('id_personal_entitate', $id_persoana)
                    ->update(array('Nume' => Input::get('nume')));
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
                $id = Input::get('id_personal_entitate');
                DB::table('personal_entitate')->where('id_personal_entitate', $id)->update(array('logical_delete' => 1));
                return $id;
            }
        }
    }
}
