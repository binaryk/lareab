<?php namespace Codecorner\Imobil\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class LocatarController extends \BaseController
{
    public function getLocatariImobil($id_imobil)
    {        
        $im = new \Codecorner\Imobil\Controllers\ImobileController();
        $imobil = $im->getImobil($id_imobil);

        $suprafata_utila_imobil = self::getSuprafataUtilaImobil($id_imobil, $imobil[0]->numar_apartamente);

        $locatari = self::getLocatariImobilASObject($id_imobil);
               
        return View::make('imobil::locatari.list_rezumat')
            ->with('locatari', $locatari)
            ->with('suprafata_utila_imobil', $suprafata_utila_imobil)
            ->with('imobil', $imobil[0]);
    }

    function getSuprafataUtilaImobil($id_imobil, $numar_apartamente)
    {
        $suprafata_utila_imobil = DB::select("SELECT 
                SUM(suprafata_utila) AS su,
                COUNT(*) AS num_locatari
                FROM locatari_imobil li 
                WHERE li.logical_delete = 0 
                AND li.id_imobil = :id_imobil", array('id_imobil' => $id_imobil));
        
        $num_locatari = 0; //Cati locatari (inregistrari) un fost introdusi?
        if(count($suprafata_utila_imobil) > 0) 
        {
            $num_locatari = intval($suprafata_utila_imobil[0]->num_locatari);
            if (($num_locatari == intval($numar_apartamente)) && ($num_locatari > 0))
                $suprafata_utila_imobil = doubleval($suprafata_utila_imobil[0]->su);
            else
                $suprafata_utila_imobil = 0;
        }
        else
            $suprafata_utila_imobil = 0;        
        return $suprafata_utila_imobil;      
    }

    function getLocatariImobilASObject($id_imobil)
    {
        $locatari = DB::select("SELECT
            locatar.id,
            locatar.nr_apartament,
            scara.scara,
            locatar.nume,
            locatar.etaj,
            locatar.suprafata_utila,
            locatar.cota_parte,
            locatar.nr_membri_familie,
            locatar.nr_cadastral,
            locatar.asteapta_verificare,
            locatar.id_acord,
            destinatie_spatiu.denumire AS destinatie_spatiu,
            destinatie_spatiu.id AS id_destinatie_spatiu,            
            ven.id AS id_venit_lunar,
            ven.denumire AS venit_lunar

            FROM locatari_imobil locatar
            LEFT OUTER JOIN scara_imobil scara ON scara.id = locatar.id_scara AND scara.logical_delete = 0
            LEFT OUTER JOIN destinatie_spatiu ON destinatie_spatiu.id = locatar.id_destinatie_spatiu AND destinatie_spatiu.logical_delete = 0
            LEFT OUTER JOIN venit_lunar_locatar ven ON ven.id = locatar.id_venit_lunar AND ven.logical_delete = 0
            WHERE locatar.logical_delete = 0
            AND locatar.id_imobil = :id_imobil", array('id_imobil' => $id_imobil));
        return $locatari;
    }


	public function getEditLocatar($id_locatar, $id_imobil)
	{
        $locatar = DB::select("SELECT
            li.id,
            li.nr_apartament,
            li.nume,
            li.etaj,
            li.suprafata_utila,
            li.cota_parte,
            li.nr_membri_familie,
            li.nr_cadastral,
            li.id_destinatie_spatiu,
            li.id_scara,
            li.id_acord,
            li.id_venit_lunar,
            li.asteapta_verificare

            FROM locatari_imobil li            
            WHERE li.id = :id_locatar", array('id_locatar' => $id_locatar));
        $locatar = $locatar[0];

        $dest_sp = self::getDestinatieSpatiu();
        $acord_locatar = self::getAcordLocatar();
        $venit_lunar_locatar = self::getVenitLocatar();
        
        $sc = new \Codecorner\Imobil\Controllers\ScaraImobilController();
        $scari = $sc->getScariImobil($id_imobil, true);       

        return View::make('imobil::locatari.edit', compact('id_imobil', 'scari', 'dest_sp', 'acord_locatar', 'locatar', 'venit_lunar_locatar'));
	}

	public function postEditLocatar($id, $id_imobil)
    {
        $rules  = array(
            'nume' => 'required',
            'nr_apartament' => 'required',
            'etaj' => 'required',
            'scara' => 'required'
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
            $suprafata_utila = self::text_2_number(Input::get('suprafata_utila'));
            $cota_parte = self::text_2_number(Input::get('cota_parte'));
            /*if (Input::has('suprafata_utila'))
            //if (!empty(Input::get('suprafata_utila')))
            {
                $suprafata_utila = Input::get('suprafata_utila');
                $suprafata_utila = str_replace('.', '', $suprafata_utila);
                $suprafata_utila = str_replace(',', '.', $suprafata_utila);
            }*/

            $id_scara = intval(Input::get('scara'));

            try
            {
                DB::table('locatari_imobil')
                    ->where('id', $id)
                    ->update(array(
                    'nume' => Input::get('nume'),
                    'nr_apartament' => intval(Input::get('nr_apartament')),
                    'etaj' => Input::get('etaj'),
                    'suprafata_utila' => $suprafata_utila,
                    'cota_parte' => $cota_parte,
                    'nr_membri_familie' => intval(Input::get('nr_membri')),
                    'id_destinatie_spatiu' => intval(Input::get('dest_sp')),
                    'id_scara' => $id_scara,
                    'id_imobil' => $id_imobil,
                    'id_acord' => intval(Input::get('acord_locatar')),
                    'id_venit_lunar' => intval(Input::get('id_venit_lunar')),
                    'asteapta_verificare' => (Input::get('asteapta_verificare')===null)?false:true
                    ));
            }
            catch (Exception $e)
            {       
                return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
            }            
            return Redirect::route('locatari_list_imobil', [$id_imobil]);
        }
    }

	public function getAddLocatar($id_imobil)
	{
        $dest_sp = self::getDestinatieSpatiu();
        $acord_locatar = self::getAcordLocatar();
        $venit_lunar_locatar = self::getVenitLocatar();

        $sc = new \Codecorner\Imobil\Controllers\ScaraImobilController();
        $scari = $sc->getScariImobil($id_imobil, true);       

        return View::make('imobil::locatari.add', compact('id_imobil', 'scari', 'dest_sp', 'acord_locatar', 'venit_lunar_locatar'));
	}

	public function postAddLocatar($id_imobil)
    {
        $rules  = array(
            'nume' => 'required',
            'nr_apartament' => 'required',
            'etaj' => 'required',
            'scara' => 'required'
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
            $suprafata_utila = self::text_2_number(Input::get('suprafata_utila'));
            $cota_parte = self::text_2_number(Input::get('cota_parte'));
            
            $id_scara = intval(Input::get('scara'));
                           
            try
            {
                DB::table('locatari_imobil')->insertGetId(array(
                    'nume' => Input::get('nume'),
                    'nr_apartament' => intval(Input::get('nr_apartament')),
                    'etaj' => Input::get('etaj'),
                    'suprafata_utila' => $suprafata_utila,
                    'cota_parte' => $cota_parte,
                    'nr_membri_familie' => intval(Input::get('nr_membri')),
                    'id_destinatie_spatiu' => intval(Input::get('dest_sp')),
                    'id_scara' => $id_scara,
                    'id_imobil' => $id_imobil,
                    'id_acord' => intval(Input::get('acord_locatar')),
                    'id_venit_lunar' => intval(Input::get('id_venit_lunar')),
                    'asteapta_verificare' => (Input::get('asteapta_verificare')===null)?false:true
                    ));
            }
            catch (Exception $e)
            {       
                return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
            }            
            return Redirect::route('locatari_list_imobil', [$id_imobil]);
        }
    }

    public function postDeleteLocatar() {
        if (Request::ajax()) {
            if (Session::token() === Input::get('_token')) {
                $id = Input::get('id');
                DB::table('locatari_imobil')->where('id', $id)->update(array('logical_delete' => 1));
                return $id;
            }
        }
    }        
}