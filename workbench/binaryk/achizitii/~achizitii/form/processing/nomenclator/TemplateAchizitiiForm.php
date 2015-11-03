<?php

namespace Binaryk\Achizitii\Form;

class TemplateAchizitiiForm extends \Processing\Form\Form
{

    public static function make()
	{
		return self::$instance = new TemplateAchizitiiForm();
	}

	protected function setView()
	{
		$this->view('achizitii::nomenclator.template_achizitii.form');	
	}

	protected function setModel()
	{
		$this->model('Binaryk|Models|Nomenclator|Template');
	}

	protected function addControls($model = NULL)
	{ 
		$this
		->addControl(
			\Easy\Form\Textbox::make('achizitii::~layouts.form.controls.textboxes.textbox')
			->name('nume')
			->caption('Titlu template (1)')
			->placeholder('Titlu template')
			->class('form-control  data-source')
			->controlsource('nume')
			->controltype('textbox')
			->maxlength(255)
		)  
		->addControl(
			\Easy\Form\Textbox::make('achizitii::~layouts.form.controls.textboxes.textbox')
			->name('cod_procedura')
			->caption('Cod procedură (2)')
			->placeholder('Cod procedură')
			->class('form-control  data-source')
			->controlsource('cod_procedura')
			->controltype('textbox')
			->maxlength(255)
		)
		->addControl(
			\Easy\Form\Textbox::make('achizitii::~layouts.form.controls.textboxes.textbox')
			->name('descriere_procedura')
			->caption('Descriere procedură (3)')
			->placeholder('Descriere procedură')
			->class('form-control  data-source')
			->controlsource('descriere_procedura')
			->controltype('textbox')
			->maxlength(255)
		)
		->addControl(
			\Easy\Form\Combobox::make('achizitii::~layouts.form.controls.comboboxes.combobox')
				->name('tip_achizitor')
				->caption('Tip achizitor (4)')
				->class('form-control data-source input-group form-select init-on-update-delete_')
				->controlsource('tip_achizitor')
				->controltype('combobox')
				->enabled('false')
				->options(\Binaryk\Models\Nomenclator\Tip::achizitori())
		)
		->addControl(
			\Easy\Form\Combobox::make('achizitii::~layouts.form.controls.comboboxes.combobox')
				->name('tip_contract')
				->caption('Tip contract (5)')
				->class('form-control data-source input-group form-select init-on-update-delete')
				->controlsource('tip_contract')
				->controltype('combobox')
				->enabled('false')
				->options(\Binaryk\Models\Nomenclator\Tip::contract())
		)
		->addControl(
			\Easy\Form\Combobox::make('achizitii::~layouts.form.controls.comboboxes.combobox')
				->name('tip_procedura')
				->caption('Tip procedură (6)')
				->class('form-control data-source input-group form-select')
				->controlsource('tip_procedura')
				->controltype('combobox')
				->enabled('false')
				->options(['0' => '-- Selectați mai întîi [tip achizitor] --'])
		)
		->addControl(
			\Easy\Form\Combobox::make('achizitii::~layouts.form.controls.comboboxes.combobox')
				->name('tip_anunt')
				->caption('Tip anunț (7)')
				->class('form-control data-source input-group form-select')
				->controlsource('tip_anunt')
				->controltype('combobox')
				->enabled('false')
				->options(['0' => '-- Selectați mai întîi [tip procedura] --'])
		)
		->addControl(
			\Easy\Form\Combobox::make('achizitii::~layouts.form.controls.comboboxes.combobox')
				->name('plafon_maxim')
				->caption('Plafon maxim (8)')
				->class('form-control data-source input-group form-select init-on-update-delete')
				->controlsource('plafon_maxim')
				->controltype('combobox')
				->enabled('false')
				->options(['' => '','5000' => '5.000','30000' => '30.000','100000' => '100.000','130000' => '130.000','200000' => '200.000','5000000' => '5.000.000'])
		)
		->addControl(
			\Easy\Form\Textbox::make('achizitii::~layouts.form.controls.textboxes.textbox-addon')
				->name('data_semnare_cf')->caption('Data semnare CF (9)')->placeholder('Data semnare CF')
				->class('form-control data-source')->readonly(1)
				->controlsource('data_semnare_cf')->controltype('textbox')
				->addon(['before' => '<i class="fa fa-calendar"></i>', 'after' => NULL])
		)
		;

		$items = \Binaryk\Models\Nomenclator\TipAchizitii::orderBy('id')->get();
		// 
		foreach($items as $i => $record)
		{
			$this->addControl( 
			\Easy\Form\Textbox::make('achizitii::~layouts.form.controls.textboxes.textbox-addon')
			->caption('')->name('txt-tip-achizitii')->placeholder('Textbox')
			->value($record->nume)->class('form-control input-sm')->enabled(0)
			->addon([
				'before' => \Form::checkbox('tip-achizitii-' . $record->id, '1', false, ['class' => 'data-source tipuri-achizitii', 'id' => 'tip-achizitii-' . $record->id, 'data-control-source' => 'tip_achizitii_' . $record->id, 'data-control-type' => 'checkbox', 'data-on' => 1, 'data-off' => 0]), 
				'after' => NULL])
			);
		}
	}

}