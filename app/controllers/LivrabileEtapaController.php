<?php

class LivrabileEtapaController extends BaseController
{
    public function getLivrabile($id_etapa)
    {
        $livrabile = DB::select("SELECT 
            le.id_livrabil_etapa, 
            le.id_etapa, 
            le.id_livrabil, 
            le.id_stadiu,
            tl.denumire AS livrabil, 
            sl.denumire AS stadiu,
            le.pret_fara_tva

            FROM livrabile_etapa le
            LEFT OUTER JOIN tip_livrabile tl ON le.id_livrabil = tl.id_tip_livrabile AND tl.logical_delete = 0            
            LEFT OUTER JOIN stadiu_livrabil sl ON le.id_stadiu = sl.id_stadiu_livrabil AND sl.logical_delete = 0
            WHERE le.logical_delete = 0
            AND le.id_etapa = :id_etapa", array('id_etapa' => $id_etapa));            

        return View::make('livrabile_etapa.list')
            ->with('livrabile', $livrabile)
            ->with('id_etapa', $id_etapa);
    }

    public function getAddLivrabilEtapa($id_etapa)
    {        
        $stadii = DB::Select("SELECT 
            id_stadiu_livrabil, denumire 
            FROM stadiu_livrabil
            WHERE logical_delete = 0");   
        $livrabile = DB::Select("SELECT 
            tl.id_tip_livrabile AS id_livrabil, 
            tl.denumire 
            FROM etape_predare_livrabile epl
            INNER JOIN obiectiv obj ON obj.id_obiectiv = epl.id_obiectiv AND obj.logical_delete = 0
            INNER JOIN template_contract_tipizat_master tctm ON tctm.id_template = obj.id_template AND tctm.logical_delete = 0
            INNER JOIN template_contract_tipizat_detail tctd ON tctd.id_template_contract_tipizat_master = tctm.id_template AND tctd.logical_delete = 0
            INNER JOIN tip_livrabile tl ON tl.id_tip_livrabile = tctd.id_tip_livrabil AND tl.logical_delete = 0
            WHERE epl.id_etapa = :id_etapa", array('id_etapa' => $id_etapa));   
        //Debugbar::info("ETP=" . $id_etapa);
        return View::make('livrabile_etapa.add')
            ->with('stadii', $stadii)
            ->with('livrabile', $livrabile)
            ->with('id_etapa', $id_etapa);
    }

    public function postAddLivrabilEtapa($id_etapa)
    {
        $rules = array(
            'livrabil' => 'required|integer|min:1',
            'stadiu' => 'required|integer|min:1'            
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
            $valoare = 0;
            if (!empty(Input::get('valoare_livrabil')))
            {
                $valoare = Input::get('valoare_livrabil');
                $valoare = self::text_2_number($valoare);
            }
                  
            try {
                DB::table('livrabile_etapa')
                ->insertGetId(array(
                    'id_livrabil' => Input::get('livrabil'),
                    'id_etapa' => $id_etapa,
                    'id_stadiu' => Input::get('stadiu'),
                    'pret_fara_tva' => $valoare));                   
            }
            catch(Exception $e) {
                return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
            }
            return Redirect::back()->with('message', 'Salvare realizata cu succes!')->withInput();
        }
    }        
}
