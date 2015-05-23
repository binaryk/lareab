<?php
class ObiectivController extends BaseController
{
    public function getObiective($id_contract = null) 
    {
        $sql = "SELECT 
            obj.id_obiectiv, 
            obj.numar AS numar_obiectiv, 
            date_format(obj.data_semnare, '%d-%m-%Y') AS data_semnare_obiectiv, 
            obj.denumire AS denumire_obiectiv, 
            obj.id_tara, 
            obj.id_regiune, 
            obj.id_judet, 
            obj.id_localitate, 
            obj.adresa AS adresa_obiectiv, 
            obj.cod_postal AS cod_postal_obiectiv, 
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

            FROM obiectiv obj
            LEFT OUTER JOIN contract ctr ON ctr.id_contract = obj.id_contract AND ctr.logical_delete = 0
            LEFT OUTER JOIN tip_nivel_contractare tnc ON  ctr.id_tip_nivel_contractare = tnc.id_tip_nivel AND tnc.logical_delete = 0
            LEFT OUTER JOIN v_localitate_descriere localitate_ctr ON  ctr.id_localitate = localitate_ctr.id_localitate
            LEFT OUTER JOIN tip_contract tip_c ON  ctr.id_tip_contract = tip_c.id_tip_contract  AND  tip_c.logical_delete = 0
            LEFT OUTER JOIN entitate entitate ON  ctr.id_entitatea_mea = entitate.id_entitate  AND  entitate.logical_delete = 0

            LEFT OUTER JOIN tara tara ON  obj.id_tara = tara.id_tara  AND  tara.logical_delete = 0
            LEFT OUTER JOIN regiune regiune ON  obj.id_regiune = regiune.id_regiune  AND  regiune.logical_delete = 0
            LEFT OUTER JOIN judet judet ON  obj.id_judet = judet.id_judet  AND  judet.logical_delete = 0
            LEFT OUTER JOIN v_localitate_descriere localitate_obj ON  obj.id_localitate = localitate_obj.id_localitate
            WHERE obj.logical_delete = 0";

        $contract = null;
        if ($id_contract !== null) 
        {
            $sql = $sql . " AND obj.id_contract = " . $id_contract;
            $contract = DB::Select("SELECT
                id_contract, numar, date_format(data_semnarii, '%d-%m-%Y') AS data_semnarii 
                FROM contract 
                WHERE id_contract = :id_contract", array('id_contract' => $id_contract));
        }

        $obiective = DB::Select($sql .
            " AND obj.id_organizatie = :id_organizatie", array('id_organizatie' => $this->date_organizatie[0]->id_organizatie));
        
        return View::make('obiective.list')
            ->with('contract', $contract)
            ->with('obiective', $obiective);     
    }  

    public function getAddObiectiv($id_contract = null)
    {        
        $contracte = DB::Select("SELECT 
            id_contract, denumire 
            FROM contract
            WHERE logical_delete = 0
            AND id_organizatie = " . $this->date_organizatie[0]->id_organizatie);      

        $templates = DB::select("SELECT
            id_template, denumire
            FROM template_contract_tipizat_master
            WHERE logical_delete = 0
            ORDER BY id_template");
            //AND id_organizatie = " . $this->date_organizatie[0]->id_organizatie);
      
        return View::make('obiective.add')
            ->with('contracte', $contracte)
            ->with('templates', $templates)
            ->with('contract_selectionat', $id_contract);
    }

    public function postAddObiectiv($id_contract = null)
    {
        $rules = array(
            'numar' => 'required',
            'data_semnare' => 'required',
            'denumire' => 'required'
            );
        $errors = array('required' => 'Campul este obligatoriu.');
        
        $validator = Validator::make(Input::all(), $rules, $errors);
        if ($validator->fails()) {
            return Redirect::back()
                ->with('message', 'Eroare validare formular!')
                ->withErrors($validator)
                ->withInput();
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
                DB::table('obiectiv')
                ->insertGetId(array(
                    'numar' => Input::get('numar'),
                    'data_semnare' => $data_semnarii_us,
                    'denumire' => Input::get('denumire'),
                    'valoare' => $valoare,
                    'tva' => $tva,
                    'id_tara' => Input::get('tara'), 
                    'id_regiune' => Input::get('regiune'), 
                    'id_judet' => Input::get('judet'), 
                    'id_localitate' => Input::get('localitate'),
                    'adresa' => Input::get('adresa'),
                    'cod_postal' => Input::get('cod_postal'),
                    'id_template' => Input::get('template'),
                    'id_contract' => count($id_contract) == 1 ? $id_contract : null,
                    'id_organizatie' => $this->date_organizatie[0]->id_organizatie));
            }
            catch(Exception $e) {
                return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
            }
            return Redirect::back()->with('message', 'Salvare realizata cu succes!')->withInput();
        }
    }

    public function getEditObiectiv($id)
    {        
        $contracte = DB::Select("SELECT 
            id_contract, denumire 
            FROM contract
            WHERE logical_delete = 0
            AND id_organizatie = " . $this->date_organizatie[0]->id_organizatie);
        $templates = DB::select("SELECT
            id_template, denumire
            FROM template_contract_tipizat_master
            WHERE logical_delete = 0
            AND id_organizatie = " . $this->date_organizatie[0]->id_organizatie);
        $obiectiv = DB::Select("SELECT
            obj.id_obiectiv,
            obj.numar,
            date_format(obj.data_semnare, '%d-%m-%Y') AS data_semnare_obiectiv, 
            obj.denumire,
            obj.id_tara,
            obj.id_regiune,
            obj.id_judet,
            obj.id_localitate,
            obj.adresa,
            obj.cod_postal,
            obj.id_contract,
            obj.id_template,
            obj.valoare,
            obj.tva,
            tara.denumire AS tara, 
            regiune.denumire AS regiune, 
            judet.denumire AS judet, 
            localitate_obj.denumire AS localitate
            FROM obiectiv obj
            LEFT OUTER JOIN tara tara ON  obj.id_tara = tara.id_tara  AND  tara.logical_delete = 0
            LEFT OUTER JOIN regiune regiune ON  obj.id_regiune = regiune.id_regiune  AND  regiune.logical_delete = 0
            LEFT OUTER JOIN judet judet ON  obj.id_judet = judet.id_judet  AND  judet.logical_delete = 0
            LEFT OUTER JOIN v_localitate_descriere localitate_obj ON  obj.id_localitate = localitate_obj.id_localitate            
            WHERE obj.logical_delete = 0
            AND obj.id_obiectiv = :id_obiectiv", array('id_obiectiv' => $id));
      

        return View::make('obiective.edit')
            ->with('contracte', $contracte)
            ->with('templates', $templates)
            ->with('obiectiv', $obiectiv[0]);
    }

    public function postEditObiectiv($id)
    {
        $rules = array(
            'numar' => 'required',
            'data_semnare' => 'required',
            'denumire' => 'required'
            );
        $errors = array('required' => 'Campul este obligatoriu.');
        
        $validator = Validator::make(Input::all(), $rules, $errors);
        if ($validator->fails()) {
            return Redirect::back()
                ->with('message', 'Eroare validare formular!')
                ->withErrors($validator)
                ->withInput();
        } 
        else {
            $data_semnarii_eu = DateTime::createFromFormat('d-m-Y', Input::get('data_semnare'));
            $data_semnarii_us = $data_semnarii_eu->format('Y-m-d');            
            $valoare = Input::get('valoare_contract');
            
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
                DB::table('obiectiv')
                ->where('id_obiectiv', $id)
                ->update(array(
                    'numar' => Input::get('numar'),
                    'data_semnare' => $data_semnarii_us,
                    'denumire' => Input::get('denumire'),
                    'valoare' => $valoare,
                    'tva' => $tva,                   
                    'id_tara' => Input::get('tara'), 
                    'id_regiune' => Input::get('regiune'), 
                    'id_judet' => Input::get('judet'), 
                    'id_localitate' => Input::get('localitate'),
                    'adresa' => Input::get('adresa'),
                    'cod_postal' => Input::get('cod_postal'),
                    'id_template' => Input::get('template'),
                    'id_contract' => Input::get('contract'),
                    'id_organizatie' => $this->date_organizatie[0]->id_organizatie));
            }
            catch(Exception $e) {
                return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
            }
            return Redirect::back()->with('message', 'Salvare realizata cu succes!')->withInput();
        }
    }

    public function postDeleteObiectiv() {
        if (Request::ajax()) {
            if (Session::token() === Input::get('_token')) {
                $id = Input::get('id_obiectiv');
                DB::table('obiectiv')->where('id_obiectiv', $id)->update(array('logical_delete' => 1));
                return $id;
            }
        }
    }    
}

