<?php

class InvestitiePORAxa12Controller extends BaseController
{   
    public function getInvestitii()
    {
        $ids = self::getIDsDepartamente(Confide::getDepartamenteUser());
        $sql = "SELECT 
            investitie.id,
            investitie.denumire,
            im.adresa,
            investitie.id_imobil,
            j.denumire AS judet,
            l.denumire AS localitate
            FROM por12_investitie investitie
            INNER JOIN imobil im ON im.id = investitie.id_imobil AND im.logical_delete = 0
            LEFT OUTER JOIN judet j ON j.id_judet = im.id_judet AND j.logical_delete = 0
            LEFT OUTER JOIN localitate l ON l.id_localitate = im.id_localitate AND l.logical_delete = 0"; 
   
        if (!Entrust::can("administrare_platforma"))
        {
            $sql .= " INNER JOIN departament ON departament.id = investitie.id_departament AND departament.logical_delete = 0
                    AND departament.id IN (" . $ids . ") ";
        }
        $sql .= " WHERE investitie.logical_delete = 0";
        
//dd($sql);

        $investitii = DB::select($sql);
        
        return View::make('investitie_por_axa12.list')
            ->with('investitii', $investitii);
    }

    public function getAddInvestitie()
    {     
        $departamente = Confide::getDepartamenteUser();
        $tva = self::getCoteTVA();  
        $imobil_class = new \Codecorner\Imobil\Controllers\ImobileController();             
        $imobile = $imobil_class->getImobil();
        $cheltuieli = self::getCheltuieliSF();

        return View::make('investitie_por_axa12.add')
            ->with('imobile', $imobile)
            ->with('tva', $tva)
            ->with('finantare_nerambursabila_por', 60)
            ->with('cofinantare_ap_neeligibil_ad', 100)
            ->with('departamente', self::object_to_array($departamente))
            ->with('cheltuieli', $cheltuieli); 
    }

    public function postAddInvestitie()
    {
        $rules  = array(
            'id_imobil' => 'required',
            'cota_tva' => 'required',
            'denumire' => 'required',
            'cota_indiviza_spatii_locuit' => 'required',
            'cota_indiviza_spatii_alta_destinatie' => 'required',
            'cofinantare_ap_eligibil' => 'required',
            'cofinantare_uat_neeligibil' => 'required',
            'departament' => 'required'
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
            $cota_indiviza_spatii_locuit            = self::text_2_number(Input::get('cota_indiviza_spatii_locuit'));
            $cota_indiviza_spatii_alta_destinatie   = self::text_2_number(Input::get('cota_indiviza_spatii_alta_destinatie'));
            $finantare_nerambursabila_por           = self::text_2_number(Input::get('finantare_nerambursabila_por'));
            $cofinantare_ap_eligibil                = self::text_2_number(Input::get('cofinantare_ap_eligibil'));
            $cofinantare_uat_eligibil               = self::text_2_number(Input::get('cofinantare_uat_eligibil'));
            $cofinantare_ap_neeligibil_ad           = self::text_2_number(Input::get('cofinantare_ap_neeligibil_ad'));
            $cofinantare_uat_neeligibil             = self::text_2_number(Input::get('cofinantare_uat_neeligibil'));
            $cofinantare_ap_neeligibil_sl           = self::text_2_number(Input::get('cofinantare_ap_neeligibil_sl'));

            try
            {
                DB::table('investitie_por_axa12')->insertGetId(array(
                    'id_imobil' => intval(Input::get('id_imobil')),
                    'id_tva' => intval(Input::get('cota_tva')),
                    'denumire' => Input::get('denumire'),
                    'cota_indiviza_spatii_locuit' => $cota_indiviza_spatii_locuit,
                    'cota_indiviza_spatii_alta_destinatie' => $cota_indiviza_spatii_alta_destinatie,
                    'finantare_nerambursabila_por' => $finantare_nerambursabila_por,
                    'cofinantare_ap_eligibil' => $cofinantare_ap_eligibil,
                    'cofinantare_uat_eligibil' => $cofinantare_uat_eligibil,
                    'cofinantare_ap_neeligibil_ad' => $cofinantare_ap_neeligibil_ad,
                    'cofinantare_uat_neeligibil' => $cofinantare_uat_neeligibil,
                    'cofinantare_ap_neeligibil_sl' => $cofinantare_ap_neeligibil_sl,
                    'id_departament' => intval(Input::get('departament'))
                    ));
            }
            catch (Exception $e)
            {       
                return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)
                    ->withInput();
            }            
            return Redirect::route('investitie_por_axa12_list');
        }
    }

    public function getEditInvestitie($id)
    {     
        $departamente = Confide::getDepartamenteUser();
        $tva = self::getCoteTVA();  
        $imobil_class = new \Codecorner\Imobil\Controllers\ImobileController();             
        $imobile = $imobil_class->getImobil();
        $cheltuieli = self::getCheltuieliSF();

        $investitie = DB::select("SELECT
            investitie.id,
            investitie.denumire,
            investitie.cota_indiviza_spatii_locuit,
            investitie.cota_indiviza_spatii_alta_destinatie,
            investitie.finantare_nerambursabila_por,
            investitie.cofinantare_ap_eligibil,
            investitie.cofinantare_uat_eligibil,
            investitie.cofinantare_ap_neeligibil_ad,
            investitie.cofinantare_uat_neeligibil,
            investitie.cofinantare_ap_neeligibil_sl,
            investitie.id_imobil,
            investitie.id_departament,
            investitie.id_tva,
            l.denumire AS localitate,
            j.denumire AS judet,
            i.adresa
            FROM por12_investitie investitie
            INNER JOIN imobil i ON i.id = investitie.id_imobil AND i.logical_delete = 0
            LEFT OUTER JOIN judet j ON j.id_judet = i.id_judet AND j.logical_delete = 0
            LEFT OUTER JOIN localitate l ON l.id_localitate = i.id_localitate AND l.logical_delete = 0
            WHERE investitie.id = :id_investitie", array('id_investitie' => $id));
        return View::make('investitie_por_axa12.edit')
            ->with('investitie', $investitie[0])
            ->with('imobile', $imobile)
            ->with('tva', $tva)
            ->with('finantare_nerambursabila_por', 60)
            ->with('cofinantare_ap_neeligibil_ad', 100)
            ->with('departamente', self::object_to_array($departamente))
            ->with('cheltuieli', $cheltuieli);             
    }

    public function postEditInvestitie($id)
    {
        $rules  = array(
            'id_imobil' => 'required',
            'cota_tva' => 'required',
            'denumire' => 'required',
            'cota_indiviza_spatii_locuit' => 'required',
            'cota_indiviza_spatii_alta_destinatie' => 'required',
            'cofinantare_ap_eligibil' => 'required',
            'cofinantare_uat_neeligibil' => 'required',
            'departament' => 'required'
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
            $cota_indiviza_spatii_locuit            = self::text_2_number(Input::get('cota_indiviza_spatii_locuit'));
            $cota_indiviza_spatii_alta_destinatie   = self::text_2_number(Input::get('cota_indiviza_spatii_alta_destinatie'));
            $finantare_nerambursabila_por           = self::text_2_number(Input::get('finantare_nerambursabila_por'));
            $cofinantare_ap_eligibil                = self::text_2_number(Input::get('cofinantare_ap_eligibil'));
            $cofinantare_uat_eligibil               = self::text_2_number(Input::get('cofinantare_uat_eligibil'));
            $cofinantare_ap_neeligibil_ad           = self::text_2_number(Input::get('cofinantare_ap_neeligibil_ad'));
            $cofinantare_uat_neeligibil             = self::text_2_number(Input::get('cofinantare_uat_neeligibil'));
            $cofinantare_ap_neeligibil_sl           = self::text_2_number(Input::get('cofinantare_ap_neeligibil_sl'));

            try
            {
                DB::table('por12_investitie')
                    ->where('id', $id)
                    ->update(array(
                    'id_imobil' => intval(Input::get('id_imobil')),
                    'id_tva' => intval(Input::get('cota_tva')),
                    'denumire' => Input::get('denumire'),
                    'cota_indiviza_spatii_locuit' => $cota_indiviza_spatii_locuit,
                    'cota_indiviza_spatii_alta_destinatie' => $cota_indiviza_spatii_alta_destinatie,
                    'finantare_nerambursabila_por' => $finantare_nerambursabila_por,
                    'cofinantare_ap_eligibil' => $cofinantare_ap_eligibil,
                    'cofinantare_uat_eligibil' => $cofinantare_uat_eligibil,
                    'cofinantare_ap_neeligibil_ad' => $cofinantare_ap_neeligibil_ad,
                    'cofinantare_uat_neeligibil' => $cofinantare_uat_neeligibil,
                    'cofinantare_ap_neeligibil_sl' => $cofinantare_ap_neeligibil_sl,
                    'id_departament' => intval(Input::get('departament'))
                    ));
            }
            catch (Exception $e)
            {       
                return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)
                    ->withInput();
            }            
            return Redirect::route('investitie_por_axa12_list');
        }
    }

    public function postDeleteInvestitie()
    {        
        if(Request::ajax()) {
            if( Session::token() === Input::get( '_token' ) ) {
                $id = Input::get('id');
                DB::table('por12_investitie')->where('id', $id)->update(array(
                    'logical_delete' => 1));
                return $id;
            }
        }
    }

    public function getOptiuniInvestitie($id_investitie, $id_imobil)
    {
        return View::make('investitie_por_axa12.options', compact('id_investitie', 'id_imobil'));
    }

    public function getLocatariImobil($id_investitie, $id_imobil)
    {
        $im = new \Codecorner\Imobil\Controllers\ImobileController();
        $imobil = $im->getImobil($id_imobil);
        $locatar_class = new \Codecorner\Imobil\Controllers\LocatarController();             
        $locatari = $locatar_class->getLocatariImobilASObject($id_imobil, $imobil[0]->numar_apartamente);
        $suprafata_utila_imobil = $locatar_class->getSuprafataUtilaImobil($id_imobil, $imobil[0]->numar_apartamente);
        $imobil = $imobil[0];
        return View::make('investitie_por_axa12.lucrari_individuale_list', compact('locatari', 'suprafata_utila_imobil', 'imobil'));            
    }

    public function getCheltuieliSF()
    {
        return DB::select("SELECT 
            tsf.denumire,
            tcsf.id,
            tcsf.eligibil_spatii_locuit,
            tcsf.neeligibil_spatii_locuit,
            tcsf.neeligibil_spatii_alta_destinatie,
            tcsf.eligibil_spatii_alta_destinatie
            FROM tip_cheltuieli_sursa_finantare tcsf
            INNER JOIN tip_sursa_finantare tsf ON tsf.id = tcsf.id_tip_sursa_finantare AND tsf.logical_delete = 0
            WHERE tcsf.logical_delete = 0");
    }

    public function getObiecte($id_investitie)
    {
        $obiecte = DB::select("SELECT
            id,
            denumire
            FROM por12_obiect_investitie
            WHERE logical_delete = 0
            AND id_investitie = :id_investitie", array('id_investitie' => $id_investitie));
        $articole = self::getArticoleDevizInvestitie($id_investitie);
        return View::make("investitie_por_axa12.I.list", compact('obiecte', 'id_investitie','articole'));
    }

    public function getArticoleDevizInvestitie($id_investitie)
    {
        $articole = DB::select("SELECT
            art.id,
            art.id_obiect,
            art.denumire,
            art.valoare_ftva_1,
            art.valoare_ftva_2,
            art.valoare_ftva_3,
            tl.denumire AS tip_lucrare,
            ds.denumire AS destinatie_spatiu,
            art.eligibil_spatii_locuit,
            art.neeligibil_spatii_locuit,
            art.neeligibil_spatii_alta_destinatie,
            art.eligibil_spatii_alta_destinatie

            FROM por12_articole_deviz art
            LEFT OUTER JOIN tip_lucrari tl ON tl.id = art.id_tip_lucrare AND tl.logical_delete = 0
            LEFT OUTER JOIN destinatie_spatiu ds ON ds.id = art.id_destinatie_spatiu AND ds.logical_delete = 0
            INNER JOIN por12_obiect_investitie obj 
                ON obj.id = art.id_obiect 
                AND obj.logical_delete = 0
                AND obj.id_investitie = :id_investitie
            WHERE art.logical_delete = 0", array('id_investitie' => $id_investitie));
        return $articole; 
    }

    public function getAddObiect($id_investitie)
    {
        return View::make("investitie_por_axa12.I.add", compact('id_investitie'));
    }
    public function postAddObiect($id_investitie)
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
                DB::table('por12_obiect_investitie')->insertGetId(array(
                    'id_investitie' => $id_investitie,
                    'denumire' => Input::get('denumire')
                    ));
            }
            catch (Exception $e)
            {       
                return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)
                    ->withInput();
            }            
            return Redirect::route('investitie_por_axa12_obiecte_list', $id_investitie);
        }
    }  
    public function getEditObiect($id, $id_investitie)
    {
        $obiect = DB::select("SELECT
            obj.id,
            obj.denumire,
            investitie.id AS id_investitie,
            investitie.denumire AS investitie
            FROM por12_obiect_investitie obj
            INNER JOIN por12_investitie investitie ON investitie.id = obj.id_investitie AND investitie.logical_delete = 0            
            WHERE obj.logical_delete = 0 
            AND obj.id = :id", array('id' => $id));
        return View::make("investitie_por_axa12.I.edit")
            ->with('obiect', $obiect[0]);          
    }  

    public function postEditObiect($id, $id_investitie)
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
                DB::table('por12_obiect_investitie')
                    ->where('id', $id)
                    ->update(array(
                    'denumire' => Input::get('denumire')
                    ));
            }
            catch (Exception $e)
            {       
                return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)
                    ->withInput();
            }            
            return Redirect::route('investitie_por_axa12_obiecte_list', $id_investitie);
        }
    }  

    public function getAddArticol($id_investitie, $id_obiect, $obiect)
    {
        $destinatie_spatiu = self::getDestinatieSpatiu();
        $tip_lucrari = self::getTipLucrari();
        return View::make("investitie_por_axa12.I.add_articol", compact('id_investitie', 'id_obiect', 'obiect', 'destinatie_spatiu', 'tip_lucrari'));
    }

    public function postAddArticol($id_investitie, $id_obiect, $obiect)
    {
        $rules  = array(
            'denumire' => 'required',
            'destinatie_spatiu' => 'required',
            'tip_lucrari' => 'required'
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
                DB::table('por12_articole_deviz')->insertGetId(array(
                    'id_obiect' => $id_obiect,
                    'denumire' => Input::get('denumire'),
                    'id_tip_lucrare' => intval(Input::get('tip_lucrari')),
                    'id_destinatie_spatiu' => intval(Input::get('destinatie_spatiu')),
                    'eligibil_spatii_locuit' => Input::get('esl')?true:false,
                    'neeligibil_spatii_locuit' => Input::get('nsl')?true:false,
                    'neeligibil_spatii_alta_destinatie' => Input::get('nsad')?true:false,
                    'eligibil_spatii_alta_destinatie' => Input::get('esad')?true:false
                    ));
            }
            catch (Exception $e)
            {       
                return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)
                    ->withInput();
            }            
            return Redirect::route('investitie_por_axa12_obiecte_list', $id_investitie);
        }
    }    
    
    public function getEditArticol($id_investitie, $id)
    {
        $destinatie_spatiu = self::getDestinatieSpatiu();
        $tip_lucrari = self::getTipLucrari();
        $articol = DB::select("SELECT
            id,
            denumire,
            id_tip_lucrare,
            id_destinatie_spatiu,
            eligibil_spatii_locuit,
            neeligibil_spatii_locuit,
            neeligibil_spatii_alta_destinatie,
            eligibil_spatii_alta_destinatie
            FROM por12_articole_deviz
            WHERE logical_delete = 0
            AND id = :id LIMIT 1", array('id' => $id));
        $articol = $articol[0];
        return View::make("investitie_por_axa12.I.edit_articol", compact('id_investitie', 'id', 'destinatie_spatiu', 'tip_lucrari', 'articol'));
    }  

    public function postEditArticol($id_investitie, $id)
    {
        $rules  = array(
            'denumire' => 'required',
            'destinatie_spatiu' => 'required',
            'tip_lucrari' => 'required'
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
                DB::table('por12_articole_deviz')
                    ->where('id', $id)
                    ->update(array(
                    'denumire' => Input::get('denumire'),
                    'id_tip_lucrare' => intval(Input::get('tip_lucrari')),
                    'id_destinatie_spatiu' => intval(Input::get('destinatie_spatiu')),
                    'eligibil_spatii_locuit' => (Input::get('esl')===null)?false:true,
                    'neeligibil_spatii_locuit' => (Input::get('nsl')===null)?false:true,
                    'neeligibil_spatii_alta_destinatie' => (Input::get('nsad')===null)?false:true,
                    'eligibil_spatii_alta_destinatie' => (Input::get('esad')===null)?false:true
                    ));
            }
            catch (Exception $e)
            {       
                return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)
                    ->withInput();
            }            
            return Redirect::route('investitie_por_axa12_obiecte_list', $id_investitie);
        }
    } 

    public function getArticoleValori($id_investitie)
    {
        $__articole = DB::select("SELECT
            art.id,
            art.id_obiect,
            art.denumire AS articol,            
            art.valoare_ftva_1,
            art.valoare_ftva_2,
            art.valoare_ftva_3,
            obj.denumire AS obiect

            FROM por12_articole_deviz art
            INNER JOIN por12_obiect_investitie obj 
                ON obj.id = art.id_obiect 
                AND obj.logical_delete = 0
                AND obj.id_investitie = :id_investitie
            WHERE art.logical_delete = 0
            ORDER BY art.id_obiect, art.id", array('id_investitie' => $id_investitie));

        //dd(gettype($articole[0]));
        $obiect_nou = -1;
        $articole = array();
        $j = 0;

        $t_v1 = 0;
        $t_v2 = 0;
        $t_v3 = 0;

        $s_v1 = 0;
        $s_v2 = 0;
        $s_v3 = 0;

        $obj;        
        for ($i=0; $i < count($__articole) ; $i++) { 


            //Daca sunt diferite inseamna ca avem obiect nou
            if ($obiect_nou != $__articole[$i]->id_obiect)
            {
                //Calculam totalul pe obiect (SUBTOTAL)
                if ($i != 0)
                {
                    //Calculez procentaje
                    $p1 = 0;
                    $p2 = 0;
                    if($s_v2 != 0) $p1 = ($s_v1 / $s_v2) * 100;
                    if($s_v3 != 0) $p2 = ($s_v2 / $s_v3) * 100;
                    $obj = array_merge(
                        array('id_obiect' => $__articole[$i]->id_obiect), 
                        array('obiect' => $__articole[$i]->obiect),
                        array('valoare_ftva_1' => $s_v1), 
                        array('valoare_ftva_2' => $s_v2), 
                        array('valoare_ftva_3' => $s_v3),
                        array('p1' =>$p1),
                        array('p2' =>$p2),
                        array('tip' => RowType::sub_total));
                    $articole[$j++] = (object)$obj;                    
                    
                    //Resetam subtotalurile ca sa inceapa calculul din nou
                    $s_v1 = 0;
                    $s_v2 = 0;
                    $s_v3 = 0;
                }

                // TITLU
                $obiect_nou = $__articole[$i]->id_obiect;
                $articole[$j++] = (object) array_merge(
                    array('id_obiect' => $obiect_nou),
                    array('obiect' => $__articole[$i]->obiect), 
                    array( 'tip' => RowType::titlu ));
            }

            // Liniile de detalii - articolele de deviz
            $articole[$j++] = (object) array_merge((array)$__articole[$i], array('tip' => RowType::detaliu));            
            $s_v1 += $__articole[$i]->valoare_ftva_1;
            $s_v2 += $__articole[$i]->valoare_ftva_2;
            $s_v3 += $__articole[$i]->valoare_ftva_3;

            //Adunam subtotalurile la totalurile generale
            $t_v1 += $s_v1;
            $t_v2 += $s_v2;
            $t_v3 += $s_v3;

            //Suntem la ultima iteratie asa ca calculam subtotalul ultimului obiect
            if ($i == count($__articole) - 1)            
            {         
                // Calculez procentaje
                $p1 = 0;
                $p2 = 0;
                if($s_v2 != 0) $p1 = ($s_v1 / $s_v2) * 100;
                if($s_v3 != 0) $p2 = ($s_v2 / $s_v3) * 100;               
                $obj = array_merge(
                    array('id_obiect' => $__articole[$i]->id_obiect), 
                    array('obiect' => $__articole[$i]->obiect),
                    array('valoare_ftva_1' => $s_v1), 
                    array('valoare_ftva_2' => $s_v2), 
                    array('valoare_ftva_3' => $s_v3),
                    array('p1' =>$p1),
                    array('p2' =>$p2),
                    array( 'tip' => RowType::sub_total ));
                $articole[$j++] = (object)$obj;                        
            }
        }

        //Total general
        $p1 = 0;
        $p2 = 0;
        if($t_v2 != 0) $p1 = ($t_v1 / $t_v2) * 100;
        if($t_v3 != 0) $p2 = ($t_v2 / $t_v3) * 100;               
        $obj = array_merge(
            array('id_obiect' => 0), 
            array('obiect' => ''),
            array('valoare_ftva_1' => $t_v1), 
            array('valoare_ftva_2' => $t_v2), 
            array('valoare_ftva_3' => $t_v3),
            array('p1' =>$p1),
            array('p2' =>$p2),
            array( 'tip' => RowType::total ));
        $articole[$j++] = (object)$obj;

        return View::make("investitie_por_axa12.II.list", compact('id_investitie','articole'));
    }

    public function getCreateEditArticoleValori($id_investitie, $id)
    {
        $articol = DB::select("SELECT
            art.id,
            art.denumire AS articol,            
            art.valoare_ftva_1,
            art.valoare_ftva_2,
            art.valoare_ftva_3

            FROM por12_articole_deviz art
            WHERE art.id = :id", array('id' => $id));
        $articol = $articol[0];
        return View::make('investitie_por_axa12.II.create_edit', compact('articol', 'id_investitie'));
    }

    public function postCreateEditArticoleValori($id_investitie, $id)
    {
        $valoare_ftva_1 = self::text_2_number(Input::get('val_sf'));
        $valoare_ftva_2 = self::text_2_number(Input::get('val_pt'));
        $valoare_ftva_3 = self::text_2_number(Input::get('val_fa'));

        try
        {
            DB::table('por12_articole_deviz')
                ->where('id', $id)
                ->update(array(
                'valoare_ftva_1' => $valoare_ftva_1,
                'valoare_ftva_2' => $valoare_ftva_2,
                'valoare_ftva_3' => $valoare_ftva_3
                ));
        }
        catch (Exception $e)
        {       
            return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)
                ->withInput();
        }            
        return Redirect::route('investitie_por_axa12_articol_valori_list', $id_investitie);
    } 
}

class articol
{
    public $tip_row;
    public $descriere;

}   

abstract class RowType
{
    const titlu = 0;
    const detaliu = 1;
    const sub_total = 2;
    const total = 3;

}