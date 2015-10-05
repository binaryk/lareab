<?php

class TemplateContractController extends BaseController 
{
	public function getTemplateContract() 
    {
		$templates = DB::select("SELECT 
            tctm.id, 
            tctm.denumire,
            tctm.observatii, 
            
            tctm.id_tip_contract, 
            tctm.id_categoria_investitie,

            cat_inv.denumire AS categorie,
            tip_ctr.denumire AS tip_contract

        FROM template_contract_tipizat_master AS tctm
        LEFT OUTER JOIN categoria_investitie AS cat_inv ON cat_inv.id_categoria_investitie = tctm.id_categoria_investitie AND cat_inv.logical_delete = 0
        LEFT OUTER JOIN tip_contract AS tip_ctr ON tip_ctr.id = tctm.id_tip_contract AND tip_ctr.logical_delete = 0
        WHERE tctm.logical_delete = 0
        AND tctm.id_organizatie = :id_organizatie
        ORDER BY tctm.id", array('id_organizatie' => isset(self::organizatie()[0])?self::organizatie()[0]->id_organizatie:-1));
   
        return View::make('template_contract.list')
                ->with('templates', $templates);                  
	}

    public function getTipActivitati($id_tip_contract = null)
    {
        $sql = "SELECT
            id,
            denumire AS activitate,
            id_tip_contract
            FROM
            tip_activitate
            WHERE logical_delete = 0
            AND id_organizatie = :id_organizatie";

//dd(self::organizatie()[0]->id_organizatie);
        $activitati = null;
        if ($id_tip_contract != null) 
        {
            $sql = $sql + " AND id_tip_contract = :id_tip_contract";
            $activitati = DB::select($sql, array('id_organizatie' => self::organizatie()[0]->id_organizatie, 'id_tip_contract' => $id_tip_contract));
        }
        else
        {
            $activitati = DB::select($sql, array('id_organizatie' => isset(self::organizatie()[0])?self::organizatie()[0]->id_organizatie:-1));   
        }
        return $activitati;
    }

    public function getTipActivitatiTipizate($id_tip_activitate = null)
    {
        $sql = "SELECT
            id,
            denumire AS activitate,
            id_tip_activitate
            FROM
            tip_activitate_tipizata
            WHERE logical_delete = 0
            AND id_organizatie = :id_organizatie";
        $activitati_tipizate = null;
        if ($id_tip_activitate != null) 
        {
            $sql = $sql + " AND id_tip_activitate = :id_tip_activitate";
            $activitati_tipizate = DB::select($sql, array('id_organizatie' => self::organizatie()[0]->id_organizatie, 'id_tip_activitate' => $id_tip_activitate));
        }
        else
        {
            $activitati_tipizate = DB::select($sql, array('id_organizatie' => isset(self::organizatie()[0])?self::organizatie()[0]->id_organizatie:-1));   
        }
        return $activitati_tipizate;
    }

	/* Mevoro edit */
    public function getTipuriContracte()
    {
        $sql = "SELECT 
		id,
		denumire
		FROM 
		tip_contract
		WHERE
		logical_delete = 0
		ORDER BY
		denumire";
		
		$tipuri_contracte = DB::select($sql);
        return $tipuri_contracte;
    }
    public function getCategoriiInvestitii()
    {
        $sql = "SELECT 
		id_categoria_investitie as id,
		denumire
		FROM 
		categoria_investitie
		WHERE
		logical_delete = 0
		ORDER BY
		denumire";
		
		$categorii_investitii = DB::select($sql);
        return $categorii_investitii;
    }

    public function getTipuriLivrabile($id_tip_activitate_tipizata = null)
    {
        
        $sql = "SELECT
			id,
			denumire,
			id_tip_activitate_tipizata
            FROM
            tip_livrabile
            WHERE logical_delete = 0
            AND id_organizatie = :id_organizatie";
        $id_tip_activitate_tipizata = null;
        if ($id_tip_activitate_tipizata != null) 
        {
            $sql = $sql + " AND id_tip_activitate_tipizata = :id_tip_activitate_tipizata";
            $tipuri_livrabile = DB::select($sql, array('id_organizatie' => self::organizatie()[0]->id_organizatie, 'id_tip_activitate_tipizata' => $id_tip_activitate_tipizata));
        }
        else
        {
            $tipuri_livrabile = DB::select($sql, array('id_organizatie' => isset(self::organizatie()[0])?self::organizatie()[0]->id_organizatie:-1));   
        }
        return $tipuri_livrabile;
    }

    public function getTipuriObligatiiSarcini($id_tip_activitate_tipizata = null)
    {
        
        $sql = "SELECT
			id_tip_obligatie_sarcina as id,
			denumire,
			id_tip_activitate_tipizata,
			id_tip_responsabil
            FROM
            tip_obligatii_sarcini
            WHERE logical_delete = 0
            AND id_organizatie = :id_organizatie";
        $id_tip_activitate_tipizata = null;
        if ($id_tip_activitate_tipizata != null) 
        {
            $sql = $sql + " AND id_tip_activitate_tipizata = :id_tip_activitate_tipizata";
            $tipuri_obligatii_sarcini = DB::select($sql, array('id_organizatie' => self::organizatie()[0]->id_organizatie, 'id_tip_activitate_tipizata' => $id_tip_activitate_tipizata));
        }
        else
        {
            $tipuri_obligatii_sarcini = DB::select($sql, array('id_organizatie' => isset(self::organizatie()[0])?self::organizatie()[0]->id_organizatie:-1));   
        }
        return $tipuri_obligatii_sarcini;
    }
	
	
    public function getAddTemplate($id = 0)
    {
		$input_form = array();
		
		//informatiile pentru popularea form-ului
		$categorii_investitii = self::getCategoriiInvestitii();
		$activitati = self::getTipActivitati(null);
        $activitati_tipizate = self::getTipActivitatiTipizate(null);
        $tipuri_contracte = self::getTipuriContracte();
        $tipuri_livrabile = self::getTipuriLivrabile();
        $tipuri_obligatii_sarcini = self::getTipuriObligatiiSarcini();
		//sfarsit informatii pentru popularea form-ului
		
		//template-ul este editat 
		$id = intval($id);
		$input_form['edit'] = $id;
		if($id != 0) {
			//cautam template-ul
			$sql = "SELECT
			denumire,
			id_tip_contract,
			observatii,
			id_categoria_investitie
            FROM
            template_contract_tipizat_master
            WHERE id = :id
            AND id_organizatie = :id_organizatie";				
			$aux = DB::select($sql, array('id' => $id, 'id_organizatie' => isset(self::organizatie()[0])?self::organizatie()[0]->id_organizatie:-1));
			
			if(count($aux) == 0) { //template-ul nu poate fi gasit
            	return Redirect::back()->with('message', 'Nu gasesc acest template sau nu aveti acces la el!');
			}
			$aux = end($aux);
			//pregatire input-uri
			$input_form['denumire'] = $aux -> denumire;
			$input_form['tip_contract'] = $aux -> id_tip_contract;
			$input_form['observatii'] = $aux -> observatii;
			$input_form['categorie_investitie'] = $aux -> id_categoria_investitie;
			
			//selectare detalii
			$sql = "SELECT
			id_tip_activitate,
			id_tip_activitate_tipizata,
			id_tip_livrabil,
			id_tip_obligatie
            FROM
            template_contract_tipizat_detail
            WHERE id_template_contract_tipizat_master = :id
			";				
			$aux = DB::select($sql, array('id' => $id));
			
			$input_form['activitati'] = array();
			$input_form['activitati_tipizate'] = array();
			$input_form['livrabile'] = array();
			$input_form['obligatii_sarcini'] = array();
			
			//salvare detalii pentru inputuri
			foreach($aux as $k => $v) {
				if($v -> id_tip_activitate)
				$input_form['activitati'][] = $v -> id_tip_activitate;
				
				elseif($v -> id_tip_activitate_tipizata)
				$input_form['activitati_tipizate'][] = $v -> id_tip_activitate_tipizata;
				
				elseif($v -> id_tip_livrabil)
				$input_form['livrabile'][] = $v -> id_tip_livrabil;
				
				elseif($v -> id_tip_obligatie)
				$input_form['obligatii_sarcini'][] = $v -> id_tip_obligatie;
			}
			
		}
		//sfarsit editare
		//echo '<pre>';print_r($input_form);echo '</pre>';die();		
        return View::make('template_contract.add')
                ->with('categorii_investitii', $categorii_investitii)
                ->with('activitati', $activitati)
                ->with('activitati_tipizate', $activitati_tipizate)
                ->with('tipuri_contracte', $tipuri_contracte) 
                ->with('tipuri_livrabile', $tipuri_livrabile)
                ->with('tipuri_obligatii_sarcini', $tipuri_obligatii_sarcini)
                ->with('input_form', $input_form);
    }

    public function postAddTemplateMaster() { 
        $rules = array(
            'denumire' => 'required',
            'tip_contract' => 'required|integer',
            'categorie_investitie' => 'required|integer'
			
			);
        $errors = array(
		'required' => 'Campul este obligatoriu.',
		'integer' => 'Categoria investitiei si/sau tipul contractului nu au fost selectate.');
        
        $validator = Validator::make(Input::all(), $rules, $errors);
        if ($validator->fails()) {
            return Redirect::back()->withErrors('Eroare validare formular!')->withErrors($validator)->withInput();
        } 
        else {		
			
			$tipuri_contracte = json_decode(json_encode(self::help_postAddTemplateMaster (self::getTipuriContracte(), 'id')), true);
			if(!isset($tipuri_contracte[Input::get('tip_contract')]))
			return Redirect::back()->withErrors('Eroare validare formular!')->withErrors($validator)->withInput();
			
			$categorii_investitii = json_decode(json_encode(self::getCategoriiInvestitii()), true);
			if(!isset($categorii_investitii[Input::get('categorie_investitie')]))
			return Redirect::back()->withErrors('Eroare validare formular!')->withErrors($validator)->withInput();
			
			$sql_insert = array();	 //folosit pt insert in template_contract_tipizat_master
					
			if(Input::has('activitati')) {
				$activitati = self::help_postAddTemplateMaster (self::getTipActivitati(null), 'id');
				foreach(Input::get('activitati') as $v) {
					if(!isset($activitati[$v]))
					return Redirect::back()->withErrors('Eroare validare formular!')->withErrors($validator)->withInput();
					$sql_insert[] = array('id_tip_activitate' => $v, 'id_tip_activitate_tipizata' => NULL, 'id_tip_livrabil' => NULL, 'id_tip_obligatie' => NULL, 'id_organizatie' => self::organizatie()[0]->id_organizatie);
				}
			}
			if(Input::has('activitati_tipizate')) {
				$activitati_tipizate = self::help_postAddTemplateMaster (self::getTipActivitatiTipizate(null), 'id');
				foreach(Input::get('activitati_tipizate') as $v) {
					if(!isset($activitati_tipizate[$v]))
					return Redirect::back()->withErrors('Eroare validare formular!')->withErrors($validator)->withInput();
					$sql_insert[] = array('id_tip_activitate' => NULL, 'id_tip_activitate_tipizata' => $v, 'id_tip_livrabil' => NULL, 'id_tip_obligatie' => NULL, 'id_organizatie' => self::organizatie()[0]->id_organizatie);
				}
			}
			
			if(Input::has('livrabile')) {
				$tipuri_livrabile = self::help_postAddTemplateMaster (self::getTipuriLivrabile(), 'id');
				foreach(Input::get('livrabile') as $v) {
					if(!isset($tipuri_livrabile[$v]))
					return Redirect::back()->withErrors('Eroare validare formular!')->withErrors($validator)->withInput();
					$sql_insert[] = array('id_tip_activitate' => NULL, 'id_tip_activitate_tipizata' => NULL, 'id_tip_livrabil' => $v, 'id_tip_obligatie' => NULL, 'id_organizatie' => self::organizatie()[0]->id_organizatie);
				}
			}
			
			
			if(Input::has('obligatii_sarcini')) {
				$tipuri_obligatii_sarcini = self::help_postAddTemplateMaster (self::getTipuriObligatiiSarcini(), 'id');
				foreach(Input::get('obligatii_sarcini') as $v) {
					if(!isset($tipuri_obligatii_sarcini[$v]))
					return Redirect::back()->withErrors('Eroare validare formular!')->withErrors($validator)->withInput();
					$sql_insert[] = array('id_tip_activitate' => NULL, 'id_tip_activitate_tipizata' => NULL, 'id_tip_livrabil' => NULL, 'id_tip_obligatie' => $v, 'id_organizatie' => self::organizatie()[0]->id_organizatie);
				}
			}
			
			//sfarsit testare date de intrare
			
			
			//se poate salva
			try {
				
				//Editeaza template
				if(Input::has('edit')) {
					$master_template_id = intval(Input::get('edit'));
					if($master_template_id == 0) //ne asiguram ca totul este in regula
					return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
					
					DB::table('template_contract_tipizat_master')
					->where('id', $master_template_id)
					->update(array('denumire' => Input::get('denumire'), 'id_categoria_investitie' => Input::get('categorie_investitie'), 'id_tip_contract' => Input::get('tip_contract'), 'observatii' => Input::get('observatii')));
					
					//sterge informatiile din detalii template
					DB::table('template_contract_tipizat_detail')->where('id_template_contract_tipizat_master', $master_template_id)->delete();
					//sfarsit stergere
				}
				
				//template nou
				else {
					$master_template_id = DB::table('template_contract_tipizat_master')
					->insertGetId(array(
						'denumire' => Input::get('denumire'),
						'id_tip_contract' => Input::get('tip_contract'),
						'id_categoria_investitie' => Input::get('categorie_investitie'),
						'id_organizatie' => self::organizatie()[0]->id_organizatie,
						'observatii' => Input::get('observatii')));
				}
				//injecteaza id master template
				foreach($sql_insert as $k => $v) {
					$sql_insert[$k]['id_template_contract_tipizat_master'] = $master_template_id;
				}
				
				//inserare linii in template_contract_tipizat_detail
				DB::table('template_contract_tipizat_detail') -> insert($sql_insert);
								
            }
            catch(Exception $e) {
                return Redirect::back()->withErrors('Eroare salvare date: ' . $e)->withInput();
            }
            return Redirect::back()->with('message', 'Salvare realizata cu succes!')->withInput();
			//sfarsit salvare informatii
		
		}
    }
	
	
	
	public function help_postAddTemplateMaster ($obj, $id) { //pentru a prelua id-urile 
		$r = array();
		
		foreach($obj as $v) {
			$r[$v -> $id] = '';	
		}
		return $r;
	}
	
	/* end Mevoro edit */
	
   

     /*** Delete from Template Contract ***/

    public function postDeleteTemplateMaster() {
        if (Request::ajax()) {
            if (Session::token() === Input::get('_token')) { 
                $id = intval(Input::get('id'));
                DB::table('template_contract_tipizat_master')->where('id', $id)->where('id_organizatie', self::organizatie()[0]->id_organizatie)->update(array('logical_delete' => 1));
                return $id;
            }
        }

    }

}