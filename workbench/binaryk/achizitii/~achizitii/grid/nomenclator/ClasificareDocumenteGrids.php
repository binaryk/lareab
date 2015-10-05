<?php
namespace Binaryk\Achizitii\Grid;  

class ClasificareDocumenteGrids extends \Binaryk\Models\Sys\GridsRecord
{

	public function __construct($id)
	{
		parent::__construct($id);

		$this->view           = 'achizitii::~layouts.datatable.index';
		$this->icon           = 'admin/img/icons/dt/settings.png';
		$this->caption        = 'Clasificare documente de achiziții';
		$this->toolbar        = 'achizitii::nomenclator.clasificare_documente.toolbar';
		$this->name           = 'dt';
		$this->display_start  = 0;
		$this->display_length = 10;
		$this->default_order  = "1,'asc'"; 
		$this->form           = 'Binaryk\Achizitii\Form\ClasificareDocumenteForm';
		$this->css            = 'packages/binaryk/achizitii/admin/css/dt/dt.css, packages/binaryk/achizitii/admin/css/dt/toolbar.css, packages/binaryk/achizitii/admin/css/dt/dtform.css';
		$this->js             = 'packages/binaryk/achizitii/admin/js/libraries/form/dtform.js';
		$this->row_source     = 'datatable-row-source';
		$this->rows_source_sql 				= 'SELECT * FROM ach_clasificare_documente :where: :order:';
		$this->count_filtered_records_sql 	= 'SELECT COUNT(*) as cnt FROM ach_clasificare_documente :where:';
		$this->count_total_records_sql     	= 'SELECT COUNT(*) AS cnt FROM ach_clasificare_documente';
		$this->columns        = [
			'1' => [
				'id'        => '#',
				'orderable' => 'no',
				'class'     => 'td-record-count td-align-center',
				'visible'   => 'yes',
				'header'    => ['caption' => '#', 'style'   => 'width:5%',],
				'type'      => 'row-number',
				'source'    => 'row-number' 
			],
			'2' => [
				'id'        => 'denumire',
				'orderable' => 'yes',
				'class'     => 'td-align-left',
				'visible'   => 'yes',
				'header'    => ['caption' => 'Denumire document', 'style'   => 'width:60%',],
				'type'      => 'field',
				'source'    => 'nume',
			], 
			'3' => [
				'id'        => 'action',
				'orderable' => 'no',
				'class'     => 'td-align-center td-actions',
				'visible'   => 'yes',
				'header'    => ['caption' => 'Acţiuni', 'style'   => 'width:5%',],
				'type'      => 'view',
				'source'    => 'achizitii::nomenclator.general_actions.actions',
			],
		];
		$this->fields = [
			'fields'      => '',
			'searchables' => 'id, nume',
			'orderables'  => [1 => 'nume'],
		];
		$this->filters = [
			'deleted' => 'deleted_at is null',
		];

	}

    public static function create()
	{ 
		return self::$instance = new ClasificareDocumenteGrids('clasificare-documente');
	}
	
}