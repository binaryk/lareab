<?php

namespace Binaryk\Achizitii\Form;

class TipProceduriAchizitiiForm extends \Processing\Form\Form
{

    public static function make()
	{
		return self::$instance = new TipProceduriAchizitiiForm();
	}

	protected function setView()
	{
		$this->view('achizitii::nomenclator.modalitati_publicare.proc_achizitii.form');	
	}

	protected function setModel()
	{
		$this->model('Binaryk|Models|Nomenclator|TipProceduriAchizitii');
	}

	protected function addControls()
	{  

		$this
		->addControl(
			\Easy\Form\Textbox::make('achizitii::~layouts.form.controls.textboxes.textbox')
			->name('denumire')
			->caption('Denumirea tipului de procedură')
			->placeholder('Denumirea tipului de procedură')
			->class('form-control  data-source')
			->controlsource('nume')
			->controltype('textbox')
			->maxlength(255)
		)
		->addControl(
			\Easy\Form\Combobox::make('achizitii::~layouts.form.controls.comboboxes.combobox')
				->name('tip_achizitor')
				->caption('Tip achizitor')
				->class('form-control data-source input-group form-select init-on-update-delete')
				->controlsource('tip_achizitor')
				->controltype('combobox')
				->enabled('false')
				->options(\Binaryk\Models\Nomenclator\Tip::achizitori())
		)
		;
	}
}