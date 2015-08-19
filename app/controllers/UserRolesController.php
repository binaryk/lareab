<?php

class UserRolesController extends BaseController 
{
	

	/* Mevoro edit */
    public function getUser($id)
    {
        $sql = "SELECT 
		id,
		full_name
		FROM 
		users
		WHERE
		id = ".$id."";
		$utilizator = DB::select($sql);
        return end($utilizator);
    }
	
    public function getOrganizations()
    {
        $sql = "SELECT 
		id,
		name
		FROM 
		organizations
		WHERE
		logical_delete = 0
		ORDER BY
		name";
		
		$organizations = DB::select($sql);
        return $organizations;
    }

    public function getCompaniesAndDepartments($id_organization = '')
    {
		
        if ($id_organization != '') 
        {
            $id_organization = 'AND `id_organizatie` = '.$id_organization.' ';
        }
        
        $sql = "SELECT 
		`e`.`id_organizatie` as `id_organizatie`, 
		`e`.`id` as `id_companie`, 
		`e`.`denumire` as `denumire_companie`, 
		`d`.`id` as `id_departament`, 
		`d`.`denumire` as `denumire_departament` 
		FROM 
		`entitate` e LEFT JOIN departament d 
		ON `e`.`id` = `d`.`id_entitate` 
		WHERE IFNULL(`e`.`logical_delete`, 0) = 0 AND IFNULL(`d`.`logical_delete`, 0) = 0 ".$id_organization."
		ORDER BY `denumire_companie`, `denumire_departament`
		";
		
        $companies = DB::select($sql); 
		return $companies;
    }

	
	
    public function getAddRoles($id)
    {
		$input_form = array();
		$id = intval($id);
		$input_form['edit'] = $id;
		
		//informatiile pentru popularea form-ului
		$organizatii_list = self::getOrganizations();
		$companiiSiDepartamente = self::getCompaniesAndDepartments();
		//sfarsit informatii pentru popularea form-ului
		
		//pregatim organizatii
		$organizatii = array();
		foreach($organizatii_list as $o) {
			$organizatii[$o -> id] = $o -> name;
		}
		
		//separam companii de departamente
		$companii = array();
		$companii_simplu = array();
		$departamente = array();
		
		foreach($companiiSiDepartamente as $cd) {
			
			if(!isset($companii_simplu[$cd -> id_companie])) {
				$companii_simplu[$cd -> id_companie] = $cd -> denumire_companie;
			}
			
			if(!isset($companii[$cd -> id_organizatie])) {
				$companii[$cd -> id_organizatie] = array();
				$companii_simplu[$cd -> id_companie] = $cd -> denumire_companie;
			}
			
			if(!isset($companii[$cd -> id_organizatie][$cd -> id_departament])) {
				$companii[$cd -> id_organizatie][$cd -> id_companie] = $cd -> denumire_companie;
			}
			
			if($cd -> id_departament)
			$departamente[$cd -> id_companie][$cd -> id_departament] = $cd -> denumire_departament;
		}
		
		/*
			echo '<pre>'; print_r($organizatii); print('</pre>');
			echo '<pre>'; print_r($companii_simplu); print('</pre>');
			echo '<pre>'; print_r($companii); print('</pre>');
			echo '<pre>'; print_r($departamente); print('</pre>');		
			echo '<pre>'; print_r($companiiSiDepartamente); die('</pre>');
		*/
		
		//sfarsit separare
		
		//template-ul este editat 
		if($id == 0) {
            	return Redirect::back()->withErrors('Nu gasesc acest utilizator!');
		}
		else {
			//cautam template-ul
			$utilizator = self::getUser($id);			
			if(!$utilizator) { //template-ul nu poate fi gasit
            	return Redirect::back()->withErrors('Nu gasesc acest utilizator!');
			}
			
			//pregatire input-uri
			$sql = "SELECT
			permis_org,
			permis_firma,
			id_departament
            FROM
            users_departament
            WHERE id_user = :id
			";				
			$aux = DB::select($sql, array('id' => $id));
			
			$input_form['organizatie'] = '';
			$input_form['edit'] = $id;
			$input_form['companii'] = array();
			$input_form['departamente'] = array();
			
			//salvare detalii pentru inputuri
			foreach($aux as $k => $v) {
				if($v -> id_departament)
				$input_form['departamente'][$v -> permis_firma][] = $v -> id_departament;
				
				if($v -> permis_firma)
				$input_form['companii'][] = $v -> permis_firma;
			}
			$aux = end($aux);
			$input_form['organizatie'] = @$aux -> permis_org;
			
		}
		//sfarsit editare
		//echo '<pre>';print_r($input_form);echo '</pre>';die();
        return View::make('admin.users.add_department')
                ->with('utilizator', $utilizator)
                ->with('organizatii', $organizatii)
                ->with('companii', $companii)
				->with('companii_simplu', $companii_simplu)
                ->with('departamente', $departamente)
                ->with('input_form', $input_form);
    } //sfarsit userRole

	
	/* 
		Salvare modificari
	*/	
    public function postAddRoles() { 
	
		echo '<pre>';print_r(Input::all());print('</pre>');
        $rules = array(
            'edit' => 'required|integer',	
            'organizatie' => 'integer',		
			);
        $errors = array(
		'required' => 'Nu ati selectat utilizatorul.',
		'integer' => 'Organizatia nu a fost selectata.');
        
        $validator = Validator::make(Input::all(), $rules, $errors);
        if ($validator->fails()) {
            return Redirect::back()->withErrors('Eroare validare formular!')->withErrors($validator)->withInput();
        } 
        else {					
		
			//informatiile pentru popularea form-ului
			$companiiSiDepartamente = self::getCompaniesAndDepartments();
			
			$companii = array();
			$departamente = array();
			foreach($companiiSiDepartamente as $k => $v) {
				$companii[$v -> id_companie] = $v -> id_organizatie;
				$departamente[$v -> id_departament] = $v -> id_companie;
			}
			//sfarsit informatii pentru popularea form-ului
			
			//cautam utilizatorul
			$utilizator = self::getUser(Input::get('edit'));			
			if(!$utilizator) { //template-ul nu poate fi gasit
            	return Redirect::back()->withErrors('Nu gasesc acest utilizator!');
			}
			
			if(!in_array(Input::get('organizatie'), $companii) && Input::get('organizatie') != '')
            return Redirect::back()->withErrors('Organizatia nu a fost selectata corect!');
			if(Input::has('companii')) {
				foreach(Input::get('companii') as $v) {
					if(!isset($companii[$v]))
					return Redirect::back()->withErrors('Eroare validare formular!')->withErrors($validator)->withInput();
					
					$idepartamente = Input::get('departamente');
					if(!isset($idepartamente[$v]))
						$sql_insert[] = array('id_user' => Input::get('edit'), 'permis_org' => Input::get('organizatie'), 'permis_firma' => $v, 'id_departament' => NULL);
					else
					foreach($idepartamente[$v] as $dk => $dv) {
						$sql_insert[] = array('id_user' => Input::get('edit'), 'permis_org' => Input::get('organizatie'), 'permis_firma' => $v, 'id_departament' => $dv);
					} //end foreach departamente
				}//end foreach companii
			}//end test companii
			
			//sfarsit testare date de intrare
			
			
			//se poate salva
			try {
					
				//curatam informatiile vechi
				DB::table('users_departament')->where('id_user', Input::get('edit'))->delete();
				//sfarsit curatare
				
				//inserare linii in template_contract_tipizat_detail
				DB::table('users_departament') -> insert($sql_insert);
								
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