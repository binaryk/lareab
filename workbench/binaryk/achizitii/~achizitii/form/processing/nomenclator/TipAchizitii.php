<?php

namespace Binaryk\Achizitii\Form;

class TipAchizitii extends \Processing\Form\Form
{

    public static function make()
	{
		return self::$instance = new TipAchizitii();
	}

	protected function setView()
	{
		$this->view('achizitii::nomenclator.tip_achizitii.form');	
	}

	protected function setModel()
	{
		$this->model('Binaryk|Models|Nomenclator|TipAchizitii');
	}

	protected function addControls()
	{ 
		$this->addControl(
			\Easy\Form\Textbox::make('achizitii::~layouts.form.controls.textboxes.textbox')
			->name('denumire')
			->caption('Denumirea tipului procedurii')
			->placeholder('Denumirea tipului procedurii')
			->class('form-control  data-source')
			->controlsource('nume')
			->controltype('textbox')
			->maxlength(255)
		);
	}
}