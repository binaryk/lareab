<?php namespace Codecorner\Entitate\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class OcupatiiController extends \BaseController
{   
    public function getOcupatii() {
        $ocupatii = self::getOcupatiiOrganizatie();
        return View::make("entitate::ocupatie.list", compact('ocupatii'));
    } 

    public function getOcupatiiOrganizatie($return_array = false) {
        $ocupatii;
        if ($return_array)
        {
            $ocupatii = DB::table('cor_2015')
                ->where('logical_delete', 0)
                ->lists('denumire', 'id');
        }
        else
        {
            $ocupatii = DB::select("SELECT
                id, denumire
                FROM cor_2015
                WHERE logical_delete = 0");
        }
        return $ocupatii;
    }

    
    public function getAddOcupatie() {   
        return View::make('entitate::ocupatie.add');
    }
      
    public function postAddOcupatie() {
        $rules = array('denumire' => 'required');
        $errors = array('required' => 'Campul este obligatoriu.');
        
        $validator = Validator::make(Input::all(), $rules, $errors);
        if ($validator->fails()) {
            return Redirect::back()->with('message', 'Eroare validare formular!')->withErrors($validator)->withInput()->with($errors);
        } 
        else {
            try {
                DB::table('cor_2015')
                    ->insertGetId(array(
                        'id' => $id,
                        'denumire' => Input::get('denumire'),                      
                        ));
            }
            catch(Exception $e) {
                return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
            }
            return Redirect::back()->with('message', 'Salvare realizata cu succes!')->withInput();
        }
    }
    
    public function getEditOcupatie($id) {
        $ocupatie = DB::select("SELECT
            id,
            denumire
            FROM ocupatie
            WHERE logical_delete = 0
            AND id = :id_ocupatie", array('id_ocupatie' => $id));
        return View::make('entitate::ocupatie.edit')->with('ocupatie', $ocupatie[0]);
    }
    
      public function postEditOcupatie($id) {
        $rules = array('denumire' => 'required');
        $errors = array('required' => 'Campul este obligatoriu.');
        
        $validator = Validator::make(Input::all(), $rules, $errors);
        if ($validator->fails()) {
            return Redirect::back()->with('message', 'Eroare validare formular!')->withErrors($validator)->withInput()->with($errors);
        } 
        else {
            try {
                DB::table('cor_2015')
                    ->where('id', $id)
                    ->update(array(
                        'id' => $id,
                        'denumire' => Input::get('denumire')                      
                        ));
            }
            catch(Exception $e) {
                return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
            }
            return Redirect::back()->with('message', 'Salvare realizata cu succes!')->withInput();
        }
    }  
    
    public function postDeleteOcupatie() {
        if (Request::ajax()) {
            if (Session::token() === Input::get('_token')) {
                $id = Input::get('id');
                DB::table('cor_2015')->where('id', $id)->update(array('logical_delete' => 1));
                return $id;
            }
        }
    }
}
