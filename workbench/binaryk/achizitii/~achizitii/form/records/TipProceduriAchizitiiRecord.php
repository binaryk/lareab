<?php 
namespace Binaryk\Achizitii\Form; 

class TipProceduriAchizitiiRecord extends \Binaryk\Models\Sys\FormsRecord
{

	public function __construct($id)
	{
		parent::__construct($id);
		$this
		->setCaption('insert', 'Adăugare tip procedură achiziție')
		->setCaption('update', 'Modificare tip procedură achiziție (#:id:)')
		->setCaption('delete', 'Ştergere tip procedură achiziție (#:id:)')

		->setFeedback('insert', 'success', 'Adăugarea procedurii de achiziție a fost realizată cu succes.')
		->setFeedback('insert', 'error', 'Adaugarea procedurii de achiziție <span class="badge">nu</span> a fost realizată.')
		->setFeedback('update', 'success', 'Modificarea procedurii de achiziție a fost realizată cu succes.')
		->setFeedback('update', 'error', 'Modificarea procedurii de achiziție <span class="badge">nu</span> a fost realizată.')
		->setFeedback('delete', 'success', 'Ştergerea procedurii de achiziție a fost realizată cu succes.')
		->setFeedback('delete', 'error', 'Ştergerea procedurii de achiziție <span class="badge">nu</span> a fost realizată.')
		;
	}

    public static function create()
	{
		return self::$instance = new TipProceduriAchizitiiRecord('proceduri-achizitii');
	}
	
}