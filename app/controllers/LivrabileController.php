<?php
class livrabileController extends BaseController
{
    private function getlivrabileFacturateNefacturate($id_factura, $facturate) 
    {
        $sql = "SELECT             
            epl.id_etapa, 
            epl.nr_etapa, 
            epl.termen_predare, 
            epl.id_um_timp, 
            epl.instiintare_contractor, 
            epl.data_start,
            le.id_livrabil_etapa, 
            le.id_stadiu, 
            le.id_factura,
            le.ore_lucrate,
            le.pret_fara_tva,
            oc.id_obiectiv, 
            oc.tva,           
            oc.denumire AS obiectiv, 
            tl.denumire AS livrabil,
            sl.denumire AS stadiu,
            um.denumire AS um,
            case
              when epl.id_um_timp=1 then date_format(date_add(epl.data_start, interval termen_predare day), '%d-%m-%Y')
              when epl.id_um_timp=2 then date_format(date_add(epl.data_start, interval termen_predare week), '%d-%m-%Y')
              when epl.id_um_timp=3 then date_format(date_add(epl.data_start, interval termen_predare month), '%d-%m-%Y')
              when epl.id_um_timp=4 then date_format(date_add(epl.data_start, interval termen_predare year), '%d-%m-%Y')
            end AS data_limita,
            datediff(now(), epl.data_start) AS zile_trecute,
            contract.id_contract,
            contract.numar AS numar_contract,
            contract.denumire AS contract,
            contract.id_entitatea_mea,
            contract.id_partener

            FROM livrabile_etapa le
            INNER JOIN etape_predare_livrabile epl ON le.id_etapa = epl.id_etapa AND epl.logical_delete = 0
            INNER JOIN obiectiv oc ON epl.id_obiectiv = oc.id_obiectiv AND oc.logical_delete = 0
            LEFT OUTER JOIN contract ON contract.id_contract = oc.id_contract AND contract.logical_delete = 0
            INNER JOIN tip_livrabile tl ON le.id_livrabil = tl.id_tip_livrabile AND tl.logical_delete = 0
            INNER JOIN stadiu_livrabil sl ON sl.id_stadiu_livrabil = le.id_stadiu AND sl.logical_delete = 0
            INNER JOIN um_timp um ON um.id_um = epl.id_um_timp AND um.logical_delete = 0
            WHERE le.logical_delete = 0 ";
                
        if ($facturate == true)
        {
            if ($id_factura > 0)
                $sql = $sql . " AND (le.id_factura = " . $id_factura;
            else
                $sql = $sql . " AND (le.id_factura > 0) ";
        }
        else
        {
            $sql = $sql . "AND (le.id_factura is NULL OR le.id_factura <= 0)";
        }            
        return $sql;
    }

    //id_tip_nivel_contractare = 1 - livrabile unui contract in care firma din grup este prestator
    //id_tip_nivel_contractare = 0 - livrabile unui contract in care firma din grup este beneficiar
    private function getlivrabileNefacturate($id_tip_nivel_contractare) 
    {
        $sql = self::getlivrabileFacturateNefacturate(0, false);        
        if (($id_tip_nivel_contractare == Nivelcontractare::Beneficiar) ||
            ($id_tip_nivel_contractare == Nivelcontractare::Prestator))
        {
            $sql = $sql . " AND contract.id_tip_nivel_contractare = " . $id_tip_nivel_contractare;
        }
        $sql = $sql . " AND oc.id_organizatie = :id_organizatie";
        //die($id_tip_nivel_contractare . ">>>" . $sql);           
        $livrabile = DB::select($sql, array('id_organizatie' => $this->date_organizatie[0]->id_organizatie));
        return $livrabile;
    }
 
    public function getlivrabileFactura($id_factura) 
    {
        $sql = self::getlivrabileFacturateNefacturate($id_factura, false);        
        $sql = $sql . " AND oc.id_organizatie = :id_organizatie";
        //die($id_tip_nivel_contractare . ">>>" . $sql); 
        $factura = self::getFactura($id_factura);          
        $livrabile = DB::select($sql, array('id_organizatie' => $this->date_organizatie[0]->id_organizatie));
        return View::make('livrabile_factura.list')
            ->with('livrabile', $livrabile)
            ->with('factura', $factura);
    }
    
    public function getlivrabile() {
        $livrabile = self::getlivrabileNefacturate(null);
        return View::make('livrabile.list')->with('livrabile', $livrabile);
    }
    
    public function getlivrabileNefacturateClient() {
        $livrabile = self::getlivrabileNefacturate(Nivelcontractare::Prestator);
        $serii_facturare = self::getSeriiFacturare();
        //Debugbar::info($serii_facturare);
        return View::make('livrabile_nefacturate_client.list')
            ->with('livrabile', $livrabile)
            ->with('serii_facturare', $serii_facturare);
    }

    public function getlivrabileNefacturateFurnizor() {
        $livrabile = self::getlivrabileNefacturate(Nivelcontractare::Beneficiar);
        return View::make('livrabile_nefacturate_furnizor.list')
            ->with('livrabile', $livrabile);
    }
    
    public function postGenereazaDesfasuratorClient() {
        $date_facturare = json_decode(Input::get('date_facturare'));
        $selected = $date_facturare[0];
        $id_prestator = $date_facturare[1];
        $id_client = $date_facturare[2];
        $id_serie_facturare = $date_facturare[3];
        $serie_fac = $date_facturare[4];
        $numar_fac = $date_facturare[5];
        $tva = $date_facturare[6];

        //die('t1=   '.Session::token() . '   t2=   '.Input::get('_token'));
        //die(Session::token() === Input::get('_token'));

        if (Request::ajax()) {
            if (Session::token() === Input::get('_token')) {
                DB::beginTransaction();
                //Debugbar::info($date_facturare);
                //Debugbar::info("NR FAC=" . $numar_fac);
                $numar_fac++;
                
                //generez factura
                $id_factura = DB::table("factura_client")->insertGetId(array('serie' => $serie_fac, 'numar' => $numar_fac, 'id_prestator' => $id_prestator, 'id_organizatie' => $this->date_organizatie[0]->id_organizatie, 'tva' => $tva, 'id_client' => $id_client));
                if ($id_factura !== -1) {
                    //Debugbar::info("ID FAC=" . $id_factura);
                    $affected_rows = DB::table("livrabile_etapa")->whereIn('id_livrabil_etapa', $selected)->update(array('id_factura' => $id_factura));
                    //Debugbar::info("AF ROWS 1=" . $affected_rows);
                    if ($affected_rows === count($selected)) {
                        //Debugbar::error("Egale " . $id_serie_facturare . "-" .$numar_fac);
                        $affected_rows = DB::table("serie_factura")
                            ->where('id_serie_factura', $id_serie_facturare)
                            ->update(array('numar' => $numar_fac));
                        //Debugbar::info("AF ROWS 2=" . $affected_rows);
                        if ($affected_rows === 1) {
                            //Debugbar::info("Commit");
                            DB::commit();
                            ob_clean();
                            return Response::json(array('status' => 'OK', 'message' => 'Factura generata cu succes'));                          
                        }
                    }
                }
                DB::rollback();
                ob_clean();
                return Response::json(array('status' => 'KO', 'message' => 'Eroare generare factura'));
            }
            ob_clean();
            return Response::json(array('status' => 'KO', 'message' => 'Eroare token'));
        }
    }

    public function postGenereazaDesfasuratorFurnizor() {
        $date_facturare = json_decode(Input::get('date_facturare'));
        $selected = $date_facturare[0];
        $id_beneficiar = $date_facturare[1];
        $id_furnizor = $date_facturare[2];
        $serie_fac = strtoupper($date_facturare[3]);
        $numar_fac = $date_facturare[4];
        $tva = $date_facturare[5];

            //  die($serie_fac . '/' . $numar_fac);
        if ($serie_fac == "" || $numar_fac == "")
        {
            ob_clean();
            return Response::json(array('status' => 'KO', 'message' => 'Seria si numarul facturii sunt campuri obligatorii.')); 
        }
        if (Request::ajax()) {
            if (Session::token() !== Input::get('_token')) {
                DB::beginTransaction();
                
                //generez factura
                $id_factura = DB::table("factura_furnizor")
                    ->insertGetId(array('Serie' => $serie_fac, 'numar' => $numar_fac, 'id_beneficiar' => $id_beneficiar, 'id_organizatie' => $this->date_organizatie[0]->id_organizatie, 'tva' => $tva, 'id_furnizor' => $id_furnizor));
                if ($id_factura !== -1) {
                    //Debugbar::info("ID FAC=" . $id_factura);
                    $affected_rows = DB::table("livrabile_etapa")->whereIn('id_livrabil_etapa', $selected)->update(array('id_factura' => $id_factura));
                    //Debugbar::info("AF ROWS 1=" . $affected_rows);
                    if ($affected_rows === count($selected)) {                       
                        DB::commit();
                        ob_clean();
                        return Response::json(array('status' => 'OK', 'message' => 'Factura generata cu succes'));                          
                    }
                }                
                DB::rollback();
                ob_clean();
                return Response::json(array('status' => 'KO', 'message' => 'Eroare generare factura'));
            }
            ob_clean();
            return Response::json(array('status' => 'KO', 'message' => 'Eroare token'));
        }
    }
}
