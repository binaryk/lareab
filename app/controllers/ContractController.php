<?php
class ContractController extends BaseController
{
    public function getOptiuniContract($id) 
    {
        $contract = DB::select("SELECT 
            ctr.id, 
            ctr.numar,             
            date_format(ctr.data_semnarii, '%d-%m-%Y') as data_semnarii
            
        FROM contract ctr
        WHERE ctr.id = :id", array('id' => $id));

        //Debugbar::info($contract);
        return View::make('contracte.options')->with('contract', $contract);
    }
	
    public function getContracte() 
    {
        $ids = self::getIDsDepartamente(Confide::getDepartamenteUser());        
        $sql = "SELECT 
            ctr.id, 
            ctr.numar, 
            ctr.id_tip_contract, 
            date_format(data_semnarii,'%Y%m%d') AS ord_data_semnarii,
            date_format(ctr.data_semnarii, '%d-%m-%Y') as data_semnarii,
            ctr.id_tip_nivel_contractare, 
            ctr.id_entitatea_mea, 
            ctr.id_partener, 
            ctr.denumire AS denumire_contract, 
            ctr.valoare, 
            ctr.tva AS procent_tva,
            ctr.valoare * ctr.tva / 100.0 AS valoare_tva,
            tnc.denumire AS parte_in_contract, 
            tip_c.denumire AS tip_contract, 
            case 
                when id_tip_nivel_contractare = 1 then
                    concat('B=', ifnull(entitate.denumire,''), '<br>', 'P=', ifnull(partener.denumire,''))
                when id_tip_nivel_contractare = 2 then
                    concat('B=', ifnull(partener.denumire,''), '<br>', 'P=', ifnull(entitate.denumire,''))
                else '?????'
            end as beneficiar_prestator,

            entitate.denumire AS entitatea_mea,
            partener.denumire AS partener, 
            /*v_localitate_descriere.denumire AS localitate,*/
            (SELECT SUM(so.grad_realizare) / COUNT(*) 
                FROM obiectiv
                LEFT OUTER JOIN stadiu_obiectiv so ON so.id = obiectiv.id_stadiu AND so.logical_delete = 0 
                WHERE obiectiv.logical_delete = 0 
                AND obiectiv.id_contract = ctr.id) AS stadiu_contract

        FROM contract ctr
        LEFT OUTER JOIN tip_nivel_contractare tnc ON  ctr.id_tip_nivel_contractare = tnc.id AND  tnc.logical_delete = 0 
        /*LEFT OUTER JOIN v_localitate_descriere v_localitate_descriere ON  ctr.id_localitate = v_localitate_descriere.id_localitate */
        LEFT OUTER JOIN tip_contract tip_c ON  ctr.id_tip_contract = tip_c.id  AND  tip_c.logical_delete = 0 
        LEFT OUTER JOIN entitate entitate ON  ctr.id_entitatea_mea = entitate.id  AND  entitate.logical_delete = 0
        LEFT OUTER JOIN entitate partener ON  ctr.id_partener = partener.id  AND  partener.logical_delete = 0
        WHERE ctr.logical_delete = 0"; 
        $sql = $sql . " AND ctr.id_departament IN (" . $ids . ")";
        $contracte = DB::select($sql); 
        /*AND ctr.id_departament IN (:departamente)", array('departamente' => $ids));      */
        /*AND ctr.id_organizatie = :id_organizatie", array('id_organizatie' => self::organizatie()[0]->id_organizatie));*/
//dd($sql);
        return View::make('contracte.list')
            ->with('contracte', $contracte);            
    }
	
	
	/* Mevoro edit */	

    public function getCentralizatorContracteClient() 
    {
		/*
		Afiseaza:
		- numar, data semnarii, denumire contract, total livrabile, total garantie, total facturat (desfasurator), total incasat, rest de incasat, total virat CG, rest de virat in CG
		- informatii afisate au trimiteri catre resursele caracteristice
		*/
		
        $ids = self::getIDsDepartamente(Confide::getDepartamenteUser());        
        $sql = "
		SELECT 
			ctr.id AS id, 
			ctr.id_tip_nivel_contractare AS id_tip_nivel_contractare,
			ctr.numar AS numar, 
			ctr.data_semnarii AS data_semnarii,
			ctr.denumire AS denumire,
			SUM(IFNULL(le.pret_fara_tva, 0)) AS total_livrabile,
			IFNULL((ctr.valoare * ge.procent_valoare / 100), 0) AS total_garantie,
			IFNULL((SELECT SUM(pret_unitar*cantitate) FROM detalii_factura WHERE id_factura = fc.id GROUP BY id_factura), 0) AS total_facturat,
			IFNULL((SELECT SUM(valoare_incasata) FROM incasare_factura WHERE id_factura = fc.id GROUP BY id_factura), 0) AS total_incasat
		
		FROM contract ctr
		
		LEFT JOIN 
			obiectiv ob 
			ON 
			ctr.id = ob.id_contract AND ob.logical_delete = 0
			
		LEFT JOIN 
			etape_predare_livrabile epl 
			ON 
			ob.id = epl.id_etapa
		
		LEFT JOIN 
			livrabile_etapa le 
			ON 
			epl.id_etapa = le.id_etapa
			
					
		#Total garantie
		LEFT JOIN 
			garantie_executie ge 
			ON 
			ctr.id = ge.id_contract    
			
				
		LEFT JOIN 
			factura_client fc 
			ON 
			ctr.id = fc.id_contract
			
		LEFT JOIN 
			detalii_factura dfc 
			ON 
			fc.id = dfc.id_factura
					
		WHERE 
			ctr.logical_delete = 0
			AND ctr.id_departament IN (" . $ids . ")
			
		GROUP BY 
			ctr.id,
			le.id_etapa
		"; 
		//dd($sql);
		$centralizator_contracte = DB::select($sql); 		
		/*
			Preferam calculul pentru Total livrabile in PHP pt ca este mult mai rapid
		*/
		/*
		Afiseaza:
		- numar, data semnarii, denumire contract, total livrabile, total garantie, total facturat (desfasurator), total incasat, rest de incasat, total virat CG, rest de virat in CG
		- informatii afisate au trimiteri catre resursele caracteristice
		*/
		$contracte = array();
		foreach($centralizator_contracte as $cc) {
			if(!isset($contracte[$cc -> id])) {
				$contracte[$cc -> id] = array(
				'numar' => $cc -> numar,
				'id_tip_nivel_contractare' => $cc -> id_tip_nivel_contractare,
				'ord_data_semnarii' => date('Ymd', strtotime($cc -> data_semnarii)),
				'data_semnarii' => date('d-m-Y', strtotime($cc -> data_semnarii)),
				'denumire' => $cc -> denumire,
				'total_livrabile' => $cc -> total_livrabile,
				'total_garantie' => $cc -> total_garantie,
				'total_facturat' => $cc -> total_facturat,
				'total_incasat' => $cc -> total_incasat,
				'rest_de_incasat' => ($cc -> total_facturat - $cc -> total_incasat),
				'total_virat_cg' => '!0',
				'rest_de_virat_cg' => '!0'
				);
			}
			else {
				$contracte[$cc -> id]['total_livrabile'] += $cc -> total_livrabile;	
			}
		}
		
		//echo '<pre>'; print_r($contracte); die('</pre>');
		
        return View::make('contracte.centralizator_list')
            ->with('contracte', $contracte);            
    } //sfarsit getCentralizatorContracte()
	
	
	/* End of Mevoro edit */
	
	 

    public function getAddContract() 
    {
        $departamente = Confide::getDepartamenteUser();
        $entitati_organizatie = self::getEntitatiOrganizatie($departamente);
        $parteneri = self::getParteneri();
        $parti_contract = self::getPartiContract();
        $tipuri_contract = self::getTipuriContract();
        $ums_timp = self::getUMTimp();
        

        return View::make('contracte.add')
            ->with('entitati_organizatie', $entitati_organizatie)
            ->with('parteneri', $parteneri)            
            ->with('parti_contract', $parti_contract)            
            ->with('tipuri_contract', $tipuri_contract)
            ->with('ums_timp', $ums_timp)
            ->with('departamente', self::object_to_array($departamente)); 
    }

    public function postAddContract()
    {
        $rules = array(         
            'departament' => 'required',
            'numar' => 'required',
            'data_semnare' => 'required',
            'denumire' => 'required',
            //'entitate_organizatie' => 'required',
            'parte_in_contract' => 'required',
            'partener_organizatie' => 'required',            
            'durata_contract' => 'required',
            'um_timp' => 'required',
            'tip_contract' => 'required'
            );
        $errors = array(
            'required' => 'Campul este obligatoriu.',
            );
        
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
            $durata_contract = 0;                            
            if (!empty(Input::get('durata_contract')))
            {
                $durata_contract = Input::get('durata_contract');    
                $durata_contract = str_replace('.', '', $durata_contract);
                $durata_contract = str_replace(',', '.', $durata_contract);
            }
            
            $id_entitate = 0;
            foreach (Confide::getDepartamenteUser() as $departament) {
                if ($departament->id == intval(Input::get('departament')))
                {
                    $id_entitate = $departament->id_entitate;
                    break;
                }
            }

            try {
                DB::table('contract')
                ->insertGetId(array(
                    'numar' => Input::get('numar'),
                    'id_tip_contract' => intval(Input::get('tip_contract')),
                    'data_semnarii' => $data_semnarii_us,
                    'id_tip_nivel_contractare' => intval(Input::get('parte_in_contract')),
                    'id_entitatea_mea' => $id_entitate,
                    'id_partener' => intval(Input::get('partener_organizatie')),
                    'denumire' => Input::get('denumire'),
                    'valoare' => $valoare,
                    'tva' => $tva,
                    'durata_contract' => $durata_contract,
                    'id_um_timp' => intval(Input::get('um_timp')),
                    'id_tara' => intval(Input::get('tara')), 
                    'id_regiune' => intval(Input::get('regiune')), 
                    'id_judet' => intval(Input::get('judet')), 
                    'id_localitate' => intval(Input::get('localitate')),
                    'id_departament' => intval(Input::get('departament'))));
            }
            catch(Exception $e) {
                return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
            }
            //return Redirect::back()->with('message', 'Salvare realizata cu succes!')->withInput();
            return Redirect::route('contract_list');
        }
    }


    public function getPartiContract()
    {
       $parti_contract = DB::select("SELECT 
            id, denumire 
            FROM tip_nivel_contractare
            WHERE logical_delete = 0");
        return self::object_to_array($parti_contract);        
    }
    
    public function getTipuriContract()
    {
        $tipuri_contract = DB::select("SELECT 
            id, denumire 
            FROM tip_contract
            WHERE logical_delete = 0");
        return self::object_to_array($tipuri_contract);
    }

    public function getEditContract($id) 
    {
        $departamente = Confide::getDepartamenteUser();
        $entitati_organizatie = self::getEntitatiOrganizatie($departamente);
        $parteneri = self::getParteneri();
        $parti_contract = self::getPartiContract();
        $tipuri_contract = self::getTipuriContract();
        $ums_timp = self::getUMTimp();
        $contract = self::getContract($id);        

        return View::make('contracte.edit')
            ->with('contract', $contract[0])            
            ->with('parteneri', $parteneri)            
            ->with('entitati_organizatie', $entitati_organizatie)                        
            ->with('parti_contract', $parti_contract)
            ->with('tipuri_contract', $tipuri_contract)
            ->with('ums_timp', $ums_timp)
            ->with('departamente', self::object_to_array($departamente));
    }
    
    public function postEditContract($id)
    {
        $rules = array(
            'departament' => 'required',
            'numar' => 'required',
            'data_semnare' => 'required',
            'denumire' => 'required',
            //'entitate_organizatie' => 'required',
            'parte_in_contract' => 'required',
            'partener_organizatie' => 'required',
            'durata_contract' => 'required',
            'um_timp' => 'required',
            'tip_contract' => 'required'
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
   
            $durata_contract = 0;                            
            if (!empty(Input::get('durata_contract')))
            {
                $durata_contract = Input::get('durata_contract');    
                $durata_contract = str_replace('.', '', $durata_contract);
                $durata_contract = str_replace(',', '.', $durata_contract);
            } 

            $id_entitate = 0;
            foreach (Confide::getDepartamenteUser() as $departament) {
                if ($departament->id == intval(Input::get('departament')))
                {
                    $id_entitate = $departament->id_entitate;
                    break;
                }
            }

            try {
                DB::table('contract')
                ->where('id', $id)
                ->update(array(
                    'numar' => Input::get('numar'),
                    'id_tip_contract' => intval(Input::get('tip_contract')),                    
                    'data_semnarii' => $data_semnarii_us,
                    'id_tip_nivel_contractare' => intval(Input::get('parte_in_contract')),
                    'id_entitatea_mea' => $id_entitate,
                    'id_partener' => intval(Input::get('partener_organizatie')),
                    'denumire' => Input::get('denumire'),
                    'valoare' => $valoare,
                    'tva' => $tva,
                    'durata_contract' => $durata_contract,
                    'id_um_timp' => intval(Input::get('um_timp')),
                    'id_tara' => intval(Input::get('tara')), 
                    'id_regiune' => intval(Input::get('regiune')), 
                    'id_judet' => intval(Input::get('judet')), 
                    'id_localitate' => intval(Input::get('localitate')),
                    'id_departament' => intval(Input::get('departament'))));
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
            ctr.id, 
            ctr.numar, 
            ctr.id_tip_contract, 
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
            localitate.denumire AS localitate,            
            tnc.id, 
            tnc.denumire AS parte_in_contract, 
            tip_c.denumire AS tip_contract, 
            entitate.denumire AS entitatea_mea,
            ctr.id_departament,
            (SELECT COUNT(*) FROM obiectiv
                WHERE obiectiv.logical_delete = 0 
                AND obiectiv.id_contract = ctr.id) AS num_obiective                    
        FROM contract ctr
        LEFT OUTER JOIN tip_nivel_contractare tnc ON  ctr.id_tip_nivel_contractare = tnc.id AND tnc.logical_delete = 0 
        LEFT OUTER JOIN tara ON tara.id_tara = ctr.id_tara AND tara.logical_delete = 0
        LEFT OUTER JOIN regiune ON regiune.id_regiune = ctr.id_regiune AND regiune.logical_delete = 0
        LEFT OUTER JOIN judet ON judet.id_judet = ctr.id_judet AND judet.logical_delete = 0        
        /*LEFT OUTER JOIN v_localitate_descriere v_localitate_descriere ON  ctr.id_localitate = v_localitate_descriere.id_localitate */
        LEFT OUTER JOIN localitate ON  ctr.id_localitate = localitate.id_localitate 
        LEFT OUTER JOIN tip_contract tip_c ON  ctr.id_tip_contract = tip_c.id  AND  tip_c.logical_delete = 0 
        LEFT OUTER JOIN entitate ON ctr.id_entitatea_mea = entitate.id  AND  entitate.logical_delete = 0
        WHERE ctr.logical_delete = 0  
        AND ctr.id = :id        
        ORDER BY ctr.id DESC LIMIT 1", array('id' => $id));
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
            oc.id, 
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
            ctr.id,
            ctr.numar AS numar_contract,
            ctr.id_tip_contract,
            date_format(ctr.data_semnarii, '%d-%m-%Y') as data_semnare_contract,
            ctr.id_tip_nivel_contractare,
            ctr.id_entitatea_mea,
            ctr.id_partener,
            ctr.denumire AS denumire_contract,
            ctr.valoare,
            ctr.tva,
            tnc.id,
            tnc.denumire AS parte_in_contract,
            tip_c.denumire AS tip_contract,
            entitate.denumire AS entitatea_mea,
            localitate_ctr.denumire AS localitate_contract

            FROM obiectiv oc
            INNER JOIN contract ctr ON ctr.id = oc.id_contract AND ctr.logical_delete = 0
            LEFT OUTER JOIN tip_nivel_contractare tnc ON  ctr.id_tip_nivel_contractare = tnc.id AND tnc.logical_delete = 0
            /*LEFT OUTER JOIN v_localitate_descriere v_localitate_descriere ON  ctr.id_localitate = v_localitate_descriere.id_localitate */
            LEFT OUTER JOIN localitate localitate_ctr ON  ctr.id_localitate = localitate_ctr.id_localitate 
            LEFT OUTER JOIN tip_contract tip_c ON  ctr.id_tip_contract = tip_c.id AND tip_c.logical_delete = 0
            LEFT OUTER JOIN entitate entitate ON  ctr.id_entitatea_mea = entitate.id  AND  entitate.logical_delete = 0

            LEFT OUTER JOIN tara tara ON  oc.id_tara = tara.id_tara  AND  tara.logical_delete = 0
            LEFT OUTER JOIN regiune regiune ON  oc.id_regiune = regiune.id_regiune  AND  regiune.logical_delete = 0
            LEFT OUTER JOIN judet judet ON  oc.id_judet = judet.id_judet  AND  judet.logical_delete = 0
            LEFT OUTER JOIN localitate localitate_obj ON  oc.id_localitate = localitate_obj.id_localitate
            WHERE oc.logical_delete = 0
            AND oc.id = :id_obiectiv
            ORDER BY ctr.id DESC LIMIT 1", array('id_obiectiv' => $id));
        
        if (count($contract) > 0) {
            return View::make('contracte.single')->with('contract', $contract);
        }
    }

    public function postDeleteContract() {
        if (Request::ajax()) {
            if (Session::token() === Input::get('_token')) {
                $id = Input::get('id');
                DB::table('contract')->where('id', $id)->update(array('logical_delete' => 1));
                return $id;
            }
        }
    }    
}
