<?php

class BaseController extends Controller {

    /**
     * Initializer.
     *
     * @access   public
     * @return \BaseController
     */
    protected $date_organizatie = null;
    
    public function __construct()
    {
        $this->beforeFilter('csrf', array('on' => 'post'));        
        if ((Auth::check() == true) && (!Session::has("organizatie_noua")))
        {        
            //dd(Session::get("ID_APP"));
            Log::info("Cauta in BD organizatia utilizatorului actual");
            $_organizatie = DB::table('organizations')
                ->join('users', 'users.id_org', '=', 'organizations.id')
                ->select(
                    'organizations.name AS organizatie', 
                    'organizations.id AS id_organizatie',
                    'users.full_name AS utilizator'
                    )
                ->where('users.id', Auth::id())
                ->where('logical_delete', 0)->get();
            if (count($_organizatie) > 0)
            {            
                View::share('_organizatie', $_organizatie);
                Session::put("organizatie_noua", "1");
                Session::put("organizatie", $_organizatie);
            }            
        }

//dd(self::organizatie());
        if (Auth::check() == false)
        {                
            if(Request::path() != 'user/login')
                die(header('Location: ' . URL::to('user/login')));
        }
    }

    //Model de eroare pentru Hostinger
    public function getError()
    {
        $loc = DB::select("SELECT * from v_localitate_descriere limit 1");
        dd($loc);
    }

    public function organizatie()
    {
        $org = array();
        if (Session::has("organizatie"))
        {
            $org = Session::get("organizatie");
        }
        return $org;
    }

    protected function redirectTo($url, $statusCode = 302)
    {
        return Redirect::route($url, $statusCode);
    }

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

    public function object_to_array($data)
    {
        $array = array();
        foreach ($data as $value)         
        {              
            $array[$value->id] = $value->denumire;
        }        
        return $array;
    }

    public function getIDsDepartamente($departamente)
    {
        $ids = "";
        if($departamente !== null)
        {
            foreach ($departamente AS $departament) {
                $ids = $ids . $departament->id . ',';
            }
            if(self::endsWith($ids, ',')) $ids = substr($ids, 0, strlen($ids)-1);
        }
        if (self::strictEmpty($ids)) $ids = '-1';
        return $ids;
    }

    function strictEmpty($var) 
    {
        if(isset($var))
        {
            $var = trim($var);
            if(isset($var) === true && $var === '') {
                return true;
            }
        }
        return false;
    }

    public function getIDsEntitati($departamente)
    {        
        $ids = "";
        if($departamente !== null)
        {
            foreach ($departamente AS $departament) {
                $ids = $ids . $departament->id_entitate . ',';
            }
            if(self::endsWith($ids, ',')) $ids = substr($ids, 0, strlen($ids)-1);
        }
        return $ids;
    }

    public function getCoteTVA()
    {
        $tva = DB::Select("SELECT 
            id, concat(valoare, ' %') AS denumire 
            FROM tva
            WHERE logical_delete = 0");
        return self::object_to_array($tva);    
    }

    public function getStadiiLivrabil()
    {
        $stadii = DB::Select("SELECT 
            id, denumire 
            FROM stadiu_livrabil
            WHERE logical_delete = 0");
        return self::object_to_array($stadii);    
    }
    
    public function getEntitatiOrganizatie($departamente = null)
    {
        $sql = "SELECT 
            ent.id, ent.denumire
            FROM entitate ent";
            
        if ($departamente !== null)
        {
            $dep = self::getIDsDepartamente($departamente);
            $sql = $sql . " INNER JOIN departament d ON d.id_entitate = ent.id and d.id IN (" . $dep . ")"; 
        }
        $sql = $sql .  
            " WHERE ent.logical_delete = 0 
            AND ent.id_tip_entitate = 1
            AND ent.id_organizatie = :id_organizatie
            GROUP BY ent.id";

        $entitati_organizatie = DB::select($sql, array('id_organizatie' => isset(self::organizatie()[0])?self::organizatie()[0]->id_organizatie:-1));
        return self::object_to_array($entitati_organizatie);        
    }

    public function getDestinatieSpatiu()
    {
        $destinatie_spatiu = DB::select(
            "SELECT
            id, denumire 
            FROM destinatie_spatiu
            WHERE logical_delete = 0");
        return self::object_to_array($destinatie_spatiu);
    }

    public function getTipLucrari()
    {
        $tip_lucrari = DB::select(
            "SELECT
            id, denumire 
            FROM tip_lucrari
            WHERE logical_delete = 0");
        return self::object_to_array($tip_lucrari);
    }

    public function getAcordLocatar()
    {
        $acord_locatar = DB::select(
            "SELECT
            id, denumire 
            FROM acord_locatar
            WHERE logical_delete = 0");
        return self::object_to_array($acord_locatar);
    }

    public function getVenitLocatar()
    {
        $venit_locatar = DB::select(
            "SELECT
            id, denumire 
            FROM venit_lunar_locatar
            WHERE logical_delete = 0
            ORDER BY id");
        return self::object_to_array($venit_locatar);
    }

    public function getParteneriOrganizatie()
    {
       $parteneri_organizatie = DB::select("SELECT 
            id, denumire 
            FROM entitate ent
            WHERE logical_delete = 0
            AND ent.id_tip_entitate = 2
            AND ent.id_organizatie = :id_organizatie", 
            array('id_organizatie' => isset(self::organizatie()[0])?self::organizatie()[0]->id_organizatie:-1));
        return self::object_to_array($parteneri_organizatie);        
    }
    public function getEntitatiPublice()
    {
       $entitati_publice = DB::select("SELECT 
            id, denumire 
            FROM entitate ent
            WHERE logical_delete = 0
            AND ent.id_tip_entitate = 3");           
        return self::object_to_array($entitati_publice);        
    }

    public function getParteneri()
    {
       $parteneri = DB::select("

            SELECT
            id, 
            (CASE 
                WHEN ent.id_tip_entitate = 1 THEN 
                    concat(denumire, ' (FIRMA GRUP)')
                WHEN ent.id_tip_entitate = 2 THEN 
                    concat(denumire, ' (CLIENT)') 
            END) AS denumire
            FROM entitate ent
            WHERE logical_delete = 0
            AND ent.id_tip_entitate = 1 OR ent.id_tip_entitate = 2
            AND ent.id_organizatie = :id_organizatie

            UNION
            
            SELECT 
            id, concat(denumire, ' (UAT)') as denumire
            FROM entitate ent
            WHERE logical_delete = 0
            AND ent.id_tip_entitate = 3", 
            array('id_organizatie' => isset(self::organizatie()[0])?self::organizatie()[0]->id_organizatie:-1));

        return self::object_to_array($parteneri);        
    }

    public function getUMTimp() 
    {
        $ums_timp = DB::select("SELECT 
            id, denumire 
            FROM um_timp
            WHERE logical_delete = 0");
        return self::object_to_array($ums_timp);
    }

    /*public function getContract($id_contract) {
        
        $contract = DB::select("SELECT
            id,  
            numar,
            date_format(data_semnarii, '%d-%m-%Y') as data_semnarii,
            valoare, 
            tva           
        FROM contract 
        WHERE logical_delete = 0  
        AND id = :id_contract        
        LIMIT 1", array('id_contract' => $id_contract));
        return $contract;
    }*/

    public function getContractSelect($id) {

        $contract = DB::select("SELECT
            id,  
            denumire
        FROM contract 
        WHERE logical_delete = 0  
        AND id = :id", array('id' => $id));
        return self::object_to_array($contract);
    }    

    public function getSeriiFacturare()
    {        
        $ids = self::getIDsEntitati(Confide::getDepartamenteUser());     
        $serii_facturare = DB::select("SELECT
            sf.id,
            sf.serie,
            sf.numar,
            ent.denumire AS entitate          
            FROM serie_factura sf            
            INNER JOIN entitate ent ON ent.id = sf.id_entitate AND ent.logical_delete = 0
            WHERE sf.logical_delete = 0
            AND sf.id_entitate IN (" . $ids . ")");

        /*$serii_facturare = DB::select("SELECT
            sf.id_serie_factura,
            sf.serie,
            sf.numar            
            FROM serie_factura sf
            INNER JOIN entitate ON entitate.id = sf.id_entitate AND entitate.logical_delete = 0
            WHERE sf.logical_delete = 0
            AND entitate.id_organizatie = :id_organizatie", array('id_organizatie' => isset(self::organizatie()[0])?self::organizatie()[0]->id_organizatie:-1));*/
        
        return $serii_facturare;
    }
    
    public function getFactura($id_factura)
    {
         $factura = DB::Select(
            "SELECT
            fc.id,
            fc.serie, 
            fc.numar,
            date_format(fc.data_facturare, '%d-%m-%Y') as data_facturare            
            FROM factura_client fc
            WHERE fc.id = :id_fc

            UNION
            
            SELECT
            ff.id,
            ff.serie, 
            ff.numar,
            date_format(ff.data_facturare, '%d-%m-%Y') as data_facturare            
            FROM factura_furnizor ff
            WHERE ff.id = :id_ff",  
            array('id_fc' => $id_factura, 'id_ff' => $id_factura));  
         return $factura[0];
    }

    public function getFacturaClient($id_factura)
    {
         $factura = DB::Select("SELECT
            fact.id, 
            fact.serie, 
            fact.numar,
            date_format(fact.data_facturare, '%d-%m-%Y') as data_facturare,
            fact.termen_plata,
            fact.id_prestator,
            fact.id_client,
            fact.observatii,
            fact.tva,
            ent.denumire AS prestator, 
            cli.denumire AS client,
            (SELECT SUM(le.pret_fara_tva) FROM livrabile_etapa le WHERE le.id_factura = fact.id AND le.logical_delete = 0) AS total
            FROM factura_client fact
            LEFT OUTER JOIN entitate ent ON ent.id = fact.id_prestator AND ent.logical_delete = 0
            LEFT OUTER JOIN entitate cli ON cli.id = fact.id_client AND ent.logical_delete = 0
            WHERE fact.id = :id_factura",  array('id_factura' => $id_factura));  

         return $factura[0];
    }

    public function getFacturaFurnizor($id_factura)
    {
         $factura = DB::Select("SELECT
            fact.id, 
            fact.serie, 
            fact.numar,
            date_format(fact.data_facturare, '%d-%m-%Y') as data_facturare,
            fact.termen_plata,
            fact.id_beneficiar,
            fact.id_furnizor,
            fact.observatii,
            fact.tva,
            ent.denumire AS prestator, 
            fur.denumire AS furnizor,
            (SELECT SUM(le.pret_fara_tva) FROM livrabile_etapa le WHERE le.id_factura = fact.id AND le.logical_delete = 0) AS total
            FROM factura_furnizor fact
            LEFT OUTER JOIN entitate ent ON ent.id = fact.id_beneficiar AND ent.logical_delete = 0
            LEFT OUTER JOIN entitate fur ON fur.id = fact.id_furnizor AND fur.logical_delete = 0
            WHERE fact.id = :id_factura",  array('id_factura' => $id_factura));  
         return $factura[0];
    }

    public function getUM()
    {
        $ums = DB::select("SELECT
            id, 
            denumire
            FROM um 
            WHERE logical_delete = 0");
        return $ums;
    }

    public function getTipIntreprindere()
    {
       $ti = DB::select("SELECT 
            id, denumire 
            FROM tip_intreprindere
            WHERE logical_delete = 0
            ORDER BY id");
        return self::object_to_array($ti);
    }

    public function getMarimeIntreprindere()
    {
       $mi = DB::select("SELECT 
            id, denumire 
            FROM marime_intreprindere
            WHERE logical_delete = 0
            ORDER BY id");
        return self::object_to_array($mi);
    }

    public function text_2_number($text)
    {
        if (is_string($text))
        {
            $text = str_replace('.', '', $text);
            $text = str_replace(',', '.', $text);
            return doubleval($text);
        }
        return 0;
    }
    
    static function numere_aproape_egale($n1, $n2)
    {
        try
        {
            $n1 = doubleval($n1);
            $n2 = doubleval($n2);
            if ($n1 > $n2)
                if (($n1 - $n2) < 0.0000001)
                    return true;
            if ($n2 > $n1)
                if (($n2 - $n1) < 0.0000001)
                    return true;
        }
        catch(Exception $e)
        {        
        }
        return false;
    }    

    public function startsWith($haystack, $needle) {
        // search backwards starting from haystack length characters from the end
        return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
    }
    
    public function endsWith($haystack, $needle) {
        // search forward starting from end minus needle length characters
        return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
    }    
}

abstract class NivelContractare
{
    const Beneficiar = 1;
    const Prestator = 2;
}