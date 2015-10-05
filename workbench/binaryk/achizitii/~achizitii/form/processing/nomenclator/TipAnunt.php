<?php

namespace Binaryk\Achizitii\Form;

class TipAnunt extends \Processing\Form\Form
{

    public static function make()
	{
		return self::$instance = new TipAnunt();
	}

	protected function setView()
	{
		$this->view('achizitii::nomenclator.modalitati_publicare.anunturi.form');	
	}

	protected function setModel()
	{
		$this->model('Binaryk|Models|Nomenclator|TipAnunturi');
	}

	protected function addControls()
	{ 
		$this->addControl(
			\Easy\Form\Textbox::make('achizitii::~layouts.form.controls.textboxes.textbox')
			->name('denumire')
			->caption('Denumire tip anunț achiziției')
			->placeholder('Denumire tip anunț achiziției')
			->class('form-control  data-source')
			->controlsource('nume')
			->controltype('textbox')
			->maxlength(255)
		);
	}
}