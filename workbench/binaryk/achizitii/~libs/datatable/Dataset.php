<?php

namespace Datatable;

class Dataset 
{

	public static function Response($config)
	{
		$response = Datatablerows::make();
		$response->source( $config['source'] );
		$response->draw( \Input::get('draw') );
		return $response->rows();
	} 

} 