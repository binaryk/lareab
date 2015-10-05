<?php namespace Binaryk\Controllers\Nomenclator; 
use BaseController;
use Illuminate\Support\Facades\View; 
use Binaryk\Models\Sys\Grids;

class TipAnuntController extends \Datatable\DatatableController {

	protected $layout = 'achizitii::~layout.master';

	public function index($id, $id_procedura)
	{
	    if (!($procedura = \Binaryk\Models\Nomenclator\TipProceduriAchizitii::getRecord((int)$id_procedura))) {
	        return \Redirect::route('proceduri-achizitii');
	    }

	    $config = Grids::make($id)->toIndexConfig($id);
	    $config['row-source'] .= '/' . $id_procedura;
	    $this->show($config + ['other-info' => [ 'procedura' => $procedura ]]);
	}

	public function rows($id, $id_procedura)
	{
	    $config = Grids::make($id)->toRowDatasetConfig($id);
	    $filters = $config['source']->custom_filters();
	    $config['source']->custom_filters($filters + ['procedura' => 'ach_tip_anunturi.id_tip_procedura = ' . $id_procedura]);
	    return $this->dataset($config);
	}

}

