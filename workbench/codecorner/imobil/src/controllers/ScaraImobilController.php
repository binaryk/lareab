<?php namespace Codecorner\Imobil\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;

class ScaraImobilController extends \BaseController
{
	public function getScari($id_imobil)
	{
        $im = new \Codecorner\Imobil\Controllers\ImobileController();
        $imobil = $im->getImobil($id_imobil);
        $scari = DB::select("SELECT
            scara_imobil.id,
            scara_imobil.scara,
            scara_imobil.observatii,
            scara_imobil.id_imobil,
            scara_imobil.id_ap,
            ap.denumire as ap
            FROM scara_imobil
            LEFT OUTER JOIN asociatie_proprietari ap ON ap.id = scara_imobil.id_ap AND ap.logical_delete = 0
            WHERE scara_imobil.logical_delete = 0
            AND scara_imobil.id_imobil = :id_imobil",  array('id_imobil' => $id_imobil)); 	
		return View::make('imobil::scara_imobil.list')
            ->with('scari', $scari)
            ->with('id_imobil', $id_imobil)
            ->with('imobil', $imobil[0]); 
	}

    public function getScariImobil($id_imobil, $return_array = false)
    {
        $scari = DB::select("SELECT
            id, 
            scara as denumire
            FROM scara_imobil
            WHERE scara_imobil.logical_delete = 0
            AND scara_imobil.id_imobil = :id_imobil",  array('id_imobil' => $id_imobil)); 
        if ($return_array === true)
            return self::object_to_array($scari);      
        else
            return $scari;
    }
	
	public function getEditScara($id, $id_imobil)
	{
        $ap = new \Codecorner\Entitate\Controllers\AsociatieProprietariController();
        $asociatii = $ap->getAPJudetImobil($id_imobil);
		$scara = DB::select("SELECT
            id,
            scara,
            observatii,
            id_imobil,
            id_ap
            FROM scara_imobil
            WHERE id = :id",  array('id' => $id));
		return View::make('imobil::scara_imobil.edit')
            ->with('scara', $scara[0])
			->with('asociatii', $asociatii);
	}

	public function postEditScara($id, $id_imobil)
    {
        $rules  = array(
            'scara' => 'required',
            'asociatie' => 'required|integer|min:0'
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
                DB::table('scara_imobil')
                	->where('id', $id)
                	->update(array(                 
                    'scara' => Input::get('scara'),
                    'observatii' => Input::get('observatii'),
                    'id_ap' => intval(Input::get('asociatie'))
                    ));
            }
            catch (Exception $e)
            {       
                return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
            }            
            return Redirect::route('scari_list', $id_imobil);
        }
    }

	public function getAddScara($id_imobil)
	{
        $ap = new \Codecorner\Entitate\Controllers\AsociatieProprietariController();
        $asociatii = $ap->getAPJudetImobil($id_imobil);             
		return View::make('imobil::scara_imobil.add')
            ->with('asociatii', $asociatii);
	}

	public function postAddScara($id_imobil)
    {           
        $rules  = array(
            'scara' => 'required',
            'asociatie' => 'required|integer|min:0'
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
                DB::table('scara_imobil')->insertGetId(array(
                    'scara' => strtoupper(Input::get('scara')),
                    'observatii' => Input::get('observatii'),
                    'id_ap' => intval(Input::get('asociatie')),
                    'id_imobil' => intval($id_imobil)
                    ));
            }
            catch (Exception $e)
            {       
                return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
            }  
            if (Session::has('callback'))
            {
                return Redirect::away(Session::get('callback'));
            }
            else return Redirect::route('scari_list', $id_imobil);
        }
    }
}