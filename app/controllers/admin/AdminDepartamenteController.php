<?php
class AdminDepartamenteController extends \BaseController 
{
	

	/* Mevoro edit */
    public function getUser($id)
    {
        $sql = "SELECT 
		id,
		full_name,
		id_org
		FROM 
		users
		WHERE
		id = ".$id."";
		$utilizator = DB::select($sql);
        return end($utilizator);
    }
	
    public function getOrganizations()
    {
		//creare filtru bazat pe calitatea utilizatorului
		$sql_filter = ''; //filtru sql gol
		if(!Entrust::can('administrare_platforma')) {
			$sql_filter = ' AND id = '. Entrust::user()->id_org . ' '; //adaugam filtru
		}
		//sfarsit creare filtru
		
		$sql = "SELECT 
		id,
		name
		FROM 
		organizations
		WHERE
		logical_delete = 0
		AND id > 0
		".$sql_filter."
		ORDER BY
		name";
		
		$organizations = DB::select($sql);
        return $organizations;
    }

    public function EntitatiSiDepartamente($id_organizatie = '')
    {
		
        if ($id_organizatie != '') 
        {
            $id_organizatie = 'AND id_organizatie = '.$id_organizatie.' ';
        }
        
        $sql = "SELECT 
		e.id_organizatie as id_organizatie, 
		e.id as id_entitate, 
		e.denumire as denumire_entitate, 
		d.id as id_departament, 
		d.denumire as denumire_departament 
		FROM 
		entitate e LEFT JOIN departament d 
		ON e.id = d.id_entitate 
		WHERE IFNULL(e.logical_delete, 0) = 0 AND IFNULL(d.logical_delete, 0) = 0 ".$id_organizatie."
		ORDER BY denumire_entitate, denumire_departament
		";
		
        $entitates = DB::select($sql); 
		return $entitates;
    }

	
	
    public function AdaugaDepartamente($id)
    {
		$input_form = array();
		$id = intval($id);
		$input_form['edit'] = $id;
		
		//informatiile pentru popularea form-ului
		$organizatii_list = self::getOrganizations();
		$entitatiSiDepartamente = self::EntitatiSiDepartamente();
		//sfarsit informatii pentru popularea form-ului
		
		//pregatim organizatii
		$organizatii = array();
		foreach($organizatii_list as $o) {
			$organizatii[$o -> id] = $o -> name;
		}
		
		//separam entitati de departamente
		$entitati = array();
		$entitati_simplu = array();
		$departamente = array();
		
		
		foreach($entitatiSiDepartamente as $cd) {
			
			if(!isset($entitati_simplu[$cd -> id_entitate])) {				
				$entitati_simplu[$cd -> id_entitate] = $cd -> denumire_entitate;
			}
			
			if(!isset($entitati[$cd -> id_organizatie])) {
				$entitati[$cd -> id_organizatie] = array();
				$entitati_simplu[$cd -> id_entitate] = $cd -> denumire_entitate;
			}
			
			if(!isset($entitati[$cd -> id_organizatie][$cd -> id_entitate])) {
				$entitati[$cd -> id_organizatie][$cd -> id_entitate] = $cd -> denumire_entitate;
			}
			
			if($cd -> id_departament)
			$departamente[$cd -> id_entitate][$cd -> id_departament] = $cd -> denumire_departament;
		}
		
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
			d.id AS did, 
			d.denumire AS ddenumire, 
			e.id AS eid,
			e.denumire AS edenumire, 
			o.id AS oid,
			o.name AS odenumire
			
			FROM users_departament ud
			INNER JOIN departament d ON ud.id_departament = d.id AND d.logical_delete = 0
			INNER JOIN entitate e ON d.id_entitate = e.id AND e.logical_delete = 0
			INNER JOIN organizations o ON e.id_organizatie = o.id AND o.logical_delete = 0
			
			WHERE ud.id_user = :id";

			$aux = DB::select($sql, array('id' => $id));

			$input_form['organizatie'] = $utilizator -> id_org;
			$input_form['edit'] = $id;
			$input_form['entitati'] = array();
			$input_form['departamente'] = array();
			
			//salvare detalii pentru inputuri
			foreach($aux as $k => $v) {
				if($v -> did)
				$input_form['departamente'][$v -> eid][] = $v -> did;
				
				if($v -> eid)
				$input_form['entitati'][] = $v -> eid;
				
				if($v -> oid && $input_form['organizatie'] == '')
				$input_form['organizatie'] = $v -> oid;
			}
			
		}
		//sfarsit editare
        return View::make('admin.users.add_department')
                ->with('utilizator', $utilizator)
                ->with('organizatii', $organizatii)
                ->with('entitati', $entitati)
				->with('entitati_simplu', $entitati_simplu)
                ->with('departamente', $departamente)
                ->with('input_form', $input_form);
    } //sfarsit userRole

	
	/* 
		Salvare modificari
	*/	
    public function SalveazaAdaugaDepartamente() { 
	
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
			//filtru de securitate pt non admini
			$organizatii_list = self::getOrganizations();
			$organizatie_ok = 0; 
			foreach($organizatii_list as $v) {
				if($v -> id == Input::get('organizatie')) {
					$organizatie_ok = 1;
					break;	
				}
			}
			
			if($organizatie_ok == 0)
            return Redirect::back()->withErrors('Organizatia nu a fost selectata corect!');
			//sfarsit filtru de securitate non admini
		
			//informatiile pentru popularea form-ului
			$entitatiSiDepartamente = self::EntitatiSiDepartamente();
			
			$entitati = array();
			$departamente = array();
			foreach($entitatiSiDepartamente as $k => $v) {
				$entitati[$v -> id_entitate] = $v -> id_organizatie;
				$departamente[$v -> id_departament] = $v -> id_entitate;
			}
			//sfarsit informatii pentru popularea form-ului
			
			//cautam utilizatorul
			$utilizator = self::getUser(Input::get('edit'));			
			if(!$utilizator) { //template-ul nu poate fi gasit
            	return Redirect::back()->withErrors('Nu gasesc acest utilizator!');
			}
			
			if($organizatie_ok == 0) {
            	return Redirect::back()->withErrors('Organizatia nu a fost selectata corect!');
			}
			
			if(Input::has('entitati')) {
				foreach(Input::get('entitati') as $v) {
					if(!isset($entitati[$v]))
					return Redirect::back()->withErrors('Eroare validare formular!')->withErrors($validator)->withInput();
					
					$idepartamente = Input::get('departamente');
					if(!isset($idepartamente[$v]))
						$sql_insert[] = array('id_user' => Input::get('edit'), 'id_departament' => NULL);
					else
					foreach($idepartamente[$v] as $dk => $dv) {
						if(intval($dv) > 0)
						$sql_insert[] = array('id_user' => Input::get('edit'), 'id_departament' => $dv);
					} //end foreach departamente
				}//end foreach entitati
			}//end test entitati
			
			//sfarsit testare date de intrare
			
					
			//se poate salva
			try {
				if(Entrust::can('administrare_platforma')) {
					//facem update la organizatie
					DB::table('users')->where('id', Input::get('edit'))->update(['id_org' => Input::get('organizatie')]);
					//sfarsit update organizatie
				}
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

}