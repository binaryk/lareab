<?php

class UtilController extends BaseController
{    
    public function getOrganizatii()
    {
        $organizatii = DB::table("organizatie")->select("id_organizatie")->where("logical_delete", 0)->get();
        return $organizatii;
    }

    /*public function getSeriiFacturare($id_organizatie)
    {
        $serii = DB::Select("SELECT
            sf.IdSerieFactura,
            sf.serie,
            sf.numar,
            entitate.IdEntitate,
            entitate.id_organizatie
            FROM serie_factura sf
            INNER JOIN entitate ON entitate.IdEntitate = sf.IdEntitate AND entitate.logical_delete = 0
            WHERE sf.logical_delete = 0
            AND entitate.id_organizatie = :id_organizatie", array('id_organizatie' => $id_organizatie));
        return $serii;
    }

    public function genereazaSeriiFacturare()
    {
        $jsSeriiFacturare = "serii_facturare.js";
        $fh = fopen($jsSeriiFacturare, 'w') or die("Eroare deschidere fisier");
        $organizatii = $this->getOrganizatii();
        foreach ($organizatii as $organizatie) 
        {   
            $serii = $this->getSeriiFacturare($organizatie->id_organizatie);        
            fwrite($fh, $this->genereazaFunctieJS('getSerii_org_' . $organizatie->id_organizatie, $serii));
        }
        fclose($fh);
    }*/

    function genereazaFunctieJS($numeFunctie, $dataTbl)
    {
        $tmp = json_encode($dataTbl);
        $tmp = str_replace("'", "", $tmp);
        $antet = "function " . $numeFunctie . "(){";
        return $antet . "return '" . $tmp . "';}\n";
    }

    public function genereazaTari()
    {
        //Debugbar::info('_tara');
        $tari = DB::table('tara')
            ->select('id_tara', 'denumire')
            ->where('logical_delete', '0')->get();        
        return $tari;
    }

    public function genereazaRegiuni($id_tara)
    {
        //Debugbar::info('_regiune');
        $regiuni = DB::table('regiune')
            ->select('id_regiune', 'denumire')
            ->where('logical_delete', '0')->where('id_tara', $id_tara)->get();        
        return $regiuni;
    }

    public function genereazaJudete($id_regiune)
    {
        //Debugbar::info('_judet');
        $judete = DB::table('judet')
            ->select('id_judet', 'denumire')
            ->where('logical_delete', '0')->where('id_regiune', $id_regiune)->get();        
        return $judete;
    }

    public function genereazaLocalitati($id_judet)
    {
        $localitati = DB::table('v_localitate_descriere')
            ->select('id_localitate', 'denumire', 'cod_postal')
            ->where('id_judet', $id_judet)->get();
        return $localitati;
    }  

    public function genereazaSegmentareGeografica()
    {
        $jsSegmentare = "segmentare.js";
        $fh = fopen($jsSegmentare, 'w') or die("Eroare deschidere fisier");
        $tari = $this->genereazaTari();
        fwrite($fh, $this->genereazaFunctieJS('getTari', $tari));
        foreach ($tari as $tara) {                        
            $regiuni = $this->genereazaRegiuni($tara->id_tara);
            fwrite($fh, $this->genereazaFunctieJS('getRegiuni_tara_' . $tara->id_tara, $regiuni));
            foreach ($regiuni as $regiune) {
                $judete = $this->genereazaJudete($regiune->id_regiune);
                fwrite($fh, $this->genereazaFunctieJS('getJudete_regiune_' . $regiune->id_regiune, $judete));                
                foreach ($judete as $judet) {
                    $localitati = $this->genereazaLocalitati($judet->id_judet);
                    fwrite($fh, $this->genereazaFunctieJS('getLocalitati_judet_' . $judet->id_judet, $localitati));
                    foreach ($localitati as $localitate) 
                    {
                        fwrite($fh, $this->genereazaFunctieJS('getcod_postal_localitate_' . $localitate->id_localitate, $localitate->cod_postal));                        
                    }                    
                }
            }
        }
        fclose($fh);
    }
}