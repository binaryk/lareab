<?php namespace Codecorner\Entitate\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class InformatiiStatisticeController extends \BaseController
{
	public function getISEntitate($id_entitate, $entitate, $with_view = false)
	{
		//dd($id_entitate . '---' . $entitate . '---' . $with_view);
		$informatii_statistice = DB::select("SELECT
			id,
			an,
			num_angajati,
			cifra_afaceri,
			profit_exploatare,
			venituri,
			active_totale,
			cheltuieli_cercetare
			FROM informatii_statistice_entitate
			WHERE logical_delete = 0
			AND id_entitate = :id", array('id' => $id_entitate));

		if ($with_view)
		{
			return View::make('entitate::informatii_statistice.list', 
				compact('informatii_statistice', 'id_entitate', 'entitate'));			
		}
		return $informatii_statistice;
	}

	public function getAddIS($id_entitate, $entitate)
	{
		//dd($id_entitate . "---" . $entitate);
		return View::make('entitate::informatii_statistice.add', compact('id_entitate', 'entitate'));
	}

	public function postAddIS($id_entitate, $entitate)
	{
       $rules  = array(
            'an' => 'required|integer|min:1900|max:2050',
        );
        $errors = array(
            'required' => 'Campul este obligatoriu.',
            'min' => 'Anul minim este 1900',            
            'max' => 'Anul maxim este 2050'
        );
		
		$cifra_afaceri = self::text_2_number(Input::get('cifra_afaceri'));
		$profit_exploatare = self::text_2_number(Input::get('profit_exploatare'));
		$venituri = self::text_2_number(Input::get('venituri'));
		$active_totale = self::text_2_number(Input::get('active_totale'));
		$cheltuieli_cercetare = self::text_2_number(Input::get('cheltuieli_cercetare'));

        $validator = Validator::make(Input::all(), $rules, $errors);
        if ($validator->fails())
        {
            return Redirect::back()->with('message', 'Eroare validare formular!')->withErrors($validator)->withInput();
        }
        else
        {
            try
            {
                DB::table('informatii_statistice_entitate')->insertGetId(array(
                    'an' => intval(Input::get('an')),
                    'num_angajati' => intval(Input::get('numar_angajati')),
                    'cifra_afaceri' => $cifra_afaceri,
                    'profit_exploatare' => $profit_exploatare,
                    'venituri' => $venituri,
                    'active_totale' => $active_totale,
                    'cheltuieli_cercetare' => $cheltuieli_cercetare,
                    'id_entitate' => $id_entitate,
                ));
            }
            catch (Exception $e)
            {       
                return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
            }            
            return Redirect::route('informatii_statistice_list', [$id_entitate, $entitate, true]);
        }		
	}

	public function getEditIS($id, $id_entitate, $entitate)
	{
		$informatii_statistice = DB::select("SELECT
			id,
			an,
			num_angajati,
			cifra_afaceri,
			profit_exploatare,
			venituri,
			active_totale,
			cheltuieli_cercetare
			FROM informatii_statistice_entitate
			WHERE logical_delete = 0
			AND id = :id", array('id' => $id));
		$informatii_statistice = $informatii_statistice[0];
		return View::make('entitate::informatii_statistice.edit', 
			compact('informatii_statistice', 'id_entitate', 'entitate'));
	}

	public function postEditIS($id, $id_entitate, $entitate)
	{
       $rules  = array(
            'an' => 'required|integer|min:1900|max:2050',
        );
        $errors = array(
            'required' => 'Campul este obligatoriu.',
            'min' => 'Anul minim este 1900',            
            'max' => 'Anul maxim este 2050'
        );
		
		$cifra_afaceri = self::text_2_number(Input::get('cifra_afaceri'));
		$profit_exploatare = self::text_2_number(Input::get('profit_exploatare'));
		$venituri = self::text_2_number(Input::get('venituri'));
		$active_totale = self::text_2_number(Input::get('active_totale'));
		$cheltuieli_cercetare = self::text_2_number(Input::get('cheltuieli_cercetare'));

        $validator = Validator::make(Input::all(), $rules, $errors);
        if ($validator->fails())
        {
            return Redirect::back()->with('message', 'Eroare validare formular!')->withErrors($validator)->withInput();
        }
        else
        {
            try
            {
                DB::table('informatii_statistice_entitate')
                	->where('id', $id)
                	->update(array(
	                    'an' => intval(Input::get('an')),
	                    'num_angajati' => intval(Input::get('numar_angajati')),
	                    'cifra_afaceri' => $cifra_afaceri,
	                    'profit_exploatare' => $profit_exploatare,
	                    'venituri' => $venituri,
	                    'active_totale' => $active_totale,
	                    'cheltuieli_cercetare' => $cheltuieli_cercetare,
	                    'id_entitate' => $id_entitate,
                ));
            }
            catch (Exception $e)
            {       
                return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
            }            
            return Redirect::route('informatii_statistice_list', [$id_entitate, $entitate, true]);
        }		
	}
}
?>