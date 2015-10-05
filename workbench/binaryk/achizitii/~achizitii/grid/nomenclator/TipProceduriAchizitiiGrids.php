<?php
namespace Binaryk\Achizitii\Grid;  

class TipProceduriAchizitiiGrids extends \Binaryk\Models\Sys\GridsRecord
{

	public function __construct($id)
	{
		parent::__construct($id);

		$this->view           = 'achizitii::nomenclator.modalitati_publicare.proc_achizitii.index';
		$this->icon           = 'admin/img/icons/dt/settings.png';
		$this->caption        = 'Tip proceduri achiziții';
		$this->toolbar        = 'achizitii::nomenclator.modalitati_publicare.proc_achizitii.toolbar';
		$this->name           = 'dt';
		$this->display_start  = 0;
		$this->display_length = 10;
		$this->default_order  = "1,'asc'"; 
		$this->form           = 'Binaryk\Achizitii\Form\TipProceduriAchizitiiForm';
		$this->css            = 'packages/binaryk/achizitii/admin/css/dt/dt.css, packages/binaryk/achizitii/admin/css/dt/toolbar.css, packages/binaryk/achizitii/admin/css/dt/dtform.css';
		$this->js             = 'packages/binaryk/achizitii/admin/js/libraries/form/dtform.js,packages/binaryk/achizitii/assets/js/metode_publicare/MetodePublicare.js';
		$this->row_source     = 'datatable-row-source';
		$this->rows_source_sql 				= 'SELECT * FROM ach_tip_proceduri_achizitii :where: :order:';
		$this->count_filtered_records_sql 	= 'SELECT COUNT(*) as cnt FROM ach_tip_proceduri_achizitii :where:';
		$this->count_total_records_sql     	= 'SELECT COUNT(*) AS cnt FROM ach_tip_proceduri_achizitii';
		$this->columns        = [
			'1' => [
				'id'        => '#',
				'orderable' => 'no',
				'class'     => 'td-record-count td-align-center',
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
				'header'    => ['caption' => 'Denumire procedură de achiziție', 'style'   => 'width:60%',],
				'type'      => 'field',
				'source'    => 'nume',
			],
			'3' => [
				'id'        => 'achizitor',
				'orderable' => 'yes',
				'class'     => 'td-align-left',
				'visible'   => 'yes',
				'header'    => ['caption' => 'Tip achizitor', 'style'   => 'width:30%',],
				'type'      => 'view',
				'source'    => 'achizitii::nomenclator.modalitati_publicare.proc_achizitii.achizitor',
			],
			'4' => [
				'id'        => 'action',
				'orderable' => 'no',
				'class'     => 'td-align-center td-actions',
				'visible'   => 'yes',
				'header'    => ['caption' => 'Acţiuni', 'style'   => 'width:5%',],
				'type'      => 'view',
				'source'    => 'achizitii::nomenclator.modalitati_publicare.proc_achizitii.actions',
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
		return self::$instance = new TipProceduriAchizitiiGrids('proceduri-achizitii');
	}
	
}