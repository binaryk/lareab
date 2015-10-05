<?php
class IncasariFacturaController extends BaseController
{
	public function getIncasariFactura($id_factura) {
        $factura = self::getFacturaClient($id_factura);         	
        $incasari = DB::select("SELECT        	
			id_incasare,
			date_format(data_incasarii, '%d-%m-%Y') as data_incasarii,
			valoare_incasata,			
            valoare_virata_CG
			FROM incasare_factura			
			WHERE logical_delete = 0            
            AND id_factura = :id_factura", array('id_factura' => $id_factura)); 
        return View::make('incasari_factura.list')
        	->with('incasari', $incasari)
        	->with('factura', $factura);        	
    }

    public function getEditIncasareFactura($id_incasare)
    {
        $incasare = DB::select("SELECT
            date_format(data_incasarii, '%d-%m-%Y') as data_incasarii,,
            valoare_incasata,
            valoare_virata_CG
            FROM incasare_factura
            WHERE id_incasare = :id_incasare", array('id_incasare' => $id_incasare));
        return View::make("incasari_factura.edit")
            ->with('incasare', $incasare[0]);
    }

    public function getAddIncasareFactura($id_factura)
    {
        $factura = self::getFactura($id_factura);
        return View::make('incasari_factura.add')
            ->with('factura', $factura); 
    }

    public function postAddIncasareFactura($id_factura) {
        $rules = array(
            'data_incasare' => 'required',
            'valoare_incasata' => 'required');
        $errors = array('required' => 'Campul este obligatoriu.');
        
        $validator = Validator::make(Input::all(), $rules, $errors);
        if ($validator->fails()) {
            return Redirect::back()->with('message', 'Eroare validare formular!')->withErrors($validator)->withInput();
        } 
        else {     
            $data_incasarii_eu = DateTime::createFromFormat('d-m-Y', Input::get('data_incasare'));
            $data_incasarii_us = $data_incasarii_eu->format('Y-m-d');            
            
            $valoare_incasata = 0;
            if (Input::has('valoare_incasata'))
            //if (!empty(Input::get('valoare_incasata')))
            {
                $valoare_incasata = Input::get('valoare_incasata');
                $valoare_incasata = self::text_2_number($valoare_incasata);
            }
            
            $valoare_virata_CG = 0;
            if (Input::has('valoare_virata_CG'))
            //if (!empty(Input::get('valoare_virata_CG')))
            {
                $valoare_virata_CG = Input::get('valoare_virata_CG');
                $valoare_virata_CG = self::text_2_number($valoare_virata_CG);
            }
            
            try {
                DB::table('incasare_factura')
                ->insertGetId(array(
                    'data_incasarii' => $data_incasarii_us, 
                    'valoare_incasata' => $valoare_incasata, 
                    'valoare_virata_CG' => $valoare_virata_CG,
                    'id_factura' => $id_factura));
            }
            catch(Exception $e) {
                return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
            }
            return Redirect::back()->with('message', 'Salvare realizata cu succes!')->withInput();
        }
    }  

    public function postEditIncasareFactura($id_incasare) {
        $rules = array(
            'data_incasare' => 'required',
            'valoare_incasata' => 'required');
        $errors = array('required' => 'Campul este obligatoriu.');
        
        $validator = Validator::make(Input::all(), $rules, $errors);
        if ($validator->fails()) {
            return Redirect::back()->with('message', 'Eroare validare formular!')->withErrors($validator)->withInput();
        } 
        else {     
            $data_incasarii_eu = DateTime::createFromFormat('d-m-Y', Input::get('data_incasare'));
            $data_incasarii_us = $data_incasarii_eu->format('Y-m-d');            
            
            $valoare_incasata = 0;
            if (Input::has('valoare_incasata'))
            //if (!empty(Input::get('valoare_incasata')))
            {
                $valoare_incasata = Input::get('valoare_incasata');
                $valoare_incasata = str_replace('.', '', $valoare_incasata);
                $valoare_incasata = str_replace(',', '.', $valoare_incasata);
            }
            
            $valoare_virata_CG = 0;
            if (Input::has('valoare_virata_CG'))
            //if (!empty(Input::get('valoare_virata_CG')))
            {
                $valoare_virata_CG = Input::get('valoare_virata_CG');
                $valoare_virata_CG = str_replace('.', '', $valoare_virata_CG);
                $valoare_virata_CG = str_replace(',', '.', $valoare_virata_CG);
            }
            
            try {
                DB::table('incasare_factura')
                    ->where('id_incasare', $id_incasare)
                    ->update(array(
                        'data_incasarii' => $data_incasarii_us, 
                        'valoare_incasata' => $valoare_incasata, 
                        'valoare_virata_CG' => $valoare_virata_CG,
                        'id_factura' => $id_factura));
            }
            catch(Exception $e) {
                return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
            }
            return Redirect::back()->with('message', 'Salvare realizata cu succes!')->withInput();
        }
    }  
    
    public function postDeleteIncasare() {
        if (Request::ajax()) {
            if (Session::token() === Input::get('_token')) {
                $id = Input::get('id_incasare');
                DB::table('incasare_factura')->where('id_incasare', $id)->update(array('logical_delete' => 1));
                return $id;
            }
        }
    }    
}