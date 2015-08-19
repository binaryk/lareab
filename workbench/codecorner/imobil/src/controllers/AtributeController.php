<?php namespace Codecorner\Imobil\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class AtributeController extends \BaseController
{
	public function getTipuriAtribute()
	{
        $tipuri_atribute = DB::select("SELECT
            ita.id, ita.denumire,
            (SELECT count(*) FROM imobil_atribute ia WHERE ia.logical_delete = 0 AND ia.id_tip_atribut = ita.id) AS numar_atribute
            FROM imobil_tip_atribute ita
            WHERE ita.logical_delete = 0");
		return View::make('imobil::atribute.list_tip_atribut')
            ->with('tipuri_atribute', $tipuri_atribute); 
	}
	
	public function getEditTipAtribut($id)
	{
		$tip_atribut = DB::select("SELECT
            id,
            denumire
            FROM imobil_tip_atribute
            WHERE id = :id",  array('id' => $id));
		return View::make('imobil::atribute.edit_tip_atribut')
            ->with('tip_atribut', $tip_atribut[0]);
	}

	public function postEditTipAtribut($id)
    {
        $rules  = array(
            'denumire' => 'required'
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
                DB::table('imobil_tip_atribute')
                	->where('id', $id)
                	->update(array(                 
                        'denumire' => Input::get('denumire')
                    ));
            }
            catch (Exception $e)
            {       
                return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
            }            
            return Redirect::route('tipuri_atribute_imobil_list');
        }
    }

	public function getAddTipAtribut()
	{
		return View::make('imobil::atribute.add_tip_atribut');
	}

	public function postAddTipAtribut()
    {
        $rules  = array(
            'denumire' => 'required'
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
                DB::table('imobil_tip_atribute')->insertGetId(array(
                    'denumire' => Input::get('denumire')
                    ));
            }
            catch (Exception $e)
            {       
                return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
            }            
            return Redirect::route('tipuri_atribute_imobil_list');
        }
    }

    public function getAtribute($id_tip_atribut, $tip_atribut)
    {        
        $atribute = DB::select("SELECT
            id, 
            denumire,
            descriere,
            id_tip_atribut
            FROM imobil_atribute            
            WHERE logical_delete = 0
            AND id_tip_atribut = :id_tip_atribut", array('id_tip_atribut' => $id_tip_atribut));

        return View::make('imobil::atribute.list_atribut')
            ->with('atribute', $atribute)
            ->with('id_tip_atribut', $id_tip_atribut)
            ->with('tip_atribut', $tip_atribut); 
    }
    
    public function getAddAtribut($id_tip_atribut, $tip_atribut)
    {
        return View::make('imobil::atribute.add_atribut');
    }    

    public function postAddAtribut($id_tip_atribut, $tip_atribut)
    {
        $rules  = array(
            'denumire' => 'required'
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
                DB::table('imobil_atribute')->insertGetId(array(
                    'denumire' => Input::get('denumire'),
                    'descriere' => Input::get('descriere'),
                    'id_tip_atribut' => $id_tip_atribut
                    ));
            }
            catch (Exception $e)
            {       
                return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
            }            
            return Redirect::route('atribute_imobil_list', [$id_tip_atribut, $tip_atribut]);
        }
    }

    public function getEditAtribut($id, $id_tip_atribut, $tip_atribut)
    {
        $atribut = DB::select("SELECT
            id,
            denumire,
            descriere
            FROM imobil_atribute
            WHERE id = :id",  array('id' => $id));
        return View::make('imobil::atribute.edit_atribut')
            ->with('atribut', $atribut[0]);
    }

    public function postEditAtribut($id, $id_tip_atribut, $tip_atribut)
    {
        $rules  = array(
            'denumire' => 'required'
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
                DB::table('imobil_atribute')
                    ->where('id', $id)
                    ->update(array(                           
                        'denumire' => Input::get('denumire'),              
                        'descriere' => Input::get('descriere')
                    ));
            }
            catch (Exception $e)
            {       
                return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
            }            
            return Redirect::route('atribute_imobil_list', [$id_tip_atribut, $tip_atribut]);
        }
    }
    
    public function postDeleteAtribut() {
        if (Request::ajax()) {
            if (Session::token() === Input::get('_token')) {
                $id = Input::get('id');
                DB::table('imobil_atribute')->where('id', $id)->update(array('logical_delete' => 1));
                return $id;
            }
        }
    }     
    public function postDeleteTipAtribut() {
        if (Request::ajax()) {
            if (Session::token() === Input::get('_token')) {
                $id = Input::get('id');
                DB::table('imobil_tip_atribute')->where('id', $id)->update(array('logical_delete' => 1));
                return $id;
            }
        }
    }       
}