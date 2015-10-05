<?php 
namespace Binaryk\Achizitii\Form; 

class TipAchizitiiRecord extends \Binaryk\Models\Sys\FormsRecord
{

	public function __construct($id)
	{
		parent::__construct($id);
		$this
		->setCaption('insert', 'Adăugare tip achiziție')
		->setCaption('update', 'Modificare tip achiziție (#:id:)')
		->setCaption('delete', 'Ştergere tip achiziție (#:id:)')

		->setFeedback('insert', 'success', 'Adăugarea tipului achiziție a fost realizată cu succes.')
		->setFeedback('insert', 'error', 'Adaugarea tipului achiziție <span class="badge">nu</span> a fost realizată.')
		->setFeedback('update', 'success', 'Modificarea tipului achiziție a fost realizată cu succes.')
		->setFeedback('update', 'error', 'Modificarea tipului achiziție <span class="badge">nu</span> a fost realizată.')
		->setFeedback('delete', 'success', 'Ştergerea tipului achiziție a fost realizată cu succes.')
		->setFeedback('delete', 'error', 'Ştergerea tipului achiziție <span class="badge">nu</span> a fost realizată.')
		;
	}

    public static function create()
	{
		return self::$instance = new TipAchizitiiRecord('tip-achizitii');
	}
	
}