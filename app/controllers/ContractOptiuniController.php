<?php
class ContractOptiuniController extends BaseController {

	public function getStadiiContract($id_contract) {

        $stadiu_contract = DB::select("SELECT 
            is_s_ctr.id_istoric, 
            is_s_ctr.id_contract, 
            is_s_ctr.id_stadiu, 
            s_ctr.Denumire, 
            /*users.full_name AS Nume,*/
            date_format(is_s_ctr.created_at, '%d-%m-%Y') AS data_stadiu

        FROM istoric_stadii_contract AS is_s_ctr
        /*LEFT OUTER JOIN users AS users ON  is_s_ctr.guid_user = users.guid  AND  users.logical_delete = 0*/
        LEFT OUTER JOIN stadiu_contract AS s_ctr ON  is_s_ctr.id_stadiu = s_ctr.id_stadiu_contract  AND  s_ctr.logical_delete = 0

        WHERE is_s_ctr.logical_delete = 0 
        AND is_s_ctr.id_contract = :id_contract", array('id_contract' => $id_contract));

        return View::make('contracte.istoric_stadii')->with('stadiu_contract', $stadiu_contract);
    }

    public function getAddEditGarantieExecutie($id_contract) {

        $contract = self::getContract($id_contract);
        $valoare_incasari = DB::select("SELECT 

            SUM(valoare_virata_CG) AS valoare_incasari
            
            FROM incasare_factura 
            INNER JOIN factura ON factura.id_factura = incasare_factura.id_factura AND factura.logical_delete = 0
            
            WHERE incasare_factura.logical_delete = 0 
            AND factura.id_contract = :id_contract", array('id_contract' => $id_contract));

        $gr_executie = DB::select("SELECT
            g_exec.id_contract,
            g_exec.necesita_garantie AS necesita_garantie,
            g_exec.nr_cont AS nr_cont,
            g_exec.banca AS banca,
            date_format(g_exec.data_deschidere, '%d-%m-%Y') AS data_deschidere,
            g_exec.procent_valoare AS procent_valoare,
            g_exec.procent_initial AS procent_initial

            FROM garantie_executie AS g_exec

            WHERE g_exec.logical_delete = 0
            AND g_exec.id_contract =  :id_contract", array('id_contract' => $id_contract));  

        return View::make('contracte.garantie_executie')
            ->with('gr_executie', count($gr_executie) == 1 ? $gr_executie[0] : null)
            ->with('contract', $contract)
            ->with('valoare_incasari', $valoare_incasari);
    }

    public function postAddEditGarantieExecutie($id_contract) {
        
        /*Uita-te in baza de care e nevoie si de care nu*/
        $rules = array(
            'necesita_garantie' => 'required',
            'nr_cont' => 'required',
            'banca' => 'required',
            'data_deschidere' => 'required',
            'procent_valoare' => 'required',
            'procent_initial' => 'required',
        );

        /*Variabila creata pentru verificarea numarului de inregistrari existente pentru ID-ul curent*/
        $nr_inregistrari = DB::select("SELECT
            COUNT(*) AS total_inregistrari
            FROM garantie_executie AS g_exec
            WHERE g_exec.id_contract = :id_contract", array('id_contract' => $id_contract));

        $errors = array('required' => 'Campul este obligatoriu.');
        $validator = Validator::make(Input::all(), $rules, $errors);

        if ($validator->fails()) {
            
            return Redirect::back()->with('message', 'Eroare validare formular!')->withErrors($validator)->withInput();
        }
        else {
            
            $data_deschidere_eu = DateTime::createFromFormat('d-m-Y', Input::get('data_deschidere'));
            $data_deschidere_us = $data_deschidere_eu->format('Y-m-d');            
            
            $procent_valoare = 0;                            
            if (!empty(Input::get('procent_valoare'))) {
                $procent_valoare = Input::get('procent_valoare');    
                $procent_valoare = str_replace('.', '', $procent_valoare);
                $procent_valoare = str_replace(',', '.', $procent_valoare);
            }

            $procent_initial = 0;                                       
            if (!empty(Input::get('procent_initial'))) {
                $procent_initial = Input::get('procent_initial');    
                $procent_initial = str_replace('.', '', $procent_initial);
                $procent_initial = str_replace(',', '.', $procent_initial);
            }
            
            if ($nr_inregistrari['0']->total_inregistrari == 0) {
                
                try {
                
                    DB::table('garantie_executie')
                    ->insertGetId(array(
                        'necesita_garantie' => Input::get('necesita_garantie'),
                        'nr_cont' => Input::get('nr_cont'),
                        'banca' => Input::get('banca'),
                        'data_deschidere' => $data_deschidere_us,
                        'procent_valoare' => $procent_valoare,
                        'procent_initial' => $procent_initial,
                        'id_contract'     => $id_contract));

                } catch(Exception $e) {
                
                    return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
                }
                return Redirect::back()->with('message', 'Salvare realizata cu succes!')->withInput();
            }
            elseif ($nr_inregistrari['0']->total_inregistrari != 0) {

                try {
                    
                    DB::table('garantie_executie')
                    ->where('id_contract', $id_contract)
                    ->update(array(
                        'necesita_garantie' => Input::get('necesita_garantie'),
                        'nr_cont' => Input::get('nr_cont'),
                        'banca' => Input::get('banca'),
                        'data_deschidere' => $data_deschidere_us,
                        'procent_valoare' => $procent_valoare,
                        'procent_initial' => $procent_initial));

                } catch (Exception $e) {

                    return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
                }    
                return Redirect::back()->with('message', 'Modificarile au fost realizate cu succes!')->withInput();
            }
        }      
    }

    public function getAddEditGarantieParticipare($id_contract) {

        $ums_timp = self::getUMTimp();
        $gr_participare = DB::select("SELECT
            g_part.id_contract,
            g_part.necesita_garantie AS necesita_garantie,
            date_format(g_part.data_constituirii, '%d-%m-%Y') AS data_constituirii,
            date_format(g_part.data_eliberarii, '%d-%m-%Y') AS data_eliberarii,
            g_part.perioada_valabilitate AS perioada_valabilitate,
            g_part.id_um,
            g_part.valoare AS valoare

        FROM garantie_participare AS g_part

        WHERE g_part.logical_delete = 0
        AND g_part.id_contract = $id_contract");

        return View::make('contracte.garantie_participare')
            ->with('gr_participare', count($gr_participare) == 1 ? $gr_participare[0] : null)
            ->with('ums_timp', $ums_timp);
    }

    public function postAddEditGarantieParticipare($id_contract) {

        /*Uita-te in baza de care e nevoie si de care nu*/
        $rules = array(
            'necesita_garantie' => 'required',
            'data_constituirii' => 'required',
            'data_eliberarii' => 'required',
            'perioada_valabilitate' => 'required',
            'valoare' => 'required',
            'um_timp' => 'required',
        );

        /*Variabila creata pentru verificarea numarului de inregistrari existente pentru ID-ul curent*/
        $nr_inregistrari = DB::select("SELECT
            COUNT(*) AS total_inregistrari
        FROM garantie_participare AS g_part
        WHERE g_part.id_contract = :id_contract", array('id_contract' => $id_contract));

        $errors = array('required' => 'Campul este obligatoriu.');

        $validator = Validator::make(Input::all(), $rules, $errors);

        if ($validator->fails()) {
            return Redirect::back()->with('message', 'Eroare validare formular!')->withErrors($validator)->withInput();
        }
        else {
            
            $data_constituirii_eu = DateTime::createFromFormat('d-m-Y', Input::get('data_constituirii'));
            $data_constituirii_us = $data_constituirii_eu->format('Y-m-d');

            $data_eliberarii_eu = DateTime::createFromFormat('d-m-Y', Input::get('data_eliberarii'));
            $data_eliberarii_us = $data_eliberarii_eu->format('Y-m-d');            
            
            $valoare = 0;
            if (!empty(Input::get('valoare')))
            {
                $valoare = Input::get('valoare');
                $valoare = str_replace('.', '', $valoare);
                $valoare = str_replace(',', '.', $valoare);
            }

            if ($nr_inregistrari['0']->total_inregistrari == 0) {

                try {
                    
                    DB::table('garantie_participare')
                    ->insertGetId(array(
                        'necesita_garantie' => Input::get('necesita_garantie'),
                        'data_constituirii' => $data_constituirii_us,
                        'data_eliberarii' => $data_eliberarii_us,
                        'perioada_valabilitate' => Input::get('perioada_valabilitate'),
                        'id_um' => Input::get('um_timp'),
                        'valoare' => $valoare,
                        'id_contract' => $id_contract));

                } catch(Exception $e) {
                    
                    return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
                }
                return Redirect::back()->with('message', 'Salvare realizata cu succes!')->withInput();

            } elseif ($nr_inregistrari['0']->total_inregistrari != 0) {

                try {

                    DB::table('garantie_participare')
                    ->where('id_contract', $id_contract)
                    ->update(array(
                        'necesita_garantie' => Input::get('necesita_garantie'),
                        'data_constituirii' => $data_constituirii_us,
                        'data_eliberarii' => $data_eliberarii_us,
                        'perioada_valabilitate' => Input::get('perioada_valabilitate'),
                        'id_um' => Input::get('um_timp'),
                        'valoare' => $valoare));

                } catch (Exception $e) {

                    return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
                }
                return Redirect::back()->with('message', 'Modificarile au fost realizate cu succes!')->withInput();
            }
        }
    }
}