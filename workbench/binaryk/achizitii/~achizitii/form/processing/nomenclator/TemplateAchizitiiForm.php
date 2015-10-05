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
			->caption('Titlu template')
			->placeholder('Titlu template')
			->class('form-control  data-source')
			->controlsource('nume')
			->controltype('textbox')
			->maxlength(255)
		)  
		->addControl(
			\Easy\Form\Textbox::make('achizitii::~layouts.form.controls.textboxes.textbox')
			->name('cod_procedura')
			->caption('Cod procedură')
			->placeholder('Cod procedură')
			->class('form-control  data-source')
			->controlsource('cod_procedura')
			->controltype('textbox')
			->maxlength(255)
		)
		->addControl(
			\Easy\Form\Textbox::make('achizitii::~layouts.form.controls.textboxes.textbox')
			->name('descriere_procedura')
			->caption('Descriere procedură')
			->placeholder('Descriere procedură')
			->class('form-control  data-source')
			->controlsource('descriere_procedura')
			->controltype('textbox')
			->maxlength(255)
		)
		->addControl(
			\Easy\Form\Combobox::make('achizitii::~layouts.form.controls.comboboxes.combobox')
				->name('tip_achizitor')
				->caption('Tip achizitor')
				->class('form-control data-source input-group form-select init-on-update-delete_')
				->controlsource('tip_achizitor')
				->controltype('combobox')
				->enabled('false')
				->options(\Binaryk\Models\Nomenclator\Tip::achizitori())
		)
		->addControl(
			\Easy\Form\Combobox::make('achizitii::~layouts.form.controls.comboboxes.combobox')
				->name('tip_contract')
				->caption('Tip contract')
				->class('form-control data-source input-group form-select init-on-update-delete')
				->controlsource('tip_contract')
				->controltype('combobox')
				->enabled('false')
				->options(\Binaryk\Models\Nomenclator\Tip::contract())
		)
		->addControl(
			\Easy\Form\Combobox::make('achizitii::~layouts.form.controls.comboboxes.combobox')
				->name('tip_procedura')
				->caption('Tip procedură')
				->class('form-control data-source input-group form-select init-on-update-delete')
				->controlsource('tip_procedura')
				->controltype('combobox')
				->enabled('false')
				->options(['0' => '-- Selectați mai întîi [tip achizitor] --'])
		)
		->addControl(
			\Easy\Form\Combobox::make('achizitii::~layouts.form.controls.comboboxes.combobox')
				->name('tip_anunt')
				->caption('Tip anunț')
				->class('form-control data-source input-group form-select init-on-update-delete')
				->controlsource('tip_anunt')
				->controltype('combobox')
				->enabled('false')
				->options(\Binaryk\Models\Nomenclator\ModalitatiPublicare::anterior())
		)
		->addControl(
			\Easy\Form\Combobox::make('achizitii::~layouts.form.controls.comboboxes.combobox')
				->name('plafon_maxim')
				->caption('Plafon maxim')
				->class('form-control data-source input-group form-select init-on-update-delete')
				->controlsource('plafon_maxim')
				->controltype('combobox')
				->enabled('false')
				->options(['' => '','5,000' => '5,000','30,000' => '30,000','100,000' => '100,000','130,000' => '130,000','200,000' => '200,000','5,000,000' => '5,000,000'])
		)
		->addControl(
			\Easy\Form\Textbox::make('achizitii::~layouts.form.controls.textboxes.textbox-addon')
				->name('data_semnare_cf')->caption('Data semnare CF')->placeholder('Data semnare CF')
				->class('form-control data-source')->readonly(1)
				->controlsource('data_semnare_cf')->controltype('textbox')
				->addon(['before' => '<i class="fa fa-calendar"></i>', 'after' => NULL])
		)

		;
	}

}