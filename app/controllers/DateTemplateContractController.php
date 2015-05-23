<?php

class DateTemplateContractController extends BaseController {

    public function getDateTemplateContract() {

        /* Main */
        $tip_contract = DB::select("SELECT

            t_ctr.id_tip_contract,
            t_ctr.logical_delete,
            t_ctr.denumire

        FROM tip_contract AS t_ctr
        WHERE t_ctr.logical_delete = 0");

        $tip_activitate = DB::select("SELECT

            t_act.id_tip_activitate,
            t_act.id_organizatie,
            t_act.id_tip_contract,
            t_act.logical_delete,
            t_act.denumire

        FROM tip_activitate AS t_act
        WHERE t_act.logical_delete = 0");

        $tip_activitate_tipizata = DB::select("SELECT

            tip_act_tip.id_tip_activitate_tipizata,
            tip_act_tip.id_tip_activitate,
            tip_act_tip.id_organizatie,
            tip_act_tip.logical_delete,
            tip_act_tip.denumire

        FROM tip_activitate_tipizata AS tip_act_tip
        WHERE tip_act_tip.logical_delete =0");

        $tip_livrabile = DB::select("SELECT

            tip_liv.id_tip_livrabile,
            tip_liv.id_tip_activitate_tipizata,
            tip_liv.id_organizatie,
            tip_liv.logical_delete,
            tip_liv.denumire

        FROM tip_livrabile AS tip_liv
        WHERE tip_liv.logical_delete = 0");

        $tip_obligatii_sarcini = DB::select("SELECT

            tip_ob_sar.id_tip_obligatie_sarcina,
            tip_ob_sar.id_tip_activitate_tipizata,
            tip_ob_sar.id_tip_responsabil,
            tip_ob_sar.id_organizatie,
            tip_ob_sar.logical_delete,
            tip_ob_sar.denumire,
            tip_resp_ob_sar.denumire AS DenumireResponsabil

        FROM tip_obligatii_sarcini AS tip_ob_sar
        LEFT OUTER JOIN tip_responsabil_obligatii_sarcini AS tip_resp_ob_sar ON tip_resp_ob_sar.id_tip_responsabil = tip_ob_sar.id_tip_responsabil 
        AND tip_resp_ob_sar.logical_delete = 0
        WHERE tip_ob_sar.logical_delete = 0");

        $responsabilitate_act_tip = DB::select("SELECT

            resp_act_tip.id_resp_at,
            resp_act_tip.id_activitate_tipizata,
            resp_act_tip.id_responsabilitate,
            resp_act_tip.id_organizatie,
            resp_act_tip.logical_delete,

            concat(rspp.denumire, '  (', cpp.denumire, ', ', spp.denumire, ')')  AS Responsabilitate, 
            rspp.id_responsabil_scp 

        FROM responsabilitate_act_tip AS resp_act_tip
        LEFT OUTER JOIN responsabilitate_subcategorie_personal_proiect AS rspp ON rspp.id_responsabil_scp = resp_act_tip.id_responsabilitate AND rspp.logical_delete = 0
        INNER JOIN subcategorie_personal_proiect spp ON  spp.id_scp = rspp.id_scp  AND  spp.logical_delete = 0 
        INNER JOIN categorie_personal_proiect cpp ON  cpp.id_cp = spp.id_cp  AND  cpp.logical_delete = 0

        WHERE resp_act_tip.logical_delete = 0");

        /* Dropdown objects */
        $tip_resp_ob_sar = DB::select("SELECT 

            DISTINCT tip_resp_ob_sar.denumire, 
            tip_resp_ob_sar.id_tip_responsabil 

        FROM tip_responsabil_obligatii_sarcini AS tip_resp_ob_sar
        WHERE tip_resp_ob_sar.logical_delete = 0 
        ORDER BY tip_resp_ob_sar.id_tip_responsabil");


        $resp_sub_cat_pers_pr = DB::select("SELECT  

            concat(rspp.denumire, '  (', cpp.denumire, ', ', spp.denumire, ')')  AS Responsabilitate, 
            rspp.id_responsabil_scp 

        FROM responsabilitate_subcategorie_personal_proiect AS rspp

        INNER JOIN subcategorie_personal_proiect spp ON  spp.id_scp = rspp.id_scp  AND  spp.logical_delete = 0 
        INNER JOIN categorie_personal_proiect cpp ON  cpp.id_cp = spp.id_cp  AND  cpp.logical_delete = 0

        WHERE rspp.logical_delete = 0");

        return View::make('template_contract.date_template_contract')
                    ->with('tip_contract', $tip_contract)
                    ->with('tip_activitate', $tip_activitate)
                    ->with('tip_activitate_tipizata', $tip_activitate_tipizata)
                    ->with('tip_livrabile', $tip_livrabile)
                    ->with('tip_obligatii_sarcini', $tip_obligatii_sarcini)
                    ->with('responsabilitate_act_tip', $responsabilitate_act_tip)
                    ->with('tip_resp_ob_sar', $tip_resp_ob_sar)
                    ->with('resp_sub_cat_pers_pr', $resp_sub_cat_pers_pr);
    }

    /*** Edit Date Template Contract ***/

    public function postEditDateTemplateContract($table) {

        $columns = DB::select("SELECT column_name FROM information_schema.columns WHERE table_name = '".$table."' ");

        DB::table($table)
        ->where($columns[0]->column_name, Input::get('pk'))
        ->update(array(Input::get('name') => Input::get('value')));
    }

    /*** Add Date Template Contract ***/

    public function postAddTipContract() {     
        
        $parametrii = json_decode(Input::get('parametrii'));
        $denumire = $parametrii[0];

        if($denumire !== "") {
            
            try {                
                
                DB::table('tip_contract')
                    ->insertGetId(array(
                    'denumire' => $denumire));
            }
            catch(Exception $e) {
                
                ob_clean();
                return Response::json(array('status' => 'KO', 'message' => 'Eroare salvare date ' . $e));
            }   
            ob_clean();     
            return Response::json(array('status' => 'OK', 'message' => 'Salvare realizata cu succes!'));                          
        }
        else {
            
            ob_clean();
            return Response::json(array('status' => 'KO', 'message' => 'Campul denumire este obligatoriu'));
        }
    }

    public function postAddTipActivitate() {

        $parametrii = json_decode(Input::get('parametrii'));
        $denumire = $parametrii[0];
        $id_tip_contract = $parametrii[1];

        if($denumire !== "") {
            
            try {                
                
                DB::table('tip_activitate')
                    ->insertGetId(array(
                    'denumire' => $denumire,
                    'id_tip_contract' => $id_tip_contract));
            }
            catch(Exception $e) {
                
                ob_clean();
                return Response::json(array('status' => 'KO', 'message' => 'Eroare salvare date ' . $e));
            }   
            ob_clean();     
            return Response::json(array('status' => 'OK', 'message' => 'Salvare realizata cu succes!'));                          
        }
        else {
            
            ob_clean();
            return Response::json(array('status' => 'KO', 'message' => 'Campul denumire este obligatoriu'));
        }

    }

    public function postAddTipActivitateTipizata() {

        $parametrii = json_decode(Input::get('parametrii'));
        $denumire = $parametrii[0];
        $id_tip_activitate = $parametrii[1];

        if($denumire !== "") {
            
            try {                
                
                DB::table('tip_activitate_tipizata')
                    ->insertGetId(array(
                    'denumire' => $denumire,
                    'id_tip_activitate' => $id_tip_activitate));
            }
            catch(Exception $e) {
                
                ob_clean();
                return Response::json(array('status' => 'KO', 'message' => 'Eroare salvare date ' . $e));
            }   
            ob_clean();     
            return Response::json(array('status' => 'OK', 'message' => 'Salvare realizata cu succes!'));                          
        }
        else {
            
            ob_clean();
            return Response::json(array('status' => 'KO', 'message' => 'Campul denumire este obligatoriu'));
        }
    }

    public function postAddTipLivrabile() {

        $parametrii = json_decode(Input::get('parametrii'));
        $denumire = $parametrii[0];
        $id_tip_activitate_tipizata = $parametrii[1];

        if($denumire !== "") {
            
            try {                
                
                DB::table('tip_livrabile')
                    ->insertGetId(array(
                    'denumire' => $denumire,
                    'id_tip_activitate_tipizata' => $id_tip_activitate_tipizata));
            }
            catch(Exception $e) {
                
                ob_clean();
                return Response::json(array('status' => 'KO', 'message' => 'Eroare salvare date ' . $e));
            }   
            ob_clean();     
            return Response::json(array('status' => 'OK', 'message' => 'Salvare realizata cu succes!'));                          
        }
        else {
            
            ob_clean();
            return Response::json(array('status' => 'KO', 'message' => 'Campul denumire este obligatoriu'));
        }
    }

    public function postAddTipObligatiiSarcini() {

        $parametrii = json_decode(Input::get('parametrii'));
        $denumire = $parametrii[0];
        $id_tip_activitate_tipizata = $parametrii[1];
        $id_tip_responsabil = $parametrii[2];

        if($denumire !== "") {
            
            try {                
                
                DB::table('tip_obligatii_sarcini')
                    ->insertGetId(array(
                    'denumire' => $denumire,
                    'id_tip_activitate_tipizata' => $id_tip_activitate_tipizata,
                    'id_tip_responsabil' => $id_tip_responsabil));
            }
            catch(Exception $e) {
                
                ob_clean();
                return Response::json(array('status' => 'KO', 'message' => 'Eroare salvare date ' . $e));
            }   
            ob_clean();     
            return Response::json(array('status' => 'OK', 'message' => 'Salvare realizata cu succes!'));                          
        }
        else {
            
            ob_clean();
            return Response::json(array('status' => 'KO', 'message' => 'Campul denumire este obligatoriu'));
        }

    }

    public function postAddResponsabilitateActTip() {

        $parametrii = json_decode(Input::get('parametrii'));
        $id_tip_activitate_tipizata = $parametrii[0];
        $id_responsabilitate = $parametrii[1];

        if($id_responsabilitate > 0) {
            
            try {                
                
                DB::table('responsabilitate_act_tip')
                    ->insertGetId(array(
                    'id_activitate_tipizata' => $id_tip_activitate_tipizata,
                    'id_responsabilitate' => $id_responsabilitate));
            }
            catch(Exception $e) {
                
                ob_clean();
                return Response::json(array('status' => 'KO', 'message' => 'Eroare salvare date ' . $e));
            }   
            ob_clean();     
            return Response::json(array('status' => 'OK', 'message' => 'Salvare realizata cu succes!'));                          
        }
        else {
            
            ob_clean();
            return Response::json(array('status' => 'KO', 'message' => 'Campul denumire este obligatoriu'));
        }

    }

    /*** Delete from Date Template Contract ***/
    
    public function postDeleteTipContract() {
        
        if (Request::ajax()) {
            if (Session::token() !== Input::get('_token')) {
                $id = Input::get('id_name');
                DB::table('tip_contract')->where('id_tip_contract', $id)->update(array('logical_delete' => 1));
                return $id;
            }
        }
    }

    public function postDeleteTipActivitate() {
        
        if (Request::ajax()) {
            if (Session::token() !== Input::get('_token')) {
                $id = Input::get('id_name');
                DB::table('tip_activitate')->where('id_tip_activitate', $id)->update(array('logical_delete' => 1));
                return $id;
            }
        }
    }

    public function postDeleteTipActivitateTipizata() {
        
        if (Request::ajax()) {
            if (Session::token() !== Input::get('_token')) {
                $id = Input::get('id_name');
                DB::table('tip_activitate_tipizata')->where('id_tip_activitate_tipizata', $id)->update(array('logical_delete' => 1));
                return $id;
            }
        }
    }

    public function postDeleteTipLivrabile() {

        if (Request::ajax()) {
            if (Session::token() !== Input::get('_token')) {
                $id = Input::get('id_name');
                DB::table('tip_livrabile')->where('id_tip_livrabile', $id)->update(array('logical_delete' => 1));
                return $id;
            }
        }
    }

    public function postDeleteTipObligatiiSarcini() {

        if (Request::ajax()) {
            if (Session::token() !== Input::get('_token')) {
                $id = Input::get('id_name');
                DB::table('tip_obligatii_sarcini')->where('id_tip_obligatie_sarcina', $id)->update(array('logical_delete' => 1));
                return $id;
            }
        }
    }

    public function postDeleteResponsabilitateActTip() {

        if (Request::ajax()) {
            if (Session::token() !== Input::get('_token')) {
                $id = Input::get('id_name');
                DB::table('responsabilitate_act_tip')->where('id_resp_at', $id)->update(array('logical_delete' => 1));
                return $id;
            }
        }
    }   
}