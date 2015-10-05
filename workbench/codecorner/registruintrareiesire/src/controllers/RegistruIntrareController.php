<?php namespace Codecorner\Registruintrareiesire\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class RegistruIntrareController extends \BaseController
{    
    public function getIntrari()
    {
        $intrari = DB::select("SELECT
                numar_inregistrare,
                created_at AS data_inregistrare,
                expeditor,
                numar_inregistrare_expeditor,
                numar_anexe,
                continut,
                destinatar,
                observatii
                FROM registru_intrare
                WHERE logical_delete = 0
                ORDER BY numar_inregistrare DESC");
        
        return View::make('registruintrareiesire::registru_intrare.list')->with('intrari', $intrari);
    }

    public function getAddIntrare()
    {
        return View::make('registruintrareiesire::registru_intrare.add');
    }

    public function postAddIntrare()
    {
        $rules  = array(
            'expeditor' => 'required',
            'destinatar' => 'required'
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
            DB::beginTransaction();
            try
            {
                $numar_inregistrare           = DB::table('registru_intrare')->select(DB::raw('max(numar_inregistrare) AS numar_inregistrare'))->where('logical_delete', 0)->get();
                $urmatorul_numar_inregistrare = 0;
                if ($numar_inregistrare[0]->numar_inregistrare > 0)
                    $urmatorul_numar_inregistrare = $numar_inregistrare[0]->numar_inregistrare;
                $urmatorul_numar_inregistrare++;
                
                DB::table('registru_intrare')->insertGetId(array(
                    'numar_inregistrare' => $urmatorul_numar_inregistrare,
                    'expeditor' => Input::get('expeditor'),
                    'numar_inregistrare_expeditor' => Input::get('numar_inregistrare_expeditor'),
                    'numar_anexe' => Input::get('numar_anexe'),
                    'continut' => Input::get('continut'),
                    'destinatar' => Input::get('destinatar'),
                    'observatii' => Input::get('observatii')
                ));
            }
            catch (Exception $e)
            {
                DB::rollback();
                return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
            }
            DB::commit();
            return Redirect::back()->with('message', 'Salvare realizata cu succes!');
        }
    }
}
