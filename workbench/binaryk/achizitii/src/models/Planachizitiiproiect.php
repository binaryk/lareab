<?php namespace Binaryk\Models\Nomenclator; 

class Planachizitiiproiect extends \Eloquent 
{ 
	protected $table = 'ach_plan_achizitii_proiecte';
	protected $fillable = ['*'];

	public static function getRecord( $id )
    {
        return self::find($id);
    }

    protected static function prepareData($data)
    {
        return $data;
    }

    public static function createRecord($data)
    {
        $data = self::prepareData($data);
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