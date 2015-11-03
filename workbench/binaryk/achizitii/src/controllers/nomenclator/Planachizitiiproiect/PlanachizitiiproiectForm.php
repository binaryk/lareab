<?php namespace Binaryk\Achizitii\Form;

class PlanachizitiiproiectForm extends \Processing\Form\Form
{

    public static function make()
	{
		return self::$instance = new PlanachizitiiproiectForm();
	}

	protected function setView()
	{
		$this->view('achizitii::nomenclator.plan-achizitii-proiect.form');	
	}

	protected function setModel()
	{
		$this->model('Binaryk|Models|Nomenclator|Planachizitiiproiect');
	}

	protected function addControls()
	{ 
		$this->addControl(
			\Easy\Form\Combobox::make('achizitii::~layouts.form.controls.comboboxes.combobox')
			->name('tip_contract')
			->caption('Tip contract')
			->class('form-control data-source input-group form-select init-on-update-delete')
			->controlsource('tip_contract')
			->controltype('combobox')
			->options(['-' => ' -- Selectati tipul de contract -- ', 'servicii' => 'Servicii', 'lucrari' => 'Lucrari', 'furnizare' => 'Furnizare'])
		)
		->addControl( 
			\Easy\Form\Textbox::make('achizitii::~layouts.form.controls.textboxes.textbox')
			->name('valoare_estimata_eur_fara_tva')
			->caption($c = 'Valoarea estimata (EUR fara TVA)')
			->placeholder($c)
			->class('form-control data-source to-float to-float-2')
			->controlsource('valoare_estimata_eur_fara_tva')
			->controltype('textbox')
		)
		->addControl(
            \Easy\Form\Textbox::make('achizitii::~layouts.form.controls.textboxes.textbox-addon')
            ->name('data_curs')
            ->caption($c = 'Data curs valutar')
            ->placeholder($c)
            ->class('form-control data-source to-datepicker moment')
            ->controlsource('data_curs')
            ->controltype('textbox')
            ->addon(['before' => '<i class="fa fa-calendar"></i>', 'after' => NULL])
        )
        ->addControl( 
			\Easy\Form\Textbox::make('achizitii::~layouts.form.controls.textboxes.textbox')
			->name('curs_valutar')
			->caption($c = 'Cursul valutar (RON/EUR)')
			->placeholder($c)
			->class('form-control data-source to-float to-float-4')
			->controlsource('curs_valutar')
			->controltype('textbox')
		)
		->addControl( 
			\Easy\Form\Textbox::make('achizitii::~layouts.form.controls.textboxes.textbox')
			->name('valoare_estimata_ron_fara_tva')
			->caption($c = 'Valoarea estimata (LEI fara TVA)')
			->placeholder($c)
			->class('form-control data-source to-float to-float-2')
			->controlsource('valoare_estimata_ron_fara_tva')
			->controltype('textbox')
			->readonly(1)
		)

		->addControl( 
			\Easy\Form\Textbox::make('achizitii::~layouts.form.controls.textboxes.textbox')
			->name('cod_procedura')
			->caption($c = 'Cod procedura')
			->placeholder($c)
			->class('form-control data-source')
			->controlsource('cod_procedura')
			->controltype('textbox')
			->readonly(1)
		)
		->addControl( 
			\Easy\Form\Textbox::make('achizitii::~layouts.form.controls.textboxes.textbox')
			->name('descriere_procedura')
			->caption($c = 'Descriere procedura')
			->placeholder($c)
			->class('form-control data-source')
			->controlsource('descriere_procedura')
			->controltype('textbox')
			->readonly(1)
		)
		->addControl( 
			\Easy\Form\Textbox::make('achizitii::~layouts.form.controls.textboxes.textbox')
			->name('tip_procedura_')
			->caption($c = 'Tip procedura')
			->placeholder($c)
			->class('form-control')
			->readonly(1)
		)
		->addControl( 
			\Easy\Form\Textbox::make('achizitii::~layouts.form.controls.textboxes.textbox')
			->name('tip_anunt_')
			->caption($c = 'Tip anunt')
			->placeholder($c)
			->class('form-control')
			->readonly(1)
		)
		->addControl( 
			\Easy\Form\Textbox::make('achizitii::~layouts.form.controls.textboxes.textbox')
			->name('plafon_maxim')
			->caption($c = 'Plafon maxim')
			->placeholder($c)
			->class('form-control data-source to-float to-float-2')
			->controlsource('plafon_maxim')
			->controltype('textbox')
			->readonly(1)
		)
		->addControl(
			\Easy\Form\Combobox::make('achizitii::~layouts.form.controls.comboboxes.combobox')
			->name('id_tip_achizitie')
			->caption('Tip achizitie')
			->class('form-control data-source input-group form-select')
			->controlsource('id_tip_achizitie')
			->controltype('combobox')
			->options([])
		)
		->addControl(
			\Easy\Form\Combobox::make('achizitii::~layouts.form.controls.comboboxes.combobox')
			->name('id_modalitate_publicare')
			->caption('Modalitatea de publicare')
			->class('form-control data-source input-group form-select')
			->controlsource('id_modalitate_publicare')
			->controltype('combobox')
			->options([])
		)

		->addControl( 
			\Easy\Form\Textbox::make('achizitii::~layouts.form.controls.textboxes.textbox')
			->name('is_anunt_anterior_')
			->caption($c = 'Anunt intentie publicat anterior')
			->placeholder($c)
			->class('form-control')
			->readonly(1)
		)
		->addControl( 
			\Easy\Form\Textbox::make('achizitii::~layouts.form.controls.textboxes.textbox')
			->name('complexitate_')
			->caption($c = 'Complexitate')
			->placeholder($c)
			->class('form-control')
			->readonly(1)
		)
		->addControl( 
			\Easy\Form\Textbox::make('achizitii::~layouts.form.controls.textboxes.textbox')
			->name('zile_depunere_publicare_')
			->caption($c = 'Zile de la depunere la publicare')
			->placeholder($c)
			->class('form-control')
			->readonly(1)
		)

		->addControl( 
			\Easy\Form\Textbox::make('achizitii::~layouts.form.controls.textboxes.textbox')
			->name('denumire_obiect_contract')
			->caption($c = 'Denumire obiect contract')
			->placeholder($c)
			->class('form-control data-source')
			->controlsource('denumire_obiect_contract')
			->controltype('textbox')
		)
		->addControl( 
			\Easy\Form\Textbox::make('achizitii::~layouts.form.controls.textboxes.textbox')
			->name('descriere_obiect_contract')
			->caption($c = 'Descriere obiect contract')
			->placeholder($c)
			->class('form-control data-source')
			->controlsource('descriere_obiect_contract')
			->controltype('textbox')
		)->addControl( 
			\Easy\Form\Textbox::make('achizitii::~layouts.form.controls.textboxes.textbox')
			->name('mod_obtinere_documentatie_atribuire')
			->caption($c = 'Modul de obtinere a documentatiei de atribuire')
			->placeholder($c)
			->class('form-control data-source')
			->controlsource('mod_obtinere_documentatie_atribuire')
			->controltype('textbox')
		)
		->addControl(
			\Easy\Form\Combobox::make('achizitii::~layouts.form.controls.comboboxes.combobox')
			->name('stadiu_procedura')
			->caption('Stadiu procedura')
			->class('form-control data-source input-group form-select')
			->controlsource('stadiu_procedura')
			->controltype('combobox')
			->options(['-' => ' --- Selectati stadiu procedura ---', 'atribuita' => 'Atribuita', 'in-desfasurare' => 'In desfasurare'])
		)
		->addControl(
			\Easy\Form\Combobox::make('achizitii::~layouts.form.controls.comboboxes.combobox')
			->name('is_pf_mai_mare_50')
			->caption('P.F mai mare de 50%')
			->class('form-control data-source input-group form-select')
			->controlsource('is_pf_mai_mare_50')
			->controltype('combobox')
			->options([-1 => ' --- Selectati ---', 0 => 'Nu', 1 => 'Da'])
		)

		;
	}
}