<?php

namespace Binaryk\Achizitii\Form;

class ClasificareDocumenteForm extends \Processing\Form\Form
{

    public static function make()
	{
		return self::$instance = new ClasificareDocumenteForm();
	}

	protected function setView()
	{
		$this->view('achizitii::nomenclator.clasificare_documente.form');	
	}

	protected function setModel()
	{
		$this->model('Binaryk|Models|Nomenclator|ClasificareDocumente');
	}

	protected function addControls()
	{ 
		$this->addControl(
			\Easy\Form\Textbox::make('achizitii::~layouts.form.controls.textboxes.textbox')
			->name('denumire')
			->caption('Denumirea documentului')
			->placeholder('Denumirea documentului')
			->class('form-control  data-source')
			->controlsource('nume')
			->controltype('textbox')
			->maxlength(255)
		);
	}
}