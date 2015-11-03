<?php
namespace Binaryk\Achizitii\Grid;  

class TemplateAchizitiiGrids extends \Binaryk\Models\Sys\GridsRecord
{

	public function __construct($id)
	{
		parent::__construct($id);

		$this->view           = 'achizitii::nomenclator.template_achizitii.index';
		$this->icon           = 'admin/img/icons/dt/settings.png';
		$this->caption        = 'Template achiziții';
		$this->toolbar        = 'achizitii::nomenclator.template_achizitii.toolbar';
		$this->name           = 'dt';
		$this->display_start  = 0;
		$this->display_length = 10;
		$this->default_order  = "1,'asc'"; 
		$this->form           = 'Binaryk\Achizitii\Form\TemplateAchizitiiForm';
		$this->css            = 'packages/binaryk/achizitii/admin/css/dt/dt.css, packages/binaryk/achizitii/admin/css/dt/toolbar.css, packages/binaryk/achizitii/admin/css/dt/dtform.css';
		$this->js             = 'packages/binaryk/achizitii/admin/js/libraries/form/dtform.js, 
								 packages/binaryk/achizitii/admin/js/libraries/form/combobox.js, 
								 packages/binaryk/achizitii/assets/js/template-achizitii/table.js,
								 packages/binaryk/achizitii/assets/js/template-achizitii/template_achizitii.js';
		$this->row_source     = 'nomenclator-template-achizitii-row-source';
		$this->rows_source_sql 				= "
			SELECT
				ach_template_achizitii.*,
				ach_tip_anunturi.nume as tip_anunt_nume
			FROM ach_template_achizitii 
			LEFT JOIN ach_tip_anunturi ON ach_template_achizitii.tip_anunt = ach_tip_anunturi.id
			:where:
			:order:
		";
		$this->count_filtered_records_sql 	= 'SELECT COUNT(*) as cnt FROM ach_template_achizitii :where:';
		$this->count_total_records_sql     	= 'SELECT COUNT(*) AS cnt FROM ach_template_achizitii';
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
				'id'        => 'nume',
				'orderable' => 'yes',
				'class'     => 'td-align-left',
				'visible'   => 'yes',
				'header'    => ['caption' => 'Titlu template', 'style'   => 'width:50%'],
				'type'      => 'field',
				'source'    => 'nume',
			],
			'3' => [
				'id'        => 'tip-anunt',
				'orderable' => 'no',
				'class'     => 'td-align-left',
				'visible'   => 'yes',
				'header'    => ['caption' => 'Tip anunt', 'style'   => 'width:25%'],
				'type'      => 'view',
				'source'    => 'achizitii::nomenclator.template_achizitii.tip_anunt',
			],
			'4' => [
				'id'        => 'dosar-achizitii',
				'orderable' => 'no',
				'class'     => 'td-align-center',
				'visible'   => 'yes',
				'header'    => ['caption' => 'Dosar achiziții', 'style'   => 'width:15%'],
				'type'      => 'view',
				'source'    => 'achizitii::nomenclator.template_achizitii.dosar_achizitii',
			],
			'5' => [
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
			'deleted' => 'ach_template_achizitii.deleted_at is null',
		];

	}

    public static function create()
	{ 
		return self::$instance = new TemplateAchizitiiGrids('template-achizitii');
	}
	
}