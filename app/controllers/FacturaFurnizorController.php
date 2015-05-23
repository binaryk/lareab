<?php
class FacturaFurnizorController extends BaseController
{
    public function getFacturi() 
    {
        $facturi = DB::Select("SELECT 
            fact.id_factura, 
            fact.serie, 
            fact.numar,
            date_format(fact.data_facturare, '%d-%m-%Y') as data_facturare,
            fact.id_beneficiar, fact.id_furnizor, fact.termen_plata,
            date_format(date_add(fact.data_facturare, interval termen_plata day), '%d-%m-%Y') AS scadenta,
            datediff(date_add(fact.data_facturare, interval termen_plata day), now()) AS zile_scadenta, fact.tva,
            (SELECT SUM(le.pret_fara_tva) FROM livrabile_etapa le WHERE le.id_factura = fact.id_factura AND le.logical_delete = 0) AS total_desfasurator,
            (SELECT SUM(df.pret_unitar * df.cantitate) FROM detalii_factura df WHERE df.id_factura = fact.id_factura AND df.logical_delete =0) AS total_detalii,
            (SELECT ifnull(SUM(valoare_platita), 0) FROM plata_factura pf WHERE pf.id_factura = fact.id_factura AND pf.logical_delete = 0) AS platit,
            (SELECT CONCAT(c.numar, '/', date_format(c.data_semnarii, '%d-%m-%Y')) 
                FROM contract c
                LEFT OUTER JOIN obiectiv o ON o.id_contract = c.id_contract AND o.logical_delete = 0
                LEFT OUTER JOIN etape_predare_livrabile epl ON o.id_obiectiv = epl.id_obiectiv AND epl.logical_delete = 0
                LEFT OUTER JOIN livrabile_etapa le ON le.id_etapa = epl.id_etapa AND le.logical_delete = 0
                LEFT OUTER JOIN factura_furnizor ff ON ff.id_factura = le.id_factura AND ff.logical_delete = 0
                WHERE le.id_factura = fact.id_factura
                AND c.logical_delete = 0
                GROUP BY c.id_contract) AS contract,
            beneficiar.denumire AS beneficiar, furnizor.denumire AS furnizor
            FROM factura_furnizor fact
            LEFT OUTER JOIN entitate beneficiar ON beneficiar.id_entitate = fact.id_beneficiar AND beneficiar.logical_delete = 0
            LEFT OUTER JOIN entitate furnizor ON furnizor.id_entitate = fact.id_furnizor AND furnizor.logical_delete = 0
            WHERE fact.logical_delete = 0  
            AND fact.id_organizatie = :id_organizatie
            ORDER BY fact.data_facturare", array('id_organizatie' => $this->date_organizatie[0]->id_organizatie));        

        return View::make('facturi_furnizor.list')
            ->with('facturi', $facturi);   
    }  

    public function getOptiuniFactura($id_factura)
    {
        $factura = self::getFacturaFurnizor($id_factura);       
        return View::make('facturi_furnizor.options')->with('factura', $factura);
    }

    public function getAddFactura()
    {        
        $beneficiari = self::getEntitatiOrganizatie();
        $furnizori = self::getParteneriOrganizatie();
        $serii_facturare = self::getSeriiFacturare();

        return View::make('facturi_furnizor.add')
            ->with('beneficiari', $beneficiari)
            ->with('furnizori', $furnizori)
            ->with('serii_facturare', $serii_facturare);
    }

    public function getEditFactura($id_factura)
    {        
        $beneficiari = self::getEntitatiOrganizatie();
        $furnizori = self::getParteneriOrganizatie();
        $factura = self::getFacturaFurnizor($id_factura);

        return View::make('facturi_furnizor.edit')
            ->with('beneficiari', $beneficiari)
            ->with('furnizori', $furnizori)
            ->with('factura', $factura);
    }
    
    public function postAddFactura()
    {     
        $rules = array(
            'serie_facturare' => 'required',
            'data_facturare'  => 'required',
            'beneficiar' => 'required',
            'furnizor' => 'required'
            );
        $errors = array('required' => 'Camp obligatoriu');
        
        $validator = Validator::make(Input::all(), $rules, $errors);
        if ($validator->fails()) {
            return Redirect::back()
                ->with('message', 'Eroare validare formular!')
                ->withErrors($validator)
                ->withInput();
        } 
        else 
        {
            $data_facturare_eu = DateTime::createFromFormat('d-m-Y', Input::get('data_facturare'));
            $data_facturare_us = $data_facturare_eu->format('Y-m-d');            

            $procent_tva = 0;
            try
            {
                $procent_tva = Input::get('procent_tva');
                $procent_tva = str_replace('.', '', $procent_tva);
                $procent_tva = str_replace(',', '.', $procent_tva);
            }
            catch(Exception $e) {}            
              
            try {                
                DB::table('factura_furnizor')
                    ->insertGetId(array(
                    'serie' => Input::get('sf'),
                    'numar' => Input::get('nf'),
                    'data_facturare' => $data_facturare_us,
                    'id_beneficiar' => Input::get('beneficiar'),
                    'id_furnizor' => Input::get('furnizor'),                    
                    'tva' => $procent_tva,
                    'termen_plata' => Input::get('termen_plata', 0),
                    'id_organizatie' => $this->date_organizatie[0]->id_organizatie));
            }
            catch(Exception $e) {
                return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
            }
            return Redirect::back()->with('message', 'Salvare realizata cu succes!')->withInput();
        }       
    }    

    public function postEditFactura($id_factura)
    {        
        $rules = array(
            'termen_plata' => 'required|Integer|Max:365'
            );
        $errors = array('required' => 'Valoare acceptata [0:365].');
        
        $validator = Validator::make(Input::all(), $rules, $errors);
        if ($validator->fails()) {
            return Redirect::back()
                ->with('message', 'Eroare validare formular!')
                ->withErrors($validator)
                ->withInput();
        } 
        else 
        {
            $procent_tva = 0;
            try
            {
                $procent_tva = Input::get('procent_tva');
                $procent_tva = text_2_number($procent_tva);
            }
            catch(Exception $e) {}  
            try {
                DB::table('factura_furnizor')
                ->where('id_factura', $id_factura)
                ->update(array(
                    'termen_plata' => Input::get('termen_plata'),
                    'tva' => $procent_tva,
                    'observatii' => Input::get('observatii')));
            }
            catch(Exception $e) {
                return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
            }
            return Redirect::back()->with('message', 'Salvare realizata cu succes!')->withInput();
        }
    }

    public function postAddDetaliuFactura()
    {     
        $parametri = json_decode(Input::get('parametri'));
        $id_factura = $parametri[0];
        $denumire = $parametri[1];
        $nr_ordine = $parametri[2];  
        $id_um = $parametri[5]; 

        //die($id_um);

        if ($denumire !== "")
        {
            $pret_unitar = 0;
            try
            {
                $pret_unitar = $parametri[4];
                $pret_unitar = str_replace('.', '', $pret_unitar);
                $pret_unitar = str_replace(',', '.', $pret_unitar);
            }
            catch(Exception $e) {}
            
            $cantitate = 0;
            try
            {
                $cantitate = $parametri[3];
                $cantitate = str_replace('.', '', $cantitate);
                $cantitate = str_replace(',', '.', $cantitate);
            }
            catch(Exception $e) {}
            
            try {                
                DB::table('detalii_factura')
                    ->insertGetId(array(
                    'denumire' => $denumire,
                    'pret_unitar' => $pret_unitar,
                    'cantitate' => $cantitate,
                    'nr_ordine' => $nr_ordine,
                    'id_um' => $id_um,
                    'id_factura' => $id_factura));
            }
            catch(Exception $e) 
            {
                ob_clean();
                return Response::json(array('status' => 'KO', 'message' => 'Eroare salvare date ' . $e));
            }   
            ob_clean();     
            return Response::json(array('status' => 'OK', 'message' => 'Salvare realizata cu succes!'));                          
        }
        else
        {
            ob_clean();
            return Response::json(array('status' => 'KO', 'message' => 'Campul denumire este obligatoriu'));
        }
    }

    public function getDetaliiFactura($id_factura)
    {     
        $detalii = DB::Select("SELECT
            df.id_det_fact,
            df.nr_ordine,
            df.denumire AS denumire_produs,
            df.cantitate,
            um.denumire AS um,
            df.pret_unitar        
            FROM detalii_factura df
            LEFT OUTER JOIN um ON um.id_um = df.id_um AND um.logical_delete = 0            
            WHERE df.logical_delete = 0
            AND df.id_factura = :id_factura", array('id_factura' => $id_factura));        
        $factura = self::getFacturaFurnizor($id_factura);       
        $ums = self::getUM();
        return View::make('facturi_furnizor.list_detalii')
            ->with('factura', $factura)
            ->with('detalii', $detalii) 
            ->with('ums', $ums);
    } 

    public function postDeleteDetaliuFactura() {
        if (Request::ajax()) {
            if (Session::token() !== Input::get('_token')) {
                $id = Input::get('id_det_fact');
                DB::table('detalii_factura')->where('id_det_fact', $id)->update(array('logical_delete' => 1));
                return $id;
            }
        }
    }

    /*Actualizeaza un camp cu ajutorul api-ului x-Editable*/
    public function postEditDetalii()
    {
        $pk = Input::get('pk');
        $name = Input::get('name');
        $value = Input::get('value');

        $pret_unitar = 0;
        $cantitate = 0;
        
        $ok = true;
        switch ($name) {           
            case 'pret_unitar':               
                try
                {
                    $pret_unitar = $value;
                    $pret_unitar = str_replace('.', '', $pret_unitar);
                    $pret_unitar = str_replace(',', '.', $pret_unitar);
                    $value = $pret_unitar;
                }
                catch(Exception $e) {}
            case 'cantitate':
                try
                {
                    $cantitate = $value;
                    $cantitate = str_replace('.', '', $cantitate);
                    $cantitate = str_replace(',', '.', $cantitate);
                    $value = $cantitate;
                }
                catch(Exception $e) {}            
            default:                
                break;
        }
        DB::table('detalii_factura')
            ->where('id_det_fact', $pk)
            ->update(array($name => $value));    
    }     
}

