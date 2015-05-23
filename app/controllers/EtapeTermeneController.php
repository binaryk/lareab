<?php
class EtapeTermeneController extends BaseController
{
    public function getEtape($id_obiectiv = null) 
    {
        $sql = "SELECT 
            epl.id_etapa,
            CONCAT(epl.termen_predare, ' ', um_timp.denumire) AS termen_predare,
            epl.id_um_timp,
            (CASE 
                WHEN epl.instiintare_contractor = true THEN 'DA'
                ELSE 'NU'
            END) AS instiintare_contractor,
            epl.nr_etapa,           
            date_format(epl.data_start, '%d-%m-%Y') AS data_start 
            FROM etape_predare_livrabile epl
            LEFT OUTER JOIN um_timp ON um_timp.id_um = epl.id_um_timp AND um_timp.logical_delete = 0
            WHERE epl.logical_delete = 0";

        $obiectiv = null;
        if ($id_obiectiv !== null) 
        {
            $sql = $sql . " AND epl.id_obiectiv = " . $id_obiectiv;
            $obiectiv = DB::Select("SELECT
                id_obiectiv,
                numar, 
                date_format(data_semnare, '%d-%m-%Y') AS data_semnare 
                FROM obiectiv 
                WHERE id_obiectiv = :id_obiectiv", array('id_obiectiv' => $id_obiectiv));
        }
        $etape = DB::Select($sql);
        
        return View::make('etape_termene.list')
            ->with('etape', $etape)
            ->with('obiectiv', $obiectiv);
    }  

    public function getAddEtapa($id_obiectiv)
    {        
        $ums_timp = DB::Select("SELECT 
            id_um, denumire 
            FROM um_timp
            WHERE logical_delete = 0");   
      
        return View::make('etape_termene.add')
            ->with('ums_timp', $ums_timp)
            ->with('id_obiectiv', $id_obiectiv);
    }

    public function postAddEtapa($id_obiectiv)
    {
        $rules = array(
            'nr_etapa' => 'required',
            'termen_predare' => 'required',
            'um_timp' => 'required'
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
            $data_inceperii_eu = DateTime::createFromFormat('d-m-Y', Input::get('data_inceperii'));
            $data_inceperii_us = $data_inceperii_eu->format('Y-m-d');            
          
            try {
                DB::table('etape_predare_livrabile')
                ->insertGetId(array(
                    'nr_etapa' => Input::get('nr_etapa'),
                    'data_start' => $data_inceperii_us,
                    'instiintare_contractor' => Input::get('instiintare'),
                    'termen_predare' => Input::get('termen_predare'),
                    'id_um_timp' => Input::get('um_timp'),
                    'id_obiectiv' => $id_obiectiv));                   
            }
            catch(Exception $e) {
                return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
            }
            return Redirect::back()->with('message', 'Salvare realizata cu succes!')->withInput();
        }
    }

    public function getEditEtapa($id_etapa)
    {               
        $etapa = DB::Select("SELECT 
            epl.id_etapa,
            epl.termen_predare,
            epl.id_um_timp,
            epl.instiintare_contractor,
            epl.nr_etapa,           
            epl.id_obiectiv,
            date_format(epl.data_start, '%d-%m-%Y') AS data_start 
            FROM etape_predare_livrabile epl            
            WHERE epl.logical_delete = 0
            AND epl.id_etapa = :id_etapa", array('id_etapa' => $id_etapa));
        
        $ums_timp = DB::Select("SELECT 
            id_um, denumire 
            FROM um_timp
            WHERE logical_delete = 0"); 

        return View::make('etape_termene.edit')
            ->with('ums_timp', $ums_timp)
            ->with('etapa', $etapa[0]);
    }

    public function postEditEtapa($id_etapa)
    {
        $rules = array(
            'nr_etapa' => 'required|Integer|Max:65535',
            'termen_predare' => 'required|Integer|Max:65535',
            'um_timp' => 'required'
            );
        $errors = array(
            'required' => 'Campul este obligatoriu.',
            'max' => 'Valoarea maxima este 65535',
            'integer' => 'Valoarea asteptata este un numar intreg');
        
        $validator = Validator::make(Input::all(), $rules, $errors);
        if ($validator->fails()) {
            return Redirect::back()
                ->with('message', 'Eroare validare formular!')
                ->withErrors($validator)
                ->withInput();
        } 
        else {
            $data_inceperii_eu = DateTime::createFromFormat('d-m-Y', Input::get('data_inceperii'));
            $data_inceperii_us = $data_inceperii_eu->format('Y-m-d');            
          
            try {
                DB::table('etape_predare_livrabile')
                    ->where('id_etapa', $id_etapa)
                    ->update(array(
                    'nr_etapa' => Input::get('nr_etapa'),
                    'data_start' => $data_inceperii_us,
                    'instiintare_contractor' => Input::get('instiintare'),
                    'termen_predare' => Input::get('termen_predare'),
                    'id_um_timp' => Input::get('um_timp')));
            }
            catch(Exception $e) {
                return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
            }
            return Redirect::back()->with('message', 'Salvare realizata cu succes!')->withInput();
        }
    }

    public function postDeleteEtapa() {
        if (Request::ajax()) {
            if (Session::token() !== Input::get('_token')) {
                $id = Input::get('id_etapa');
                DB::table('etape_predare_livrabile')
                    ->where('id_etapa', $id)
                    ->update(array('logical_delete' => 1));
                return $id;
            }
        }
    }
}

