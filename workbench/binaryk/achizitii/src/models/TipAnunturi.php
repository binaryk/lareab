<?php namespace Binaryk\Models\Nomenclator; 

class TipAnunturi extends \Eloquent 
{ 

	protected $table = 'ach_tip_anunturi';
	protected $fillable = ['nume', 'id_tip_procedura'];

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

    public static function toPopulateCombobox( $id_tip_procedura )
    {
        $data = [0 => ' -- Selectaţi un tip de anunț --'] + self::where('id_tip_procedura', $id_tip_procedura)->orderBy('id')->lists('nume', 'id');
        $result = [];
        foreach($data as $id => $option)
        {
            $result[] = ['id' => $id, 'text' => $option];
        }
        return $result;
        // return [0 => ' -- Selectaţi un anunț --'] + self::where('id_tip_procedura', $id_tip_procedura)->orderBy('id')->lists('nume', 'id');
    }


    public function procedura(){
        return $this->belongsTo('Binaryk\Models\Nomenclator\TipProceduriAchizitii','id_tip_procedura');
    } 

}
