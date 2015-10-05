<?php namespace Binaryk\Achizitii\Form; 

class TemplateAchizitiiRecord extends \Binaryk\Models\Sys\FormsRecord
{

	public function __construct($id)
	{
		parent::__construct($id);
		$this
		->setCaption('insert', 'Adăugare template')
		->setCaption('update', 'Modificare template (#:id:)')
		->setCaption('delete', 'Ştergere template (#:id:)')

		->setFeedback('insert', 'success', 'Adăugarea template-ului a fost realizată cu succes.')
		->setFeedback('insert', 'error', 'Adaugarea template-ului <span class="badge">nu</span> a fost realizată.')
		->setFeedback('update', 'success', 'Modificarea template-ului a fost realizată cu succes.')
		->setFeedback('update', 'error', 'Modificarea template-ului <span class="badge">nu</span> a fost realizată.')
		->setFeedback('delete', 'success', 'Ştergerea template-ului a fost realizată cu succes.')
		->setFeedback('delete', 'error', 'Ştergerea template-ului <span class="badge">nu</span> a fost realizată.')
		;
	}

    public static function create()
	{
		return self::$instance = new TemplateAchizitiiRecord('template-achizitii');
	}
	
}