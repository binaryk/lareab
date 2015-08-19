<?php
class ObiectivController extends BaseController
{
    public function _getObiective($id_contract = null) 
    {
        $sql = "SELECT 
            obj.id, 
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
            ctr.numar AS numar_contract,
            ctr.id_tip_contract,
            date_format(ctr.data_semnarii, '%d-%m-%Y') as data_semnare_contract,
            date_format(data_semnarii,'%Y%m%d') AS ord_data_semnare_contract,
            ctr.id_tip_nivel_contractare,
            ctr.id_entitatea_mea,
            ctr.id_partener,
            ctr.denumire AS denumire_contract,
            ctr.valoare,
            ctr.tva,
            tnc.denumire AS parte_in_contract,
            tip_c.denumire AS tip_contract,
            entitate.denumire AS entitatea_mea,
            localitate_ctr.denumire AS localitate_contract,
            so.denumire AS stadiu_obiectiv

            FROM obiectiv obj
            LEFT OUTER JOIN contract ctr ON ctr.id = obj.id_contract AND ctr.logical_delete = 0
            LEFT OUTER JOIN stadiu_obiectiv so ON so.id = obj.id_stadiu AND so.logical_delete = 0
            LEFT OUTER JOIN tip_nivel_contractare tnc ON  ctr.id_tip_nivel_contractare = tnc.id AND tnc.logical_delete = 0
            LEFT OUTER JOIN localitate localitate_ctr ON  ctr.id_localitate = localitate_ctr.id_localitate
            LEFT OUTER JOIN tip_contract tip_c ON  ctr.id_tip_contract = tip_c.id  AND  tip_c.logical_delete = 0
            LEFT OUTER JOIN entitate entitate ON  ctr.id_entitatea_mea = entitate.id  AND  entitate.logical_delete = 0

            LEFT OUTER JOIN tara tara ON  obj.id_tara = tara.id_tara  AND  tara.logical_delete = 0
            LEFT OUTER JOIN regiune regiune ON  obj.id_regiune = regiune.id_regiune  AND  regiune.logical_delete = 0
            LEFT OUTER JOIN judet judet ON  obj.id_judet = judet.id_judet  AND  judet.logical_delete = 0
            LEFT OUTER JOIN localitate localitate_obj ON  obj.id_localitate = localitate_obj.id_localitate
            WHERE obj.logical_delete = 0";

        $contract = null;
        $parametri = array();

        $sql = $sql . " AND obj.id_organizatie = :id_organizatie";        
        $parametri['id_organizatie'] = self::organizatie()[0]->id_organizatie;
        
        if ($id_contract) 
        {
            $sql = $sql . " AND obj.id_contract = :id_contract";
            $parametri['id_contract'] = $id_contract;
            $contract = DB::Select("SELECT
                id, numar, date_format(data_semnarii, '%d-%m-%Y') AS data_semnarii 
                FROM contract 
                WHERE id = :id_contract", array('id_contract' => $id_contract));
        }  
//dd($id_contract);  //{id}
        $obiective = DB::Select($sql, $parametri);
//dd($obiective);
        return View::make('obiective.list')
            ->with('contract', $contract)
            ->with('obiective', $obiective);     
    } 
    
    public function getObiective($id_contract = null) 
    {
        $sql = "SELECT 
            obj.id, 
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
            ctr.numar AS numar_contract,
            ctr.id_tip_contract,
            date_format(ctr.data_semnarii, '%d-%m-%Y') as data_semnare_contract,
            date_format(data_semnarii,'%Y%m%d') AS ord_data_semnare_contract,
            ctr.id_tip_nivel_contractare,
            ctr.id_entitatea_mea,
            ctr.id_partener,
            ctr.denumire AS denumire_contract,
            ctr.valoare,
            ctr.tva,
            tnc.denumire AS parte_in_contract,
            tip_c.denumire AS tip_contract,
            entitate.denumire AS entitatea_mea,
            localitate_ctr.denumire AS localitate_contract,
            so.denumire AS stadiu_obiectiv

            FROM obiectiv obj
            LEFT OUTER JOIN contract ctr ON ctr.id = obj.id_contract AND ctr.logical_delete = 0
            LEFT OUTER JOIN stadiu_obiectiv so ON so.id = obj.id_stadiu AND so.logical_delete = 0
            LEFT OUTER JOIN tip_nivel_contractare tnc ON  ctr.id_tip_nivel_contractare = tnc.id AND tnc.logical_delete = 0
            LEFT OUTER JOIN localitate localitate_ctr ON  ctr.id_localitate = localitate_ctr.id_localitate
            LEFT OUTER JOIN tip_contract tip_c ON  ctr.id_tip_contract = tip_c.id  AND  tip_c.logical_delete = 0
            LEFT OUTER JOIN entitate entitate ON  ctr.id_entitatea_mea = entitate.id  AND  entitate.logical_delete = 0

            LEFT OUTER JOIN tara tara ON  obj.id_tara = tara.id_tara  AND  tara.logical_delete = 0
            LEFT OUTER JOIN regiune regiune ON  obj.id_regiune = regiune.id_regiune  AND  regiune.logical_delete = 0
            LEFT OUTER JOIN judet judet ON  obj.id_judet = judet.id_judet  AND  judet.logical_delete = 0
            LEFT OUTER JOIN localitate localitate_obj ON  obj.id_localitate = localitate_obj.id_localitate
            WHERE obj.logical_delete = 0";

        $contract = null;
        $parametri = array();
        
        //Cauta departamentele de care apartine utilizatorul actual
        $ids = "";
        $departamente = Confide::getDepartamenteUser();
        if($departamente !== null)
        {
            $ids = self::getIDsDepartamente($departamente);
        }
        
        $sql = $sql . " AND obj.id_departament IN (" . $ids . ")";                
        
        if ($id_contract) 
        {
            $sql = $sql . " AND obj.id_contract = :id_contract";
            $parametri['id_contract'] = $id_contract;
            $contract = DB::Select("SELECT
                id, numar, date_format(data_semnarii, '%d-%m-%Y') AS data_semnarii 
                FROM contract 
                WHERE id = :id_contract", array('id_contract' => $id_contract));
        }  
//dd($id_contract);  //{id}
        $obiective = DB::Select($sql, $parametri);
//dd($obiective);
        return View::make('obiective.list')
            ->with('contract', $contract)
            ->with('obiective', $obiective);     
    } 
    public function getStadiiObiectiv()
    {
        $stadii_obiectiv = DB::select("SELECT 
            id, denumire 
            FROM stadiu_obiectiv
            WHERE logical_delete = 0");
        return self::object_to_array($stadii_obiectiv);        
    } 

    public function getAddObiectiv($id_contract = null)
    {    
        $stadii_obiectiv = self::getStadiiObiectiv();
        $ids = self::getIDsDepartamente(Confide::getDepartamenteUser());
        $contracte = DB::Select("SELECT 
            id, denumire 
            FROM contract
            WHERE logical_delete = 0
            AND id_departament IN (" . $ids . ")");      

        $templates = DB::select("SELECT
            id, denumire
            FROM template_contract_tipizat_master
            WHERE logical_delete = 0
            ORDER BY id");
        $id_tara = null;
        $id_regiune = null;
        $id_judet = null;        
        $contract = null;

        if ($id_contract)
        {
            $contract = DB::Select("SELECT
                id, id_tara, id_regiune, id_judet
                FROM contract 
                WHERE id = :id_contract", array('id_contract' => $id_contract));
            if (count($contract) == 1)
            {
                $id_tara = $contract[0]->id_tara;
                $id_regiune = $contract[0]->id_regiune;
                $id_judet = $contract[0]->id_judet;
            }            
        }
      
        return View::make('obiective.add')
            ->with('contracte', self::object_to_array($contracte))
            ->with('templates', self::object_to_array($templates))
            ->with('stadii_obiectiv', $stadii_obiectiv)
            ->with('id_contract', $id_contract)
            ->with('id_tara', $id_tara)
            ->with('id_regiune', $id_regiune)
            ->with('id_judet', $id_judet)
            ->with('departamente', self::object_to_array(Confide::getDepartamenteUser())); 
    }

    public function postAddObiectiv($id_contract = null)
    {
        $rules = array(
            'departament' => 'required',
            'numar' => 'required',
            'data_semnare' => 'required',
            'denumire' => 'required',
            'stadiu_obiectiv' => 'required',
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
            if (Input::has('valoare_obiectiv'))
            //if (!empty(Input::get('valoare_obiectiv')))
            {
                $valoare = Input::get('valoare_obiectiv');
                $valoare = str_replace('.', '', $valoare);
                $valoare = str_replace(',', '.', $valoare);
            }

            $tva = 0;   
            if (Input::has('procent_tva'))                         
            //if (!empty(Input::get('procent_tva')))
            {
                $tva = Input::get('procent_tva');    
                $tva = str_replace('.', '', $tva);
                $tva = str_replace(',', '.', $tva);
            }
            $id_template = null;
            if (Input::has('template'))
            //if (!empty(Input::get('template')))
            {
                try
                {
                    $id_template = (int)Input::get('template');
                } 
                catch (Exception $e) 
                {
                }
            }

            try {
                DB::table('obiectiv')
                ->insertGetId(array(
                    'numar' => Input::get('numar'),
                    'nr_reg_proiect' => Input::get('nr_reg_proiect'),
                    'data_semnare' => $data_semnarii_us,
                    'id_stadiu' => Input::get('stadiu_obiectiv'),
                    'denumire' => Input::get('denumire'),
                    'valoare' => $valoare,
                    'tva' => $tva,
                    'id_tara' => Input::get('tara'), 
                    'id_regiune' => Input::get('regiune'), 
                    'id_judet' => Input::get('judet'), 
                    'id_localitate' => Input::get('localitate'),
                    'adresa' => Input::get('adresa'),
                    'cod_postal' => Input::get('cod_postal'),
                    'id_template' => $id_template,
                    'id_contract' => $id_contract > 0 ? $id_contract : null,
                    'id_departament' => intval(Input::get('departament'))));
            }
            catch(Exception $e) {
                return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
            }
            //return Redirect::back()->with('message', 'Salvare realizata cu succes!')->withInput();            
            return Redirect::route('obiectiv_list_contract', $id_contract);
        }
    }

    public function getEditObiectiv($id)
    {    
        $stadii_obiectiv = self::getStadiiObiectiv();
        $ids = self::getIDsDepartamente(Confide::getDepartamenteUser());        
        $contracte = DB::select("SELECT 
            id, denumire 
            FROM contract
            WHERE logical_delete = 0
            AND id_departament IN (" . $ids . ")"); 
        $templates = DB::select("SELECT
            id, denumire
            FROM template_contract_tipizat_master
            WHERE logical_delete = 0
            AND id_organizatie = " . self::organizatie()[0]->id_organizatie);
        $obiectiv = DB::select("SELECT
            obj.id,
            obj.nr_reg_proiect,
            obj.numar,
            date_format(obj.data_semnare, '%d-%m-%Y') AS data_semnare_obiectiv, 
            obj.denumire AS denumire_obj,
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
            obj.id_stadiu,
            obj.id_departament,
            tara.denumire AS tara, 
            regiune.denumire AS regiune, 
            judet.denumire AS judet, 
            localitate_obj.denumire AS localitate
            FROM obiectiv obj
            LEFT OUTER JOIN tara tara ON  obj.id_tara = tara.id_tara  AND  tara.logical_delete = 0
            LEFT OUTER JOIN regiune regiune ON  obj.id_regiune = regiune.id_regiune  AND  regiune.logical_delete = 0
            LEFT OUTER JOIN judet judet ON  obj.id_judet = judet.id_judet  AND  judet.logical_delete = 0
            LEFT OUTER JOIN localitate localitate_obj ON  obj.id_localitate = localitate_obj.id_localitate            
            WHERE obj.logical_delete = 0
            AND obj.id = :id", array('id' => $id));
      
        return View::make('obiective.edit')
            ->with('contracte', self::object_to_array($contracte))
            ->with('templates', self::object_to_array($templates))
            ->with('stadii_obiectiv', $stadii_obiectiv)
            ->with('obiectiv', $obiectiv[0])
            ->with('departamente', self::object_to_array(Confide::getDepartamenteUser()));
    }

    public function postEditObiectiv($id)
    {
        $rules = array(
            'departament' => 'required',
            'numar' => 'required',
            'data_semnare' => 'required',
            'denumire_obj' => 'required',
            'stadiu_obiectiv' => 'required',
            );
        $errors = array('required' => 'Campul este obligatoriu.');
        //dd(Input::all());
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
            if (Input::has('valoare_obiectiv'))
            //if (!empty(Input::get('valoare_obiectiv')))
            {
                $valoare = Input::get('valoare_obiectiv');
                $valoare = str_replace('.', '', $valoare);
                $valoare = str_replace(',', '.', $valoare);
            }

            $tva = 0;                
            if (Input::has('procent_tva'))            
            //if (!empty(Input::get('procent_tva')))
            {
                $tva = Input::get('procent_tva');    
                $tva = str_replace('.', '', $tva);
                $tva = str_replace(',', '.', $tva);
            }
            $template = Input::get('template');
            if ($template == null) 
            {
                $template = 0;
            }
            else
            {
                $template = 1;            
            }
            //return intval(Input::get('regiune'));
            //dd(Input::get('regiune')>0?Input::get('regiune'):0);

            try {
                DB::table('obiectiv')
                ->where('id', $id)
                ->update(array(
                    'numar' => Input::get('numar'),
                    'nr_reg_proiect' => Input::get('nr_reg_proiect'),
                    'data_semnare' => $data_semnarii_us,
                    'id_stadiu' => intval(Input::get('stadiu_obiectiv')),
                    'denumire' => Input::get('denumire_obj'),
                    'valoare' => $valoare,
                    'tva' => $tva,                   
                    'id_tara' => intval(Input::get('tara')), 
                    'id_regiune' => intval(Input::get('regiune')), 
                    'id_judet' => intval(Input::get('judet')), 
                    'id_localitate' => intval(Input::get('localitate')),
                    'adresa' => Input::get('adresa'),
                    'cod_postal' => Input::get('cod_postal'),
                    'id_template' => intval($template),
                    'id_contract' => intval(Input::get('contract')),
                    'id_departament' => intval(Input::get('departament'))));
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
                $id = Input::get('id');
                DB::table('obiectiv')->where('id', $id)->update(array('logical_delete' => 1));
                return $id;
            }
        }
    }    
}

