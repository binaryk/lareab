<?php namespace Binaryk\Controllers\Nomenclator; 

use BaseController;
use Illuminate\Support\Facades\View; 
use Binaryk\Models\Sys\Grids;
use Binaryk\Models\Nomenclator\Template;

class TemplateAchizitiiController extends \Datatable\DatatableController {

	protected $layout = 'achizitii::~layout.master';
 	
	public function index($id)
	{ 

		$input = new \Binaryk\Achizitii\Form\TemplateAchizitiiForm;
		
		$config = \Binaryk\Models\Sys\Grids::make($id)->toIndexConfig($id);

		$config['breadcrumbs'] = [
            [
                'name' => 'Template achiziții',
                'url' => "nomenclator-template-achizitii",
                'ids' => ''
            ]
        ];

        $this->show( $config + ['other-info' => ['control']] );
	} 


	public function rows($id)
	{
		return $this->dataset( \Binaryk\Models\Sys\Grids::make($id)->toRowDatasetConfig($id) );
	}

	public function getTipAchizitiiTemplate(){
		$parent_model = \Input::get('parent_model');
		$parent_id = \Input::get('parent_id');

		$result = $parent_model::find($parent_id);
		
		return \Response::json([ 'options' => $result->achizitii ]);
	} 

	public function getTipAnuntByTipProcedura()
	{
		return \Response::json(['success' => true, 'options' => \Binaryk\Models\Nomenclator\TipAnunturi::toPopulateCombobox(\Input::get('id'))]);
	}

	public function getModalFormModalitatiPublicareByTipAnunt()
	{
		return \Response::json(['success' => true, 'modal' => \Binaryk\Models\Nomenclator\ModalitatiPublicare::toFormByTipAnunt(\Input::get('id_tip_anunt'))]);
	}

}