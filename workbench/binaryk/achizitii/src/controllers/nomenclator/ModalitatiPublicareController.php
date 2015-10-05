<?php namespace Binaryk\Controllers\Nomenclator; 

use BaseController;
use Illuminate\Support\Facades\View; 
use Models\Nomenclator\TipAnunturi;
use Binaryk\Models\Nomenclator\ModalitatiPublicare;
use Binaryk\Models\Sys\Grids;

class ModalitatiPublicareController extends \Datatable\DatatableController {

	protected $layout = 'achizitii::~layout.master';

	public function index($id, $id_anunt)
	{

	    if (!($anunt = \Binaryk\Models\Nomenclator\TipAnunturi::getRecord((int)$id_anunt))) {
	        return \Redirect::route('proceduri-achizitii');
	    }


	    $config = Grids::make($id)->toIndexConfig($id);
	    $config['row-source'] .= '/' . $id_anunt;

	    $this->show($config + ['other-info' => [ 'anunt' => $anunt ]]);
	}

	public function rows($id, $id_anunt)
	{
	    $config = Grids::make($id)->toRowDatasetConfig($id);
	    $filters = $config['source']->custom_filters();
	    $config['source']->custom_filters($filters + ['anunt' => 'ach_modalitati_publicare.id_tip_anunt = ' . $id_anunt]);
	    return $this->dataset($config);
	}

}

