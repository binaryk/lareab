<?php 
namespace Binaryk\Achizitii\Form; 

class ModalitatiPublicareRecord extends \Binaryk\Models\Sys\FormsRecord
{

	public function __construct($id)
	{
		parent::__construct($id);
		$this
		->setCaption('insert', 'Adăugare modalitate publicare achiziție')
		->setCaption('update', 'Modificare modalitate publicare achiziție (#:id:)')
		->setCaption('delete', 'Ştergere modalitate publicare achiziție (#:id:)')

		->setFeedback('insert', 'success', 'Adăugarea modalității de publicare a fost realizată cu succes.')
		->setFeedback('insert', 'error', 'Adaugarea modalității de publicare <span class="badge">nu</span> a fost realizată.')
		->setFeedback('update', 'success', 'Modificarea modalității de publicare a fost realizată cu succes.')
		->setFeedback('update', 'error', 'Modificarea modalității de publicare <span class="badge">nu</span> a fost realizată.')
		->setFeedback('delete', 'success', 'Ştergerea modalității de publicare a fost realizată cu succes.')
		->setFeedback('delete', 'error', 'Ştergerea modalității de publicare <span class="badge">nu</span> a fost realizată.')
		;
	}

    public static function create()
	{
		return self::$instance = new ModalitatiPublicareRecord('modalitati-publicare');
	}
	
}