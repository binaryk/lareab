<?php namespace Codecorner\Imobil\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class CategorieConstructieController extends \BaseController {

	public function getCategoriiConstructie() {

		$categorii_constructie = DB::select("SELECT

			id,
			denumire

		FROM categorie_constructie
		WHERE logical_delete = 0

		ORDER BY denumire ASC");

		return View::make('imobil::categorie_constructie.list')
			->with('categorii_constructie', $categorii_constructie);
	}

	public function getCategorieConstructie($id) {

		$categorie_constructie = DB::select("SELECT

			id,
			denumire

		FROM categorie_constructie
		WHERE logical_delete = 0
		AND id = :id

		ORDER BY denumire ASC", array('id' => $id));

		return $categorie_constructie;
	}

	public function getAddCategorieConstructie() {

		return View::make('imobil::categorie_constructie.add');
	}

	public function postAddCategorieConstructie() {

		$rules = array('denumire' => 'required');
        
        $errors = array(
            'required' => 'Campul este obligatoriu.',
            );
        
        $validator = Validator::make(Input::all(), $rules, $errors);

        if ($validator->fails()) {
            return Redirect::back()->with('message', 'Eroare validare formular!')->withErrors($validator)->withInput();
        } 
        else {
                        
            try {
                DB::table('categorie_constructie')
                ->insertGetId(array(
                    'denumire' => Input::get('denumire')));
            }
            catch(Exception $e) {
                return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
            }
            //return Redirect::back()->with('message', 'Salvare realizata cu succes!')->withInput();
            return Redirect::route('categorie_constructie_list');
        }

	}

	public function getEditCategorieConstructie($id) {

		$categorie_constructie = self::getCategorieConstructie($id);
		return View::make('imobil::categorie_constructie.edit')
			->with('categorie_constructie', $categorie_constructie[0]);

	}

	public function postEditCategorieConstructie($id) {

		$rules = array('denumire' => 'required');
		$errors = array('required' => 'Campul este obligatoriu.');
		
		$validator = Validator::make(Input::all(), $rules, $errors);

		if ($validator->fails()) {
		    return Redirect::back()->with('message', 'Eroare validare formular!')->withErrors($validator)->withInput();
		} 
		else { 

		    try {
		        DB::table('categorie_constructie')
		        ->where('id', $id)
		        ->update(array(
		            'denumire' => Input::get('denumire')));
		    }
		    catch(Exception $e) {
		        return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
		    }
		    return Redirect::route('categorie_constructie_list');
		}
	}

	public function postDeleteCategorieConstructie() {
        if (Request::ajax()) {
            if (Session::token() === Input::get('_token')) {
                $id = Input::get('id');
                DB::table('categorie_constructie')->where('id', $id)->update(array('logical_delete' => 1));
                return $id;
            }
        }
    } 
}