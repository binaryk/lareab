<?php
class ContractController extends BaseController
{
    public function getOptiuniContract($id_contract) 
    {
        $contract = DB::select("SELECT 
            ctr.id_contract, 
            ctr.numar,             
            date_format(ctr.data_semnarii, '%d-%m-%Y') as data_semnarii
            
        FROM contract ctr
        WHERE ctr.id_contract = :id_contract", array('id_contract' => $id_contract));

        //Debugbar::info($contract);
        return View::make('contracte.options')->with('contract', $contract);
    }

    public function getContracte() 
    {
        $contracte = DB::select("SELECT 
            ctr.id_contract, 
            ctr.numar, 
            ctr.id_tip_contract, 
            date_format(ctr.data_semnarii, '%d-%m-%Y') as data_semnarii,
            ctr.id_tip_nivel_contractare, 
            ctr.id_entitatea_mea, 
            ctr.id_partener, 
            ctr.denumire AS denumire_contract, 
            ctr.valoare, 
            ctr.tva AS procent_tva,
            ctr.valoare * ctr.tva / 100.0 AS valoare_tva,
            tnc.id_tip_nivel, 
            tnc.denumire AS parte_in_contract, 
            tip_c.denumire AS tip_contract, 
            entitate.denumire AS entitatea_mea, 
            v_localitate_descriere.denumire AS localitate,
            sc.denumire as stadiu_contract
        FROM contract ctr
        LEFT OUTER JOIN tip_nivel_contractare tnc ON  ctr.id_tip_nivel_contractare = tnc.id_tip_nivel  AND  tnc.logical_delete = 0 
        LEFT OUTER JOIN v_localitate_descriere v_localitate_descriere ON  ctr.id_localitate = v_localitate_descriere.id_localitate 
        LEFT OUTER JOIN tip_contract tip_c ON  ctr.id_tip_contract = tip_c.id_tip_contract  AND  tip_c.logical_delete = 0 
        LEFT OUTER JOIN entitate entitate ON  ctr.id_entitatea_mea = entitate.id_entitate  AND  entitate.logical_delete = 0
        LEFT OUTER JOIN stadiu_contract sc ON sc.id_stadiu_contract = ctr.id_stadiu AND sc.logical_delete = 0 
        WHERE ctr.logical_delete = 0 
        AND ctr.id_organizatie = :id_organizatie", array('id_organizatie' => $this->date_organizatie[0]->id_organizatie));

        if (count($contracte) > 0) {
            return View::make('contracte.list')->with('contracte', $contracte);
        }
    }

    /** getStadiiContract() se afla acum si in ContractOptiuniController.php **/
    public function getStadiiContract()
    {
        $stadii_contract = DB::select("SELECT 
            id_stadiu_contract, denumire 
            FROM stadiu_contract
            WHERE logical_delete = 0");
        return $stadii_contract;        
    }

    public function getAddContract() 
    {
        $entitati_organizatie = self::getEntitatiOrganizatie();
        $parteneri_organizatie = self::getParteneriOrganizatie();
        $entitati_publice = self::getEntitatiPublice();
        $parti_contract = self::getPartiContract();
        $stadii_contract = self::getStadiiContract();
        $tipuri_contract = self::getTipuriContract();
        $ums_timp = self::getUMTimp();

        return View::make('contracte.add')
            ->with('entitati_organizatie', $entitati_organizatie)
            ->with('parteneri_organizatie', $parteneri_organizatie)
            ->with('entitati_publice', $entitati_publice)
            ->with('parti_contract', $parti_contract)
            ->with('stadii_contract', $stadii_contract)
            ->with('tipuri_contract', $tipuri_contract)
            ->with('ums_timp', $ums_timp);
    }

    public function postAddContract()
    {
        $rules = array(
            'numar' => 'required',
            'data_semnare' => 'required',
            'entitate_organizatie' => 'required',
            'parte_in_contract' => 'required',
            'partener_organizatie' => 'required',
            'stadiu_contract' => 'required',
            'durata_contract' => 'required',
            'um_timp' => 'required'
            );
        $errors = array('required' => 'Campul este obligatoriu.');
        
        $validator = Validator::make(Input::all(), $rules, $errors);
        if ($validator->fails()) {
            return Redirect::back()->with('message', 'Eroare validare formular!')->withErrors($validator)->withInput();
        } 
        else {
            $data_semnarii_eu = DateTime::createFromFormat('d-m-Y', Input::get('data_semnare'));
            $data_semnarii_us = $data_semnarii_eu->format('Y-m-d');            
            
            $valoare = 0;
            if (!empty(Input::get('valoare_contract')))
            {
                $valoare = Input::get('valoare_contract');
                $valoare = str_replace('.', '', $valoare);
                $valoare = str_replace(',', '.', $valoare);
            }

            $tva = 0;                            
            if (!empty(Input::get('procent_tva')))
            {
                $tva = Input::get('procent_tva');    
                $tva = str_replace('.', '', $tva);
                $tva = str_replace(',', '.', $tva);
            }
            try {
                DB::table('contract')
                ->insertGetId(array(
                    'numar' => Input::get('numar'),
                    'id_tip_contract' => Input::get('tip_contract'),
                    'id_stadiu' => Input::get('stadiu_contract'),
                    'data_semnarii' => $data_semnarii_us,
                    'id_tip_nivel_contractare' => Input::get('parte_in_contract'),
                    'id_entitatea_mea' => Input::get('entitate_organizatie'),
                    'id_partener' => Input::get('partener_organizatie'),
                    'denumire' => Input::get('denumire'),
                    'valoare' => $valoare,
                    'tva' => $tva,
                    'durata_contract' => Input::get('durata_contract'),
                    'id_um_timp' => Input::get('um_timp'),
                    'id_tara' => Input::get('tara'), 
                    'id_regiune' => Input::get('regiune'), 
                    'id_judet' => Input::get('judet'), 
                    'id_localitate' => Input::get('localitate'),
                    'id_organizatie' => $this->date_organizatie[0]->id_organizatie));
            }
            catch(Exception $e) {
                return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
            }
            return Redirect::back()->with('message', 'Salvare realizata cu succes!')->withInput();
        }
    }


    public function getPartiContract()
    {
       $parti_contract = DB::select("SELECT 
            id_tip_nivel, denumire 
            FROM tip_nivel_contractare
            WHERE logical_delete = 0");
        return $parti_contract;        
    }
    

    public function getTipuriContract()
    {
        $tipuri_contract = DB::select("SELECT 
            id_tip_contract, denumire 
            FROM tip_contract
            WHERE logical_delete = 0");
        return $tipuri_contract;
    }

    /** getUMTimp() se afla acum si in ContractOptiuniController.php **/
    public function getUMTimp()
    {
        $ums_timp = DB::select("SELECT 
            id_um, denumire 
            FROM um_timp
            WHERE logical_delete = 0");
        return $ums_timp;
    }

    public function getEditContract($id) 
    {
        $entitati_organizatie = self::getEntitatiOrganizatie();
        $parteneri_organizatie = self::getParteneriOrganizatie();
        $parti_contract = self::getPartiContract();
        $stadii_contract = self::getStadiiContract();
        $tipuri_contract = self::getTipuriContract();
        $ums_timp = self::getUMTimp();
        $contract = self::getContract($id);

        return View::make('contracte.edit')
            ->with('contract', $contract[0])
            ->with('entitati_organizatie', $entitati_organizatie)
            ->with('parteneri_organizatie', $parteneri_organizatie)
            ->with('parti_contract', $parti_contract)
            ->with('stadii_contract', $stadii_contract)
            ->with('tipuri_contract', $tipuri_contract)
            ->with('ums_timp', $ums_timp);
    }
    
    public function postEditContract($id)
    {
        $rules = array(
            'numar' => 'required',
            'data_semnare' => 'required',
            'entitate_organizatie' => 'required|integer|min:1',
            'parte_in_contract' => 'required|integer|min:1',
            'partener_organizatie' => 'required|integer|min:1',
            'stadiu_contract' => 'required|integer|min:1',
            'durata_contract' => 'required|integer|min:1',
            'um_timp' => 'required|integer|min:1',
            'tip_contract' => 'required|integer|min:1'
            );
        $errors = array('required' => 'Campul este obligatoriu.');
        
        $validator = Validator::make(Input::all(), $rules, $errors);
        if ($validator->fails()) {
            return Redirect::back()->with('message', 'Eroare validare formular!')->withErrors($validator)->withInput();
        } 
        else {
            $data_semnarii_eu = DateTime::createFromFormat('d-m-Y', Input::get('data_semnare'));
            $data_semnarii_us = $data_semnarii_eu->format('Y-m-d');            
            
            $valoare = 0;
            if (!empty(Input::get('valoare_contract')))
            {
                $valoare = Input::get('valoare_contract');
                $valoare = str_replace('.', '', $valoare);
                $valoare = str_replace(',', '.', $valoare);
            }

            $tva = 0;                            
            if (!empty(Input::get('procent_tva')))
            {
                $tva = Input::get('procent_tva');    
                $tva = str_replace('.', '', $tva);
                $tva = str_replace(',', '.', $tva);
            }
   
            /*$id_regiune = 0;
            if (!empty(Input::get('regiune') !== null))
            {
                $id_regiune = Input::get('regiune');
            }*/

            try {
                DB::table('contract')
                ->where('id_contract', $id)
                ->update(array(
                    'numar' => Input::get('numar'),
                    'id_tip_contract' => Input::get('tip_contract'),
                    'id_stadiu' => Input::get('stadiu_contract'),
                    'data_semnarii' => $data_semnarii_us,
                    'id_tip_nivel_contractare' => Input::get('parte_in_contract'),
                    'id_entitatea_mea' => Input::get('entitate_organizatie'),
                    'id_partener' => Input::get('partener_organizatie'),
                    'denumire' => Input::get('denumire'),
                    'valoare' => $valoare,
                    'tva' => $tva,
                    'durata_contract' => Input::get('durata_contract'),
                    'id_um_timp' => Input::get('um_timp'),
                    'id_tara' => Input::get('tara'), 
                    'id_regiune' => Input::get('regiune'), 
                    'id_judet' => Input::get('judet'), 
                    'id_localitate' => Input::get('localitate'),
                    'id_organizatie' => $this->date_organizatie[0]->id_organizatie));
            }
            catch(Exception $e) {
                return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
            }
            return Redirect::back()->with('message', 'Salvare realizata cu succes!')->withInput();
        }
    }
    /** getContract() se afla acum si in ContractOptiuniController.php **/
    public function getContract($id) 
    {
        $contract = DB::select("SELECT 
            ctr.id_contract, 
            ctr.numar, 
            ctr.id_tip_contract, 
            ctr.id_stadiu,
            date_format(ctr.data_semnarii, '%d-%m-%Y') as data_semnarii,
            ctr.id_tip_nivel_contractare, 
            ctr.id_entitatea_mea, 
            ctr.id_partener, 
            ctr.denumire AS denumire_contract, 
            ctr.valoare, 
            ctr.tva, 
            ctr.durata_contract,
            ctr.id_um_timp,
            ctr.id_tara,
            ctr.id_regiune,
            ctr.id_judet,
            ctr.id_localitate,
            tara.denumire AS tara,
            regiune.denumire AS regiune,
            judet.denumire AS judet,
            v_localitate_descriere.denumire AS localitate,            
            tnc.id_tip_nivel, 
            tnc.denumire AS parte_in_contract, 
            tip_c.denumire AS tip_contract, 
            entitate.denumire AS entitatea_mea          
        FROM contract ctr
        LEFT OUTER JOIN tip_nivel_contractare tnc ON  ctr.id_tip_nivel_contractare = tnc.id_tip_nivel  AND  tnc.logical_delete = 0 
        LEFT OUTER JOIN tara ON tara.id_tara = ctr.id_tara AND tara.logical_delete = 0
        LEFT OUTER JOIN regiune ON regiune.id_regiune = ctr.id_regiune AND regiune.logical_delete = 0
        LEFT OUTER JOIN judet ON judet.id_judet = ctr.id_judet AND judet.logical_delete = 0        
        LEFT OUTER JOIN v_localitate_descriere v_localitate_descriere ON  ctr.id_localitate = v_localitate_descriere.id_localitate 
        LEFT OUTER JOIN tip_contract tip_c ON  ctr.id_tip_contract = tip_c.id_tip_contract  AND  tip_c.logical_delete = 0 
        LEFT OUTER JOIN entitate ON ctr.id_entitatea_mea = entitate.id_entitate  AND  entitate.logical_delete = 0
        WHERE ctr.logical_delete = 0  
        AND ctr.id_contract = :id_contract        
        ORDER BY ctr.id_contract DESC LIMIT 1", array('id_contract' => $id));
        return $contract;               
    }

    public function getContractSingle($id)
    {
        $contract = self::getContract($id);
        if (count($contract) > 0) {
            return View::make('contracte.single')->with('contract', $contract);
        }
    }
    
    public function getObiectivSingle($id) {
        $contract = DB::Select("SELECT 
            oc.id_obiectiv, 
            oc.numar AS numar_obiectiv, 
            date_format(oc.data_semnare, '%d-%m-%Y') AS data_semnare_obiectiv, 
            oc.denumire AS denumire_obiectiv, 
            oc.id_tara, 
            oc.id_regiune, 
            oc.id_judet, 
            oc.id_localitate, 
            oc.adresa AS adresa_obiectiv, 
            oc.cod_postal AS cod_postal_obiectiv, 
            tara.denumire AS tara_obiectiv, 
            regiune.denumire AS regiune_obiectiv, 
            judet.denumire AS judet_obiectiv, 
            localitate_obj.denumire AS localitate_obiectiv,
            ctr.id_contract,
            ctr.numar AS numar_contract,
            ctr.id_tip_contract,
            date_format(ctr.data_semnarii, '%d-%m-%Y') as data_semnare_contract,
            ctr.id_tip_nivel_contractare,
            ctr.id_entitatea_mea,
            ctr.id_partener,
            ctr.denumire AS denumire_contract,
            ctr.valoare,
            ctr.tva,
            tnc.id_tip_nivel,
            tnc.denumire AS parte_in_contract,
            tip_c.denumire AS tip_contract,
            entitate.denumire AS entitatea_mea,
            localitate_ctr.denumire AS localitate_contract

            FROM obiectiv oc
            INNER JOIN contract ctr ON ctr.id_contract = oc.id_contract AND ctr.logical_delete = 0
            LEFT OUTER JOIN tip_nivel_contractare tnc ON  ctr.id_tip_nivel_contractare = tnc.id_tip_nivel  AND  tnc.logical_delete = 0
            LEFT OUTER JOIN v_localitate_descriere localitate_ctr ON  ctr.id_localitate = localitate_ctr.id_localitate
            LEFT OUTER JOIN tip_contract tip_c ON  ctr.id_tip_contract = tip_c.id_tip_contract  AND  tip_c.logical_delete = 0
            LEFT OUTER JOIN entitate entitate ON  ctr.id_entitatea_mea = entitate.id_entitate  AND  entitate.logical_delete = 0

            LEFT OUTER JOIN tara tara ON  oc.id_tara = tara.id_tara  AND  tara.logical_delete = 0
            LEFT OUTER JOIN regiune regiune ON  oc.id_regiune = regiune.id_regiune  AND  regiune.logical_delete = 0
            LEFT OUTER JOIN judet judet ON  oc.id_judet = judet.id_judet  AND  judet.logical_delete = 0
            LEFT OUTER JOIN v_localitate_descriere localitate_obj ON  oc.id_localitate = localitate_obj.id_localitate
            WHERE oc.logical_delete = 0
            AND oc.id_obiectiv = :id_obiectiv
            ORDER BY ctr.id_contract DESC LIMIT 1", array('id_obiectiv' => $id));
        
        if (count($contract) > 0) {
            return View::make('contracte.single')->with('contract', $contract);
        }
    }

    public function postDeleteContract() {
        if (Request::ajax()) {
            if (Session::token() === Input::get('_token')) {
                $id = Input::get('id_contract');
                DB::table('contract')->where('id_contract', $id)->update(array('logical_delete' => 1));
                return $id;
            }
        }
    }    
}
