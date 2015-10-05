<?php
namespace Binaryk\Models\Nomenclator; 

class Tip extends \Eloquent { 

	protected $table = 'ach_tipuri';

	protected $fillable = ['nume', 'id_categorie'];

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
        return [0 => ' -- Selectaţi tip --'] + self::orderBy('id')->lists('nume', 'id');
    }

    public function categorie(){
        return $this->belongsTo('Binaryk\Models\Nomenclator\CategorieTip','id_categorie');
    }

    public static function achizitori(){
        return [0 => ' -- Selectaţi tip achizitor --'] + self::orderBy('id')->where('id_categorie',\Config::get('achizitii::types.achizitor'))->lists('nume', 'id');
    }  

    public static function tipDaNu(){
        return [0 => ' -- Selectaţi --'] + self::orderBy('id')->where('id_categorie',\Config::get('achizitii::types.danu'))->lists('nume', 'id');
    }

    public static function contract(){
        return [0 => ' -- Selectaţi --'] + self::orderBy('id')->where('id_categorie',\Config::get('achizitii::types.contract'))->lists('nume', 'id');
    }

    public static function tip_achizitii(){
        return [0 => ' -- Selectaţi --'] + self::orderBy('id')->where('id_categorie',\Config::get('achizitii::types.tip_achizitii'))->lists('nume', 'id');
    }

}
