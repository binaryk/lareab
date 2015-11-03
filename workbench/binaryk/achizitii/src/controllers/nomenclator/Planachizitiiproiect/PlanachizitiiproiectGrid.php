<?php namespace Binaryk\Achizitii\Grid;  

class PlanachizitiiproiectGrid extends \Binaryk\Models\Sys\GridsRecord
{

	public function __construct($id)
	{
		parent::__construct($id);

		$this->view           = 'achizitii::nomenclator.plan-achizitii-proiect.index';
		$this->icon           = 'admin/img/icons/dt/settings.png';
		$this->caption        = 'Proiecte';
		$this->toolbar        = 'achizitii::nomenclator.plan-achizitii-proiect.toolbar';
		$this->name           = 'dt';
		$this->display_start  = 0;
		$this->display_length = 10;
		$this->default_order  = "0,'asc'"; 
		$this->form           = 'Binaryk\Achizitii\Form\PlanachizitiiproiectForm';
		$this->css            = 'packages/binaryk/achizitii/admin/css/dt/dt.css, packages/binaryk/achizitii/admin/css/dt/toolbar.css, packages/binaryk/achizitii/admin/css/dt/dtform.css';
		$this->js             = 'packages/binaryk/achizitii/admin/js/libraries/form/dtform.js';
		$this->row_source     = 'plan-achizitii-proiect-row-source';

		$this->rows_source_sql 				= "
			SELECT 
				ach_plan_achizitii_proiecte.* 
			FROM ach_plan_achizitii_proiecte 
			:where: 
			:order:
		";
		$this->count_filtered_records_sql 	= "
			SELECT 
				COUNT(*) as cnt 
			FROM ach_plan_achizitii_proiecte
			:where:
		";
		$this->count_total_records_sql     	= "
			SELECT 
				COUNT(*) AS cnt 
			FROM ach_plan_achizitii_proiecte
		";
		
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
				'id'        => 'contract',
				'orderable' => 'no',
				'class'     => 'td-align-left',
				'visible'   => 'yes',
				'header'    => ['caption' => 'Achizitii', 'style'   => 'width:95%',],
				'type'      => 'view',
				'source'    => 'achizitii::nomenclator.plan-achizitii-proiect.~contract',
			],
			// '3' => [
			// 	'id'        => 'denumire',
			// 	'orderable' => 'yes',
			// 	'class'     => 'td-align-left',
			// 	'visible'   => 'yes',
			// 	'header'    => ['caption' => 'Titlu proiect', 'style'   => 'width:60%',],
			// 	'type'      => 'view',
			// 	'source'    => 'achizitii::nomenclator.proiecte.titlu',
			// ],
			// '4' => [
			// 	'id'        => 'tip-achizitor',
			// 	'orderable' => 'yes',
			// 	'class'     => 'td-align-left',
			// 	'visible'   => 'yes',
			// 	'header'    => ['caption' => 'Tip achizitor', 'style'   => 'width:20%',],
			// 	'type'      => 'view',
			// 	'source'    => 'achizitii::nomenclator.proiecte.tip-achizitor',
			// ],
			// '5' => [
			// 	'id'        => 'action',
			// 	'orderable' => 'no',
			// 	'class'     => 'td-align-center td-actions',
			// 	'visible'   => 'yes',
			// 	'header'    => ['caption' => 'Acţiuni', 'style'   => 'width:5%',],
			// 	'type'      => 'view',
			// 	'source'    => 'achizitii::nomenclator.proiecte.actions',
			// ],
		];
		$this->fields = [
			'fields'      => '',
			'searchables' => '',
			'orderables'  => [],
		];
		$this->filters = [
		];

	}

    public static function create()
	{ 
		return self::$instance = new PlanachizitiiproiectGrid('plan-achizitii-proiect');
	}
	
}