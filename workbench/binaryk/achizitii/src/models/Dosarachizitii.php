<?php namespace Binaryk\Models\Nomenclator; 

class Dosarachizitii extends \Eloquent 
{ 
	protected $table = 'ach_dosare_achizitii';
	protected $fillable = ['*'];

	protected static $mod_solicitare = [
		'obligatoriu' => 'Obligatoriu',
		'optional'    => 'Optional',
	];

	protected static $mod_predare = [
		'copie'            => 'Copie',
		'original'         => 'Original',
		'copie-legalizata' => 'Copie legalizata'
	];

	protected static $rules = [
		'document_necesar'         => 'required',
		'numar_ordine'             => 'required|integer',
		'id_clasificare_documente' => 'exists:ach_clasificare_documente,id',
		'mod_solicitare'           => 'not_in:0',
		'mod_predare'              => 'not_in:0'
	];

	protected static $messages = [
		'document_necesar.required' 		=> 'Documentul necesar este obligatoriu.',
		'numar_ordine.required'     		=> 'Numarul de ordine este obligatoriu',
		'numar_ordine.integer'      		=> 'Numarul de ordine trebuie sa fie un numar intreg',	
		'id_clasificare_documente.exists'   => 'Selectarea clasificare documente este obligatorie',
		'mod_solicitare.not_in'             => 'Selectarea modulului de solicitare este obligatorie',
		'mod_predare.not_in'                => 'Selectarea modulului de predare este obligatorie'
	];

	public static function getModSolicitare()
	{
		return self::$mod_solicitare;
	}

	public static function getModPredare()
	{
		return self::$mod_predare;
	}

	public static function getRules()
	{
		return self::$rules;
	}

	public static function getMessages()
	{
		return self::$messages;
	}

	public static function getDocumenteNecesare($id_template_achizitii, $tip_dosar)
	{
		return self::where('id_template_achizitii', $id_template_achizitii)->where('tip_dosar', $tip_dosar)->orderBy('numar_ordine')->get();
	}
}