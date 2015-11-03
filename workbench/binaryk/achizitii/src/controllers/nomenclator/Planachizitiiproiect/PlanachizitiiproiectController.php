<?php namespace Binaryk\Controllers\Nomenclator; 

class PlanachizitiiproiectController extends \Datatable\DatatableController
{

	protected $layout = 'achizitii::~layout.master';
	protected $id     = 'plan-achizitii-proiect';

	public function index($proiect_id, $id = NULL)
	{
		$proiect = \Binaryk\Models\Nomenclator\Proiect::find( (int) $proiect_id);
		if( is_null($proiect) )
		{
			return \Redirect::route('proiecte-index');
		}
	    $config = \Binaryk\Models\Sys\Grids::make($this->id)->toIndexConfig($this->id);
	    $config['caption'] = 'Planul de achizitii al proiectului ' . $proiect->titlu;
	    $config['row-source'] = \URL::route('plan-achizitii-proiect-row-source', ['id_proiect' => $proiect->id]);
	    $this->show($config + ['other-info' => [
	    	'proiect'           => $proiect,
	    	'modal_form'        => \Easy\Form\Modal::make('achizitii::~layouts.form.modals.modal')
				->id('frm-templates')
				->caption('-')
				->closable(true)
				->body('-')
				->footer('-')
	    ]]);
	}

	public function rows($id_proiect, $id = NULL)
	{
	    $config = \Binaryk\Models\Sys\Grids::make($this->id)->toRowDatasetConfig($this->id);
	    $filters = $config['source']->custom_filters();
	    $config['source']->custom_filters($filters + ['proiect' => 'ach_plan_achizitii_proiecte.id_proiect = ' . $id_proiect]);
	    return $this->dataset($config);
	}

	public function getCursValutar()
	{
		$curs = \CursBNR::get(\Input::get('currency'), \Input::get('date') );
		return \Response::json(['curs' => $curs]);
	}

	public function getTemplates()
	{
		$tip_achizitor = \Input::get('tip_achizitor');
		$tip_contract = \Input::get('tip_contract');
		$plafon       = \Input::get('valoare_eur'); 
		$templates = \Binaryk\Models\Nomenclator\Template::where('tip_achizitor_', $tip_achizitor)->where('tip_contract_', $tip_contract)->whereRaw( '((plafon_maxim >=' . $plafon . ') OR (plafon_maxim = 0))')->orderBy('plafon_maxim')->get();

		return \Response::json([
			'title' => 'Selectati templateul de achizitii',
			'body'  => \View::make('achizitii::nomenclator.plan-achizitii-proiect.templates-for-selection')->with([
				'tip_achizitor' => $tip_achizitor,
				'tip_contract'  => $tip_contract,
				'plafon'        => $plafon,
				'records'       => $templates,
			])->render(),
			'footer' => '<button id="btn-select-template" class="btn btn-primary">Selecteaza</button><button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>'
		]);
	}

	public function getTemplateRecord()
	{
		$template = \Binaryk\Models\Nomenclator\Template::find(\Input::get('id_template') );
		$template->tip_procedura_ = $template->tipprocedura ? $template->tipprocedura->nume : '-';
		$template->tip_anunt_ = $template->tipanunt ? $template->tipanunt->nume : '-';
		$template->tip_achizitie_ = json_decode($template->tip_achizitie);

		if($template->tip_anunt)
		{
			$template->modalitati_publicare = \Binaryk\Models\Nomenclator\ModalitatiPublicare::where('id_tip_anunt', $template->tip_anunt)->get();
			foreach($template->modalitati_publicare as $i => $record)
			{
				$record->is_anunt_anterior_ =  \Binaryk\Models\Nomenclator\ModalitatiPublicare::toTextAnterior($record->anunt_anterior);
				$record->complexitate_ =  \Binaryk\Models\Nomenclator\ModalitatiPublicare::toTextTipComplexitate($record->tip_complexitate);
				$record->zile_depunere_publicare_ =  \Binaryk\Models\Nomenclator\ModalitatiPublicare::toTextZileDP($record->zile_dp);
			}
		}
		else
		{
			$template->modalitati_publicare = NULL;	
		}


		return \Response::json(['record' => $template]);
	}
}