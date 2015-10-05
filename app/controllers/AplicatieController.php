<?php

class AplicatieController extends BaseController
{   
    public function getAplicatii() {
        $aplicatii = DB::select("SELECT
            id, denumire
            FROM aplicatie
            WHERE logical_delete = 0");
        return View::make("aplicatie.list", compact('aplicatii'));
    } 
    
    //Permite accesul grupurilor de utilizatori la aplicatia selectionata
    public function getAplicatieGrup($id_aplicatie, $aplicatie) {
        $roles_app = DB::select("SELECT
            ar.id, r.name
            FROM roles r
            INNER JOIN aplicatie_role ar ON ar.id_role = r.id AND ar.logical_delete = 0
            WHERE ar.id_aplicatie = :id_aplicatie", array('id_aplicatie' => $id_aplicatie));

        $roles_all = DB::select("SELECT
            r.id, r.name
            FROM roles r
            WHERE r.id NOT IN (SELECT id_role FROM aplicatie_role WHERE logical_delete = 0 AND id_aplicatie = :id_aplicatie)", array('id_aplicatie' => $id_aplicatie));
        return View::make("aplicatie.asociaza_roles", compact('roles_all', 'roles_app', 'id_aplicatie', 'aplicatie'));
    } 

    public function getAddAplicatie() {   
        return View::make('aplicatie.add');
    }
      
    public function postAddAplicatie() {
        $rules = array('denumire' => 'required');
        $errors = array('required' => 'Campul este obligatoriu.');
        
        $validator = Validator::make(Input::all(), $rules, $errors);
        if ($validator->fails()) {
            return Redirect::back()->with('message', 'Eroare validare formular!')->withErrors($validator)->withInput()->with($errors);
        } 
        else {
            try {
                DB::table('aplicatie')
                    ->insertGetId(array(
                        'denumire' => Input::get('denumire')                        
                        ));
            }
            catch(Exception $e) {
                return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
            }
            return Redirect::back()->with('message', 'Salvare realizata cu succes!')->withInput();
        }
    }
    
    public function getEditAplicatie($id) {
        $aplicatie = DB::select("SELECT
            id,
            denumire
            FROM aplicatie
            WHERE logical_delete = 0
            AND id = :id_aplicatie", array('id_aplicatie' => $id));
        return View::make('aplicatie.edit')->with('aplicatie', $aplicatie[0]);
    }
    
    public function postEditAplicatie($id) {
        $rules = array('denumire' => 'required');
        $errors = array('required' => 'Campul este obligatoriu.');
        
        $validator = Validator::make(Input::all(), $rules, $errors);
        if ($validator->fails()) {
            return Redirect::back()->with('message', 'Eroare validare formular!')->withErrors($validator)->withInput()->with($errors);
        } 
        else {
            try {
                DB::table('aplicatie')
                    ->where('id', $id)
                    ->update(array(
                        'denumire' => Input::get('denumire')                                            
                        ));
            }
            catch(Exception $e) {
                return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
            }
            return Redirect::back()->with('message', 'Salvare realizata cu succes!')->withInput();
        }
    }  
    
    public function postDeleteAplicatie() {
        if (Request::ajax()) {
            if (Session::token() === Input::get('_token')) {
                $id = Input::get('id');
                DB::table('aplicatie')->where('id', $id)->update(array('logical_delete' => 1));
                return $id;
            }
        }
    }

    public function postDezasociazaRole() {
        if (Request::ajax()) {
            if (Session::token() === Input::get('_token')) {
                $id = Input::get('id');
                DB::table('aplicatie_role')
                    ->where('id', $id)
                    ->update(array('logical_delete' => 1));
                return $id;
            }
        }
    }
    
    public function postAsociazaRole() {
        if (Request::ajax()) {
            if (Session::token() === Input::get('_token')) {
                $id = Input::get('id');
                DB::table('aplicatie_role')
                    ->insertGetId(array(
                        'id_aplicatie' => Input::get('id_aplicatie'), 
                        'id_role' => $id));
                return $id;
            }
        }
    }    
}
