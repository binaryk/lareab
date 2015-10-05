<?php

namespace Datatable;

class Header 
{
	protected static $instance = NULL;

	protected $caption = 'Column Header Caption';
	protected $style  = NULL;

	public static function make()
	{
		return self::$instance = new Header();
	}

	public function __call($method, $args)
	{
		if(! property_exists($this, $method))
		{
			throw new \Exception(__CLASS__ . '. Property ' . $method . ' unknown.');
		}
		if( isset($args[0]) )
		{
			$this->{$method} = $args[0];
			return $this;
		}
		return $this->{$method};
	}

	public function cell()
	{
		return '<th style="' . $this->style . ' !important">' . $this->caption . '</th>';
	}

}