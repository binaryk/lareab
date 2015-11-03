<?php namespace Binaryk\Controllers\Nomenclator; 

class ProiecteController extends \Datatable\DatatableController
{

	protected $layout = 'achizitii::~layout.master';
	protected $id     = 'lista-proiecte';

	public function index($id = NULL)
	{
	    $config = \Binaryk\Models\Sys\Grids::make($this->id)->toIndexConfig($this->id);
	    $this->show($config + ['other-info' => []]);
	}

	public function rows($id = NULL)
	{
	    $config = \Binaryk\Models\Sys\Grids::make($this->id)->toRowDatasetConfig($this->id);
	    return $this->dataset($config);
	}

}