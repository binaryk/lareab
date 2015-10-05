<?php 
namespace Binaryk\Achizitii\Form; 

class ClasificareDocumenteRecord extends \Binaryk\Models\Sys\FormsRecord
{

	public function __construct($id)
	{
		parent::__construct($id);
		$this
		->setCaption('insert', 'Adăugare tip document')
		->setCaption('update', 'Modificare tip document (#:id:)')
		->setCaption('delete', 'Ştergere tip document (#:id:)')

		->setFeedback('insert', 'success', 'Adăugarea tipului de document a fost realizată cu succes.')
		->setFeedback('insert', 'error', 'Adaugarea tipului de document <span class="badge">nu</span> a fost realizată.')
		->setFeedback('update', 'success', 'Modificarea tipului de document a fost realizată cu succes.')
		->setFeedback('update', 'error', 'Modificarea tipului de document <span class="badge">nu</span> a fost realizată.')
		->setFeedback('delete', 'success', 'Ştergerea tipului de document a fost realizată cu succes.')
		->setFeedback('delete', 'error', 'Ştergerea tipului de document <span class="badge">nu</span> a fost realizată.')
		;
	}

    public static function create()
	{
		return self::$instance = new ClasificareDocumenteRecord('clasificare-documente');
	}
	
}