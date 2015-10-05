<?php
namespace Binaryk\Models\Nomenclator; 

class ModalitatiPublicare extends \Eloquent { 

	protected $table = 'ach_modalitati_publicare';

	protected $fillable = ['nume', 'id_tip_anunt', 'anunt_anterior', 'tip_complexitate', 'zile_dp'];

    protected static $anterior     = [ '1' => 'Nu', '2' => 'Da' ];
    protected static $complexitate = [ '1' => 'Redus', '2' => 'Normal/Mare' ];
    protected static $zile = [ '1' => '4', '2' => '6','3' => '10', '4' => '36','5' => '52' ];


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
        return [0 => ' -- Selectaţi un anunț --'] + self::orderBy('id')->lists('nume', 'id');
    }

    public static function anterior()
    {
        return [0 => ' -- Selectaţi --'] + self::$anterior;
    }

    public static function complexitate()
    {
        return [0 => ' -- Selectaţi --'] + self::$complexitate;
    }

    public static function zile()
    {
        return [0 => ' -- Selectaţi --'] + self::$zile;
    }

    public function procedura(){
        return $this->belongsTo('Binaryk\Models\Nomenclator\TipProceduriAchizitii','id_tip_procedura');
    } 

} 