<?php 
namespace Binaryk\Achizitii\Form; 

class TipAnuntRecord extends \Binaryk\Models\Sys\FormsRecord
{

	public function __construct($id)
	{
		parent::__construct($id);
		$this
		->setCaption('insert', 'Adăugare tip anunț achiziție')
		->setCaption('update', 'Modificare tip anunț achiziție (#:id:)')
		->setCaption('delete', 'Ştergere tip anunț achiziție (#:id:)')

		->setFeedback('insert', 'success', 'Adăugarea tipului a fost realizată cu succes.')
		->setFeedback('insert', 'error', 'Adaugarea tipului <span class="badge">nu</span> a fost realizată.')
		->setFeedback('update', 'success', 'Modificarea tipului a fost realizată cu succes.')
		->setFeedback('update', 'error', 'Modificarea tipului <span class="badge">nu</span> a fost realizată.')
		->setFeedback('delete', 'success', 'Ştergerea tipului a fost realizată cu succes.')
		->setFeedback('delete', 'error', 'Ştergerea tipului <span class="badge">nu</span> a fost realizată.')
		;
	}

    public static function create()
	{
		return self::$instance = new TipAnuntRecord('tip-anunt');
	}
	
}