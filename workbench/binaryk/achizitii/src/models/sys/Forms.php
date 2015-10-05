<?php

namespace Binaryk\Models\Sys;

class Forms
{

	protected static $instance = NULL;
	protected $forms =[];

	protected $maps = [
		'tip-achizitii'        	 	   => '\Binaryk\Achizitii\Form\TipAchizitiiRecord',
		'proceduri-achizitii'          => '\Binaryk\Achizitii\Form\TipProceduriAchizitiiRecord',
		'clasificare-documente'        => '\Binaryk\Achizitii\Form\ClasificareDocumenteRecord',
		'template-achizitii'           => '\Binaryk\Achizitii\Form\TemplateAchizitiiRecord',
		'tip-anunt' 			       => '\Binaryk\Achizitii\Form\TipAnuntRecord',
		'modalitati-publicare'	       => '\Binaryk\Achizitii\Form\ModalitatiPublicareRecord',
	];

	public function __construct($id)
	{
		$this->addForm( call_user_func([$this->maps[$id], 'create']));
	}

	protected function addForm( FormsRecord $form)
	{
		$this->forms[$form->id] = $form;
		return $this;
	}

	public static function make($id)
	{
		return self::$instance = new Forms($id);
	} 

	public function toFormConfig($id)
	{
		$record = $this->forms[$id];
		$result = new \StdClass();
		$result->captions = $record->captions(); 
		$result->buttons = $record->buttons(); 
		return $result;
	}

	public function toActionConfig($id)
	{
		$record = $this->forms[$id];
		$result = new \StdClass();
		$result->feedback = $record->feedback(); 
		$result->rules    = $record->rules();
		$result->messages = $record->messages();
		return $result;
	}

}