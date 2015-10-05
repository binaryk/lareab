<?php
namespace Binaryk\Achizitii\Grid;  

class TipAnuntGrids extends \Binaryk\Models\Sys\GridsRecord
{

	public function __construct($id)
	{
		parent::__construct($id);

		$this->view           = 'achizitii::~layouts.datatable.index';
		$this->icon           = 'admin/img/icons/dt/settings.png';
		$this->caption        = 'Tip anunț achiziții';
		$this->toolbar        = 'achizitii::nomenclator.modalitati_publicare.anunturi.toolbar';
		$this->name           = 'dt';
		$this->display_start  = 0;
		$this->display_length = 10;
		$this->default_order  = "1,'asc'"; 
		$this->form           = 'Binaryk\Achizitii\Form\TipAnunt';
		$this->css            = 'packages/binaryk/achizitii/admin/css/dt/dt.css, packages/binaryk/achizitii/admin/css/dt/toolbar.css, packages/binaryk/achizitii/admin/css/dt/dtform.css';
		$this->js             = 'packages/binaryk/achizitii/admin/js/libraries/form/dtform.js';
		$this->row_source     = 'nomenclator-tip-anunt-row-source';
		$this->rows_source_sql 				= 'SELECT * FROM ach_tip_anunturi :where: :order:';
		$this->count_filtered_records_sql 	= 'SELECT COUNT(*) as cnt FROM ach_tip_anunturi :where:';
		$this->count_total_records_sql     	= 'SELECT COUNT(*) AS cnt FROM ach_tip_anunturi';
		$this->columns        = [
			'1' => [
				'id'        => '#',
				'orderable' => 'no',
				'class'     => 'td-record-count td-align-left',
				'visible'   => 'yes',
				'header'    => ['caption' => '#', 'style'   => 'width:5%',],
				'type'      => 'row-number',
				'source'    => 'row-number',
			],
			'2' => [
				'id'        => 'denumire',
				'orderable' => 'yes',
				'class'     => 'td-align-left',
				'visible'   => 'yes',
				'header'    => ['caption' => 'Denumire tip anunț', 'style'   => 'width:90%',],
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
				'source'    => 'achizitii::nomenclator.modalitati_publicare.anunturi.actions',
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
		return self::$instance = new TipAnuntGrids('tip-anunt');
	}
	
}