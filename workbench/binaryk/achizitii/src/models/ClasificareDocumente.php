<?php
namespace Binaryk\Models\Nomenclator; 

class ClasificareDocumente extends \Eloquent { 

	protected $table = 'ach_clasificare_documente';

	protected $fillable = ['nume'];

    public static function getRecord( $id )
    {
        return self::find($id);
    }

    public static function createRecord($data )
    {
        return self::create($data);
    }

    public static function updateRecord($id, $data)
    {
        $record = self::find($id);
        if( ! $record )
        {
            return false;
        }
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

    public static function toCombobox()
    {
        return [0 => ' -- Selectaţi document --'] + self::orderBy('id')->lists('nume', 'id');
    }  

}
