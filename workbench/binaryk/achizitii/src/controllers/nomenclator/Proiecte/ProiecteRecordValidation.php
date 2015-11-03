<?php namespace Binaryk\Achizitii\Form; 

class ProiecteRecordValidation extends \Binaryk\Models\Sys\FormsRecord
{

	public function __construct($id)
	{
		parent::__construct($id);
		$this
		->setCaption('insert', 'Adăugare proiect')
		->setCaption('update', 'Modificare proiect (#:id:)')
		->setCaption('delete', 'Ştergere proiect (#:id:)')

		->setFeedback('insert', 'success', 'Adăugarea proiectului a fost realizată cu succes.')
		->setFeedback('insert', 'error', 'Adaugarea proiectului <span class="badge">nu</span> a fost realizată.')
		
		->setFeedback('update', 'success', 'Modificarea proiectului a fost realizată cu succes.')
		->setFeedback('update', 'error', 'Modificarea proiectului <span class="badge">nu</span> a fost realizată.')
		
		->setFeedback('delete', 'success', 'Ştergerea proiectului a fost realizată cu succes.')
		->setFeedback('delete', 'error', 'Ştergerea proiectului <span class="badge">nu</span> a fost realizată.')

		->addRule('insert', 'titlu', 'required')
		->addRule('insert', 'tip_achizitor', 'not_in:-')

		->addMessage('insert', 'titlu.required', 'Va rugam sa completati titlul proiectului.')
		->addMessage('insert', 'tip_achizitor.not_in', 'Va rugam sa selectati tipul de achizitor')

		->addRule('update', 'titlu', 'required')
		->addRule('update', 'tip_achizitor', 'not_in:-')

		->addMessage('update', 'titlu.required', 'Va rugam sa completati titlul proiectului.')
		->addMessage('update', 'tip_achizitor.not_in', 'Va rugam sa selectati tipul de achizitor')
		;
	}

    public static function create()
	{
		return self::$instance = new ProiecteRecordValidation('lista-proiecte');
	}
	
}