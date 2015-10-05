<?php namespace Codecorner\Entitate\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class DepartamentController extends \BaseController
{
    public function getDepartamenteEntitate($id_entitate, $entitate) {
        $departamente = DB::select("SELECT 
            departament.id,
            departament.denumire,
            departament.descriere,
            entitate.denumire AS entitate
            FROM departament
            LEFT OUTER JOIN entitate 
                ON entitate.id = departament.id_entitate 
                AND entitate.logical_delete = 0                       
            WHERE departament.logical_delete = 0
            AND departament.id_entitate = :id_entitate", array('id_entitate' => $id_entitate));
        return View::make('entitate::departament.list')
			->with('departamente', $departamente)
			->with('entitate', $entitate)
			->with('id_entitate', $id_entitate);            
    }
    
    public function getDepartamenteOrganizatie() {
        $sql = "SELECT 
            departament.id,
            departament.denumire,
            departament.descriere,
            entitate.denumire AS entitate
            FROM departament
            INNER JOIN entitate 
                ON entitate.id = departament.id_entitate 
                AND entitate.logical_delete = 0";
        $departamente = [];
        if (\Entrust::can('list_departament'))
        {
            $sql = $sql . " AND entitate.id_organizatie = :id_organizatie WHERE departament.logical_delete = 0";  
            $departamente = DB::select($sql, array('id_organizatie' => isset(self::organizatie()[0])?self::organizatie()[0]->id_organizatie:-1));
        }
        else if (\Entrust::can('administrare_platforma'))
        {
            $sql = $sql . " WHERE departament.logical_delete = 0";
            $departamente = DB::select($sql);
        }       
        return View::make('entitate::departament.list')->with('departamente', $departamente);
    }
    
    public function getAddDepartamentOrganizatie() {
        return View::make('entitate::departament.add')
            ->with('entitati', self::getEntitati());
    }
    
    public function getAddDepartamentEntitate($id_entitate, $denumire) {
        return View::make('entitate::departament.add')
            ->with('id_entitate', $id_entitate)
            ->with('denumire', $denumire)
            ->with('entitati', self::getEntitati());
    }
    
    public function postAddDepartament() {
        $arr_selected = explode(',', Input::get('selected_rows'));
        $rules = array(
            'denumire' => 'required', 
            'entitate' => 'required|integer|min:1');
        $errors = array('required' => 'Campul este obligatoriu.', 'min' => 'Selectioneaza cel putin o entitate.');
        
        $validator = Validator::make(Input::all(), $rules, $errors);
        if ($validator->fails()) {
            return Redirect::back()
                ->with('error', 'Eroare validare formular!')
                ->withErrors($validator)
                ->withInput()
                ->with($errors)
                ->with('arr_selected', $arr_selected);                
        } 
        else {
            if (count($arr_selected) === 0)
                return Redirect::back()
                    ->with('error', 'Eroare salvare date. Trebuie selectionata cel putin o entitate!')
                    ->withInput();                    
            
            DB::beginTransaction();
            try {                
                $ok = false;
                foreach ($arr_selected as $value) {
                    //var_dump('Val='.$value);
                    $exist_dep = DB::select('SELECT 
                        id 
                        FROM departament 
                        WHERE id_entitate = :id_entitate
                        AND denumire = :denumire', array('id_entitate' => $value, 'denumire' => Input::get('denumire')));
                    //var_dump("CNT=".count($exist_dep));                    
                    if (count($exist_dep) == 0) 
                    {                       
                        $id = DB::table('departament')->insertGetId(array(
                            'denumire' => Input::get('denumire'), 
                            'descriere' => Input::get('descriere'),
                            'id_entitate' => $value));
                        if ($id > 0) 
                            $ok = true;
                        else
                        {
                            $ok = false;
                            break;
                        }
                    }                    
                }

                /*dd(Input::get('selected_rows'));
                DB::table('departament')->insertGetId(array(
                    'denumire' => Input::get('denumire'), 
                    'descriere' => Input::get('descriere'),
                    'id_entitate' => Input::get('entitate')));*/
            }
            catch(Exception $e) {
                DB::rollback();
                return Redirect::back()
                    ->with('error', 'Eroare salvare date: ' . $e)
                    ->withInput()
                    ->with('arr_selected', $arr_selected);
            }
            if ($ok)
            {
                DB::commit();
                return Redirect::back()
                    ->with('success', 'Salvare realizata cu succes!')
                    ->withInput()
                    ->with('arr_selected', $arr_selected);
            }
            else
            {
                DB::rollback();
                return Redirect::back()
                    ->with('error', 'Eroare salvare entitati.')
                    ->withInput()
                    ->with('arr_selected', $arr_selected);
            }            
        }
    }
    
    public function getEditDepartament($id_departament) {
        $departament = DB::select("SELECT 
            id,
            denumire,
            descriere,
            id_entitate            
            FROM departament                       
            WHERE logical_delete = 0
            AND id = :id_departament", array('id_departament' => $id_departament));
        return View::make('entitate::departament.edit')
            ->with('departament', $departament[0])
            ->with('entitati', self::getEntitati());
    }
    
    public function postEditDepartament($id_departament) {
        $rules = array('denumire' => 'required');
        $errors = array('required' => 'Campul este obligatoriu.');
        
        $validator = Validator::make(Input::all(), $rules, $errors);
        if ($validator->fails()) {
            return Redirect::back()->with('error', 'Eroare validare formular!')->withErrors($validator)->withInput();
        }
        try {
            DB::table('departament')
                ->where('id', $id_departament)
                ->update(array(
                    'denumire' => Input::get('denumire'),
                    'descriere' => Input::get('descriere'),
                    'id_entitate' => intval(Input::get('entitate'))
                    ));
        }
        catch(Exception $e) {
            return Redirect::back()->with('error', 'Eroare salvare date: ' . $e)->withInput();
        }
        return Redirect::back()->with('success', 'Salvare realizata cu succes!')->withInput();
    }
    
    public function postDeleteDepartament() {
        if (Request::ajax()) {
            if (Session::token() === Input::get('_token')) {
                $id = Input::get('id');
                DB::table('departament')->where('id', $id)->update(array('logical_delete' => 1));
                return $id;
            }
        }
    }

    public function getEntitati()
    {
        $sql = "SELECT
            denumire, id
            FROM entitate
            WHERE logical_delete = 0";
        $departamente = [];
        if (\Entrust::can('list_departament'))
        {
            $sql = $sql . " AND entitate.id_organizatie = :id_organizatie";  
            $departamente = DB::select($sql, array('id_organizatie' => isset(self::organizatie()[0])?self::organizatie()[0]->id_organizatie:-1));
            return self::object_to_array($departamente);
        }
        else if (\Entrust::can('administrare_platforma'))
        {
            $departamente = DB::select($sql);
            return self::object_to_array($departamente);
        }
        return $departamente;
    }
}
