<?php

/**
Usage: 
	#1) cursbnr::get('EUR') - for today
	#2) cursbnr::get('EUR', '2014-03-08') - for 8 March 2014 
	#3) cursbnr::last('EUR') - primul curs existent de azi inspre ieri, tinand cont ca in weekend nu exista curs
**/

class CursBNR
{
	protected static $instance = NULL;

	protected $endpoint		= 'http://www.bnr.ro/MakeXmlFile.aspx?date=';
	protected $xmlDocument 	= NULL;
	protected $date 		= '';
	protected $currency 	= array();

	public function __construct($date)
	{
		if( is_string($date) )
		{
			$date = Carbon::createFromFormat('Y-m-d', $date);
		}
		try
		{
			$this->xmlDocument = file_get_contents($this->endpoint . $date->format('d.m.Y'));
        	$this->__parseXMLDocument();
		}
		catch(Exception $e)
		{
			$this->xmlDocument = NULL;
		}
	}

	protected function __parseXMLDocument()
    {
    	$xml = new SimpleXMLElement($this->xmlDocument);
        $this->date = Carbon::createFromFormat('Y-m-d', (string) $xml->Body->Cube['date']);
        foreach($xml->Body->Cube->Rate as $line)    
        {
        	$this->currency[] =array(
        		"name"  => $line["currency"], 
        		"value" => $line, 
        		"multiplier" => $line["multiplier"]
        	);
         }
    }

	public function __getvalue($currency)
	{
		if(is_null($this->xmlDocument))
		{
			return NULL;
		}
		foreach($this->currency as $line)
		{
			if($line["name"]==$currency)
			{
				$result = new StdClass;
				$result->date = $this->date;
				$result->value = (double) $line['value'];
				$result->currency = $currency;
				$result->multiplier = (int) (isset($line["multiplier"]) ? $line["multiplier"] : 1);
				return $result;
			}
		}
		return NULL;
	}

	public static function get($currency, $date = NULL)
	{
		if( is_null($date) )
		{
			$date = Carbon::now();
		}
		self::$instance = new cursbnr($date);
		return self::$instance->__getvalue($currency, $date);
	}

	public static function last($currency)
	{
		$now = \Carbon::now();
		do
		{
			$result = self::get($currency, $now);
			if(is_null($result) )
			{
				$now = $now->subDays(1);
			}
		} 
		while( is_null($result) );
		return $result;
	}
}