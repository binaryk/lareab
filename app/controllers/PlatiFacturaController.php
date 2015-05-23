<?php
class PlatiFacturaController extends BaseController
{
	public function getPlatiFactura($id_factura) 
    {
        $factura = self::getFacturaFurnizor($id_factura);         	
        $plati = DB::select("SELECT        	
			id_plata,
			date_format(data_platii, '%d-%m-%Y') as data_platii,
			valoare_platita,
            valoare_virata_CG
			FROM plata_factura			
			WHERE logical_delete = 0            
            AND id_factura = :id_factura", array('id_factura' => $id_factura)); 
        return View::make('plati_factura.list')
        	->with('plati', $plati)
        	->with('factura', $factura);        	
    }

    public function getEditPlataFactura($id_plata)
    {
        $plata = DB::select("SELECT
            date_format(data_platii, '%d-%m-%Y') as data_platii,
            valoare_platita,
            valoare_virata_CG
            FROM plata_factura
            WHERE id_plata = :id_plata", array('id_plata' => $id_plata));
        return View::make("plati_factura.edit")
            ->with('plata', $plata[0]);
    }

    public function getAddPlataFactura($id_factura)
    {
        $factura = self::getFacturaFurnizor($id_factura);
        return View::make('plati_factura.add')
            ->with('factura', $factura); 
    }

    public function postAddPlataFactura($id_factura) {
        $rules = array(
            'data_plata' => 'required',
            'valoare_platita' => 'required');
        $errors = array('required' => 'Campul este obligatoriu.');
        
        $validator = Validator::make(Input::all(), $rules, $errors);
        if ($validator->fails()) {
            return Redirect::back()->with('message', 'Eroare validare formular!')->withErrors($validator)->withInput();
        } 
        else {     
            $data_platii_eu = DateTime::createFromFormat('d-m-Y', Input::get('data_plata'));
            $data_platii_us = $data_platii_eu->format('Y-m-d');            
            
            $valoare_platita = 0;
            if (!empty(Input::get('valoare_platita')))
            {
                $valoare_platita = Input::get('valoare_platita');
                $valoare_platita = text_2_number($valoare_platita);
            }

            $valoare_virata_CG = 0;
            if (!empty(Input::get('valoare_virata_CG')))
            {
                $valoare_virata_CG = Input::get('valoare_virata_CG');
                $valoare_virata_CG = text_2_number($valoare_virata_CG);
            }
                      
            try {
                DB::table('plata_factura')
                ->insertGetId(array(
                    'data_platii' => $data_platii_us, 
                    'valoare_platita' => $valoare_platita, 
                    'valoare_virata_CG' => $valoare_virata_CG,
                    'id_factura' => $id_factura));
            }
            catch(Exception $e) {
                return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
            }
            return Redirect::back()->with('message', 'Salvare realizata cu succes!')->withInput();
        }
    }  

    public function postEditPlataFactura($id_plata) {
        $rules = array(
            'data_plata' => 'required',
            'valoare_platita' => 'required');
        $errors = array('required' => 'Campul este obligatoriu.');
        
        $validator = Validator::make(Input::all(), $rules, $errors);
        if ($validator->fails()) {
            return Redirect::back()->with('message', 'Eroare validare formular!')->withErrors($validator)->withInput();
        } 
        else {                             
            $data_platii_eu = DateTime::createFromFormat('d-m-Y', Input::get('data_plata'));            
            $data_platii_us = $data_platii_eu->format('Y-m-d');            
            
            $valoare_platita = 0;
            if (!empty(Input::get('valoare_platita')))
            {
                $valoare_platita = Input::get('valoare_platita');
                $valoare_platita = text_2_number($valoare_platita);
            }

            $valoare_virata_CG = 0;
            if (!empty(Input::get('valoare_virata_CG')))
            {
                $valoare_virata_CG = Input::get('valoare_virata_CG');
                $valoare_virata_CG = text_2_number($valoare_virata_CG);
            }          
           
            try {
                DB::table('plata_factura')
                    ->where('id_plata', $id_plata)
                    ->update(array(
                        'data_platii' => $data_platii_us, 
                        'valoare_platita' => $valoare_platita,
                        'valoare_virata_CG' => $valoare_virata_CG, 
                        'id_factura' => $id_factura));
            }
            catch(Exception $e) {
                return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
            }
            return Redirect::back()->with('message', 'Salvare realizata cu succes!')->withInput();
        }
    }  
    
    public function postDeletePlata() {
        if (Request::ajax()) {
            if (Session::token() === Input::get('_token')) {
                $id = Input::get('id_plata');
                DB::table('plata_factura')->where('id_plata', $id)->update(array('logical_delete' => 1));
                return $id;
            }
        }
    }    
}