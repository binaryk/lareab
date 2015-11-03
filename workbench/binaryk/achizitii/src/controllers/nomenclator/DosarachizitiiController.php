<?php namespace Binaryk\Controllers\Nomenclator; 

class DosarachizitiiController extends \BaseController
{

	public function index( $id_template_achizitii )
	{
		$template_achizitii = \Binaryk\Models\Nomenclator\Template::find( (int) $id_template_achizitii); 
		if( is_null($template_achizitii) )
		{
			return \Redirect::route('nomenclator-template-achizitii', ['id' => 'template-achizitii']);
		}
		return \View::make('achizitii::nomenclator.dosare_achizitii.index')->with([
			'template_achizitii'  => $template_achizitii,
			'documente_achizitor' => \Binaryk\Models\Nomenclator\Dosarachizitii::getDocumenteNecesare( (int) $id_template_achizitii, 'achizitor'),
			'documente_ofertant'  => \Binaryk\Models\Nomenclator\Dosarachizitii::getDocumenteNecesare( (int) $id_template_achizitii, 'ofertant'),
			'clasificare_documente' => \Binaryk\Models\Nomenclator\ClasificareDocumente::orderBy('id')->get(),
			'mod_solicitare'        => \Binaryk\Models\Nomenclator\Dosarachizitii::getModSolicitare(),
			'mod_predare'           => \Binaryk\Models\Nomenclator\Dosarachizitii::getModPredare(),
		]);

	}

	public function insert()
	{
		$rules     = \Binaryk\Models\Nomenclator\Dosarachizitii::getRules();
		$messages  = \Binaryk\Models\Nomenclator\Dosarachizitii::getMessages();
		$validator = \Validator::make( $data = \Input::all(), $rules, $messages);
		if ($validator->fails())
        {
        	return \Response::json([
		    	'success'         => false, 
		    	'validation-fail' => true, 
		    	'messages'        => $validator->messages()
		    ]);
        }
        try
        {
        	\Binaryk\Models\Nomenclator\Dosarachizitii::unguard();
        	$record = \Binaryk\Models\Nomenclator\Dosarachizitii::create($data);
        	return \Response::json([
		    	'success'         => true, 
		    	'validation-fail' => false, 
		    	'messages'        => ['Create. OK'],
		    	'id'              => $record->id
		    ]);
        }
        catch(\Exception $e)
        {
           	return \Response::json([
		    	'success'         => false, 
		    	'validation-fail' => false, 
		    	'messages'        => [$e->getMessage()],
		    ]);
        }
	}

	public function update()
	{
		$rules     = \Binaryk\Models\Nomenclator\Dosarachizitii::getRules();
		$messages  = \Binaryk\Models\Nomenclator\Dosarachizitii::getMessages();
		$validator = \Validator::make( $data = \Input::all(), $rules, $messages);
		if ($validator->fails())
        {
        	return \Response::json([
		    	'success'         => false, 
		    	'validation-fail' => true, 
		    	'messages'        => $validator->messages()
		    ]);
        }
        try
        {
        	$record = \Binaryk\Models\Nomenclator\Dosarachizitii::find( (int) $data['id']);
        	\Binaryk\Models\Nomenclator\Dosarachizitii::unguard();
        	$record->update($data);
        	return \Response::json([
		    	'success'         => true, 
		    	'validation-fail' => false, 
		    	'messages'        => ['Update. OK'],
		    	'id'              => $record->id
		    ]);
        }
        catch(\Exception $e)
        {
           	return \Response::json([
		    	'success'         => false, 
		    	'validation-fail' => false, 
		    	'messages'        => [$e->getMessage()],
		    ]);
        }
	}

	public function delete()
	{
        try
        {
        	$record = \Binaryk\Models\Nomenclator\Dosarachizitii::find( (int) \Input::get('id') );
        	$record->delete();
        	return \Response::json([
		    	'success'         => true, 
		    	'validation-fail' => false, 
		    	'messages'        => ['Delete. OK'],
		    	'id'              => $record->id
		    ]);
        }
        catch(\Exception $e)
        {
           	return \Response::json([
		    	'success'         => false, 
		    	'validation-fail' => false, 
		    	'messages'        => [$e->getMessage()],
		    ]);
        }
	}
}