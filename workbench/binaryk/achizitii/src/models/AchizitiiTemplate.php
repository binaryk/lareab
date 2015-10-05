<?php
namespace Binaryk\Models\Nomenclator; 
class AchizitiiTemplate extends \Eloquent { 

	protected $table = 'ach_tip_achzitii_template';
	protected $fillable = ['id_tip_achizitie','id_template'];

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
}