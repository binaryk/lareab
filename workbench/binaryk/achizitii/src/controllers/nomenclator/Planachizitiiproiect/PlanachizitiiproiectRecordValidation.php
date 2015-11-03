<?php namespace Binaryk\Achizitii\Form; 

class PlanachizitiiproiectRecordValidation extends \Binaryk\Models\Sys\FormsRecord
{

	public function __construct($id)
	{
		parent::__construct($id);
		$this
		->setCaption('insert', 'Adăugare plan achizitii')
		->setCaption('update', 'Modificare plan achizitii (#:id:)')
		->setCaption('delete', 'Ştergere plan achizitii (#:id:)')

		->setFeedback('insert', 'success', 'Adăugare plan achizitii a fost realizată cu succes.')
		->setFeedback('insert', 'error', 'Adaugare plan achizitii <span class="badge">nu</span> a fost realizată.')
		
		->setFeedback('update', 'success', 'Modificare plan achizitii a fost realizată cu succes.')
		->setFeedback('update', 'error', 'Modificare plan achizitii <span class="badge">nu</span> a fost realizată.')
		
		->setFeedback('delete', 'success', 'Ştergere plan achizitii a fost realizată cu succes.')
		->setFeedback('delete', 'error', 'Ştergere plan achizitii <span class="badge">nu</span> a fost realizată.')

		->addRule('insert', 'tip_contract', 'not_in:-')
		->addRule('insert', 'valoare_estimata_eur_fara_tva', 'required|numeric|min:0.01')
		->addRule('insert', 'data_curs', 'required|date')
		->addRule('insert', 'curs_valutar', 'required|numeric|min:0.01')
		->addRule('insert', 'valoare_estimata_ron_fara_tva', 'required|numeric|min:0.01')
		->addRule('insert', 'id_tip_achizitie', 'required|not_in:0')
		->addRule('insert', 'id_modalitate_publicare', 'required|not_in:0')


		
		->addMessage('insert', 'tip_contract.not_in', 'Va rugam sa selectati tipul de contract')
		->addMessage('insert', 'valoare_estimata_eur_fara_tva.required', 'Valoare este obligatorie')
		->addMessage('insert', 'valoare_estimata_eur_fara_tva.numeric', 'Valoare este obligatorie')
		->addMessage('insert', 'valoare_estimata_eur_fara_tva.min', 'Valoare este obligatorie')
		->addMessage('insert', 'data_curs.required', 'Data curs este obligatorie')
		->addMessage('insert', 'data_curs.date', 'Data curs este obligatorie')
		->addMessage('insert', 'curs_valutar.required', 'Valoare este obligatorie')
		->addMessage('insert', 'curs_valutar.numeric', 'Valoare este obligatorie')
		->addMessage('insert', 'curs_valutar.min', 'Valoare este obligatorie')
		->addMessage('insert', 'valoare_estimata_ron_fara_tva.required', 'Valoare este obligatorie')
		->addMessage('insert', 'valoare_estimata_ron_fara_tva.numeric', 'Valoare este obligatorie')
		->addMessage('insert', 'valoare_estimata_ron_fara_tva.min', 'Valoare este obligatorie')
		->addMessage('insert', 'id_tip_achizitie.required', 'Va rugam sa selectati tipul de achizitie')
		->addMessage('insert', 'id_tip_achizitie.not_in', 'Va rugam sa selectati tipul de achizitie')
		->addMessage('insert', 'id_modalitate_publicare.required', 'Va rugam sa selectati modalitate de publicare')
		->addMessage('insert', 'id_modalitate_publicare.not_in', 'Va rugam sa selectati modalitate de publicare')
		// ->addRule('update', 'titlu', 'required')
		// ->addRule('update', 'tip_achizitor', 'not_in:-')

		// ->addMessage('update', 'titlu.required', 'Va rugam sa completati titlul proiectului.')
		// ->addMessage('update', 'tip_achizitor.not_in', 'Va rugam sa selectati tipul de achizitor')
		;
	}

    public static function create()
	{
		return self::$instance = new PlanachizitiiproiectRecordValidation('plan-achizitii-proiect');
	}
	
}