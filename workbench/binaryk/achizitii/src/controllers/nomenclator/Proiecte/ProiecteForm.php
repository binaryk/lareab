<?php namespace Binaryk\Achizitii\Form;

class ProiecteForm extends \Processing\Form\Form
{

    public static function make()
	{
		return self::$instance = new ProiecteForm();
	}

	protected function setView()
	{
		$this->view('achizitii::nomenclator.proiecte.form');	
	}

	protected function setModel()
	{
		$this->model('Binaryk|Models|Nomenclator|Proiect');
	}

	protected function addControls()
	{ 
		$this->addControl(
			\Easy\Form\Textbox::make('achizitii::~layouts.form.controls.textboxes.textbox')
			->name('titlu')
			->caption('Titlu proiect')
			->placeholder('Titlu proiect')
			->class('form-control data-source')
			->controlsource('titlu')
			->controltype('textbox')
			->maxlength(128)
		)
		->addControl(
			\Easy\Form\Combobox::make('achizitii::~layouts.form.controls.comboboxes.combobox')
			->name('tip_achizitor')
			->caption('Tip achizitor')
			->class('form-control data-source input-group form-select init-on-update-delete')
			->controlsource('tip_achizitor')
			->controltype('combobox')
			->enabled('false')
			->options(['-' => ' -- Selectati tipul de achizitor -- ', 'public' => 'Public', 'privat' => 'Privat'])
		);
	}
}