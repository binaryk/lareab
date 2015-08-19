<?php namespace Codecorner\Banca\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class BancaController extends \BaseController
{
    public function getBanciOrganizatie()
    {
        $sql = "SELECT
            b.id,
            b.denumire
            FROM banca b
            WHERE b.logical_delete = 0
            AND b.id_organizatie = :id_organizatie";
        $banci_all = DB::select($sql, array('id_organizatie' => isset(self::organizatie()[0])?self::organizatie()[0]->id_organizatie:-1));
        return self::object_to_array($banci_all);
    }

    public function getBanci()
    {
        $banci = array();
        $sql = "SELECT
            id,
            denumire,
            adresa,     
            telefon
            FROM banca
            WHERE logical_delete = 0";
        if (\Entrust::can('administrare_platforma'))
        {
            $banci = DB::select($sql);
        }
        else 
        {
            $sql .= " AND id_organizatie = :id_organizatie";
            $banci = DB::select($sql, array('id_organizatie' => isset(self::organizatie()[0])?self::organizatie()[0]->id_organizatie:-1));
        }

        return View::make("banca::banca.list")
            ->with("banci", $banci);
    }

	public function getAddBanca()
	{
		return View::make('banca::banca.add');
	}
	
	public function postAddBanca() {
        $rules = array(
        	'denumire' => 'required',
            'adresa' => 'required');
        $errors = array('required' => 'Campul este obligatoriu.');
        
        $validator = Validator::make(Input::all(), $rules, $errors);
        if ($validator->fails()) {
            return Redirect::back()->with('message', 'Eroare validare formular!')->withErrors($validator)->withInput();
        } 
        else {
            try {
                DB::table('banca')
                ->insertGetId(array(
                    'denumire' => Input::get('denumire'), 
                    'adresa' => Input::get('adresa'), 
                    'telefon' => Input::get('telefon')));
            }
            catch(Exception $e) {
                return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
            }
            return Redirect::route('banci_list');
        }
    }	

    public function getEditBanca($id)
    {
    	$banca = DB::select("SELECT
            id,
            denumire,
            adresa,     
            telefon
            FROM banca
			WHERE id = :id", array('id' => $id));
		return View::make("banca::banca.edit")
			->with("banca", $banca[0]);	
    }

    public function postEditBanca($id) {
        $rules = array(
            'denumire' => 'required',
            'adresa' => 'required');
        $errors = array('required' => 'Campul este obligatoriu.');
        
        $validator = Validator::make(Input::all(), $rules, $errors);
        if ($validator->fails()) {
            return Redirect::back()->with('message', 'Eroare validare formular!')->withErrors($validator)->withInput();
        } 
        else {
            try {
                DB::table('banca')
                    ->where('id', $id)
                    ->update(array(
                    'denumire' => Input::get('denumire'), 
                    'adresa' => Input::get('adresa'), 
                    'telefon' => Input::get('telefon')));
            }
            catch(Exception $e) {
                return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
            }
            return Redirect::route('banci_list');
        }
    }

    public function postDeleteBanca() {
        if (Request::ajax()) {
            if (Session::token() === Input::get('_token')) {
                $id = Input::get('id');
                DB::table('banca')->where('id', $id)->update(array('logical_delete' => 1));
                return $id;
            }
        }
    }
}