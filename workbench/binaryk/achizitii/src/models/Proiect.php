<?php namespace Binaryk\Models\Nomenclator; 

class Proiect extends \Eloquent 
{ 
	protected $table = 'ach_proiecte';
	protected $fillable = ['*'];

	public static function getRecord( $id )
    {
        return self::find($id);
    }

    public static function createRecord($data )
    {
    	self::unguard();
        return self::create($data);
    }

    public static function updateRecord($id, $data)
    {
        $record = self::find($id);
        if( ! $record )
        {
            return false;
        }
        self::unguard();
        return $record->update($data);
    }

    public static function deleteRecord($id, $data)
    {
        $record = self::find($id);
        if( ! $record )
        {
            return false;
        }
        return $record->delete();
    }

}