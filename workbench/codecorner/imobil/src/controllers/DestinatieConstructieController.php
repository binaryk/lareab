<?php namespace Codecorner\Imobil\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class DestinatieConstructieController extends \BaseController {

	public function getTipuriConstructie() {

		$tipuri_constructie = DB::select("SELECT

			t_const.id,
			t_const.denumire AS denumire_tip_const,
			t_const.id_categoria_constructie,

			cat_const.id AS id_cat_const,
			cat_const.denumire AS denumire_cat_const

		FROM tip_constructie AS t_const
		LEFT OUTER JOIN categorie_constructie AS cat_const ON cat_const.id = t_const.id_categoria_constructie AND cat_const.logical_delete = 0

		WHERE t_const.logical_delete = 0
		ORDER BY cat_const.denumire ASC");

		return View::make('imobil::destinatie_constructie.list')
			->with('tipuri_constructie', $tipuri_constructie);
	}

	public function getTipuriConstructieCategorie($id_categorie)
	{
		$tipuri_constructie = DB::select("SELECT

			t_const.id,
			t_const.denumire AS denumire_tip_const,
			t_const.id_categoria_constructie,

			cat_const.id AS id_cat_const,
			cat_const.denumire AS denumire_cat_const

		FROM tip_constructie AS t_const
		LEFT OUTER JOIN categorie_constructie AS cat_const ON cat_const.id = t_const.id_categoria_constructie AND cat_const.logical_delete = 0

		WHERE t_const.logical_delete = 0
		AND t_const.id_categoria_constructie = :id_categorie", array('id_categorie' => $id_categorie));

		$cat = new CategorieConstructieController();
		$categorie_constructie = $cat->getCategorieConstructie($id_categorie);
		return View::make('imobil::destinatie_constructie.list')
			->with('tipuri_constructie', $tipuri_constructie)
			->with('categorie_constructie', $categorie_constructie[0]);
	}

	public function getTipConstructie($id) {

		$tip_constructie = DB::select("SELECT

			t_const.id,
			t_const.denumire AS denumire_tip_const,
			t_const.id_categoria_constructie,

			cat_const.id AS id_cat_const,
			cat_const.denumire AS denumire_cat_const

		FROM tip_constructie AS t_const
		LEFT OUTER JOIN categorie_constructie AS cat_const ON cat_const.id = t_const.id_categoria_constructie AND cat_const.logical_delete = 0

		WHERE t_const.logical_delete = 0
		AND t_const.id = :id
		ORDER BY cat_const.denumire ASC", array('id' => $id));

		return $tip_constructie;

	}

	public function getCategoriiConstructie() {

		$categorii_constructie = DB::select("SELECT

			id,
			denumire

		FROM categorie_constructie
		WHERE logical_delete = 0

		ORDER BY denumire ASC");

		return self::object_to_array($categorii_constructie);
	}

	public function getAddTipConstructie() {

		$categorii_constructie = self::getCategoriiConstructie();
		return View::make('imobil::destinatie_constructie.add')
			->with('categorii_constructie', $categorii_constructie);

	}
	public function postAddTipConstructie() {

		$rules = array(
			'denumire' => 'required',
			'categorie_constructie' => 'required'
			);
        
        $errors = array(
            'required' => 'Campul este obligatoriu.',
            );
        
        $validator = Validator::make(Input::all(), $rules, $errors);

        if ($validator->fails()) {
            return Redirect::back()->with('message', 'Eroare validare formular!')->withErrors($validator)->withInput();
        } 
        else {
                        
            try {
                DB::table('tip_constructie')
                ->insertGetId(array(
                    'denumire' => Input::get('denumire'),
                    'id_categoria_constructie' => Input::get('categorie_constructie')));
            }
            catch(Exception $e) {
                return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
            }
            //return Redirect::back()->with('message', 'Salvare realizata cu succes!')->withInput();
            return Redirect::route('destinatie_constructie_list');
        }

	}

	public function getEditTipConstructie($id) {

		$categorii_constructie = self::getCategoriiConstructie();
		$tip_constructie = self::getTipConstructie($id);

		return View::make('imobil::destinatie_constructie.edit')
			->with('categorii_constructie', $categorii_constructie)
			->with('tip_constructie', $tip_constructie[0]);
	}

	public function postEditTipConstructie($id) {

		$rules = array(
			'denumire' => 'required',
			'categorie_constructie' => 'required');

		$errors = array('required' => 'Campul este obligatoriu.');
		
		$validator = Validator::make(Input::all(), $rules, $errors);

		if ($validator->fails()) {
		    return Redirect::back()->with('message', 'Eroare validare formular!')->withErrors($validator)->withInput();
		} 
		else { 

		    try {
		        DB::table('tip_constructie')
		        ->where('id', $id)
		        ->update(array(
		            'denumire' => Input::get('denumire'),
		            'id_categoria_constructie' => Input::get('categorie_constructie')));
		    }
		    catch(Exception $e) {
		        return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
		    }
		    return Redirect::route('destinatie_constructie_list');
		}
	}

	public function postDeleteTipConstructie() {
        if (Request::ajax()) {
            if (Session::token() === Input::get('_token')) {
                $id = Input::get('id');
                DB::table('tip_constructie')->where('id', $id)->update(array('logical_delete' => 1));
                return $id;
            }
        }
    }
 
}