<?php namespace Codecorner\Banca\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class BancaEntitateController extends \BaseController
{
    public function getBanciEntitate($id_entitate, $entitate)
    {
        $banci_entitate = array();

        $sql = "SELECT
            be.id,
            b.id AS id_banca,
            be.id_entitate,
            b.denumire,
            b.adresa,
            b.telefon,     
            be.iban,
            be.sucursala
            FROM banca_entitate be
            INNER JOIN banca b ON b.id = be.id_banca AND b.logical_delete = 0
            WHERE be.logical_delete = 0
            AND be.id_entitate = :id_entitate";
        $banci_entitate = DB::select($sql, array('id_entitate' => $id_entitate));               

        return View::make("banca::banca_entitate.list", compact('banci_entitate', 'id_entitate', 'entitate'));
    }

	public function getAddBancaEntitate($id_entitate, $entitate)
	{
        $banca_class = new BancaController;
        $banci = $banca_class->getBanciOrganizatie();
		return View::make('banca::banca_entitate.add', compact('banci', 'id_entitate', 'entitate'));
	}
	
	public function postAddBancaEntitate($id_entitate, $entitate) {
        $rules = array(
            'id_banca' => 'required');
        $errors = array('required' => 'Campul este obligatoriu.');
        
        $validator = Validator::make(Input::all(), $rules, $errors);
        if ($validator->fails()) {
            return Redirect::back()->with('message', 'Eroare validare formular!')->withErrors($validator)->withInput();
        } 
        else {
            try {
                DB::table('banca_entitate')
                ->insertGetId(array(
                    'id_banca' => intval(Input::get('id_banca')), 
                    'id_entitate' => $id_entitate,
                    'sucursala' => Input::get('sucursala'), 
                    'iban' => Input::get('iban')));
            }
            catch(Exception $e) {
                return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
            }
            return Redirect::route('banci_list_entitate', [$id_entitate, $entitate]);
        }
    }	

    public function getEditBancaEntitate($id, $id_entitate, $entitate)
    {
        $banca_class = new BancaController;
        $banci = $banca_class->getBanciOrganizatie();

    	$banca = DB::select("SELECT
            id,
            id_banca,
            iban,     
            sucursala
            FROM banca_entitate
			WHERE id = :id", array('id' => $id));
		return View::make("banca::banca_entitate.edit")
			->with("banca", $banca[0])
            ->with("banci", $banci)
            ->with("id_entitate", $id_entitate)
            ->with("entitate", $entitate);	
    }

    public function postEditBancaEntitate($id, $id_entitate, $entitate) {
        $rules = array(
            'id_banca' => 'required');
        $errors = array('required' => 'Campul este obligatoriu.');
        
        $validator = Validator::make(Input::all(), $rules, $errors);
        if ($validator->fails()) {
            return Redirect::back()->with('message', 'Eroare validare formular!')->withErrors($validator)->withInput();
        } 
        else {
            try {
                DB::table('banca_entitate')
                    ->where('id', $id)
                    ->update(array(
                    'id_banca' => intval(Input::get('id_banca')), 
                    'sucursala' => Input::get('sucursala'), 
                    'iban' => Input::get('iban')));
            }
            catch(Exception $e) {
                return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
            }
            return Redirect::route('banci_list_entitate', [$id_entitate, $entitate]);
        }
    }

    public function postDeleteBancaEntitate() {
        if (Request::ajax()) {
            if (Session::token() === Input::get('_token')) {
                $id = Input::get('id');
                DB::table('banca_entitate')->where('id', $id)->update(array('logical_delete' => 1));
                return $id;
            }
        }
    }
}