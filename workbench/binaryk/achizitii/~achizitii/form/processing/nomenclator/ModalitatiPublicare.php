<?php

namespace Binaryk\Achizitii\Form;

class ModalitatiPublicare extends \Processing\Form\Form
{

    public static function make()
	{
		return self::$instance = new ModalitatiPublicare();
	}

	protected function setView()
	{
		$this->view('achizitii::nomenclator.modalitati_publicare.form');	
	}

	protected function setModel()
	{
		$this->model('Binaryk|Models|Nomenclator|ModalitatiPublicare');
	}

	protected function addControls()
	{ 
		$this
		->addControl(
			\Easy\Form\Textbox::make('achizitii::~layouts.form.controls.textboxes.textbox')
			->name('denumire')
			->caption('Denumirea modalității de publicare')
			->placeholder('Denumirea modalității de publicare')
			->class('form-control  data-source')
			->controlsource('nume')
			->controltype('textbox')
			->maxlength(255)
		)
		->addControl(
			\Easy\Form\Combobox::make('achizitii::~layouts.form.controls.comboboxes.combobox')
				->name('anunt_anterior')
				->caption('Anunt intenție publicat anterior')
				->class('form-control data-source input-group form-select init-on-update-delete')
				->controlsource('anunt_anterior')
				->controltype('combobox')
				->enabled('false')
				->options(\Binaryk\Models\Nomenclator\ModalitatiPublicare::anterior())
		)
		->addControl(
			\Easy\Form\Combobox::make('achizitii::~layouts.form.controls.comboboxes.combobox')
				->name('tip_complexitate')
				->caption('Tip complexitate')
				->class('form-control data-source input-group form-select init-on-update-delete')
				->controlsource('tip_complexitate')
				->controltype('combobox')
				->enabled('false')
				->options(\Binaryk\Models\Nomenclator\ModalitatiPublicare::complexitate())
		)
		->addControl(
			\Easy\Form\Combobox::make('achizitii::~layouts.form.controls.comboboxes.combobox')
				->name('zile_dp')
				->caption('Zile D-P')
				->class('form-control data-source input-group form-select init-on-update-delete')
				->controlsource('zile_dp')
				->controltype('combobox')
				->enabled('false')
				->options(\Binaryk\Models\Nomenclator\ModalitatiPublicare::zile())
		)
		;
	}
}