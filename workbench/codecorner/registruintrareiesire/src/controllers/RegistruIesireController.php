<?php namespace Codecorner\Registruintrareiesire\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class RegistruIesireController extends \BaseController
{    
    public function getIesiri()
    {
        $iesiri = DB::select("SELECT
                re.numar_inregistrare,
                re.created_at AS data_inregistrare,
                re.expeditor,
                ri.numar_inregistrare AS numar_inregistrare_intrare,
                re.numar_anexe,
                re.continut,
                re.destinatar,
                re.observatii
                FROM registru_iesire AS re
                LEFT OUTER JOIN registru_intrare AS ri
                    ON re.id_registru_intrare = ri.id_registru
                    AND ri.logical_delete = 0
                WHERE re.logical_delete = 0
                ORDER BY re.numar_inregistrare DESC");
        
        return View::make('registruintrareiesire::registru_iesire.list')->with('iesiri', $iesiri);
    }

    public function getAddIesire()
    {
        $intrari = DB::table('registru_intrare')
            ->where('logical_delete', 0)
            ->select('*')
            ->orderBy('numar_inregistrare')
            ->get();
        return View::make('registruintrareiesire::registru_iesire.add')->with('intrari', $intrari);
    }

    public function postAddIesire()
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
                $numar_inregistrare           = DB::table('registru_iesire')->select(DB::raw('max(numar_inregistrare) AS numar_inregistrare'))->where('logical_delete', 0)->get();
                $urmatorul_numar_inregistrare = 0;
                if ($numar_inregistrare[0]->numar_inregistrare > 0)
                    $urmatorul_numar_inregistrare = $numar_inregistrare[0]->numar_inregistrare;
                $urmatorul_numar_inregistrare++;
                
                DB::table('registru_iesire')->insertGetId(array(
                    'numar_inregistrare' => $urmatorul_numar_inregistrare,
                    'Expeditor' => Input::get('expeditor'),
                    'id_registru_intrare' => Input::get('numar_inregistrare_intrare'),
                    'numar_anexe' => Input::get('numar_anexe'),
                    'numar_anexe' => Input::get('numar_anexe'),
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
            return Redirect::back()->with('message', 'Salvare realizata cu succes!')->withInput();
        }
    }
}