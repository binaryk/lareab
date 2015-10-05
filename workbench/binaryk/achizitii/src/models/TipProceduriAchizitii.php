<?php
namespace Binaryk\Models\Nomenclator; 

class TipProceduriAchizitii extends \Eloquent { 

	protected $table = 'ach_tip_proceduri_achizitii';

	protected $fillable = ['nume', 'tip_achizitor'];

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

    public static function toCombobox($tip_achizitor, $field = 'nume')
    {
        return [0 => ' -- Selectaţi un tip de procedură --'] + self::where('tip_achizitor',$tip_achizitor)->orderBy('id')->lists($field, 'id');
    }

    public function tipAchizitor(){
        return $this->belongsTo('Binaryk\Models\Nomenclator\Tip', 'tip_achizitor');
    }

    public static function anunturi(){
         return $this->hasMany('Binaryk\Models\Nomenclator\TipAnunturi','id_tip_procedura');
     }  

}
