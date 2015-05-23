<?php

class TemplateContractController extends BaseController {

    /*** Get Template Contract ***/

	public function getTemplateContract() {

        /*** Main ***/
		$template_contract_tipizat_master = DB::select("SELECT 

            tctm.id_template, 
            tctm.denumire,
            tctm.observatii, 
            tctm.id_organizatie, 
            tctm.id_tip_contract, 
            tctm.id_categoria_investitie,

            cat_inv.denumire AS Categorie,
            tip_ctr.denumire AS TipContract

        FROM template_contract_tipizat_master AS tctm
        LEFT OUTER JOIN categoria_investitie AS cat_inv ON cat_inv.id_categoria_investitie = tctm.id_categoria_investitie AND cat_inv.logical_delete = 0
        LEFT OUTER JOIN tip_contract AS tip_ctr ON tip_ctr.id_tip_contract = tctm.id_tip_contract AND tip_ctr.logical_delete = 0
        WHERE tctm.logical_delete = 0  
        ORDER BY tctm.id_template");

        $template_contract_tipizat_detail = DB::select("SELECT

            tctd.id_template_contract_tipizat_detail,
            tctd.id_template_contract_tipizat_master,
            tctd.id_tip_livrabil,
            tctd.id_tip_obligatie,
            tctd.id_tip_activitate,
            tctd.id_tip_activitate_tipizata,
            tctd.id_organizatie,

            tip_act.id_tip_activitate AS IdTipActivitate_child,
            tip_act.denumire AS Activitate,

            tip_act_tip.id_tip_activitate_tipizata AS IdTipActivitateTipizata_child,
            tip_act_tip.denumire AS ActivitateTipizata,

            tip_liv.id_tip_livrabile AS IdTipLivrabile_child,
            tip_liv.denumire AS Livrabil,

            tip_ob_sar.id_tip_obligatie_sarcina AS IdTipObligatieSarcina_child,
            tip_ob_sar.denumire AS Obligatie


        FROM template_contract_tipizat_detail AS tctd
        LEFT OUTER JOIN tip_activitate AS tip_act ON tctd.id_tip_activitate = tip_act.id_tip_activitate AND tip_act.logical_delete = 0
        LEFT OUTER JOIN tip_activitate_tipizata AS tip_act_tip ON tctd.id_tip_activitate_tipizata = tip_act_tip.id_tip_activitate_tipizata AND tip_act_tip.logical_delete = 0
        LEFT OUTER JOIN tip_livrabile AS tip_liv ON tctd.id_tip_livrabil = tip_liv.id_tip_livrabile AND tip_liv.logical_delete = 0
        LEFT OUTER JOIN tip_obligatii_sarcini tip_ob_sar ON tctd.id_tip_obligatie = tip_ob_sar.id_tip_obligatie_sarcina AND tip_ob_sar.logical_delete = 0

        WHERE tctd.logical_delete = 0");
        
        /*** Dropdown objects ***/
        $categoria_investitie = DB::select("SELECT 

            DISTINCT cat_inv.denumire, 
            cat_inv.id_categoria_investitie 

        FROM categoria_investitie AS cat_inv 
        WHERE cat_inv.logical_delete = 0  
        ORDER BY cat_inv.id_categoria_investitie");

        $tip_contract = DB::select("SELECT 

            DISTINCT tip_ctr.denumire, 
            tip_ctr.id_tip_contract 

        FROM tip_contract AS tip_ctr 
        WHERE tip_ctr.logical_delete = 0 
        ORDER BY tip_ctr.id_tip_contract");

        $tip_activitate = DB::select("SELECT

            tip_act.id_tip_activitate,
            tip_act.denumire,
            tip_act.id_tip_contract,
            tip_act.id_organizatie,
            tip_act.logical_delete

        FROM tip_activitate AS tip_act
        WHERE tip_act.logical_delete = 0 
        ORDER BY tip_act.id_tip_activitate");

        $tip_activitate_tipizata = DB::select("SELECT

            tip_act_tip.id_tip_activitate_tipizata,
            tip_act_tip.denumire,
            tip_act_tip.id_tip_activitate,
            tip_act_tip.id_organizatie,
            tip_act_tip.logical_delete

        FROM tip_activitate_tipizata AS tip_act_tip
        WHERE tip_act_tip.logical_delete = 0
        ORDER BY tip_act_tip.id_tip_activitate_tipizata");

        $tip_livrabile = DB::select("SELECT

            tip_liv.id_tip_livrabile,
            tip_liv.denumire,
            tip_liv.id_tip_activitate_tipizata,
            tip_liv.id_organizatie,
            tip_liv.logical_delete

        FROM tip_livrabile AS tip_liv
        WHERE tip_liv.logical_delete = 0
        ORDER BY tip_liv.id_tip_livrabile");

        $tip_obligatii_sarcini = DB::select("SELECT

            tip_ob_sar.id_tip_obligatie_sarcina,
            tip_ob_sar.denumire,
            tip_ob_sar.id_tip_activitate_tipizata,
            tip_ob_sar.id_organizatie,
            tip_ob_sar.id_tip_responsabil,
            tip_ob_sar.logical_delete

        FROM tip_obligatii_sarcini AS tip_ob_sar
        WHERE tip_ob_sar.logical_delete = 0
        ORDER BY tip_ob_sar.id_tip_obligatie_sarcina");

        return View::make('template_contract.template_contract')
                    ->with('template_contract_tipizat_master', $template_contract_tipizat_master)
                    ->with('template_contract_tipizat_detail', $template_contract_tipizat_detail)
                    ->with('categoria_investitie', $categoria_investitie)
                    ->with('tip_contract', $tip_contract)
                    ->with('tip_activitate', $tip_activitate)
                    ->with('tip_activitate_tipizata', $tip_activitate_tipizata)
                    ->with('tip_livrabile', $tip_livrabile)
                    ->with('tip_obligatii_sarcini', $tip_obligatii_sarcini);
	}

    /*** Edit Template Contract ***/

    public function postEditTemplateContract($table) {

		$columns = DB::select("SELECT column_name FROM information_schema.columns WHERE table_name = '".$table."' ");

        DB::table($table)
        ->where($columns[0]->column_name, Input::get('pk'))
        ->update(array(Input::get('name') => Input::get('value')));
    }

    /*** Add Template Contract ***/

    public function postAddTemplateMaster() {     
        
        $parametrii = json_decode(Input::get('parametrii'));
        $denumire = $parametrii[0];
        $observatii = $parametrii[1];
        $id_categoria = $parametrii[2];
        $id_tip_ctr = $parametrii[3];

        if($denumire !== "") {
            
            try {                
                
                DB::table('template_contract_tipizat_master')
                    ->insertGetId(array(
                    'denumire' => $denumire,
                    'observatii' => $observatii,
                    'id_categoria_investitie' => $id_categoria,
                    'id_tip_contract' => $id_tip_ctr));
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

    public function postAddTemplateDetail() {

        $parametrii = json_decode(Input::get('parametrii'));
        $act = $parametrii[0];
        $act_tip = $parametrii[1];
        $liv = $parametrii[2];
        $obl = $parametrii[3];
        $id_template_master = $parametrii[4];

        if($id_template_master > 0) {
            
            try {                
                
                DB::table('template_contract_tipizat_detail')
                    ->insertGetId(array(
                    'id_tip_activitate' => $act,
                    'id_tip_activitate_tipizata' => $act_tip,
                    'id_tip_livrabil' => $liv,
                    'id_tip_obligatie' => $obl,
                    'id_template_contract_tipizat_master' => $id_template_master));
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

    /*** Edit detalii template ***/

    public function postEditTemplateDetail() {

        $parametrii = json_decode(Input::get('parametrii'));
        $act = $parametrii[0];
        $act_tip = $parametrii[1];
        $liv = $parametrii[2];
        $obl = $parametrii[3];
        $id_template_detail = $parametrii[4];

        if($id_template_detail > 0) {
            
            try {                
                
                DB::table('template_contract_tipizat_detail')
                    ->where('id_template_contract_tipizat_detail', $id_template_detail)
                    ->update(array(
                    'id_tip_activitate' => $act,
                    'id_tip_activitate_tipizata' => $act_tip,
                    'id_tip_livrabil' => $liv,
                    'id_tip_obligatie' => $obl));
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

     /*** Delete from Template Contract ***/

    public function postDeleteTemplateMaster() {

        if (Request::ajax()) {
            if (Session::token() !== Input::get('_token')) {
                $id = Input::get('id_name');
                DB::table('template_contract_tipizat_master')->where('id_template', $id)->update(array('logical_delete' => 1));
                return $id;
            }
        }

    }

    public function postDeleteTemplateDetail() {

        if (Request::ajax()) {
            if (Session::token() !== Input::get('_token')) {
                $id = Input::get('id_name');
                DB::table('template_contract_tipizat_detail')->where('id_template_contract_tipizat_detail', $id)->update(array('logical_delete' => 1));
                return $id;
            }
        }

    }

}