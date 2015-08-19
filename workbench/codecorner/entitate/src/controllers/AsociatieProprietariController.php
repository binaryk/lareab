<?php namespace Codecorner\Entitate\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class AsociatieProprietariController extends \BaseController
{
	public function getAP()
    {
        $asociatii = DB::select("SELECT
            ap.id,
            ap.denumire,
            ap.strada,
            ap.numar,
            ap.bloc,
            ap.scara,
            judet.denumire AS judet,
            loc.denumire as localitate
            FROM asociatie_proprietari ap
            LEFT OUTER JOIN judet ON judet.id_judet = ap.id_judet AND judet.logical_delete = 0
            LEFT OUTER JOIN v_localitate_descriere loc ON loc.id_localitate = ap.id_localitate
            WHERE ap.id_organizatie = :id_organizatie", array('id_organizatie' => isset(self::organizatie()[0])?self::organizatie()[0]->id_organizatie:-1));
        return $asociatii;
    }
    
    public function getAPbyID($id_asociatie)
    {
        $asociatie = DB::select("SELECT
            id,
            concat (denumire,' (',strada,', Nr.',numar,', Bloc: ',bloc, ')') AS denumire
            FROM asociatie_proprietari ap
            WHERE ap.id = :id_asociatie", array('id_asociatie' => $id_asociatie));
        return $asociatie[0];
    }

    //Returneaza asociatiile de proprietari din judetul din care face parte imobilul
    public function getAPJudetImobil($id_imobil)
    {
        $asociatii = DB::select("SELECT
            ap.id,
            concat (ap.denumire,' (',ap.strada,', Nr.',ap.numar,', Bloc: ',ap.bloc, ')') AS denumire
            FROM asociatie_proprietari ap
            INNER JOIN imobil ON imobil.id_judet = ap.id_judet 
            AND imobil.logical_delete = 0
            AND imobil.id = :id_imobil", array('id_imobil' => $id_imobil));
        return self::object_to_array($asociatii);
    }

    public function getAP_VariantaRedusa()
    {
        $asociatii = DB::table('asociatie_proprietari')
            ->where('logical_delete', 0)            
            ->select(DB::raw('concat (denumire," (",strada,", Nr.",numar,", Bloc: ",bloc, ")") as denumire,id'))
            ->lists('denumire', 'id');
        return $asociatii;
    }

    public function getAsociatiiProprietari()
	{
        $asociatii = self::getAP();
		return View::make('entitate::asociatie_proprietari.list')
            ->with('asociatii', $asociatii);  						
	}
	
	public function getEditAsociatieProprietari($id)
	{
		$asociatie = DB::select("SELECT
			ap.id,
			ap.denumire,
			ap.cif,
			ap.strada,
			ap.numar,
			ap.bloc,
			ap.scara,
			ap.apartament,
			ap.id_tara,
			ap.id_regiune,
			ap.id_judet,
			ap.id_localitate,
			ap.cod_postal,
			ap.telefon1,
			ap.telefon2,
			ap.fax1,
			ap.fax2,
			ap.email1,
			ap.email2,
       		tara.denumire AS tara,
            regiune.denumire AS regiune,
            judet.denumire AS judet,
            loc.denumire AS localitate			
			FROM asociatie_proprietari ap
          	LEFT OUTER JOIN tara ON ap.id_tara = tara.id_tara AND tara.logical_delete = 0
            LEFT OUTER JOIN regiune ON ap.id_regiune = regiune.id_regiune AND regiune.logical_delete = 0
            LEFT OUTER JOIN judet ON ap.id_judet = judet.id_judet AND judet.logical_delete = 0
            LEFT OUTER JOIN localitate loc ON ap.id_localitate = loc.id_localitate AND loc.logical_delete = 0

			WHERE id = :id", array('id' => $id));
		return View::make('entitate::asociatie_proprietari.edit')
			->with('asociatie_proprietari', $asociatie[0]);
	}

	public function postEditAsociatieProprietari($id)
    {
        $rules  = array(
            'denumire' => 'required',
            'cif' => 'required',
            'localitate' => 'required'
            );
        $errors = array(
            'required' => 'Campul este obligatoriu.'
        );
        
        $validator = Validator::make(Input::all(), $rules, $errors);
        if ($validator->fails())
        {
            return Redirect::back()->with('message', 'Eroare validare formular!')->withErrors($validator)->withInput();
        }
        else
        {
            try
            {
                DB::table('asociatie_proprietari')
                	->where('id', $id)
                	->update(array(
                    'denumire' => Input::get('denumire'),
                    'cif' => Input::get('cif'),
                    'strada' => Input::get('strada'),
                    'numar' => Input::get('numar'),
                    'bloc' => Input::get('bloc'),
                    'scara' => Input::get('scara'),
                    'apartament' => Input::get('apartament'),
                    'id_tara' => intval(Input::get('tara')),
                    'id_regiune' => intval(Input::get('regiune')),
                    'id_judet' => intval(Input::get('judet')),
                    'id_localitate' => intval(Input::get('localitate')),                    
                    'cod_postal' => Input::get('cod_postal'),
                    'telefon1' => Input::get('telefon1'),
                    'fax1' => Input::get('fax1'),
                    'email1' => Input::get('email1'),
                    'telefon2' => Input::get('telefon2'),
                    'fax2' => Input::get('fax2'),
                    'email2' => Input::get('email2'),
                    'id_organizatie' => intval(self::organizatie()[0]->id_organizatie)
                    ));
            }
            catch (Exception $e)
            {       
                return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
            }            
            return Redirect::route('asociatii_proprietari_list');
        }
    }

	public function getAddAsociatieProprietari()
	{
		return View::make('entitate::asociatie_proprietari.add');
	}

	public function postAddAsociatieProprietari()
    {
        $rules  = array(
            'denumire' => 'required',
            'cif' => 'required',
            'localitate' => 'required'
            );
        $errors = array(
            'required' => 'Campul este obligatoriu.'
        );
        
        $validator = Validator::make(Input::all(), $rules, $errors);
        if ($validator->fails())
        {
            return Redirect::back()->with('message', 'Eroare validare formular!')->withErrors($validator)->withInput();
        }
        else
        {
            try
            {
                DB::table('asociatie_proprietari')->insertGetId(array(
                    'denumire' => Input::get('denumire'),
                    'cif' => Input::get('cif'),
                    'strada' => Input::get('strada'),
                    'numar' => Input::get('numar'),
                    'bloc' => Input::get('bloc'),
                    'scara' => Input::get('scara'),
                    'apartament' => Input::get('apartament'),
                    'id_tara' => intval(Input::get('tara')),
                    'id_regiune' => intval(Input::get('regiune')),
                    'id_judet' => intval(Input::get('judet')),
                    'id_localitate' => intval(Input::get('localitate')),                    
                    'cod_postal' => Input::get('cod_postal'),
                    'telefon1' => Input::get('telefon1'),
                    'fax1' => Input::get('fax1'),
                    'email1' => Input::get('email1'),
                    'telefon2' => Input::get('telefon2'),
                    'fax2' => Input::get('fax2'),
                    'email2' => Input::get('email2'),
                    'id_organizatie' => intval(self::organizatie()[0]->id_organizatie)
                    ));
            }
            catch (Exception $e)
            {       
                return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
            }            
            return Redirect::route('asociatii_proprietari_list');
        }
    }
}