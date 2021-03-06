<?php namespace Codecorner\Entitate\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class ImobileController extends \BaseController
{
	public function getImobile()
	{
        $imobile = DB::select("SELECT
			im.id,
			im.adresa,		
			im.numar_apartamente,
			im.observatii,
			loc.Denumire AS localitate,
            judet.Denumire AS judet,
            regiune.Denumire AS regiune
            FROM imobil im
            LEFT OUTER JOIN tara ON im.id_tara = tara.id_tara AND tara.logical_delete = 0
            LEFT OUTER JOIN judet ON im.id_judet = judet.id_judet AND judet.logical_delete = 0
            LEFT OUTER JOIN localitate loc ON im.id_localitate = loc.id_localitate AND loc.logical_delete = 0
            LEFT OUTER JOIN regiune ON im.id_regiune = regiune.id_regiune AND regiune.logical_delete = 0
			WHERE im.logical_delete = 0");
		return View::make("entitate::imobil.list")
			->with("imobile", $imobile);
	}

    public function getImobileAsociatie($id_asociatie)
    {
        $imobile = DB::select("SELECT
            im.id,
            im.adresa,      
            im.numar_apartamente,
            im.observatii,
            loc.Denumire AS localitate,
            judet.Denumire AS judet,
            regiune.Denumire AS regiune
            FROM imobil im
            INNER JOIN scara_imobil scara ON scara.id_imobil = im.id AND im.logical_delete = 0 AND scara.id_ap = :id_asociatie
            LEFT OUTER JOIN tara ON im.id_tara = tara.id_tara AND tara.logical_delete = 0
            LEFT OUTER JOIN judet ON im.id_judet = judet.id_judet AND judet.logical_delete = 0
            LEFT OUTER JOIN localitate loc ON im.id_localitate = loc.id_localitate AND loc.logical_delete = 0
            LEFT OUTER JOIN regiune ON im.id_regiune = regiune.id_regiune AND regiune.logical_delete = 0
            WHERE im.logical_delete = 0", array('id_asociatie' => $id_asociatie));

        $ap = new AsociatieProprietariController();
        $asociatie = $ap->getAPbyID($id_asociatie);
        return View::make("entitate::imobil.list")
            ->with("imobile", $imobile)
            ->with("asociatie", $asociatie);
    }

	public function getAddImobil()
	{
		return View::make('entitate::imobil.add');
	}
	
	public function postAddImobil() {
        $rules = array(
        	'adresa' => 'required',
        	'regiune' => 'required',
        	'judet' => 'required',
        	'localitate' => 'required');
        $errors = array('required' => 'Campul este obligatoriu.');
        
        $validator = Validator::make(Input::all(), $rules, $errors);
        if ($validator->fails()) {
            return Redirect::back()->with('message', 'Eroare validare formular!')->withErrors($validator)->withInput();
        } 
        else {
            try {
                DB::table('imobil')
                ->insertGetId(array(
                    'adresa' => Input::get('adresa'), 
                    'id_tara' => intval(Input::get('tara')), 
                    'id_regiune' => intval(Input::get('regiune')), 
                    'id_judet' => intval(Input::get('judet')), 
                    'id_localitate' => intval(Input::get('localitate')), 
                    'cod_postal' => Input::get('cod_postal'),                
                    'numar_apartamente' => intval(Input::get('numar_apartamente')), 
                    'observatii' => Input::get('observatii')));
            }
            catch(Exception $e) {
                return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
            }
            return Redirect::route('imobile_list');
        }
    }	

    public function getEditImobil($id)
    {
    	$imobil = DB::select("SELECT
			im.id,
			im.adresa,	
			im.numar_apartamente,
			im.observatii,
			im.id_tara,
			im.id_localitate,
            im.id_judet,
            im.id_regiune,
            im.cod_postal
            FROM imobil im
			WHERE im.id = :id", array('id' => $id));
		return View::make("entitate::imobil.edit")
			->with("imobil", $imobil[0]);	
    }

    public function postEditImobil($id) {
 		$rules = array(
        	'adresa' => 'required',
        	'regiune' => 'required',
        	'judet' => 'required',
        	'localitate' => 'required');
        $errors = array('required' => 'Campul este obligatoriu.');        
        $validator = Validator::make(Input::all(), $rules, $errors);
        if ($validator->fails()) {
            return Redirect::back()->with('message', 'Eroare validare formular!')->withErrors($validator)->withInput();
        }
        try {        
            DB::table('imobil')
                ->where('id', $id)
                ->update(array(
                    'adresa' => Input::get('adresa'), 
                    'id_tara' => intval(Input::get('tara')), 
                    'id_regiune' => intval(Input::get('regiune')), 
                    'id_judet' => intval(Input::get('judet')), 
                    'id_localitate' => intval(Input::get('localitate')), 
                    'cod_postal' => Input::get('cod_postal'),                  
                    'numar_apartamente' => intval(Input::get('numar_apartamente')), 
                    'observatii' => Input::get('observatii')));
        }
        catch(Exception $e) {
            return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
        }
        return Redirect::route('imobile_list');
    }

    public function postDeleteImobil() {
        if (Request::ajax()) {
            if (Session::token() === Input::get('_token')) {
                $id = Input::get('id');
                DB::table('imobil')->where('id', $id)->update(array('logical_delete' => 1));
                return $id;
            }
        }
    }    
}