<?php

class StadiuLivrabilController extends BaseController {

    public function getStadii($id_livrabil)
    {    
        $stadii = DB::select("SELECT    
            isl.id_livrabil_etapa,
            ifnull(users.full_name, '') AS nume_utilizator,
            sl.denumire AS stadiu,
            sl.id,
            date_format(isl.created_at, '%d-%m-%Y %H:%i') AS data_stadiu        
            FROM istoric_stadii_livrabil AS isl
            LEFT OUTER JOIN stadiu_livrabil AS sl ON sl.id = isl.id_stadiu AND sl.logical_delete = 0
            LEFT OUTER JOIN users ON users.id = isl.id_user
            WHERE isl.logical_delete = 0 AND isl.id_livrabil_etapa = :id_livrabil
            ORDER BY isl.created_at DESC", array('id_livrabil' => $id_livrabil));        

        $stadii_livrabil = DB::select("SELECT    
            sl.id,
            sl.denumire
            FROM stadiu_livrabil AS sl
            WHERE sl.logical_delete = 0
            ORDER BY sl.id");

        $ore_lucrate = DB::select("SELECT
            ore_lucrate
            FROM livrabile_etapa
            WHERE livrabile_etapa.logical_delete = 0
            AND livrabile_etapa.id = :id_livrabil",
            array('id_livrabil' => $id_livrabil));
        /*$ore_lucrate = DB::table('livrabile_etapa')
            ->where('id', $id_livrabil)
            ->where('logical_delete', 0)
            ->lists('ore_lucrate');*/
            //dd($id_livrabil);
        try
        {
            $ore_lucrate = $ore_lucrate[0]->ore_lucrate;
        }
        catch(Exception $err) { 
            $ore_lucrate = 0; 
        }

        return View::make('stadii_livrabil.list')
            ->with('stadii', $stadii)
            ->with('stadii_livrabil', $stadii_livrabil)
            ->with('id_livrabil_etapa', $id_livrabil)
            ->with('ore_lucrate', $ore_lucrate);
    }

    public function _postSchimbaStadiu()
    {
        $rules = array(
            'stadiu_selectionat' => 'required'
        );
        $errors = array(
            'required' => 'Campul este obligatoriu'            
        );

        $validator = Validator::make(Input::all(), $rules, $errors);
        if ($validator->fails()) {
            return Redirect::back()
                ->with('message', 'Eroare validare formular!')
                ->withErrors($validator)
                ->withInput();
        } else {
            DB::table('istoric_stadii_livrabil')->insertGetId(
                array(
                    'id_livrabil_etapa' => Input::get('id_livrabil_etapa'), 
                    'id_stadiu' => Input::get('stadiu_selectionat'), 
                    'guid_user' => 'fuck_you')
            );

            return Redirect::back()->with('message', 'Stadiul a fost schimbat cu succes!');
        }
    }

    public function postSchimbaStadiu($id_livrabil)
    {       
        $actualizare_ore = Input::get('ore_lucrate') > 0;                     
        $is_stadiu = (Input::get('stadiu_selectionat') != null) && (Input::get('stadiu_selectionat') > 0);

        $array_update = array();
        if ($is_stadiu)
        {
            //Face insert in tabela de istoric de stadii
            //Actualizeaza stadiul livrabilului
            $array_update = array_add($array_update, 'id_stadiu', Input::get('stadiu_selectionat'));
        }
        if ($actualizare_ore)
        {
            //Actualizeaza numarul de ore lucrate la acest livrabil
            $array_update = array_add($array_update, 'ore_lucrate', Input::get('ore_lucrate'));
        }

        // Start transaction!
        DB::beginTransaction();
        if ($is_stadiu)
        {
            try 
            {                
                DB::table('istoric_stadii_livrabil')
                    ->insertGetId(
                        array(
                        'id_livrabil_etapa' => Input::get('id_livrabil_etapa'), 
                        'id_stadiu' => Input::get('stadiu_selectionat'), 
                        'id_user' => Entrust::user()->id));            
            } catch(Exception $e)
            {
                DB::rollback();                    
                return Redirect::back()->with('message', 'Eroare salvare date: ' . $e);
            }
        }

        if ($is_stadiu || $actualizare_ore)
        {
            try 
            {
                DB::table('livrabile_etapa')
                    ->where('id', Input::get('id_livrabil_etapa'))
                    ->update($array_update);                     
            } catch(Exception $e)
            {
                DB::rollback();
                return Redirect::back()->with('message', 'Eroare salvare date: ' . $e);
            }
        }                 

        DB::commit();
        return Redirect::back()->with('message', 'Actualizare realizata cu succes!')->withInput();
    }
}

    