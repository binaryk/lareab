<?php
class FacturaClientController extends BaseController
{
    public function getFacturi() 
    {
        $facturi = DB::Select("SELECT 
            fact.id_factura, 
            fact.serie, 
            fact.numar,
            date_format(fact.data_facturare, '%d-%m-%Y') as data_facturare,
            fact.id_prestator, fact.id_client, fact.termen_plata,
            date_format(date_add(fact.data_facturare, interval termen_plata day), '%d-%m-%Y') AS scadenta,
            datediff(date_add(fact.data_facturare, interval termen_plata day), now()) AS zile_scadenta, fact.tva,
            (SELECT SUM(le.pret_fara_tva) FROM livrabile_etapa le WHERE le.id_factura = fact.id_factura AND le.logical_delete = 0) AS total_desfasurator,
            (SELECT SUM(df.pret_unitar * df.cantitate) FROM detalii_factura df WHERE df.id_factura = fact.id_factura AND df.logical_delete =0) AS total_detalii,            
            (SELECT ifnull( SUM(valoare_incasata), 0) FROM incasare_factura incf WHERE incf.id_factura = fact.id_factura AND incf.logical_delete = 0) AS incasat,
            ent.denumire AS prestator, cli.denumire AS client
            FROM factura_client fact
            LEFT OUTER JOIN entitate ent ON ent.id_entitate = fact.id_prestator AND ent.logical_delete = 0
            LEFT OUTER JOIN entitate cli ON cli.id_entitate = fact.id_client AND ent.logical_delete = 0
            WHERE fact.logical_delete = 0  
            AND fact.id_organizatie = :id_organizatie
            ORDER BY fact.data_facturare", array('id_organizatie' => $this->date_organizatie[0]->id_organizatie));        

        return View::make('facturi_client.list')
            ->with('facturi', $facturi);   
    }  

    public function getOptiuniFactura($id_factura)
    {
        $factura = self::getFacturaClient($id_factura);       
        return View::make('facturi_client.options')->with('factura', $factura);
    }

    public function getEditFactura($id_factura)
    {        
        $prestatori = self::getEntitatiOrganizatie();
        $clienti = self::getParteneriOrganizatie();
        $factura = self::getFacturaClient($id_factura);

        return View::make('facturi_client.edit')
            ->with('prestatori', $prestatori)
            ->with('clienti', $clienti)
            ->with('factura', $factura);
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
                DB::table('factura_client')
                ->where('id_factura', $id_factura)
                ->update(array(
                    'termen_plata' => Input::get('termen_plata'),
                    'id_prestator' => Input::get('prestator'),
                    'id_client' => Input::get('client'),
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
        $total_defasurator = DB::select("SELECT
            SUM(pret_fara_tva) AS valoare
            FROM livrabile_etapa
            WHERE logical_delete = 0
            AND id_factura = :id_factura", array('id_factura' => $id_factura)); 
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
        $factura = self::getFacturaClient($id_factura);       
        $ums = self::getUM();
        return View::make('facturi_client.list_detalii')
            ->with('factura', $factura)
            ->with('detalii', $detalii)
            ->with('total_defasurator', $total_defasurator[0])       
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

