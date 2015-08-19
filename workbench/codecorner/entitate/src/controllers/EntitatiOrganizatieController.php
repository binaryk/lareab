<?php namespace Codecorner\Entitate\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;


class EntitatiOrganizatieController extends \BaseController
{   
    public function getEntitati($tip_entitate)
    {        
        $sql = "SELECT 
            ent.id, 
            ent.denumire, 
            ent.cif,
            ent.adresa, 
            ent.cod_postal, 
            ent.telefon, 
            ent.fax, 
            ent.id_organizatie, 
            ent.id_tip_entitate,             
            judet.denumire AS judet, 
            loc.denumire AS localitate
            FROM entitate ent
            LEFT OUTER JOIN judet ON ent.id_judet = judet.id_judet AND judet.logical_delete = 0 
            LEFT OUTER JOIN localitate loc ON ent.id_localitate = loc.id_localitate AND loc.logical_delete = 0";

        $and = "";
        if (\Entrust::hasRole("Administrator de grup"))
        {
            $and = " AND ent.id_organizatie = " . \Entrust::user()->id_org;
        }
        else if (!\Entrust::can("administrare_platforma"))
        {
            $ids = self::getIDsDepartamente(\Confide::getDepartamenteUser());
            $sql = $sql . 
                " INNER JOIN departament d ON d.id_entitate = ent.id AND d.logical_delete = 0" .
                " AND d.id IN (" . $ids . ")";
        }
        $sql .= " WHERE ent.logical_delete = 0 ";
        $sql .= $and;

        if ($tip_entitate == 1)
            $sql .= " AND ent.id_tip_entitate = 1 ";
        else
            $sql .= " AND ent.id_tip_entitate = 2 ";
        $sql .= " GROUP BY ent.id";

        $entitati = DB::select($sql);
        //dd($sql);        
        return View::make('entitate::entitati_organizatie.list')
            ->with('entitati', $entitati)
            ->with('tip_entitate', $tip_entitate);
    }


    public function getAddEntitate($tip_entitate)
    {       
        $tip_intreprindere = self::getTipIntreprindere();
        $marime_intreprindere = self::getMarimeIntreprindere();
        return View::make('entitate::entitati_organizatie.add')
            ->with('tip_intreprindere', $tip_intreprindere)
            ->with('marime_intreprindere', $marime_intreprindere)
            ->with('tip_entitate', $tip_entitate);
    }

    public function postAddEntitate($tip_entitate)
    {
        $rules  = array(
            'denumire' => 'required',
            'num_ord_rc' => 'required',
            'an_infiintare' => 'integer'
        );
        $errors = array(
            'required' => 'Campul este obligatoriu.',
            'integer' => 'Anul infintarii nu este corect'            
        );

        $capital_social = self::text_2_number(Input::get('capital_social'));
        $procent_cs_pf = self::text_2_number(Input::get('procent_cs_pf'));
        $procent_cs_imm = self::text_2_number(Input::get('procent_cs_imm'));
        $procent_cs_scm = self::text_2_number(Input::get('procent_cs_scm'));

        $validator = Validator::make(Input::all(), $rules, $errors);
        if ($validator->fails())
        {
            return Redirect::back()->with('message', 'Eroare validare formular!')->withErrors($validator)->withInput();
        }
        else
        {
            try
            {
                DB::table('entitate')->insertGetId(array(
                    'denumire' => Input::get('denumire'),
                    'cif' => Input::get('cif'),
                    'norc' => Input::get('num_ord_rc'),
                    'id_tara' => intval(Input::get('tara')),
                    'id_regiune' => intval(Input::get('regiune')),
                    'id_judet' => intval(Input::get('judet')),
                    'id_localitate' => intval(Input::get('localitate')),
                    'adresa' => Input::get('adresa'),
                    'cod_postal' => Input::get('cod_postal'),
                    'telefon' => Input::get('telefon'),
                    'fax' => Input::get('fax'),
                    'servicii' => (Input::get('servicii')===null)?false:true,
                    'lucrari' => (Input::get('lucrari')===null)?false:true,
                    'furnizare' => (Input::get('furnizare')===null)?false:true,
                    'id_organizatie' => intval(self::organizatie()[0]->id_organizatie),
                    'id_tip_entitate' => $tip_entitate,
                    'id_tip_intreprindere' => intval(Input::get('tip_intreprindere')),
                    'id_marime_intreprindere' => intval(Input::get('tip_intreprindere')),
                    'capital_social' => $capital_social,
                    'procent_cs_pf' => $procent_cs_pf,
                    'procent_cs_imm' => $procent_cs_imm,
                    'procent_cs_scm' => $procent_cs_scm,
                    'platitor_tva' => (Input::get('platitor_tva')===null)?false:true,
                    'an_infiintare' => intval(Input::get('an_infiintare')),
                ));
            }
            catch (Exception $e)
            {       
                return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
            }            
            return Redirect::route('entitati_organizatie_list', $tip_entitate);
        }
    }

    public function getEditEntitate($id, $tip_entitate)
    {               
        $entitate = DB::select("SELECT 
            ent.id, 
            ent.denumire, 
            ent.cif,
            ent.norc,
            ent.adresa, 
            ent.cod_postal, 
            ent.telefon, 
            ent.fax, 
            ent.id_tara,
            ent.id_regiune,
            ent.id_judet,            
            ent.id_localitate, 
            ent.id_tip_entitate, 
            ent.servicii,
            ent.lucrari,
            ent.furnizare,
            ent.id_tip_intreprindere,
            ent.id_marime_intreprindere,
            ent.capital_social,
            ent.procent_cs_pf,
            ent.procent_cs_imm,
            ent.procent_cs_scm,
            ent.platitor_tva,
            ent.an_infiintare,
            tara.denumire AS tara,
            regiune.denumire AS regiune,
            judet.denumire AS judet, 
            loc.denumire AS localitate
            FROM entitate ent
            LEFT OUTER JOIN tara ON ent.id_tara = tara.id_tara AND tara.logical_delete = 0 
            LEFT OUTER JOIN regiune ON ent.id_regiune = regiune.id_regiune AND regiune.logical_delete = 0 
            LEFT OUTER JOIN judet ON ent.id_judet = judet.id_judet AND judet.logical_delete = 0 
            LEFT OUTER JOIN localitate loc ON ent.id_localitate = loc.id_localitate AND loc.logical_delete = 0
            WHERE ent.logical_delete = 0  AND  ent.id_tip_entitate = 1      
            AND ent.id = :id",
            array('id' => $id));
        $entitate = $entitate[0];
        $tip_intreprindere = self::getTipIntreprindere();
        $marime_intreprindere = self::getMarimeIntreprindere();   
        $informatii_statistice = new InformatiiStatisticeController;

        $informatii_statistice = $informatii_statistice->getISEntitate($id, $entitate->denumire);        
        return View::make('entitate::entitati_organizatie.edit')
            ->with('entitate', $entitate)
            ->with('tip_intreprindere', $tip_intreprindere)
            ->with('marime_intreprindere', $marime_intreprindere)
            ->with('informatii_statistice', $informatii_statistice)
            ->with('tip_entitate', $tip_entitate);
    }

    public function postEditEntitate($id, $tip_entitate)
    {
        //dd($tip_entitate);
        $rules  = array(
            'denumire' => 'required',
            'num_ord_rc' => 'required',
            'an_infiintare' => 'integer'
        );
        $errors = array(
            'required' => 'Campul este obligatoriu.',
            'integer' => 'Anul infintarii nu este corect'
        );

        $capital_social = self::text_2_number(Input::get('capital_social'));
        $procent_cs_pf = self::text_2_number(Input::get('procent_cs_pf'));
        $procent_cs_imm = self::text_2_number(Input::get('procent_cs_imm'));
        $procent_cs_scm = self::text_2_number(Input::get('procent_cs_scm'));
        
        $validator = Validator::make(Input::all(), $rules, $errors);
        if ($validator->fails())
        {
            return Redirect::back()->with('message', 'Eroare validare formular!')->withErrors($validator)->withInput();
        }
        try
        {           
            //Debugbar::info('CP='.Input::get('cod_postal'));
            DB::table('entitate')
                ->where('id', $id)
                ->update(array(                    
                    'denumire' => Input::get('denumire'),
                    'cif' => Input::get('cif'),
                    'norc' => Input::get('num_ord_rc'),
                    'id_tara' => intval(Input::get('tara')),
                    'id_regiune' => intval(Input::get('regiune')),
                    'id_judet' => intval(Input::get('judet')),
                    'id_localitate' => intval(Input::get('localitate')),
                    'adresa' => Input::get('adresa'),
                    'cod_postal' => Input::get('cod_postal'),
                    'telefon' => Input::get('telefon'),
                    'fax' => Input::get('fax'),
                    'servicii' => (Input::get('servicii') === '1')?true:false,
                    'lucrari' => (Input::get('lucrari') === '1')?true:false,
                    'furnizare' => (Input::get('furnizare') === '1')?true:false,
                    'id_organizatie' => intval(self::organizatie()[0]->id_organizatie),
                    'id_tip_entitate' => $tip_entitate, 
                    'id_tip_intreprindere' => intval(Input::get('tip_intreprindere')),
                    'id_marime_intreprindere' => intval(Input::get('tip_intreprindere')),
                    'capital_social' => $capital_social,
                    'procent_cs_pf' => $procent_cs_pf,
                    'procent_cs_imm' => $procent_cs_imm,
                    'procent_cs_scm' => $procent_cs_scm,
                    'platitor_tva' => (Input::get('platitor_tva')===null)?false:true,                                          
                    'an_infiintare' => intval(Input::get('an_infiintare')),
                ));
        }
        catch (Exception $e)
        {       
            return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
        }            
        return Redirect::back()->with('message', 'Salvare realizata cu succes!')->withInput();        
    }

    public function postDeleteEntitate()
    {        
        if(Request::ajax()) {
            if( Session::token() === Input::get( '_token' ) ) {
                $id = Input::get('id');
                DB::table('entitate')->where('id', $id)->update(array(
                    'logical_delete' => 1));
                return $id;
            }
        }
    }
}