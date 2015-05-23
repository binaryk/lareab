<?php

class BaseController extends Controller {

    /**
     * Initializer.
     *
     * @access   public
     * @return \BaseController
     */
    protected $date_organizatie = NULL;
    public function __construct()
    {
        $this->beforeFilter('csrf', array('on' => 'post'));
		/*$_organizatie = DB::table('organizations')
        	->join('users', 'users.id_org', '=', 'organizations.id')
        	->select(
        		'organizations.name AS organizatie', 
        		'organizations.id AS id_organizatie',
        		'users.full_name AS utilizator'
        		)
        	->where('users.id', Auth::id())->get();
            //dd($_organizatie);
        if (count($_organizatie) > 0)
        {
            $this->date_organizatie = $_organizatie[0];
            View::share('_organizatie', $this->date_organizatie);
        }
        else return redirect('/')->with('message', 'Login Failed');*/
        //dd($this->date_organizatie);
        
        if (Auth::check() == true)
        {        
            $_organizatie = DB::table('organizations')
                ->join('users', 'users.id_org', '=', 'organizations.id')
                ->select(
                    'organizations.name AS organizatie', 
                    'organizations.id AS id_organizatie',
                    'users.full_name AS utilizator'
                    )
                ->where('users.id', Auth::id())->get();
            if (count($_organizatie) > 0)
            {            
                View::share('_organizatie', $_organizatie);
                $this->date_organizatie = $_organizatie;  
            }
        }

        if (Auth::check() == false)
        {                
            if(Request::path() != 'user/login')
                die(header('Location: ' . URL::to('user/login')));
        }
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
    public function getEntitatiOrganizatie()
    {
        $entitati_organizatie = DB::select("SELECT 
            id_entitate, denumire 
            FROM entitate ent
            WHERE logical_delete = 0
            AND ent.gestionata_org = true
            AND ent.id_organizatie = :id_organizatie", 
            array('id_organizatie' => $this->date_organizatie[0]->id_organizatie));
        return $entitati_organizatie;        
    }
    public function getParteneriOrganizatie()
    {
       $parteneri_organizatie = DB::select("SELECT 
            id_entitate, denumire 
            FROM entitate ent
            WHERE logical_delete = 0
            AND ent.gestionata_org = false
            AND ent.id_organizatie = :id_organizatie", 
            array('id_organizatie' => $this->date_organizatie[0]->id_organizatie));
        return $parteneri_organizatie;        
    }
    public function getEntitatiPublice()
    {
       $entitati_publice = DB::select("SELECT 
            id_entitate, denumire 
            FROM entitate ent
            WHERE logical_delete = 0
            AND ent.gestionata_org = false
            AND ent.id_organizatie IS NULL
            AND ent.id_tip_entitate = 2");           
        return $entitati_publice;        
    }

    public function getUMTimp() {
        
        $ums_timp = DB::select("SELECT 
            id_um, denumire 
            FROM um_timp
            WHERE logical_delete = 0");
        return $ums_timp;
    }

    public function getContract($id_contract) {
        
        $contract = DB::select("SELECT
            id_contract,  
            numar,
            date_format(data_semnarii, '%d-%m-%Y') as data_semnarii,
            valoare, 
            tva           
        FROM contract 
        WHERE logical_delete = 0  
        AND id_contract = :id_contract        
        LIMIT 1", array('id_contract' => $id_contract));
        return $contract;               
    }
    
    public function getSeriiFacturare()
    {
        $serii_facturare = DB::select("SELECT
            sf.id_serie_factura,
            sf.serie,
            sf.numar            
            FROM serie_factura sf
            INNER JOIN entitate ON entitate.id_entitate = sf.id_entitate AND entitate.logical_delete = 0
            WHERE sf.logical_delete = 0
            AND entitate.id_organizatie = :id_organizatie", array('id_organizatie' => $this->date_organizatie[0]->id_organizatie));                        
        return $serii_facturare;
    }
    
    public function getFactura($id_factura)
    {
         $factura = DB::Select(
            "SELECT
            fc.serie, 
            fc.numar,
            date_format(fc.data_facturare, '%d-%m-%Y') as data_facturare            
            FROM factura_client fc
            WHERE fc.id_factura = :id_fc

            UNION
            
            SELECT
            ff.serie, 
            ff.numar,
            date_format(ff.data_facturare, '%d-%m-%Y') as data_facturare            
            FROM factura_furnizor ff
            WHERE ff.id_factura = :id_ff",  
            array('id_fc' => $id_factura, 'id_ff' => $id_factura));  
         return $factura[0];
    }

    public function getFacturaClient($id_factura)
    {
         $factura = DB::Select("SELECT
            fact.id_factura, 
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
            (SELECT SUM(le.pret_fara_tva) FROM livrabile_etapa le WHERE le.id_factura = fact.id_factura AND le.logical_delete = 0) AS total
            FROM factura_client fact
            LEFT OUTER JOIN entitate ent ON ent.id_entitate = fact.id_prestator AND ent.logical_delete = 0
            LEFT OUTER JOIN entitate cli ON cli.id_entitate = fact.id_client AND ent.logical_delete = 0
            WHERE fact.id_factura = :id_factura",  array('id_factura' => $id_factura));  
         return $factura[0];
    }

    public function getFacturaFurnizor($id_factura)
    {
         $factura = DB::Select("SELECT
            fact.id_factura, 
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
            (SELECT SUM(le.pret_fara_tva) FROM livrabile_etapa le WHERE le.id_factura = fact.id_factura AND le.logical_delete = 0) AS total
            FROM factura_furnizor fact
            LEFT OUTER JOIN entitate ent ON ent.id_entitate = fact.id_beneficiar AND ent.logical_delete = 0
            LEFT OUTER JOIN entitate fur ON fur.id_entitate = fact.id_furnizor AND fur.logical_delete = 0
            WHERE fact.id_factura = :id_factura",  array('id_factura' => $id_factura));  
         return $factura[0];
    }

    public function getUM()
    {
        $ums = DB::select("SELECT
            id_um, 
            denumire
            FROM um 
            WHERE logical_delete = 0");
        return $ums;
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
}

abstract class NivelContractare
{
    const Beneficiar = 1;
    const Prestator = 2;
}