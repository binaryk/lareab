<?php

class SerieFacturareController extends BaseController
{   
    public function getSeriiFacturare()
    {
        $ids = self::getIDsDepartamente(Confide::getDepartamenteUser());
        $sql = "SELECT 
          sf.id,
          sf.serie,
          sf.numar,
          sf.id_entitate,
          ent.denumire AS entitate
          FROM serie_factura sf
          INNER JOIN entitate ent ON ent.id = sf.id_entitate AND ent.logical_delete = 0
          WHERE ";
   
        if (!Entrust::can("administrare_platforma"))
        {
            /*$sql .= 
                " INNER JOIN departament d ON d.id_entitate = ent.id AND d.logical_delete = 0" .
                " AND d.id IN (" . $ids . ")";*/
            $sql .= " EXISTS(SELECT id FROM departament WHERE departament.id_entitate = sf.id_entitate AND departament.logical_delete = 0
                    AND departament.id IN (" . $ids . ")) AND ";
        }
        $sql .= " sf.logical_delete = 0 ORDER BY ent.id, sf.serie";
        
//dd($sql);

        $serii = DB::select($sql);
        
        return View::make('serii_facturare.list')
            ->with('serii', $serii);
    }

    public function getAddSerie()
    {       
        $entitati = self::getEntitatiOrganizatie(null);
        return View::make('serii_facturare.add')->with('entitati', $entitati);
    }

    public function postAddSerie()
    {
        $rules  = array(
            'entitate' => 'required',
            'serie' => 'required',
            'numar' => 'required'
        );
        $errors = array(
            'required' => 'Campul este obligatoriu.'
        );
        
        $validator = Validator::make(Input::all(), $rules, $errors);
        if ($validator->fails())
        {
            return Redirect::back()->with('message', 'Eroare validare formular!')->withErrors($validator)->withInput();
        }
        else
        {
            try
            {
                DB::table('serie_factura')->insertGetId(array(
                    'id_entitate' => intval(Input::get('entitate')),
                    'serie' => Input::get('serie'),
                    'numar' => Input::get('numar')
                    ));
            }
            catch (Exception $e)
            {       
                return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
            }            
            return Redirect::route('serii_facturare');
        }
    }

    public function getEditSerie($id)
    {        
        $serie = DB::select("SELECT 
          sf.id,
          sf.serie,
          sf.numar,
          sf.id_entitate
          FROM serie_factura sf
          WHERE sf.logical_delete = 0      
            AND sf.id = :id",
            array('id' => $id));
        $entitati = self::getEntitatiOrganizatie(null);
        return View::make('serii_facturare.edit')
            ->with('serie', $serie[0])
            ->with('entitati', $entitati);
    }

    public function postEditSerie($id)
    {
        $rules  = array(
            'entitate' => 'required',
            'serie' => 'required',
            'numar' => 'required'
        );
        $errors = array(
            'required' => 'Campul este obligatoriu.'
        );
        
        $validator = Validator::make(Input::all(), $rules, $errors);
        if ($validator->fails())
        {
            return Redirect::back()->with('message', 'Eroare validare formular!')->withErrors($validator)->withInput();
        }
        try
        {           
            //Debugbar::info('CP='.Input::get('cod_postal'));
            DB::table('serie_factura')
                ->where('id', $id)
                ->update(array(                    
                    'id_entitate' => intval(Input::get('entitate')),
                    'serie' => Input::get('serie'),
                    'numar' => Input::get('numar')          
                ));
        }
        catch (Exception $e)
        {       
            return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
        }            
        return Redirect::back()->with('message', 'Salvare realizata cu succes!')->withInput();        
    }

    public function postDeleteSerie()
    {        
        if(Request::ajax()) {
            if( Session::token() === Input::get( '_token' ) ) {
                $id = Input::get('id');
                DB::table('serie_factura')->where('id', $id)->update(array(
                    'logical_delete' => 1));
                return $id;
            }
        }
    }
}